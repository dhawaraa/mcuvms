<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>สมัครปฏิบัติวิปัสสนากรรมฐาน - VPSMCU มจร</title>
    
    <!-- Fonts: Sarabun & Prompt -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@300;400;500;600;700&family=Prompt:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
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
                        brand: {
                            green: '#2C7338',
                            greenDark: '#235D2E',
                            greenLight: '#E8F5E9',
                            forest: '#1E4620',
                            clay: '#C86D51',
                            warmBg: '#FBF9F4',
                            border: '#E8E3D7',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        body { 
            font-family: 'Sarabun', sans-serif; 
            background-color: #F8F5EE;
            color: #2D2A26;
        }
        h1, h2, h3, h4, .font-heading { font-family: 'Prompt', sans-serif; }
        .hero-banner-card {
            background-image: linear-gradient(to right, rgba(21, 87, 36, 0.96) 0%, rgba(21, 87, 36, 0.88) 52%, rgba(21, 87, 36, 0.15) 85%, transparent 100%), url('{{ asset("images/heroimage.png") }}');
            background-size: cover;
            background-position: right center;
            background-repeat: no-repeat;
        }
        .main-card {
            background: #FFFFFF;
            border: 1px solid #EAE5D9;
            box-shadow: 0 4px 25px -4px rgba(74, 59, 50, 0.05);
        }
        .step-line {
            height: 2px;
            background-color: #E2DDD2;
        }
        .step-line.active {
            background-color: #2C7338;
        }
    </style>
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/mcu-logo.png') }}">
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

                <!-- Module 3 Navigation Tabs: สมัครคอร์ส vs ตรวจสอบสถานะ (Active: สมัครคอร์ส) -->
                <div class="hidden sm:flex items-center bg-[#EAE5D9]/80 p-1 rounded-2xl border border-[#D5CEBC]">
                    <a href="{{ route('public.register') }}" class="px-4 py-2 rounded-xl text-xs font-bold transition flex items-center gap-1.5 bg-[#5A6B47] text-white shadow-sm">
                        <i data-lucide="user-plus" class="w-4 h-4"></i>
                        <span>{{ __('portal.public_tab_register') }}</span>
                    </a>
                    <a href="{{ route('public.check') }}" class="px-4 py-2 rounded-xl text-xs font-bold transition flex items-center gap-1.5 text-[#4A3B32] hover:text-[#2C3E2D] hover:bg-[#FAF8F2]">
                        <i data-lucide="search" class="w-4 h-4 text-[#5A6B47]"></i>
                        <span>{{ __('portal.public_tab_check') }}</span>
                    </a>
                </div>

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
                        <i data-lucide="arrow-left" class="w-4.5 h-4.5 text-[#5A6B47]"></i> <span class="hidden sm:inline">{{ __('portal.nav_back_home') }}</span>
                    </a>
                </div>
            </div>

            <!-- Mobile Sub-Navigation -->
            <div class="flex sm:hidden items-center justify-center pb-3 pt-1 border-t border-[#EAE5D9] gap-2">
                <a href="{{ route('public.register') }}" class="flex-1 text-center py-1.5 px-3 rounded-lg text-xs font-bold bg-[#5A6B47] text-white">
                    {{ __('portal.public_tab_register') }}
                </a>
                <a href="{{ route('public.check') }}" class="flex-1 text-center py-1.5 px-3 rounded-lg text-xs font-bold bg-white text-[#4A3B32] border border-[#D5CEBC]">
                    {{ __('portal.public_tab_check') }}
                </a>
            </div>
        </div>
    </nav>

    <!-- Main Container -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full flex-grow space-y-6 sm:space-y-8">

        <!-- 1. Header Banner Card (Dynamic title per step) -->
        <div class="hero-banner-card rounded-2xl p-6 sm:p-9 text-white shadow-sm border border-[#205C29]/40 relative overflow-hidden">
            <div class="max-w-xl">
                <h1 id="banner_title" class="text-2xl sm:text-3xl font-heading font-extrabold text-white tracking-tight leading-snug">
                    สมัครปฏิบัติวิปัสสนากรรมฐาน
                </h1>
                <p id="banner_subtitle" class="text-base sm:text-lg font-heading font-medium text-white/95 mt-0.5">
                    เลือกโครงการที่ต้องการสมัคร
                </p>
                <p id="banner_desc" class="text-xs sm:text-sm text-white/85 mt-3 leading-relaxed">
                    กรุณาเลือกโครงการที่ท่านสนใจและอยู่ในช่วงเปิดรับสมัคร<br class="hidden sm:inline">
                    จากนั้นคลิก "ถัดไป" เพื่อกรอกข้อมูลผู้สมัครในขั้นตอนต่อไป
                </p>
            </div>
        </div>

        <!-- 2. Wizard Stepper (Circular Numbers with Connecting Lines) -->
        <div class="max-w-2xl mx-auto px-2">
            <div class="relative flex items-center justify-between">
                <!-- Background Connection Lines -->
                <div class="absolute top-5 left-10 right-10 -translate-y-1/2 flex items-center z-0">
                    <div id="step-connector-1" class="step-line flex-1 transition duration-300"></div>
                    <div id="step-connector-2" class="step-line flex-1 transition duration-300"></div>
                </div>

                <!-- Step 1 Circle & Label -->
                <div class="relative z-10 flex flex-col items-center cursor-pointer" onclick="goToStep(1)">
                    <div id="step-circle-1" class="w-10 h-10 rounded-full bg-[#1F6B30] text-white flex items-center justify-center font-bold text-sm shadow-xs transition duration-200">
                        <i data-lucide="check" class="w-5 h-5 hidden" id="step-icon-1"></i>
                        <span id="step-num-1">1</span>
                    </div>
                    <span id="step-text-1" class="text-xs sm:text-sm font-heading font-bold text-[#2D2A26] mt-2 text-center whitespace-nowrap">
                        เลือกโครงการ
                    </span>
                </div>

                <!-- Step 2 Circle & Label -->
                <div class="relative z-10 flex flex-col items-center cursor-pointer" onclick="goToStep(2)">
                    <div id="step-circle-2" class="w-10 h-10 rounded-full bg-white border-2 border-[#D5CEBC] text-[#8C8275] flex items-center justify-center font-bold text-sm shadow-xs transition duration-200">
                        <i data-lucide="check" class="w-5 h-5 hidden" id="step-icon-2"></i>
                        <span id="step-num-2">2</span>
                    </div>
                    <span id="step-text-2" class="text-xs sm:text-sm font-heading font-medium text-[#7A7367] mt-2 text-center whitespace-nowrap">
                        กรอกข้อมูลผู้สมัคร
                    </span>
                </div>

                <!-- Step 3 Circle & Label -->
                <div class="relative z-10 flex flex-col items-center cursor-pointer" onclick="goToStep(3)">
                    <div id="step-circle-3" class="w-10 h-10 rounded-full bg-white border-2 border-[#D5CEBC] text-[#8C8275] flex items-center justify-center font-bold text-sm shadow-xs transition duration-200">
                        <i data-lucide="check" class="w-5 h-5 hidden" id="step-icon-3"></i>
                        <span id="step-num-3">3</span>
                    </div>
                    <span id="step-text-3" class="text-xs sm:text-sm font-heading font-medium text-[#7A7367] mt-2 text-center whitespace-nowrap">
                        ยืนยันการสมัคร
                    </span>
                </div>
            </div>
        </div>

        @if (session('error'))
            <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-xl shadow-xs">
                <div class="flex items-center">
                    <i data-lucide="alert-triangle" class="w-5 h-5 text-red-500 mr-2 shrink-0"></i>
                    <p class="text-sm text-red-800 font-medium">{{ session('error') }}</p>
                </div>
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-xl shadow-xs space-y-1">
                <div class="flex items-center text-red-800 font-bold text-sm mb-1">
                    <i data-lucide="alert-triangle" class="w-5 h-5 text-red-500 mr-2 shrink-0"></i>
                    <span>เกิดข้อผิดพลาดในการลงทะเบียน โปรดตรวจสอบข้อมูล:</span>
                </div>
                <ul class="list-disc list-inside text-xs text-red-700 space-y-0.5 ml-7">
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('regSuccess'))
            <div class="main-card rounded-2xl p-8 sm:p-12 text-center shadow-lg">
                <div class="w-20 h-20 bg-[#2C7338]/15 text-[#2C7338] rounded-full flex items-center justify-center mx-auto mb-4 border border-[#2C7338]/30">
                    <i data-lucide="check-circle" class="w-10 h-10"></i>
                </div>
                <div class="inline-block px-3.5 py-1 bg-amber-50 text-amber-800 text-xs font-semibold rounded-full border border-amber-200 mb-3">
                    สถานะ: รอเจ้าหน้าที่ตรวจสอบคุณสมบัติ (Pending Review)
                </div>
                <h2 class="text-xl md:text-3xl font-heading font-bold text-[#2C3E2D] mb-2">{{ session('success') }}</h2>
                <p class="text-[#4A3B32] text-sm mb-3">รหัสการลงทะเบียนของท่านคือ:</p>
                <div class="inline-block bg-[#F8F5EE] border-2 border-[#D5CEBC] font-mono font-extrabold text-2xl md:text-3xl px-8 py-3 rounded-xl text-[#C86D51] tracking-wider mb-6">
                    {{ session('regSuccess') }}
                </div>
                <div class="max-w-md mx-auto bg-[#FAF8F2] border border-[#EAE5D9] rounded-xl p-4 text-xs text-[#7B8D65] text-left mb-6 space-y-1.5">
                    <div class="font-bold text-[#2C3E2D] flex items-center gap-1.5 text-sm">
                        <i data-lucide="info" class="w-4 h-4 text-[#2C7338]"></i> ลำดับขั้นตอนถัดไป:
                    </div>
                    <div>1. เจ้าหน้าที่ส่วนงานจะตรวจสอบประวัติและข้อจำกัดทางสุขภาพ/อาหาร</div>
                    <div>2. ตรวจสอบการจัดสรรห้องพัก/อาคารตามเพศสภาพและพรรษา</div>
                    <div>3. เมื่อผ่านการอนุมัติ เจ้าหน้าที่จะปรับสถานะเป็น "อนุมัติสิทธิ์ (Confirmed)" เพื่อเตรียมเข้ารับการอบรม</div>
                </div>
                <div class="flex flex-wrap items-center justify-center gap-3">
                    <button onclick="window.print()" class="bg-[#2C7338] hover:bg-[#235D2E] text-white font-medium px-6 py-2.5 rounded-xl text-sm transition flex items-center gap-2">
                        <i data-lucide="printer" class="w-4 h-4"></i> พิมพ์เอกสารยืนยัน
                    </button>
                    <a href="{{ route('public.register') }}" class="px-6 py-2.5 rounded-xl text-sm font-medium bg-white border border-[#D5CEBC] text-[#4A3B32] hover:bg-[#FAF8F2] transition">
                        ลงทะเบียนให้ท่านอื่น
                    </a>
                </div>
            </div>
        @else

            <!-- Form Card Wrapper -->
            <form id="publicRegisterForm" action="{{ url('/public_register.php') }}" method="POST">
                @csrf

                <!-- ============================================================== -->
                <!-- STEP 1: หน้าเลือกรีวิวโครงการ (Step 1) -->
                <!-- ============================================================== -->
                <div id="step-content-1" class="main-card rounded-2xl p-6 sm:p-9 space-y-6">
                    
                    <!-- Section Title with Icon -->
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-[#E8F3EA] text-[#2C7338] flex items-center justify-center shrink-0">
                            <i data-lucide="calendar" class="w-5 h-5"></i>
                        </div>
                        <div>
                            <h2 class="text-lg sm:text-xl font-heading font-bold text-[#2D2A26]">โครงการที่เปิดรับสมัคร</h2>
                            <p class="text-xs text-[#7A7367] mt-0.5">เลือกโครงการปฏิบัติวิปัสสนากรรมฐานที่ท่านสนใจ</p>
                        </div>
                    </div>

                    <!-- Events List -->
                    <div class="space-y-4">
                        @forelse ($events as $index => $ev)
                            @php 
                                $quota = $ev->max_quota ?? 50;
                                $confirmed = $ev->confirmed_count ?? 0;
                                $available = max(0, $quota - $confirmed);
                                $isFull = ($available <= 0);
                                $percent = $quota > 0 ? min(100, round(($confirmed / $quota) * 100)) : 0;
                                $coverImg = $ev->cover_image ? $ev->cover_image : '/images/news/meditation_hall.jpg';
                            @endphp
                            <label class="event-card group relative block p-4 sm:p-5 border border-[#E8E3D7] rounded-2xl cursor-pointer hover:border-[#2C7338] hover:shadow-xs transition bg-[#FFFFFF]" data-event-id="{{ $ev->id }}">
                                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4">
                                    
                                    <!-- Radio Selector Circle -->
                                    <div class="shrink-0 flex items-center">
                                        <input type="radio" name="event_id" value="{{ $ev->id }}" {{ $index === 0 ? 'checked' : '' }} required class="event-radio w-5 h-5 text-[#2C7338] focus:ring-[#2C7338] cursor-pointer" onchange="onEventRadioChange(this)">
                                    </div>

                                    <!-- Thumbnail Image -->
                                    <div class="w-full sm:w-44 h-28 rounded-xl overflow-hidden bg-stone-100 shrink-0 border border-[#EAE5D9]">
                                        <img src="{{ asset($coverImg) }}" alt="{{ $ev->localized_title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                                    </div>

                                    <!-- Event Main Information -->
                                    <div class="flex-grow min-w-0 space-y-2">
                                        <div class="flex items-center gap-2">
                                            @if ($ev->status === 'OPEN' && !$isFull)
                                                <span class="px-2.5 py-0.5 rounded-md text-[11px] font-bold bg-[#2C7338] text-white">
                                                    เปิดรับสมัคร
                                                </span>
                                            @elseif ($isFull)
                                                <span class="px-2.5 py-0.5 rounded-md text-[11px] font-bold bg-[#A3432B] text-white">
                                                    ที่นั่งเต็ม (คิวสำรอง)
                                                </span>
                                            @else
                                                <span class="px-2.5 py-0.5 rounded-md text-[11px] font-bold bg-[#A3432B] text-white">
                                                    เร็ว ๆ นี้
                                                </span>
                                            @endif
                                        </div>

                                        <h3 class="font-heading font-bold text-base text-[#2D2A26] group-hover:text-[#2C7338] transition leading-snug event-title">
                                            {{ $ev->localized_title }}
                                        </h3>
                                        <p class="text-xs text-[#7A7367] event-target">
                                            สำหรับนิสิต บุคลากร และประชาชนทั่วไป
                                        </p>

                                        <div class="pt-1 flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4 text-xs text-[#6B6357]">
                                            <div class="flex items-center gap-1.5 truncate">
                                                <i data-lucide="map-pin" class="w-3.5 h-3.5 text-[#C86D51] shrink-0"></i>
                                                <span class="truncate event-location">{{ $ev->localized_location }}</span>
                                            </div>
                                            <div class="flex items-center gap-1.5 shrink-0">
                                                <i data-lucide="calendar" class="w-3.5 h-3.5 text-[#7A7367] shrink-0"></i>
                                                @php
                                                    $sDate = \Carbon\Carbon::parse($ev->start_date);
                                                    $eDate = \Carbon\Carbon::parse($ev->end_date);
                                                    $thMonths = ['', 'ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.'];
                                                    $nights = $sDate->diffInDays($eDate);
                                                    $days = $nights + 1;
                                                    $dateStr = ($sDate->format('Y-m') === $eDate->format('Y-m'))
                                                        ? ($sDate->day . ' - ' . $eDate->day . ' ' . $thMonths[$sDate->month] . ' ' . ($sDate->year + 543))
                                                        : ($sDate->day . ' ' . $thMonths[$sDate->month] . ' ' . ($sDate->year + 543) . ' - ' . $eDate->day . ' ' . $thMonths[$eDate->month] . ' ' . ($eDate->year + 543));
                                                    
                                                    $deadlineDate = $sDate->copy()->subDays(3);
                                                    $deadlineStr = $deadlineDate->day . ' ' . $thMonths[$deadlineDate->month] . ' ' . ($deadlineDate->year + 543);
                                                @endphp
                                                <span class="event-dates">{{ $dateStr }} ({{ $nights }} คืน {{ $days }} วัน)</span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Right Meta Badge (Quota & Deadlines) -->
                                    <div class="w-full sm:w-44 shrink-0 bg-[#FBF9F4] rounded-xl p-3 border border-[#EFECE5] text-xs space-y-2 mt-2 sm:mt-0">
                                        <div class="flex items-center gap-1.5 text-[#6B6357]">
                                            <i data-lucide="calendar-check" class="w-3.5 h-3.5 text-[#7A7367]"></i>
                                            <span>รับสมัครถึง</span>
                                            <strong class="text-[#2D2A26]">{{ $deadlineStr }}</strong>
                                        </div>

                                        <div class="flex items-center gap-1.5 text-[#6B6357]">
                                            <i data-lucide="users" class="w-3.5 h-3.5 text-[#2C7338]"></i>
                                            <span>เหลือ <strong>{{ $available }}</strong> ที่นั่ง</span>
                                        </div>
                                        <div class="text-[10px] text-[#8C8275]">
                                            จากทั้งหมด {{ $quota }} ที่นั่ง
                                        </div>

                                        <!-- Progress Bar -->
                                        <div class="w-full bg-[#EAE5D9] rounded-full h-1.5 overflow-hidden">
                                            <div class="bg-[#2C7338] h-1.5 rounded-full" style="width: {{ $percent }}%"></div>
                                        </div>
                                        <div class="text-right text-[10px] text-[#7A7367] font-mono">
                                            {{ $percent }}%
                                        </div>
                                    </div>

                                </div>
                            </label>
                        @empty
                            <div class="text-center py-10 text-[#7B8D65] bg-[#FAF8F2] rounded-xl border border-dashed border-[#EAE5D9]">
                                ยังไม่มีโครงการเปิดรับสมัครในขณะนี้
                            </div>
                        @endforelse
                    </div>

                    <!-- Step 1 Footer Buttons -->
                    <div class="pt-6 border-t border-[#EAE5D9] flex items-center justify-end gap-4">
                        <a href="{{ route('home') }}" class="text-xs font-semibold text-[#6B6357] hover:text-[#2D2A26] transition">
                            ยกเลิก
                        </a>
                        <button type="button" onclick="nextToStep(2)" class="bg-[#2C7338] hover:bg-[#235D2E] text-white font-semibold px-6 py-2.5 rounded-xl text-xs sm:text-sm shadow-xs transition flex items-center gap-2">
                            <span>ถัดไป : กรอกข้อมูลผู้สมัคร</span>
                            <i data-lucide="arrow-right" class="w-4 h-4"></i>
                        </button>
                    </div>
                </div>

                <!-- ============================================================== -->
                <!-- STEP 2: หน้ากรอกข้อมูลผู้สมัคร (Step 2) -->
                <!-- ============================================================== -->
                <div id="step-content-2" class="hidden main-card rounded-2xl p-6 sm:p-9 space-y-7">
                    
                    <!-- Selected Project Preview Header -->
                    <div class="flex items-center gap-3 pb-4 border-b border-[#EAE5D9]">
                        <div class="w-10 h-10 rounded-xl bg-[#E8F3EA] text-[#2C7338] flex items-center justify-center shrink-0">
                            <i data-lucide="layout-list" class="w-5 h-5"></i>
                        </div>
                        <h2 class="text-lg sm:text-xl font-heading font-bold text-[#2D2A26]">โครงการที่ท่านเลือกเข้าร่วม</h2>
                    </div>

                    <!-- Selected Project Preview Box (Matches Screenshot 2) -->
                    <div class="p-4 sm:p-5 border border-[#E8E3D7] rounded-2xl bg-white flex flex-col sm:flex-row items-start sm:items-center gap-4">
                        <div class="w-full sm:w-36 h-24 rounded-xl overflow-hidden bg-stone-100 shrink-0 border border-[#EAE5D9]">
                            <img id="selected_ev_img" src="/images/news/meditation_hall.jpg" alt="Selected Event" class="w-full h-full object-cover">
                        </div>
                        <div class="flex-grow space-y-1.5">
                            <span class="px-2 py-0.5 rounded-md text-[11px] font-bold bg-[#2C7338] text-white inline-block">
                                เปิดรับสมัคร
                            </span>
                            <h3 id="selected_ev_title" class="font-heading font-bold text-base text-[#2D2A26] leading-snug">
                                --
                            </h3>
                            <p class="text-xs text-[#7A7367]">
                                สำหรับนิสิต บุคลากร และประชาชนทั่วไป
                            </p>
                        </div>
                        <div class="w-full sm:w-56 shrink-0 bg-[#F4FBF5] rounded-xl p-3 border border-[#D7EED9] text-xs space-y-1.5">
                            <div class="flex items-center gap-1.5 text-[#2C7338] font-semibold">
                                <i data-lucide="calendar" class="w-3.5 h-3.5"></i>
                                <span id="selected_ev_dates">--</span>
                            </div>
                            <div class="flex items-start gap-1.5 text-[#6B6357]">
                                <i data-lucide="map-pin" class="w-3.5 h-3.5 text-[#C86D51] shrink-0 mt-0.5"></i>
                                <span id="selected_ev_loc" class="text-[11px] leading-tight">--</span>
                            </div>
                        </div>
                    </div>

                    <!-- 1. ข้อมูลผู้สมัครเข้าร่วมโครงการ (Personal Information) -->
                    <div class="space-y-4">
                        <div class="flex items-center gap-2">
                            <span class="w-6 h-6 rounded-full bg-[#2C7338] text-white flex items-center justify-center text-xs font-bold font-mono">1</span>
                            <h3 class="font-heading font-bold text-sm sm:text-base text-[#2D2A26]">ข้อมูลผู้สมัครเข้าร่วมโครงการ (Personal Information)</h3>
                        </div>

                        <!-- Status Selector Radio Box -->
                        <div class="p-4 rounded-xl bg-[#FBF9F4] border border-[#EFECE5]">
                            <div class="text-xs text-[#7A7367] mb-2 font-medium">สถานะผู้สมัคร (Applicant Status)</div>
                            <div class="flex flex-wrap gap-6 text-xs text-[#2D2A26]">
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="radio" name="applicant_type" value="PEOPLE" checked class="w-4 h-4 text-[#2C7338] focus:ring-[#2C7338]" onchange="toggleStudentField(this.value)">
                                    <span>ประชาชนทั่วไป (General Public)</span>
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="radio" name="applicant_type" value="STUDENT" class="w-4 h-4 text-[#2C7338] focus:ring-[#2C7338]" onchange="toggleStudentField(this.value)">
                                    <span>นิสิต มจร (MCU Student)</span>
                                </label>
                            </div>
                        </div>

                        <!-- Academic Info Container (Collapsible) -->
                        <div id="studentIdContainer" class="hidden p-4 rounded-xl bg-[#FBF9F4] border border-[#EFECE5] space-y-3">
                            <div class="flex items-center gap-2 text-xs font-bold text-[#2C7338]">
                                <i data-lucide="graduation-cap" class="w-4 h-4"></i>
                                <span>ข้อมูลการศึกษาใน มจร (MCU Academic Information)</span>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 text-xs">
                                <div>
                                    <label class="block text-[#6B6357] mb-1">รหัสนิสิต มจร (Student ID) <span class="text-red-500">*</span></label>
                                    <input type="text" name="student_id" id="txt_studentid" placeholder="เช่น 6401201001" class="w-full px-3 py-2 bg-white border border-[#D5CEBC] rounded-lg text-xs font-mono">
                                </div>
                                <div>
                                    <label class="block text-[#6B6357] mb-1">ระดับการศึกษา <span class="text-red-500">*</span></label>
                                    <select name="degree_level" id="select_degree_level" class="w-full px-3 py-2 bg-white border border-[#D5CEBC] rounded-lg text-xs">
                                        <option value="">-- เลือกระดับการศึกษา --</option>
                                        <option value="ปริญญาตรี">ปริญญาตรี</option>
                                        <option value="ปริญญาโท">ปริญญาโท</option>
                                        <option value="ปริญญาเอก">ปริญญาเอก</option>
                                        <option value="ประกาศนียบัตร">ประกาศนียบัตร</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-[#6B6357] mb-1">คณะ <span class="text-red-500">*</span></label>
                                    <select name="faculty" id="txt_faculty" class="w-full px-3 py-2 bg-white border border-[#D5CEBC] rounded-lg text-xs">
                                        <option value="">-- เลือกคณะ --</option>
                                        <option value="พุทธศาสตร์">พุทธศาสตร์</option>
                                        <option value="ครุศาสตร์">ครุศาสตร์</option>
                                        <option value="สังคมศาสตร์">สังคมศาสตร์</option>
                                        <option value="มนุษยศาสตร์">มนุษยศาสตร์</option>
                                        <option value="บัณฑิตวิทยาลัย">บัณฑิตวิทยาลัย</option>
                                        <option value="IBSC">IBSC</option>
                                        <option value="วิทยาลัยสงฆ์/วิทยาเขต">วิทยาลัยสงฆ์/วิทยาเขต</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-[#6B6357] mb-1">หลักสูตร / สาขาวิชา <span class="text-red-500">*</span></label>
                                    <input type="text" name="program_name" id="txt_program_name" placeholder="เช่น พุทธศาสตรบัณฑิต, การสอนภาษาไทย" class="w-full px-3 py-2 bg-white border border-[#D5CEBC] rounded-lg text-xs">
                                </div>
                            </div>
                        </div>

                        <!-- Personal Fields Grid -->
                        <div class="grid grid-cols-1 sm:grid-cols-12 gap-3 text-xs">
                            <div class="sm:col-span-4">
                                <label class="block text-[#6B6357] mb-1">เลขบัตร ปชช. / Passport <span class="text-red-500">*</span></label>
                                <input type="text" name="citizen_id" id="inp_citizen_id" placeholder="13 หลัก หรือเลข Passport" required class="w-full px-3 py-2 bg-white border border-[#D5CEBC] rounded-lg text-xs font-mono">
                            </div>
                            <div class="sm:col-span-3">
                                <label class="block text-[#6B6357] mb-1">คำนำหน้าชื่อ <span class="text-red-500">*</span></label>
                                <input type="text" name="prefix" id="prefix_select" list="prefix_datalist" placeholder="เช่น นาย, พระ, นางสาว" required class="w-full px-3 py-2 bg-white border border-[#D5CEBC] rounded-lg text-xs">
                                <datalist id="prefix_datalist">
                                    <option value="นาย">
                                    <option value="นาง">
                                    <option value="นางสาว">
                                    <option value="พระ">
                                    <option value="พระภิกษุ">
                                    <option value="สามเณร">
                                    <option value="แม่ชี">
                                    <option value="อุบาสก">
                                    <option value="อุบาสิกา">
                                </datalist>
                            </div>
                            <div class="sm:col-span-5">
                                <label class="block text-[#6B6357] mb-1">ชื่อ <span class="text-red-500">*</span></label>
                                <input type="text" name="first_name" id="inp_first_name" required class="w-full px-3 py-2 bg-white border border-[#D5CEBC] rounded-lg text-xs">
                            </div>

                            <div class="sm:col-span-4">
                                <label class="block text-[#6B6357] mb-1">นามสกุล <span class="text-red-500">*</span></label>
                                <input type="text" name="last_name" id="inp_last_name" required class="w-full px-3 py-2 bg-white border border-[#D5CEBC] rounded-lg text-xs">
                            </div>
                            <div class="sm:col-span-4">
                                <label class="block text-[#6B6357] mb-1">ฉายา (เฉพาะพระภิกษุ)</label>
                                <input type="text" name="buddhist_name" id="inp_buddhist_name" placeholder="เช่น เขมธมฺโม หรือเว้นว่าง" class="w-full px-3 py-2 bg-white border border-[#D5CEBC] rounded-lg text-xs">
                            </div>
                            <div class="sm:col-span-2" id="vassaWrapper">
                                <label class="block text-[#6B6357] mb-1">พรรษา (เฉพาะพระภิกษุ)</label>
                                <input type="number" name="vassa" id="inp_vassa" value="0" min="0" class="w-full px-3 py-2 bg-white border border-[#D5CEBC] rounded-lg text-xs">
                            </div>
                            <div class="sm:col-span-2">
                                <label class="block text-[#6B6357] mb-1">อายุ (ปี)</label>
                                <input type="number" name="age" id="inp_age" placeholder="เช่น 45" class="w-full px-3 py-2 bg-white border border-[#D5CEBC] rounded-lg text-xs">
                            </div>

                            <div class="sm:col-span-4">
                                <label class="block text-[#6B6357] mb-1">เบอร์โทรศัพท์ติดต่อ <span class="text-red-500">*</span></label>
                                <input type="tel" name="phone" id="inp_phone" placeholder="08xxxxxxxx" required class="w-full px-3 py-2 bg-white border border-[#D5CEBC] rounded-lg text-xs font-mono">
                            </div>
                            <div class="sm:col-span-4">
                                <label class="block text-[#6B6357] mb-1">อีเมล (ถ้ามี)</label>
                                <input type="email" name="email" id="inp_email" placeholder="example@gmail.com" class="w-full px-3 py-2 bg-white border border-[#D5CEBC] rounded-lg text-xs">
                            </div>
                            <div class="sm:col-span-4">
                                <label class="block text-[#6B6357] mb-1">ไลน์ (Line ID)</label>
                                <input type="text" name="line_id" id="inp_line" placeholder="Line ID หรือเบอร์ไลน์" class="w-full px-3 py-2 bg-white border border-[#D5CEBC] rounded-lg text-xs">
                            </div>
                        </div>
                    </div>

                    <!-- 2. ที่อยู่ (Address) -->
                    <div class="space-y-4 pt-3 border-t border-[#EAE5D9]">
                        <div class="flex items-center gap-2">
                            <span class="w-6 h-6 rounded-full bg-[#2C7338] text-white flex items-center justify-center text-xs font-bold font-mono">2</span>
                            <h3 class="font-heading font-bold text-sm sm:text-base text-[#2D2A26]">ที่อยู่ (Address)</h3>
                        </div>

                        <div class="space-y-3 text-xs">
                            <div>
                                <label class="block text-[#6B6357] mb-1">ที่อยู่ / วัดต้นสังกัด / บ้านเลขที่ หมู่ ซอย ถนน</label>
                                <input type="text" name="address" id="inp_address" placeholder="เช่น 99/1 หมู่ 2 หรือ วัดมหาธาตุยุวราชรังสฤษฎิ์" class="w-full px-3 py-2 bg-white border border-[#D5CEBC] rounded-lg text-xs">
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
                                <div>
                                    <label class="block text-[#6B6357] mb-1">จังหวัด (Province) <span class="text-red-500">*</span></label>
                                    <select id="province_select" name="province" required onchange="onProvinceChange(this.value)" class="w-full px-3 py-2 bg-white border border-[#D5CEBC] rounded-lg text-xs">
                                        <option value="">-- กรุณาเลือกจังหวัด --</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-[#6B6357] mb-1">อำเภอ / เขต (District) <span class="text-red-500">*</span></label>
                                    <select id="district_select" name="district" required disabled onchange="onDistrictChange(this.value)" class="w-full px-3 py-2 bg-white border border-[#D5CEBC] rounded-lg text-xs disabled:bg-stone-100">
                                        <option value="">-- เลือกจังหวัดก่อน --</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-[#6B6357] mb-1">ตำบล / แขวง (Subdistrict) <span class="text-red-500">*</span></label>
                                    <select id="subdistrict_select" name="subdistrict" required disabled onchange="onSubdistrictChange(this.value)" class="w-full px-3 py-2 bg-white border border-[#D5CEBC] rounded-lg text-xs disabled:bg-stone-100">
                                        <option value="">-- เลือกอำเภอก่อน --</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-[#6B6357] mb-1">รหัสไปรษณีย์ (Postal Code)</label>
                                    <input type="text" id="postal_code_input" name="postal_code" maxlength="5" placeholder="เช่น 13170" class="w-full px-3 py-2 bg-[#FBF9F4] border border-[#D5CEBC] rounded-lg text-xs font-mono">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 3. ข้อมูลห้องพัก ยานพาหนะ และอาหาร (Accommodations & Preferences) -->
                    <div class="space-y-4 pt-3 border-t border-[#EAE5D9]">
                        <div class="flex items-center gap-2">
                            <span class="w-6 h-6 rounded-full bg-[#2C7338] text-white flex items-center justify-center text-xs font-bold font-mono">3</span>
                            <h3 class="font-heading font-bold text-sm sm:text-base text-[#2D2A26]">ข้อมูลห้องพัก ยานพาหนะ และอาหาร (Accommodations & Preferences)</h3>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                            <div>
                                <label class="block text-[#6B6357] mb-1">ข้อมูลห้องพัก / อาคารที่ต้องการ (Room / Building Request)</label>
                                <select name="room_info" id="inp_room_info" class="w-full px-3 py-2 bg-white border border-[#D5CEBC] rounded-lg text-xs">
                                    <option value="แบบตัวเลือก - ขอที่พักเอง / พักรวมตามที่สถาบันจัดให้">แบบตัวเลือก - ขอที่พักเอง / พักรวมตามที่สถาบันจัดให้</option>
                                    <option value="พักรวมตามที่สถาบันจัดให้">พักรวมตามที่สถาบันจัดให้</option>
                                    <option value="ขอพักเดี่ยว (กรณีมีข้อจำกัดด้านสุขภาพ)">ขอพักเดี่ยว (กรณีมีข้อจำกัดด้านสุขภาพ)</option>
                                    <option value="เดินทางไป-กลับ ไม่ค้างคืน">เดินทางไป-กลับ ไม่ค้างคืน</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-[#6B6357] mb-1">การเดินทาง / ยานพาหนะ</label>
                                <select name="vehicle_info" id="inp_vehicle_info" class="w-full px-3 py-2 bg-white border border-[#D5CEBC] rounded-lg text-xs">
                                    <option value="แบบตัวเลือก - เดินทางไป-กลับเอง / ขึ้นรถตามที่สถาบันจัดให้">แบบตัวเลือก - เดินทางไป-กลับเอง / ขึ้นรถตามที่สถาบันจัดให้</option>
                                    <option value="เดินทางโดยรถยนต์ส่วนตัว">เดินทางโดยรถยนต์ส่วนตัว</option>
                                    <option value="เดินทางโดยรถตู้/รถบัสของสถาบัน">เดินทางโดยรถตู้/รถบัสของสถาบัน</option>
                                    <option value="เดินทางโดยรถโดยสารสาธารณะ">เดินทางโดยรถโดยสารสาธารณะ</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-[#6B6357] mb-1">ประเภทอาหาร <span class="text-red-500">*</span></label>
                                <select name="food_type" id="inp_food_type" class="w-full px-3 py-2 bg-white border border-[#D5CEBC] rounded-lg text-xs">
                                    <option value="NORMAL">อาหารทั่วไป</option>
                                    <option value="VEGETARIAN">มังสวิรัติ (Vegetarian)</option>
                                    <option value="JAY">อาหารเจ</option>
                                    <option value="HALAL">ฮาลาล / มุสลิม</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-[#6B6357] mb-1">ความต้องการพิเศษ / ข้อจำกัดทางร่างกาย (ถ้ามี)</label>
                                <input type="text" name="special_needs" id="inp_special_needs" placeholder="เช่น ขอห้องพักชั้นล่างเนื่องจากหัวเข่า, แพ้อาหาร..." class="w-full px-3 py-2 bg-white border border-[#D5CEBC] rounded-lg text-xs">
                            </div>
                        </div>
                    </div>

                    <!-- Step 2 Footer Buttons -->
                    <div class="pt-6 border-t border-[#EAE5D9] flex items-center justify-end gap-3">
                        <button type="button" onclick="goToStep(1)" class="px-5 py-2.5 rounded-xl border border-[#D5CEBC] text-[#4A3B32] hover:bg-[#FAF8F2] text-xs sm:text-sm font-semibold flex items-center gap-1.5 transition">
                            <i data-lucide="arrow-left" class="w-4 h-4"></i>
                            <span>ย้อนกลับ</span>
                        </button>
                        <button type="button" onclick="validateAndGoToStep3()" class="bg-[#2C7338] hover:bg-[#235D2E] text-white font-semibold px-6 py-2.5 rounded-xl text-xs sm:text-sm shadow-xs transition flex items-center gap-2">
                            <i data-lucide="check" class="w-4 h-4"></i>
                            <span>ยืนยันการลงทะเบียน</span>
                        </button>
                    </div>
                </div>

                <!-- ============================================================== -->
                <!-- STEP 3: หน้ารีวิว กฎ ระเบียบต่างๆ ก่อนการกดยืนยัน (Step 3) -->
                <!-- ============================================================== -->
                <div id="step-content-3" class="hidden main-card rounded-2xl p-6 sm:p-9 space-y-6">
                    
                    <!-- Section Title: สรุปข้อมูลก่อนยืนยัน -->
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-[#E8F3EA] text-[#2C7338] flex items-center justify-center shrink-0">
                            <i data-lucide="file-text" class="w-5 h-5"></i>
                        </div>
                        <div>
                            <h2 class="text-lg sm:text-xl font-heading font-bold text-[#2D2A26]">สรุปข้อมูลก่อนยืนยัน</h2>
                            <p class="text-xs text-[#7A7367] mt-0.5">กรุณาตรวจสอบความถูกต้องของข้อมูลทั้งหมดก่อนยืนยันการสมัคร</p>
                        </div>
                    </div>

                    <!-- 1. ข้อมูลโครงการที่ท่านเลือก (Card Box) -->
                    <div class="space-y-2.5">
                        <div class="flex items-center gap-2 text-sm font-heading font-bold text-[#2D2A26]">
                            <span class="w-5 h-5 rounded-md bg-[#2C7338] text-white flex items-center justify-center text-[10px]">
                                <i data-lucide="list" class="w-3.5 h-3.5"></i>
                            </span>
                            <span>ข้อมูลโครงการที่ท่านเลือก</span>
                        </div>

                        <div class="p-4 sm:p-5 border border-[#E8E3D7] rounded-2xl bg-white flex flex-col sm:flex-row items-start sm:items-center gap-4">
                            <div class="w-full sm:w-36 h-24 rounded-xl overflow-hidden bg-stone-100 shrink-0 border border-[#EAE5D9]">
                                <img id="review_ev_img" src="/images/news/meditation_hall.jpg" alt="Event Cover" class="w-full h-full object-cover">
                            </div>
                            <div class="flex-grow space-y-1.5">
                                <span class="px-2 py-0.5 rounded-md text-[11px] font-bold bg-[#2C7338] text-white inline-block">
                                    เปิดรับสมัคร
                                </span>
                                <h3 id="review_ev_title" class="font-heading font-bold text-base text-[#2D2A26] leading-snug">
                                    --
                                </h3>
                                <p class="text-xs text-[#7A7367]">
                                    สำหรับนิสิต บุคลากร และประชาชนทั่วไป
                                </p>
                            </div>
                            <div class="w-full sm:w-56 shrink-0 bg-[#F4FBF5] rounded-xl p-3 border border-[#D7EED9] text-xs space-y-1.5">
                                <div class="flex items-center gap-1.5 text-[#2C7338] font-semibold">
                                    <i data-lucide="calendar" class="w-3.5 h-3.5"></i>
                                    <span id="review_ev_dates">--</span>
                                </div>
                                <div class="flex items-start gap-1.5 text-[#6B6357]">
                                    <i data-lucide="map-pin" class="w-3.5 h-3.5 text-[#C86D51] shrink-0 mt-0.5"></i>
                                    <span id="review_ev_loc" class="text-[11px] leading-tight">--</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 2. ข้อมูลผู้สมัครโดยสรุป (Grid List + Edit Link) -->
                    <div class="space-y-2.5">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2 text-sm font-heading font-bold text-[#2D2A26]">
                                <span class="w-5 h-5 rounded-md bg-[#2C7338] text-white flex items-center justify-center text-[10px]">
                                    <i data-lucide="user" class="w-3.5 h-3.5"></i>
                                </span>
                                <span>ข้อมูลผู้สมัครโดยสรุป</span>
                            </div>
                            <button type="button" onclick="goToStep(2)" class="text-xs text-[#2C7338] hover:underline font-semibold flex items-center gap-1">
                                <i data-lucide="edit-3" class="w-3.5 h-3.5"></i>
                                <span>แก้ไขข้อมูลผู้สมัคร</span>
                            </button>
                        </div>

                        <div class="p-4 sm:p-5 border border-[#E8E3D7] rounded-2xl bg-[#FBF9F4] grid grid-cols-1 md:grid-cols-2 gap-y-2 gap-x-8 text-xs">
                            <div class="flex justify-between sm:justify-start gap-4">
                                <span class="text-[#7A7367] w-28 shrink-0">ชื่อ - สกุล</span>
                                <span class="text-[#2D2A26] font-semibold">: <span id="sum_name">--</span></span>
                            </div>
                            <div class="flex justify-between sm:justify-start gap-4">
                                <span class="text-[#7A7367] w-28 shrink-0">จังหวัด</span>
                                <span class="text-[#2D2A26] font-semibold">: <span id="sum_province">--</span></span>
                            </div>
                            <div class="flex justify-between sm:justify-start gap-4">
                                <span class="text-[#7A7367] w-28 shrink-0">สถานะผู้สมัคร</span>
                                <span class="text-[#2D2A26] font-semibold">: <span id="sum_status">ประชาชนทั่วไป</span></span>
                            </div>
                            <div class="flex justify-between sm:justify-start gap-4">
                                <span class="text-[#7A7367] w-28 shrink-0">ประเภทอาหาร</span>
                                <span class="text-[#2D2A26] font-semibold">: <span id="sum_food">อาหารทั่วไป</span></span>
                            </div>
                            <div class="flex justify-between sm:justify-start gap-4">
                                <span class="text-[#7A7367] w-28 shrink-0">เบอร์โทรศัพท์</span>
                                <span class="text-[#2D2A26] font-semibold font-mono">: <span id="sum_phone">--</span></span>
                            </div>
                            <div class="flex justify-between sm:justify-start gap-4">
                                <span class="text-[#7A7367] w-28 shrink-0">การเดินทาง</span>
                                <span class="text-[#2D2A26] font-semibold">: <span id="sum_travel">รถยนต์ส่วนตัว</span></span>
                            </div>
                            <div class="flex justify-between sm:justify-start gap-4">
                                <span class="text-[#7A7367] w-28 shrink-0">อีเมล</span>
                                <span class="text-[#2D2A26] font-semibold">: <span id="sum_email">-</span></span>
                            </div>
                            <div class="flex justify-between sm:justify-start gap-4">
                                <span class="text-[#7A7367] w-28 shrink-0">ความต้องการพิเศษ</span>
                                <span class="text-[#2D2A26] font-semibold">: <span id="sum_special">-</span></span>
                            </div>
                        </div>
                    </div>

                    <!-- 3. กฎ ระเบียบ และข้อปฏิบัติในการเข้าร่วม (8 Items in 2 Columns) -->
                    <div class="space-y-3">
                        <div class="flex items-center gap-2">
                            <span class="w-6 h-6 rounded-full bg-[#1F6B30] text-white flex items-center justify-center text-xs font-bold font-mono">1</span>
                            <h3 class="font-heading font-bold text-sm sm:text-base text-[#2D2A26]">กฎ ระเบียบ และข้อปฏิบัติในการเข้าร่วม</h3>
                        </div>

                        <div class="p-5 border border-[#E8E3D7] rounded-2xl bg-white grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-3 text-xs text-[#2D2A26]">
                            <!-- Col 1 -->
                            <div class="flex items-start gap-2.5">
                                <span class="w-5 h-5 rounded-full bg-[#E8F3EA] text-[#2C7338] flex items-center justify-center text-[10px] font-bold font-mono shrink-0 mt-0.5">1</span>
                                <span class="leading-relaxed">ผู้เข้าร่วมต้องลงทะเบียนและรายงานตัวตามวันและเวลาที่โครงการกำหนด</span>
                            </div>
                            <div class="flex items-start gap-2.5">
                                <span class="w-5 h-5 rounded-full bg-[#E8F3EA] text-[#2C7338] flex items-center justify-center text-[10px] font-bold font-mono shrink-0 mt-0.5">5</span>
                                <span class="leading-relaxed">งดใช้โทรศัพท์มือถือหรืออุปกรณ์สื่อสารระหว่างการปฏิบัติธรรม เว้นแต่ได้รับอนุญาต</span>
                            </div>
                            <div class="flex items-start gap-2.5">
                                <span class="w-5 h-5 rounded-full bg-[#E8F3EA] text-[#2C7338] flex items-center justify-center text-[10px] font-bold font-mono shrink-0 mt-0.5">2</span>
                                <span class="leading-relaxed">แต่งกายสุภาพเรียบร้อย เหมาะสมกับการปฏิบัติธรรม</span>
                            </div>
                            <div class="flex items-start gap-2.5">
                                <span class="w-5 h-5 rounded-full bg-[#E8F3EA] text-[#2C7338] flex items-center justify-center text-[10px] font-bold font-mono shrink-0 mt-0.5">6</span>
                                <span class="leading-relaxed">รักษาความสงบ สำรวมกาย วาจา ใจ และเคารพสิทธิของผู้เข้าร่วมท่านอื่น</span>
                            </div>
                            <div class="flex items-start gap-2.5">
                                <span class="w-5 h-5 rounded-full bg-[#E8F3EA] text-[#2C7338] flex items-center justify-center text-[10px] font-bold font-mono shrink-0 mt-0.5">3</span>
                                <span class="leading-relaxed">งดนำสุรา บุหรี่ สิ่งเสพติด และสิ่งอบายมุขทุกชนิดเข้าพื้นที่</span>
                            </div>
                            <div class="flex items-start gap-2.5">
                                <span class="w-5 h-5 rounded-full bg-[#E8F3EA] text-[#2C7338] flex items-center justify-center text-[10px] font-bold font-mono shrink-0 mt-0.5">7</span>
                                <span class="leading-relaxed">หากมีโรคประจำตัวหรือข้อจำกัดด้านสุขภาพ กรุณาแจ้งเจ้าหน้าที่ล่วงหน้า</span>
                            </div>
                            <div class="flex items-start gap-2.5">
                                <span class="w-5 h-5 rounded-full bg-[#E8F3EA] text-[#2C7338] flex items-center justify-center text-[10px] font-bold font-mono shrink-0 mt-0.5">4</span>
                                <span class="leading-relaxed">ปฏิบัติตามตารางกิจกรรม คำแนะนำของวิปัสสนาจารย์ และเจ้าหน้าที่อย่างเคร่งครัด</span>
                            </div>
                            <div class="flex items-start gap-2.5">
                                <span class="w-5 h-5 rounded-full bg-[#E8F3EA] text-[#2C7338] flex items-center justify-center text-[10px] font-bold font-mono shrink-0 mt-0.5">8</span>
                                <span class="leading-relaxed">หากฝ่าฝืนกฎระเบียบ สถาบันขอสงวนสิทธิ์ในการพิจารณาให้ออกจากโครงการ</span>
                            </div>
                        </div>
                    </div>

                    <!-- 4. ข้อควรทราบเพิ่มเติม (4 Items with Megaphone Icon) -->
                    <div class="space-y-3">
                        <div class="flex items-center gap-2">
                            <span class="w-6 h-6 rounded-full bg-[#1F6B30] text-white flex items-center justify-center text-xs font-bold font-mono">2</span>
                            <h3 class="font-heading font-bold text-sm sm:text-base text-[#2D2A26]">ข้อควรทราบเพิ่มเติม</h3>
                        </div>

                        <div class="p-4 sm:p-5 border border-[#F4E3C8] rounded-2xl bg-[#FFFDF9] flex flex-col sm:flex-row items-start sm:items-center gap-4">
                            <!-- Megaphone Icon -->
                            <div class="w-12 h-12 rounded-2xl bg-[#FFF3DD] text-[#D88D2B] flex items-center justify-center shrink-0">
                                <i data-lucide="megaphone" class="w-6 h-6"></i>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-2 text-xs text-[#2D2A26] flex-grow">
                                <div class="flex items-start gap-2">
                                    <span class="w-4 h-4 rounded-full bg-[#F3ECE0] text-[#7A7367] flex items-center justify-center text-[9px] font-mono shrink-0 mt-0.5">1</span>
                                    <span>ผู้สมัครควรนำบัตรประชาชนและของใช้ส่วนตัวที่จำเป็นมาด้วย</span>
                                </div>
                                <div class="flex items-start gap-2">
                                    <span class="w-4 h-4 rounded-full bg-[#F3ECE0] text-[#7A7367] flex items-center justify-center text-[9px] font-mono shrink-0 mt-0.5">3</span>
                                    <span>ข้อมูลที่ท่านกรอกจะใช้เพื่อการบริหารจัดการโครงการเท่านั้น</span>
                                </div>
                                <div class="flex items-start gap-2">
                                    <span class="w-4 h-4 rounded-full bg-[#F3ECE0] text-[#7A7367] flex items-center justify-center text-[9px] font-mono shrink-0 mt-0.5">2</span>
                                    <span>ที่พักแยกชาย–หญิง และจัดตามความเหมาะสมของโครงการ</span>
                                </div>
                                <div class="flex items-start gap-2">
                                    <span class="w-4 h-4 rounded-full bg-[#F3ECE0] text-[#7A7367] flex items-center justify-center text-[9px] font-mono shrink-0 mt-0.5">4</span>
                                    <span>เมื่อกดยืนยันการสมัครแล้ว ระบบจะบันทึกข้อมูลทันที</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 5. Checkboxes (Rules & Accuracy Acknowledgement) -->
                    <div class="space-y-2.5 pt-2">
                        <label class="flex items-start gap-2.5 cursor-pointer">
                            <input type="checkbox" id="chk_agree_rules" required class="w-4 h-4 text-[#2C7338] border-[#D5CEBC] rounded focus:ring-[#2C7338] mt-0.5">
                            <span class="text-xs text-[#2D2A26] leading-relaxed">
                                ข้าพเจ้าได้อ่านและยอมรับกฎ ระเบียบ และเงื่อนไขการเข้าร่วมโครงการแล้ว <span class="text-red-500">*</span>
                            </span>
                        </label>
                        <label class="flex items-start gap-2.5 cursor-pointer">
                            <input type="checkbox" id="chk_certify_info" required class="w-4 h-4 text-[#2C7338] border-[#D5CEBC] rounded focus:ring-[#2C7338] mt-0.5">
                            <span class="text-xs text-[#2D2A26] leading-relaxed">
                                ข้าพเจ้าขอยืนยันว่าข้อมูลที่กรอกไว้เป็นความจริงและถูกต้อง <span class="text-red-500">*</span>
                            </span>
                        </label>
                    </div>

                    <!-- Step 3 Footer Buttons & Notice -->
                    <div class="pt-6 border-t border-[#EAE5D9] flex flex-col sm:flex-row items-center justify-between gap-4">
                        <div class="flex items-center gap-1.5 text-xs text-[#C86D51] order-2 sm:order-1">
                            <i data-lucide="alert-circle" class="w-4 h-4 shrink-0"></i>
                            <span>เมื่อกดยืนยันแล้ว จะไม่สามารถแก้ไขข้อมูลได้ทันที</span>
                        </div>

                        <div class="flex items-center gap-3 w-full sm:w-auto justify-end order-1 sm:order-2">
                            <button type="button" onclick="goToStep(2)" class="px-5 py-2.5 rounded-xl border border-[#D5CEBC] text-[#4A3B32] hover:bg-[#FAF8F2] text-xs sm:text-sm font-semibold flex items-center gap-1.5 transition">
                                <i data-lucide="arrow-left" class="w-4 h-4"></i>
                                <span>ย้อนกลับ</span>
                            </button>
                            <button type="submit" id="btn_final_submit" class="bg-[#2C7338] hover:bg-[#235D2E] text-white font-semibold px-7 py-2.5 rounded-xl text-xs sm:text-sm shadow-xs transition flex items-center gap-2">
                                <i data-lucide="check" class="w-4 h-4"></i>
                                <span>ยืนยันการสมัคร</span>
                            </button>
                        </div>
                    </div>

                </div>

            </form>

        @endif

    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-[#EAE5D9] py-5 text-center text-xs text-[#7B8D65]">
        มหาวิทยาลัยมหาจุฬาลงกรณราชวิทยาลัย &bull; ระบบสารสนเทศการปฏิบัติวิปัสสนากรรมฐาน (VPSMCU)
    </footer>

    <!-- Scripts Engine -->
    <script>
        let currentStep = 1;

        // Step Configs for Header Banner
        const stepBannerData = {
            1: {
                title: 'สมัครปฏิบัติวิปัสสนากรรมฐาน',
                subtitle: 'เลือกโครงการที่ต้องการสมัคร',
                desc: 'กรุณาเลือกโครงการที่ท่านสนใจและอยู่ในช่วงเปิดรับสมัคร<br class="hidden sm:inline">จากนั้นคลิก "ถัดไป" เพื่อกรอกข้อมูลผู้สมัครในขั้นตอนต่อไป'
            },
            2: {
                title: 'กรอกข้อมูลผู้สมัคร',
                subtitle: 'กรุณากรอกข้อมูลให้ครบถ้วนและถูกต้อง',
                desc: 'ข้อมูลของท่านจะถูกใช้สำหรับการลงทะเบียนเข้าร่วมโครงการ<br class="hidden sm:inline">กรุณาตรวจสอบความถูกต้องก่อนยืนยันการลงทะเบียน'
            },
            3: {
                title: 'ตรวจสอบกฎ ระเบียบก่อนสมัคร',
                subtitle: 'กรุณาอ่านและยอมรับข้อกำหนดการเข้าร่วมโครงการก่อนยืนยันการสมัคร',
                desc: 'โปรดตรวจสอบรายละเอียดโครงการ ข้อมูลผู้สมัคร และกฎระเบียบการเข้าร่วม<br class="hidden sm:inline">ให้ครบถ้วน เพื่อให้การสมัครเป็นไปอย่างถูกต้อง'
            }
        };

        function goToStep(step) {
            if (step === 3 && currentStep === 1) {
                nextToStep(2);
                return;
            }
            if (step === 3) {
                if (!validateStep2()) {
                    return;
                }
                syncSummaryData();
            }

            // Update Banner
            document.getElementById('banner_title').textContent = stepBannerData[step].title;
            document.getElementById('banner_subtitle').textContent = stepBannerData[step].subtitle;
            document.getElementById('banner_desc').innerHTML = stepBannerData[step].desc;

            // Update Stepper Visuals
            for (let s = 1; s <= 3; s++) {
                const circle = document.getElementById('step-circle-' + s);
                const text = document.getElementById('step-text-' + s);
                const num = document.getElementById('step-num-' + s);
                const icon = document.getElementById('step-icon-' + s);
                const content = document.getElementById('step-content-' + s);

                if (s < step) {
                    // Completed Step
                    circle.className = 'w-10 h-10 rounded-full bg-[#1F6B30] text-white flex items-center justify-center font-bold text-sm shadow-xs transition duration-200';
                    text.className = 'text-xs sm:text-sm font-heading font-medium text-[#2D2A26] mt-2 text-center whitespace-nowrap';
                    icon.classList.remove('hidden');
                    num.classList.add('hidden');
                } else if (s === step) {
                    // Current Active Step
                    if (s === 3) {
                        circle.className = 'w-10 h-10 rounded-full bg-[#1F6B30] text-white flex items-center justify-center font-bold text-sm shadow-xs transition duration-200';
                        icon.classList.add('hidden');
                        num.classList.remove('hidden');
                    } else {
                        circle.className = 'w-10 h-10 rounded-full bg-[#1F6B30] text-white flex items-center justify-center font-bold text-sm shadow-xs transition duration-200';
                        icon.classList.add('hidden');
                        num.classList.remove('hidden');
                    }
                    text.className = 'text-xs sm:text-sm font-heading font-bold text-[#2D2A26] mt-2 text-center whitespace-nowrap';
                } else {
                    // Future Inactive Step
                    circle.className = 'w-10 h-10 rounded-full bg-white border-2 border-[#D5CEBC] text-[#8C8275] flex items-center justify-center font-bold text-sm shadow-xs transition duration-200';
                    text.className = 'text-xs sm:text-sm font-heading font-medium text-[#7A7367] mt-2 text-center whitespace-nowrap';
                    icon.classList.add('hidden');
                    num.classList.remove('hidden');
                }

                // Show/Hide Content
                if (s === step) {
                    content.classList.remove('hidden');
                } else {
                    content.classList.add('hidden');
                }
            }

            // Update Connector Lines
            const conn1 = document.getElementById('step-connector-1');
            const conn2 = document.getElementById('step-connector-2');
            if (step >= 2) {
                conn1.classList.add('active');
            } else {
                conn1.classList.remove('active');
            }
            if (step >= 3) {
                conn2.classList.add('active');
            } else {
                conn2.classList.remove('active');
            }

            currentStep = step;
            window.scrollTo({ top: 120, behavior: 'smooth' });
            lucide.createIcons();
        }

        function nextToStep(step) {
            if (step === 2) {
                const selected = document.querySelector('input[name="event_id"]:checked');
                if (!selected) {
                    alert('กรุณาเลือกโครงการที่ต้องการสมัคร');
                    return;
                }
                syncSelectedEventCard(selected);
            }
            goToStep(step);
        }

        function onEventRadioChange(radio) {
            syncSelectedEventCard(radio);
        }

        function syncSelectedEventCard(radio) {
            const card = radio.closest('.event-card');
            if (!card) return;

            const title = card.querySelector('.event-title') ? card.querySelector('.event-title').textContent.trim() : '';
            const loc = card.querySelector('.event-location') ? card.querySelector('.event-location').textContent.trim() : '';
            const dates = card.querySelector('.event-dates') ? card.querySelector('.event-dates').textContent.trim() : '';
            const img = card.querySelector('img') ? card.querySelector('img').src : '';

            // Step 2 Preview
            const sImg = document.getElementById('selected_ev_img');
            const sTitle = document.getElementById('selected_ev_title');
            const sDates = document.getElementById('selected_ev_dates');
            const sLoc = document.getElementById('selected_ev_loc');
            if (sImg) sImg.src = img;
            if (sTitle) sTitle.textContent = title;
            if (sDates) sDates.textContent = dates;
            if (sLoc) sLoc.textContent = loc;

            // Step 3 Review
            const rImg = document.getElementById('review_ev_img');
            const rTitle = document.getElementById('review_ev_title');
            const rDates = document.getElementById('review_ev_dates');
            const rLoc = document.getElementById('review_ev_loc');
            if (rImg) rImg.src = img;
            if (rTitle) rTitle.textContent = title;
            if (rDates) rDates.textContent = dates;
            if (rLoc) rLoc.textContent = loc;
        }

        function validateStep2() {
            const citizenId = document.getElementById('inp_citizen_id');
            const firstName = document.getElementById('inp_first_name');
            const lastName = document.getElementById('inp_last_name');
            const phone = document.getElementById('inp_phone');
            const prov = document.getElementById('province_select');
            const dist = document.getElementById('district_select');
            const subdist = document.getElementById('subdistrict_select');

            if (!citizenId.value.trim()) {
                alert('กรุณากรอกเลขบัตรประชาชน หรือ Passport');
                citizenId.focus();
                return false;
            }
            if (!firstName.value.trim()) {
                alert('กรุณากรอกชื่อจริง');
                firstName.focus();
                return false;
            }
            if (!lastName.value.trim()) {
                alert('กรุณากรอกนามสกุล');
                lastName.focus();
                return false;
            }
            if (!phone.value.trim()) {
                alert('กรุณากรอกเบอร์โทรศัพท์ติดต่อ');
                phone.focus();
                return false;
            }
            if (!prov.value) {
                alert('กรุณาเลือกจังหวัด');
                prov.focus();
                return false;
            }
            if (!dist.value) {
                alert('กรุณาเลือกอำเภอ');
                dist.focus();
                return false;
            }
            if (!subdist.value) {
                alert('กรุณาเลือกตำบล');
                subdist.focus();
                return false;
            }

            const appType = document.querySelector('input[name="applicant_type"]:checked').value;
            if (appType === 'STUDENT') {
                const stdId = document.getElementById('txt_studentid');
                const deg = document.getElementById('select_degree_level');
                const fac = document.getElementById('txt_faculty');
                const prog = document.getElementById('txt_program_name');

                if (!stdId.value.trim() || !deg.value || !fac.value.trim() || !prog.value.trim()) {
                    alert('กรุณากรอกข้อมูลการศึกษาใน มจร ให้ครบถ้วน');
                    return false;
                }
            }

            return true;
        }

        function validateAndGoToStep3() {
            if (validateStep2()) {
                syncSummaryData();
                goToStep(3);
            }
        }

        function syncSummaryData() {
            const prefix = document.getElementById('prefix_select').value;
            const firstName = document.getElementById('inp_first_name').value.trim();
            const lastName = document.getElementById('inp_last_name').value.trim();
            const buddhistName = document.getElementById('inp_buddhist_name').value.trim();
            const bStr = buddhistName ? ' (' + buddhistName + ')' : '';
            document.getElementById('sum_name').textContent = prefix + ' ' + firstName + ' ' + lastName + bStr;

            document.getElementById('sum_province').textContent = document.getElementById('province_select').value || '-';
            
            const appType = document.querySelector('input[name="applicant_type"]:checked').value;
            document.getElementById('sum_status').textContent = appType === 'STUDENT' ? 'นิสิต มจร' : 'ประชาชนทั่วไป';

            const foodSel = document.getElementById('inp_food_type');
            document.getElementById('sum_food').textContent = foodSel.options[foodSel.selectedIndex].text;

            document.getElementById('sum_phone').textContent = document.getElementById('inp_phone').value.trim() || '-';
            
            const vehicle = document.getElementById('inp_vehicle_info').value;
            document.getElementById('sum_travel').textContent = vehicle.includes('รถยนต์') ? 'รถยนต์ส่วนตัว' : (vehicle.includes('รถตู้') ? 'รถตู้สถาบัน' : vehicle);

            document.getElementById('sum_email').textContent = document.getElementById('inp_email').value.trim() || '-';
            document.getElementById('sum_special').textContent = document.getElementById('inp_special_needs').value.trim() || 'ไม่มี';

            const selected = document.querySelector('input[name="event_id"]:checked');
            if (selected) {
                syncSelectedEventCard(selected);
            }
        }

        function toggleStudentField(val) {
            const el = document.getElementById('studentIdContainer');
            const studentIdInput = document.getElementById('txt_studentid');
            const degreeSelect = document.getElementById('select_degree_level');
            const facultyInput = document.getElementById('txt_faculty');
            const programInput = document.getElementById('txt_program_name');

            if (val === 'STUDENT') {
                el.classList.remove('hidden');
                if (studentIdInput) studentIdInput.required = true;
                if (degreeSelect) degreeSelect.required = true;
                if (facultyInput) facultyInput.required = true;
                if (programInput) programInput.required = true;
            } else {
                el.classList.add('hidden');
                if (studentIdInput) { studentIdInput.value = ''; studentIdInput.required = false; }
                if (degreeSelect) { degreeSelect.value = ''; degreeSelect.required = false; }
                if (facultyInput) { facultyInput.value = ''; facultyInput.required = false; }
                if (programInput) { programInput.value = ''; programInput.required = false; }
            }
        }

        // Thailand Address Cascading Engine
        let thaiProvinces = [];
        let thaiDistricts = [];
        let thaiSubdistricts = [];

        document.addEventListener('DOMContentLoaded', async () => {
            // Initial sync for first radio selection
            const firstRadio = document.querySelector('input[name="event_id"]:checked');
            if (firstRadio) {
                syncSelectedEventCard(firstRadio);
            }

            try {
                const resProv = await fetch('/assets/data/provinces.json');
                thaiProvinces = await resProv.json();
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

                fetch('/assets/data/districts.json')
                    .then(r => r.json())
                    .then(data => { thaiDistricts = data; });

                fetch('/assets/data/subdistricts.json')
                    .then(r => r.json())
                    .then(data => { thaiSubdistricts = data; });

            } catch (err) {
                console.error('Failed to load address data', err);
            }
        });

        function onProvinceChange(provinceName) {
            const distSelect = document.getElementById('district_select');
            const subSelect = document.getElementById('subdistrict_select');
            const postalInput = document.getElementById('postal_code_input');

            distSelect.innerHTML = '<option value="">-- กำลังโหลดอำเภอ... --</option>';
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

            subSelect.innerHTML = '<option value="">-- กำลังโหลดตำบล... --</option>';
            subSelect.disabled = true;
            postalInput.value = '';

            if (!districtName) {
                subSelect.innerHTML = '<option value="">-- กรุณาเลือกอำเภอก่อน --</option>';
                return;
            }

            const distOption = document.querySelector(`#district_select option[value="${districtName}"]`);
            const districtCode = distOption ? parseInt(distOption.dataset.districtCode) : null;

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
    <script>
        lucide.createIcons();
    </script>

</body>
</html>
