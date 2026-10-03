<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ยื่นคำร้องขอหนังสือรับรองและเอกสาร e-Document (ระดับบัณฑิตศึกษา) - VPSMCU</title>
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
                        <div class="font-heading font-bold text-[#2C3E2D] leading-tight">VPSMCU</div>
                        <div class="text-xs text-[#6B6357]">{{ __('portal.university_name') }}</div>
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

                    <a href="{{ route('grad.progress') }}" class="text-[#4A3B32] hover:text-[#C86D51] font-semibold text-[15px] flex items-center gap-1.5 transition">
                        <i data-lucide="arrow-left" class="w-4.5 h-4.5 text-[#5A6B47]"></i> <span class="hidden sm:inline">ตรวจสอบสถานะสะสมวัน</span>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full flex-grow">
        
        <!-- Header Banner -->
        <div class="bg-gradient-to-r from-[#243325] via-[#4A3B32] to-[#2C3E2D] rounded-2xl p-6 md:p-8 text-white shadow-md mb-8 border border-[#3D523E]">
            <div class="inline-flex items-center gap-1.5 px-3 py-1 bg-white/15 backdrop-blur-sm rounded-full text-xs font-semibold uppercase tracking-wider mb-2 border border-white/20">
                <i data-lucide="file-text" class="w-3.5 h-3.5 text-[#EAE5D9]"></i>
                <span>ระบบคำร้อง e-Document บัณฑิตศึกษา</span>
            </div>
            <h1 class="text-2xl md:text-3xl font-heading font-bold mb-2">ยื่นคำร้องขอหนังสือรับรองการปฏิบัติวิปัสสนากรรมฐาน (e-Document)</h1>
            <p class="text-[#EAE5D9] text-sm leading-relaxed">
                สำหรับนิสิตระดับมหาบัณฑิต (ป.โท 30 วัน) และดุษฎีบัณฑิต (ป.เอก 45 วัน) ยื่นคำร้องขอใบรับรอง พร้อมแนบหลักฐานการปฏิบัติธรรมและการชำระค่าธรรมเนียม
            </p>
        </div>

        @if ($isClosed)
            <div class="bg-[#FBE8E6] border-l-4 border-[#C86D51] p-6 rounded-r-2xl mb-8 shadow-sm">
                <div class="flex items-start gap-3">
                    <i data-lucide="lock" class="w-6 h-6 text-[#C86D51] shrink-0 mt-0.5"></i>
                    <div>
                        <h3 class="text-base font-heading font-bold text-[#A85238]">ขณะนี้ระบบปิดรับคำร้อง e-Document ชั่วคราว</h3>
                        <p class="text-xs text-[#6B6357] mt-1 leading-relaxed">
                            ระบบรับคำร้องปิดตามกำหนดเวลาหรืออยู่ระหว่างการประมวลผลข้อมูลของเจ้าหน้าที่สถาบันวิปัสสนาธุระ มจร หากมีข้อสงสัยโปรดติดต่อเจ้าหน้าที่ส่วนงานต้นสังกัด
                        </p>
                        <a href="{{ route('grad.progress') }}" class="inline-flex items-center gap-1.5 text-xs text-[#5A6B47] hover:underline font-semibold mt-3">
                            <i data-lucide="search" class="w-3.5 h-3.5"></i> ไปที่หน้าตรวจสอบสถานะสะสมวันเดิม
                        </a>
                    </div>
                </div>
            </div>
        @else

            @if (session('success'))
                <div class="bg-white border border-[#D5CEBC] rounded-2xl p-8 shadow-sm text-center mb-8">
                    <div class="w-16 h-16 bg-[#E9EFE2] text-[#3D523E] rounded-full flex items-center justify-center mx-auto mb-4 border border-[#CADBC0]">
                        <i data-lucide="check-circle" class="w-8 h-8 text-[#5A6B47]"></i>
                    </div>
                    <h2 class="text-2xl font-heading font-bold text-[#2C3E2D] mb-1">ส่งคำร้องขอหนังสือรับรองเรียบร้อยแล้ว</h2>
                    <p class="text-[#6B6357] text-xs max-w-lg mx-auto mb-4 leading-relaxed">
                        {{ session('success') }}
                    </p>
                    <div class="flex items-center justify-center gap-3">
                        <a href="{{ route('grad.progress', ['student_code' => session('student_code')]) }}" class="bg-[#2C3E2D] hover:bg-[#3D523E] text-white font-medium px-6 py-2.5 rounded-lg text-sm transition flex items-center gap-2 shadow-sm">
                            <i data-lucide="search" class="w-4 h-4"></i> ตรวจสอบสถานะคำร้อง
                        </a>
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div class="bg-[#FBE8E6] border-l-4 border-[#C86D51] p-4 rounded-r-lg mb-6 shadow-sm">
                    <div class="flex items-center">
                        <i data-lucide="alert-circle" class="w-5 h-5 text-[#C86D51] mr-2 shrink-0"></i>
                        <p class="text-sm text-[#A85238] font-medium">{{ session('error') }}</p>
                    </div>
                </div>
            @endif

            <form name="data_form" id="data_form" action="{{ route('grad.request.store') }}" method="POST" enctype="multipart/form-data" class="bg-white border border-[#E3DEC9] rounded-2xl shadow-sm overflow-hidden p-6 md:p-8 space-y-8">
                @csrf

                <!-- หมวดที่ 1: ข้อมูลส่วนตัวและประวัติผู้ยื่นคำร้อง -->
                <div>
                    <h2 class="text-base font-heading font-bold text-[#2C3E2D] flex items-center border-b border-[#E3DEC9] pb-3 mb-5">
                        <span class="w-6 h-6 rounded-full bg-[#5A6B47] text-white text-xs font-bold flex items-center justify-center mr-2">1</span>
                        ข้อมูลส่วนตัวและประวัติผู้ยื่นคำร้อง
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-[#4A3B32] mb-1">รหัสนิสิต <span class="text-[#C86D51]">*</span></label>
                            <input type="text" id="txt_studentid" name="student_id" maxlength="15" required placeholder="เช่น 6501102001" value="{{ old('student_id') }}" class="w-full px-3 py-2 border border-[#D5CEBC] rounded-lg text-sm font-mono focus:ring-2 focus:ring-[#5A6B47] bg-[#FAF8F2]">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-[#4A3B32] mb-1">เลขประจำตัวประชาชน / Passport <span class="text-[#C86D51]">*</span></label>
                            <input type="text" id="txt_personalid" name="citizen_id" maxlength="13" required placeholder="เลข 13 หลัก" value="{{ old('citizen_id') }}" class="w-full px-3 py-2 border border-[#D5CEBC] rounded-lg text-sm font-mono focus:ring-2 focus:ring-[#5A6B47] bg-[#FAF8F2]">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-[#4A3B32] mb-1">คำนำหน้าชื่อ <span class="text-[#C86D51]">*</span></label>
                            <select id="txt_titlename" name="prefix" required class="w-full px-3 py-2 border border-[#D5CEBC] rounded-lg text-sm focus:ring-2 focus:ring-[#5A6B47] bg-[#FAF8F2]">
                                <option value="พระมหา">พระมหา</option>
                                <option value="พระครู">พระครู</option>
                                <option value="พระครูปลัด">พระครูปลัด</option>
                                <option value="พระ">พระ</option>
                                <option value="สามเณร">สามเณร</option>
                                <option value="นาย">นาย</option>
                                <option value="นาง">นาง</option>
                                <option value="นางสาว">นางสาว</option>
                                <option value="ดร.">ดร.</option>
                                <option value="แม่ชี">แม่ชี</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-[#4A3B32] mb-1">สัญชาติ <span class="text-[#C86D51]">*</span></label>
                            <input type="text" id="txt_nation" name="nationality" value="{{ old('nationality', 'ไทย') }}" required class="w-full px-3 py-2 border border-[#D5CEBC] rounded-lg text-sm focus:ring-2 focus:ring-[#5A6B47] bg-[#FAF8F2]">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-[#4A3B32] mb-1">ชื่อ <span class="text-[#C86D51]">*</span></label>
                            <input type="text" id="txt_name" name="first_name" required placeholder="ชื่อจริง" value="{{ old('first_name') }}" class="w-full px-3 py-2 border border-[#D5CEBC] rounded-lg text-sm focus:ring-2 focus:ring-[#5A6B47] bg-[#FAF8F2]">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-[#4A3B32] mb-1">นามสกุล <span class="text-[#C86D51]">*</span></label>
                            <input type="text" id="txt_lastname" name="last_name" required placeholder="นามสกุล" value="{{ old('last_name') }}" class="w-full px-3 py-2 border border-[#D5CEBC] rounded-lg text-sm focus:ring-2 focus:ring-[#5A6B47] bg-[#FAF8F2]">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-[#4A3B32] mb-1">ฉายาทางธรรม (ถ้าไม่มีใส่ -)</label>
                            <input type="text" id="txt_buddhistname" name="buddhist_name" placeholder="เช่น ปุญฺญกาโม หรือ -" value="{{ old('buddhist_name', '-') }}" class="w-full px-3 py-2 border border-[#D5CEBC] rounded-lg text-sm focus:ring-2 focus:ring-[#5A6B47] bg-[#FAF8F2]">
                        </div>
                        <div class="grid grid-cols-2 gap-2">
                            <div>
                                <label class="block text-xs font-semibold text-[#4A3B32] mb-1">อายุ (ปี)</label>
                                <input type="number" id="txt_age" name="age" min="15" max="120" placeholder="อายุ" value="{{ old('age') }}" class="w-full px-3 py-2 border border-[#D5CEBC] rounded-lg text-sm font-mono focus:ring-2 focus:ring-[#5A6B47] bg-[#FAF8F2]">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-[#4A3B32] mb-1">พรรษา</label>
                                <input type="number" id="txt_vassa" name="vassa" min="0" max="100" placeholder="0" value="{{ old('vassa', 0) }}" class="w-full px-3 py-2 border border-[#D5CEBC] rounded-lg text-sm font-mono focus:ring-2 focus:ring-[#5A6B47] bg-[#FAF8F2]">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- หมวดที่ 2: ข้อมูลการศึกษาและสังกัดใน มจร -->
                <div>
                    <h2 class="text-base font-heading font-bold text-[#2C3E2D] flex items-center border-b border-[#E3DEC9] pb-3 mb-5">
                        <span class="w-6 h-6 rounded-full bg-[#5A6B47] text-white text-xs font-bold flex items-center justify-center mr-2">2</span>
                        ข้อมูลการศึกษาและสังกัดใน มจร
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-[#4A3B32] mb-1">ระดับการศึกษา <span class="text-[#C86D51]">*</span></label>
                            <select id="txt_status" name="degree_level" required onchange="handleDegreeChange(this.value)" class="w-full px-3 py-2 border border-[#D5CEBC] rounded-lg text-sm focus:ring-2 focus:ring-[#5A6B47] bg-[#FAF8F2]">
                                <option value="MASTER">ปริญญาโท (มหาบัณฑิต - เกณฑ์ 30 วัน)</option>
                                <option value="DOCTORAL">ปริญญาเอก (ดุษฎีบัณฑิต - เกณฑ์ 45 วัน)</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-[#4A3B32] mb-1">คณะ <span class="text-[#C86D51]">*</span></label>
                            <select id="txt_faculty" name="faculty" required class="w-full px-3 py-2 border border-[#D5CEBC] rounded-lg text-sm focus:ring-2 focus:ring-[#5A6B47] bg-[#FAF8F2]">
                                <option value="บัณฑิตวิทยาลัย">บัณฑิตวิทยาลัย</option>
                                <option value="พุทธศาสตร์">พุทธศาสตร์</option>
                                <option value="ครุศาสตร์">ครุศาสตร์</option>
                                <option value="มนุษยศาสตร์">มนุษยศาสตร์</option>
                                <option value="สังคมศาสตร์">สังคมศาสตร์</option>
                                <option value="IBSC">วิทยาลัยพุทธศาสตร์นานาชาติ (IBSC)</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-[#4A3B32] mb-1">สาขาวิชา / หลักสูตร <span class="text-[#C86D51]">*</span></label>
                            <input type="text" id="txt_subject" name="program_name" required placeholder="เช่น พุทธศาสตรมหาบัณฑิต สาขาวิชาการจัดการเชิงพุทธ" value="{{ old('program_name') }}" class="w-full px-3 py-2 border border-[#D5CEBC] rounded-lg text-sm focus:ring-2 focus:ring-[#5A6B47] bg-[#FAF8F2]">
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-xs font-semibold text-[#4A3B32] mb-1">วิทยาเขต / ส่วนงานสังกัด (มจร) <span class="text-[#C86D51]">*</span></label>
                            <select id="txt_zone" name="org_unit_id" required class="w-full px-3 py-2 border border-[#D5CEBC] rounded-lg text-sm focus:ring-2 focus:ring-[#5A6B47] bg-[#FAF8F2]">
                                @foreach ($orgUnits as $org)
                                    <option value="{{ $org->id }}" {{ old('org_unit_id', 1) == $org->id ? 'selected' : '' }}>
                                        {{ $org->name_th }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-[#4A3B32] mb-1">จำนวนวันสะสมรวม (วัน) <span class="text-[#C86D51]">*</span></label>
                            <input type="number" id="txt_total" name="accumulated_days" min="1" max="100" required placeholder="ป.โท >= 30, ป.เอก >= 45" value="{{ old('accumulated_days') }}" class="w-full px-3 py-2 border border-[#D5CEBC] rounded-lg text-sm font-mono font-bold text-[#5A6B47] focus:ring-2 focus:ring-[#5A6B47] bg-[#FAF8F2]">
                        </div>
                    </div>
                </div>

                <!-- หมวดที่ 3: ข้อมูลที่อยู่และการติดต่อ -->
                <div>
                    <h2 class="text-base font-heading font-bold text-[#2C3E2D] flex items-center border-b border-[#E3DEC9] pb-3 mb-5">
                        <span class="w-6 h-6 rounded-full bg-[#5A6B47] text-white text-xs font-bold flex items-center justify-center mr-2">3</span>
                        ข้อมูลที่อยู่และการติดต่อ
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div class="md:col-span-2">
                            <label class="block text-xs font-semibold text-[#4A3B32] mb-1">ที่อยู่ / วัด / สังกัด (บ้านเลขที่, หมู่, ถนน) <span class="text-[#C86D51]">*</span></label>
                            <input type="text" id="txt_address" name="address" required placeholder="เช่น 79 หมู่ 1 ต.ลำไทร หรือ วัดมหาธาตุฯ" value="{{ old('address') }}" class="w-full px-3 py-2 border border-[#D5CEBC] rounded-lg text-sm focus:ring-2 focus:ring-[#5A6B47] bg-[#FAF8F2]">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-[#4A3B32] mb-1">ตำบล / แขวง <span class="text-[#C86D51]">*</span></label>
                            <input type="text" name="subdistrict" required placeholder="ตำบล/แขวง" value="{{ old('subdistrict') }}" class="w-full px-3 py-2 border border-[#D5CEBC] rounded-lg text-sm focus:ring-2 focus:ring-[#5A6B47] bg-[#FAF8F2]">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-[#4A3B32] mb-1">อำเภอ / เขต <span class="text-[#C86D51]">*</span></label>
                            <input type="text" name="district" required placeholder="อำเภอ/เขต" value="{{ old('district') }}" class="w-full px-3 py-2 border border-[#D5CEBC] rounded-lg text-sm focus:ring-2 focus:ring-[#5A6B47] bg-[#FAF8F2]">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-[#4A3B32] mb-1">จังหวัด <span class="text-[#C86D51]">*</span></label>
                            <input type="text" name="province" required placeholder="จังหวัด" value="{{ old('province') }}" class="w-full px-3 py-2 border border-[#D5CEBC] rounded-lg text-sm focus:ring-2 focus:ring-[#5A6B47] bg-[#FAF8F2]">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-[#4A3B32] mb-1">รหัสไปรษณีย์ <span class="text-[#C86D51]">*</span></label>
                            <input type="text" id="txt_postcode" name="postcode" maxlength="5" required placeholder="5 หลัก" value="{{ old('postcode') }}" class="w-full px-3 py-2 border border-[#D5CEBC] rounded-lg text-sm font-mono focus:ring-2 focus:ring-[#5A6B47] bg-[#FAF8F2]">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-xs font-semibold text-[#4A3B32] mb-1">หมายเลขโทรศัพท์มือถือ <span class="text-[#C86D51]">*</span></label>
                            <input type="tel" id="txt_tel" name="phone" required placeholder="เช่น 0812345678" value="{{ old('phone') }}" class="w-full px-3 py-2 border border-[#D5CEBC] rounded-lg text-sm font-mono focus:ring-2 focus:ring-[#5A6B47] bg-[#FAF8F2]">
                        </div>
                    </div>
                </div>

                <!-- หมวดที่ 4: ไฟล์เอกสารแนบและหลักฐาน (4 รายการตาม e-Doc) -->
                <div>
                    <h2 class="text-base font-heading font-bold text-[#2C3E2D] flex items-center border-b border-[#E3DEC9] pb-3 mb-5">
                        <span class="w-6 h-6 rounded-full bg-[#5A6B47] text-white text-xs font-bold flex items-center justify-center mr-2">4</span>
                        ไฟล์เอกสารแนบและหลักฐาน (4 รายการ)
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- ไฟล์ที่ 1: รูปถ่ายนิสิต -->
                        <div class="p-4 bg-[#FAF8F2] border border-[#EAE5D9] rounded-xl space-y-2">
                            <div class="flex items-center gap-2">
                                <i data-lucide="image" class="w-4 h-4 text-[#5A6B47]"></i>
                                <label class="text-xs font-bold text-[#2C3E2D]">1. รูปถ่ายนิสิต ขนาด 2x2 นิ้ว พื้นหลังสีฟ้า <span class="text-[#C86D51]">*</span></label>
                            </div>
                            <p class="text-[11px] text-[#8C8275]">สำหรับจัดทำหนังสือรับรอง (ไฟล์ JPG, PNG ขนาดไม่เกิน 5MB)</p>
                            <input type="file" name="file_photo" accept="image/jpeg,image/png" required class="w-full text-xs text-[#4A3B32] file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-[#5A6B47] file:text-white hover:file:bg-[#2C3E2D]">
                        </div>

                        <!-- ไฟล์ที่ 2: PDF ใบบันทึกสอบอารมณ์ -->
                        <div class="p-4 bg-[#FAF8F2] border border-[#EAE5D9] rounded-xl space-y-2">
                            <div class="flex items-center gap-2">
                                <i data-lucide="file-check" class="w-4 h-4 text-[#5A6B47]"></i>
                                <label class="text-xs font-bold text-[#2C3E2D]">2. ใบบันทึกการส่ง-สอบอารมณ์กรรมฐาน (PDF) <span class="text-[#C86D51]">*</span></label>
                            </div>
                            <p class="text-[11px] text-[#8C8275]">ลงนามรับรองโดยพระวิปัสสนาจารย์ (ไฟล์ PDF ขนาดไม่เกิน 10MB)</p>
                            <input type="file" name="file_interview" accept="application/pdf" required class="w-full text-xs text-[#4A3B32] file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-[#2C3E2D] file:text-white hover:file:bg-[#1E2B1F]">
                        </div>

                        <!-- ไฟล์ที่ 3: PDF ใบลงเวลา -->
                        <div class="p-4 bg-[#FAF8F2] border border-[#EAE5D9] rounded-xl space-y-2">
                            <div class="flex items-center gap-2">
                                <i data-lucide="calendar" class="w-4 h-4 text-[#5A6B47]"></i>
                                <label class="text-xs font-bold text-[#2C3E2D]">3. ใบลงเวลาการปฏิบัติกรรมฐาน (PDF) <span class="text-[#C86D51]">*</span></label>
                            </div>
                            <p class="text-[11px] text-[#8C8275]">ใบบันทึกเวลาการเดินจงกรม-นั่งสมาธิครบตามเกณฑ์ (ไฟล์ PDF ไม่เกิน 10MB)</p>
                            <input type="file" name="file_attendance" accept="application/pdf" required class="w-full text-xs text-[#4A3B32] file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-[#2C3E2D] file:text-white hover:file:bg-[#1E2B1F]">
                        </div>

                        <!-- ไฟล์ที่ 4: สลิปโอนเงิน + วันเวลา -->
                        <div class="p-4 bg-[#FAF8F2] border border-[#EAE5D9] rounded-xl space-y-2">
                            <div class="flex items-center gap-2">
                                <i data-lucide="receipt" class="w-4 h-4 text-[#C86D51]"></i>
                                <label class="text-xs font-bold text-[#2C3E2D]">4. สลิปหลักฐานการโอนเงินค่าธรรมเนียม <span class="text-[#C86D51]">*</span></label>
                            </div>
                            <p class="text-[11px] text-[#8C8275]">รูปสลิปหลักฐานโอนเงินค่าธรรมเนียมออกเอกสาร (JPG, PNG หรือ PDF)</p>
                            <input type="file" name="file_slip" accept="image/jpeg,image/png,application/pdf" required class="w-full text-xs text-[#4A3B32] file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-[#C86D51] file:text-white hover:file:bg-[#A85238]">

                            <div class="grid grid-cols-2 gap-2 pt-2 border-t border-[#EAE5D9]">
                                <div>
                                    <label class="block text-[11px] font-semibold text-[#4A3B32] mb-1">วันที่โอนในสลิป <span class="text-[#C86D51]">*</span></label>
                                    <input type="date" id="sdatepickert" name="transfer_date" required value="{{ old('transfer_date', date('Y-m-d')) }}" class="w-full px-2.5 py-1.5 border border-[#D5CEBC] rounded-lg text-xs bg-white">
                                </div>
                                <div>
                                    <label class="block text-[11px] font-semibold text-[#4A3B32] mb-1">เวลาที่โอนในสลิป <span class="text-[#C86D51]">*</span></label>
                                    <input type="time" id="timet" name="transfer_time" required value="{{ old('transfer_time', date('H:i')) }}" class="w-full px-2.5 py-1.5 border border-[#D5CEBC] rounded-lg text-xs bg-white font-mono">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="pt-6 border-t border-[#E3DEC9] flex flex-col sm:flex-row items-center justify-between gap-4">
                    <div class="text-xs text-[#8C8275] flex items-center gap-1.5">
                        <i data-lucide="shield-check" class="w-4 h-4 text-[#5A6B47]"></i>
                        <span>ข้อมูลและเอกสารจะถูกส่งเข้าสู่ระบบตรวจสอบหลังบ้าน e-Document สถาบันวิปัสสนาธุระ มจร</span>
                    </div>

                    <button type="submit" class="w-full sm:w-auto bg-[#5A6B47] hover:bg-[#2C3E2D] text-white font-medium px-8 py-3 rounded-xl text-sm transition shadow-md flex items-center justify-center gap-2">
                        <i data-lucide="send" class="w-4 h-4"></i>
                        <span>ส่งคำร้อง e-Document (Submit Request)</span>
                    </button>
                </div>

            </form>
        @endif

    </main>

    <!-- Footer -->
    <footer class="bg-[#FAF8F2] border-t border-[#E3DEC9] py-6 text-center text-xs text-[#8C8275]">
        {{ __('portal.footer_brand') }}
    </footer>

    <script>
        function handleDegreeChange(val) {
            const totalInput = document.getElementById('txt_total');
            if (val === 'DOCTORAL') {
                totalInput.placeholder = 'เกณฑ์ขั้นต่ำ 45 วัน';
            } else {
                totalInput.placeholder = 'เกณฑ์ขั้นต่ำ 30 วัน';
            }
        }
        lucide.createIcons();
    </script>
</body>
</html>
