<?php

namespace App\Http\Controllers;

use App\Models\OrganizationUnit;
use App\Models\UgBatch;
use App\Models\UgRegistration;
use App\Models\UgMasterStudent;
use App\Models\GradStudent;
use App\Models\PublicRegistration;
use App\Models\PublicEvent;
use App\Models\NewsArticle;
use App\Models\User;
use App\Models\SiteSetting;
use App\Models\ContactInquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function showLogin()
    {
        if (Session::has('admin_user')) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');

        $user = DB::table('users')->where('username', $username)->first();

        if ($user && password_verify($password, $user->password_hash)) {
            Session::put('admin_user', [
                'id' => $user->id,
                'username' => $user->username,
                'name' => $user->full_name,
                'role' => $user->role,
                'org_unit_id' => $user->org_unit_id,
            ]);
            return redirect()->route('admin.dashboard');
        }

        return back()->with('error', 'ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง');
    }

    public function logout()
    {
        Session::forget('admin_user');
        return redirect()->route('login');
    }

    public function dashboard()
    {
        $this->checkAuth();
        $admin = Session::get('admin_user');

        $isCentralOrSuper = in_array($admin['role'], ['SUPER_ADMIN', 'CENTRAL_OFFICER']);

        $totalOrgs = OrganizationUnit::where('is_active', 1)->count();
        
        $totalUGQuery = UgRegistration::query();
        $totalGradQuery = GradStudent::query();
        $totalPublicQuery = PublicRegistration::query();

        if (!$isCentralOrSuper && !empty($admin['org_unit_id'])) {
            $totalUGQuery->where('org_unit_id', $admin['org_unit_id']);
            $totalGradQuery->where('org_unit_id', $admin['org_unit_id']);
        }

        $totalUG = $totalUGQuery->count();
        $totalGrad = $totalGradQuery->count();
        $totalPublic = $totalPublicQuery->count();

        // สถิติจำนวนผู้เข้าร่วมปฏิบัติวิปัสสนากรรมฐานแยกตามหน่วยงาน/ส่วนงาน (สำหรับแผนภูมิกราฟแท่ง)
        $campusChartData = OrganizationUnit::where('is_active', 1)
            ->get()
            ->map(function ($org) {
                $ug = UgRegistration::where('org_unit_id', $org->id)->count();
                $grad = GradStudent::where('org_unit_id', $org->id)->count();
                $public = PublicRegistration::whereHas('event', function ($q) use ($org) {
                    $q->where('org_unit_id', $org->id);
                })->count();
                $total = $ug + $grad + $public;

                return [
                    'id' => $org->id,
                    'name' => $org->name_th,
                    'short_name' => str_replace(['วิทยาเขต', 'วิทยาลัยสงฆ์'], ['วข.', 'วส.'], $org->name_th),
                    'code' => $org->province_code ?? $org->code,
                    'type' => $org->type,
                    'ug' => $ug,
                    'grad' => $grad,
                    'public' => $public,
                    'total' => $total,
                ];
            })
            ->filter(function ($item) {
                return $item['total'] > 0;
            })
            ->sortByDesc('total')
            ->values();

        return view('admin.dashboard', compact('totalOrgs', 'totalUG', 'totalGrad', 'totalPublic', 'campusChartData'));
    }

    // Module 1: จัดการรอบผลัด/ปฏิทินปฏิบัติธรรม (Batches & Schedules)
    public function ugBatches(Request $request)
    {
        $this->checkAuth();
        $admin = Session::get('admin_user');
        $isCentralOrSuper = in_array($admin['role'], ['SUPER_ADMIN', 'CENTRAL_OFFICER']);

        $query = UgBatch::with(['organizationUnit', 'registrations'])->orderBy('start_date', 'desc');

        // สิทธิ์การเข้าถึง: ถ้าเป็นเจ้าหน้าที่วิทยาเขต (CAMPUS_ADMIN) จะเห็นเฉพาะรอบของวิทยาเขตตนเอง
        // ถ้าเป็นเจ้าหน้าที่ส่วนกลาง (CENTRAL_OFFICER) หรือ Super Admin จะตรวจสอบได้ครบทุก 52 ส่วนงาน
        if (!$isCentralOrSuper && !empty($admin['org_unit_id'])) {
            $query->where('org_unit_id', $admin['org_unit_id']);
        } elseif ($request->filled('filter_org')) {
            $query->where('org_unit_id', $request->input('filter_org'));
        }

        $perPage = $this->getPerPage($request);
        $batches = $query->paginate($perPage)->withQueryString();
        $orgUnits = OrganizationUnit::where('is_active', 1)->orderBy('id', 'asc')->get();

        return view('admin.ug_batches', compact('batches', 'orgUnits', 'isCentralOrSuper'));
    }

    public function ugBatchStore(Request $request)
    {
        $this->checkAuth();
        $admin = Session::get('admin_user');
        $isCentralOrSuper = in_array($admin['role'], ['SUPER_ADMIN', 'CENTRAL_OFFICER']);

        $validated = $request->validate([
            'academic_year' => 'required|integer',
            'batch_no' => 'nullable|integer',
            'title' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'max_quota' => 'required|integer|min:1',
            'status' => 'required|in:OPEN,CLOSED,IN_PROGRESS,COMPLETED',
            'org_unit_id' => 'nullable|integer',
        ]);

        // กำหนดส่วนงานเจ้าของโครงการ:
        // หากเป็น CAMPUS_ADMIN จะล็อกให้อยู่ใน org_unit_id ของตนเองเสมอ
        $org_id = $isCentralOrSuper && !empty($validated['org_unit_id'])
            ? $validated['org_unit_id']
            : ($admin['org_unit_id'] ?? 1);

        UgBatch::create([
            'org_unit_id' => $org_id,
            'academic_year' => $validated['academic_year'],
            'batch_no' => $validated['batch_no'] ?? 1,
            'title' => $validated['title'],
            'location' => $validated['location'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'max_quota' => $validated['max_quota'],
            'status' => $validated['status'],
        ]);

        return back()->with('success', 'บันทึกกำหนดการปฏิบัติวิปัสสนากรรมฐาน ประจำปีการศึกษา ' . $validated['academic_year'] . ' สำเร็จเรียบร้อยแล้ว');
    }

    public function ugBatchUpdate(Request $request, $id)
    {
        $this->checkAuth();
        $admin = Session::get('admin_user');
        $isCentralOrSuper = in_array($admin['role'], ['SUPER_ADMIN', 'CENTRAL_OFFICER']);

        $batch = UgBatch::findOrFail($id);

        // ตรวจสอบสิทธิ์: อนุญาตเฉพาะ Super Admin, เจ้าหน้าที่ส่วนกลาง (Central Officer) หรือ เจ้าหน้าที่วิทยาเขตที่เป็นเจ้าของส่วนงานโครงการ
        if (!$isCentralOrSuper && $batch->org_unit_id != $admin['org_unit_id']) {
            return back()->with('error', 'ท่านไม่มีสิทธิ์แก้ไขข้อมูลโครงการของส่วนงานอื่น');
        }

        $validated = $request->validate([
            'academic_year' => 'required|integer',
            'title' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'max_quota' => 'required|integer|min:1',
            'status' => 'required|in:OPEN,CLOSED,IN_PROGRESS,COMPLETED',
            'org_unit_id' => 'nullable|integer',
        ]);

        $updateData = [
            'academic_year' => $validated['academic_year'],
            'title' => $validated['title'],
            'location' => $validated['location'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'max_quota' => $validated['max_quota'],
            'status' => $validated['status'],
        ];

        // อนุญาตให้แก้ไขส่วนงานเจ้าของโครงการเฉพาะ Central / Super Admin
        if ($isCentralOrSuper && !empty($validated['org_unit_id'])) {
            $updateData['org_unit_id'] = $validated['org_unit_id'];
        }

        $batch->update($updateData);

        return back()->with('success', 'แก้ไขข้อมูลกำหนดการโครงการ ' . $batch->title . ' สำเร็จเรียบร้อยแล้ว');
    }

    public function ugBatchStatus($id, $status)
    {
        $this->checkAuth();
        $admin = Session::get('admin_user');
        $isCentralOrSuper = in_array($admin['role'], ['SUPER_ADMIN', 'CENTRAL_OFFICER']);

        $batch = UgBatch::findOrFail($id);

        // Security Scope Check: ตรวจสอบสิทธิ์เฉพาะส่วนงาน
        if (!$isCentralOrSuper && $batch->org_unit_id != $admin['org_unit_id']) {
            return back()->with('error', 'ท่านไม่มีสิทธิ์แก้ไขข้อมูลของส่วนงานอื่น');
        }

        if (in_array($status, ['OPEN', 'CLOSED', 'IN_PROGRESS', 'COMPLETED'])) {
            $batch->update(['status' => $status]);
            return back()->with('success', 'ปรับเปลี่ยนสถานะโครงการเป็น ' . $status . ' สำเร็จ');
        }

        return back();
    }

    public function ugBatchDelete($id)
    {
        $this->checkAuth();
        $admin = Session::get('admin_user');
        $isCentralOrSuper = in_array($admin['role'], ['SUPER_ADMIN', 'CENTRAL_OFFICER']);

        $batch = UgBatch::findOrFail($id);

        if (!$isCentralOrSuper && $batch->org_unit_id != $admin['org_unit_id']) {
            return back()->with('error', 'ท่านไม่มีสิทธิ์ลบข้อมูลของส่วนงานอื่น');
        }

        $batch->delete();
        return back()->with('success', 'ลบกำหนดการโครงการเรียบร้อยแล้ว');
    }

    public function ugImport(Request $request)
    {
        $this->checkAuth();
        $admin = Session::get('admin_user');
        $isCentralOrSuper = in_array($admin['role'], ['SUPER_ADMIN', 'CENTRAL_OFFICER']);

        $query = UgMasterStudent::with('organizationUnit')->orderBy('id', 'desc');

        if (!$isCentralOrSuper && !empty($admin['org_unit_id'])) {
            $query->where('org_unit_id', $admin['org_unit_id']);
        } elseif ($request->filled('filter_org')) {
            $query->where('org_unit_id', $request->input('filter_org'));
        }

        if ($request->filled('search')) {
            $s = trim($request->input('search'));
            $query->where(function ($q) use ($s) {
                $q->where('student_code', 'LIKE', "%{$s}%")
                  ->orWhere('first_name', 'LIKE', "%{$s}%")
                  ->orWhere('last_name', 'LIKE', "%{$s}%")
                  ->orWhere('chaya', 'LIKE', "%{$s}%")
                  ->orWhere('citizen_id', 'LIKE', "%{$s}%");
            });
        }

        $perPage = $this->getPerPage($request);
        $students = $query->paginate($perPage)->withQueryString();
        $orgUnits = OrganizationUnit::where('is_active', 1)->orderBy('id', 'asc')->get();
        $totalMasterCount = UgMasterStudent::count();

        return view('admin.ug_import', compact('students', 'orgUnits', 'totalMasterCount', 'isCentralOrSuper'));
    }

    public function ugImportCsv(Request $request)
    {
        $this->checkAuth();
        $admin = Session::get('admin_user');
        $isCentralOrSuper = in_array($admin['role'], ['SUPER_ADMIN', 'CENTRAL_OFFICER']);

        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt|max:10240',
            'default_org_unit_id' => 'nullable|integer',
        ]);

        $file = $request->file('csv_file');
        $path = $file->getRealPath();

        // โหลด map รายชื่อส่วนงานเพื่อใช้ค้นหาตามชื่อส่วนงานใน CSV
        $orgs = OrganizationUnit::all();
        $orgMap = [];
        foreach ($orgs as $org) {
            $orgMap[mb_strtolower(trim($org->name_th))] = $org->id;
            if ($org->code) {
                $orgMap[mb_strtolower(trim($org->code))] = $org->id;
            }
            if ($org->code_provincial) {
                $orgMap[mb_strtolower(trim($org->code_provincial))] = $org->id;
            }
        }

        $defaultOrgId = $isCentralOrSuper && $request->filled('default_org_unit_id')
            ? $request->input('default_org_unit_id')
            : ($admin['org_unit_id'] ?? 1);

        $handle = fopen($path, 'r');
        if (!$handle) {
            return back()->with('error', 'ไม่สามารถเปิดไฟล์ CSV ได้');
        }

        // ตรวจสอบ BOM (UTF-8 BOM)
        $bom = fread($handle, 3);
        if ($bom !== "\xEF\xBB\xBF") {
            rewind($handle);
        }

        $imported = 0;
        $updated = 0;
        $skipped = 0;
        $rowNumber = 0;

        while (($row = fgetcsv($handle, 2000, ",")) !== FALSE) {
            $rowNumber++;
            // ข้าม Header ถ้าแถวแรกมีคำว่า "รหัสนิสิต" หรือ "student_code"
            if ($rowNumber === 1 && (str_contains($row[0] ?? '', 'รหัส') || str_contains(strtolower($row[0] ?? ''), 'student'))) {
                continue;
            }

            // รองรับรูปแบบคอลัมน์:
            // 0: รหัสนิสิต (student_code)
            // 1: คำนำหน้าชื่อ (prefix)
            // 2: ชื่อ - นามสกุล (first_name, last_name) หรือ ชื่อ
            // 3: นามสกุล หรือ ฉายา (last_name / chaya)
            // 4: ฉายา (chaya) หรือ ระดับการศึกษา
            // 5: ระดับการศึกษา (degree_level)
            // 6: สาขาวิชา (major)
            // 7: คณะ (faculty)
            // 8: ส่วนจัดการศึกษา (org_unit)

            $studentCode = trim($row[0] ?? '');
            if (!$studentCode) {
                $skipped++;
                continue;
            }

            $prefix = trim($row[1] ?? 'พระ');
            $fullNameRaw = trim($row[2] ?? '');
            $col3 = trim($row[3] ?? '');
            $col4 = trim($row[4] ?? '');
            $col5 = trim($row[5] ?? 'ปริญญาตรี');
            $col6 = trim($row[6] ?? '');
            $col7 = trim($row[7] ?? '');
            $col8 = trim($row[8] ?? '');

            // แยกชื่อและนามสกุล/ฉายา
            $firstName = $fullNameRaw;
            $lastName = $col3;
            $chaya = $col4;

            // ถ้า col 2 มี space และ col 3 เป็นฉายา
            if (str_contains($fullNameRaw, ' ') && !$col3) {
                $parts = explode(' ', $fullNameRaw, 2);
                $firstName = trim($parts[0]);
                $lastName = trim($parts[1]);
            }

            $degreeLevel = $col5 ?: 'ปริญญาตรี';
            $major = $col6;
            $faculty = $col7;
            $orgName = $col8;

            // หา Org Unit ID
            $orgUnitId = $defaultOrgId;
            if ($orgName) {
                $cleanOrgName = mb_strtolower($orgName);
                if (isset($orgMap[$cleanOrgName])) {
                    $orgUnitId = $orgMap[$cleanOrgName];
                } else {
                    foreach ($orgMap as $key => $id) {
                        if (str_contains($key, $cleanOrgName) || str_contains($cleanOrgName, $key)) {
                            $orgUnitId = $id;
                            break;
                        }
                    }
                }
            }

            // ถ้าเจ้าหน้าที่ประจำวิทยาเขต ต้องล็อก org_unit_id ตามสิทธิ์ตนเอง
            if (!$isCentralOrSuper) {
                $orgUnitId = $admin['org_unit_id'];
            }

            $existing = UgMasterStudent::where('student_code', $studentCode)->first();

            $data = [
                'student_code' => $studentCode,
                'prefix' => $prefix,
                'first_name' => $firstName,
                'last_name' => $lastName,
                'chaya' => $chaya,
                'degree_level' => $degreeLevel,
                'major' => $major,
                'faculty' => $faculty,
                'org_unit_id' => $orgUnitId,
                'is_active' => 1,
            ];

            if ($existing) {
                $existing->update($data);
                $updated++;
            } else {
                UgMasterStudent::create($data);
                $imported++;
            }
        }

        fclose($handle);

        return back()->with('success', "นำเข้าข้อมูลนิสิตสำเร็จ! เพิ่มใหม่ {$imported} รายการ, อัปเดตข้อมูลเดิม {$updated} รายการ (ข้าม {$skipped} แถว)");
    }

    public function ugDownloadTemplate()
    {
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="ug_student_template.csv"',
        ];

        $callback = function () {
            $handle = fopen('php://output', 'w');
            // Add UTF-8 BOM
            fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));

            fputcsv($handle, [
                'รหัสนิสิต',
                'คำนำหน้าชื่อ',
                'ชื่อ',
                'นามสกุล',
                'ฉายา',
                'ระดับการศึกษา',
                'สาขาวิชา',
                'คณะ',
                'ส่วนจัดการศึกษา'
            ]);

            fputcsv($handle, [
                '6601201001',
                'พระ',
                'สมชาย',
                'ใจดี',
                'ปญฺญาธโร',
                'ปริญญาตรี',
                'พระพุทธศาสนา',
                'พุทธศาสตร์',
                'มจร ส่วนกลาง พระนครศรีอยุธยา'
            ]);

            fputcsv($handle, [
                '6601201002',
                'สามเณร',
                'วิชัย',
                'รักสงบ',
                'เขมโก',
                'ปริญญาตรี',
                'ปรัชญา',
                'พุทธศาสตร์',
                'วิทยาเขตเชียงใหม่'
            ]);

            fputcsv($handle, [
                '6601201003',
                'นาย',
                'ประสิทธิ์',
                'มั่นคง',
                '',
                'ปริญญาตรี',
                'รัฐประศาสนศาสตร์',
                'สังคมศาสตร์',
                'วิทยาเขตขอนแก่น'
            ]);

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function ugStudents(Request $request)
    {
        $this->checkAuth();
        $admin = Session::get('admin_user');
        $isCentralOrSuper = in_array($admin['role'], ['SUPER_ADMIN', 'CENTRAL_OFFICER']);

        $query = UgRegistration::with(['batch', 'organizationUnit'])->orderBy('created_at', 'desc');

        // สิทธิ์การเข้าถึงข้อมูลรายชื่อนิสิต:
        // เจ้าหน้าที่วิทยาเขตจะเห็นเฉพาะนิสิตในวิทยาเขตของตนเอง
        // เจ้าหน้าที่ส่วนกลางและ Super Admin จะเห็นของทุกส่วนงานทั่วประเทศ
        if (!$isCentralOrSuper && !empty($admin['org_unit_id'])) {
            $query->where('org_unit_id', $admin['org_unit_id']);
        } elseif ($request->filled('filter_org')) {
            $query->where('org_unit_id', $request->input('filter_org'));
        }

        // ค้นหาตามรหัสนิสิต / เลขที่สมัคร / ชื่อ-นามสกุล / เบอร์โทร
        if ($request->filled('search')) {
            $s = trim($request->input('search'));
            $query->where(function ($q) use ($s) {
                $q->where('student_code', 'LIKE', "%{$s}%")
                  ->orWhere('registration_no', 'LIKE', "%{$s}%")
                  ->orWhere('first_name', 'LIKE', "%{$s}%")
                  ->orWhere('last_name', 'LIKE', "%{$s}%")
                  ->orWhere('full_name', 'LIKE', "%{$s}%")
                  ->orWhere('phone', 'LIKE', "%{$s}%");
            });
        }

        // กรองตามโครงการ / รอบปฏิบัติธรรม
        if ($request->filled('batch_id')) {
            $query->where('batch_id', $request->input('batch_id'));
        }

        // กรองตามสถานะ
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        $perPage = $this->getPerPage($request);
        $registrations = $query->paginate($perPage)->withQueryString();
        $orgUnits = OrganizationUnit::where('is_active', 1)->orderBy('id', 'asc')->get();
        $batches = UgBatch::where('status', '!=', 'COMPLETED')->orderBy('academic_year', 'desc')->orderBy('start_date', 'asc')->get();

        return view('admin.ug_students', compact('registrations', 'orgUnits', 'batches', 'isCentralOrSuper'));
    }

    public function ugStudentUpdate(Request $request, $id)
    {
        $this->checkAuth();
        $admin = Session::get('admin_user');
        $isCentralOrSuper = in_array($admin['role'], ['SUPER_ADMIN', 'CENTRAL_OFFICER']);

        $reg = UgRegistration::findOrFail($id);

        // ตรวจสอบสิทธิ์: Super Admin / Central Officer แก้ไขได้ทุกส่วนงาน หรือ เจ้าหน้าที่วิทยาเขตสังกัดเดียวกัน
        if (!$isCentralOrSuper && $reg->org_unit_id != $admin['org_unit_id']) {
            return back()->with('error', 'ท่านไม่มีสิทธิ์แก้ไขข้อมูลนิสิตของส่วนงานอื่น');
        }

        $validated = $request->validate([
            'student_code' => 'required|string|max:50',
            'citizen_id' => 'required|string|max:13',
            'prefix' => 'required|string|max:50',
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'study_year' => 'required|integer|min:1|max:8',
            'phone' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:100',
            'faculty' => 'nullable|string|max:100',
            'major' => 'nullable|string|max:100',
            'batch_id' => 'required|integer',
            'status' => 'required|in:REGISTERED,CHECKED_IN,COMPLETED',
            'org_unit_id' => 'nullable|integer',
        ]);

        $updateData = [
            'student_code' => $validated['student_code'],
            'citizen_id' => $validated['citizen_id'],
            'prefix' => $validated['prefix'],
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'full_name' => $validated['prefix'] . $validated['first_name'] . ' ' . $validated['last_name'],
            'study_year' => $validated['study_year'],
            'phone' => $validated['phone'],
            'email' => $validated['email'],
            'faculty' => $validated['faculty'],
            'major' => $validated['major'],
            'batch_id' => $validated['batch_id'],
            'status' => $validated['status'],
        ];

        // อนุญาตให้แก้ไขส่วนงานสังกัดเฉพาะ Central / Super Admin
        if ($isCentralOrSuper && !empty($validated['org_unit_id'])) {
            $updateData['org_unit_id'] = $validated['org_unit_id'];
        }

        $reg->update($updateData);

        return back()->with('success', 'แก้ไขข้อมูลนิสิต (' . $reg->student_code . ' ' . $reg->full_name . ') สำเร็จเรียบร้อยแล้ว');
    }

    public function ugStudentDelete($id)
    {
        $this->checkAuth();
        $admin = Session::get('admin_user');
        $isCentralOrSuper = in_array($admin['role'], ['SUPER_ADMIN', 'CENTRAL_OFFICER']);

        $reg = UgRegistration::findOrFail($id);

        if (!$isCentralOrSuper && $reg->org_unit_id != $admin['org_unit_id']) {
            return back()->with('error', 'ท่านไม่มีสิทธิ์ลบข้อมูลนิสิตของส่วนงานอื่น');
        }

        $reg->delete();
        return back()->with('success', 'ลบข้อมูลการลงทะเบียนของนิสิตเรียบร้อยแล้ว');
    }

    public function ugCheckin($id)
    {
        $this->checkAuth();
        $admin = Session::get('admin_user');
        $isCentralOrSuper = in_array($admin['role'], ['SUPER_ADMIN', 'CENTRAL_OFFICER']);

        $reg = UgRegistration::findOrFail($id);

        if (!$isCentralOrSuper && $reg->org_unit_id != $admin['org_unit_id']) {
            return back()->with('error', 'ท่านไม่มีสิทธิ์จัดการข้อมูลนิสิตของส่วนงานอื่น');
        }

        $reg->status = 'CHECKED_IN';
        $reg->checked_in_at = now();
        $reg->save();

        return back()->with('success', 'เช็คอินนิสิต (' . $reg->student_code . ' ' . $reg->full_name . ') เรียบร้อยแล้ว');
    }

    public function ugComplete($id)
    {
        $this->checkAuth();
        $admin = Session::get('admin_user');
        $isCentralOrSuper = in_array($admin['role'], ['SUPER_ADMIN', 'CENTRAL_OFFICER']);

        $reg = UgRegistration::findOrFail($id);

        if (!$isCentralOrSuper && $reg->org_unit_id != $admin['org_unit_id']) {
            return back()->with('error', 'ท่านไม่มีสิทธิ์จัดการข้อมูลนิสิตของส่วนงานอื่น');
        }

        $reg->status = 'COMPLETED';
        $reg->evaluation_result = 'PASS';
        $reg->evaluation_score = 100;
        $reg->save();

        return back()->with('success', 'บันทึกสถานะผ่านเกณฑ์ 10 วัน ให้นิสิต (' . $reg->student_code . ' ' . $reg->full_name . ') เรียบร้อยแล้ว');
    }

    // จัดการจำนวนมาก (Bulk Action) สำหรับทะเบียนนิสิต ป.ตรี
    public function ugStudentsBulkAction(Request $request)
    {
        $this->checkAuth();
        $admin = Session::get('admin_user');
        $isCentralOrSuper = in_array($admin['role'], ['SUPER_ADMIN', 'CENTRAL_OFFICER']);

        $action = $request->input('bulk_action');
        $ids = $request->input('selected_ids', []);

        if (empty($ids) || !is_array($ids)) {
            return back()->with('error', 'กรุณาเลือกรายการที่ต้องการดำเนินการอย่างน้อย 1 รายการ');
        }

        $query = UgRegistration::whereIn('id', $ids);
        if (!$isCentralOrSuper && !empty($admin['org_unit_id'])) {
            $query->where('org_unit_id', $admin['org_unit_id']);
        }

        $count = $query->count();
        if ($count === 0) {
            return back()->with('error', 'ไม่พบรายการที่ท่านมีสิทธิ์ดำเนินการ');
        }

        switch ($action) {
            case 'CHECKED_IN':
                $query->update([
                    'status' => 'CHECKED_IN',
                    'checked_in_at' => now(),
                ]);
                return back()->with('success', "เช็คอินรายงานตัวจำนวนมากสำเร็จแล้ว ({$count} รายการ)");

            case 'COMPLETED':
                $query->update([
                    'status' => 'COMPLETED',
                    'evaluation_result' => 'PASS',
                    'evaluation_score' => 100,
                ]);
                return back()->with('success', "บันทึกผ่านเกณฑ์ 10 วัน จำนวนมากสำเร็จแล้ว ({$count} รายการ)");

            case 'REGISTERED':
                $query->update([
                    'status' => 'REGISTERED',
                    'checked_in_at' => null,
                ]);
                return back()->with('success', "ปรับสถานะกลับเป็นลงทะเบียนแล้ว ({$count} รายการ)");

            case 'DELETE':
                $query->delete();
                return back()->with('success', "ลบข้อมูลการลงทะเบียนจำนวนมากสำเร็จ ({$count} รายการ)");

            default:
                return back()->with('error', 'การดำเนินการไม่ถูกต้อง');
        }
    }

    public function ugScanner(Request $request)
    {
        $this->checkAuth();
        $admin = Session::get('admin_user');
        $isCentralOrSuper = in_array($admin['role'], ['SUPER_ADMIN', 'CENTRAL_OFFICER']);

        $batchQuery = UgBatch::with('organizationUnit')->orderBy('academic_year', 'desc')->orderBy('start_date', 'desc');
        if (!$isCentralOrSuper && !empty($admin['org_unit_id'])) {
            $batchQuery->where('org_unit_id', $admin['org_unit_id']);
        }
        $batches = $batchQuery->get();

        $selectedBatchId = $request->input('batch_id', $batches->first()->id ?? null);
        $selectedBatch = $selectedBatchId ? UgBatch::with('organizationUnit')->find($selectedBatchId) : null;

        // สรุปยอดการเช็คอินของโครงการที่เลือก
        $stats = [
            'total' => 0,
            'checked_in' => 0,
            'completed' => 0,
            'registered' => 0,
        ];

        $recentCheckins = collect();

        if ($selectedBatchId) {
            $stats['total'] = UgRegistration::where('batch_id', $selectedBatchId)->count();
            $stats['checked_in'] = UgRegistration::where('batch_id', $selectedBatchId)->where('status', 'CHECKED_IN')->count();
            $stats['completed'] = UgRegistration::where('batch_id', $selectedBatchId)->where('status', 'COMPLETED')->count();
            $stats['registered'] = UgRegistration::where('batch_id', $selectedBatchId)->where('status', 'REGISTERED')->count();

            $recentCheckins = UgRegistration::with('organizationUnit')
                ->where('batch_id', $selectedBatchId)
                ->whereIn('status', ['CHECKED_IN', 'COMPLETED'])
                ->orderBy('updated_at', 'desc')
                ->take(10)
                ->get();
        }

        return view('admin.ug_scanner', compact('batches', 'selectedBatch', 'selectedBatchId', 'stats', 'recentCheckins', 'isCentralOrSuper'));
    }

    public function ugScannerVerify(Request $request)
    {
        $this->checkAuth();
        $code = trim($request->input('code', ''));
        $batchId = $request->input('batch_id');

        if (!$code) {
            return response()->json([
                'success' => false,
                'message' => 'ไม่พบข้อมูลรหัส QR Code หรือเลขที่ลงทะเบียน'
            ]);
        }

        // คลีนค่า code เผื่อส่งมาในรูปแบบ MCUVMS-UG-xxx หรือ URL
        $cleanCode = preg_replace('/^MCUVMS-/', '', $code);

        $query = UgRegistration::with(['batch', 'organizationUnit'])
            ->where(function ($q) use ($cleanCode) {
                $q->where('registration_no', $cleanCode)
                  ->orWhere('student_code', $cleanCode)
                  ->orWhere('citizen_id', $cleanCode);
            });

        if ($batchId) {
            $query->where('batch_id', $batchId);
        }

        $student = $query->first();

        if (!$student) {
            return response()->json([
                'success' => false,
                'message' => "ไม่พบข้อมูลนิสิตจากรหัส '{$cleanCode}' ในโครงการนี้ กรุณาตรวจสอบอีกครั้ง"
            ]);
        }

        // ตรวจสอบสถานะปัจจุบัน
        $previousStatus = $student->status;
        $alreadyCheckedIn = in_array($previousStatus, ['CHECKED_IN', 'COMPLETED']);

        // อัปเดตสถานะเป็น CHECKED_IN ทันที
        $student->status = 'CHECKED_IN';
        $student->checked_in_at = now();
        $student->save();

        return response()->json([
            'success' => true,
            'already_checked_in' => $alreadyCheckedIn,
            'message' => $alreadyCheckedIn 
                ? 'นิสิตท่านนี้ได้รายงานตัวเช็คอินไปแล้วก่อนหน้า' 
                : 'เช็คอินรายงานตัวสำเร็จเรียบร้อยแล้ว!',
            'student' => [
                'id' => $student->id,
                'registration_no' => $student->registration_no,
                'student_code' => $student->student_code,
                'full_name' => $student->prefix . $student->first_name . ' ' . $student->last_name,
                'org_unit_name' => $student->organizationUnit->name_th ?? 'มจร',
                'faculty' => $student->faculty ?? '-',
                'study_year' => $student->study_year ?? 1,
                'batch_title' => $student->batch->title ?? '-',
                'phone' => $student->phone ?? '-',
                'status' => $student->status,
                'checked_in_at' => $student->checked_in_at ? $student->checked_in_at->format('d/m/Y H:i:s') : date('d/m/Y H:i:s')
            ]
        ]);
    }

    public function ugAttendancePrint(Request $request)
    {
        $this->checkAuth();
        $admin = Session::get('admin_user');
        $isCentralOrSuper = in_array($admin['role'], ['SUPER_ADMIN', 'CENTRAL_OFFICER']);

        $batchQuery = UgBatch::with('organizationUnit')->orderBy('academic_year', 'desc')->orderBy('start_date', 'desc');
        if (!$isCentralOrSuper && !empty($admin['org_unit_id'])) {
            $batchQuery->where('org_unit_id', $admin['org_unit_id']);
        }
        $batches = $batchQuery->get();

        $selectedBatchId = $request->input('batch_id', $batches->first()->id ?? null);
        $selectedBatch = $selectedBatchId ? UgBatch::with('organizationUnit')->find($selectedBatchId) : null;

        $registrations = collect();
        if ($selectedBatchId) {
            $registrations = UgRegistration::with('organizationUnit')
                ->where('batch_id', $selectedBatchId)
                ->orderBy('student_code', 'asc')
                ->get();
        }

        return view('admin.ug_attendance', compact('batches', 'selectedBatch', 'selectedBatchId', 'registrations', 'isCentralOrSuper'));
    }

    public function ugExportRegistrar(Request $request)
    {
        $this->checkAuth();
        $admin = Session::get('admin_user');
        $isCentralOrSuper = in_array($admin['role'], ['SUPER_ADMIN', 'CENTRAL_OFFICER']);

        $batchId = $request->input('batch_id');
        $statusFilter = $request->input('status', 'ALL');

        $query = UgRegistration::with(['batch', 'organizationUnit'])->orderBy('student_code', 'asc');

        if (!$isCentralOrSuper && !empty($admin['org_unit_id'])) {
            $query->where('org_unit_id', $admin['org_unit_id']);
        }

        if ($batchId) {
            $query->where('batch_id', $batchId);
            $batch = UgBatch::find($batchId);
            $batchName = $batch ? "_{$batch->academic_year}" : '';
        } else {
            $batchName = '_ALL';
        }

        if ($statusFilter !== 'ALL') {
            $query->where('status', $statusFilter);
        }

        $records = $query->get();

        $filename = "MCUVMS_UG_Registrar_Export" . $batchName . "_" . date('Ymd_His') . ".csv";

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($records) {
            $handle = fopen('php://output', 'w');
            // Add UTF-8 BOM for Excel in Thai
            fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));

            // Header Row
            fputcsv($handle, [
                'ลำดับ',
                'เลขที่สมัคร',
                'รหัสนิสิต',
                'คำนำหน้า',
                'ชื่อ',
                'นามสกุล',
                'ฉายา',
                'ระดับการศึกษา',
                'ชั้นปี',
                'คณะ',
                'สาขาวิชา',
                'ส่วนงานต้นสังกัด',
                'โครงการปฏิบัติธรรม',
                'ปีการศึกษา',
                'เบอร์โทรศัพท์',
                'สถานะการปฏิบัติ',
                'ผลการประเมิน',
                'คะแนน',
                'วันที่เช็คอิน'
            ]);

            $index = 1;
            foreach ($records as $r) {
                $statusTh = match ($r->status) {
                    'COMPLETED' => 'ผ่านเกณฑ์ 10 วัน',
                    'CHECKED_IN' => 'เข้าปฏิบัติธรรมแล้ว',
                    default => 'ลงทะเบียนแล้ว'
                };

                $evalTh = match ($r->evaluation_result) {
                    'PASS' => 'ผ่าน (P)',
                    'FAIL' => 'ไม่ผ่าน (U)',
                    default => ($r->status === 'COMPLETED' ? 'ผ่าน (P)' : 'รอดำเนินการ')
                };

                fputcsv($handle, [
                    $index++,
                    $r->registration_no,
                    $r->student_code,
                    $r->prefix,
                    $r->first_name,
                    $r->last_name,
                    $r->chaya ?? '',
                    'ปริญญาตรี',
                    $r->study_year ?? 1,
                    $r->faculty ?? '',
                    $r->major ?? '',
                    $r->organizationUnit->name_th ?? 'มจร',
                    $r->batch->title ?? '',
                    $r->batch->academic_year ?? '',
                    $r->phone ?? '',
                    $statusTh,
                    $evalTh,
                    $r->evaluation_score ?? ($r->status === 'COMPLETED' ? 100 : 0),
                    $r->checked_in_at ? $r->checked_in_at : ''
                ]);
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function gradApprovals(Request $request)
    {
        $this->checkAuth();
        $admin = Session::get('admin_user');
        $isCentralOrSuper = in_array($admin['role'], ['SUPER_ADMIN', 'CENTRAL_OFFICER']);

        $query = GradStudent::with('organizationUnit')
            ->orderByRaw("FIELD(submission_status, 'SUBMITTED', 'ACCUMULATING', 'APPROVED', 'REJECTED')")
            ->orderBy('submitted_at', 'desc')
            ->orderBy('id', 'desc');

        if (!$isCentralOrSuper && !empty($admin['org_unit_id'])) {
            $query->where('org_unit_id', $admin['org_unit_id']);
        } elseif ($request->filled('filter_org')) {
            $query->where('org_unit_id', $request->input('filter_org'));
        }

        if ($request->filled('degree_level')) {
            $query->where('degree_level', $request->input('degree_level'));
        }

        if ($request->filled('status')) {
            $query->where('submission_status', $request->input('status'));
        }

        if ($request->filled('search')) {
            $s = trim($request->input('search'));
            $query->where(function ($q) use ($s) {
                $q->where('student_code', 'LIKE', "%{$s}%")
                  ->orWhere('first_name', 'LIKE', "%{$s}%")
                  ->orWhere('last_name', 'LIKE', "%{$s}%")
                  ->orWhere('program_name', 'LIKE', "%{$s}%");
            });
        }

        $perPage = $this->getPerPage($request);
        $students = $query->paginate($perPage)->withQueryString();
        $orgUnits = OrganizationUnit::where('is_active', 1)->orderBy('id', 'asc')->get();

        return view('admin.grad_approvals', compact('students', 'orgUnits', 'isCentralOrSuper'));
    }

    public function gradApprove(Request $request)
    {
        $this->checkAuth();
        $studentId = $request->input('student_id');
        $admin = Session::get('admin_user');

        GradStudent::where('id', $studentId)->update([
            'submission_status' => 'APPROVED',
            'approved_at' => now(),
            'approved_by' => $admin['id'],
        ]);

        return back()->with('success', 'อนุมัติผลการสะสมวันปฏิบัติธรรมของนิสิตเรียบร้อยแล้ว');
    }

    public function gradReject(Request $request)
    {
        $this->checkAuth();
        $studentId = $request->input('student_id');

        GradStudent::where('id', $studentId)->update([
            'submission_status' => 'REJECTED',
        ]);

        return back()->with('success', 'ส่งกลับแก้ไขแฟ้มสะสมวันของนิสิตเรียบร้อยแล้ว');
    }

    public function publicSar(Request $request)
    {
        $this->checkAuth();
        $admin = Session::get('admin_user');
        $isCentralOrSuper = in_array($admin['role'], ['SUPER_ADMIN', 'CENTRAL_OFFICER']);

        $total_registered = PublicRegistration::count();
        $confirmed_count = PublicRegistration::where('status', 'CONFIRMED')->count();
        $waiting_count = PublicRegistration::where('status', 'WAITING_LIST')->count();

        $gender_stats = PublicRegistration::select('gender', DB::raw('count(*) as count'))
            ->groupBy('gender')
            ->get();

        $age_stats = PublicRegistration::select(
            DB::raw("CASE 
                WHEN age < 25 THEN 'เยาวชน (< 25 ปี)'
                WHEN age BETWEEN 25 AND 45 THEN 'วัยทำงาน (25 - 45 ปี)'
                WHEN age BETWEEN 46 AND 60 THEN 'วัยผู้ใหญ่ (46 - 60 ปี)'
                ELSE 'ผู้สูงอายุ (> 60 ปี)'
            END as age_group"),
            DB::raw('count(*) as count')
        )->groupBy('age_group')->get();

        $query = PublicRegistration::with(['event.organizationUnit'])->orderBy('created_at', 'desc');

        // สิทธิ์การเข้าถึงตามส่วนงาน
        if (!$isCentralOrSuper && !empty($admin['org_unit_id'])) {
            $query->whereHas('event', function ($q) use ($admin) {
                $q->where('org_unit_id', $admin['org_unit_id']);
            });
        } elseif ($request->filled('filter_org')) {
            $orgId = $request->input('filter_org');
            $query->whereHas('event', function ($q) use ($orgId) {
                $q->where('org_unit_id', $orgId);
            });
        }

        // ค้นหาตามชื่อ-สกุล, เบอร์โทร, หรือคิว
        if ($request->filled('search')) {
            $s = trim($request->input('search'));
            $cleanQueue = preg_replace('/[^0-9]/', '', $s);
            $query->where(function ($q) use ($s, $cleanQueue) {
                $q->where('full_name', 'LIKE', "%{$s}%")
                  ->orWhere('phone', 'LIKE', "%{$s}%");
                if ($cleanQueue) {
                    $q->orWhere('queue_no', intval($cleanQueue));
                }
            });
        }

        // กรองตามโครงการอบรมประชาชน
        if ($request->filled('event_id')) {
            $query->where('event_id', $request->input('event_id'));
        }

        // กรองตามสถานะ
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        $perPage = $this->getPerPage($request);
        $registrations = $query->paginate($perPage)->withQueryString();
        $events = PublicEvent::orderBy('start_date', 'desc')->get();
        $orgUnits = OrganizationUnit::where('is_active', 1)->orderBy('id', 'asc')->get();

        return view('admin.public_sar', compact('total_registered', 'confirmed_count', 'waiting_count', 'gender_stats', 'age_stats', 'registrations', 'events', 'orgUnits', 'isCentralOrSuper'));
    }

    // จัดการจำนวนมาก (Bulk Action) สำหรับการอนุมัติบัณฑิตศึกษา (Module 2)
    public function gradApprovalsBulkAction(Request $request)
    {
        $this->checkAuth();
        $admin = Session::get('admin_user');
        $isCentralOrSuper = in_array($admin['role'], ['SUPER_ADMIN', 'CENTRAL_OFFICER']);

        $action = $request->input('bulk_action');
        $ids = $request->input('selected_ids', []);

        if (empty($ids) || !is_array($ids)) {
            return back()->with('error', 'กรุณาเลือกรายการที่ต้องการดำเนินการอย่างน้อย 1 รายการ');
        }

        $query = GradStudent::whereIn('id', $ids);
        if (!$isCentralOrSuper && !empty($admin['org_unit_id'])) {
            $query->where('org_unit_id', $admin['org_unit_id']);
        }

        $count = $query->count();
        if ($count === 0) {
            return back()->with('error', 'ไม่พบรายการที่ท่านมีสิทธิ์ดำเนินการ');
        }

        switch ($action) {
            case 'APPROVE':
                $query->update([
                    'submission_status' => 'APPROVED',
                    'approved_at' => now(),
                    'approved_by' => $admin['id'],
                ]);
                return back()->with('success', "อนุมัติผลการสะสมวันจำนวนมากสำเร็จแล้ว ({$count} รายการ)");

            case 'REJECT':
                $query->update([
                    'submission_status' => 'REJECTED',
                ]);
                return back()->with('success', "ส่งกลับแก้ไขแฟ้มสะสมวันจำนวนมากเรียบร้อยแล้ว ({$count} รายการ)");

            case 'RESET':
                $query->update([
                    'submission_status' => 'ACCUMULATING',
                ]);
                return back()->with('success', "ปรับสถานะกลับเป็นกำลังสะสมวัน ({$count} รายการ)");

            default:
                return back()->with('error', 'การดำเนินการไม่ถูกต้อง');
        }
    }

    // จัดการจำนวนมาก (Bulk Action) สำหรับทะเบียนประชาชนทั่วไป (Module 3)
    public function publicSarBulkAction(Request $request)
    {
        $this->checkAuth();
        $admin = Session::get('admin_user');
        $isCentralOrSuper = in_array($admin['role'], ['SUPER_ADMIN', 'CENTRAL_OFFICER']);

        $action = $request->input('bulk_action');
        $ids = $request->input('selected_ids', []);

        if (empty($ids) || !is_array($ids)) {
            return back()->with('error', 'กรุณาเลือกรายการที่ต้องการดำเนินการอย่างน้อย 1 รายการ');
        }

        $query = PublicRegistration::whereIn('id', $ids);
        if (!$isCentralOrSuper && !empty($admin['org_unit_id'])) {
            $query->whereHas('event', function ($q) use ($admin) {
                $q->where('org_unit_id', $admin['org_unit_id']);
            });
        }

        $count = $query->count();
        if ($count === 0) {
            return back()->with('error', 'ไม่พบรายการที่ท่านมีสิทธิ์ดำเนินการ');
        }

        switch ($action) {
            case 'CONFIRMED':
                $query->update(['status' => 'CONFIRMED']);
                return back()->with('success', "ปรับสถานะเป็น ได้รับสิทธิ์เข้าร่วม (Confirmed) จำนวน {$count} ท่าน");

            case 'WAITING_LIST':
                $query->update(['status' => 'WAITING_LIST']);
                return back()->with('success', "ปรับสถานะเป็น รายชื่อสำรอง (Waiting List) จำนวน {$count} ท่าน");

            case 'ATTENDED':
                $query->update(['status' => 'ATTENDED']);
                return back()->with('success', "บันทึกเข้าร่วมอบรมแล้ว (Attended) จำนวน {$count} ท่าน");

            case 'CANCELLED':
                $query->update(['status' => 'CANCELLED']);
                return back()->with('success', "ปรับสถานะเป็น ยกเลิกการเข้าร่วม จำนวน {$count} ท่าน");

            case 'DELETE':
                $query->delete();
                return back()->with('success', "ลบข้อมูลผู้สมัครเข้าร่วมจำนวนมากสำเร็จ ({$count} รายการ)");

            default:
                return back()->with('error', 'การดำเนินการไม่ถูกต้อง');
        }
    }

    public function newsIndex(Request $request)
    {
        $this->checkAuth();
        $admin = Session::get('admin_user');
        $isCentralOrSuper = in_array($admin['role'], ['SUPER_ADMIN', 'CENTRAL_OFFICER']);

        $query = NewsArticle::with('organizationUnit');

        if (!$isCentralOrSuper && !empty($admin['org_unit_id'])) {
            $query->where('org_unit_id', $admin['org_unit_id']);
        }

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->input('search') . '%');
        }

        if ($request->filled('category')) {
            $query->where('category', $request->input('category'));
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        $perPage = $this->getPerPage($request);
        $newsList = $query->orderBy('is_pinned', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate($perPage)
            ->withQueryString();

        $orgUnits = OrganizationUnit::where('is_active', 1)->orderBy('name_th')->get();

        return view('admin.news_index', compact('newsList', 'orgUnits', 'admin', 'isCentralOrSuper'));
    }

    public function newsStore(Request $request)
    {
        $this->checkAuth();
        $admin = Session::get('admin_user');
        $isCentralOrSuper = in_array($admin['role'], ['SUPER_ADMIN', 'CENTRAL_OFFICER']);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category' => 'required|in:ANNOUNCEMENT,MEDITATION,ACADEMIC,GENERAL',
            'status' => 'required|in:DRAFT,PUBLISHED,ARCHIVED',
            'is_pinned' => 'nullable|boolean',
            'cover_image' => 'nullable|string|max:500',
            'cover_file' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:5120',
            'org_unit_id' => 'nullable|integer',
        ]);

        $coverImageUrl = $validated['cover_image'] ?? null;
        if ($request->hasFile('cover_file') && $request->file('cover_file')->isValid()) {
            $path = $request->file('cover_file')->store('news', 'public');
            $coverImageUrl = Storage::url($path);
        }

        $orgUnitId = $isCentralOrSuper ? (!empty($validated['org_unit_id']) ? $validated['org_unit_id'] : null) : ($admin['org_unit_id'] ?? null);

        NewsArticle::create([
            'org_unit_id' => $orgUnitId,
            'title' => $validated['title'],
            'content' => $validated['content'],
            'cover_image' => $coverImageUrl,
            'category' => $validated['category'],
            'is_pinned' => $request->has('is_pinned') ? 1 : 0,
            'status' => $validated['status'],
            'views' => 0,
            'published_at' => now(),
            'created_at' => now(),
        ]);

        return redirect()->route('admin.news.index')->with('success', 'บันทึกและเผยแพร่ข่าวสารเรียบร้อยแล้ว');
    }

    public function newsUpdate(Request $request, $id)
    {
        $this->checkAuth();
        $admin = Session::get('admin_user');
        $isCentralOrSuper = in_array($admin['role'], ['SUPER_ADMIN', 'CENTRAL_OFFICER']);

        $article = NewsArticle::findOrFail($id);

        if (!$isCentralOrSuper && $article->org_unit_id != $admin['org_unit_id']) {
            return redirect()->route('admin.news.index')->with('error', 'ท่านไม่มีสิทธิ์แก้ไขข่าวสารของหน่วยงานอื่น');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category' => 'required|in:ANNOUNCEMENT,MEDITATION,ACADEMIC,GENERAL',
            'status' => 'required|in:DRAFT,PUBLISHED,ARCHIVED',
            'is_pinned' => 'nullable|boolean',
            'cover_image' => 'nullable|string|max:500',
            'cover_file' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:5120',
            'org_unit_id' => 'nullable|integer',
        ]);

        $coverImageUrl = $validated['cover_image'] ?? $article->cover_image;
        if ($request->hasFile('cover_file') && $request->file('cover_file')->isValid()) {
            $path = $request->file('cover_file')->store('news', 'public');
            $coverImageUrl = Storage::url($path);
        }

        $updateData = [
            'title' => $validated['title'],
            'content' => $validated['content'],
            'cover_image' => $coverImageUrl,
            'category' => $validated['category'],
            'is_pinned' => $request->has('is_pinned') ? 1 : 0,
            'status' => $validated['status'],
        ];

        if ($isCentralOrSuper) {
            $updateData['org_unit_id'] = !empty($validated['org_unit_id']) ? $validated['org_unit_id'] : null;
        }

        $article->update($updateData);

        return redirect()->route('admin.news.index')->with('success', 'อัปเดตข่าวสารประชาสัมพันธ์เรียบร้อยแล้ว');
    }

    public function newsDelete($id)
    {
        $this->checkAuth();
        $admin = Session::get('admin_user');
        $isCentralOrSuper = in_array($admin['role'], ['SUPER_ADMIN', 'CENTRAL_OFFICER']);

        $article = NewsArticle::findOrFail($id);

        if (!$isCentralOrSuper && $article->org_unit_id != $admin['org_unit_id']) {
            return redirect()->route('admin.news.index')->with('error', 'ท่านไม่มีสิทธิ์ลบข่าวสารของหน่วยงานอื่น');
        }

        $article->delete();

        return redirect()->route('admin.news.index')->with('success', 'ลบข่าวสารเรียบร้อยแล้ว');
    }

    public function newsTogglePin($id)
    {
        $this->checkAuth();
        $article = NewsArticle::findOrFail($id);
        $article->is_pinned = $article->is_pinned ? 0 : 1;
        $article->save();

        return redirect()->route('admin.news.index')->with('success', $article->is_pinned ? 'ปักหมุดข่าวแล้ว' : 'ยกเลิกการปักหมุดข่าวแล้ว');
    }

    // ==========================================
    // Rule Matrix: จัดการผู้ใช้งานและกำหนดสิทธิ์ (User & Role Management)
    // ==========================================
    public function usersIndex(Request $request)
    {
        $this->checkAuth();
        $admin = Session::get('admin_user');
        
        // เฉพาะ SUPER_ADMIN และ CENTRAL_OFFICER เท่านั้นที่มีสิทธิ์เข้าจัดการผู้ใช้งาน
        if (!in_array($admin['role'], ['SUPER_ADMIN', 'CENTRAL_OFFICER'])) {
            return redirect()->route('admin.dashboard')->with('error', 'ท่านไม่มีสิทธิ์เข้าถึงเมนูจัดการผู้ใช้งานและกำหนดสิทธิ์');
        }

        $query = User::with('organizationUnit')->orderBy('role', 'asc')->orderBy('id', 'asc');

        if ($request->filled('role_filter')) {
            $query->where('role', $request->input('role_filter'));
        }

        if ($request->filled('search')) {
            $s = trim($request->input('search'));
            $query->where(function($q) use ($s) {
                $q->where('username', 'LIKE', "%{$s}%")
                  ->orWhere('full_name', 'LIKE', "%{$s}%")
                  ->orWhere('email', 'LIKE', "%{$s}%");
            });
        }

        $perPage = $this->getPerPage($request);
        $users = $query->paginate($perPage)->withQueryString();
        $orgUnits = OrganizationUnit::where('is_active', 1)->orderBy('id', 'asc')->get();

        return view('admin.users_index', compact('users', 'orgUnits'));
    }

    public function userStore(Request $request)
    {
        $this->checkAuth();
        $admin = Session::get('admin_user');
        if (!in_array($admin['role'], ['SUPER_ADMIN', 'CENTRAL_OFFICER'])) {
            return back()->with('error', 'ท่านไม่มีสิทธิ์เพิ่มผู้ใช้งาน');
        }

        $validated = $request->validate([
            'username' => 'required|string|max:50|unique:users,username',
            'password' => 'required|string|min:6',
            'full_name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'role' => 'required|in:SUPER_ADMIN,CENTRAL_OFFICER,CAMPUS_ADMIN,EXECUTIVE',
            'org_unit_id' => 'nullable|integer|exists:organization_units,id',
            'is_active' => 'nullable|boolean',
        ]);

        User::create([
            'username' => trim($validated['username']),
            'password_hash' => password_hash($validated['password'], PASSWORD_BCRYPT),
            'full_name' => trim($validated['full_name']),
            'email' => $validated['email'] ?? null,
            'role' => $validated['role'],
            'org_unit_id' => $validated['role'] === 'CAMPUS_ADMIN' ? $validated['org_unit_id'] : ($validated['org_unit_id'] ?? 1),
            'is_active' => $request->has('is_active') ? 1 : 1,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'เพิ่มผู้ใช้งานและกำหนดสิทธิ์สำเร็จเรียบร้อยแล้ว');
    }

    public function userUpdate(Request $request, $id)
    {
        $this->checkAuth();
        $admin = Session::get('admin_user');
        if (!in_array($admin['role'], ['SUPER_ADMIN', 'CENTRAL_OFFICER'])) {
            return back()->with('error', 'ท่านไม่มีสิทธิ์แก้ไขผู้ใช้งาน');
        }

        $user = User::findOrFail($id);

        $validated = $request->validate([
            'username' => 'required|string|max:50|unique:users,username,' . $user->id,
            'password' => 'nullable|string|min:6',
            'full_name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'role' => 'required|in:SUPER_ADMIN,CENTRAL_OFFICER,CAMPUS_ADMIN,EXECUTIVE',
            'org_unit_id' => 'nullable|integer|exists:organization_units,id',
            'is_active' => 'nullable|boolean',
        ]);

        $updateData = [
            'username' => trim($validated['username']),
            'full_name' => trim($validated['full_name']),
            'email' => $validated['email'] ?? null,
            'role' => $validated['role'],
            'org_unit_id' => $validated['role'] === 'CAMPUS_ADMIN' ? $validated['org_unit_id'] : ($validated['org_unit_id'] ?? 1),
            'is_active' => $request->has('is_active') ? 1 : 0,
        ];

        if (!empty($validated['password'])) {
            $updateData['password_hash'] = password_hash($validated['password'], PASSWORD_BCRYPT);
        }

        $user->update($updateData);

        return redirect()->route('admin.users.index')->with('success', 'อัปเดตข้อมูลผู้ใช้งานและสิทธิ์เรียบร้อยแล้ว');
    }

    public function userToggleStatus($id)
    {
        $this->checkAuth();
        $admin = Session::get('admin_user');
        if (!in_array($admin['role'], ['SUPER_ADMIN', 'CENTRAL_OFFICER'])) {
            return back()->with('error', 'ท่านไม่มีสิทธิ์ระงับผู้ใช้งาน');
        }

        $user = User::findOrFail($id);
        if ($user->id === $admin['id']) {
            return back()->with('error', 'ไม่สามารถปิดการใช้งานบัญชีที่กำลังล็อกอินอยู่ได้');
        }

        $user->is_active = $user->is_active ? 0 : 1;
        $user->save();

        return redirect()->route('admin.users.index')->with('success', $user->is_active ? 'เปิดใช้งานบัญชีผู้ใช้แล้ว' : 'ระงับการใช้งานบัญชีผู้ใช้แล้ว');
    }

    public function userDelete($id)
    {
        $this->checkAuth();
        $admin = Session::get('admin_user');
        if ($admin['role'] !== 'SUPER_ADMIN') {
            return back()->with('error', 'เฉพาะผู้ดูแลระบบส่วนกลางระดับสูงสุด (Super Admin) เท่านั้นที่มีสิทธิ์ลบบัญชีผู้ใช้');
        }

        $user = User::findOrFail($id);
        if ($user->id === $admin['id']) {
            return back()->with('error', 'ไม่สามารถลบบัญชีที่กำลังล็อกอินอยู่ได้');
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'ลบบัญชีผู้ใช้งานเรียบร้อยแล้ว');
    }

    /**
     * Module: ระบบสถิติเปรียบเทียบและการวิเคราะห์สำหรับผู้บริหาร (Executive Analytics & Comparative Dashboard)
     * สิทธิ์ตาม Rule Matrix: ผู้บริหาร (ดู Dashboard ภาพรวม, ดูสถิติระดับส่วนงาน, ดูสถิติระดับประเทศ, เปรียบเทียบข้อมูลระหว่างส่วนงาน)
     */
    public function executiveAnalytics(Request $request)
    {
        $this->checkAuth();
        $admin = Session::get('admin_user');

        // สถิติระดับประเทศ (National Aggregate Stats)
        $totalUgNation = UgRegistration::count();
        $totalUgPassNation = UgRegistration::where('status', 'COMPLETED')->count();
        $totalGradNation = GradStudent::count();
        $totalGradApprovedNation = GradStudent::where('submission_status', 'APPROVED')->count();
        $totalPublicNation = PublicRegistration::count();
        $totalEventsNation = PublicEvent::count();

        // คำนวณอัตราความสำเร็จระดับประเทศ (%)
        $ugPassRateNation = $totalUgNation > 0 ? round(($totalUgPassNation / $totalUgNation) * 100, 1) : 0;
        $gradApprovedRateNation = $totalGradNation > 0 ? round(($totalGradApprovedNation / $totalGradNation) * 100, 1) : 0;

        // สถิติจำแนกตามประเภทส่วนงาน (CENTRAL, CAMPUS, SANGHA_COLLEGE, ACADEMIC_UNIT)
        $statsByType = OrganizationUnit::select('type', DB::raw('count(*) as org_count'))
            ->where('is_active', 1)
            ->groupBy('type')
            ->get()
            ->map(function ($t) {
                $orgIds = OrganizationUnit::where('type', $t->type)->pluck('id');
                $t->ug_count = UgRegistration::whereIn('org_unit_id', $orgIds)->count();
                $t->ug_completed = UgRegistration::whereIn('org_unit_id', $orgIds)->where('status', 'COMPLETED')->count();
                $t->grad_count = GradStudent::whereIn('org_unit_id', $orgIds)->count();
                $t->grad_approved = GradStudent::whereIn('org_unit_id', $orgIds)->where('submission_status', 'APPROVED')->count();
                $t->public_count = PublicRegistration::whereHas('event', function ($q) use ($orgIds) {
                    $q->whereIn('org_unit_id', $orgIds);
                })->count();
                return $t;
            });

        // รายการส่วนงานทั้งหมดสำหรับการเปรียบเทียบ (52 ส่วนงาน)
        $allOrgUnits = OrganizationUnit::where('is_active', 1)->orderBy('id', 'asc')->get();

        // ตัวเลือกการเปรียบเทียบส่วนงาน (Comparative Analysis: Org A vs Org B)
        $selectedOrgAId = $request->input('org_a', 10); // default: วิทยาเขตเชียงใหม่
        $selectedOrgBId = $request->input('org_b', 11); // default: วิทยาเขตขอนแก่น

        $orgA = OrganizationUnit::find($selectedOrgAId);
        $orgB = OrganizationUnit::find($selectedOrgBId);

        $getOrgMetrics = function ($orgId) {
            if (!$orgId) return null;
            $ugTotal = UgRegistration::where('org_unit_id', $orgId)->count();
            $ugCompleted = UgRegistration::where('org_unit_id', $orgId)->where('status', 'COMPLETED')->count();
            $ugCheckin = UgRegistration::where('org_unit_id', $orgId)->whereIn('status', ['CHECKED_IN', 'COMPLETED'])->count();
            
            $gradTotal = GradStudent::where('org_unit_id', $orgId)->count();
            $gradMaster = GradStudent::where('org_unit_id', $orgId)->where('degree_level', 'MASTER')->count();
            $gradDoctoral = GradStudent::where('org_unit_id', $orgId)->where('degree_level', 'DOCTORAL')->count();
            $gradApproved = GradStudent::where('org_unit_id', $orgId)->where('submission_status', 'APPROVED')->count();
            $gradAccumulating = GradStudent::where('org_unit_id', $orgId)->whereIn('submission_status', ['ACCUMULATING', 'SUBMITTED'])->count();

            $publicTotal = PublicRegistration::whereHas('event', function ($q) use ($orgId) {
                $q->where('org_unit_id', $orgId);
            })->count();
            $eventsCount = PublicEvent::where('org_unit_id', $orgId)->count();

            $ugPassRate = $ugTotal > 0 ? round(($ugCompleted / $ugTotal) * 100, 1) : 0;
            $gradPassRate = $gradTotal > 0 ? round(($gradApproved / $gradTotal) * 100, 1) : 0;

            return [
                'ug_total' => $ugTotal,
                'ug_completed' => $ugCompleted,
                'ug_checkin' => $ugCheckin,
                'ug_pass_rate' => $ugPassRate,
                'grad_total' => $gradTotal,
                'grad_master' => $gradMaster,
                'grad_doctoral' => $gradDoctoral,
                'grad_approved' => $gradApproved,
                'grad_accumulating' => $gradAccumulating,
                'grad_pass_rate' => $gradPassRate,
                'public_total' => $publicTotal,
                'events_count' => $eventsCount,
                'grand_total' => $ugTotal + $gradTotal + $publicTotal,
            ];
        };

        $metricsA = $getOrgMetrics($selectedOrgAId);
        $metricsB = $getOrgMetrics($selectedOrgBId);

        // อันดับสูงสุดของส่วนงานที่มีผู้เข้าร่วมปฏิบัติวิปัสสนามากที่สุด Top 10 (Ranking)
        $topOrgs = OrganizationUnit::where('is_active', 1)
            ->get()
            ->map(function ($org) use ($getOrgMetrics) {
                $m = $getOrgMetrics($org->id);
                $org->metrics = $m;
                return $org;
            })
            ->filter(function ($org) {
                return $org->metrics['grand_total'] > 0;
            })
            ->sortByDesc(function ($org) {
                return $org->metrics['grand_total'];
            })
            ->values();

        return view('admin.executive_analytics', compact(
            'totalUgNation',
            'totalUgPassNation',
            'totalGradNation',
            'totalGradApprovedNation',
            'totalPublicNation',
            'totalEventsNation',
            'ugPassRateNation',
            'gradApprovedRateNation',
            'statsByType',
            'allOrgUnits',
            'selectedOrgAId',
            'selectedOrgBId',
            'orgA',
            'orgB',
            'metricsA',
            'metricsB',
            'topOrgs'
        ));
    }

    protected function getPerPage(Request $request, $default = 20)
    {
        $perPage = strtolower((string)$request->input('per_page', $default));
        if ($perPage === 'all') {
            return 999999;
        }
        $val = (int)$perPage;
        if (in_array($val, [10, 20, 50, 100])) {
            return $val;
        }
        return $default;
    }

    // Organization Units Master Directory (ภายใต้กลุ่ม การตั้งค่า)
    public function orgUnitsIndex(Request $request)
    {
        $this->checkAuth();

        $query = OrganizationUnit::withCount(['ugRegistrations as ug_count', 'gradStudents as grad_count']);

        if ($request->filled('search')) {
            $s = $request->input('search');
            $query->where(function ($q) use ($s) {
                $q->where('name_th', 'like', "%{$s}%")
                  ->orWhere('code', 'like', "%{$s}%")
                  ->orWhere('province_th', 'like', "%{$s}%")
                  ->orWhere('province_code', 'like', "%{$s}%");
            });
        }

        if ($request->filled('type')) {
            $query->where('type', $request->input('type'));
        }

        $perPage = $this->getPerPage($request, 20);
        $orgUnits = $query->orderBy('id', 'asc')->paginate($perPage)->withQueryString();

        $totalOrgs = OrganizationUnit::where('is_active', 1)->count();
        $totalCampuses = OrganizationUnit::where('type', 'CAMPUS')->count();
        $totalColleges = OrganizationUnit::where('type', 'COLLEGE')->count();
        $totalCentral = OrganizationUnit::where('type', 'CENTRAL')->count();

        return view('admin.org_units', compact('orgUnits', 'totalOrgs', 'totalCampuses', 'totalColleges', 'totalCentral'));
    }

    // Contact Settings & Inquiries Management
    public function contactSettings(Request $request)
    {
        $this->checkAuth();
        
        $settings = SiteSetting::where('setting_group', 'contact')
            ->orderBy('id', 'asc')
            ->get();
            
        $perPage = $this->getPerPage($request, 20);
        $inquiries = ContactInquiry::orderBy('created_at', 'desc')->paginate($perPage);

        return view('admin.contact_settings', compact('settings', 'inquiries'));
    }

    public function contactSettingsUpdate(Request $request)
    {
        $this->checkAuth();

        $inputs = $request->except(['_token']);

        foreach ($inputs as $key => $value) {
            SiteSetting::where('setting_key', $key)->update([
                'setting_value' => $value,
                'updated_at' => now(),
            ]);
        }

        return back()->with('success', 'บันทึกการตั้งค่าข้อมูลติดต่อสอบถามเรียบร้อยแล้ว');
    }

    public function contactInquiryStatus($id, $status)
    {
        $this->checkAuth();

        if (in_array($status, ['NEW', 'READ', 'RESPONDED'])) {
            ContactInquiry::where('id', $id)->update([
                'status' => $status,
                'updated_at' => now(),
            ]);
        }

        return back()->with('success', 'อัปเดตสถานะข้อความสอบถามเรียบร้อยแล้ว');
    }

    public function contactInquiryDelete($id)
    {
        $this->checkAuth();

        ContactInquiry::where('id', $id)->delete();

        return back()->with('success', 'ลบข้อความสอบถามเรียบร้อยแล้ว');
    }

    private function checkAuth()
    {
        if (!Session::has('admin_user')) {
            abort(redirect()->route('login'));
        }
    }
}
