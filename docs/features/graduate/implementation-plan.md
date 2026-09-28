# Step-by-Step Implementation Plan (`implementation-plan.md`)
## Feature: Graduate Meditation Credit & Approval System (`graduate`)
**แผนการพัฒนาสำหรับ Laravel 11 Framework (Apache / PHP 8.4 / MariaDB)**

---

### Phase 1: Database Migration & Model Layer
- [x] **Task 1.1:** สร้าง Migration `create_grad_students_table` และ `create_grad_credit_entries_table`
- [x] **Task 1.2:** สร้าง Eloquent Model `GradStudent` และ `GradCreditEntry` พร้อมตั้งค่าความสัมพันธ์ `belongsTo` และ `hasMany`
- [x] **Task 1.3:** รัน Migration: `docker exec MCUVMS php artisan migrate`
- [x] **Task 1.4:** ใส่ข้อมูลเริ่มต้น (Seed Data) สำหรับนิสิต ป.โท (สะสม 25 วัน) และ ป.เอก (สะสม 45 วัน ยื่นรออนุมัติ) ใน `DatabaseSeeder.php`

---

### Phase 2: Controller & Business Logic
- [x] **Task 2.1:** พัฒนา `GraduateController.php`:
  - Action `progress`: ค้นหานิสิตด้วย `student_code` และคำนวณวันคงเหลือ
  - Action `storeEntry`: รับฟอร์มเพิ่มรายการย่อย, อัปโหลดไฟล์, คำนวณวัน `(end - start) + 1` และอัปเดต `accumulated_days`
  - Action `submitFinal`: **Lock Engine Guard** — ตรวจสอบว่าวันสะสมครบตามเกณฑ์ (ป.โท 30 วัน, ป.เอก 45 วัน) ก่อนเปลี่ยนสถานะเป็น `SUBMITTED`
- [x] **Task 2.2:** พัฒนา `AdminController.php`:
  - Action `gradApprovals`: แสดงรายการนิสิตที่ยื่นคำขอรออนุมัติ
  - Action `approveGrad`: เปลี่ยนสถานะเป็น `APPROVED` พร้อมออกรหัส `completion_code` (เช่น `MCU-GRD-2567-001`)
  - Action `rejectGrad`: เปลี่ยนสถานะเป็น `REJECTED` หรือ `RETURNED_FOR_EDIT` พร้อมบันทึกเหตุผล
- [x] **Task 2.3:** ผูก Route ใน `routes/web.php` ทั้งแบบ Clean URL และ Legacy `.php`

---

### Phase 3: Portal UI (นิสิตบัณฑิตศึกษา)
- [x] **Task 3.1:** ปรับแต่งหน้า `resources/views/portal/grad_progress.blade.php`:
  - นำชุดสี **Earth Tones / Organic Palette** (`#5A6B47`, `#2C3E2D`, `#C86D51`, `#F7F5EE`) มาใช้เต็มรูปแบบ
  - ปรับระบบไอคอนเป็น **Lucide Icons** ทั้งหมด (`compass`, `graduation-cap`, `calendar`, `clock`, `check`, `lock`)
  - แสดงผล Progress Bar และเกณฑ์วันสะสม 30 วัน / 45 วัน
  - ปุ่ม "ยื่นขออนุมัติผล" ล็อกอัตโนมัติหากวันยังไม่ครบเกณฑ์
  - กล่องแสดงสถานะเมื่อส่งคำขอแล้ว (มีป้ายล็อกข้อมูล)

---

### Phase 4: Admin Console UI (เจ้าหน้าที่ & คณะกรรมการ)
- [x] **Task 4.1:** ปรับแต่งหน้า `resources/views/admin/grad_approvals.blade.php`:
  - ใช้ Sidebar แบบ Deep Forest & Olive (`#243325` / `#5A6B47`)
  - ปรับไอคอนเป็น Lucide Icons
  - ตารางแสดงรายการคำขอ พร้อมป้ายสถานะ (ผ่านเกณฑ์, รออนุมัติ, ตีกลับแก้ไข)
  - ฟอร์มปุ่มกด "อนุมัติผล" และ "ส่งกลับแก้ไข"

---

### Phase 5: Testing & Verification
- [x] **Task 5.1:** ทดสอบการค้นหาประวัตินิสิตผ่านเว็บเบราว์เซอร์
- [x] **Task 5.2:** ทดสอบการล็อกปุ่มยื่นคำขอในกรณีที่วันสะสมยังไม่ถึง 30 หรือ 45 วัน
- [x] **Task 5.3:** ทดสอบการอนุมัติและส่งกลับแก้ไขจากหน้า Admin Console
- [x] **Task 5.4:** ล้าง Cache ของ Blade: `docker exec MCUVMS php artisan view:clear`
