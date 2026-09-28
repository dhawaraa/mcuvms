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
                <div class="flex items-center space-x-4">
                    <a href="{{ route('home') }}" class="text-[#4A3B32] hover:text-[#5A6B47] font-medium text-sm flex items-center gap-1.5 transition">
                        <i data-lucide="arrow-left" class="w-4 h-4"></i> กลับหน้าหลัก
                    </a>
                    <a href="{{ route('login') }}" class="text-[#5A6B47] hover:text-[#2C3E2D] font-medium text-sm border border-[#5A6B47]/30 px-3 py-1.5 rounded-lg bg-white/70 flex items-center gap-1.5 transition">
                        <i data-lucide="lock" class="w-3.5 h-3.5"></i> เจ้าหน้าที่เข้าระบบ
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
                <span>โมดูลที่ 3 (Module 3: Public Community)</span>
            </div>
            <h1 class="text-2xl md:text-3xl font-heading font-bold mb-2 text-[#FAF8F2]">ลงทะเบียนปฏิบัติธรรมสำหรับประชาชนทั่วไป</h1>
            <p class="text-[#EAE5D9] text-sm leading-relaxed">
                บริการวิชาการทางพระพุทธศาสนาแก่สังคม เพื่อพัฒนาจิตและสันติสุขในชีวิตประจำวัน (เปิดกว้างสำหรับสาธุชนทุกท่าน สะดวก ใช้งานง่าย)
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
                <div class="w-16 h-16 bg-[#5A6B47]/15 text-[#5A6B47] rounded-2xl flex items-center justify-center mx-auto mb-4 border border-[#5A6B47]/20">
                    <i data-lucide="check" class="w-8 h-8"></i>
                </div>
                <h2 class="text-2xl font-heading font-bold text-[#2C3E2D] mb-2">{{ session('success') }}</h2>
                <p class="text-[#4A3B32] text-sm mb-6">รหัสการลงทะเบียนของท่านคือ:</p>
                <div class="inline-block bg-[#FAF8F2] border border-[#EAE5D9] font-mono font-bold text-xl px-6 py-3 rounded-xl text-[#2C3E2D] tracking-wider mb-6 shadow-inner">
                    {{ session('regSuccess') }}
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

            <!-- Easy Form for Public -->
            <form action="{{ route('public.store') }}" method="POST" class="organic-card rounded-3xl overflow-hidden p-6 md:p-8 space-y-6">
                @csrf
                
                <!-- Section 1: Choose Course -->
                <div>
                    <h2 class="text-lg font-heading font-semibold text-[#2C3E2D] flex items-center border-b border-[#EAE5D9] pb-3 mb-4">
                        <span class="w-7 h-7 rounded-xl bg-[#5A6B47] text-white text-xs font-bold flex items-center justify-center mr-2.5 shadow-sm">1</span>
                        เลือกคอร์สปฏิบัติธรรมที่ประสงค์เข้าร่วม
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
                                ยังไม่มีคอร์สปฏิบัติธรรมสำหรับประชาชนเปิดรับในขณะนี้
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Section 2: Personal Information -->
                <div>
                    <h2 class="text-lg font-heading font-semibold text-[#2C3E2D] flex items-center border-b border-[#EAE5D9] pb-3 mb-4">
                        <span class="w-7 h-7 rounded-xl bg-[#5A6B47] text-white text-xs font-bold flex items-center justify-center mr-2.5 shadow-sm">2</span>
                        ข้อมูลผู้สมัครเข้าร่วมโครงการ
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-medium text-[#4A3B32] mb-1">เลขประจำตัวประชาชน 13 หลัก <span class="text-[#C86D51]">*</span></label>
                            <input type="text" name="citizen_id" maxlength="13" placeholder="13 หลัก ไม่ต้องเว้นวรรค" required class="w-full px-3.5 py-2.5 border border-[#EAE5D9] bg-white rounded-xl text-sm focus:ring-2 focus:ring-[#5A6B47] focus:border-[#5A6B47]">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-[#4A3B32] mb-1">คำนำหน้าชื่อ</label>
                            <select name="prefix" class="w-full px-3.5 py-2.5 border border-[#EAE5D9] rounded-xl text-sm bg-white focus:ring-2 focus:ring-[#5A6B47] focus:border-[#5A6B47]">
                                <option value="นาย">นาย</option>
                                <option value="นาง">นาง</option>
                                <option value="นางสาว">นางสาว</option>
                                <option value="อุบาสก">อุบาสก</option>
                                <option value="อุบาสิกา">อุบาสิกา</option>
                                <option value="แม่ชี">แม่ชี</option>
                                <option value="พระ">พระภิกษุ</option>
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
                                <input type="number" name="age" min="10" max="100" placeholder="เช่น 45" class="w-full px-3.5 py-2.5 border border-[#EAE5D9] bg-white rounded-xl text-sm focus:ring-2 focus:ring-[#5A6B47] focus:border-[#5A6B47]">
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-[#4A3B32] mb-1">จังหวัดที่พำนักปัจจุบัน</label>
                            <input type="text" name="province" placeholder="เช่น นครราชสีมา, เชียงใหม่, กรุงเทพฯ" class="w-full px-3.5 py-2.5 border border-[#EAE5D9] bg-white rounded-xl text-sm focus:ring-2 focus:ring-[#5A6B47] focus:border-[#5A6B47]">
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-[#4A3B32] mb-1">เบอร์โทรศัพท์ติดต่อ <span class="text-[#C86D51]">*</span></label>
                            <input type="tel" name="phone" placeholder="08xxxxxxxx" required class="w-full px-3.5 py-2.5 border border-[#EAE5D9] bg-white rounded-xl text-sm focus:ring-2 focus:ring-[#5A6B47] focus:border-[#5A6B47]">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-[#4A3B32] mb-1">อีเมล (ถ้ามี)</label>
                            <input type="email" name="email" placeholder="example@gmail.com" class="w-full px-3.5 py-2.5 border border-[#EAE5D9] bg-white rounded-xl text-sm focus:ring-2 focus:ring-[#5A6B47] focus:border-[#5A6B47]">
                        </div>
                    </div>
                </div>

                <!-- Section 3: Preference & Dietary -->
                <div>
                    <h2 class="text-lg font-heading font-semibold text-[#2C3E2D] flex items-center border-b border-[#EAE5D9] pb-3 mb-4">
                        <span class="w-7 h-7 rounded-xl bg-[#5A6B47] text-white text-xs font-bold flex items-center justify-center mr-2.5 shadow-sm">3</span>
                        ข้อมูลประเภทอาหารและความต้องการพิเศษ
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
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
                            <input type="text" name="special_needs" placeholder="เช่น ขอห้องพักชั้นล่างเนื่องจากหัวเข่า, แพ้อาหารทะเล..." class="w-full px-3.5 py-2.5 border border-[#EAE5D9] bg-white rounded-xl text-sm focus:ring-2 focus:ring-[#5A6B47] focus:border-[#5A6B47]">
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

        @endif

    </main>

    <!-- Footer -->
    <footer class="bg-[#FAF8F2] border-t border-[#EAE5D9] py-6 text-center text-xs text-[#7B8D65]">
        มหาวิทยาลัยมหาจุฬาลงกรณราชวิทยาลัย (MCU) &bull; ระบบสารสนเทศการปฏิบัติวิปัสสนากรรมฐาน (MCUVMS Laravel)
    </footer>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>
