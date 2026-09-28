# AI Coding Instructions & Rules (`agent.md`)
## Feature: Graduate Meditation Credit & Approval System (`graduate`)
**แนวทางการพัฒนาสำหรับ Laravel 11 + PHP 8.4 + MariaDB + Blade Templates**

เอกสารนี้ระบุ **กฎเหล็ก ข้อห้าม และแนวทางปฏิบัติ** สำหรับ AI Coding Assistant หรือทีมพัฒนา เมื่อต้องเขียน ทดสอบ หรือแก้ไขโค้ดในโมดูล `graduate` บนโปรเจกต์ `mcuvms-laravel/`

---

### 1. กฎเหล็กการจัดวางโครงสร้างโค้ด (Laravel 11 Architecture Rules)

1. **โครงสร้างโฟลเดอร์หลัก:**
   - โค้ด Backend ต้องอยู่ในไดเรกทอรี `mcuvms-laravel/`:
     - **Eloquent Models:** `mcuvms-laravel/app/Models/` (เช่น `GradStudent.php`, `GradCreditEntry.php`, `OrganizationUnit.php`)
     - **Controllers:** `mcuvms-laravel/app/Http/Controllers/` (เช่น `GraduateController.php`, `AdminController.php`)
     - **Form Requests & Validations:** `mcuvms-laravel/app/Http/Requests/`
     - **Blade Views:** `mcuvms-laravel/resources/views/`
       - หน้า Portal: `resources/views/portal/grad_progress.blade.php`
       - หน้า Admin: `resources/views/admin/grad_approvals.blade.php`
     - **Routing:** `mcuvms-laravel/routes/web.php`
2. **ความเข้ากันได้กับโฮสติ้งของมหาวิทยาลัย:**
   - ระบบต้องรันได้อย่างสมบูรณ์บน **Apache/2.4 + PHP 8.4 + MariaDB 10.6**
   - การเรียกใช้ Route ต้องรองรับทั้ง Path มาตรฐาน และ Path จำลองแบบ `.php` เช่น `/grad_progress.php` และ `/admin/grad_approvals.php`
3. **การเข้าถึงฐานข้อมูล:**
   - ใช้ **Eloquent ORM** หรือ **Query Builder** ผ่าน Facade `DB`
   - ห้ามเขียน Raw SQL ที่ไม่ปลอดภัยต่อ SQL Injection (ให้ใช้ Parameter Binding เสมอ)

---

### 2. กฎการตรวจสอบข้อมูล (Validation) และความปลอดภัย

1. **การตรวจสอบ Input (Form Requests & Controller Validation):**
   - ทุก Request ที่มีการเปลี่ยนแปลงข้อมูล (POST/PUT/DELETE) ต้องตรวจ CSRF Token (`@csrf`)
   - ต้องตรวจสอบความถูกต้องของข้อมูลผ่าน `$request->validate([...])` หรือ Form Request เสมอ:
     - วันที่เริ่มต้นและวันที่สิ้นสุด: `end_date >= start_date`
     - การอัปโหลดไฟล์: ตรวจสอบ MIME Type (`pdf,jpg,jpeg,png`) และขนาดไม่เกิน 10MB
2. **Lock Engine Guard (กฎเหล็กธุรกิจ):**
   - เมื่อนิสิตกดยื่นคำขอขั้นสุดท้าย (`submitFinal`):
     - ต้องตรวจสอบทางฝั่ง Controller เสมอว่า `$student->accumulated_days >= $student->target_days` (ป.โท 30 วัน, ป.เอก 45 วัน)
     - ห้ามพึ่งพาการ Disable ปุ่มบนหน้าจอเพียงอย่างเดียว
     - เมื่อสถานะเปลี่ยนเป็น `SUBMITTED` ให้ปฏิเสธการแก้ไขหรือลบรายการย่อยทันที
3. **การควบคุมสิทธิ์ผู้ดูแลระบบ (Admin Authorization):**
   - หน้าจอการอนุมัติและการคัดกรองเอกสาร ต้องผ่านการตรวจ Session ผู้ดูแลระบบ (`Session::has('admin_user')`) ก่อนเสมอ

---

### 3. มาตรฐานการออกแบบหน้าจอและสไตล์ (Design & Icons)

1. **ระบบไอคอน (Lucide Icons บังคับ 100%):**
   - ห้ามใช้อิโมจิในจุดที่เป็น Functional Icon
   - ต้องโหลด Script: `<script src="https://unpkg.com/lucide@latest"></script>` ใน `<head>`
   - ใช้แท็ก `<i data-lucide="..."></i>`
   - เรียกฟังก์ชัน `lucide.createIcons();` ก่อนปิดแท็ก `</body>` เสมอ
2. **โทนสีธรรมชาติ Earth Tones / Organic Palette (ห้ามใช้สีฉูดฉาด):**
   - **เขียวมะกอก (Olive):** `#5A6B47` / `#7B8D65` (ปุ่มหลัก, ป้ายสำเร็จ, หัวข้อย่อย)
   - **เขียวป่าลึก (Deep Forest):** `#2C3E2D` / `#243325` (Sidebar ผู้ดูแลระบบ, แบนเนอร์, การ์ดสำคัญ)
   - **น้ำตาลอิฐ / ดินเผา (Clay / Terracotta):** `#C86D51` / `#A85238` (สีเน้น, ป้ายสถานะรออนุมัติ, รหัสการสมัคร)
   - **ทรายและก้อนหินอ่อน (Sand & Stone):** `#F7F5EE`, `#FAF8F2`, `#EAE5D9` (พื้นหลังและการ์ดเนื้อหา)
   - **เปลือกไม้ (Bark):** `#4A3B32` / `#2D2A26` (ข้อความหลัก)
3. **การออกแบบเชิง Organic:**
   - ใช้ความโค้งมนสไตล์ธรรมชาติ (`rounded-2xl`, `rounded-3xl`)
   - ใช้การ์ดกึ่งโปร่งใส (Glassmorphism ละมุน) พร้อมเส้นขอบหินอ่อนธรรมชาติ (`border-[#EAE5D9]`)

---

### 4. การจัดการภาษา (Internationalization - i18n)

1. **โครงสร้างภาษาของ Laravel:**
   - ข้อความที่ต้องแปลจัดเก็บไว้ใน `mcuvms-laravel/lang/th/` และ `mcuvms-laravel/lang/en/`
   - ในไฟล์ Blade Template เรียกใช้ผ่าน `{{ __('graduate.title') }}` หรือฟังก์ชันแปลภาษาของระบบ
   - การแสดงวันที่ภาษาไทยต้องแปลงปีพุทธศักราช (พ.ศ.) ให้ถูกต้องตามบริบทมหาวิทยาลัยสงฆ์

---

### 5. แนวทางปฏิบัติเมื่อปรับปรุงโค้ด (Maintenance Workflow)

1. **ล้าง Cache ของ Blade เมื่อแก้ไข View เสมอ:**
   - หลังจากเพิ่มหรือแก้ไขไฟล์ใน `resources/views/` ให้รันคำสั่ง:
     ```bash
     docker exec MCUVMS php artisan view:clear
     ```
2. **การทดสอบความถูกต้อง:**
   - ทดสอบการเข้าถึง URL ทั้งสองรูปแบบ (`/grad_progress` และ `/grad_progress.php`)
   - ตรวจสอบว่าโค้ดสี `#5A6B47`, `#2C3E2D`, `#C86D51` และไอคอน Lucide แสดงผลครบถ้วน
