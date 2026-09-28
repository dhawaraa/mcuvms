<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ใบลงเวลาการปฏิบัติวิปัสสนากรรมฐาน (10 วัน) - MCUVMS Admin</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@300;400;500;600;700&family=Prompt:wght@400;500;600;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Lucide Icons -->
    <script src="/assets/js/lucide.min.js"></script>

    <!-- Tailwind CSS -->
    <script src="/assets/js/tailwindcss.min.js"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Sarabun', 'sans-serif'],
                        heading: ['Prompt', 'sans-serif'],
                        mono: ['Inter', 'monospace'],
                    },
                    colors: {
                        earth: {
                            sand: '#F7F5EE',
                            stone: '#EAE5D9',
                            clay: '#C86D51',
                            clayDark: '#A85238',
                            forest: '#2C3E2D',
                            olive: '#5A6B47',
                            bark: '#4A3B32',
                            cream: '#FAF8F2',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        body { 
            font-family: 'Sarabun', sans-serif; 
            background: #F4F1EA; 
            color: #2D2A26;
        }
        h1, h2, h3, h4, .font-heading { font-family: 'Prompt', sans-serif; }

        .earth-admin-card {
            background: rgba(255, 255, 255, 0.94);
            backdrop-filter: blur(14px);
            border: 1px solid rgba(220, 215, 201, 0.85);
            box-shadow: 0 10px 25px -10px rgba(74, 59, 50, 0.05);
            border-radius: 1.25rem;
        }

        /* Print Specific CSS */
        @media print {
            body {
                background: white !important;
                color: black !important;
            }
            .no-print {
                display: none !important;
            }
            .print-only {
                display: block !important;
            }
            .page-break {
                page-break-after: always;
            }
            .print-container {
                padding: 0 !important;
                margin: 0 !important;
                max-width: 100% !important;
                box-shadow: none !important;
                border: none !important;
            }
            table {
                width: 100% !important;
                border-collapse: collapse !important;
            }
            th, td {
                border: 1px solid #444 !important;
                padding: 4px 6px !important;
                font-size: 9pt !important;
            }
            th {
                background-color: #eee !important;
            }
        }
    </style>
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/mcu-logo.png') }}">
    <link rel="shortcut icon" href="{{ asset('images/mcu-logo.png') }}">
</head>
<body class="antialiased min-h-screen flex flex-col md:flex-row selection:bg-[#5A6B47] selection:text-white">

    <!-- Earth Tones Sidebar (Deep Forest & Olive) with Collapsible Submenus -->
    @include('admin.layouts.sidebar')

    <!-- Main Content -->
    <main class="flex-grow p-6 md:p-10 overflow-y-auto print-container">
        
        <!-- Header - ซ่อนเมื่อสั่งพิมพ์ -->
        <div class="no-print flex flex-col sm:flex-row justify-between sm:items-center pb-6 mb-8 border-b border-[#D5CEBC] gap-4">
            <div>
                <div class="flex items-center gap-2 mb-1">
                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-semibold tracking-wider uppercase bg-[#5A6B47]/15 text-[#5A6B47] border border-[#5A6B47]/30">
                        <i data-lucide="printer" class="w-3 h-3 inline mr-1"></i> A4 Print-ready & Registrar Export
                    </span>
                </div>
                <h1 class="text-2xl font-heading font-bold text-[#2C3E2D]">พิมพ์ใบเซ็นชื่อ & ส่งออกข้อมูลฝ่ายทะเบียน</h1>
                <p class="text-xs text-[#7B8D65] mt-1 font-medium">ใบลงเวลาปฏิบัติวิปัสสนากรรมฐาน 10 วัน ประจำโครงการ และระบบส่งออกไฟล์ CSV/Excel ส่งฝ่ายทะเบียนและวัดผล</p>
            </div>
            
            <div class="flex items-center gap-2">
                <button onclick="window.print()" class="bg-[#5A6B47] hover:bg-[#2C3E2D] text-white px-4 py-2.5 rounded-xl text-xs font-medium transition flex items-center gap-2 shadow-sm">
                    <i data-lucide="printer" class="w-4 h-4"></i> พิมพ์ใบเซ็นชื่อ (Print A4)
                </button>
                <a href="{{ route('admin.ug.export', ['batch_id' => $selectedBatchId]) }}" class="bg-[#2C3E2D] hover:bg-[#1E2B1F] text-white px-4 py-2.5 rounded-xl text-xs font-medium transition flex items-center gap-2 shadow-sm">
                    <i data-lucide="download" class="w-4 h-4 text-[#A3B88C]"></i> Export CSV
                </a>
            </div>
        </div>

        <!-- แถบเลือกโครงการ & ค้นหา (no-print) -->
        <div class="no-print earth-admin-card p-5 mb-8 flex flex-col md:flex-row justify-between items-center gap-4 bg-white">
            <div class="w-full md:w-auto flex-grow flex items-center gap-3">
                <label class="text-xs font-semibold text-[#6B6357] whitespace-nowrap flex items-center gap-1 font-mono">
                    <i data-lucide="calendar" class="w-4 h-4 text-[#5A6B47]"></i> เลือกรอบโครงการ:
                </label>
                <form method="GET" action="{{ route('admin.ug.attendance') }}" id="batchForm" class="flex-grow max-w-xl">
                    <select name="batch_id" onchange="document.getElementById('batchForm').submit()" class="w-full px-3.5 py-2 bg-[#FAF8F2] border border-[#D5CEBC] rounded-xl text-xs font-medium text-[#2C3E2D] focus:ring-2 focus:ring-[#5A6B47] focus:outline-none">
                        @foreach ($batches as $b)
                            <option value="{{ $b->id }}" {{ $selectedBatchId == $b->id ? 'selected' : '' }}>
                                ปี {{ $b->academic_year }}: {{ $b->title }} ({{ $b->organizationUnit->name_th ?? 'มจร' }})
                            </option>
                        @endforeach
                    </select>
                </form>
            </div>

            <div class="text-xs text-[#7B8D65] flex items-center gap-3">
                <span>ยอดนิสิตในรอบนี้: <strong class="text-[#2C3E2D] font-mono text-sm">{{ count($registrations) }}</strong> ท่าน</span>
            </div>
        </div>

        <!-- หน้าเอกสารทางการ (Document Canvas) จัดสไตล์ให้พิมพ์สวยงาม -->
        <div class="bg-white border border-[#D5CEBC] p-8 md:p-12 rounded-2xl shadow-sm text-[#2D2A26]">
            
            <!-- Document Header -->
            <div class="text-center mb-6 pb-4 border-b-2 border-black/80">
                <div class="w-14 h-14 mx-auto mb-2">
                    <img src="{{ asset('images/mcu-logo.png') }}" alt="MCU Logo" class="w-full h-full object-contain">
                </div>
                <h2 class="text-lg md:text-xl font-heading font-bold text-black uppercase tracking-wide">
                    มหาวิทยาลัยมหาจุฬาลงกรณราชวิทยาลัย
                </h2>
                <h3 class="text-base font-heading font-semibold text-black mt-0.5">
                    ใบลงเวลาและการประเมินผลการปฏิบัติวิปัสสนากรรมฐาน (หลักสูตรปริญญาตรี 10 วัน)
                </h3>
                
                @if ($selectedBatch)
                    <div class="text-xs text-gray-800 mt-2 font-medium">
                        <strong>โครงการ:</strong> {{ $selectedBatch->title }} &bull; 
                        <strong>ปีการศึกษา:</strong> {{ $selectedBatch->academic_year }} &bull; 
                        <strong>ส่วนงาน:</strong> {{ $selectedBatch->organizationUnit->name_th ?? 'มจร' }}
                    </div>
                    <div class="text-xs text-gray-700 mt-1">
                        <strong>สถานที่ปฏิบัติ:</strong> {{ $selectedBatch->location }} &bull; 
                        <strong>ระยะเวลา:</strong> {{ \Carbon\Carbon::parse($selectedBatch->start_date)->format('d/m/Y') }} ถึง {{ \Carbon\Carbon::parse($selectedBatch->end_date)->format('d/m/Y') }}
                    </div>
                @endif
            </div>

            <!-- Attendance Table -->
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs border border-gray-400">
                    <thead class="bg-gray-100 text-black font-semibold text-center text-[10px] uppercase border-b border-gray-400">
                        <tr>
                            <th class="p-2 border border-gray-400 w-8" rowspan="2">ที่</th>
                            <th class="p-2 border border-gray-400 w-24" rowspan="2">รหัสนิสิต</th>
                            <th class="p-2 border border-gray-400 min-w-[150px] text-left" rowspan="2">ชื่อ - ฉายา - นามสกุล</th>
                            <th class="p-2 border border-gray-400 w-12 text-center" rowspan="2">ชั้นปี</th>
                            <th class="p-2 border border-gray-400 whitespace-nowrap text-left px-3" rowspan="2">คณะ</th>
                            <th class="p-1 border border-gray-400" colspan="10">การลงเวลาปฏิบัติธรรมประจำวัน (วันที่ 1 - 10)</th>
                            <th class="p-2 border border-gray-400 w-16" rowspan="2">สถานะ</th>
                            <th class="p-2 border border-gray-400 w-16" rowspan="2">ผลการประเมิน</th>
                        </tr>
                        <tr>
                            @for ($d = 1; $d <= 10; $d++)
                                <th class="p-1 border border-gray-400 w-7 text-center">{{ $d }}</th>
                            @endfor
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-300">
                        @forelse ($registrations as $idx => $r)
                            <tr class="hover:bg-gray-50">
                                <td class="p-2 border border-gray-300 text-center font-mono">{{ $idx + 1 }}</td>
                                <td class="p-2 border border-gray-300 font-mono font-semibold">{{ $r->student_code }}</td>
                                <td class="p-2 border border-gray-300">
                                    <div class="font-medium text-black">
                                        {{ $r->prefix . $r->first_name . ' ' . $r->last_name }}
                                        @if(!empty($r->chaya))
                                            <span class="text-gray-600">({{ $r->chaya }})</span>
                                        @endif
                                    </div>
                                    <div class="text-[10px] text-gray-500 font-mono no-print">{{ $r->registration_no }}</div>
                                </td>
                                <td class="p-2 border border-gray-300 text-center font-mono font-medium text-[11px] whitespace-nowrap">
                                    ปี {{ $r->study_year ?? 1 }}
                                </td>
                                <td class="p-2 px-3 border border-gray-300 text-left text-[11px] font-medium text-gray-800 whitespace-nowrap">
                                    {{ $r->faculty ?? 'ไม่ระบุ' }}
                                </td>
                                
                                <!-- 10 Days Attendance Check Boxes -->
                                @for ($d = 1; $d <= 10; $d++)
                                    <td class="p-1 border border-gray-300 text-center">
                                        @if ($r->status === 'COMPLETED' || ($r->status === 'CHECKED_IN' && $d == 1))
                                            <span class="text-xs text-black font-serif font-bold">&#10003;</span>
                                        @else
                                            <span class="text-gray-300 text-[10px]">&bull;</span>
                                        @endif
                                    </td>
                                @endfor

                                <td class="p-2 border border-gray-300 text-center text-[10px] whitespace-nowrap">
                                    @if ($r->status === 'COMPLETED')
                                        <span class="font-semibold text-emerald-800">ผ่านครบ 10 วัน</span>
                                    @elseif ($r->status === 'CHECKED_IN')
                                        <span class="text-blue-800">รายงานตัวแล้ว</span>
                                    @else
                                        <span class="text-gray-600">รอรายงานตัว</span>
                                    @endif
                                </td>
                                <td class="p-2 border border-gray-300 text-center font-mono font-semibold text-[11px] whitespace-nowrap">
                                    {{ $r->status === 'COMPLETED' ? 'P (ผ่าน)' : '-' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="17" class="text-center py-8 text-gray-500 border border-gray-300">
                                    ยังไม่มีรายชื่อนิสิตลงทะเบียนในโครงการนี้
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Signature Section (ลงนามท้ายเอกสาร) -->
            <div class="mt-12 pt-6 border-t border-gray-300 grid grid-cols-2 gap-8 text-xs text-center">
                <div>
                    <div class="mb-14">ลงชื่อ.............................................................. เจ้าหน้าที่ผู้รับรายงานตัว</div>
                    <div class="font-semibold">(..............................................................)</div>
                    <div class="text-gray-600 mt-1">ตำแหน่ง เจ้าหน้าที่ประสานงานวิปัสสนากรรมฐาน</div>
                </div>
                <div>
                    <div class="mb-14">ลงชื่อ.............................................................. พระวิปัสสนาจารย์ / ผู้รับผิดชอบ</div>
                    <div class="font-semibold">(..............................................................)</div>
                    <div class="text-gray-600 mt-1">ผู้อำนวยการส่วนงาน / พระอาจารย์ใหญ่ฝ่ายวิปัสสนาธุระ</div>
                </div>
            </div>

        </div>

    </main>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>
