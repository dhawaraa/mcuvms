<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('grad_students', function (Blueprint $table) {
            // ข้อมูลส่วนตัวตาม e-Document
            if (!Schema::hasColumn('grad_students', 'buddhist_name')) {
                $table->string('buddhist_name', 100)->nullable()->after('last_name')->comment('ฉายาทางธรรม');
            }
            if (!Schema::hasColumn('grad_students', 'age')) {
                $table->integer('age')->nullable()->after('buddhist_name')->comment('อายุ');
            }
            if (!Schema::hasColumn('grad_students', 'vassa')) {
                $table->integer('vassa')->nullable()->default(0)->after('age')->comment('พรรษา');
            }
            if (!Schema::hasColumn('grad_students', 'nationality')) {
                $table->string('nationality', 50)->default('ไทย')->after('citizen_id')->comment('สัญชาติ');
            }

            // ข้อมูลที่อยู่และการติดต่อ
            if (!Schema::hasColumn('grad_students', 'address')) {
                $table->text('address')->nullable()->after('program_name')->comment('ที่อยู่/บ้านเลขที่/หมู่/ถนน');
            }
            if (!Schema::hasColumn('grad_students', 'subdistrict')) {
                $table->string('subdistrict', 100)->nullable()->after('address')->comment('ตำบล/แขวง');
            }
            if (!Schema::hasColumn('grad_students', 'district')) {
                $table->string('district', 100)->nullable()->after('subdistrict')->comment('อำเภอ/เขต');
            }
            if (!Schema::hasColumn('grad_students', 'province')) {
                $table->string('province', 100)->nullable()->after('district')->comment('จังหวัด');
            }
            if (!Schema::hasColumn('grad_students', 'postcode')) {
                $table->string('postcode', 10)->nullable()->after('province')->comment('รหัสไปรษณีย์');
            }
            if (!Schema::hasColumn('grad_students', 'phone')) {
                $table->string('phone', 30)->nullable()->after('postcode')->comment('เบอร์โทรศัพท์');
            }

            // ไฟล์หลักฐานแนบ e-Document 4 รายการ
            if (!Schema::hasColumn('grad_students', 'photo_path')) {
                $table->string('photo_path', 500)->nullable()->after('phone')->comment('รูปถ่าย 2x2 นิ้ว');
            }
            if (!Schema::hasColumn('grad_students', 'interview_record_path')) {
                $table->string('interview_record_path', 500)->nullable()->after('photo_path')->comment('PDF ใบบันทึกส่ง-สอบอารมณ์');
            }
            if (!Schema::hasColumn('grad_students', 'attendance_record_path')) {
                $table->string('attendance_record_path', 500)->nullable()->after('interview_record_path')->comment('PDF ใบลงเวลาปฏิบัติธรรม');
            }
            if (!Schema::hasColumn('grad_students', 'slip_path')) {
                $table->string('slip_path', 500)->nullable()->after('attendance_record_path')->comment('สลิปโอนเงินค่าธรรมเนียม');
            }
            if (!Schema::hasColumn('grad_students', 'transfer_date')) {
                $table->date('transfer_date')->nullable()->after('slip_path')->comment('วันที่โอนเงิน');
            }
            if (!Schema::hasColumn('grad_students', 'transfer_time')) {
                $table->time('transfer_time')->nullable()->after('transfer_date')->comment('เวลาที่โอนเงิน');
            }

            // ไฟล์เอกสารตอบกลับจากหลังบ้าน (Admin Upload Response)
            if (!Schema::hasColumn('grad_students', 'cert_th_path')) {
                $table->string('cert_th_path', 500)->nullable()->after('approved_at')->comment('ไฟล์ใบรับรองภาษาไทย');
            }
            if (!Schema::hasColumn('grad_students', 'cert_en_path')) {
                $table->string('cert_en_path', 500)->nullable()->after('cert_th_path')->comment('ไฟล์ใบรับรองภาษาอังกฤษ');
            }
            if (!Schema::hasColumn('grad_students', 'receipt_path')) {
                $table->string('receipt_path', 500)->nullable()->after('cert_en_path')->comment('ไฟล์ใบเสร็จรับเงิน');
            }
            if (!Schema::hasColumn('grad_students', 'assessment_doc_path')) {
                $table->string('assessment_doc_path', 500)->nullable()->after('receipt_path')->comment('ไฟล์ใบประเมิน บฑ. ๒๑');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('grad_students', function (Blueprint $table) {
            $table->dropColumn([
                'buddhist_name', 'age', 'vassa', 'nationality',
                'address', 'subdistrict', 'district', 'province', 'postcode', 'phone',
                'photo_path', 'interview_record_path', 'attendance_record_path', 'slip_path',
                'transfer_date', 'transfer_time',
                'cert_th_path', 'cert_en_path', 'receipt_path', 'assessment_doc_path'
            ]);
        });
    }
};
