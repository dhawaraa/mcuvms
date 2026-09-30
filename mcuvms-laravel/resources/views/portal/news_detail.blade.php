<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $news->title }} - ข่าวสาร MCUVMS</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@300;400;500;600;700&family=Prompt:wght@400;500;600;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
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
        body { font-family: 'Sarabun', sans-serif; background-color: #F7F5EE; color: #2D2A26; }
        h1, h2, h3, h4, .font-heading { font-family: 'Prompt', sans-serif; }
    </style>
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/mcu-logo.png') }}">
    <link rel="shortcut icon" href="{{ asset('images/mcu-logo.png') }}">
</head>
<body class="antialiased min-h-screen flex flex-col justify-between selection:bg-[#5A6B47] selection:text-white">

    <!-- Top Info Bar -->
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
    <header class="sticky top-0 z-50 bg-[#FAF8F2]/90 backdrop-blur-xl border-b border-[#E3DEC9] shadow-sm">
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

                <!-- Nav Links: ปฏิทิน, ปริญญาตรี, บัณฑิตศึกษา, ประชาชนทั่วไป, ติดต่อ, ร่วมบริจาค -->
                <nav class="hidden xl:flex items-center space-x-6 text-[15px] font-semibold text-[#4A3B32]">
                    <a href="{{ route('home') }}#calendar" class="hover:text-[#C86D51] transition flex items-center gap-1.5 whitespace-nowrap py-1">
                        <i data-lucide="calendar" class="w-4.5 h-4.5 text-[#5A6B47]"></i>
                        <span>{{ __('portal.nav_calendar') }}</span>
                    </a>
                    <a href="{{ route('ug.register') }}" class="hover:text-[#C86D51] transition flex items-center gap-1.5 whitespace-nowrap py-1">
                        <i data-lucide="graduation-cap" class="w-4.5 h-4.5 text-[#5A6B47]"></i>
                        <span>{{ __('portal.nav_ug') }}</span>
                    </a>
                    <a href="{{ route('grad.progress') }}" class="hover:text-[#C86D51] transition flex items-center gap-1.5 whitespace-nowrap py-1">
                        <i data-lucide="scroll" class="w-4.5 h-4.5 text-[#5A6B47]"></i>
                        <span>{{ __('portal.nav_grad') }}</span>
                    </a>
                    <a href="{{ route('public.register') }}" class="hover:text-[#C86D51] transition flex items-center gap-1.5 whitespace-nowrap py-1">
                        <i data-lucide="users" class="w-4.5 h-4.5 text-[#5A6B47]"></i>
                        <span>{{ __('portal.nav_public') }}</span>
                    </a>
                    <a href="{{ route('contact') }}" class="hover:text-[#C86D51] transition flex items-center gap-1.5 whitespace-nowrap py-1">
                        <i data-lucide="phone-call" class="w-4.5 h-4.5 text-[#5A6B47]"></i>
                        <span>{{ __('portal.nav_contact') }}</span>
                    </a>
                    <a href="{{ route('donation') }}" class="hover:text-[#C86D51] transition flex items-center gap-1.5 text-[#C86D51] font-bold whitespace-nowrap py-1">
                        <i data-lucide="gift" class="w-4.5 h-4.5 text-[#C86D51]"></i>
                        <span>{{ __('portal.nav_donation') }}</span>
                    </a>
                </nav>

                <!-- Actions: Language Switcher & Auth / Admin Button -->
                <div class="flex items-center space-x-2.5">
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

                    @if (Session::has('admin_user'))
                        <a href="{{ route('admin.dashboard') }}" title="แผงควบคุมแอดมิน" class="bg-[#2C3E2D] hover:bg-[#3D523E] text-[#F7F4EA] px-3.5 py-2 rounded-xl text-sm font-semibold flex items-center gap-1.5 shadow-sm transition whitespace-nowrap">
                            <i data-lucide="layout-dashboard" class="w-4 h-4 text-[#A3B88C]"></i>
                            <span class="hidden sm:inline">{{ __('portal.nav_admin_panel') }}</span>
                        </a>
                    @else
                        <a href="{{ route('login') }}" title="เข้าสู่ระบบเจ้าหน้าที่" class="p-2 sm:px-3.5 sm:py-2 text-sm font-semibold text-[#4A3B32] hover:text-[#2C3E2D] bg-[#EAE5D9] hover:bg-[#DDD7C8] rounded-xl transition border border-[#D5CEBC] shadow-sm flex items-center gap-1.5 whitespace-nowrap">
                            <i data-lucide="lock" class="w-4 h-4 text-[#5A6B47]"></i>
                            <span class="hidden sm:inline">{{ __('portal.nav_admin_login') }}</span>
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content Matching Standardized Width max-w-7xl -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full flex-grow">
        
        <!-- Breadcrumb -->
        <div class="flex items-center gap-2 text-xs text-[#8C8275] mb-6">
            <a href="{{ route('home') }}" class="hover:text-[#5A6B47]">หน้าหลัก</a>
            <i data-lucide="chevron-right" class="w-3.5 h-3.5 text-[#D5CEBC]"></i>
            <a href="{{ route('news.index') }}" class="hover:text-[#5A6B47]">ข่าวสารประชาสัมพันธ์</a>
            <i data-lucide="chevron-right" class="w-3.5 h-3.5 text-[#D5CEBC]"></i>
            <span class="text-[#2C3E2D] font-medium truncate max-w-xs sm:max-w-md">{{ $news->title }}</span>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Article Body (Col 1-2) -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-3xl p-6 sm:p-10 border border-[#E3DEC9] shadow-sm">
                    
                    <!-- Metadata Header -->
                    <div class="flex flex-wrap items-center gap-2 mb-4">
                        @if ($news->category === 'ANNOUNCEMENT')
                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-[#C86D51] text-white">ประกาศทางการ</span>
                        @elseif ($news->category === 'MEDITATION')
                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-[#5A6B47] text-white">กิจกรรมปฏิบัติธรรม</span>
                        @elseif ($news->category === 'ACADEMIC')
                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-[#4A3B32] text-white">วิชาการวิปัสสนาธุระ</span>
                        @else
                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-stone-800 text-white">ข่าวทั่วไป</span>
                        @endif

                        @if ($news->is_pinned)
                            <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-[#C86D51]/15 text-[#A85238] border border-[#C86D51]/30 flex items-center gap-1">
                                <i data-lucide="pin" class="w-3 h-3 fill-[#A85238]"></i> ปักหมุด
                            </span>
                        @endif
                    </div>

                    <h1 class="text-2xl sm:text-3xl font-heading font-extrabold text-[#2C3E2D] leading-tight mb-4">
                        {{ $news->title }}
                    </h1>

                    <div class="flex flex-wrap items-center gap-4 text-xs text-[#8C8275] pb-6 mb-6 border-b border-[#EAE5D9] font-mono">
                        <span class="flex items-center gap-1.5">
                            <i data-lucide="building" class="w-4 h-4 text-[#5A6B47]"></i>
                            {{ $news->organizationUnit->name_th ?? 'สถาบันวิปัสสนาธุระ (ส่วนกลาง)' }}
                        </span>
                        <span>•</span>
                        <span class="flex items-center gap-1.5">
                            <i data-lucide="calendar" class="w-4 h-4 text-[#5A6B47]"></i>
                            เผยแพร่เมื่อ {{ substr($news->published_at ?? $news->created_at, 0, 10) }}
                        </span>
                        <span>•</span>
                        <span class="flex items-center gap-1.5">
                            <i data-lucide="eye" class="w-4 h-4 text-[#A3B88C]"></i>
                            เข้าชม {{ number_format($news->views) }} ครั้ง
                        </span>
                    </div>

                    <!-- Cover Image -->
                    @if ($news->cover_image)
                        <div class="rounded-2xl overflow-hidden mb-8 border border-[#E3DEC9] shadow-sm max-h-[450px]">
                            <img src="{{ $news->cover_image }}" alt="{{ $news->title }}" class="w-full h-full object-cover">
                        </div>
                    @endif

                    <!-- Content -->
                    <div class="prose max-w-none text-[#4A3B32] text-sm sm:text-base leading-relaxed space-y-4">
                        {!! $news->content !!}
                    </div>

                    <!-- Share / Actions -->
                    <div class="mt-10 pt-6 border-t border-[#EAE5D9] flex flex-col sm:flex-row justify-between items-center gap-4">
                        <a href="{{ route('news.index') }}" class="inline-flex items-center gap-2 text-xs font-semibold text-[#5A6B47] hover:text-[#2C3E2D] transition">
                            <i data-lucide="arrow-left" class="w-4 h-4"></i> ย้อนกลับไปรายการข่าวทั้งหมด
                        </a>
                        <div class="flex items-center gap-2 text-xs text-[#8C8275]">
                            <span>แชร์ข่าวนี้:</span>
                            <button onclick="navigator.clipboard.writeText(window.location.href); alert('คัดลอกลิงก์เรียบร้อยแล้ว');" class="px-3 py-1.5 bg-[#FAF8F2] border border-[#D5CEBC] rounded-lg hover:bg-[#EAE5D9] transition flex items-center gap-1 text-[#2C3E2D]">
                                <i data-lucide="copy" class="w-3.5 h-3.5"></i> คัดลอกลิงก์
                            </button>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Sidebar / Related News (Col 3) -->
            <div class="space-y-6">
                
                <!-- Quick Register Box -->
                <div class="bg-gradient-to-br from-[#2C3E2D] to-[#3D523E] rounded-3xl p-6 text-white shadow-md">
                    <div class="flex items-center gap-2 mb-2 text-[#A3B88C] text-xs font-mono font-semibold uppercase">
                        <i data-lucide="sparkles" class="w-4 h-4"></i> MCUVMS Portal
                    </div>
                    <h3 class="font-heading font-bold text-lg mb-2">ลงทะเบียนปฏิบัติธรรม</h3>
                    <p class="text-xs text-[#D5CEBC] leading-relaxed mb-4">
                        นิสิตและพุทธศาสนิกชนสามารถตรวจสอบรอบโครงการและสมัครผ่านระบบออนไลน์ได้ทันที
                    </p>
                    <div class="space-y-2">
                        <a href="{{ route('ug.register') }}" class="w-full py-2.5 px-4 rounded-xl bg-white/10 hover:bg-white/20 text-xs font-semibold flex items-center justify-between transition border border-white/15">
                            <span>นิสิต ป.ตรี (เกณฑ์ 40 วัน)</span>
                            <i data-lucide="arrow-right" class="w-4 h-4"></i>
                        </a>
                        <a href="{{ route('grad.progress') }}" class="w-full py-2.5 px-4 rounded-xl bg-white/10 hover:bg-white/20 text-xs font-semibold flex items-center justify-between transition border border-white/15">
                            <span>นิสิต บัณฑิตศึกษา (ป.โท/เอก)</span>
                            <i data-lucide="arrow-right" class="w-4 h-4"></i>
                        </a>
                        <a href="{{ route('public.register') }}" class="w-full py-2.5 px-4 rounded-xl bg-white/10 hover:bg-white/20 text-xs font-semibold flex items-center justify-between transition border border-white/15">
                            <span>ประชาชนทั่วไป (บริการวิชาการแก่สังคม)</span>
                            <i data-lucide="arrow-right" class="w-4 h-4"></i>
                        </a>
                    </div>
                </div>

                <!-- Related News -->
                <div class="bg-white rounded-3xl p-6 border border-[#E3DEC9] shadow-sm">
                    <h3 class="font-heading font-bold text-base text-[#2C3E2D] pb-3 mb-4 border-b border-[#EAE5D9] flex items-center gap-2">
                        <i data-lucide="newspaper" class="w-4 h-4 text-[#5A6B47]"></i>
                        <span>ข่าวประชาสัมพันธ์อื่นๆ</span>
                    </h3>

                    <div class="space-y-4">
                        @forelse ($relatedNews as $item)
                            <div class="group">
                                <span class="text-[10px] text-[#8C8275] font-mono flex items-center gap-1 mb-1">
                                    <i data-lucide="calendar" class="w-3 h-3 text-[#A3B88C]"></i>
                                    {{ substr($item->published_at ?? $item->created_at, 0, 10) }}
                                </span>
                                <h4 class="font-heading font-medium text-xs text-[#2C3E2D] group-hover:text-[#C86D51] transition line-clamp-2 leading-snug">
                                    <a href="{{ route('news.detail', $item->id) }}">
                                        {{ $item->title }}
                                    </a>
                                </h4>
                            </div>
                        @empty
                            <p class="text-xs text-[#8C8275]">ไม่มีข่าวที่เกี่ยวข้องในขณะนี้</p>
                        @endforelse
                    </div>

                    <div class="mt-4 pt-3 border-t border-[#F2EFE7]">
                        <a href="{{ route('news.index') }}" class="text-xs font-semibold text-[#5A6B47] hover:text-[#2C3E2D] flex items-center justify-between">
                            <span>ดูข่าวทั้งหมด</span>
                            <i data-lucide="chevron-right" class="w-3.5 h-3.5"></i>
                        </a>
                    </div>
                </div>

            </div>

        </div>

    </main>

    <!-- Footer -->
    <footer class="bg-[#243325] text-[#D5CEBC] text-xs py-12 border-t border-[#1B271C]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-center gap-6 text-center md:text-left">
                <div>
                    <div class="flex items-center justify-center md:justify-start gap-3 mb-2">
                        <img src="{{ asset('images/mcu-logo.png') }}" alt="MCU Logo" class="w-8 h-8 object-contain">
                        <span class="font-heading font-bold text-white text-base">{{ __('portal.footer_brand') }}</span>
                    </div>
                    <p class="text-[#A3B88C]">มหาวิทยาลัยมหาจุฬาลงกรณราชวิทยาลัย 79 หมู่ 1 ต.ลำไทร อ.วังน้อย จ.พระนครศรีอยุธยา 13170</p>
                    <p class="text-[#8C8275] mt-1">สถาบันวิปัสสนาธุระ มหาวิทยาลัยมหาจุฬาลงกรณราชวิทยาลัย</p>
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
