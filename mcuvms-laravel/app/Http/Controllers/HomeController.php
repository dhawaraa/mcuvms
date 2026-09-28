<?php

namespace App\Http\Controllers;

use App\Models\OrganizationUnit;
use App\Models\NewsArticle;
use App\Models\MeditationCalendar;
use App\Models\UgBatch;
use App\Models\UgRegistration;
use App\Models\GradStudent;
use App\Models\PublicRegistration;
use App\Models\SiteSetting;
use App\Models\ContactInquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $orgUnits = OrganizationUnit::where('is_active', 1)
            ->orderBy('id', 'asc')
            ->get();

        $recentNews = NewsArticle::with('organizationUnit')
            ->where('status', 'PUBLISHED')
            ->orderBy('is_pinned', 'desc')
            ->orderBy('published_at', 'desc')
            ->limit(8)
            ->get();

        // ดึงกำหนดการและปฏิทินปฏิบัติธรรมที่เปิดรับสมัคร (จาก UgBatch และ MeditationCalendar)
        $batchQuery = UgBatch::with(['organizationUnit', 'registrations'])
            ->where('status', 'OPEN');

        if ($request->filled('filter_org')) {
            $batchQuery->where('org_unit_id', $request->input('filter_org'));
        }

        $openBatches = $batchQuery->orderBy('start_date', 'asc')->get();

        return view('portal.index', compact('orgUnits', 'recentNews', 'openBatches'));
    }

    public function newsIndex(Request $request)
    {
        $query = NewsArticle::with('organizationUnit')
            ->where('status', 'PUBLISHED');

        if ($request->filled('category')) {
            $query->where('category', $request->input('category'));
        }

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->input('search') . '%');
        }

        if ($request->filled('org_unit_id')) {
            $query->where('org_unit_id', $request->input('org_unit_id'));
        }

        $newsList = $query->orderBy('is_pinned', 'desc')
            ->orderBy('published_at', 'desc')
            ->paginate(9);

        $orgUnits = OrganizationUnit::where('is_active', 1)->orderBy('name_th')->get();

        return view('portal.news_index', compact('newsList', 'orgUnits'));
    }

    public function newsDetail(Request $request, $id = null)
    {
        // Support /news/{id}, /news_detail.php?id=1, or legacy /news_detail.php?1
        if (!$id) {
            $id = $request->query('id');
        }

        if (!$id) {
            // Check if query string is just numeric like ?1
            $queryString = $request->getQueryString();
            if ($queryString && is_numeric($queryString)) {
                $id = (int)$queryString;
            } else {
                // Check if any query keys are numeric
                foreach ($request->query() as $key => $val) {
                    if (is_numeric($key)) {
                        $id = (int)$key;
                        break;
                    }
                }
            }
        }

        if (!$id) {
            return redirect()->route('news.index');
        }

        $news = NewsArticle::with('organizationUnit')
            ->where('status', 'PUBLISHED')
            ->findOrFail($id);

        // Increment views
        DB::table('news_articles')->where('id', $id)->increment('views');
        $news->views += 1;

        $relatedNews = NewsArticle::with('organizationUnit')
            ->where('status', 'PUBLISHED')
            ->where('id', '!=', $id)
            ->orderBy('published_at', 'desc')
            ->limit(4)
            ->get();

        return view('portal.news_detail', compact('news', 'relatedNews'));
    }

    public function verifyCertificate(Request $request)
    {
        $type = $request->query('type');
        $code = $request->query('code');

        $result = null;
        $isValid = false;

        if ($type === 'ug') {
            $record = UgRegistration::with(['batch.organizationUnit', 'organizationUnit'])
                ->where('registration_no', $code)
                ->first();

            if ($record && $record->status === 'COMPLETED') {
                $isValid = true;
                $result = [
                    'type' => 'UG',
                    'title' => 'หนังสือรับรองการปฏิบัติวิปัสสนากรรมฐาน (หลักสูตรปริญญาตรี 10 วัน)',
                    'code' => $record->registration_no,
                    'student_code' => $record->student_code,
                    'name' => ($record->prefix ?? '') . $record->first_name . ' ' . ($record->last_name ?? ''),
                    'faculty' => $record->faculty ?? '-',
                    'major' => $record->major ?? '-',
                    'org_unit' => $record->organizationUnit->name_th ?? 'มหาวิทยาลัยมหาจุฬาลงกรณราชวิทยาลัย',
                    'details' => 'โครงการ: ' . ($record->batch->title ?? '-') . ' (ปีการศึกษา ' . ($record->batch->academic_year ?? '-') . ')',
                    'date' => $record->updated_at ? \Carbon\Carbon::parse($record->updated_at)->format('d/m/Y') : '-',
                    'status' => 'ผ่านเกณฑ์สมบูรณ์ (Verified)',
                    'score' => $record->evaluation_score ?? 100,
                ];
            }
        } elseif ($type === 'grad') {
            $record = GradStudent::with('organizationUnit')
                ->where('student_code', $code)
                ->orWhere('student_id', $code)
                ->first();

            if ($record && $record->submission_status === 'APPROVED') {
                $isValid = true;
                $levelTh = $record->degree_level === 'DOCTORAL' ? 'ปริญญาเอก (45 วัน)' : 'ปริญญาโท (30 วัน)';
                $result = [
                    'type' => 'GRAD',
                    'title' => 'หนังสือรับรองผลการสะสมวันปฏิบัติวิปัสสนากรรมฐาน ระดับบัณฑิตศึกษา (' . $levelTh . ')',
                    'code' => 'GRAD-CERT-' . ($record->student_code ?? $record->student_id),
                    'student_code' => $record->student_code ?? $record->student_id,
                    'name' => ($record->prefix ?? '') . ($record->full_name ?? ($record->first_name . ' ' . $record->last_name)),
                    'faculty' => $record->faculty ?? '-',
                    'major' => $record->major ?? ($record->program_name ?? '-'),
                    'org_unit' => $record->organizationUnit->name_th ?? 'บัณฑิตวิทยาลัย มจร',
                    'details' => 'สะสมวันปฏิบัติธรรมครบถ้วนตามเกณฑ์ ' . $record->target_days . ' วัน (สะสมจริง ' . $record->accumulated_days . ' วัน)',
                    'date' => $record->approved_at ? \Carbon\Carbon::parse($record->approved_at)->format('d/m/Y') : \Carbon\Carbon::now()->format('d/m/Y'),
                    'status' => 'อนุมัติผ่านเกณฑ์สมบูรณ์ (Verified)',
                    'score' => 'ผ่านเกณฑ์มาตรฐานหลักสูตร',
                ];
            }
        }

        return view('portal.certificate_verify', compact('result', 'isValid', 'code', 'type'));
    }

    public function contact()
    {
        $settings = SiteSetting::getByGroup('contact');
        return view('portal.contact', compact('settings'));
    }

    public function contactSubmit(Request $request)
    {
        $validated = $request->validate([
            'sender_name' => 'required|string|max:150',
            'phone' => 'required|string|max:50',
            'email' => 'nullable|email|max:150',
            'category' => 'required|string|max:100',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:3000',
        ]);

        $ticketNo = 'INQ-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -4));

        ContactInquiry::create([
            'ticket_no' => $ticketNo,
            'sender_name' => $validated['sender_name'],
            'phone' => $validated['phone'],
            'email' => $validated['email'] ?? null,
            'category' => $validated['category'],
            'subject' => $validated['subject'],
            'message' => $validated['message'],
            'status' => 'NEW',
        ]);

        return back()->with('success', 'ส่งข้อความติดต่อสอบถามเรียบร้อยแล้ว เจ้าหน้าที่จะติดต่อกลับโดยเร็ว')
                     ->with('ticket_no', $ticketNo);
    }
}

