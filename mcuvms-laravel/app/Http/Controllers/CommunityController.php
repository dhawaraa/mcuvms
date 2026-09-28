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
            'citizen_id' => 'required|string|size:13',
            'prefix' => 'required|string',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'gender' => 'required|string',
            'age' => 'nullable|integer',
            'phone' => 'required|string',
            'email' => 'nullable|email',
            'province' => 'nullable|string',
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

        $status = ($event->confirmed_count < $event->max_quota) ? 'CONFIRMED' : 'WAITING_LIST';
        $fullName = trim(($validated['prefix'] ?? '') . ' ' . $validated['first_name'] . ' ' . $validated['last_name']);
        
        $queueNo = PublicRegistration::where('event_id', $event->id)->count() + 1;
        $regNo = 'PUB-' . date('Ymd') . '-' . str_pad($queueNo, 4, '0', STR_PAD_LEFT);

        DB::transaction(function () use ($validated, $event, $status, $fullName, $queueNo) {
            PublicRegistration::create([
                'event_id' => $event->id,
                'citizen_id' => $validated['citizen_id'],
                'prefix' => $validated['prefix'],
                'full_name' => $fullName,
                'gender' => $validated['gender'],
                'age' => $validated['age'] ?? 0,
                'phone' => $validated['phone'],
                'province' => $validated['province'],
                'dietary_restriction' => $validated['food_type'] ?? null,
                'congenital_disease' => $validated['special_needs'] ?? null,
                'queue_no' => $queueNo,
                'status' => $status,
                'registered_at' => now(),
            ]);

            if ($status === 'CONFIRMED') {
                $event->increment('confirmed_count');
            } else {
                $event->increment('waiting_count');
            }
        });

        $msg = ($status === 'CONFIRMED') 
            ? 'ลงทะเบียนได้รับสิทธิ์เข้าร่วมโครงการเรียบร้อยแล้ว!' 
            : 'ขณะนี้จำนวนที่นั่งเต็มแล้ว ท่านได้รับการจัดอยู่ในบัญชีรายชื่อสำรอง (Waiting List)';

        return back()->with('success', $msg)->with('regSuccess', $regNo);
    }
}
