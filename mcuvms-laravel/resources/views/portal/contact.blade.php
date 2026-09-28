@php
    use App\Models\SiteSetting;
    $contactSettings = SiteSetting::getByGroup('contact');
    $currentRoute = Route::currentRouteName();
@endphp
<!DOCTYPE html>
<html lang="th" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ติดต่อสอบถาม | MCUVMS ระบบสารสนเทศการปฏิบัติวิปัสสนากรรมฐาน มจร</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@300;400;500;600;700&family=Prompt:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
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
                            forestDark: '#243325',
                            olive: '#5A6B47',
                            oliveLight: '#7B8D65',
                            bark: '#4A3B32',
                            barkDark: '#2D2A26'
                        }
                    }
                }
            }
        }
    </script>
    <style>
        body { 
            font-family: 'Sarabun', sans-serif; 
            background-color: #FAF8F2; 
            color: #2D2A26;
        }
        h1, h2, h3, h4, .font-heading { font-family: 'Prompt', sans-serif; }
        .organic-card {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(16px);
            border: 1px solid #EAE5D9;
            box-shadow: 0 10px 30px -10px rgba(74, 59, 50, 0.05);
        }
    </style>
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/mcu-logo.png') }}">
    <link rel="shortcut icon" href="{{ asset('images/mcu-logo.png') }}">
</head>
<body class="antialiased min-h-screen flex flex-col justify-between selection:bg-[#5A6B47] selection:text-white">

    <!-- Top Announcement Bar -->
    <div class="bg-[#2C3E2D] text-[#EAE5D9] text-xs py-2 px-4 border-b border-[#3D523E]">
        <div class="max-w-7xl mx-auto flex flex-col sm:flex-row justify-between items-center gap-1 font-medium">
            <div class="flex items-center space-x-2">
                <span class="inline-block w-2 h-2 rounded-full bg-[#7B8D65] animate-pulse"></span>
                <span>มหาจุฬาลงกรณราชวิทยาลัย — ระบบสารสนเทศการปฏิบัติวิปัสสนากรรมฐาน (MCUVMS)</span>
            </div>
            <div class="flex items-center space-x-4 text-[#D8D2C2] text-[11px]">
                <span class="flex items-center gap-1.5"><i data-lucide="shield-check" class="w-3.5 h-3.5 text-[#A3B88C]"></i> สถาบันวิปัสสนาธุระ</span>
            </div>
        </div>
    </div>

    <!-- Main Navigation Header -->
    <header class="sticky top-0 z-50 bg-[#FAF8F2]/90 backdrop-blur-xl border-b border-[#E3DEC9] shadow-sm transition">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                
                <!-- Logo & Brand -->
                <div class="flex items-center space-x-3.5">
                    <a href="{{ route('home') }}" class="shrink-0 flex items-center">
                        <img src="{{ asset('images/mcu-logo.png') }}" alt="MCU Logo" class="w-12 h-12 object-contain drop-shadow-sm hover:scale-105 transition">
                    </a>
                    <div>
                        <a href="{{ route('home') }}" class="font-heading font-extrabold text-xl text-[#2C3E2D] tracking-tight leading-tight flex items-center gap-2">
                            MCUVMS
                            <span class="text-[10px] uppercase font-mono px-2 py-0.5 rounded-full bg-[#EAE5D9] text-[#4A3B32] border border-[#D5CEBC]">มจร</span>
                        </a>
                        <p class="text-xs text-[#6B6357] font-medium">ระบบสารสนเทศการปฏิบัติวิปัสสนากรรมฐาน</p>
                    </div>
                </div>

                <!-- Nav Links: ปฏิทินกำหนดการ, ระดับปริญญาตรี, ระดับบัณฑิตศึกษา, ประชาชนทั่วไป, ติดต่อสอบถาม -->
                <nav class="hidden lg:flex items-center space-x-7 text-sm font-medium text-[#4A3B32]">
                    <a href="{{ route('home') }}#calendar" class="hover:text-[#C86D51] transition flex items-center gap-1.5">
                        <i data-lucide="calendar" class="w-4 h-4 text-[#5A6B47]"></i>
                        <span>ปฏิทินกำหนดการ</span>
                    </a>
                    <a href="{{ route('ug.register') }}" class="hover:text-[#C86D51] transition flex items-center gap-1.5">
                        <i data-lucide="graduation-cap" class="w-4 h-4 text-[#5A6B47]"></i>
                        <span>ระดับปริญญาตรี</span>
                    </a>
                    <a href="{{ route('grad.progress') }}" class="hover:text-[#C86D51] transition flex items-center gap-1.5">
                        <i data-lucide="scroll" class="w-4 h-4 text-[#5A6B47]"></i>
                        <span>ระดับบัณฑิตศึกษา</span>
                    </a>
                    <a href="{{ route('public.register') }}" class="hover:text-[#C86D51] transition flex items-center gap-1.5">
                        <i data-lucide="users" class="w-4 h-4 text-[#5A6B47]"></i>
                        <span>ประชาชนทั่วไป</span>
                    </a>
                    <a href="{{ route('contact') }}" class="text-[#C86D51] font-semibold transition flex items-center gap-1.5">
                        <i data-lucide="phone-call" class="w-4 h-4 text-[#C86D51]"></i>
                        <span>ติดต่อสอบถาม</span>
                    </a>
                </nav>

                <!-- Auth / Admin Button -->
                <div class="flex items-center space-x-3">
                    @if (Session::has('admin_user'))
                        <a href="{{ route('admin.dashboard') }}" class="bg-[#2C3E2D] hover:bg-[#3D523E] text-[#F7F4EA] px-4 py-2.5 rounded-xl text-xs font-semibold flex items-center gap-2 shadow-sm transition">
                            <i data-lucide="layout-dashboard" class="w-4 h-4 text-[#A3B88C]"></i>
                            <span>แผงควบคุมแอดมิน</span>
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="text-[#2C3E2D] hover:text-[#5A6B47] px-3.5 py-2 rounded-xl text-xs font-semibold border border-[#D5CEBC] bg-white hover:bg-[#FAF8F2] flex items-center gap-1.5 shadow-2xs transition">
                            <i data-lucide="lock" class="w-3.5 h-3.5 text-[#5A6B47]"></i>
                            <span>เข้าสู่ระบบ</span>
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full flex-grow">
        
        <!-- Header Banner (Organic Earth Deep Forest) -->
        <div class="bg-gradient-to-r from-[#2C3E2D] via-[#3A4F3C] to-[#5A6B47] rounded-3xl p-6 md:p-10 text-white shadow-lg shadow-[#2C3E2D]/15 mb-8 border border-[#2C3E2D]/20">
            <div class="inline-flex items-center gap-1.5 px-3 py-1 bg-white/15 backdrop-blur-sm rounded-full text-xs font-semibold uppercase tracking-wider mb-3 border border-white/20 text-[#FAF8F2]">
                <i data-lucide="headphones" class="w-3.5 h-3.5 text-[#EAE5D9]"></i>
                <span>Helpdesk & Contact Center</span>
            </div>
            <h1 class="text-2xl md:text-4xl font-heading font-bold mb-3 text-[#FAF8F2]">ติดต่อสอบถาม & บริการสารสนเทศ</h1>
            <p class="text-[#EAE5D9] text-sm md:text-base max-w-3xl leading-relaxed">
                มีข้อสงสัยเกี่ยวกับการปฏิบัติธรรม การลงทะเบียนนิสิต การสะสมหน่วยกิตบัณฑิตศึกษา หรือคอร์สประชาชนทั่วไป สามารถติดต่อสถาบันวิปัสสนาธุระ มจร ได้ทุกช่องทาง
            </p>
        </div>

        @if (session('success'))
            <div class="bg-[#5A6B47]/10 border-l-4 border-[#5A6B47] p-5 rounded-r-2xl mb-8 shadow-sm">
                <div class="flex items-start">
                    <i data-lucide="check-circle" class="w-6 h-6 text-[#5A6B47] mr-3 shrink-0 mt-0.5"></i>
                    <div>
                        <h4 class="text-base font-bold text-[#2C3E2D] font-heading">{{ session('success') }}</h4>
                        @if (session('ticket_no'))
                            <p class="text-xs text-[#4A3B32] mt-1">
                                เลขที่อ้างอิงการติดต่อ (Ticket ID): <strong class="font-mono text-[#C86D51] font-bold text-sm">{{ session('ticket_no') }}</strong> (กรุณาบันทึกไว้เพื่อใช้อ้างอิงการติดตามเรื่อง)
                            </p>
                        @endif
                    </div>
                </div>
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-r-2xl mb-8 shadow-sm">
                <div class="flex items-center mb-1">
                    <i data-lucide="alert-circle" class="w-5 h-5 text-red-500 mr-2 shrink-0"></i>
                    <h5 class="text-sm font-bold text-red-800">กรุณาตรวจสอบข้อมูลที่กรอก</h5>
                </div>
                <ul class="list-disc list-inside text-xs text-red-700 space-y-0.5 ml-2">
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 mb-12">
            
            <!-- Left Column: Contact Information Cards (5 cols) -->
            <div class="lg:col-span-5 space-y-6">
                
                <!-- Main Office Info -->
                <div class="organic-card rounded-3xl p-6 md:p-7 border border-[#EAE5D9]">
                    <div class="flex items-center gap-3 mb-5 pb-4 border-b border-[#EAE5D9]">
                        <div class="w-12 h-12 rounded-2xl bg-[#5A6B47]/15 text-[#5A6B47] flex items-center justify-center shrink-0 border border-[#5A6B47]/20">
                            <i data-lucide="building" class="w-6 h-6"></i>
                        </div>
                        <div>
                            <span class="text-[11px] font-mono uppercase text-[#7B8D65] font-semibold">สถานที่ตั้งส่วนกลาง</span>
                            <h3 class="font-heading font-bold text-base text-[#2C3E2D] leading-tight">
                                {{ $contactSettings['contact_org_name'] ?? 'สถาบันวิปัสสนาธุระ มจร' }}
                            </h3>
                        </div>
                    </div>

                    <div class="space-y-4 text-xs text-[#4A3B32]">
                        <div class="flex items-start gap-3">
                            <i data-lucide="map-pin" class="w-4 h-4 text-[#C86D51] shrink-0 mt-0.5"></i>
                            <p class="leading-relaxed">
                                {{ $contactSettings['contact_address'] ?? 'อาคาร 75 ปี พระพรหมมังคลาจารย์ มจร วังน้อย อยุธยา' }}
                            </p>
                        </div>

                        <div class="flex items-start gap-3">
                            <i data-lucide="clock" class="w-4 h-4 text-[#5A6B47] shrink-0 mt-0.5"></i>
                            <p class="leading-relaxed">
                                <strong class="text-[#2C3E2D]">เวลาทำการ:</strong> {{ $contactSettings['contact_office_hours'] ?? 'วันจันทร์ - ศุกร์ 08.30 - 16.30 น.' }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Fast Contact Methods (Phone, Hotline, LINE, Email) -->
                <div class="organic-card rounded-3xl p-6 md:p-7 border border-[#EAE5D9]">
                    <h3 class="font-heading font-bold text-base text-[#2C3E2D] mb-4 flex items-center gap-2">
                        <i data-lucide="phone-forwarded" class="w-4 h-4 text-[#5A6B47]"></i>
                        <span>ช่องทางติดต่อด่วน</span>
                    </h3>

                    <div class="space-y-3.5">
                        
                        <!-- Phone -->
                        <div class="flex items-center justify-between p-3 rounded-2xl bg-[#FAF8F2] border border-[#EAE5D9]">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-xl bg-[#5A6B47]/15 text-[#5A6B47] flex items-center justify-center shrink-0">
                                    <i data-lucide="phone" class="w-4 h-4"></i>
                                </div>
                                <div>
                                    <div class="text-[10px] text-[#7B8D65]">เบอร์โทรศัพท์กลาง</div>
                                    <div class="font-semibold text-xs text-[#2C3E2D] font-mono">{{ $contactSettings['contact_phone'] ?? '035-248-000' }}</div>
                                </div>
                            </div>
                            <a href="tel:{{ preg_replace('/[^0-9]/', '', $contactSettings['contact_phone'] ?? '') }}" class="px-2.5 py-1 bg-white hover:bg-[#5A6B47] hover:text-white border border-[#D5CEBC] rounded-lg text-[11px] font-semibold text-[#4A3B32] transition">
                                โทร
                            </a>
                        </div>

                        <!-- Hotline -->
                        <div class="flex items-center justify-between p-3 rounded-2xl bg-[#FAF8F2] border border-[#EAE5D9]">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-xl bg-[#C86D51]/15 text-[#C86D51] flex items-center justify-center shrink-0">
                                    <i data-lucide="smartphone" class="w-4 h-4"></i>
                                </div>
                                <div>
                                    <div class="text-[10px] text-[#C86D51]">สายด่วนวิปัสสนาธุระ</div>
                                    <div class="font-semibold text-xs text-[#2C3E2D] font-mono">{{ $contactSettings['contact_hotline'] ?? '084-456-4554' }}</div>
                                </div>
                            </div>
                            <a href="tel:{{ preg_replace('/[^0-9]/', '', $contactSettings['contact_hotline'] ?? '') }}" class="px-2.5 py-1 bg-white hover:bg-[#C86D51] hover:text-white border border-[#D5CEBC] rounded-lg text-[11px] font-semibold text-[#4A3B32] transition">
                                โทร
                            </a>
                        </div>

                        <!-- Email -->
                        <div class="flex items-center justify-between p-3 rounded-2xl bg-[#FAF8F2] border border-[#EAE5D9]">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-xl bg-[#2C3E2D]/15 text-[#2C3E2D] flex items-center justify-center shrink-0">
                                    <i data-lucide="mail" class="w-4 h-4"></i>
                                </div>
                                <div>
                                    <div class="text-[10px] text-[#7B8D65]">อีเมลประสานงาน</div>
                                    <div class="font-semibold text-xs text-[#2C3E2D] font-mono">{{ $contactSettings['contact_email'] ?? 'vipassana@mcu.ac.th' }}</div>
                                </div>
                            </div>
                            <a href="mailto:{{ $contactSettings['contact_email'] ?? 'vipassana@mcu.ac.th' }}" class="px-2.5 py-1 bg-white hover:bg-[#2C3E2D] hover:text-white border border-[#D5CEBC] rounded-lg text-[11px] font-semibold text-[#4A3B32] transition">
                                ส่งอีเมล
                            </a>
                        </div>

                        <!-- LINE & Social -->
                        <div class="grid grid-cols-2 gap-3 pt-1">
                            <a href="https://line.me/ti/p/~{{ ltrim($contactSettings['contact_line_id'] ?? '@mcu.vipassana', '@') }}" target="_blank" class="p-3 rounded-2xl bg-[#06C755]/10 border border-[#06C755]/20 hover:bg-[#06C755]/20 transition flex items-center gap-2.5">
                                <i data-lucide="message-circle" class="w-4 h-4 text-[#06C755]"></i>
                                <div>
                                    <div class="text-[9px] text-[#4A3B32]">LINE ID</div>
                                    <div class="font-bold text-[11px] text-[#2C3E2D] font-mono truncate">{{ $contactSettings['contact_line_id'] ?? '@mcu.vipassana' }}</div>
                                </div>
                            </a>
                            <a href="{{ $contactSettings['contact_facebook'] ?? 'https://facebook.com/vipassanamcu' }}" target="_blank" class="p-3 rounded-2xl bg-[#1877F2]/10 border border-[#1877F2]/20 hover:bg-[#1877F2]/20 transition flex items-center gap-2.5">
                                <i data-lucide="facebook" class="w-4 h-4 text-[#1877F2]"></i>
                                <div>
                                    <div class="text-[9px] text-[#4A3B32]">Facebook</div>
                                    <div class="font-bold text-[11px] text-[#2C3E2D] truncate">เพจวิปัสสนา มจร</div>
                                </div>
                            </a>
                        </div>

                    </div>
                </div>

            </div>

            <!-- Right Column: Interactive Contact Form (7 cols) -->
            <div class="lg:col-span-7">
                <div class="organic-card rounded-3xl p-6 md:p-8 border border-[#EAE5D9]">
                    <div class="flex items-center justify-between pb-4 mb-6 border-b border-[#EAE5D9]">
                        <div>
                            <h2 class="font-heading font-bold text-xl text-[#2C3E2D]">แบบฟอร์มส่งข้อความสอบถามออนไลน์</h2>
                            <p class="text-xs text-[#7B8D65] mt-1">กรอกข้อมูลเพื่อส่งเรื่องถึงเจ้าหน้าที่ผู้รับผิดชอบโดยตรง</p>
                        </div>
                        <span class="p-3 rounded-2xl bg-[#5A6B47]/15 text-[#5A6B47]">
                            <i data-lucide="send" class="w-6 h-6"></i>
                        </span>
                    </div>

                    <form action="{{ route('contact.submit') }}" method="POST" class="space-y-5">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-[#4A3B32] mb-1.5">
                                    ชื่อ-นามสกุล / ฉายา / พระนาม <span class="text-[#C86D51]">*</span>
                                </label>
                                <input type="text" name="sender_name" value="{{ old('sender_name') }}" required placeholder="ระบุชื่อผู้ติดต่อ" class="w-full px-3.5 py-2.5 bg-white border border-[#EAE5D9] rounded-xl text-xs text-[#2D2A26] focus:ring-2 focus:ring-[#5A6B47] focus:border-[#5A6B47]">
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-[#4A3B32] mb-1.5">
                                    เบอร์โทรศัพท์ติดต่อกลับ <span class="text-[#C86D51]">*</span>
                                </label>
                                <input type="tel" name="phone" value="{{ old('phone') }}" required placeholder="เช่น 081-234-5678" class="w-full px-3.5 py-2.5 bg-white border border-[#EAE5D9] rounded-xl text-xs text-[#2D2A26] focus:ring-2 focus:ring-[#5A6B47] focus:border-[#5A6B47]">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-[#4A3B32] mb-1.5">
                                    อีเมลสำหรับรับการตอบกลับ
                                </label>
                                <input type="email" name="email" value="{{ old('email') }}" placeholder="example@mcu.ac.th" class="w-full px-3.5 py-2.5 bg-white border border-[#EAE5D9] rounded-xl text-xs text-[#2D2A26] focus:ring-2 focus:ring-[#5A6B47] focus:border-[#5A6B47]">
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-[#4A3B32] mb-1.5">
                                    หมวดหมู่เรื่องที่ติดต่อ <span class="text-[#C86D51]">*</span>
                                </label>
                                <select name="category" required class="w-full px-3.5 py-2.5 bg-white border border-[#EAE5D9] rounded-xl text-xs text-[#2D2A26] focus:ring-2 focus:ring-[#5A6B47] focus:border-[#5A6B47]">
                                    <option value="ทั่วไป">สอบถามข้อมูลทั่วไป</option>
                                    <option value="ปริญญาตรี">การปฏิบัติธรรมระดับปริญญาตรี (40 วัน)</option>
                                    <option value="บัณฑิตศึกษา">การสะสมวันบัณฑิตศึกษา ป.โท/ป.เอก (30/45 วัน)</option>
                                    <option value="ประชาชนทั่วไป">คอร์สปฏิบัติธรรมสำหรับประชาชนทั่วไป</option>
                                    <option value="วุฒิบัตร">การออกใบรับรอง / ตรวจสอบวุฒิบัตร (QR)</option>
                                    <option value="ปัญหาการใช้งาน">แจ้งปัญหาการใช้งานระบบ MCUVMS</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-[#4A3B32] mb-1.5">
                                หัวข้อเรื่อง <span class="text-[#C86D51]">*</span>
                            </label>
                            <input type="text" name="subject" value="{{ old('subject') }}" required placeholder="ระบุหัวข้อที่ต้องการสอบถามหรือแจ้งเรื่อง" class="w-full px-3.5 py-2.5 bg-white border border-[#EAE5D9] rounded-xl text-xs text-[#2D2A26] focus:ring-2 focus:ring-[#5A6B47] focus:border-[#5A6B47]">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-[#4A3B32] mb-1.5">
                                รายละเอียดข้อความ <span class="text-[#C86D51]">*</span>
                            </label>
                            <textarea name="message" rows="5" required placeholder="พิมพ์ข้อความและรายละเอียดที่ต้องการสอบถามให้ครบถ้วน..." class="w-full px-3.5 py-2.5 bg-white border border-[#EAE5D9] rounded-xl text-xs text-[#2D2A26] focus:ring-2 focus:ring-[#5A6B47] focus:border-[#5A6B47] leading-relaxed">{{ old('message') }}</textarea>
                        </div>

                        <div class="pt-3 border-t border-[#EAE5D9] flex items-center justify-between">
                            <span class="text-[11px] text-[#7B8D65] flex items-center gap-1">
                                <i data-lucide="shield-check" class="w-3.5 h-3.5 text-[#5A6B47]"></i>
                                ข้อมูลของท่านจะถูกส่งถึงเจ้าหน้าที่โดยตรง
                            </span>
                            <button type="submit" class="bg-[#5A6B47] hover:bg-[#2C3E2D] text-white font-medium px-6 py-2.5 rounded-xl text-xs shadow-md transition flex items-center gap-2">
                                <i data-lucide="send" class="w-4 h-4"></i>
                                <span>ส่งข้อความติดต่อสอบถาม</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>

        <!-- Google Maps Embed Section -->
        @if (!empty($contactSettings['contact_map_embed']))
            <div class="organic-card rounded-3xl p-6 md:p-8 border border-[#EAE5D9] mb-12">
                <div class="flex items-center justify-between pb-4 mb-5 border-b border-[#EAE5D9]">
                    <div class="flex items-center gap-2.5">
                        <i data-lucide="map" class="w-5 h-5 text-[#5A6B47]"></i>
                        <h3 class="font-heading font-bold text-lg text-[#2C3E2D]">แผนที่ตั้ง สถาบันวิปัสสนาธุระ มจร วังน้อย อยุธยา</h3>
                    </div>
                    <a href="https://maps.google.com/?q=มหาวิทยาลัยมหาจุฬาลงกรณราชวิทยาลัย+วังน้อย" target="_blank" class="text-xs text-[#5A6B47] hover:text-[#2C3E2D] font-semibold flex items-center gap-1 transition">
                        <span>เปิดใน Google Maps</span>
                        <i data-lucide="external-link" class="w-3.5 h-3.5"></i>
                    </a>
                </div>
                <div class="w-full h-80 sm:h-96 rounded-2xl overflow-hidden border border-[#EAE5D9] shadow-inner">
                    <iframe src="{{ $contactSettings['contact_map_embed'] }}" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
        @endif

    </main>

    <!-- Footer (Organic Earth Forest) -->
    <footer id="contact" class="bg-[#243325] text-[#D5CEBC] text-xs py-12 border-t border-[#1B271C]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-center gap-6 text-center md:text-left">
                <div>
                    <div class="flex items-center justify-center md:justify-start gap-3 mb-2">
                        <img src="{{ asset('images/mcu-logo.png') }}" alt="MCU Logo" class="w-8 h-8 object-contain">
                        <span class="font-heading font-bold text-white text-base">ระบบสารสนเทศการปฏิบัติวิปัสสนากรรมฐาน (MCUVMS)</span>
                    </div>
                    <p class="text-[#A3B88C]">{{ $contactSettings['contact_address'] ?? 'มหาวิทยาลัยมหาจุฬาลงกรณราชวิทยาลัย 79 หมู่ 1 ต.ลำไทร อ.วังน้อย จ.พระนครศรีอยุธยา 13170' }}</p>
                    <p class="text-[#8C8275] mt-1">{{ $contactSettings['contact_org_name'] ?? 'สถาบันวิปัสสนาธุระ มหาวิทยาลัยมหาจุฬาลงกรณราชวิทยาลัย' }} &bull; โทรศัพท์ {{ $contactSettings['contact_phone'] ?? '035-248-000' }}</p>
                </div>
                <div class="text-[#8C8275] font-mono text-[11px]">
                    <div>Architecture: Laravel 11.x &bull; Server: Apache/2.4 (FreeBSD)</div>
                    <div>Database: MariaDB 10.6 &bull; MCU Vipassana Management System</div>
                </div>
            </div>
        </div>
    </footer>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>
