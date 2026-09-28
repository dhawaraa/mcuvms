# Undergraduate Feature Specification (Laravel 11 Edition)
## โมดูลที่ 1: ระบบลงทะเบียนปฏิบัติกรรมฐาน ระดับปริญญาตรี (`undergraduate`)
**เกณฑ์หลักสูตร:** ปฏิบัติธรรม **ปีละ 10 วัน ต่อเนื่อง 4 ปีการศึกษา (รวม 40 วัน)** ครอบคลุม 52 ส่วนงานทั่วประเทศ

---

### 1. โครงสร้างฐานข้อมูล (Laravel Database Migrations & Eloquent)

ตารางข้อมูลใน MariaDB 10.6 ออกแบบเพื่อรองรับการลงทะเบียนของนิสิต ป.ตรี และการตรวจสอบการเข้าอบรม:

#### 1.1 ตารางรอบผลัดการปฏิบัติธรรม (`ug_batches`)
```php
Schema::create('ug_batches', function (Blueprint $table) {
    $table->id();
    $table->foreignId('organization_unit_id')->constrained('organization_units')->onDelete('cascade');
    $table->integer('academic_year'); // เช่น 2567
    $table->integer('batch_no');      // ผลัดที่ 1, 2, ...
    $table->string('title', 255);     // เช่น ผลัดที่ 1/2567 (นิสิตชั้นปีที่ 1)
    $table->date('start_date');
    $table->date('end_date');
    $table->integer('max_quota')->default(100);
    $table->integer('current_registered')->default(0);
    $table->timestamps();

    $table->index(['organization_unit_id', 'academic_year']);
});
```

#### 1.2 ตารางการลงทะเบียนรายบุคคล (`ug_registrations`)
```php
Schema::create('ug_registrations', function (Blueprint $table) {
    $table->id();
    $table->foreignId('ug_batch_id')->constrained('ug_batches')->onDelete('cascade');
    $table->foreignId('organization_unit_id')->constrained('organization_units')->onDelete('cascade');
    $table->string('registration_no', 50)->unique(); // UG-2567-XXXX
    $table->string('student_code', 20);
    $table->string('prefix', 50)->default('นาย');
    $table->string('first_name', 100);
    $table->string('last_name', 100);
    $table->integer('study_year'); // ชั้นปีที่ 1-4
    $table->string('faculty_name', 150)->nullable();
    $table->string('major_name', 150)->nullable();
    $table->string('phone', 20);
    $table->string('email', 255)->nullable();
    $table->uuid('checkin_token')->unique(); // สำหรับสแกน QR Code หน้างาน
    $table->enum('status', ['REGISTERED', 'CHECKED_IN', 'COMPLETED', 'FAILED'])->default('REGISTERED');
    $table->integer('evaluation_score')->nullable(); // คะแนนการปฏิบัติ
    $table->timestamp('checked_in_at')->nullable();
    $table->timestamps();

    $table->index(['organization_unit_id', 'student_code']);
});
```

---

### 2. วงจรสถานะและกฎเกณฑ์ทางธุรกิจ (Lifecycle & Business Rules)

1. **วงจรสถานะการอบรม:**
   - `REGISTERED`: นิสิตลงทะเบียนสำเร็จ ได้รับรหัส `registration_no` และ QR Code ประจำตัว
   - `CHECKED_IN`: เจ้าหน้าที่/พระวิปัสสนาจารย์สแกน QR Code รับรายงานตัวเข้าค่ายปฏิบัติธรรม
   - `COMPLETED`: เข้าร่วมครบ 10 วัน และสอบอารมณ์ผ่านการประเมิน (สะสมวันสำเร็จ 10 วันประจำปีการศึกษานั้น)
   - `FAILED`: ขาดเกินกำหนด หรือไม่ผ่านการประเมิน
2. **Campus-Binding Rule (กฎเหล็กวิทยาเขต):**
   - นิสิตต้องลงทะเบียนรอบผลัดของวิทยาเขตตนเองเท่านั้น โดยตรวจผ่าน `organization_unit_id`
3. **Attendance 100% Policy:**
   - ต้องเข้าปฏิบัติครบทั้ง 10 วัน หากขาดเกินกำหนดจะปรับสถานะเป็น `FAILED` ทันที

---

### 3. เส้นทางและสิทธิ์การใช้งาน (Routing & Access Control)

- **Portal (นิสิต):**
  - `GET /ug_register` หรือ `/ug_register.php`: ฟอร์มลงทะเบียนนิสิต ป.ตรี พร้อมเลือก 52 ส่วนงาน
  - `POST /ug_register`: ตรวจสอบความถูกต้องและสร้างใบสมัครพร้อม QR Code
- **Admin Console (เจ้าหน้าที่ & อาจารย์):**
  - `GET /admin/ug_students` หรือ `/admin/ug_students.php`: ตารางตรวจสอบรายชื่อนิสิตและการลงทะเบียน
  - `GET /admin/ug/checkin/{id}`: จุดเช็คชื่อ / จำลอง QR Check-in หน้างาน
  - `GET /admin/ug/complete/{id}`: บันทึกคะแนนและประเมินผ่านเกณฑ์ 10 วัน

---

### 4. สไตล์และการแสดงผล (Design & Icons)

- **สไตล์สี:** ใช้ **Earth Tones / Organic Palette** อย่างเคร่งครัด:
  - เขียวมะกอก (`#5A6B47`) / เขียวป่าลึก (`#2C3E2D`) / น้ำตาลอิฐ (`#C86D51`)
- **ระบบไอคอน:** ใช้ **Lucide Icons** 100% (`compass`, `graduation-cap`, `qr-code`, `check-check`, `clock`)
