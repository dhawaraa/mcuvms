# พิมพ์เขียวสถาปัตยกรรมระบบสารสนเทศการปฏิบัติวิปัสสนากรรมฐาน มจร (MCUVMS Architecture Blueprint)
**ระบบสารสนเทศการปฏิบัติวิปัสสนากรรมฐาน มหาวิทยาลัยมหาจุฬาลงกรณราชวิทยาลัย**  
ครอบคลุม 52 ส่วนงานทั่วประเทศ (คณะ, วิทยาเขต, วิทยาลัยสงฆ์, หน่วยวิทยบริการ)

---

## 1. บริบทและสถาปัตยกรรมระบบ (System Architecture)

ระบบ MCUVMS พัฒนาบนพื้นฐานของ **VibeCore Framework** ตามแนวคิด **Modular Monolith** เพื่อความสะดวกในการดูแลรักษา การแยกขอบเขตฟังก์ชันอย่างชัดเจน (Separation of Concerns) และการควบคุมการเข้าถึงข้อมูลตามสังกัดส่วนงาน (Organization-Unit Level Isolation)

### เทคโนโลยีหลัก (Tech Stack)
* **Framework:** Next.js 16 (App Router, Server Actions, React 19)
* **ORM & Database:** Prisma 6 + PostgreSQL 16 (รันผ่าน Docker Container `MCUVMS-DB` พอร์ต `5433`)
* **Design System & UI:** Tailwind CSS 4 + Liyon Design System (รองรับ Light / Dark Mode, Theme Palettes)
* **Authentication & RBAC:** NextAuth v5 (Auth.js) รองรับการยืนยันตัวตนด้วย Username / Citizen ID + Password ควบคู่ Role & Permission Matrix
* **Container Environment:** Docker & Docker Compose (`MCUVMS`, `MCUVMS-DB`, `MCUVMS-GUI` / pgAdmin4)

---

## 2. โครงสร้างระบบ 2 ส่วนหลัก (Dual Sub-systems)

1. **Public Portal (ระบบหน้าบ้านสำหรับบุคคลภายนอกและนิสิต):**
   * เข้าถึงได้โดยไม่ต้องล็อกอิน หรือล็อกอินด้วยบัญชีนิสิต (รหัสนิสิต + เลขบัตร ปชช.)
   * ค้นหาข่าวสาร, ปฏิทินปฏิบัติธรรมทั่วประเทศ
   * ลงทะเบียนนิสิต ป.ตรี, ระบบสะสมวัน ป.โท-เอก, ระบบลงทะเบียนประชาชนทั่วไป
   * ตรวจสอบสถานะการสมัคร, แสดงบัตรประจำตัวพร้อม QR Code, ดาวน์โหลดเกียรติบัตรดิจิทัล

2. **Admin Console (ระบบหลังบ้านสำหรับเจ้าหน้าที่และอาจารย์):**
   * ระบบยืนยันตัวตนเจ้าหน้าที่ตามสิทธิ์ (RBAC) และตามสังกัด 52 ส่วนงาน
   * ตรวจสอบรายชื่อ, คัดกรองเอกสาร, สแกน QR Code เช็คชื่อหน้างาน (Mobile Scanner)
   * ระบบเวิร์กโฟลว์การอนุมัติผลการปฏิบัติธรรมและการเทียบวันสะสม
   * แดชบอร์ดสถิติ และการส่งออกรายงาน (Excel / PDF) สำหรับสำนักทะเบียนและรายงาน SAR

---

## 3. รายละเอียด 5 ฟีเจอร์หลักตามกรอบ D-A-B-U

### 3.1 ระบบจัดการข่าวสารประชาสัมพันธ์ (News & Announcements)
* **[D] Data:**
  * `news_articles`: `id`, `org_unit_id`, `title_th`, `title_en`, `slug`, `content_html`, `cover_image_url`, `category_id`, `is_pinned`, `status` (DRAFT, PUBLISHED, ARCHIVED), `view_count`, `published_at`
  * `news_categories`: `id`, `name_th`, `name_en`
* **[A] Access & Roles:**
  * `Guest / นิสิต`: อ่านข่าว, กรองข่าวตามวิทยาเขต, ดาวน์โหลดเอกสารแนบ
  * `NEWS_STAFF` (เจ้าหน้าที่วิทยาเขต): จัดการข่าวสารเฉพาะส่วนงานของตนเอง
  * `NEWS_APPROVER` (หัวหน้าส่วนงาน): ตรวจสอบและอนุมัติเผยแพร่ข่าว
  * `SUPER_ADMIN` (ส่วนกลาง): จัดการข่าวได้ทุกส่วนงาน และมีสิทธิ์ปักหมุดข่าวระดับประเทศ
* **[B] Business Rules:**
  * ข่าวที่แสดงหน้าบ้านต้องมีสถานะ `PUBLISHED` และถึงกำหนดเวลาเผยแพร่แล้ว
  * ข่าวทุกชิ้นจะแสดงป้ายกำกับ (Badge) สังกัดวิทยาเขตผู้เผยแพร่เสมอ
* **[U] UI/UX:**
  * **Portal:** การ์ดข่าวสไตล์ Modern Glass, ตัวกรองแยก "ข่าวส่วนกลาง / ข่าววิทยาเขต", ค้นหาด้วยคำสำคัญ
  * **Admin:** Data Table รายการข่าว, Rich Text Editor สำหรับพิมพ์เนื้อหา, ตัวอัปโหลดภาพ Banner, ระบบ Preview ก่อนเผยแพร่

---

### 3.2 ระบบจัดการปฏิทินการปฏิบัติกรรมฐาน 52 หน่วยงาน (Meditation Calendar)
* **[D] Data:**
  * `meditation_calendars`: `id`, `org_unit_id`, `academic_year`, `title`, `target_group` (UG, GRAD, PUBLIC, ALL), `start_date`, `end_date`, `total_days`, `location_name`, `map_url`, `max_seats`, `regis_start_date`, `regis_end_date`, `status`
* **[A] Access & Roles:**
  * `Guest / นิสิต`: ดูปฏิทินรายเดือน/รายสัปดาห์/Agenda, กรองตามวิทยาเขต, กดลิงก์เพื่อไปสมัคร
  * `CALENDAR_STAFF`: บันทึกโครงการและกำหนดการของส่วนงานตนเอง
  * `SUPER_ADMIN`: ดูปฏิทินและภาพรวมไทม์ไลน์ 52 ส่วนงานทั่วประเทศ
* **[B] Business Rules:**
  * ช่วงเวลาจัดโครงการในสถานที่เดียวกันต้องไม่ซ้ำซ้อนกัน
  * สถานะการรับสมัครจะเปิด-ปิดอัตโนมัติตามช่วงเวลา `regis_start_date` และ `regis_end_date`
* **[U] UI/UX:**
  * **Portal:** Interactive Calendar View, ตัวกรองตาม 52 วิทยาเขต, แถบสีจำแนกกลุ่มเป้าหมาย (ตรี/บัณฑิต/ประชาชน)
  * **Admin:** หน้าจัดการปฏิทินแบบ Gantt Chart / Timeline, ฟอร์มบันทึกกำหนดการ, ปุ่มคัดลอกโครงการจากปีก่อน

---

### 3.3 โมดูลที่ 1: ระบบลงทะเบียนปฏิบัติกรรมฐาน ระดับปริญญาตรี (Undergraduate Module)
**เกณฑ์หลักสูตร:** ภาคปกติและภาคพิเศษ ปฏิบัติธรรม **ปีละ 10 วัน ต่อเนื่อง 4 ปีการศึกษา (รวม 40 วัน)**

* **[D] Data:**
  * `ug_student_profiles`: `student_id`, `citizen_id`, `org_unit_id`, `faculty_id`, `department_id`, `program_type` (NORMAL, SPECIAL), `class_year` (1-4)
  * `ug_yearly_records`: `student_id`, `year_1_status`, `year_2_status`, `year_3_status`, `year_4_status` (NOT_REACHED, PENDING, PASSED, FAILED, WAIVED)
  * `ug_batches`: `id`, `org_unit_id`, `academic_year`, `batch_no` (ผลัดที่), `start_date`, `end_date`, `max_quota`, `current_registered`
  * `ug_registrations`: `id`, `batch_id`, `student_id`, `checkin_token` (UUID สำหรับ QR Code), `final_result` (PENDING, PASSED, FAILED, ABSENT)
* **[A] Access & Roles:**
  * `STUDENT_UG`: ล็อกอินด้วยรหัสนิสิต + เลข ปชช., เลือกรอบผลัด, กดยืนยันระเบียบ, รับใบลงทะเบียนพร้อม QR Code ประจำตัว
  * `CAMPUS_ADMIN`: ตรวจสอบรายชื่อแยกชั้นปี/สาขา, สแกน QR Code รับรายงานตัว, บันทึกผลการอบรม, ส่งออกไฟล์ Excel
  * `VIPASSANA_MASTER`: บันทึกผลการสอบอารมณ์และรับรองผลการปฏิบัติธรรม
  * `SUPER_ADMIN`: แดชบอร์ดสรุปสถิตินิสิต ป.ตรี ที่ผ่าน/ค้างเกณฑ์ทั่วประเทศ
* **[B] Business Rules:**
  * **Eligibility Engine:** อนุญาตให้ลงทะเบียนเฉพาะรอบของชั้นปีตนเอง หรือรอบเก็บตกกรณีไม่ผ่านในปีก่อน
  * **Campus Binding:** ต้องเลือกรอบที่จัดโดยวิทยาเขตสังกัดของตนเองเท่านั้น (ป้องกันการข้ามวิทยาเขตโดยพลการ)
  * **Attendance 100%:** ต้องเข้าร่วมครบตามกำหนด 10 วัน หากขาดเกินกำหนดจะปรับเป็น `FAILED` ทันที
* **[U] UI/UX:**
  * **Portal (Student):** แดชบอร์ดแสดงผลผ่านเกณฑ์ 4 ปี (ปี 1, 2, 3, 4 แบบ Visual Steps), ฟอร์มเลือกผลัดอบรม, หน้าบัตรประจำตัว Pass Card พร้อม QR Code คมชัด
  * **Admin:** แผงสแกน QR Code (Mobile Scanner), ตารางบันทึกผลการเข้าอบรม, ปุ่ม Export Excel ฟอร์แมตใบเซ็นชื่อส่งฝ่ายทะเบียน

---

### 3.4 โมดูลที่ 2: ระบบลงทะเบียนและสะสมวันปฏิบัติกรรมฐาน ระดับบัณฑิตศึกษา (Graduate Module)
**เกณฑ์หลักสูตร:** ปริญญาโท **สะสมครบ 30 วัน** / ปริญญาเอก **สะสมครบ 45 วัน** (แบบ One-Time Final Submission)

* **[D] Data:**
  * `grad_profiles`: `student_id`, `degree_level` (MASTER=30 วัน, DOCTORAL=45 วัน), `target_days`, `total_accumulated_days`, `submission_state` (ACCUMULATING, READY_TO_SUBMIT, SUBMITTED, RETURNED_FOR_EDIT, APPROVED, REJECTED)
  * `grad_credit_entries` (ประวัติย่อยแต่ละครั้ง): `id`, `student_id`, `start_date`, `end_date`, `days_earned`, `temple_name`, `master_name`, `location_province`
  * `grad_final_submissions` (คำร้องขอจบ): `id`, `student_id`, `submitted_at`, `reviewed_at`, `reviewer_id`, `rejection_note`, `completion_code`
  * `grad_submission_files`: `submission_id`, `file_type` (CERTIFICATE, RECOMMEND_LETTER, PHOTO), `file_url`, `file_size`
* **[A] Access & Roles:**
  * `STUDENT_GRAD`: บันทึกประวัติย่อยแต่ละครั้ง, ดู Progress Bar วันสะสม, ยื่นขออนุมัติเมื่อวันสะสมครบตามเกณฑ์ (ส่งได้ 1 ครั้ง), แก้ไขเอกสารกรณีถูกตีกลับ
  * `GRAD_STAFF`: ตรวจทานหลักฐานและนับวันสะสม, ส่งกลับแก้ไขพร้อมระบุหมายเหตุ
  * `GRAD_APPROVER` (คณะกรรมการบัณฑิตวิทยาลัย): อนุมัติขั้นสุดท้าย และออก Digital Completion Slip
  * `REGISTRAR`: ดึงรายงานสรุปรายชื่อนิสิตที่ผ่านเกณฑ์เพื่อประมวลผลการสำเร็จการศึกษา
* **[B] Business Rules:**
  * **Lock Engine:** ปุ่มยื่นคำขออนุมัติจะถูก **ล็อกอย่างเด็ดขาด** จนกว่าจำนวนวันสะสมจะครบตามเกณฑ์ (โท ≥ 30, เอก ≥ 45)
  * **One-Time Final Submission:** ส่งเรื่องได้เพียง 1 ครั้งเมื่อวันครบ และระบบจะระงับการแก้ไขประวัติระหว่างรอพิจารณา
  * **Re-submission Flow:** หากเจ้าหน้าที่สั่งแก้ไข ระบบจะปลดล็อกให้แก้ไขเฉพาะไฟล์ที่ระบุ และส่งเข้ามาตรวจซ้ำได้
  * **Auto Compression:** ไฟล์แนบ PDF/JPG/PNG จะถูกบีบอัดอัตโนมัติบน Server เพื่อลดขนาดพื้นที่จัดเก็บ
* **[U] UI/UX:**
  * **Portal (Student):** Progress Bar / Gauge แสดงวันสะสม เช่น `35 / 45 วัน (ขาดอีก 10 วัน)`, Timeline แสดงประวัติการเข้าปฏิบัติ, พื้นที่ Upload ไฟล์แบบ Drag & Drop, หน้ารับรอง Digital Completion Slip
  * **Admin:** หน้าจอ Split-Screen Reviewer (ด้านซ้ายดูข้อมูลวันสะสม ด้านขวาดูไฟล์ PDF/รูปภาพได้ทันทีไม่ต้องโหลดลงเครื่อง), ปุ่มแอคชัน `[อนุมัติ]` / `[ส่งกลับแก้ไข]` / `[ไม่อนุมัติ]`, รายงาน Graduation Clearance Report

---

### 3.5 โมดูลที่ 3: ระบบลงทะเบียนปฏิบัติกรรมฐานสำหรับประชาชนทั่วไป (Public Community Module)
**เกณฑ์หลักสูตร:** บริการวิชาการแก่สังคม เปิดรับประชาชนทั่วไปตามโครงการของ 52 ส่วนงาน

* **[D] Data:**
  * `public_events`: `id`, `org_unit_id`, `title`, `start_date`, `end_date`, `max_quota`, `waiting_quota`, `confirmed_count`, `waiting_count`, `status`
  * `public_registrations`: `id`, `event_id`, `citizen_id` (13 หลัก), `prefix`, `full_name`, `gender`, `age_group`, `phone_number`, `province`, `emergency_contact_name`, `emergency_phone`, `congenital_disease`, `dietary_restriction`, `queue_no`, `status` (CONFIRMED, WAITING_LIST, CANCELLED, ATTENDED)
* **[A] Access & Roles:**
  * `Public Guest`: สมัครเข้าร่วมโครงการโดยไม่ต้องมีบัญชี, ค้นหาโครงการตามจังหวัด/วิทยาเขต, ตรวจสถานะด้วยเลขบัตร ปชช., พิมพ์บัตรประจำตัว
  * `PUBLIC_STAFF`: ตั้งค่าโควตา, ตรวจสอบรายชื่อ, จัดคิวและสแกนเช็คชื่อหน้างาน
  * `PUBLIC_DIRECTOR`: ปิดรับสมัครก่อนกำหนด, รับรองรายงานสรุปผล
  * `SUPER_ADMIN`: สรุปรายงานสถิติบริการวิชาการระดับมหาวิทยาลัยเพื่อรายงานประกันคุณภาพ (SAR)
* **[B] Business Rules:**
  * **Duplicate Prevention:** 1 เลขบัตรประชาชน สมัครได้เพียง 1 ครั้งต่อ 1 โครงการ
  * **Real-time Quota & Waiting List:** ตรวจนับที่นั่งว่างแบบ Real-time Transaction เมื่อเต็มจะปรับเข้าสู่สถานะ `WAITING_LIST` อัตโนมัติ และเลื่อนคิวขึ้นเป็นตัวจริงแบบ FIFO เมื่อมีคนยกเลิก
  * **SAR Data Aggregation:** จัดกลุ่มสถิติประชากรศาสตร์ (เพศ, อายุ, ภูมิลำเนา) สำหรับนำไปใช้ประกอบรายงาน SAR ได้ทันที
* **[U] UI/UX:**
  * **Portal:** ฟอร์มรับสมัครขนาดใหญ่ (Elder-Friendly) อ่านง่าย กรอกสะดวกบนมือถือ, ป้ายกำกับบอกสถานะ `[เปิดรับ - เหลือ 5 ที่]`, `[เต็ม - สำรองได้]`, บัตรประจำตัวผู้ปฏิบัติธรรมพร้อมคำแนะนำการเตรียมตัว
  * **Admin:** Dashboard ยอดผู้สมัครแบบ Real-time, ระบบคัดกรองข้อมูลสุขภาพ/อาหาร, หน้ารายงานสถิติ SAR แบบ Chart กราฟิกสวยงาม

---

## 4. มาตรฐานรหัสส่วนงานภายใน มจร (51 แห่ง)
อ้างอิงรหัสย่อจังหวัดมาตรฐานสากล (ISO 3166-2:TH / TIS)

### 4.1 ส่วนกลาง / คณะ / วิทยาลัย (7 แห่ง)
1. `MCU-GRAD`: บัณฑิตวิทยาลัย
2. `MCU-BUD`: คณะพุทธศาสตร์
3. `MCU-EDU`: คณะครุศาสตร์
4. `MCU-HUM`: คณะมนุษยศาสตร์
5. `MCU-SOC`: คณะสังคมศาสตร์
6. `MCU-IBSC`: วิทยาลัยพุทธศาสตร์นานาชาติ
7. `MCU-DDT`: วิทยาลัยพระธรรมทูต

### 4.2 วิทยาเขต และสถาบันสมทบ (13 แห่ง)
8. `CAMPUS-NKI`: วิทยาเขตหนองคาย (นค)
9. `CAMPUS-NRT`: วิทยาเขตนครศรีธรรมราช (นศ)
10. `CAMPUS-CMI`: วิทยาเขตเชียงใหม่ (ชม)
11. `CAMPUS-KKN`: วิทยาเขตขอนแก่น (ขก)
12. `CAMPUS-NMA`: วิทยาเขตนครราชสีมา (นม)
13. `CAMPUS-UBN`: วิทยาเขตอุบลราชธานี (อบ)
14. `CAMPUS-PRE`: วิทยาเขตแพร่ (พร)
15. `CAMPUS-SRN`: วิทยาเขตสุรินทร์ (สร)
16. `CAMPUS-PYO`: วิทยาเขตพะเยา (พย)
17. `CAMPUS-NPT-BP`: วิทยาเขตบาฬีศึกษาพุทธโฆส จ.นครปฐม (นฐ)
18. `CAMPUS-NSN`: วิทยาเขตนครสวรรค์ (นว)
19. `CAMPUS-NAN`: วิทยาเขตนครน่าน เฉลิมพระเกียรติฯ (นน)
20. `CAMPUS-NPT-MVBR`: มหาวชิราลงกรณบาลีเถรวาทราชวิทยาลัย จ.นครปฐม (นฐ)

### 4.3 วิทยาลัยสงฆ์ (28 แห่ง)
21. `SANGHA-LEI`: วิทยาลัยสงฆ์เลย (ลย)
22. `SANGHA-NPM`: วิทยาลัยสงฆ์นครพนม (นพ)
23. `SANGHA-LPN`: วิทยาลัยสงฆ์ลำพูน (ลพ)
24. `SANGHA-PLK-PCN`: วิทยาลัยสงฆ์พุทธชินราช จ.พิษณุโลก (พล)
25. `SANGHA-PTN`: วิทยาลัยสงฆ์ปัตตานี (ปน)
26. `SANGHA-BRM`: วิทยาลัยสงฆ์บุรีรัมย์ (บร)
27. `SANGHA-LPG`: วิทยาลัยสงฆ์นครลำปาง (ลป)
28. `SANGHA-SSK`: วิทยาลัยสงฆ์ศรีสะเกษ (ศก)
29. `SANGHA-CCO-PTS`: วิทยาลัยสงฆ์พุทธโสธร จ.ฉะเชิงเทรา (ฉช)
30. `SANGHA-SPB`: วิทยาลัยสงฆ์สุพรรณบุรีศรีสุวรรณภูมิ (สพ)
31. `SANGHA-PCT`: วิทยาลัยสงฆ์พิจิตร (พจ)
32. `SANGHA-CPM`: วิทยาลัยสงฆ์ชัยภูมิ (ชย)
33. `SANGHA-RET`: วิทยาลัยสงฆ์ร้อยเอ็ด (รอ)
34. `SANGHA-RBR`: วิทยาลัยสงฆ์ราชบุรี (รบ)
35. `SANGHA-PNB-PKP`: วิทยาลัยสงฆ์พ่อขุนผาเมือง จ.เพชรบูรณ์ (พช)
36. `SANGHA-NPT-PSTD`: วิทยาลัยสงฆ์พุทธปัญญาศรีทวารวดี จ.นครปฐม (นฐ)
37. `SANGHA-MKM`: วิทยาลัยสงฆ์มหาสารคาม (มค)
38. `SANGHA-RYG`: วิทยาลัยสงฆ์ระยอง (รย)
39. `SANGHA-PBI`: วิทยาลัยสงฆ์เพชรบุรี (พบ)
40. `SANGHA-TAK`: วิทยาลัยสงฆ์ตาก (ตก)
41. `SANGHA-UTI`: วิทยาลัยสงฆ์อุทัยธานี (อน)
42. `SANGHA-CBI`: วิทยาลัยสงฆ์ชลบุรี (ชบ)
43. `SANGHA-KRI`: วิทยาลัยสงฆ์กาญจนบุรี ศรีไพบูลย์ (กจ)
44. `SANGHA-CTI`: วิทยาลัยสงฆ์จันทบุรี (จบ)
45. `SANGHA-CRI`: วิทยาลัยสงฆ์เชียงราย (ชร)
46. `SANGHA-SNI`: วิทยาลัยสงฆ์สุราษฎร์ธานี (สฎ)
47. `SANGHA-KPT`: วิทยาลัยสงฆ์กำแพงเพชร (กพ)
48. `SANGHA-SKA`: วิทยาลัยสงฆ์สงขลา (สข)

### 4.4 หน่วยวิทยบริการ (3 แห่ง)
49. `UNIT-UTT`: หน่วยวิทยบริการ จังหวัดอุตรดิตถ์ (อต)
50. `UNIT-KSN`: หน่วยวิทยบริการ จังหวัดกาฬสินธุ์ (กส)
51. `UNIT-SKM`: หน่วยวิทยบริการ จังหวัดสมุทรสงคราม (สส)

---

## 5. การจัดวางโครงสร้างโค้ด (Source Code Mapping)

```text
src/
├── features/
│   ├── news/                     # ระบบข่าวสารประชาสัมพันธ์
│   ├── calendar/                 # ระบบปฏิทินปฏิบัติธรรม 52 ส่วนงาน
│   ├── course-ug/                # โมดูล 1: ปริญญาตรี (10 วัน x 4 ปี)
│   ├── course-grad/              # โมดูล 2: บัณฑิตศึกษา (สะสม 30/45 วัน + One-time Final Submit)
│   ├── course-public/            # โมดูล 3: ประชาชนทั่วไป (โควตา + Waiting List + SAR)
│   └── org-units/                # การจัดการข้อมูล 52 ส่วนงาน
└── app/
    ├── (public)/                 # เส้นทางหน้าบ้าน (Portal)
    │   ├── news/
    │   ├── calendar/
    │   ├── ug/register/
    │   ├── grad/progress/
    │   └── public/events/
    └── (admin)/                  # เส้นทางหลังบ้าน (Admin Console)
        ├── ug/attendance/
        ├── grad/approvals/
        ├── public/sar/
        └── org-units/
```
