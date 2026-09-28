# Task Tracking & Quality Gates (`progress.md`)
## Feature: Graduate Meditation Credit & Approval System (`graduate`)
**การติดตามความคืบหน้าและการประกันคุณภาพ (Laravel 11 Edition)**

---

### 1. ตารางติดตามความคืบหน้ารายขั้นตอน (Task Progress Matrix)

| หมวดหมู่งาน (Phase) | รายละเอียดงาน (Tasks) | ความสำคัญ | สถานะ (Status) | การตรวจสอบในระบบ |
| :--- | :--- | :---: | :---: | :--- |
| **1. Database & Models** | Migration ตาราง `grad_students` และ `grad_credit_entries` | P0 | `Completed` | MariaDB 10.6 พอร์ต 3310 |
| | Eloquent Models พร้อม Relationships | P0 | `Completed` | `app/Models/GradStudent.php` |
| | Seed ข้อมูลนิสิต ป.โท (25 วัน) และ ป.เอก (45 วัน) | P1 | `Completed` | ตรวจสอบผ่าน phpMyAdmin |
| **2. Controller Logic** | ระบบค้นหาประวัติตามรหัสนิสิต (`progress`) | P0 | `Completed` | `GraduateController.php` |
| | การคำนวณวันสะสมและบันทึกประวัติย่อย (`storeEntry`) | P0 | `Completed` | สูตรคำนวณ Inclusive |
| | **Lock Engine Guard** (บล็อกส่งถ้าวันไม่ครบ 30/45 วัน) | P0 | `Completed` | ฝั่ง Controller + UI |
| | เวิร์กโฟลว์การอนุมัติและส่งกลับแก้ไข | P0 | `Completed` | `AdminController.php` |
| **3. UI & Themes** | ปรับแต่งหน้า Portal สะสมวันนิสิต | P0 | `Completed` | `portal/grad_progress.blade.php` |
| | ปรับแต่งหน้า Admin ตรวจสอบและอนุมัติ | P0 | `Completed` | `admin/grad_approvals.blade.php` |
| | แปลงไอคอนเป็น **Lucide Icons** ทั้งหมด | P0 | `Completed` | `<i data-lucide="..."></i>` |
| | ใช้ชุดสี **Earth Tones / Organic Palette** | P0 | `Completed` | `#5A6B47`, `#2C3E2D`, `#C86D51` |
| **4. Compatibility** | รันบน Apache/2.4 + PHP 8.4 + MariaDB | P0 | `Completed` | ผ่าน Docker Container `MCUVMS` |
| | รองรับทั้ง Clean URL และ `.php` URL | P0 | `Completed` | ผ่าน `routes/web.php` |

---

### 2. Checklist การตรวจสอบคุณภาพระบบ (Quality Gates for Laravel)

- [x] **1. การทำงานของ Route & Compatibility:**
  - เข้าถึงหน้า Portal ผ่าน [http://localhost:8086/grad_progress.php](http://localhost:8086/grad_progress.php) ได้ถูกต้อง
  - เข้าถึงหน้า Admin ผ่าน [http://localhost:8086/admin/grad_approvals.php](http://localhost:8086/admin/grad_approvals.php) ได้ถูกต้อง
- [x] **2. ความถูกต้องของ Business Logic:**
  - นิสิต ป.โท ต้องสะสมครบ 30 วัน / ป.เอก ต้องสะสมครบ 45 วัน
  - ปุ่ม "ยื่นขออนุมัติผล" ล็อกอัตโนมัติหากวันยังไม่ถึงเกณฑ์
  - เมื่อยื่นคำขอแล้ว สถานะเปลี่ยนเป็น `SUBMITTED` และขึ้นป้ายล็อกข้อมูล
- [x] **3. มาตรฐานการแสดงผลและไอคอน:**
  - ไอคอนทั้งหมดเรียกใช้ผ่าน Lucide Icons อย่างเป็นทางการ
  - โทนสีทั้งหน้าบ้านและหลังบ้านเป็น **Earth Tones / Organic Palette** สบายตา สมดุล และสะท้อนความเป็นธรรมชาติ
- [x] **4. การจัดการ Cache:**
  - รัน `docker exec MCUVMS php artisan view:clear` เพื่อให้ Blade แสดงผลเวอร์ชันล่าสุดทันที

---

### 3. ประวัติการปรับปรุงเอกสาร (Changelog)

| วันที่ | เวอร์ชัน | รายละเอียดการปรับปรุง | ผู้รับผิดชอบ |
| :---: | :---: | :--- | :---: |
| 2026-09-23 | v1.0.0 | จัดทำชุดพิมพ์เขียว Next.js Starter | Antigravity AI |
| 2026-09-23 | v2.0.0 | ปรับปรุงชุดเอกสารทั้ง 6 ฉบับให้ตรงตามสถาปัตยกรรม **Laravel 11 + PHP 8.4 + MariaDB + Blade** อย่างสมบูรณ์ | Antigravity AI |
