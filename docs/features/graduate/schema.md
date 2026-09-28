# Data Model & Validations (`schema.md`)
## Feature: Graduate Meditation Credit & Approval System (`graduate`)
**สคริปต์ฐานข้อมูลและ Validation สำหรับ Laravel 11 / MariaDB 10.6**

---

### 1. โครงสร้างฐานข้อมูล (Laravel Database Migrations)

#### 1.1 ตารางนิสิตระดับบัณฑิตศึกษา (`grad_students`)
```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('grad_students', function (Blueprint $table) {
            $table->id();
            $table->string('student_code', 20)->unique();
            $table->string('citizen_id', 13)->nullable();
            $table->string('prefix', 50)->default('พระ');
            $table->string('first_name', 100);
            $table->string('last_name', 100);
            $table->enum('degree_level', ['MASTER', 'DOCTORAL'])->default('MASTER');
            $table->integer('target_days')->default(30); // 30 (โท) หรือ 45 (เอก)
            $table->integer('accumulated_days')->default(0);
            $table->foreignId('organization_unit_id')->constrained('organization_units')->onDelete('cascade');
            $table->string('faculty_name', 150)->nullable();
            $table->string('program_name', 150)->nullable();
            $table->enum('submission_status', [
                'ACCUMULATING', 
                'READY_TO_SUBMIT', 
                'SUBMITTED', 
                'RETURNED_FOR_EDIT', 
                'APPROVED', 
                'REJECTED'
            ])->default('ACCUMULATING');
            $table->string('completion_code', 50)->nullable()->unique();
            $table->timestamp('approved_at')->nullable();
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->text('rejection_note')->nullable();
            $table->timestamps();

            $table->index(['organization_unit_id', 'submission_status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('grad_students');
    }
};
```

#### 1.2 ตารางประวัติการเข้าปฏิบัติธรรมย่อย (`grad_credit_entries`)
```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('grad_credit_entries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('grad_student_id')->constrained('grad_students')->onDelete('cascade');
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('days_earned');
            $table->string('temple_name', 255);
            $table->string('master_name', 150);
            $table->string('province', 100);
            $table->string('attachment_path', 500)->nullable();
            $table->string('attachment_name', 255)->nullable();
            $table->text('remarks')->nullable();
            $table->timestamps();

            $table->index('grad_student_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('grad_credit_entries');
    }
};
```

---

### 2. โมเดล Eloquent (Eloquent Models)

#### 2.1 โมเดล `GradStudent` (`app/Models/GradStudent.php`)
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GradStudent extends Model
{
    protected $fillable = [
        'student_code',
        'citizen_id',
        'prefix',
        'first_name',
        'last_name',
        'degree_level',
        'target_days',
        'accumulated_days',
        'organization_unit_id',
        'faculty_name',
        'program_name',
        'submission_status',
        'completion_code',
        'approved_at',
        'approved_by',
        'rejection_note',
    ];

    public function organizationUnit(): BelongsTo
    {
        return $this->belongsTo(OrganizationUnit::class);
    }

    public function creditEntries(): HasMany
    {
        return $this->hasMany(GradCreditEntry::class);
    }
}
```

#### 2.2 โมเดล `GradCreditEntry` (`app/Models/GradCreditEntry.php`)
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GradCreditEntry extends Model
{
    protected $fillable = [
        'grad_student_id',
        'start_date',
        'end_date',
        'days_earned',
        'temple_name',
        'master_name',
        'province',
        'attachment_path',
        'attachment_name',
        'remarks',
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(GradStudent::class, 'grad_student_id');
    }
}
```

---

### 3. ข้อกำหนด Validation ใน Laravel (Form Requests & Rules)

#### 3.1 ตรวจสอบการเพิ่มประวัติย่อย (`StoreCreditEntryRequest.php`)
```php
public function rules(): array
{
    return [
        'student_code' => ['required', 'string', 'exists:grad_students,student_code'],
        'start_date'   => ['required', 'date'],
        'end_date'     => ['required', 'date', 'after_or_equal:start_date'],
        'temple_name'  => ['required', 'string', 'max:255'],
        'master_name'  => ['required', 'string', 'max:150'],
        'province'     => ['required', 'string', 'max:100'],
        'attachment'   => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:10240'], // สูงสุด 10MB
        'remarks'      => ['nullable', 'string', 'max:1000'],
    ];
}
```

#### 3.2 ตรวจสอบการพิจารณาอนุมัติโดยเจ้าหน้าที่
```php
public function rules(): array
{
    return [
        'student_id'     => ['required', 'integer', 'exists:grad_students,id'],
        'action'         => ['required', 'in:APPROVE,REJECT'],
        'rejection_note' => ['required_if:action,REJECT', 'nullable', 'string', 'max:1000'],
    ];
}
```

---

### 4. พจนานุกรมภาษา (Language Files)

บันทึกไว้ใน `lang/th/graduate.php`:
```php
return [
    'title'            => 'ระบบสะสมวันปฏิบัติกรรมฐาน ระดับบัณฑิตศึกษา',
    'subtitle'         => 'เกณฑ์: ปริญญาโท 30 วัน / ปริญญาเอก 45 วัน',
    'search_ph'        => 'ป้อนรหัสนิสิต เช่น 6601201001',
    'accumulated'      => 'สะสมแล้ว :current จาก :target วัน',
    'remaining'        => 'ยังขาดอีก :days วัน จึงจะครบเกณฑ์ยื่นคำขอ',
    'ready_to_submit'  => 'สะสมวันครบตามเกณฑ์แล้ว พร้อมยื่นขออนุมัติ',
    'submit_btn'       => 'ยื่นขออนุมัติผลสะสมวัน (Final Submission)',
    'locked_msg'       => 'คำร้องของท่านอยู่ระหว่างการตรวจสอบ (ข้อมูลถูกล็อก)',
    'approved_msg'     => 'ผ่านการอนุมัติเรียบร้อย รหัสรับรอง: :code',
    'returned_msg'     => 'คำร้องถูกส่งกลับแก้ไข: :note',
];
```
