<?php

namespace App\Http\Controllers;

use App\Models\GradStudent;
use App\Models\GradCreditEntry;
use Illuminate\Http\Request;

class GraduateController extends Controller
{
    public function index(Request $request)
    {
        $searchCode = trim($request->get('student_code', ''));
        $student = null;
        $credits = [];

        if (!empty($searchCode)) {
            $student = GradStudent::with('organizationUnit')
                ->where('student_code', $searchCode)
                ->orWhere('student_id', $searchCode)
                ->first();

            if ($student) {
                $credits = GradCreditEntry::where('student_id', $student->id)
                    ->orWhere('student_id', $student->student_id)
                    ->orderBy('start_date', 'desc')
                    ->get();
            }
        }

        return view('portal.grad_progress', compact('student', 'credits', 'searchCode'));
    }

    public function finalSubmit(Request $request)
    {
        $studentId = (int)$request->input('student_id');
        $student = GradStudent::findOrFail($studentId);

        if (in_array($student->submission_status, ['DRAFT', 'ACCUMULATING']) && $student->accumulated_days >= $student->target_days) {
            $student->update([
                'submission_status' => 'SUBMITTED',
                'submitted_at' => now(),
            ]);
            return redirect()->route('grad.progress', ['student_code' => $student->student_code ?? $student->student_id, 'status' => 'submitted']);
        }

        return back()->with('error', 'ไม่สามารถส่งคำขอได้เนื่องจากวันสะสมยังไม่ครบเกณฑ์หรือข้อมูลถูกล็อกแล้ว');
    }

    public function certificate($code)
    {
        $student = GradStudent::with('organizationUnit')
            ->where('student_code', $code)
            ->orWhere('student_id', $code)
            ->firstOrFail();

        // ตรวจสอบสถานะการอนุมัติ (ต้อง APPROVED)
        if ($student->submission_status !== 'APPROVED') {
            return redirect()->route('grad.progress', ['student_code' => $code])
                ->with('error', 'ยังไม่สามารถออกหนังสือรับรองได้เนื่องจากคำขอยังไม่ได้รับการอนุมัติสมบูรณ์');
        }

        $verifyUrl = route('cert.verify', ['type' => 'grad', 'code' => $student->student_code ?? $student->student_id]);

        return view('portal.certificate_grad', compact('student', 'verifyUrl'));
    }
}

