<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ระบบสะสมวันและรายงานผลการปฏิบัติธรรม ระดับบัณฑิตศึกษา - MCUVMS</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@300;400;500;600;700&family=Prompt:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Lucide Icons -->
    <script src="/assets/js/lucide.min.js"></script>

    <script src="/assets/js/tailwindcss.min.js"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Sarabun', 'sans-serif'],
                        heading: ['Prompt', 'sans-serif'],
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
                        }
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Sarabun', sans-serif; background-color: #F7F5EE; color: #2D2A26; }
        h1, h2, h3, h4, .font-heading { font-family: 'Prompt', sans-serif; }
    </style>
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/mcu-logo.png') }}">
    <link rel="shortcut icon" href="{{ asset('images/mcu-logo.png') }}">
</head>
<body class="antialiased min-h-screen flex flex-col justify-between">

    <!-- Top Navigation -->
    <nav class="bg-[#FAF8F2] border-b border-[#E3DEC9] sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <a href="{{ route('home') }}" class="flex items-center space-x-3">
                    <img src="{{ asset('images/mcu-logo.png') }}" alt="MCU Logo" class="w-10 h-10 object-contain drop-shadow-sm">
                    <div>
                        <div class="font-heading font-bold text-[#2C3E2D] leading-tight">MCUVMS</div>
                        <div class="text-xs text-[#6B6357]">มหาจุฬาลงกรณราชวิทยาลัย</div>
                    </div>
                </a>
                <div class="flex items-center space-x-3 sm:space-x-4">
                    @php
                        $currentLang = session('locale', 'th');
                    @endphp
                    <!-- Language Switcher (TH / EN) -->
                    <div class="flex items-center bg-[#EAE5D9] p-0.5 rounded-xl border border-[#D5CEBC] text-xs font-bold font-mono">
                        <a href="{{ route('lang.switch', 'th') }}" title="ภาษาไทย" class="px-2 py-1 rounded-lg transition {{ $currentLang === 'th' ? 'bg-[#5A6B47] text-white shadow-sm' : 'text-[#6B6357] hover:text-[#2C3E2D]' }}">
                            TH
                        </a>
                        <a href="{{ route('lang.switch', 'en') }}" title="English" class="px-2 py-1 rounded-lg transition {{ $currentLang === 'en' ? 'bg-[#5A6B47] text-white shadow-sm' : 'text-[#6B6357] hover:text-[#2C3E2D]' }}">
                            EN
                        </a>
                    </div>

                    <a href="{{ route('home') }}" class="text-[#4A3B32] hover:text-[#C86D51] font-semibold text-[15px] flex items-center gap-1.5 transition">
                        <i data-lucide="arrow-left" class="w-4.5 h-4.5 text-[#5A6B47]"></i> <span class="hidden sm:inline">กลับหน้าหลัก</span>
                    </a>
                    <a href="{{ route('login') }}" class="text-[#2C3E2D] hover:text-[#C86D51] font-semibold text-sm border border-[#D5CEBC] px-4 py-2 rounded-xl bg-[#EAE5D9] hover:bg-[#DDD7C8] flex items-center gap-1.5 shadow-sm transition">
                        <i data-lucide="lock" class="w-4 h-4 text-[#5A6B47]"></i> <span class="hidden sm:inline">เจ้าหน้าที่เข้าระบบ</span>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full flex-grow">
        
        <!-- Header Banner (Bark & Forest Earth Tone) -->
        <div class="bg-gradient-to-r from-[#243325] via-[#4A3B32] to-[#2C3E2D] rounded-2xl p-6 md:p-8 text-white shadow-md mb-8 border border-[#3D523E]">
            <div class="inline-flex items-center gap-1.5 px-3 py-1 bg-white/15 backdrop-blur-sm rounded-full text-xs font-semibold uppercase tracking-wider mb-2 border border-white/20">
                <i data-lucide="scroll-text" class="w-3.5 h-3.5 text-[#EAE5D9]"></i>
                <span>โมดูลที่ 2 (Module 2: Graduate Studies)</span>
            </div>
            <h1 class="text-2xl md:text-3xl font-heading font-bold mb-2">ระบบตรวจสอบและสะสมวันปฏิบัติธรรม ระดับบัณฑิตศึกษา</h1>
            <p class="text-[#EAE5D9] text-sm leading-relaxed">
                เกณฑ์มาตรฐานหลักสูตรระดับบัณฑิตศึกษา: <span class="font-semibold text-white">ปริญญาโท สะสมครบ 30 วัน</span> / <span class="font-semibold text-white">ปริญญาเอก สะสมครบ 45 วัน</span> ก่อนยื่นขอสอบวิทยานิพนธ์
            </p>
        </div>

        <!-- Search Box -->
        <div class="bg-white border border-[#E3DEC9] rounded-2xl p-6 shadow-sm mb-8">
            <form action="{{ route('grad.progress') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
                <div class="relative flex-grow">
                    <input type="text" name="student_code" value="{{ $searchCode }}" placeholder="กรอกรหัสนิสิตระดับ ป.โท / ป.เอก เช่น 6501102001" class="w-full px-4 py-2.5 border border-[#D5CEBC] rounded-lg text-sm focus:ring-2 focus:ring-[#5A6B47] font-mono bg-[#FAF8F2]">
                </div>
                <button type="submit" class="bg-[#2C3E2D] hover:bg-[#3D523E] text-white font-medium px-6 py-2.5 rounded-lg text-sm transition flex items-center justify-center gap-2 shadow-sm">
                    <i data-lucide="search" class="w-4 h-4 text-[#A3B88C]"></i>
                    <span>ตรวจสอบประวัติสะสมวัน</span>
                </button>
            </form>
            <div class="text-xs text-[#8C8275] mt-2 flex items-center gap-1.5">
                <i data-lucide="lightbulb" class="w-3.5 h-3.5 text-[#C86D51]"></i>
                <span>ตัวอย่างรหัสนิสิตทดสอบในฐานข้อมูล: <a href="{{ route('grad.progress', ['student_code' => '6501102001']) }}" class="text-[#C86D51] underline font-mono">6501102001</a> (พระมหาบุญช่วย - ป.โท สังคมศาสตร์)</span>
            </div>
        </div>

        @if (request()->has('status') && request()->get('status') === 'submitted')
            <div class="bg-[#E9EFE2] border border-[#CADBC0] rounded-xl p-4 text-[#3D523E] text-sm mb-6 flex items-center gap-3">
                <i data-lucide="lock" class="w-6 h-6 text-[#5A6B47] shrink-0"></i>
                <div>
                    <strong>ยื่นคำขออนุมัติผลเรียบร้อยแล้ว (Locked)</strong> ระบบได้ทำการล็อกข้อมูลของท่านเพื่อให้อาจารย์ที่ปรึกษาและเจ้าหน้าที่บัณฑิตวิทยาลัยตรวจสอบ
                </div>
            </div>
        @endif

        @if ($student)
            @php 
                $target = (int)$student->target_days;
                $accumulated = (int)$student->accumulated_days;
                $percent = min(100, round(($accumulated / $target) * 100));
                $isCompleted = ($accumulated >= $target);
            @endphp

            <!-- Student Profile & Progress Dashboard -->
            <div class="bg-white border border-[#E3DEC9] rounded-2xl p-6 md:p-8 shadow-sm mb-8">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 border-b border-[#E3DEC9] pb-6 mb-6">
                    <div>
                        <div class="flex items-center space-x-2">
                            <span class="px-2.5 py-0.5 rounded text-xs font-semibold {{ $student->degree_level === 'DOCTORAL' ? 'bg-[#F3E7E3] text-[#A85238] border border-[#E8D1CB]' : 'bg-[#EAE5D9] text-[#4A3B32] border border-[#D5CEBC]' }}">
                                {{ $student->degree_level === 'DOCTORAL' ? 'ระดับปริญญาเอก' : 'ระดับปริญญาโท' }}
                            </span>
                            <span class="text-xs text-[#8C8275] font-mono">รหัส: {{ $student->student_code }}</span>
                        </div>
                        <h2 class="text-xl font-heading font-bold text-[#2C3E2D] mt-1">
                            {{ $student->prefix . $student->first_name . ' ' . $student->last_name }}
                        </h2>
                        <div class="text-sm text-[#6B6357] mt-1 flex items-center gap-1.5">
                            <i data-lucide="book-open" class="w-3.5 h-3.5 text-[#5A6B47]"></i>
                            <span>สาขาวิชา: {{ $student->program_name }} • สังกัด: {{ $student->organizationUnit->name_th ?? 'มจร' }}</span>
                        </div>
                    </div>

                    <!-- Status Badge & Certificate Button -->
                    <div class="text-left sm:text-right flex flex-col sm:items-end gap-2">
                        @if ($student->submission_status === 'APPROVED')
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-[#E9EFE2] text-[#3D523E] border border-[#CADBC0]">
                                <i data-lucide="check-circle" class="w-3.5 h-3.5"></i> อนุมัติผ่านเกณฑ์แล้ว
                            </span>
                            <a href="{{ route('grad.certificate', ['code' => $student->student_code ?? $student->student_id]) }}" target="_blank" class="mt-1 inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-xs font-semibold bg-[#2C3E2D] hover:bg-[#3D523E] text-white shadow-sm transition">
                                <i data-lucide="file-check-2" class="w-4 h-4 text-[#A3B88C]"></i>
                                <span>ดาวน์โหลดหนังสือรับรอง (e-Certificate)</span>
                            </a>
                        @elseif ($student->submission_status === 'SUBMITTED')
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-[#F7F0E3] text-[#9E692D] border border-[#ECD9BF]">
                                <i data-lucide="clock" class="w-3.5 h-3.5 animate-spin"></i> อยู่ระหว่างการตรวจผล (Locked)
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-[#EAE5D9] text-[#4A3B32] border border-[#D5CEBC]">
                                <i data-lucide="file-edit" class="w-3.5 h-3.5"></i> กำลังบันทึกสะสม (Draft)
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Progress Bar & Target Gauge -->
                <div class="bg-[#F7F5EE] rounded-xl p-5 border border-[#E3DEC9] mb-6">
                    <div class="flex justify-between items-end mb-2">
                        <div>
                            <div class="text-xs text-[#8C8275] uppercase font-medium">ความคืบหน้าการสะสมวันปฏิบัติธรรม</div>
                            <div class="text-2xl font-heading font-bold text-[#2C3E2D]">
                                {{ $accumulated }} <span class="text-sm font-normal text-[#6B6357]">/ {{ $target }} วัน</span>
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="text-lg font-heading font-bold {{ $isCompleted ? 'text-[#5A6B47]' : 'text-[#C86D51]' }}">{{ $percent }}%</span>
                        </div>
                    </div>
                    <div class="w-full bg-[#EAE5D9] rounded-full h-3 overflow-hidden">
                        <div class="h-3 rounded-full transition-all duration-500 {{ $isCompleted ? 'bg-[#5A6B47]' : 'bg-[#C86D51]' }}" style="width: {{ $percent }}%"></div>
                    </div>
                    <div class="flex justify-between text-[11px] text-[#8C8275] mt-2">
                        <span>เริ่มต้น 0 วัน</span>
                        <span>เกณฑ์ขั้นต่ำ: {{ $target }} วัน</span>
                    </div>
                </div>

                <!-- History Table -->
                <h3 class="font-heading font-semibold text-[#2C3E2D] text-base mb-3 flex items-center justify-between">
                    <span class="flex items-center gap-2">
                        <i data-lucide="clipboard-list" class="w-4 h-4 text-[#5A6B47]"></i>
                        <span>บันทึกประวัติแต่ละรอบ (Accredited Records)</span>
                    </span>
                    <span class="text-xs text-[#8C8275] font-normal">ทั้งหมด {{ count($credits) }} รายการ</span>
                </h3>

                <div class="overflow-x-auto border border-[#E3DEC9] rounded-xl">
                    <table class="w-full text-left text-xs text-[#5A544A]">
                        <thead class="bg-[#FAF8F2] text-[#2C3E2D] font-heading border-b border-[#E3DEC9]">
                            <tr>
                                <th class="p-3">สถานที่ / สำนักปฏิบัติธรรม</th>
                                <th class="p-3">ช่วงเวลา</th>
                                <th class="p-3 text-center">จำนวนวัน</th>
                                <th class="p-3">อาจารย์ผู้สอบอารมณ์ / พระวิปัสสนาจารย์</th>
                                <th class="p-3 text-center">สถานะ</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#EAE5D9]">
                            @forelse ($credits as $c)
                                <tr class="hover:bg-[#F7F5EE]">
                                    <td class="p-3 font-medium text-[#2C3E2D]">{{ $c->venue_name }}</td>
                                    <td class="p-3">{{ $c->start_date }} - {{ $c->end_date }}</td>
                                    <td class="p-3 text-center font-bold text-[#C86D51]">{{ $c->days_count }} วัน</td>
                                    <td class="p-3">{{ $c->master_name }}</td>
                                    <td class="p-3 text-center">
                                        <span class="px-2 py-0.5 rounded text-[10px] font-semibold bg-[#E9EFE2] text-[#3D523E] border border-[#CADBC0] inline-flex items-center gap-1">
                                            <i data-lucide="check" class="w-3 h-3 text-[#5A6B47]"></i> ตรวจสอบแล้ว
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="p-4 text-center text-[#8C8275]">ยังไม่มีรายการบันทึกสะสมวัน</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Final Submit / Lock Engine Action -->
                @if ($student->submission_status === 'DRAFT')
                    <div class="mt-8 pt-6 border-t border-[#E3DEC9]">
                        <div class="bg-[#F7F5EE] border border-[#D5CEBC] rounded-xl p-4 mb-4 flex items-start space-x-3">
                            <i data-lucide="shield-alert" class="w-5 h-5 text-[#C86D51] shrink-0 mt-0.5"></i>
                            <div class="text-xs text-[#5A544A] leading-relaxed">
                                <strong>ระบบยื่นขออนุมัติขั้นสุดท้าย (Final Submission Lock):</strong> เมื่อท่านสะสมวันครบตามเกณฑ์ ({{ $target }} วัน) และกดยื่นคำขอ ระบบจะทำการล็อกแฟ้มข้อมูลทันทีเพื่อให้อาจารย์ผู้ควบคุมตรวจสอบ และออกใบรับรองสำหรับยื่นสอบวิทยานิพนธ์
                            </div>
                        </div>

                        <form action="{{ route('grad.finalSubmit') }}" method="POST" onsubmit="return confirm('ยืนยันการส่งคำขออนุมัติขั้นสุดท้าย? เมื่อส่งแล้วจะไม่สามารถแก้ไขข้อมูลได้')">
                            @csrf
                            <input type="hidden" name="student_id" value="{{ $student->id }}">
                            <button type="submit" {{ !$isCompleted ? 'disabled' : '' }} class="w-full py-3 rounded-xl font-medium text-sm transition shadow-sm flex items-center justify-center gap-2 {{ $isCompleted ? 'bg-[#2C3E2D] hover:bg-[#3D523E] text-white cursor-pointer' : 'bg-[#EAE5D9] text-[#8C8275] cursor-not-allowed' }}">
                                <i data-lucide="lock" class="w-4 h-4"></i>
                                <span>{{ $isCompleted ? 'ยื่นขออนุมัติผลสะสมวันปฏิบัติธรรม (Lock & Submit)' : 'ยังสะสมวันไม่ครบเกณฑ์ ' . $target . ' วัน (สะสมแล้ว ' . $accumulated . ' วัน)' }}</span>
                            </button>
                        </form>
                    </div>
                @endif

            </div>
        @endif

    </main>

    <!-- Footer -->
    <footer class="bg-[#FAF8F2] border-t border-[#E3DEC9] py-6 text-center text-xs text-[#8C8275]">
        มหาวิทยาลัยมหาจุฬาลงกรณราชวิทยาลัย  • ระบบสารสนเทศการปฏิบัติวิปัสสนากรรมฐาน (MCUVMS)
    </footer>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>
