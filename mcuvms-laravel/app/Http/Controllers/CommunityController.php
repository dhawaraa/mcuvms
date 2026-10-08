<?php

namespace App\Http\Controllers;

use App\Models\OrganizationUnit;
use App\Models\PublicEvent;
use App\Models\PublicRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CommunityController extends Controller
{
    public function create()
    {
        $events = PublicEvent::with('organizationUnit')
            ->where('status', 'OPEN')
            ->orderBy('start_date', 'asc')
            ->get();

        $orgUnits = OrganizationUnit::orderedForSelect()->get();

        return view('portal.public_register', compact('events', 'orgUnits'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'event_id' => 'required|integer',
            'applicant_type' => 'nullable|string',
            'student_id' => 'nullable|string|max:30',
            'degree_level' => 'nullable|string|max:50',
            'faculty' => 'nullable|string|max:150',
            'org_unit_id' => 'nullable|integer',
            'program_name' => 'nullable|string|max:200',
            'citizen_id' => 'required|string|min:8|max:20',
            'prefix' => 'required|string',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'buddhist_name' => 'nullable|string',
            'gender' => 'nullable|string',
            'age' => 'nullable|integer|min:1',
            'vassa' => 'nullable|integer|min:0',
            'phone' => 'required|string',
            'email' => 'nullable|email',
            'line_id' => 'nullable|string|max:100',
            'address' => 'nullable|string',
            'subdistrict' => 'nullable|string',
            'district' => 'nullable|string',
            'province' => 'nullable|string',
            'postal_code' => 'nullable|string|max:10',
            'room_info' => 'nullable|string|max:150',
            'vehicle_info' => 'nullable|string|max:150',
            'food_type' => 'required|string',
            'special_needs' => 'nullable|string',
        ]);

        $event = PublicEvent::findOrFail($validated['event_id']);

        $existing = PublicRegistration::where('event_id', $event->id)
            ->where('citizen_id', $validated['citizen_id'])
            ->first();

        if ($existing) {
            return back()->with('error', 'ท่านได้ลงทะเบียนในโครงการนี้แล้ว เลขที่ใบสมัคร: ' . $existing->registration_no . ' (' . $existing->status . ')')
                         ->with('regSuccess', $existing->registration_no);
        }

        $status = 'PENDING';
        
        $buddhistPart = !empty($validated['buddhist_name']) ? ' (' . trim($validated['buddhist_name']) . ')' : '';
        $fullName = trim(($validated['prefix'] ?? '') . ' ' . $validated['first_name'] . ' ' . $validated['last_name'] . $buddhistPart);

        // Derive gender if not provided
        $gender = $validated['gender'] ?? null;
        if (!$gender) {
            $p = trim($validated['prefix'] ?? '');
            if (in_array($p, ['นาง', 'นางสาว', 'แม่ชี', 'อุบาสิกา', 'ด.ญ.'])) {
                $gender = 'FEMALE';
            } elseif (in_array($p, ['นาย', 'พระ', 'พระภิกษุ', 'พระมหา', 'พระครู', 'พระอธิการ', 'สามเณร', 'อุบาสก', 'ด.ช.'])) {
                $gender = 'MALE';
            } else {
                $gender = 'OTHER';
            }
        }
        
        $queueNo = PublicRegistration::where('event_id', $event->id)->count() + 1;
        $regNo = 'PUB-' . date('Ymd') . '-' . str_pad($queueNo, 4, '0', STR_PAD_LEFT);

        DB::transaction(function () use ($validated, $event, $status, $fullName, $queueNo, $regNo, $gender) {
            PublicRegistration::create([
                'registration_no' => $regNo,
                'event_id' => $event->id,
                'applicant_type' => $validated['applicant_type'] ?? 'PEOPLE',
                'student_id' => ($validated['applicant_type'] ?? '') === 'STUDENT' ? ($validated['student_id'] ?? null) : null,
                'degree_level' => ($validated['applicant_type'] ?? '') === 'STUDENT' ? ($validated['degree_level'] ?? null) : null,
                'faculty' => ($validated['applicant_type'] ?? '') === 'STUDENT' ? ($validated['faculty'] ?? null) : null,
                'org_unit_id' => ($validated['applicant_type'] ?? '') === 'STUDENT' ? ($validated['org_unit_id'] ?? null) : null,
                'program_name' => ($validated['applicant_type'] ?? '') === 'STUDENT' ? ($validated['program_name'] ?? null) : null,
                'citizen_id' => $validated['citizen_id'],
                'prefix' => $validated['prefix'],
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'buddhist_name' => $validated['buddhist_name'] ?? null,
                'full_name' => $fullName,
                'gender' => $gender,
                'age' => $validated['age'] ?? 0,
                'vassa' => $validated['vassa'] ?? 0,
                'phone' => $validated['phone'],
                'email' => $validated['email'] ?? null,
                'line_id' => $validated['line_id'] ?? null,
                'address' => $validated['address'] ?? null,
                'subdistrict' => $validated['subdistrict'] ?? null,
                'district' => $validated['district'] ?? null,
                'province' => $validated['province'] ?? null,
                'postal_code' => $validated['postal_code'] ?? null,
                'room_info' => $validated['room_info'] ?? null,
                'vehicle_info' => $validated['vehicle_info'] ?? null,
                'dietary_restriction' => $validated['food_type'] ?? null,
                'congenital_disease' => $validated['special_needs'] ?? null,
                'queue_no' => $queueNo,
                'status' => $status,
                'registered_at' => now(),
            ]);
        });

        $msg = 'บันทึกใบสมัครเข้าร่วมโครงการเรียบร้อยแล้ว! ข้อมูลของท่านอยู่ระหว่างเจ้าหน้าที่ตรวจสอบคุณสมบัติและจัดสรรที่พัก (สถานะ: รอการตรวจสอบ)';

        return back()->with('success', $msg)->with('regSuccess', $regNo);
    }

    public function checkStatus(Request $request)
    {
        $search = trim($request->input('search', ''));
        $registrations = collect();

        if ($search) {
            // Strip any dashes or spaces for phone comparison (e.g., 0818889999)
            $cleanDigits = preg_replace('/[^0-9]/', '', $search);

            $registrations = PublicRegistration::with(['event.organizationUnit', 'organizationUnit'])
                ->where(function ($q) use ($search, $cleanDigits) {
                    $q->where('registration_no', $search)
                      ->orWhere('phone', $search);
                    if ($cleanDigits) {
                        $q->orWhere(DB::raw("REPLACE(REPLACE(phone, '-', ''), ' ', '')"), $cleanDigits);
                    }
                })
                ->orderBy('registered_at', 'desc')
                ->get();
        }

        $orgUnits = OrganizationUnit::orderedForSelect()->get();

        return view('portal.public_check', compact('search', 'registrations', 'orgUnits'));
    }

    public function updateRegistration(Request $request, $id)
    {
        $reg = PublicRegistration::findOrFail($id);

        // Security check: Only allow editing if status is PENDING or REJECTED
        if (!in_array($reg->status, ['PENDING', 'REJECTED'])) {
            return back()->with('error', 'ไม่สามารถแก้ไขข้อมูลได้ เนื่องจากใบสมัครได้รับการอนุมัติหรืออยู่ในสถานะที่ไม่เปิดให้แก้ไข');
        }

        $validated = $request->validate([
            'applicant_type' => 'nullable|string',
            'student_id' => 'nullable|string|max:30',
            'degree_level' => 'nullable|string|max:50',
            'faculty' => 'nullable|string|max:150',
            'org_unit_id' => 'nullable|integer',
            'program_name' => 'nullable|string|max:200',
            'prefix' => 'required|string',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'buddhist_name' => 'nullable|string',
            'age' => 'nullable|integer|min:1',
            'vassa' => 'nullable|integer|min:0',
            'phone' => 'required|string',
            'email' => 'nullable|email',
            'line_id' => 'nullable|string|max:100',
            'address' => 'nullable|string',
            'subdistrict' => 'nullable|string',
            'district' => 'nullable|string',
            'province' => 'nullable|string',
            'postal_code' => 'nullable|string|max:10',
            'room_info' => 'nullable|string|max:150',
            'vehicle_info' => 'nullable|string|max:150',
            'food_type' => 'required|string',
            'special_needs' => 'nullable|string',
        ]);

        $buddhistPart = !empty($validated['buddhist_name']) ? ' (' . trim($validated['buddhist_name']) . ')' : '';
        $fullName = trim(($validated['prefix'] ?? '') . ' ' . $validated['first_name'] . ' ' . $validated['last_name'] . $buddhistPart);

        $p = trim($validated['prefix'] ?? '');
        $gender = null;
        if (in_array($p, ['นาง', 'นางสาว', 'แม่ชี', 'อุบาสิกา', 'ด.ญ.'])) {
            $gender = 'FEMALE';
        } elseif (in_array($p, ['นาย', 'พระ', 'พระภิกษุ', 'พระมหา', 'พระครู', 'พระอธิการ', 'สามเณร', 'อุบาสก', 'ด.ช.'])) {
            $gender = 'MALE';
        }

        $updateData = [
            'applicant_type' => $validated['applicant_type'] ?? 'PEOPLE',
            'student_id' => ($validated['applicant_type'] ?? '') === 'STUDENT' ? ($validated['student_id'] ?? null) : null,
            'degree_level' => ($validated['applicant_type'] ?? '') === 'STUDENT' ? ($validated['degree_level'] ?? null) : null,
            'faculty' => ($validated['applicant_type'] ?? '') === 'STUDENT' ? ($validated['faculty'] ?? null) : null,
            'org_unit_id' => ($validated['applicant_type'] ?? '') === 'STUDENT' ? ($validated['org_unit_id'] ?? null) : null,
            'program_name' => ($validated['applicant_type'] ?? '') === 'STUDENT' ? ($validated['program_name'] ?? null) : null,
            'prefix' => $validated['prefix'],
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'buddhist_name' => $validated['buddhist_name'] ?? null,
            'full_name' => $fullName,
            'gender' => $gender ?? $reg->gender ?? 'OTHER',
            'age' => $validated['age'] ?? 0,
            'vassa' => $validated['vassa'] ?? 0,
            'phone' => $validated['phone'],
            'email' => $validated['email'] ?? null,
            'line_id' => $validated['line_id'] ?? null,
            'address' => $validated['address'] ?? null,
            'subdistrict' => $validated['subdistrict'] ?? null,
            'district' => $validated['district'] ?? null,
            'province' => $validated['province'] ?? null,
            'postal_code' => $validated['postal_code'] ?? null,
            'room_info' => $validated['room_info'] ?? null,
            'vehicle_info' => $validated['vehicle_info'] ?? null,
            'dietary_restriction' => $validated['food_type'] ?? null,
            'congenital_disease' => $validated['special_needs'] ?? null,
        ];

        // If previously REJECTED, reset status back to PENDING for re-examination
        if ($reg->status === 'REJECTED') {
            $updateData['status'] = 'PENDING';
            $updateData['reject_reason'] = null;
        }

        $reg->update($updateData);

        return redirect()->route('public.check', ['search' => $reg->phone])
            ->with('success', 'แก้ไขข้อมูลใบสมัคร (' . $reg->registration_no . ') เรียบร้อยแล้ว');
    }
}

