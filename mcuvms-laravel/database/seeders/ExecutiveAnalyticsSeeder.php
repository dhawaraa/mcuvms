<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\OrganizationUnit;
use App\Models\UgBatch;
use App\Models\UgRegistration;
use App\Models\GradStudent;
use App\Models\GradCreditEntry;
use App\Models\PublicEvent;
use App\Models\PublicRegistration;

class ExecutiveAnalyticsSeeder extends Seeder
{
    public function run()
    {
        // 1. ตรวจสอบว่ามี Public Events สำหรับส่วนงานต่าง ๆ หรือไม่
        $events = [
            [
                'org_unit_id' => 1, // บัณฑิตวิทยาลัย / ส่วนกลาง
                'title' => 'โครงการปฏิบัติธรรมสำหรับประชาชนทั่วไปและบุคลากร รุ่นที่ 1/2569',
                'start_date' => '2569-04-10',
                'end_date' => '2569-04-13',
                'max_quota' => 120,
                'confirmed_count' => 115,
                'waiting_count' => 12,
                'location_name' => 'อาคารมหาจุฬาบรรณาคาร มจร วังน้อย อยุธยา',
                'status' => 'OPEN',
            ],
            [
                'org_unit_id' => 10, // วิทยาเขตเชียงใหม่
                'title' => 'อบรมวิปัสสนากรรมฐานล้านนาเพื่อการพัฒนาจิตและปัญญา',
                'start_date' => '2569-05-01',
                'end_date' => '2569-05-04',
                'max_quota' => 80,
                'confirmed_count' => 80,
                'waiting_count' => 25,
                'location_name' => 'ศูนย์ปฏิบัติธรรม มจร วิทยาเขตเชียงใหม่',
                'status' => 'CLOSED',
            ],
            [
                'org_unit_id' => 11, // วิทยาเขตขอนแก่น
                'title' => 'วิปัสสนากรรมฐานเพื่อสันติสุขในชุมชนอีสาน ประจำปี 2569',
                'start_date' => '2569-06-15',
                'end_date' => '2569-06-18',
                'max_quota' => 100,
                'confirmed_count' => 92,
                'waiting_count' => 8,
                'location_name' => 'หอประชุมสมเด็จพระพุฒาจารย์ มจร วิทยาเขตขอนแก่น',
                'status' => 'OPEN',
            ],
            [
                'org_unit_id' => 12, // วิทยาเขตนครราชสีมา
                'title' => 'คอร์สปฏิบัติธรรมเจริญสติภาวนาสำหรับพุทธศาสนิกชน',
                'start_date' => '2569-07-20',
                'end_date' => '2569-07-23',
                'max_quota' => 60,
                'confirmed_count' => 58,
                'waiting_count' => 5,
                'location_name' => 'อาคารปฏิบัติธรรม มจร นครราชสีมา',
                'status' => 'OPEN',
            ],
        ];

        foreach ($events as $ev) {
            $eventId = DB::table('public_events')->insertGetId(array_merge($ev, [
                'created_at' => now(),
            ]));

            // Seed ประชาชนเข้าร่วม 8 คนต่อ Event
            $sampleNames = [
                ['นาย', 'สมชาย', 'ใจดี', 'MALE', 45, 'กรุงเทพมหานคร'],
                ['นางสาว', 'วราภรณ์', 'ศิริพร', 'FEMALE', 38, 'พระนครศรีอยุธยา'],
                ['นาง', 'ปราณี', 'ทองใบ', 'FEMALE', 52, 'เชียงใหม่'],
                ['นาย', 'กิตติศักดิ์', 'บุญชู', 'MALE', 33, 'ขอนแก่น'],
                ['นาย', 'อภิชาต', 'แสงสุวรรณ', 'MALE', 41, 'นครราชสีมา'],
                ['นางสาว', 'พิมลวรรณ', 'ดวงดี', 'FEMALE', 29, 'นนทบุรี'],
                ['นาย', 'ธนดล', 'ประสิทธิ์', 'MALE', 50, 'ปทุมธานี'],
                ['นาง', 'อรัญญา', 'รักษ์ไทย', 'FEMALE', 47, 'สงขลา'],
            ];

            foreach ($sampleNames as $i => $sn) {
                DB::table('public_registrations')->insert([
                    'event_id' => $eventId,
                    'citizen_id' => '1' . str_pad((string)(rand(10000000000, 99999999999)), 12, '0', STR_PAD_LEFT),
                    'prefix' => $sn[0],
                    'full_name' => $sn[0] . $sn[1] . ' ' . $sn[2],
                    'gender' => $sn[3],
                    'age' => $sn[4],
                    'phone' => '08' . rand(10000000, 99999999),
                    'province' => $sn[5],
                    'emergency_contact' => 'ญาติสายตรง',
                    'emergency_phone' => '08' . rand(10000000, 99999999),
                    'queue_no' => $i + 1,
                    'status' => 'CONFIRMED',
                    'registered_at' => now()->subDays(rand(1, 20)),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        // 2. สร้างรอบโครงการ ป.ตรี ในวิทยาเขตหลัก
        $campusBatches = [
            10 => UgBatch::firstOrCreate(['org_unit_id' => 10, 'academic_year' => 2569], [
                'batch_no' => 1,
                'title' => 'โครงการปฏิบัติธรรม ป.ตรี มจร เชียงใหม่ 2569',
                'location' => 'วัดสวนดอก เชียงใหม่',
                'start_date' => '2569-12-15',
                'end_date' => '2569-12-25',
                'max_quota' => 250,
                'status' => 'OPEN',
            ]),
            11 => UgBatch::firstOrCreate(['org_unit_id' => 11, 'academic_year' => 2569], [
                'batch_no' => 1,
                'title' => 'โครงการปฏิบัติธรรม ป.ตรี มจร ขอนแก่น 2569',
                'location' => 'ศูนย์วิปัสสนา มจร ขอนแก่น',
                'start_date' => '2569-12-15',
                'end_date' => '2569-12-25',
                'max_quota' => 300,
                'status' => 'OPEN',
            ]),
            12 => UgBatch::firstOrCreate(['org_unit_id' => 12, 'academic_year' => 2569], [
                'batch_no' => 1,
                'title' => 'โครงการปฏิบัติธรรม ป.ตรี มจร นครราชสีมา 2569',
                'location' => 'วัดป่าสาลวัน นครราชสีมา',
                'start_date' => '2569-12-15',
                'end_date' => '2569-12-25',
                'max_quota' => 180,
                'status' => 'OPEN',
            ]),
            13 => UgBatch::firstOrCreate(['org_unit_id' => 13, 'academic_year' => 2569], [
                'batch_no' => 1,
                'title' => 'โครงการปฏิบัติธรรม ป.ตรี มจร นครศรีธรรมราช 2569',
                'location' => 'วัดพระมหาธาตุ นครศรีธรรมราช',
                'start_date' => '2569-12-15',
                'end_date' => '2569-12-25',
                'max_quota' => 150,
                'status' => 'OPEN',
            ]),
        ];

        // Seed นักศึกษา ป.ตรี กระจายตามสถานะ
        $names = [
            ['พระ', 'สุริยา', 'เตโช', 'เตชวโร', 'คณะพุทธศาสตร์', 'สาขาวิชาพระพุทธศาสนา'],
            ['พระมหา', 'วรวิทย์', 'ปัญญาดี', 'ญาณสิริ', 'คณะครุศาสตร์', 'สาขาวิชาการสอนภาษาไทย'],
            ['สามเณร', 'ธีรภัทร', 'ใจสว่าง', null, 'คณะมนุษยศาสตร์', 'สาขาวิชาภาษาอังกฤษ'],
            ['นาย', 'อนันต์', 'รักเรียน', null, 'คณะสังคมศาสตร์', 'สาขาวิชารัฐศาสตร์'],
            ['นางสาว', 'ศศิธร', 'มีทรัพย์', null, 'คณะสังคมศาสตร์', 'สาขาวิชาการจัดการเชิงพุทธ'],
            ['พระ', 'คมสันต์', 'จิตมั่น', 'จิตฺตทนฺโต', 'คณะพุทธศาสตร์', 'สาขาวิชาปรัชญา'],
            ['พระครู', 'วินัยธรบุญเลิศ', 'บุญส่ง', 'ฐานทตฺโต', 'คณะครุศาสตร์', 'สาขาวิชาการสอนสังคมศึกษา'],
            ['นาย', 'ณัฐพงษ์', 'ศรีสุข', null, 'คณะมนุษยศาสตร์', 'สาขาวิชาภาษาบาลี'],
        ];

        $regNoCounter = 2000;
        foreach ($campusBatches as $orgId => $batch) {
            foreach ($names as $idx => $n) {
                $statusPool = ['COMPLETED', 'COMPLETED', 'CHECKED_IN', 'REGISTERED'];
                $status = $statusPool[$idx % count($statusPool)];
                $eval = ($status === 'COMPLETED') ? 'PASS' : null;
                $score = ($status === 'COMPLETED') ? rand(85, 98) : null;
                $regNoCounter++;

                UgRegistration::firstOrCreate(
                    [
                        'student_code' => '66' . str_pad((string)($orgId * 1000 + $idx), 8, '0', STR_PAD_RIGHT),
                        'batch_id' => $batch->id,
                    ],
                    [
                        'registration_no' => 'UG-2569-' . $regNoCounter,
                        'org_unit_id' => $orgId,
                        'citizen_id' => '1' . str_pad((string)rand(10000000000, 99999999999), 12, '0', STR_PAD_LEFT),
                        'prefix' => $n[0],
                        'first_name' => $n[1],
                        'last_name' => $n[2],
                        'full_name' => $n[0] . $n[1] . ' ' . $n[2] . ($n[3] ? ' ' . $n[3] : ''),
                        'faculty' => $n[4],
                        'major' => $n[5],
                        'study_year' => ($idx % 4) + 1,
                        'class_year' => ($idx % 4) + 1,
                        'phone' => '08' . rand(10000000, 99999999),
                        'status' => $status,
                        'evaluation_score' => $score,
                        'evaluation_result' => $eval,
                        'checked_in_at' => in_array($status, ['CHECKED_IN', 'COMPLETED']) ? now()->subDays(5) : null,
                        'registered_at' => now()->subDays(10),
                    ]
                );
            }
        }

        // 3. สร้างนิสิตบัณฑิตศึกษาเพิ่มเติมในหลายวิทยาเขต
        $gradPool = [
            ['พระมหาศุภชัย', 'ชยธมฺโม', '6501202005', 10, 'MASTER', 30, 30, 'APPROVED', 'สาขาวิชาวิปัสสนาภาวนา'],
            ['ดร.อานนท์', 'มงคลรัตน์', '6401102008', 10, 'DOCTORAL', 45, 45, 'APPROVED', 'สาขาวิชาพระพุทธศาสนา'],
            ['พระครูสมุห์ประดิษฐ์', 'ฐิตปญฺโญ', '6601202012', 11, 'MASTER', 22, 30, 'ACCUMULATING', 'สาขาวิชาพุทธบริหารการศึกษา'],
            ['ดร.กานดา', 'สุขสมบัติ', '6401102015', 11, 'DOCTORAL', 45, 45, 'SUBMITTED', 'สาขาวิชาปรัชญา'],
            ['พระวิชัย', 'ปภสฺสโร', '6601202020', 12, 'MASTER', 30, 30, 'APPROVED', 'สาขาวิชาพระพุทธศาสนา'],
            ['นางสาวธิดารัตน์', 'เลิศปัญญา', '6501202030', 13, 'MASTER', 18, 30, 'ACCUMULATING', 'สาขาวิชาการพัฒนาสังคมเชิงพุทธ'],
            ['พระมหาวีระ', 'วีรจิตฺโต', '6401102040', 8, 'DOCTORAL', 45, 45, 'APPROVED', 'สาขาวิชาพุทธจิตวิทยา'],
            ['พระมหาประสิทธิ์', 'ญาณโสภโณ', '6501102055', 1, 'MASTER', 30, 30, 'APPROVED', 'สาขาวิชาพระไตรปิฎกศึกษา'],
        ];

        foreach ($gradPool as $g) {
            $student = GradStudent::firstOrCreate(
                ['student_code' => $g[2]],
                [
                    'student_id' => $g[2],
                    'citizen_id' => '1' . str_pad((string)rand(10000000000, 99999999999), 12, '0', STR_PAD_LEFT),
                    'org_unit_id' => $g[3],
                    'prefix' => '',
                    'first_name' => $g[0],
                    'last_name' => $g[1],
                    'full_name' => $g[0] . ' ' . $g[1],
                    'degree_level' => $g[4],
                    'program_name' => $g[8],
                    'faculty' => 'บัณฑิตวิทยาลัย',
                    'target_days' => $g[6],
                    'accumulated_days' => $g[5],
                    'submission_status' => $g[7],
                    'submitted_at' => in_array($g[7], ['SUBMITTED', 'APPROVED']) ? now()->subDays(10) : null,
                    'approved_at' => ($g[7] === 'APPROVED') ? now()->subDays(2) : null,
                    'approved_by' => ($g[7] === 'APPROVED') ? 1 : null,
                    'created_at' => now(),
                ]
            );

            // Seed entries
            if ($g[5] > 0) {
                GradCreditEntry::firstOrCreate(
                    ['student_id' => $student->student_id, 'venue_name' => 'ศูนย์ปฏิบัติธรรม มจร'],
                    [
                        'temple_name' => 'ศูนย์ปฏิบัติธรรม มจร',
                        'master_name' => 'พระอาจารย์วิปัสสนาจารย์',
                        'province' => 'พระนครศรีอยุธยา',
                        'start_date' => '2568-10-01',
                        'end_date' => '2568-10-15',
                        'days_earned' => min($g[5], 15),
                        'days_count' => min($g[5], 15),
                        'evidence_file' => 'uploads/evidence_sample.pdf',
                        'created_at' => now(),
                    ]
                );
            }
        }
    }
}
