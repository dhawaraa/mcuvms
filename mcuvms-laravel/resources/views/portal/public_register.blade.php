<!DOCTYPE html>
<html lang="th" data-palette="coral" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ลงทะเบียนปฏิบัติธรรมสำหรับประชาชนทั่วไป (Social Service) - MCUVMS Laravel</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@300;400;500;600;700&family=Prompt:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
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
                            sand: '#F7F4EA',
                            stone: '#EAE5D9',
                            clay: '#C86D51',
                            clayDark: '#A85238',
                            forest: '#2C3E2D',
                            olive: '#5A6B47',
                            oliveLight: '#7B8D65',
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
            background-color: #F7F5EE;
            color: #2D2A26;
        }
        h1, h2, h3, h4, .font-heading { font-family: 'Prompt', sans-serif; }
        .organic-card {
            background: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(220, 215, 201, 0.85);
            box-shadow: 0 10px 30px -10px rgba(74, 59, 50, 0.06);
        }
        .organic-mesh {
            background-image: 
                radial-gradient(at 10% 10%, rgba(90, 107, 71, 0.12) 0px, transparent 50%),
                radial-gradient(at 90% 15%, rgba(200, 109, 81, 0.10) 0px, transparent 50%),
                radial-gradient(at 50% 90%, rgba(123, 141, 101, 0.08) 0px, transparent 60%);
        }
    </style>
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/mcu-logo.png') }}">
    <link rel="shortcut icon" href="{{ asset('images/mcu-logo.png') }}">
</head>
<body class="antialiased min-h-screen flex flex-col justify-between selection:bg-[#5A6B47] selection:text-white">

    <!-- Organic Background Layer -->
    <div class="fixed inset-0 pointer-events-none z-[-1] organic-mesh"></div>

    <!-- Navigation -->
    <nav class="bg-[#FAF8F2]/90 backdrop-blur-md border-b border-[#EAE5D9] sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <a href="{{ route('home') }}" class="flex items-center space-x-3">
                    <img src="{{ asset('images/mcu-logo.png') }}" alt="MCU Logo" class="w-10 h-10 object-contain drop-shadow-sm">
                    <div>
                        <div class="font-heading font-bold text-[#2C3E2D] leading-tight">MCUVMS</div>
                        <div class="text-xs text-[#7B8D65]">มหาจุฬาลงกรณราชวิทยาลัย</div>
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

                    <a href="{{ route('home') }}" class="text-[#4A3B32] hover:text-[#5A6B47] font-semibold text-[15px] flex items-center gap-1.5 transition">
                        <i data-lucide="arrow-left" class="w-4.5 h-4.5 text-[#5A6B47]"></i> <span class="hidden sm:inline">กลับหน้าหลัก</span>
                    </a>
                    <a href="{{ route('login') }}" class="text-[#2C3E2D] hover:text-[#5A6B47] font-semibold text-sm border border-[#D5CEBC] px-4 py-2 rounded-xl bg-[#EAE5D9] hover:bg-[#DDD7C8] flex items-center gap-1.5 shadow-sm transition">
                        <i data-lucide="lock" class="w-4 h-4 text-[#5A6B47]"></i> <span class="hidden sm:inline">เจ้าหน้าที่เข้าระบบ</span>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full flex-grow">
        
        <!-- Header Banner -->
        <div class="bg-gradient-to-r from-[#2C3E2D] via-[#3A4F3C] to-[#5A6B47] rounded-3xl p-6 md:p-8 text-white shadow-lg shadow-[#2C3E2D]/15 mb-8 border border-[#2C3E2D]/20">
            <div class="inline-flex items-center gap-1.5 px-3 py-1 bg-white/15 backdrop-blur-sm rounded-full text-xs font-semibold uppercase tracking-wider mb-2 border border-white/20 text-[#FAF8F2]">
                <i data-lucide="heart-handshake" class="w-3.5 h-3.5 text-[#EAE5D9]"></i>
                <span>โมดูลที่ 3 (Module 3: Public Meditation)</span>
            </div>
            <h1 class="text-2xl md:text-3xl font-heading font-bold mb-2 text-[#FAF8F2]">คอร์สวิปัสสนากรรมฐานสำหรับประชาชน</h1>
            <p class="text-[#EAE5D9] text-sm leading-relaxed">
                บริการวิชาการทางพระพุทธศาสนาแก่สังคม เพื่อพัฒนาจิตและสันติสุขในชีวิตประจำวัน (เปิดกว้างสำหรับสาธุชนและนิสิตทุกท่าน สะดวก ใช้งานง่าย)
            </p>
        </div>

        @if (session('error'))
            <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-r-lg mb-6 shadow-sm">
                <div class="flex items-center">
                    <i data-lucide="alert-triangle" class="w-5 h-5 text-red-500 mr-2 shrink-0"></i>
                    <p class="text-sm text-red-800 font-medium">{{ session('error') }}</p>
                </div>
            </div>
        @endif

        @if (session('regSuccess'))
            <div class="organic-card rounded-3xl p-8 text-center mb-8">
                <div class="w-16 h-16 bg-amber-100 text-amber-800 rounded-2xl flex items-center justify-center mx-auto mb-4 border border-amber-300">
                    <i data-lucide="clock" class="w-8 h-8"></i>
                </div>
                <div class="inline-block px-3 py-1 bg-amber-50 text-amber-800 text-xs font-semibold rounded-full border border-amber-200 mb-3">
                    สถานะ: รอเจ้าหน้าที่ตรวจสอบคุณสมบัติ (Pending Review)
                </div>
                <h2 class="text-xl md:text-2xl font-heading font-bold text-[#2C3E2D] mb-2">{{ session('success') }}</h2>
                <p class="text-[#4A3B32] text-sm mb-4">รหัสการลงทะเบียนของท่านคือ:</p>
                <div class="inline-block bg-[#FAF8F2] border border-[#EAE5D9] font-mono font-bold text-xl px-6 py-3 rounded-xl text-[#2C3E2D] tracking-wider mb-6 shadow-inner">
                    {{ session('regSuccess') }}
                </div>
                <div class="max-w-md mx-auto bg-stone-50 border border-[#EAE5D9] rounded-2xl p-4 text-xs text-[#7B8D65] text-left mb-6 space-y-1.5">
                    <div class="font-semibold text-[#2C3E2D] flex items-center gap-1.5">
                        <i data-lucide="info" class="w-4 h-4 text-[#5A6B47]"></i> ลำดับขั้นตอนถัดไป (Next Steps):
                    </div>
                    <div>1. เจ้าหน้าที่ส่วนงานจะตรวจสอบประวัติและข้อจำกัดทางสุขภาพ/อาหาร</div>
                    <div>2. ตรวจสอบการจัดสรรห้องพัก/อาคารตามเพศสภาพและพรรษา</div>
                    <div>3. เมื่อผ่านการอนุมัติ เจ้าหน้าที่จะปรับสถานะเป็น <strong class="text-[#5A6B47]">"อนุมัติสิทธิ์ (Confirmed)"</strong> เพื่อเตรียมเข้ารับการอบรม</div>
                </div>
                <div class="flex items-center justify-center gap-3">
                    <button onclick="window.print()" class="bg-[#5A6B47] hover:bg-[#2C3E2D] text-white font-medium px-6 py-2.5 rounded-xl text-sm transition flex items-center gap-2 shadow-sm">
                        <i data-lucide="printer" class="w-4 h-4"></i> พิมพ์เอกสารยืนยัน
                    </button>
                    <a href="{{ route('public.register') }}" class="text-[#4A3B32] hover:text-[#5A6B47] text-sm font-medium py-2.5">
                        ลงทะเบียนให้ท่านอื่น
                    </a>
                </div>
            </div>
        @else

            <!-- Easy Form for Public & Students -->
            <form action="{{ route('public.store') }}" method="POST" class="organic-card rounded-3xl overflow-hidden p-6 md:p-8 space-y-6">
                @csrf
                
                <!-- Section 1: Choose Course -->
                <div>
                    <h2 class="text-lg font-heading font-semibold text-[#2C3E2D] flex items-center border-b border-[#EAE5D9] pb-3 mb-4">
                        <span class="w-7 h-7 rounded-xl bg-[#5A6B47] text-white text-xs font-bold flex items-center justify-center mr-2.5 shadow-sm">1</span>
                        เลือกคอร์สปฏิบัติธรรมที่ประสงค์เข้าร่วม (Course Selection)
                    </h2>

                    <div class="space-y-3">
                        @forelse ($events as $ev)
                            @php 
                                $quota = $ev->max_quota ?? 50;
                                $confirmed = $ev->confirmed_count ?? 0;
                                $available = max(0, $quota - $confirmed);
                                $isFull = ($available <= 0);
                            @endphp
                            <label class="flex items-start p-4 border border-[#EAE5D9] rounded-2xl cursor-pointer hover:border-[#5A6B47] hover:bg-[#5A6B47]/5 transition bg-white/70">
                                <input type="radio" name="event_id" value="{{ $ev->id }}" required class="mt-1 text-[#5A6B47] focus:ring-[#5A6B47]">
                                <div class="ml-3 flex-grow">
                                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-1">
                                        <span class="font-heading font-semibold text-[#2C3E2D] text-base">{{ $ev->title }}</span>
                                        @if ($isFull)
                                            <span class="px-2.5 py-0.5 text-xs bg-[#C86D51]/15 text-[#C86D51] rounded-full font-medium border border-[#C86D51]/30">ที่นั่งเต็ม (รับรายชื่อสำรอง)</span>
                                        @else
                                            <span class="px-2.5 py-0.5 text-xs bg-[#5A6B47]/15 text-[#5A6B47] rounded-full font-medium border border-[#5A6B47]/30">ว่าง {{ $available }} จาก {{ $quota }} ที่นั่ง</span>
                                        @endif
                                    </div>
                                    <div class="text-xs text-[#7B8D65] mt-1 flex items-center gap-1.5">
                                        <i data-lucide="map-pin" class="w-3.5 h-3.5 text-[#5A6B47] shrink-0"></i>
                                        <span>สถานที่: {{ $ev->location_name ?? '-' }} (จัดโดย: {{ $ev->organizationUnit->name_th ?? 'มหาวิทยาลัยมหาจุฬาลงกรณราชวิทยาลัย' }})</span>
                                    </div>
                                    <div class="text-xs text-[#C86D51] font-medium mt-1 flex items-center gap-1.5">
                                        <i data-lucide="calendar" class="w-3.5 h-3.5 text-[#C86D51] shrink-0"></i>
                                        <span>วันที่จัด: {{ \Carbon\Carbon::parse($ev->start_date)->locale('th')->translatedFormat('d M') }} - {{ \Carbon\Carbon::parse($ev->end_date)->locale('th')->translatedFormat('d M Y') }}</span>
                                    </div>
                                </div>
                            </label>
                        @empty
                            <div class="text-center py-6 text-[#7B8D65] bg-[#FAF8F2] rounded-2xl border border-dashed border-[#EAE5D9]">
                                ยังไม่มีคอร์สปฏิบัติธรรมเปิดรับสมัครในขณะนี้
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Section 2: Personal Information -->
                <div>
                    <h2 class="text-lg font-heading font-semibold text-[#2C3E2D] flex items-center border-b border-[#EAE5D9] pb-3 mb-4">
                        <span class="w-7 h-7 rounded-xl bg-[#5A6B47] text-white text-xs font-bold flex items-center justify-center mr-2.5 shadow-sm">2</span>
                        ข้อมูลผู้สมัครเข้าร่วมโครงการ (Personal Information)
                    </h2>

                    <!-- Status Selector (PEOPLE vs STUDENT) -->
                    <div class="mb-4 bg-[#FAF8F2] p-4 rounded-2xl border border-[#EAE5D9]">
                        <label class="block text-xs font-semibold text-[#4A3B32] mb-2">สถานะผู้สมัคร (Applicant Status)</label>
                        <div class="flex flex-wrap gap-4">
                            <label class="inline-flex items-center text-sm cursor-pointer">
                                <input type="radio" name="applicant_type" value="PEOPLE" checked class="text-[#5A6B47] focus:ring-[#5A6B47]" onchange="toggleStudentField(this.value)">
                                <span class="ml-2 font-medium text-[#2C3E2D]">ประชาชนทั่วไป (General Public)</span>
                            </label>
                            <label class="inline-flex items-center text-sm cursor-pointer">
                                <input type="radio" name="applicant_type" value="STUDENT" class="text-[#5A6B47] focus:ring-[#5A6B47]" onchange="toggleStudentField(this.value)">
                                <span class="ml-2 font-medium text-[#2C3E2D]">นิสิต มจร (MCU Student)</span>
                            </label>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div id="studentIdContainer" class="hidden md:col-span-3 bg-amber-50/60 p-3.5 rounded-xl border border-amber-200">
                            <label class="block text-xs font-medium text-[#4A3B32] mb-1">รหัสนิสิต มจร (Student ID)</label>
                            <input type="text" name="student_id" id="txt_studentid" placeholder="เช่น 6401201001" class="w-full px-3.5 py-2.5 border border-[#EAE5D9] bg-white rounded-xl text-sm focus:ring-2 focus:ring-[#5A6B47] focus:border-[#5A6B47]">
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-[#4A3B32] mb-1">เลขบัตร ปชช. / Passport <span class="text-[#C86D51]">*</span></label>
                            <input type="text" name="citizen_id" minlength="8" maxlength="20" placeholder="13 หลัก หรือเลข Passport" required class="w-full px-3.5 py-2.5 border border-[#EAE5D9] bg-white rounded-xl text-sm focus:ring-2 focus:ring-[#5A6B47] focus:border-[#5A6B47]">
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-[#4A3B32] mb-1">คำนำหน้าชื่อ <span class="text-[#C86D51]">*</span></label>
                            <select name="prefix" id="prefix_select" class="w-full px-3.5 py-2.5 border border-[#EAE5D9] rounded-xl text-sm bg-white focus:ring-2 focus:ring-[#5A6B47] focus:border-[#5A6B47]" onchange="toggleMonkFields(this.value)">
                                <option value="นาย">นาย</option>
                                <option value="นาง">นาง</option>
                                <option value="นางสาว">นางสาว</option>
                                <option value="พระ">พระ / พระภิกษุ</option>
                                <option value="สามเณร">สามเณร</option>
                                <option value="แม่ชี">แม่ชี</option>
                                <option value="อุบาสก">อุบาสก</option>
                                <option value="อุบาสิกา">อุบาสิกา</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-[#4A3B32] mb-1">ชื่อ <span class="text-[#C86D51]">*</span></label>
                            <input type="text" name="first_name" required class="w-full px-3.5 py-2.5 border border-[#EAE5D9] bg-white rounded-xl text-sm focus:ring-2 focus:ring-[#5A6B47] focus:border-[#5A6B47]">
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-[#4A3B32] mb-1">นามสกุล <span class="text-[#C86D51]">*</span></label>
                            <input type="text" name="last_name" required class="w-full px-3.5 py-2.5 border border-[#EAE5D9] bg-white rounded-xl text-sm focus:ring-2 focus:ring-[#5A6B47] focus:border-[#5A6B47]">
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-[#4A3B32] mb-1">ฉายาทางธรรม (ถ้ามี)</label>
                            <input type="text" name="buddhist_name" placeholder="เช่น เขมธมฺโม หรือเว้นว่าง" class="w-full px-3.5 py-2.5 border border-[#EAE5D9] bg-white rounded-xl text-sm focus:ring-2 focus:ring-[#5A6B47] focus:border-[#5A6B47]">
                        </div>

                        <div class="grid grid-cols-2 gap-2">
                            <div>
                                <label class="block text-xs font-medium text-[#4A3B32] mb-1">เพศ</label>
                                <select name="gender" class="w-full px-3.5 py-2.5 border border-[#EAE5D9] rounded-xl text-sm bg-white focus:ring-2 focus:ring-[#5A6B47] focus:border-[#5A6B47]">
                                    <option value="MALE">ชาย</option>
                                    <option value="FEMALE">หญิง</option>
                                    <option value="OTHER">ไม่ระบุ</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-[#4A3B32] mb-1">อายุ (ปี)</label>
                                <input type="number" name="age" min="6" max="120" placeholder="เช่น 45" class="w-full px-3.5 py-2.5 border border-[#EAE5D9] bg-white rounded-xl text-sm focus:ring-2 focus:ring-[#5A6B47] focus:border-[#5A6B47]">
                            </div>
                        </div>

                        <div id="vassaContainer" class="hidden">
                            <label class="block text-xs font-medium text-[#4A3B32] mb-1">พรรษา (สำหรับพระภิกษุ/สามเณร)</label>
                            <input type="number" name="vassa" value="0" min="0" max="100" class="w-full px-3.5 py-2.5 border border-[#EAE5D9] bg-white rounded-xl text-sm focus:ring-2 focus:ring-[#5A6B47] focus:border-[#5A6B47]">
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-[#4A3B32] mb-1">เบอร์โทรศัพท์ติดต่อ <span class="text-[#C86D51]">*</span></label>
                            <input type="tel" name="phone" placeholder="08xxxxxxxx" required class="w-full px-3.5 py-2.5 border border-[#EAE5D9] bg-white rounded-xl text-sm focus:ring-2 focus:ring-[#5A6B47] focus:border-[#5A6B47]">
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-[#4A3B32] mb-1">อีเมล (ถ้ามี)</label>
                            <input type="email" name="email" placeholder="example@gmail.com" class="w-full px-3.5 py-2.5 border border-[#EAE5D9] bg-white rounded-xl text-sm focus:ring-2 focus:ring-[#5A6B47] focus:border-[#5A6B47]">
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-[#4A3B32] mb-1">ไลน์ (Line ID) (ถ้ามี)</label>
                            <input type="text" name="line_id" placeholder="Line ID หรือเบอร์ไลน์" class="w-full px-3.5 py-2.5 border border-[#EAE5D9] bg-white rounded-xl text-sm focus:ring-2 focus:ring-[#5A6B47] focus:border-[#5A6B47]">
                        </div>
                    </div>
                </div>

                <!-- Section 3: Address Information -->
                <div>
                    <h2 class="text-lg font-heading font-semibold text-[#2C3E2D] flex items-center border-b border-[#EAE5D9] pb-3 mb-4">
                        <span class="w-7 h-7 rounded-xl bg-[#5A6B47] text-white text-xs font-bold flex items-center justify-center mr-2.5 shadow-sm">3</span>
                        ที่อยู่สำหรับการติดต่อ (Contact Address)
                    </h2>

                    <div class="space-y-4">
                        <!-- แถวที่ 1: รายละเอียดที่อยู่ / วัดต้นสังกัด (เต็มแถว) -->
                        <div>
                            <label class="block text-xs font-medium text-[#4A3B32] mb-1">ที่อยู่ / วัดต้นสังกัด / บ้านเลขที่ หมู่ ซอย ถนน</label>
                            <input type="text" name="address" placeholder="เช่น 99/1 หมู่ 2 หรือ วัดมหาธาตุยุวราชรังสฤษฎิ์" class="w-full px-3.5 py-2.5 border border-[#EAE5D9] bg-white rounded-xl text-sm focus:ring-2 focus:ring-[#5A6B47] focus:border-[#5A6B47]">
                        </div>

                        <!-- แถวที่ 2: จังหวัด, อำเภอ, ตำบล, รหัสไปรษณีย์ (4 คอลัมน์แถวเดียวกัน) -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                            <!-- 1. เลือกจังหวัด -->
                            <div>
                                <label class="block text-xs font-medium text-[#4A3B32] mb-1">จังหวัด (Province) <span class="text-[#C86D51]">*</span></label>
                                <select id="province_select" name="province" required onchange="onProvinceChange(this.value)" class="w-full px-3.5 py-2.5 border border-[#EAE5D9] bg-white rounded-xl text-sm focus:ring-2 focus:ring-[#5A6B47] focus:border-[#5A6B47]">
                                    <option value="">-- กำลังโหลดจังหวัด... --</option>
                                </select>
                            </div>

                            <!-- 2. เลือกอำเภอ/เขต -->
                            <div>
                                <label class="block text-xs font-medium text-[#4A3B32] mb-1">อำเภอ / เขต (District) <span class="text-[#C86D51]">*</span></label>
                                <select id="district_select" name="district" required disabled onchange="onDistrictChange(this.value)" class="w-full px-3.5 py-2.5 border border-[#EAE5D9] bg-white rounded-xl text-sm focus:ring-2 focus:ring-[#5A6B47] focus:border-[#5A6B47] disabled:bg-[#F4F1EA] disabled:text-[#8C8275]">
                                    <option value="">-- เลือกจังหวัดก่อน --</option>
                                </select>
                            </div>

                            <!-- 3. เลือกตำบล/แขวง -->
                            <div>
                                <label class="block text-xs font-medium text-[#4A3B32] mb-1">ตำบล / แขวง (Subdistrict) <span class="text-[#C86D51]">*</span></label>
                                <select id="subdistrict_select" name="subdistrict" required disabled onchange="onSubdistrictChange(this.value)" class="w-full px-3.5 py-2.5 border border-[#EAE5D9] bg-white rounded-xl text-sm focus:ring-2 focus:ring-[#5A6B47] focus:border-[#5A6B47] disabled:bg-[#F4F1EA] disabled:text-[#8C8275]">
                                    <option value="">-- เลือกอำเภอก่อน --</option>
                                </select>
                            </div>

                            <!-- 4. รหัสไปรษณีย์ -->
                            <div>
                                <label class="block text-xs font-medium text-[#4A3B32] mb-1">รหัสไปรษณีย์ (Postal Code) <span class="text-[#5A6B47] text-[10px] font-normal">(อัตโนมัติ)</span></label>
                                <input type="text" id="postal_code_input" name="postal_code" maxlength="5" placeholder="เช่น 13170" class="w-full px-3.5 py-2.5 border border-[#EAE5D9] bg-[#FAF8F2] rounded-xl text-sm font-mono focus:ring-2 focus:ring-[#5A6B47] focus:border-[#5A6B47]">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section 4: Accommodation, Vehicle & Dietary Preferences -->
                <div>
                    <h2 class="text-lg font-heading font-semibold text-[#2C3E2D] flex items-center border-b border-[#EAE5D9] pb-3 mb-4">
                        <span class="w-7 h-7 rounded-xl bg-[#5A6B47] text-white text-xs font-bold flex items-center justify-center mr-2.5 shadow-sm">4</span>
                        ข้อมูลห้องพัก ยานพาหนะ และอาหาร (Accommodations & Preferences)
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-medium text-[#4A3B32] mb-1">ข้อมูลห้องพัก / อาคารที่ต้องการ (Room / Building Request)</label>
                            <input type="text" name="room_info" placeholder="เช่น อาคาร 72 พรรษา หรือพักเดี่ยว/พักรวม" class="w-full px-3.5 py-2.5 border border-[#EAE5D9] bg-white rounded-xl text-sm focus:ring-2 focus:ring-[#5A6B47] focus:border-[#5A6B47]">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-[#4A3B32] mb-1">ยานพาหนะ / หมายเลขทะเบียนรถ (Vehicle / License Plate)</label>
                            <input type="text" name="vehicle_info" placeholder="เช่น รถยนต์ กข 1234 กทม. หรือ เดินทางโดยรถตู้" class="w-full px-3.5 py-2.5 border border-[#EAE5D9] bg-white rounded-xl text-sm focus:ring-2 focus:ring-[#5A6B47] focus:border-[#5A6B47]">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-[#4A3B32] mb-1">ประเภทอาหาร</label>
                            <select name="food_type" class="w-full px-3.5 py-2.5 border border-[#EAE5D9] rounded-xl text-sm bg-white focus:ring-2 focus:ring-[#5A6B47] focus:border-[#5A6B47]">
                                <option value="NORMAL">อาหารทั่วไป</option>
                                <option value="VEGETARIAN">มังสวิรัติ (Vegetarian)</option>
                                <option value="JAY">อาหารเจ</option>
                                <option value="HALAL">ฮาลาล / มุสลิม</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-[#4A3B32] mb-1">ความต้องการพิเศษ / ข้อจำกัดทางร่างกาย (ถ้ามี)</label>
                            <input type="text" name="special_needs" placeholder="เช่น ขอห้องพักชั้นล่างเนื่องจากหัวเข่า, แพ้อาหาร..." class="w-full px-3.5 py-2.5 border border-[#EAE5D9] bg-white rounded-xl text-sm focus:ring-2 focus:ring-[#5A6B47] focus:border-[#5A6B47]">
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="pt-4 border-t border-[#EAE5D9] flex items-center justify-end space-x-3">
                    <a href="{{ route('home') }}" class="px-5 py-2.5 text-[#4A3B32] hover:text-[#2C3E2D] text-sm font-medium">ยกเลิก</a>
                    <button type="submit" class="bg-[#5A6B47] hover:bg-[#2C3E2D] text-white font-medium px-6 py-2.5 rounded-xl text-sm shadow-md transition flex items-center gap-2">
                        <i data-lucide="check" class="w-4 h-4"></i>
                        <span>ยืนยันการลงทะเบียน (Confirm Registration)</span>
                    </button>
                </div>
            </form>

            <script>
                function toggleStudentField(val) {
                    const el = document.getElementById('studentIdContainer');
                    if (val === 'STUDENT') {
                        el.classList.remove('hidden');
                    } else {
                        el.classList.add('hidden');
                        document.getElementById('txt_studentid').value = '';
                    }
                }

                function toggleMonkFields(prefix) {
                    const vassa = document.getElementById('vassaContainer');
                    if (prefix === 'พระ' || prefix === 'สามเณร') {
                        vassa.classList.remove('hidden');
                    } else {
                        vassa.classList.add('hidden');
                    }
                }

                // ==========================================
                // ระบบที่อยู่แบบ Cascading Dropdowns (Thailand Address Engine)
                // ==========================================
                let thaiProvinces = [];
                let thaiDistricts = [];
                let thaiSubdistricts = [];

                document.addEventListener('DOMContentLoaded', async () => {
                    try {
                        // โหลดข้อมูลจังหวัด
                        const resProv = await fetch('/assets/data/provinces.json');
                        thaiProvinces = await resProv.json();

                        // เรียงตามชื่อจังหวัด ก-ฮ
                        thaiProvinces.sort((a, b) => a.provinceNameTh.localeCompare(b.provinceNameTh, 'th'));

                        const provSelect = document.getElementById('province_select');
                        provSelect.innerHTML = '<option value="">-- กรุณาเลือกจังหวัด --</option>';
                        thaiProvinces.forEach(p => {
                            const opt = document.createElement('option');
                            opt.value = p.provinceNameTh;
                            opt.textContent = p.provinceNameTh;
                            opt.dataset.provinceCode = p.provinceCode;
                            provSelect.appendChild(opt);
                        });

                        // โหลดข้อมูลอำเภอและตำบลล่วงหน้าแบบ background
                        fetch('/assets/data/districts.json')
                            .then(r => r.json())
                            .then(data => { thaiDistricts = data; });

                        fetch('/assets/data/subdistricts.json')
                            .then(r => r.json())
                            .then(data => { thaiSubdistricts = data; });

                    } catch (err) {
                        console.error('Failed to load address database', err);
                        const provSelect = document.getElementById('province_select');
                        if (provSelect) provSelect.innerHTML = '<option value="">เกิดข้อผิดพลาดในการโหลดจังหวัด</option>';
                    }
                });

                function onProvinceChange(provinceName) {
                    const distSelect = document.getElementById('district_select');
                    const subSelect = document.getElementById('subdistrict_select');
                    const postalInput = document.getElementById('postal_code_input');

                    // รีเซ็ต dropdown อำเภอและตำบล
                    distSelect.innerHTML = '<option value="">-- กำลังโหลดรายชื่ออำเภอ... --</option>';
                    distSelect.disabled = true;
                    subSelect.innerHTML = '<option value="">-- กรุณาเลือกอำเภอก่อน --</option>';
                    subSelect.disabled = true;
                    postalInput.value = '';

                    if (!provinceName) {
                        distSelect.innerHTML = '<option value="">-- กรุณาเลือกจังหวัดก่อน --</option>';
                        return;
                    }

                    const provOption = document.querySelector(`#province_select option[value="${provinceName}"]`);
                    const provinceCode = provOption ? parseInt(provOption.dataset.provinceCode) : null;

                    // กรองอำเภอที่ตรงกับรหัสจังหวัด
                    const filteredDistricts = thaiDistricts.filter(d => d.provinceCode === provinceCode);
                    filteredDistricts.sort((a, b) => a.districtNameTh.localeCompare(b.districtNameTh, 'th'));

                    distSelect.innerHTML = '<option value="">-- เลือกอำเภอ / เขต --</option>';
                    filteredDistricts.forEach(d => {
                        const opt = document.createElement('option');
                        opt.value = d.districtNameTh;
                        opt.textContent = d.districtNameTh;
                        opt.dataset.districtCode = d.districtCode;
                        distSelect.appendChild(opt);
                    });
                    distSelect.disabled = false;
                }

                function onDistrictChange(districtName) {
                    const subSelect = document.getElementById('subdistrict_select');
                    const postalInput = document.getElementById('postal_code_input');

                    subSelect.innerHTML = '<option value="">-- กำลังโหลดรายชื่อตำบล... --</option>';
                    subSelect.disabled = true;
                    postalInput.value = '';

                    if (!districtName) {
                        subSelect.innerHTML = '<option value="">-- กรุณาเลือกอำเภอก่อน --</option>';
                        return;
                    }

                    const distOption = document.querySelector(`#district_select option[value="${districtName}"]`);
                    const districtCode = distOption ? parseInt(distOption.dataset.districtCode) : null;

                    // กรองตำบลที่ตรงกับรหัสอำเภอ
                    const filteredSubdistricts = thaiSubdistricts.filter(s => s.districtCode === districtCode);
                    filteredSubdistricts.sort((a, b) => a.subdistrictNameTh.localeCompare(b.subdistrictNameTh, 'th'));

                    subSelect.innerHTML = '<option value="">-- เลือกตำบล / แขวง --</option>';
                    filteredSubdistricts.forEach(s => {
                        const opt = document.createElement('option');
                        opt.value = s.subdistrictNameTh;
                        opt.textContent = s.subdistrictNameTh;
                        opt.dataset.postalCode = s.postalCode || '';
                        subSelect.appendChild(opt);
                    });
                    subSelect.disabled = false;
                }

                function onSubdistrictChange(subdistrictName) {
                    const subOption = document.querySelector(`#subdistrict_select option[value="${subdistrictName}"]`);
                    const postalInput = document.getElementById('postal_code_input');

                    if (subOption && subOption.dataset.postalCode) {
                        postalInput.value = subOption.dataset.postalCode;
                    }
                }
            </script>

        @endif

    </main>

    <!-- Footer -->
    <footer class="bg-[#FAF8F2] border-t border-[#EAE5D9] py-6 text-center text-xs text-[#7B8D65]">
        มหาวิทยาลัยมหาจุฬาลงกรณราชวิทยาลัย  • ระบบสารสนเทศการปฏิบัติวิปัสสนากรรมฐาน (MCUVMS)
    </footer>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>
