# Guidelines for AI Coding Assistants (MCUVMS Laravel Edition)

ระบบนี้คือ **ระบบสารสนเทศการปฏิบัติวิปัสสนากรรมฐาน มหาวิทยาลัยมหาจุฬาลงกรณราชวิทยาลัย (MCUVMS)**  
ครอบคลุม 52 ส่วนงานทั่วประเทศ พัฒนาบนพื้นฐานของ **Laravel 11, PHP 8.4, MariaDB 10.6, Apache 2.4, และ Tailwind CSS (Blade Views)**  
รองรับการนำไปติดตั้งใช้งานจริงบนโครงสร้างพื้นฐานโฮสติ้งของมหาวิทยาลัย (`Apache/2.4.63 (FreeBSD) PHP/8.4.8 MariaDB`)

---

## 1. สถาปัตยกรรมระบบและโครงสร้างไดเรกทอรี (Laravel Architecture)
โค้ดและส่วนประกอบทั้งหมดของระบบอยู่ที่ `mcuvms-laravel/` โดยมีโครงสร้างหลักดังนี้:
- **Models:** `app/Models/` (Eloquent Models เช่น `OrganizationUnit`, `UgBatch`, `UgRegistration`, `GradStudent`, `GradCreditEntry`, `PublicEvent`, `PublicRegistration`, `User`)
- **Controllers:** `app/Http/Controllers/` (แยกกลุ่มอย่างชัดเจน: `HomeController`, `UndergraduateController`, `GraduateController`, `CommunityController`, `AdminController`)
- **Routes:** `routes/web.php`
  - ต้องรองรับการเข้าถึงทั้ง **Clean URL** (เช่น `/grad_progress`) และ **Legacy Compatibility URL** (เช่น `/grad_progress.php`, `/login.php`, `/admin/dashboard.php`) เพื่อความเข้ากันได้ 100%
- **Views (Blade):** `resources/views/`
  - ส่วนหน้าบ้าน (Portal): `resources/views/portal/`
  - ส่วนหลังบ้าน (Admin Console): `resources/views/admin/`

---

## 2. กฎการตรวจสอบข้อมูลและความปลอดภัย (Validation & Security)
1. **CSRF Protection:** แบบฟอร์ม HTML/Blade ทุกฟอร์มที่ส่งข้อมูลด้วย method `POST`, `PUT`, หรือ `DELETE` ต้องใส่ `@csrf` เสมอ
2. **Form Validation:** ทำการตรวจสอบ Input ผ่าน `$request->validate([...])` หรือ Laravel Form Request เสมอ:
   - ตรวจสอบความถูกต้องของช่วงวันที่ (`after_or_equal:start_date`)
   - ตรวจสอบประเภทและขนาดไฟล์แนบ (`mimes:pdf,jpg,jpeg,png` สูงสุดไม่เกิน 10MB)
3. **Admin Authentication Guard:**
   - หน้าผู้ดูแลระบบ (`/admin/*`) ต้องตรวจสอบสิทธิ์ผ่าน Middleware หรือ Session `admin_user` เสมอ หากไม่มีให้ Redirect ไปที่ `/login.php`
4. **Lock Engine (กฎเหล็กทางธุรกิจ):**
   - **โมดูลบัณฑิตศึกษา (ป.โท 30 วัน / ป.เอก 45 วัน):** ห้ามอนุญาตให้ยื่นคำขออนุมัติเด็ดขาดหาก `accumulated_days < target_days` และเมื่อสถานะเป็น `SUBMITTED` ให้ล็อกห้ามแก้ไขหรือลบรายการย่อย
   - **โมดูลปริญญาตรี (10 วัน/ปี รวม 40 วัน):** นิสิตต้องลงทะเบียนเฉพาะโครงการของวิทยาเขตต้นสังกัดเท่านั้น (`Campus-Binding Rule`)

---

## 3. ระบบไอคอน (Icon System Directive)
- **บังคับใช้ Lucide Icons 100%:** ห้ามใช้อิโมจิในจุดที่เป็น Functional UI / Buttons / Badges
- **การติดตั้ง:** ต้องมี `<script src="https://unpkg.com/lucide@latest"></script>` ใน `<head>`
- **การเรียกใช้:** ใช้แท็ก `<i data-lucide="icon-name" class="w-4 h-4"></i>` (ดูชื่อไอคอนได้จาก https://lucide.dev/icons/)
- **การ Render:** ต้องเรียกใช้ฟังก์ชัน `lucide.createIcons();` ก่อนปิดแท็ก `</body>` ในไฟล์ Blade ทุกหน้า

---

## 4. ระบบสีและอัตลักษณ์ (Earth Tones / Organic Palette)
ระบบทั้งหน้าบ้าน (Portal) และหลังบ้าน (Admin Console) ต้องใช้สไตล์ **Earth Tones / Organic (โทนธรรมชาติ)** ที่ได้แรงบันดาลใจจากผืนดิน ป่าไม้ หิน และทราย สื่อถึงความสงบ ปลอดภัย และเป็นมิตรกับธรรมชาติ ห้ามใช้สีนีออนฉูดฉาด:

| สีธรรมชาติ | รหัสสี (HEX) | การใช้งานในระบบ |
| :--- | :--- | :--- |
| **เขียวมะกอก (Olive)** | `#5A6B47`, `#7B8D65` | สีนำ (Primary), ปุ่มหลัก, ป้ายสำเร็จ, หัวข้อเน้น |
| **เขียวป่าลึก (Deep Forest)** | `#2C3E2D`, `#243325` | แถบข้าง Admin Sidebar, การ์ดแบนเนอร์, สีหัวตาราง |
| **น้ำตาลอิฐ / ดินเผา (Clay / Terracotta)** | `#C86D51`, `#A85238` | สีเน้น (Accent), ป้ายรออนุมัติ/ที่นั่งเต็ม, รหัสการสมัคร |
| **ทรายและก้อนหินอ่อน (Sand & Stone)** | `#F7F5EE`, `#FAF8F2`, `#EAE5D9` | สีพื้นหลัง (Background), เส้นขอบการ์ด และตารางข้อมูล |
| **เปลือกไม้ (Bark)** | `#4A3B32`, `#2D2A26` | ข้อความและเนื้อหาหลัก อ่านง่าย ละมุนตา |

---

## 5. กฎเหล็กโครงสร้างและระยะห่างหน้าจอ (Layout & Spacing Standards)
### 5.1 ระบบหลังบ้าน (Admin Console Layout Standard)
**ทุกหน้าในระบบหลังบ้าน (Admin Console) ต้องยึดมาตรฐานระยะห่างเดียวกับหน้า Dashboard (`/admin/dashboard.php`) 100% เสมอ:**
1. **แท็กพื้นที่ทำงานหลัก (`<main>`):**
   - **บังคับใช้คลาส:** `<main class="flex-grow p-6 md:p-10 overflow-y-auto">`
   - **ห้ามใส่ `max-w-7xl` หรือ `mx-auto`** บน `<main>` เด็ดขาด เพื่อให้พื้นที่กว้างเต็มสัดส่วนและมี Padding บน ล่าง ซ้าย ขวา เสมอกันทุกหน้าจอ
2. **ส่วนหัวของหน้า (Header Section):**
   - **บังคับใช้คลาส:** `<div class="flex flex-col sm:flex-row justify-between sm:items-center pb-6 mb-8 border-b border-[#D5CEBC] gap-4">`
   - มีเส้นคั่นล่างสีหินอ่อน (`border-b border-[#D5CEBC]`) และระยะห่างใต้หัวเรื่องเสมอ (`pb-6 mb-8`)
3. **การสร้างหน้าหลังบ้านใหม่ในอนาคต:**
   - ต้องคัดลอกโครงสร้าง `<aside>` และ `<main class="flex-grow p-6 md:p-10 overflow-y-auto">` นี้เป็นพิมพ์เขียวมาตรฐานเสมอ

### 5.2 ระบบหน้าบ้าน (Portal Layout Standard)
**ทุกหน้าในระบบหน้าบ้าน (Portal) ต้องจัดความกว้างเนื้อหาให้เสมอกับส่วนหัว (Navigation Bar) เสมอ:**
1. **บังคับใช้คลาสความกว้างมาตรฐาน:**
   - `<nav>` / `<header>`: `<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">`
   - `<main>`: `<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full flex-grow">`
   - **ห้ามบีบเนื้อหาแคบลง** ด้วยคลาสเช่น `max-w-4xl`, `max-w-5xl` หรือ `max-w-6xl` ในคอนเทนเนอร์หลัก เพื่อให้แนวขอบเนื้อหาเสมอกับเมนูด้านบนทุกหน้า

---

## 6. โมดูลข่าวสารประชาสัมพันธ์ (News & Announcements Directive)
- **Model & Database:** ใช้ `App\Models\NewsArticle` (ตาราง `news_articles`) โดยระบุ `public $timestamps = false;` (ตารางมีเฉพาะ `created_at` และ `published_at`)
- **การเข้าถึง URL:** รองรับทั้ง `/news/{id}`, `/news.php`, และ Legacy Compatibility `/news_detail.php?id=1` หรือ `/news_detail.php?1`
- **การจัดการตารางข่าวสารในหลังบ้าน (`/admin/news.php`):**
  - คอลัมน์สถานะ วันที่ ยอดวิว และปุ่มดำเนินการต้องมี `whitespace-nowrap` และจัดตำแหน่งด้วย `align-middle`
  - คอลัมน์หัวข้อข่าวและเนื้อหาย่อต้องใช้ `line-clamp-1` ป้องกันการตกขอบหรือตัดบรรทัดผิดรูปทรง

---

## 7. การจัดการแคชและการทำงานกับ Docker (Developer Workflow)
1. **เมื่อแก้ไขไฟล์ Blade Template:**
   - ต้องล้าง Compiled Views เสมอเพื่อให้การเปลี่ยนแปลงแสดงผลทันที:
     ```bash
     docker exec MCUVMS php artisan view:clear
     ```
2. **การอัปเดตโครงสร้างฐานข้อมูล:**
   - รัน Migration และ Seeder ผ่าน Container:
     ```bash
     docker exec MCUVMS php artisan migrate
     docker exec MCUVMS php artisan db:seed
     ```
3. **การตรวจสอบความถูกต้อง:**
   - เข้าตรวจสอบหน้าบ้าน: [http://localhost:8086/](http://localhost:8086/)
   - เข้าตรวจสอบหลังบ้าน: [http://localhost:8086/login.php](http://localhost:8086/login.php) (Admin: `admin` / `password`)
