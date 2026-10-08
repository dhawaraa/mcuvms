# MCUVMS Project Handoff Document
**ระบบสารสนเทศการปฏิบัติวิปัสสนากรรมฐาน มหาวิทยาลัยมหาจุฬาลงกรณราชวิทยาลัย (MCUVMS)**  
*บันทึกสถานะงานและการส่งมอบ (Handoff Summary) สำหรับการพัฒนาต่อในรอบถัดไป*

> **ข้อมูลการส่งมอบล่าสุด (Handoff Metadata):**
> - **วันที่และเวลาบันทึกล่าสุด:** วันศุกร์ที่ 25 กันยายน พ.ศ. 2569 เวลา 18:15 น. (2026-09-25 18:15:00+07:00)
> - **สถานะปัจจุบัน:** ปรับปรุงปฏิทินปฏิบัติธรรมหน้าแรก (Interactive Monthly Grid + รายการกิจกรรมย่อย), จัดเรียง Navbar หน้าบ้าน, ระบบติดต่อสอบถามหน้าบ้าน/หลังบ้าน, ย้ายจัดการส่วนงาน/สิทธิ์/ติดต่อสอบถามเข้ากลุ่มการตั้งค่า, ลบคำว่า SAR และข้อความรกรุงรังทั่วระบบ, และเพิ่มสถิติแผนภูมิกราฟแท่ง (Bar Chart) ระดับส่วนงานในหน้า Dashboard สมบูรณ์ 100%
> - **เวอร์ชันระบบ:** Laravel 11.x (PHP 8.4.8 / Apache 2.4.63 / MariaDB 10.6.21)

---

### 🕒 บันทึกไทม์ไลน์การทำงาน (Activity & Milestone Logs)

| วันที่ / เวลา (Log Timestamp) | ขั้นตอนที่ดำเนินการ (Milestone) | ผลลัพธ์และสิ่งที่สำเร็จ (Outputs & Artifacts) | สถานะ |
| :--- | :--- | :--- | :--- |
| **2026-09-23 10:15 - 11:30** | **Step 1: System Blueprints & Analysis** | - สรุปพิมพ์เขียวสถาปัตยกรรมระบบ 52 ส่วนงานลงไฟล์ [MCUVMS_ARCHITECTURE_BLUEPRINT.md](file:///Users/dhawara/Desktop/WebDEV/0-MCU/MCUVMS/MCUVMS_ARCHITECTURE_BLUEPRINT.md)<br>- วิเคราะห์ความเข้ากันได้กับโฮสติ้งจริงของมหาวิทยาลัย (`Apache/2.4 + PHP/8.4 + MariaDB`) | `Done` |
| **2026-09-23 11:30 - 13:45** | **Step 2: Transition to Laravel 11** | - สร้างโครงสร้างโปรเจกต์ `mcuvms-laravel/` แทนที่ Next.js เดิม (สำรองไว้ใน `_nextjs_backup/`)<br>- คอนฟิก Apache DocumentRoot ไปที่ `/var/www/html/public`<br>- ปรับฐานข้อมูล MariaDB พอร์ต `3310` พร้อมรัน Migration & Seed 52 ส่วนงาน | `Done` |
| **2026-09-23 13:45 - 15:30** | **Step 3: Core Business Modules (1, 2, 3)** | - พัฒนา Model, Controller และ Route รองรับทั้ง Clean URL และ `.php`<br>- โมดูล 1: นิสิต ป.ตรี 10 วัน/ปี รวม 40 วัน<br>- โมดูล 2: บัณฑิตศึกษา ป.โท 30 วัน / ป.เอก 45 วัน (พร้อม Lock Engine)<br>- โมดูล 3: ภาคประชาชน บริการวิชาการแก่สังคม | `Done` |
| **2026-09-23 15:30 - 17:05** | **Step 4: Earth Tones Theme & Lucide Icons** | - ปรับระบบไอคอนทั่วทั้งระบบ 100% เป็น [Lucide Icons](https://lucide.dev/icons/) (`data-lucide="..."`)<br>- ออกแบบชุดสี **Earth Tones / Organic (โทนธรรมชาติ)**: เขียวมะกอก (`#5A6B47`), เขียวป่าลึก (`#2C3E2D`), น้ำตาลอิฐ (`#C86D51`), ทรายและก้อนหินอ่อน (`#F7F5EE`, `#EAE5D9`)<br>- ปรับใช้ครบถ้วนทั้ง 9 หน้า (หน้าบ้าน 4 หน้า + หลังบ้าน 5 หน้า) | `Done` |
| **2026-09-23 17:05 - 17:40** | **Step 5: AGENTS.md & Blueprints Alignment** | - **ปรับปรุง [AGENTS.md](file:///Users/dhawara/Desktop/WebDEV/0-MCU/MCUVMS/AGENTS.md) เป็นเวอร์ชัน Laravel 11 ฉบับสมบูรณ์**<br>- พิมพ์เขียว 6 ฉบับโมดูลบัณฑิตศึกษาใน [docs/features/graduate/](file:///Users/dhawara/Desktop/WebDEV/0-MCU/MCUVMS/docs/features/graduate/) สอดคล้องกับ Laravel 11 100% | `Done` |
| **2026-09-23 17:40 - 17:45** | **Step 6: Clean up Non-Laravel Artifacts** | - **ลบไฟล์/โฟลเดอร์ที่ไม่เกี่ยวกับ Laravel 100%** (`node_modules`, `.next`, `src/`, `_nextjs_backup`, `public_html`, `.dependency-cruiser.cjs`, `next-env.d.ts`, `.nvmrc`, `.npmrc`)<br>- ปรับปรุง `.env`, `.env.example`, และ `.gitignore` ให้เป็นมาตรฐาน Laravel + Docker | `Done` |
| **2026-09-24 15:00 - 15:30** | **Step 7: Annual Schedules & Central Officer RBAC** | - **ระบบจัดการกำหนดการประจำปีการศึกษา (`UgBatch`)**: จัดการกำหนดการปฏิบัติธรรม 10 วัน ปีละ 1 ครั้งตามปีการศึกษา<br>- **บทบาท `CENTRAL_OFFICER`**: เจ้าหน้าที่ส่วนกลางจัดการได้ 52 ส่วนงาน<br>- ย้ายเมนูกำหนดการโครงการออกมาเป็นเมนูหลักต่อจากภาพรวมระบบ | `Done` |
| **2026-09-24 15:30 - 16:30** | **Step 8: CSV Import & Student Verification** | - สร้างตาราง `ug_master_students` และ Eloquent Model `UgMasterStudent`<br>- พัฒนาระบบนำเข้าไฟล์ CSV พร้อมดาวน์โหลดไฟล์ Template (`/admin/ug_import.php`)<br>- พัฒนาระบบตรวจสอบรหัสนิสิตหน้าบ้านแบบ Real-time (`/ug/lookup-student`) ดึงข้อมูลสังกัดอัตโนมัติและล็อกให้เลือกลงทะเบียนเฉพาะโครงการของวิทยาเขตตนเองเท่านั้น | `Done` |
| **2026-09-24 16:30 - 17:15** | **Step 9: MCU Official Logo & Favicon Integration** | - นำภาพโลโก้ทางการ มจร ติดตั้งที่ `public/images/mcu-logo.png`<br>- ติดตั้ง Favicon และ Apple Touch Icon ใน Blade Views ครบทุกหน้า<br>- ปรับใช้โลโก้บน Navigation Bar หน้าบ้าน, ส่วนหัว Sidebar หลังบ้าน, และหน้าเข้าสู่ระบบ | `Done` |
| **2026-09-24 17:15 - 17:50** | **Step 10: Standardized Layout Width Alignment** | - ปรับขอบเขตความกว้างเนื้อหาหน้าบ้านทุกหน้าเป็น `max-w-7xl mx-auto px-4 sm:px-6 lg:px-8` เสมอกับ Navigation Bar ไม่บีบแคบ<br>- ปรับชื่อปุ่มแอดมินใน Header หน้าบ้านเหลือเพียง "แผงควบคุม" เพื่อความกระชับ | `Done` |
| **2026-09-24 17:50 - 18:15** | **Step 11: News & Announcements Module** | - พัฒนาระบบข่าวสารประชาสัมพันธ์ครบวงจร (`NewsArticle`)<br>- ส่วนหลังบ้าน: เมนู `/admin/news.php` รองรับ CRUD, ปักหมุด (Pin), ตัวกรองหมวดหมู่ และจัดตารางไม่ให้ตกขอบ/ตกบรรทัด<br>- ส่วนหน้าบ้าน: หน้ารวมข่าว (`/news.php`) และหน้ารายละเอียด (`/news/{id}`, `/news_detail.php?id=1` / `/news_detail.php?1`) พร้อมระบบนับยอดวิวและแชร์ลิงก์ | `Done` |
| **2026-09-25 11:45 - 11:52** | **Step 12: Mobile QR Scanner & Attendance / Registrar Export** | - **ระบบ Mobile QR Scanner ([/admin/ug_scanner.php](http://localhost:8086/admin/ug_scanner.php))**: สแกน QR บัตร E-Ticket นิสิตผ่านกล้องมือถือ/แท็บเล็ต มีเสียง Beep สรุปยอดเช็คชื่อ Real-time พร้อมช่องกรอกรหัสฉุกเฉิน<br>- **ระบบพิมพ์ใบเซ็นชื่อ 10 วัน ([/admin/ug_attendance.php](http://localhost:8086/admin/ug_attendance.php))**: หน้า A4 Print-ready จัดคอลัมน์เซ็นชื่อวันที่ 1-10 พร้อมช่องลงนามพระวิปัสสนาจารย์<br>- **ระบบ Export ทะเบียน ([/admin/ug/export](http://localhost:8086/admin/ug/export))**: ส่งออกข้อมูลผลการปฏิบัติธรรมเป็นไฟล์ CSV/Excel พร้อม UTF-8 BOM รองรับภาษาไทย 100% | `Done` |
| **2026-09-25 11:53 - 11:58** | **Step 13: Collapsible Sidebar Submenus Component** | - สร้าง Component กลาง [admin/layouts/sidebar.blade.php](file:///Users/dhawara/Desktop/WebDEV/0-MCU/MCUVMS/mcuvms-laravel/resources/views/admin/layouts/sidebar.blade.php)<br>- **ระบบย่อ/ขยายเมนูย่อย (Collapsible Submenus)**: ยุบเมนูย่อยของโมดูล ป.ตรี ทั้ง 5 รายการ (กำหนดการ, นำเข้า CSV, ทะเบียน, สแกน QR, พิมพ์ใบเซ็นชื่อ) ไว้ใต้เมนูหลัก "ปฏิบัติธรรม ป.ตรี (40 วัน)" พร้อมลูกศรหมุนและเปิดค้างอัตโนมัติตามหน้าที่กำลังใช้งาน<br>- ปรับใช้ครบทุกหน้าในแผงควบคุมหลังบ้านทั้ง 7 หน้า | `Done` |
| **2026-09-25 14:00 - 15:30** | **Step 14: Interactive Calendar & Navbar Reorganization** | - **ปฏิทินปฏิบัติธรรมหน้าแรก**: ปรับเป็นแบบ Monthly Grid สวยงาม แสดงจุด/แท็กกิจกรรม พร้อมแผงลิสต์รายการทางขวาที่มีความสูงพอดีกับปฏิทิน เลื่อนดูโครงการในเดือนนั้นได้ และกดวันเพื่อดูรายละเอียดโครงการได้ทันที<br>- **จัดลำดับเมนู Navigation Bar หน้าบ้านตามคำขอ**:<br>1. ปฏิทินกำหนดการ<br>2. ระดับปริญญาตรี<br>3. ระดับบัณฑิตศึกษา<br>4. ประชาชนทั่วไป<br>5. ติดต่อสอบถาม | `Done` |
| **2026-09-25 15:30 - 16:30** | **Step 15: Public Retreat Pruning & Contact Inquiry Module** | - ปรับลดรายการตัวอย่างการลงทะเบียนประชาชนทั่วไปเหลือ 4-5 รายการที่กระชับและสมจริง<br>- **หน้าติดต่อสอบถามหน้าบ้าน ([/contact.php](http://localhost:8086/contact.php))**: แบบฟอร์มส่งข้อความสอบถาม พร้อมแผนที่และข้อมูลติดต่อ 52 ส่วนงาน<br>- **ระบบหลังบ้านจัดการข้อมูลติดต่อ ([/admin/contact_settings.php](http://localhost:8086/admin/contact_settings.php))**: เมนูตั้งค่าช่องทางติดต่อ เบอร์โทร อีเมล เวลาทำการ และกล่องข้อความผู้ติดต่อ (`SiteSetting` & `ContactInquiry`) | `Done` |
| **2026-09-25 16:30 - 17:30** | **Step 16: Admin Settings Grouping & UI Cleanup** | - **สร้างกลุ่มเมนู "การตั้งค่าระบบ (System Settings)" ใน Sidebar หลังบ้าน** รวมเมนูย่อย 3 รายการ:<br>1. รายชื่อส่วนงานภายใน มจร และรหัสย่อจังหวัด (`/admin/org_units.php`)<br>2. จัดการผู้ใช้งานและกำหนดสิทธิ์ (`/admin/users.php`)<br>3. ตั้งค่าระบบสำหรับติดต่อสอบถาม (`/admin/contact_settings.php`)<br>- **ตัดตารางส่วนงานที่ยาวและรกรุงรังออกจากหน้า Dashboard** ย้ายไปเป็นหน้าย่อยที่เข้าถึงได้ผ่านการ์ดและเมนูการตั้งค่า<br>- นำคำว่า "ครอบคลุม 52 ส่วนงานทั่วประเทศ" ออกจากทุกจุดที่ซ้ำซ้อนทั้งหน้าบ้านและหลังบ้าน | `Done` |
| **2026-09-25 17:30 - 17:52** | **Step 17: Removal of "SAR" Acronym Across System** | - ถอดคำว่า "SAR" / "รายงาน SAR" ออกจากหน้าบ้านและหลังบ้านทั้งหมด 100%<br>- ปรับใช้ข้อความภาษาไทย "บริการวิชาการแก่สังคม" และ "การประกันคุณภาพ" ที่สุภาพและเป็นทางการ (โดยคงฟอนต์ `Sarabun` ไว้อย่างถูกต้อง) | `Done` |
| **2026-09-25 17:52 - 18:05** | **Step 18: Campus Statistics Bar Chart on Dashboard** | - **เพิ่มแผนภูมิกราฟแท่ง (Bar Chart) จำแนกตามหน่วยงาน/ส่วนงาน** บนหน้า Dashboard หลังบ้าน ([/admin/dashboard.php](http://localhost:8086/admin/dashboard.php)) ด้วย Chart.js<br>- แสดงเปรียบเทียบ 3 กลุ่ม (ป.ตรี, บัณฑิตศึกษา, บริการวิชาการแก่สังคม) ตามอัตลักษณ์ Earth Tones พร้อมตารางสรุปข้อมูล | `Done` |
| **2026-10-02 21:00 - 23:00** | **Step 19: VPSMCU Rebranding & Rootless Podman Setup** | - ปรับชื่อระบบทั่วทั้งระบบและคอนเทนเนอร์เป็น **VPSMCU** (`vps.mcu.ac.th`)<br>- จัดการรันบน **Podman Rootless Container** (SELinux Compliant) 100%<br>- ปรับแต่งการย่อ/ขยายกลุ่มเมนู Sidebar หลังบ้านแบบ Accordion เพื่อคืนพื้นที่แสดงผล | `Done` |
| **2026-10-02 23:30 - 23:55** | **Step 20: Organization Directory & Master Data Refinement** | - **ลบ "วิทยาเขตสงขลา"** (`CAMPUS-SKA`) ออกจากฐานข้อมูลและ Master Data เนื่องจากไม่มีอยู่จริง<br>- **ยกระดับเป็น "วิทยาลัยสงฆ์สงขลา"** (`SANGHA-SKA`) ประเภท `SANGHA_COLLEGE`<br>- **แก้ไขตัวกรองวิทยาลัยสงฆ์** ให้กรองได้ครบ 28 แห่ง และเพิ่มตัวกรองประเภท **หน่วยวิทยบริการ** (`ACADEMIC_UNIT`)<br>- ปรับแต่งความเร็วหน้าเว็บ (`/admin/org_units.php`) ให้โหลดเร็วทันที | `Done` |
| **2026-10-05 17:45 - 18:05** | **Step 21: MCU Student Academic Fields in Public Module** | - เพิ่มฟิลด์กรณีเลือกสถานะผู้สมัครเป็น **นิสิต มจร (MCU Student)** ในหน้าลงทะเบียน ([/public_register.php](https://vps.mcu.ac.th/public_register.php)):<br>  1. ระดับการศึกษา (`degree_level` ป.ตรี, ป.โท, ป.เอก, ประกาศนียบัตร)<br>  2. คณะ (`faculty`)<br>  3. ส่วนจัดการศึกษาภายใน มจร 51 ส่วนงาน (`org_unit_id`)<br>  4. หลักสูตร/สาขาวิชา (`program_name`)<br>- รัน Migration บน Production (`mcuvps_db`) เพิ่ม 4 คอลัมน์สำเร็จ<br>- อัปเดตแสดงผลในหน้า Admin คัดกรอง, SAR Modal, Export CSV, และหน้าตรวจสถานะคำขอ<br>- นำขึ้นโดเมนจริง [https://vps.mcu.ac.th](https://vps.mcu.ac.th) และล้าง Cache สำเร็จ 100% | `Done` |
| **2026-10-06 16:50 - 17:10** | **Step 22: Fix 404 & 405 on Production Bulk Actions & Single Actions** | - **แก้ไขปัญหา Error 404 Not Found & 405 Method Not Allowed บนเซิร์ฟเวอร์จริง (`vps.mcu.ac.th`)** เมื่อกดยืนยันอนุมัติ/ปฏิเสธ/ลบ/จัดการข้อมูลจำนวนมาก (Bulk Actions)<br>- ปรับปรุงฟอร์มจัดการจำนวนมาก (`#bulk-form`) ใน `public_students.blade.php`, `public_sar.blade.php`, `ug_students.blade.php`, และ `grad_approvals.blade.php` ให้ส่ง POST ตรงเข้า Script Endpoints (เช่น `/admin/public_students.php`, `/admin/ug_students.php`, `/admin/grad_approvals.php`)<br>- เพิ่ม **Route::match(['get', 'post'])** และ **Action Dispatcher Pattern** สำหรับ Bulk Actions ใน `AdminController.php`<br>- อัปโหลดไฟล์ขึ้น Production (`vpsmcu-core/`) และเคลียร์ Route/View Cache เรียบร้อย 100% | `Done` |
| **2026-10-06 17:10 - 17:28** | **Step 23: Vipassana Institute Integration (Option #1 Priority)** | - **เพิ่ม "สถาบันวิปัสสนาธุระ"** (`code: 'MCU-VIPASSANA'`, `type: 'CENTRAL'`, พระนครศรีอยุธยา) เข้าสู่ฐานข้อมูล `organization_units` ทั้ง Local และ Production (`vps.mcu.ac.th`)<br>- สร้าง Scope `OrganizationUnit::orderedForSelect()` จัดลำดับให้ **สถาบันวิปัสสนาธุระ เป็นตัวเลือกอันดับที่ 1** เสมอในทุกหน้าจอ (กำหนดการ ป.ตรี, คอร์สประชาชน, โพสต์ข่าวสาร, และตัวกรองสถิติ)<br>- อัปเดตและทดสอบการแสดงผลบน Production สำเร็จ 100% | `Done` |
| **2026-10-07 18:00 - 19:05** | **Step 25: Home Portal Redesign (Home-Portal.png Alignment)** | - ปรับปรุงดีไซน์หน้าแรก (`portal/index.blade.php`) ตามภาพต้นแบบ [Home-Portal.png](file:///home/dhawara/APPDEV/VPSMCU/Sample%20Data/Home-Portal.png) 100%<br>- ติดตั้ง **Hero Image** จริง (`public/images/heroimage.png`)<br>- จัดหัวข้อภาษาไทยและอังกฤษเป็น 3 บรรทัด (`whitespace-nowrap` ไม่ตกบรรทัดเด็ดขาดเมื่อสลับภาษา TH/EN)<br>- ปรับสีและฟอนต์หัวข้อ: "ระบบสารสนเทศ" (ใหญ่พิเศษ 120px สี `#663300`) และ "การปฏิบัติวิปัสสนากรรมฐาน" (72px สี `#CC6600`) และ "สถาบันวิปัสสนาธุระ มหาวิทยาลัยมหาจุฬาลงกรณราชวิทยาลัย"<br>- ปรับแต่งการ์ด 4 โมดูลหลักตามโค้ดสีที่กำหนดเป๊ะ: สมัครปฏิบัติธรรม (ปุ่ม `#397657` พื้นหลัง `#E9FAE9`), ฐานข้อมูลนิสิต (ปุ่ม `#357EBC` พื้นหลัง `#E5F7FD`), ตรวจสอบจำนวนวัน (ปุ่ม `#A14530` พื้นหลัง `#F5EFE5`), ขอหนังสือรับรอง (ปุ่ม `#A3772C` พื้นหลัง `#FFFEF0`)<br>- อัปเดตลิงก์ Navbar: ปฏิทิน, ตรวจสอบวัน, ยื่นคำร้อง, ฐานข้อมูล, ติดต่อ, ร่วมบริจาค<br>- ปรับแต่งปฏิทินรายเดือน + โครงการเปิดรับสมัคร + ข่าวประชาสัมพันธ์ (3 การ์ดพร้อมไอคอนโทรโข่ง) และ Footer โทน Deep Forest สวยงามสมบูรณ์<br>- ปรับแคช Production: `config:cache`, `route:cache`, `view:cache` พร้อมนำขึ้นเว็บจริง | `Done` |
| **2026-10-07 19:05 - 19:15** | **Step 26: Production Deployment & Verification** | - อัปโหลดไฟล์หน้าหลักใหม่และ Assets ขึ้น Production (`vps.mcu.ac.th`) เรียบร้อย 100%:<br>  1. `public/images/heroimage.png` (Webroot และ `vpsmcu-core/public/images/`)<br>  2. `vpsmcu-core/lang/th/portal.php` และ `vpsmcu-core/lang/en/portal.php`<br>  3. `vpsmcu-core/resources/views/portal/index.blade.php`<br>- ทดสอบการแสดงผลบน Production [https://vps.mcu.ac.th](https://vps.mcu.ac.th): HTTP 200 OK, Hero Image แสดงผลสมบูรณ์, 3 บรรทัดหัวข้อสีถูกต้อง (`#663300`, `#CC6600`), สลับภาษา TH/EN ทำงานถูกต้องไม่ตกบรรทัด, สีปุ่มและการ์ด 4 โมดูลตรงตามที่ระบุ 100% | `Done` |
| **2026-10-07 19:15 - 19:40** | **Step 27: Course & Batch Cover Image Integration & Fix 404 on Update Actions** | - **เพิ่มคอลัมน์ `cover_image` (VARCHAR 500)** ในตาราง `ug_batches` (ป.ตรี) และ `public_events` (ภาคประชาชน) ทั้ง Local Container และ Production Server (`mcuvps_db`)<br>- **ระบบหลังบ้าน (Admin Console):**<br>  1. เพิ่มช่องอัปโหลดไฟล์ภาพปกโครงการ (`cover_file` สูงสุด 10MB) หรือระบุ URL ใน Modal เพิ่ม/แก้ไขกำหนดการ ป.ตรี (`/admin/ug_batches.php`)<br>  2. เพิ่มช่องอัปโหลดไฟล์ภาพปกโครงการหรือระบุ URL ใน Modal เพิ่ม/แก้ไขคอร์สภาคประชาชน (`/admin/public_events.php`)<br>  3. เพิ่มช่อง Thumbnail Preview แสดงภาพปกโครงการในตารางรายการของทั้งสองโมดูล<br>- **แก้ไขปัญหา Error 404 Not Found บน Production เมื่อกดยืนยันบันทึก/แก้ไขข้อมูลกำหนดการ:**<br>  - ปัญหาเกิดจากเซิร์ฟเวอร์ FreeBSD Apache ปิด `AllowOverride` ทำให้ Clean URL เช่น `/admin/ug/batches/update/1` เกิด 404<br>  - ปรับ Action Dispatcher ใน `AdminController.php` ให้รองรับ `action=store` และ `action=update`<br>  - ปรับ Action Endpoints ของฟอร์มทั้งใน `ug_batches.blade.php` และ `public_events.blade.php` ให้ส่ง POST ตรงเข้า Script Endpoints (`/admin/ug_batches.php` และ `/admin/public_events.php`)<br>- **แก้ไขปัญหาภาพปกไม่แสดงผลบน Production (`/storage/...` ➔ 404):**<br>  - บนโฮสติ้งจริงของมหาวิทยาลัย Apache ปิด `.htaccess` และไม่มี symlink `/storage`<br>  - เพิ่ม Model Accessor `getCoverImageAttribute` ใน `UgBatch.php` และ `PublicEvent.php` เพื่อแปลง Path เป็น `/storage.php/batches/...` อัตโนมัติ (สตรีมผ่าน `storage.php` เหมือนระบบข่าวสาร)<br>  - สร้างโฟลเดอร์ `storage/batches` และ `storage/public_events` บน Webroot<br>  - ทดสอบการแสดงผลภาพ: HTTP 200 OK แสดงภาพปกจริงทันทีทั้งในหน้า Admin และหน้า Portal | `Done` |
| **2026-10-07 20:00 - 20:25** | **Step 28: Custom Earth Tones 404 & 500 Error Pages & Form Dispatcher Audit** | - **ออกแบบและติดตั้งหน้า Error 404 & 500 ตามธีม Earth Tones / Organic Palette** (`resources/views/errors/404.blade.php` และ `500.blade.php`) สวยงาม ละมุนตา สื่อถึงความสงบของ มจร พร้อม Lucide Icons, โลโก้ทางการ, และทางลัดเมนูบริการด่วน<br>- **ตรวจสอบและแก้ไขปัญหาฟอร์มหลังบ้านที่ยังส่ง Clean URL** จนเกิด Apache 404 Not Found:<br>  1. โมดูลทะเบียน ป.ตรี (`ug_students.blade.php`): ปรับแบบฟอร์มแก้ไขนิสิตให้ส่งเข้า `/admin/ug_students.php` พร้อม `action=update`<br>  2. โมดูลอนุมัติบัณฑิตศึกษา (`grad_approvals.blade.php`): ปรับแบบฟอร์มแก้ไขคำร้องนิสิตให้ส่งเข้า `/admin/grad_approvals.php` พร้อม `action=update`<br>  3. โมดูลทะเบียนประชาชน (`public_sar.blade.php`): ปรับแบบฟอร์มแก้ไขให้ส่งเข้า `/admin/public_sar.php` พร้อม `action=update`<br>  4. โมดูลผู้ใช้งาน (`users_index.blade.php`): ปรับแบบฟอร์มเพิ่ม/แก้ไข/ลบ/ระงับ ให้ส่งเข้า `/admin/users.php`<br>  5. โมดูลการบริจาค (`donations_index.blade.php`): ปรับแบบฟอร์มแก้ไข/เปลี่ยนสถานะ/ลบ ให้ส่งเข้า `/admin/donations.php`<br>- ปรับแต่ง `AdminController.php` เพิ่ม Action Dispatcher รองรับการทำงานผ่าน `.php` ครบทุกเมนู 100%<br>- อัปโหลดไฟล์ขึ้น Production (`vps.mcu.ac.th`) และล้าง Compiled Views Cache สำเร็จ | `Done` |
| **2026-10-07 20:25 - 20:30** | **Step 29: Portal Action Card 1 Link Target Alignment** | - ปรับปรุงปุ่มในการ์ดที่ 1 **"สมัครปฏิบัติธรรม"** บนหน้าหลัก Portal ([portal/index.blade.php](file:///home/dhawara/APPDEV/VPSMCU/vpsmcu-laravel/resources/views/portal/index.blade.php)) ให้ลิงก์ไปยัง **หน้าลงทะเบียนเข้าร่วมปฏิบัติธรรม ภาคประชาชน** (`/public_register.php` หรือ `route('public.register')`) ตรงตามความต้องการ<br>- อัปโหลดขึ้น Production (`vps.mcu.ac.th`) และเคลียร์ View Cache สำเร็จ | `Done` |

---

### 1. สรุปภาพรวมสถานะโครงการ (Current Project Status)

1. **สภาพแวดล้อมระบบและการรันจริง (Active Runtime Environment):**
   - **ระบบหลัก:** พัฒนาด้วย **Laravel 11 (PHP 8.4) + MariaDB 10.6 + Apache 2.4** ตามข้อจำกัดของโฮสติ้งมหาวิทยาลัย
   - **ที่ตั้งซอร์สโค้ด:** โฟลเดอร์ `mcuvms-laravel/` (แมป DocumentRoot เข้าสู่ `/var/www/html/public`)
   - **Docker Containers:**
     - `MCUVMS` (Web Server: Apache 2.4 + PHP 8.4): เข้าใช้งานได้ที่ [http://localhost:8086/](http://localhost:8086/)
     - `MCUVMS-DB` (Database: MariaDB 10.6): พอร์ตภายนอก `3310` (DB: `mcuvms_db`, User: `mcuvms_user`, Pass: `mcuvms_password`)
     - `MCUVMS-GUI` (phpMyAdmin): เข้าใช้งานได้ที่ [http://localhost:8088/](http://localhost:8088/)
   - **ข้อมูลเข้าสู่ระบบ Admin Console (รหัสผ่านทุกบัญชีคือ `password`):**
     - **Super Admin:** User `admin`
     - **เจ้าหน้าที่ส่วนกลาง (Central Officer - ดูแล 52 ส่วนงาน):** User `central`
     - **เจ้าหน้าที่วิทยาเขตเชียงใหม่ (Campus Admin):** User `officer_cmi`
     - **เจ้าหน้าที่วิทยาเขตขอนแก่น (Campus Admin):** User `officer_kkn`

2. **ระบบดีไซน์และอัตลักษณ์ (Design System & Aesthetics):**
   - **สไตล์สี:** นำ **Earth Tones / Organic Palette (โทนธรรมชาติ)** มาปรับใช้แล้วครบทุกหน้า:
     - เขียวมะกอก (Olive): `#5A6B47` / `#7B8D65` (สีหลักและป้ายสถานะ)
     - เขียวป่าลึก (Deep Forest): `#2C3E2D` / `#243325` (Sidebar และแบนเนอร์)
     - น้ำตาลอิฐ / ดินเผา (Terracotta / Clay): `#C86D51` (สีเน้นและป้ายรออนุมัติ)
     - สีทรายและก้อนหินอ่อน (Sand & Stone): `#F7F5EE`, `#FAF8F2`, `#EAE5D9` (พื้นหลังและการ์ด)
   - **ระบบไอคอน:** ใช้ **[Lucide Icons](https://lucide.dev/icons/)** 100% ทั่วทั้งระบบ (`<i data-lucide="..."></i>`)
   - **มาตรฐานโครงสร้างหน้าจอ (Layout Standards):**
     - **หลังบ้าน (Admin Console):** `<main class="flex-grow p-6 md:p-10 overflow-y-auto">` พร้อม `<header class="flex flex-col sm:flex-row justify-between sm:items-center pb-6 mb-8 border-b border-[#D5CEBC] gap-4">`
     - **หน้าบ้าน (Portal):** `<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">` ครอบคลุมทั้ง Navigation Bar และ `<main>` เนื้อหาไม่บีบแคบ

3. **ฟังก์ชันสำคัญที่เพิ่มล่าสุด (Recently Delivered Features):**
   - **ระบบนำเข้าข้อมูลนิสิตผ่าน CSV ([/admin/ug_import.php](http://localhost:8086/admin/ug_import.php)):** รองรับการอัปโหลดรายชื่อนิสิต ตรวจสอบความถูกต้อง พร้อมดาวน์โหลดตัวอย่างไฟล์ CSV และระบบบันทึกลงตาราง `ug_master_students`
   - **ระบบตรวจสอบสิทธิ์และผูกส่วนงานอัตโนมัติ (Campus-Binding):** ในหน้าลงทะเบียน ป.ตรี ([/ug_register.php](http://localhost:8086/ug_register.php)) เมื่อกรอกรหัสนิสิต ระบบจะแสดงข้อมูลและกรองเฉพาะโครงการของส่วนงานต้นสังกัดเท่านั้น
   - **ระบบข่าวสารประชาสัมพันธ์ครบวงจร:**
     - หลังบ้าน ([/admin/news.php](http://localhost:8086/admin/news.php)): CRUD ข่าว, ปักหมุด, กรองหมวดหมู่/สถานะ, จัดตารางเรียบร้อยไม่ตกขอบ
     - หน้าบ้าน ([/news.php](http://localhost:8086/news.php) & [/news/{id}](http://localhost:8086/news/1)): แสดงรายการข่าวพร้อมระบบค้นหา กรอง 52 ส่วนงาน บันทึกยอดวิว และแชร์ลิงก์ รองรับ Legacy URL (`/news_detail.php?id=1` / `/news_detail.php?1`)
   - **ระบบปฏิทินปฏิบัติธรรมหน้าแรก (Interactive Monthly Grid):** ตารางปฏิทินรายเดือนแสดงจุดกิจกรรมพร้อมกล่องลิสต์โครงการทางขวา เลื่อนดูรายการได้พอดีกับความสูงของปฏิทิน
   - **ระบบติดต่อสอบถาม (หน้าบ้าน/หลังบ้าน):** หน้าแบบฟอร์มติดต่อสอบถาม ([/contact.php](http://localhost:8086/contact.php)) และหน้าตั้งค่าระบบช่องทางติดต่อ/กล่องข้อความผู้ติดต่อหลังบ้าน ([/admin/contact_settings.php](http://localhost:8086/admin/contact_settings.php))
   - **จัดกลุ่มเมนูการตั้งค่าระบบ (System Settings):** รวมเมนูรายชื่อส่วนงาน/รหัสย่อ, จัดการผู้ใช้และสิทธิ์, และตั้งค่าติดต่อสอบถาม ไว้ในกลุ่มเดียว พร้อมตัดตารางยาวรกรุงรังออกจาก Dashboard
   - **ถอดคำว่า "SAR" และข้อความซ้ำซ้อน:** ปรับคำแสดงผลทั่วระบบเป็น "บริการวิชาการแก่สังคม" และนำคำว่า "ครอบคลุม 52 ส่วนงานทั่วประเทศ" ออกจากจุดที่ซ้ำซ้อน
   - **สถิติแผนภูมิกราฟแท่งระดับส่วนงาน (Campus Bar Chart):** แสดงผลเปรียบเทียบสัดส่วนผู้เข้าร่วม 3 กลุ่มบนหน้า Dashboard ([/admin/dashboard.php](http://localhost:8086/admin/dashboard.php)) ด้วย Chart.js พร้อมตารางสรุป
   - **ปรับปรุงฐานข้อมูลแม่แบบส่วนงาน มจร (`/admin/org_units.php`):**
     - ลบรายการ "วิทยาเขตสงขลา" (`CAMPUS-SKA`) ออกจากฐานข้อมูลและ Master Data เนื่องจากไม่มีอยู่จริง
     - ยกระดับ "หน่วยวิทยบริการ จังหวัดสงขลา" (`UNIT-SKA`) เป็น **"วิทยาลัยสงฆ์สงขลา"** (`SANGHA-SKA`) ประเภท `SANGHA_COLLEGE`
     - ปรับปรุง Controller และ View ให้รองรับการค้นหาและกรอง "วิทยาลัยสงฆ์" (`SANGHA_COLLEGE` / `COLLEGE`) ครบทั้ง 28 แห่ง
     - เพิ่มตัวกรองและป้ายสถานะ "หน่วยวิทยบริการ" (`ACADEMIC_UNIT`) พร้อมการ์ดสรุปสถิติ 5 กลุ่ม
     - ปรับปรุงประสิทธิภาพความเร็วของหน้าเว็บให้ทำงานลื่นไหลและตอบสนองทันที
   - **อัตลักษณ์มหาวิทยาลัย:** ติดตั้ง MCU Official Logo และ Favicon ครบถ้วนทุกหน้าในระบบ

---

### 2. รายการงานสำหรับดำเนินการต่อ (Next Steps Backlog)

เมื่อกลับมาทำงานต่อ สามารถหยิบงานตามลำดับนี้ได้ทันที:

1. **การลงมือสร้างโมดูลที่ 1 (Undergraduate Module):**
   - พัฒนาระบบสแกน QR Code หน้างาน (Mobile Scanner UI สำหรับอาจารย์/เจ้าหน้าที่)
   - ระบบพิมพ์ใบเซ็นชื่อและ Export รายชื่อนิสิต ป.ตรี ส่งฝ่ายทะเบียน

2. **ระบบการอัปโหลดและจัดเก็บเอกสารจริง (File Storage):**
   - ผูกระบบจัดเก็บไฟล์หลักฐานใบประกาศ/รูปภาพของนิสิต ป.โท-เอก ผ่าน Symlink `php artisan storage:link`
   - เพิ่มระบบป้องกันขนาดไฟล์เกิน (File compression ก่อนบันทึก)

3. **ระบบสแกนและตรวจสอบใบรับรองดิจิทัล (Digital Verification):**
   - ทำหน้า Public Verification URL สำหรับให้บุคคลภายนอกสแกน QR Code ตรวจสอบความถูกต้องของใบรับรองผล

---

### 3. คำสั่งสำคัญสำหรับนักพัฒนา (Developer Cheat Sheet)

```bash
# ตรวจสอบสถานะ Containers
docker compose ps

# ดู Log ของ Web Server
docker logs -f MCUVMS

# ล้างแคช View ของ Laravel เมื่อแก้ไฟล์ Blade
docker exec MCUVMS php artisan view:clear

# สั่งรัน Database Migration
docker exec MCUVMS php artisan migrate

# เข้าสู่ Bash ภายใน Web Container
docker exec -it MCUVMS bash
```
