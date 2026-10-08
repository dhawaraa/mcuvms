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
        Schema::create('donations', function (Blueprint $table) {
            $table->id();
            $table->string('donation_no', 50)->unique(); // DON-20261001-XXXX
            $table->string('donor_name', 255); // ชื่อ-นามสกุล ผู้บริจาค
            $table->string('tax_id', 20)->nullable(); // เลขประจำตัวผู้เสียภาษี / เลขบัตรประชาชน
            $table->boolean('is_tax_deductible')->default(false); // ติ๊กว่าต้องการลดหย่อนภาษีหรือไม่
            $table->decimal('amount', 12, 2); // จำนวนเงินบริจาค (บาท)
            $table->string('bank_account', 100)->nullable(); // บัญชีธนาคารปลายทางที่โอนเข้า
            $table->date('transfer_date')->nullable(); // วันที่โอนเงิน
            $table->string('transfer_time', 10)->nullable(); // เวลาที่โอนเงิน
            $table->string('slip_path', 255)->nullable(); // พาธไฟล์แนบสลิปโอนเงิน
            $table->string('phone', 50)->nullable(); // เบอร์โทรศัพท์ติดต่อ
            $table->string('email', 150)->nullable(); // อีเมลรับใบอนุโมทนา/หลักฐาน
            $table->text('address')->nullable(); // ที่อยู่สำหรับออกใบเสร็จ/ใบอนุโมทนาบัตร
            $table->string('purpose', 255)->nullable(); // วัตถุประสงค์การบริจาค เช่น ค่ายานพาหนะ, ภัตตาหาร/น้ำปานะ, กองทุนวิปัสสนา
            $table->text('note')->nullable(); // ข้อความคำอธิษฐานจิต/หมายเหตุเพิ่มเติม
            $table->enum('status', ['PENDING', 'VERIFIED', 'REJECTED'])->default('PENDING'); // สถานะการตรวจสอบ
            $table->text('admin_notes')->nullable(); // หมายเหตุเจ้าหน้าที่/เหตุผลการปฏิเสธ
            $table->unsignedBigInteger('verified_by')->nullable(); // ผู้ตรวจสอบ
            $table->timestamp('verified_at')->nullable(); // วันเวลาที่ตรวจสอบ
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donations');
    }
};
