<?php

namespace App\Http\Controllers;

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

        return view('portal.public_register', compact('events'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'event_id' => 'required|integer',
            'applicant_type' => 'nullable|string',
            'student_id' => 'nullable|string|max:30',
            'citizen_id' => 'required|string|min:8|max:20',
            'prefix' => 'required|string',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'buddhist_name' => 'nullable|string',
            'gender' => 'required|string',
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
        
        $queueNo = PublicRegistration::where('event_id', $event->id)->count() + 1;
        $regNo = 'PUB-' . date('Ymd') . '-' . str_pad($queueNo, 4, '0', STR_PAD_LEFT);

        DB::transaction(function () use ($validated, $event, $status, $fullName, $queueNo, $regNo) {
            PublicRegistration::create([
                'registration_no' => $regNo,
                'event_id' => $event->id,
                'applicant_type' => $validated['applicant_type'] ?? 'PEOPLE',
                'student_id' => $validated['student_id'] ?? null,
                'citizen_id' => $validated['citizen_id'],
                'prefix' => $validated['prefix'],
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'buddhist_name' => $validated['buddhist_name'] ?? null,
                'full_name' => $fullName,
                'gender' => $validated['gender'],
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
}
