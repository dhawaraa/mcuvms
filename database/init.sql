-- MCUVMS Database Schema (MariaDB / MySQL 8.0)
-- ระบบสารสนเทศการปฏิบัติวิปัสสนากรรมฐาน มจร 52 ส่วนงาน

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- 1. ตารางส่วนงาน 52 แห่ง (Organization Units)
DROP TABLE IF EXISTS `organization_units`;
CREATE TABLE `organization_units` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `code` VARCHAR(50) NOT NULL UNIQUE,
  `name_th` VARCHAR(255) NOT NULL,
  `name_en` VARCHAR(255) NULL,
  `type` ENUM('CENTRAL', 'CAMPUS', 'SANGHA_COLLEGE', 'ACADEMIC_UNIT') NOT NULL DEFAULT 'CAMPUS',
  `province_th` VARCHAR(100) NULL,
  `province_code` VARCHAR(10) NULL,
  `is_active` TINYINT(1) NOT NULL DEFAULT 1,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 2. ตารางผู้ใช้งานและบทบาท (Users & Roles)
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `org_unit_id` INT NULL,
  `username` VARCHAR(50) NOT NULL UNIQUE,
  `password_hash` VARCHAR(255) NOT NULL,
  `full_name` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NULL,
  `role` ENUM('SUPER_ADMIN', 'CENTRAL_OFFICER', 'CAMPUS_ADMIN', 'VIPASSANA_MASTER', 'GRAD_OFFICER', 'PUBLIC_STAFF') NOT NULL DEFAULT 'CAMPUS_ADMIN',
  `is_active` TINYINT(1) NOT NULL DEFAULT 1,
  `last_login_at` DATETIME NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`org_unit_id`) REFERENCES `organization_units` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 3. ตารางข่าวสารประชาสัมพันธ์ (News & Announcements)
DROP TABLE IF EXISTS `news_articles`;
CREATE TABLE `news_articles` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `org_unit_id` INT NULL,
  `title` VARCHAR(255) NOT NULL,
  `content` TEXT NOT NULL,
  `cover_image` VARCHAR(500) NULL,
  `category` ENUM('ANNOUNCEMENT', 'MEDITATION', 'ACADEMIC', 'GENERAL') NOT NULL DEFAULT 'GENERAL',
  `is_pinned` TINYINT(1) NOT NULL DEFAULT 0,
  `status` ENUM('DRAFT', 'PUBLISHED', 'ARCHIVED') NOT NULL DEFAULT 'PUBLISHED',
  `views` INT NOT NULL DEFAULT 0,
  `published_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`org_unit_id`) REFERENCES `organization_units` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 4. ตารางปฏิทินปฏิบัติธรรม 52 หน่วยงาน (Meditation Calendar)
DROP TABLE IF EXISTS `meditation_calendars`;
CREATE TABLE `meditation_calendars` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `org_unit_id` INT NOT NULL,
  `academic_year` INT NOT NULL,
  `title` VARCHAR(255) NOT NULL,
  `target_group` ENUM('UG', 'GRAD', 'PUBLIC', 'ALL') NOT NULL DEFAULT 'ALL',
  `start_date` DATE NOT NULL,
  `end_date` DATE NOT NULL,
  `total_days` INT NOT NULL,
  `location_name` VARCHAR(255) NOT NULL,
  `max_seats` INT NOT NULL DEFAULT 0,
  `status` ENUM('OPEN', 'CLOSED', 'COMPLETED', 'CANCELLED') NOT NULL DEFAULT 'OPEN',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`org_unit_id`) REFERENCES `organization_units` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 5. โมดูล 1: ปริญญาตรี (10 วัน x 4 ปี)
DROP TABLE IF EXISTS `ug_batches`;
CREATE TABLE `ug_batches` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `org_unit_id` INT NOT NULL,
  `academic_year` INT NOT NULL,
  `batch_no` INT NOT NULL,
  `title` VARCHAR(255) NOT NULL,
  `location` VARCHAR(255) NOT NULL DEFAULT 'ศูนย์พัฒนาศาสนศึกษา / อาคารปฏิบัติธรรมประจำวิทยาเขต',
  `start_date` DATE NOT NULL,
  `end_date` DATE NOT NULL,
  `max_quota` INT NOT NULL DEFAULT 100,
  `status` ENUM('OPEN', 'CLOSED', 'IN_PROGRESS', 'COMPLETED') NOT NULL DEFAULT 'OPEN',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`org_unit_id`) REFERENCES `organization_units` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `ug_registrations`;
CREATE TABLE `ug_registrations` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `batch_id` INT NOT NULL,
  `student_id` VARCHAR(20) NOT NULL,
  `citizen_id` VARCHAR(13) NOT NULL,
  `prefix` VARCHAR(20) NULL,
  `full_name` VARCHAR(255) NOT NULL,
  `org_unit_id` INT NOT NULL,
  `faculty` VARCHAR(100) NULL,
  `major` VARCHAR(100) NULL,
  `class_year` TINYINT NOT NULL DEFAULT 1,
  `program_type` ENUM('NORMAL', 'SPECIAL') NOT NULL DEFAULT 'NORMAL',
  `phone` VARCHAR(30) NULL,
  `checkin_token` VARCHAR(64) NOT NULL UNIQUE,
  `checkin_status` TINYINT(1) NOT NULL DEFAULT 0,
  `final_result` ENUM('PENDING', 'PASSED', 'FAILED', 'ABSENT') NOT NULL DEFAULT 'PENDING',
  `registered_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`batch_id`) REFERENCES `ug_batches` (`id`) ON DELETE CASCADE,
  FOREIGN KEY (`org_unit_id`) REFERENCES `organization_units` (`id`) ON DELETE CASCADE,
  UNIQUE KEY `unique_student_batch` (`batch_id`, `student_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 6. โมดูล 2: บัณฑิตศึกษา (สะสม 30/45 วัน)
DROP TABLE IF EXISTS `grad_students`;
CREATE TABLE `grad_students` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `student_id` VARCHAR(20) NOT NULL UNIQUE,
  `citizen_id` VARCHAR(13) NOT NULL,
  `full_name` VARCHAR(255) NOT NULL,
  `degree_level` ENUM('MASTER', 'DOCTORAL') NOT NULL DEFAULT 'MASTER',
  `target_days` INT NOT NULL DEFAULT 30,
  `accumulated_days` INT NOT NULL DEFAULT 0,
  `org_unit_id` INT NOT NULL,
  `faculty` VARCHAR(100) NULL,
  `major` VARCHAR(100) NULL,
  `submission_status` ENUM('ACCUMULATING', 'READY', 'SUBMITTED', 'RETURNED', 'APPROVED', 'REJECTED') NOT NULL DEFAULT 'ACCUMULATING',
  `return_reason` TEXT NULL,
  `approved_at` DATETIME NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`org_unit_id`) REFERENCES `organization_units` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `grad_credit_entries`;
CREATE TABLE `grad_credit_entries` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `student_id` VARCHAR(20) NOT NULL,
  `temple_name` VARCHAR(255) NOT NULL,
  `master_name` VARCHAR(255) NOT NULL,
  `province` VARCHAR(100) NULL,
  `start_date` DATE NOT NULL,
  `end_date` DATE NOT NULL,
  `days_earned` INT NOT NULL,
  `evidence_file` VARCHAR(500) NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`student_id`) REFERENCES `grad_students` (`student_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 7. โมดูล 3: ประชาชนทั่วไป (โควตา + Waiting List + SAR)
DROP TABLE IF EXISTS `public_events`;
CREATE TABLE `public_events` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `org_unit_id` INT NOT NULL,
  `title` VARCHAR(255) NOT NULL,
  `start_date` DATE NOT NULL,
  `end_date` DATE NOT NULL,
  `max_quota` INT NOT NULL DEFAULT 50,
  `confirmed_count` INT NOT NULL DEFAULT 0,
  `waiting_count` INT NOT NULL DEFAULT 0,
  `location_name` VARCHAR(255) NOT NULL,
  `status` ENUM('OPEN', 'CLOSED', 'COMPLETED') NOT NULL DEFAULT 'OPEN',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`org_unit_id`) REFERENCES `organization_units` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `public_registrations`;
CREATE TABLE `public_registrations` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `event_id` INT NOT NULL,
  `citizen_id` VARCHAR(13) NOT NULL,
  `prefix` VARCHAR(20) NULL,
  `full_name` VARCHAR(255) NOT NULL,
  `gender` ENUM('MALE', 'FEMALE', 'OTHER') NOT NULL,
  `age` INT NOT NULL,
  `phone` VARCHAR(30) NOT NULL,
  `province` VARCHAR(100) NULL,
  `emergency_contact` VARCHAR(255) NULL,
  `emergency_phone` VARCHAR(30) NULL,
  `congenital_disease` VARCHAR(255) NULL,
  `dietary_restriction` VARCHAR(100) NULL,
  `queue_no` INT NOT NULL,
  `status` ENUM('CONFIRMED', 'WAITING_LIST', 'CANCELLED', 'ATTENDED') NOT NULL DEFAULT 'CONFIRMED',
  `registered_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`event_id`) REFERENCES `public_events` (`id`) ON DELETE CASCADE,
  UNIQUE KEY `unique_public_event` (`event_id`, `citizen_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -------------------------------------------------------------
-- Seed Data: บัญชีผู้ดูแลระบบตั้งต้น (admin / password)
-- -------------------------------------------------------------
-- รหัสผ่าน hash สำหรับคำว่า 'password'
INSERT INTO `users` (`username`, `password_hash`, `full_name`, `email`, `role`, `org_unit_id`, `is_active`)
VALUES 
('admin', '$2y$12$XDe43h2HZhg2DwbxUyqjMe6mlHaZWN.hf.pmu1LPJ9LkpHFSt.B/S', 'ผู้ดูแลระบบสูงสุด (Super Admin)', 'admin@mcu.ac.th', 'SUPER_ADMIN', NULL, 1),
('central', '$2y$12$XDe43h2HZhg2DwbxUyqjMe6mlHaZWN.hf.pmu1LPJ9LkpHFSt.B/S', 'เจ้าหน้าที่สถาบันวิปัสสนาธุระ ส่วนกลาง (Central Officer)', 'central@mcu.ac.th', 'CENTRAL_OFFICER', 1, 1),
('officer_cmi', '$2y$12$XDe43h2HZhg2DwbxUyqjMe6mlHaZWN.hf.pmu1LPJ9LkpHFSt.B/S', 'เจ้าหน้าที่วิปัสสนา วิทยาเขตเชียงใหม่', 'cmi@mcu.ac.th', 'CAMPUS_ADMIN', 10, 1),
('officer_kkn', '$2y$12$XDe43h2HZhg2DwbxUyqjMe6mlHaZWN.hf.pmu1LPJ9LkpHFSt.B/S', 'เจ้าหน้าที่วิปัสสนา วิทยาเขตขอนแก่น', 'kkn@mcu.ac.th', 'CAMPUS_ADMIN', 11, 1);

-- -------------------------------------------------------------
-- Seed Data: 52 ส่วนงานของ มจร ตามรหัสมาตรฐานจังหวัด
-- -------------------------------------------------------------
INSERT INTO `organization_units` (`code`, `name_th`, `type`, `province_th`, `province_code`) VALUES
('MCU-GRAD', 'บัณฑิตวิทยาลัย', 'CENTRAL', 'พระนครศรีอยุธยา', 'AYA'),
('MCU-BUD', 'คณะพุทธศาสตร์', 'CENTRAL', 'พระนครศรีอยุธยา', 'AYA'),
('MCU-EDU', 'คณะครุศาสตร์', 'CENTRAL', 'พระนครศรีอยุธยา', 'AYA'),
('MCU-HUM', 'คณะมนุษยศาสตร์', 'CENTRAL', 'พระนครศรีอยุธยา', 'AYA'),
('MCU-SOC', 'คณะสังคมศาสตร์', 'CENTRAL', 'พระนครศรีอยุธยา', 'AYA'),
('MCU-IBSC', 'วิทยาลัยพุทธศาสตร์นานาชาติ', 'CENTRAL', 'พระนครศรีอยุธยา', 'AYA'),
('MCU-DDT', 'วิทยาลัยพระธรรมทูต', 'CENTRAL', 'พระนครศรีอยุธยา', 'AYA'),
('CAMPUS-NKI', 'วิทยาเขตหนองคาย', 'CAMPUS', 'หนองคาย', 'NKI'),
('CAMPUS-NRT', 'วิทยาเขตนครศรีธรรมราช', 'CAMPUS', 'นครศรีธรรมราช', 'NRT'),
('CAMPUS-CMI', 'วิทยาเขตเชียงใหม่', 'CAMPUS', 'เชียงใหม่', 'CMI'),
('CAMPUS-KKN', 'วิทยาเขตขอนแก่น', 'CAMPUS', 'ขอนแก่น', 'KKN'),
('CAMPUS-NMA', 'วิทยาเขตนครราชสีมา', 'CAMPUS', 'นครราชสีมา', 'NMA'),
('CAMPUS-UBN', 'วิทยาเขตอุบลราชธานี', 'CAMPUS', 'อุบลราชธานี', 'UBN'),
('CAMPUS-PRE', 'วิทยาเขตแพร่', 'CAMPUS', 'แพร่', 'PRE'),
('CAMPUS-SRN', 'วิทยาเขตสุรินทร์', 'CAMPUS', 'สุรินทร์', 'SRN'),
('CAMPUS-PYO', 'วิทยาเขตพะเยา', 'CAMPUS', 'พะเยา', 'PYO'),
('CAMPUS-NPT-BP', 'วิทยาเขตบาฬีศึกษาพุทธโฆส', 'CAMPUS', 'นครปฐม', 'NPT'),
('CAMPUS-NSN', 'วิทยาเขตนครสวรรค์', 'CAMPUS', 'นครสวรรค์', 'NSN'),
('CAMPUS-NAN', 'วิทยาเขตนครน่าน เฉลิมพระเกียรติฯ', 'CAMPUS', 'น่าน', 'NAN'),
('CAMPUS-NPT-MVBR', 'มหาวชิราลงกรณบาลีเถรวาทราชวิทยาลัย', 'CAMPUS', 'นครปฐม', 'NPT'),
('SANGHA-LEI', 'วิทยาลัยสงฆ์เลย', 'SANGHA_COLLEGE', 'เลย', 'LEI'),
('SANGHA-NPM', 'วิทยาลัยสงฆ์นครพนม', 'SANGHA_COLLEGE', 'นครพนม', 'NPM'),
('SANGHA-LPN', 'วิทยาลัยสงฆ์ลำพูน', 'SANGHA_COLLEGE', 'ลำพูน', 'LPN'),
('SANGHA-PLK-PCN', 'วิทยาลัยสงฆ์พุทธชินราช', 'SANGHA_COLLEGE', 'พิษณุโลก', 'PLK'),
('SANGHA-PTN', 'วิทยาลัยสงฆ์ปัตตานี', 'SANGHA_COLLEGE', 'ปัตตานี', 'PTN'),
('SANGHA-BRM', 'วิทยาลัยสงฆ์บุรีรัมย์', 'SANGHA_COLLEGE', 'บุรีรัมย์', 'BRM'),
('SANGHA-LPG', 'วิทยาลัยสงฆ์นครลำปาง', 'SANGHA_COLLEGE', 'ลำปาง', 'LPG'),
('SANGHA-SSK', 'วิทยาลัยสงฆ์ศรีสะเกษ', 'SANGHA_COLLEGE', 'ศรีสะเกษ', 'SSK'),
('SANGHA-CCO-PTS', 'วิทยาลัยสงฆ์พุทธโสธร', 'SANGHA_COLLEGE', 'ฉะเชิงเทรา', 'CCO'),
('SANGHA-SPB', 'วิทยาลัยสงฆ์สุพรรณบุรีศรีสุวรรณภูมิ', 'SANGHA_COLLEGE', 'สุพรรณบุรี', 'SPB'),
('SANGHA-PCT', 'วิทยาลัยสงฆ์พิจิตร', 'SANGHA_COLLEGE', 'พิจิตร', 'PCT'),
('SANGHA-CPM', 'วิทยาลัยสงฆ์ชัยภูมิ', 'SANGHA_COLLEGE', 'ชัยภูมิ', 'CPM'),
('SANGHA-RET', 'วิทยาลัยสงฆ์ร้อยเอ็ด', 'SANGHA_COLLEGE', 'ร้อยเอ็ด', 'RET'),
('SANGHA-RBR', 'วิทยาลัยสงฆ์ราชบุรี', 'SANGHA_COLLEGE', 'ราชบุรี', 'RBR'),
('SANGHA-PNB-PKP', 'วิทยาลัยสงฆ์พ่อขุนผาเมือง', 'SANGHA_COLLEGE', 'เพชรบูรณ์', 'PNB'),
('SANGHA-NPT-PSTD', 'วิทยาลัยสงฆ์พุทธปัญญาศรีทวารวดี', 'SANGHA_COLLEGE', 'นครปฐม', 'NPT'),
('SANGHA-MKM', 'วิทยาลัยสงฆ์มหาสารคาม', 'SANGHA_COLLEGE', 'มหาสารคาม', 'MKM'),
('SANGHA-RYG', 'วิทยาลัยสงฆ์ระยอง', 'SANGHA_COLLEGE', 'ระยอง', 'RYG'),
('SANGHA-PBI', 'วิทยาลัยสงฆ์เพชรบุรี', 'SANGHA_COLLEGE', 'เพชรบุรี', 'PBI'),
('SANGHA-TAK', 'วิทยาลัยสงฆ์ตาก', 'SANGHA_COLLEGE', 'ตาก', 'TAK'),
('SANGHA-UTI', 'วิทยาลัยสงฆ์อุทัยธานี', 'SANGHA_COLLEGE', 'อุทัยธานี', 'UTI'),
('SANGHA-CBI', 'วิทยาลัยสงฆ์ชลบุรี', 'SANGHA_COLLEGE', 'ชลบุรี', 'CBI'),
('SANGHA-KRI', 'วิทยาลัยสงฆ์กาญจนบุรี ศรีไพบูลย์', 'SANGHA_COLLEGE', 'กาญจนบุรี', 'KRI'),
('SANGHA-CTI', 'วิทยาลัยสงฆ์จันทบุรี', 'SANGHA_COLLEGE', 'จันทบุรี', 'CTI'),
('SANGHA-CRI', 'วิทยาลัยสงฆ์เชียงราย', 'SANGHA_COLLEGE', 'เชียงราย', 'CRI'),
('SANGHA-SNI', 'วิทยาลัยสงฆ์สุราษฎร์ธานี', 'SANGHA_COLLEGE', 'สุราษฎร์ธานี', 'SNI'),
('SANGHA-KPT', 'วิทยาลัยสงฆ์กำแพเพชร', 'SANGHA_COLLEGE', 'กำแพงเพชร', 'KPT'),
('SANGHA-SKA', 'วิทยาลัยสงฆ์สงขลา', 'SANGHA_COLLEGE', 'สงขลา', 'SKA'),
('UNIT-UTT', 'หน่วยวิทยบริการ จังหวัดอุตรดิตถ์', 'ACADEMIC_UNIT', 'อุตรดิตถ์', 'UTT'),
('UNIT-KSN', 'หน่วยวิทยบริการ จังหวัดกาฬสินธุ์', 'ACADEMIC_UNIT', 'กาฬสินธุ์', 'KSN'),
('UNIT-SKM', 'หน่วยวิทยบริการ จังหวัดสมุทรสงคราม', 'ACADEMIC_UNIT', 'สมุทรสงคราม', 'SKM');

SET FOREIGN_KEY_CHECKS = 1;
