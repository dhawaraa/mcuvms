<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ข่าวสารประชาสัมพันธ์ - MCUVMS ระบบสารสนเทศการปฏิบัติวิปัสสนากรรมฐาน</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@300;400;500;600;700&family=Prompt:wght@400;500;600;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>

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
                    <a href="{{ route('home') }}#contact" class="hover:text-[#C86D51] transition flex items-center gap-1.5">
                        <i data-lucide="phone-call" class="w-4 h-4 text-[#5A6B47]"></i>
                        <span>ติดต่อสอบถาม</span>
                    </a>
                </nav>

                <!-- Auth / Admin Button -->
                <div class="flex items-center space-x-3">
                    @if (Session::has('admin_user'))
                        <a href="{{ route('admin.dashboard') }}" class="bg-[#2C3E2D] hover:bg-[#3D523E] text-[#F7F4EA] px-4 py-2.5 rounded-xl text-xs font-semibold flex items-center gap-2 shadow-sm transition">
                            <i data-lucide="layout-dashboard" class="w-4 h-4 text-[#A3B88C]"></i>
                            <span>แผงควบคุม</span>
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="px-4 py-2.5 text-xs font-semibold text-[#4A3B32] hover:text-[#2C3E2D] bg-[#EAE5D9] hover:bg-[#DDD7C8] rounded-xl transition border border-[#D5CEBC] shadow-sm flex items-center gap-2">
                            <i data-lucide="lock" class="w-3.5 h-3.5 text-[#5A6B47]"></i>
                            <span>เจ้าหน้าที่เข้าระบบ</span>
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content Matching Standardized Width -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full flex-grow">
        
        <!-- Header Banner -->
        <div class="bg-gradient-to-r from-[#2C3E2D] via-[#4A3B32] to-[#5A6B47] rounded-3xl p-6 md:p-8 text-white shadow-lg shadow-[#2C3E2D]/15 mb-8 border border-[#2C3E2D]/20">
            <div class="inline-flex items-center gap-1.5 px-3 py-1 bg-white/15 backdrop-blur-sm rounded-full text-xs font-semibold uppercase tracking-wider mb-2 border border-white/20 text-[#FAF8F2]">
                <i data-lucide="newspaper" class="w-3.5 h-3.5 text-[#EAE5D9]"></i>
                <span>ข่าวสาร & ประชาสัมพันธ์ (News & Announcements)</span>
            </div>
            <h1 class="text-2xl md:text-3xl font-heading font-bold mb-2">ข่าวสารและกิจกรรมวิปัสสนากรรมฐาน มจร</h1>
            <p class="text-[#EAE5D9] text-sm leading-relaxed max-w-3xl">
                ติดตามข่าวประกาศ โครงการปฏิบัติธรรมประจำปี บทความวิชาการ และกิจกรรมส่งเสริมการปฏิบัติวิปัสสนาธุระ สถาบันวิปัสสนาธุระ มหาวิทยาลัยมหาจุฬาลงกรณราชวิทยาลัย
            </p>
        </div>

        <!-- Filter & Search Bar -->
        <div class="bg-white rounded-2xl p-4 sm:p-5 border border-[#E3DEC9] shadow-sm mb-8">
            <form method="GET" action="{{ route('news.index') }}" class="flex flex-col md:flex-row items-center justify-between gap-4">
                <div class="flex flex-wrap items-center gap-3 w-full md:w-auto flex-grow">
                    <div class="relative flex-grow sm:flex-grow-0 sm:w-72">
                        <i data-lucide="search" class="w-4 h-4 absolute left-3 top-3 text-[#8C8275]"></i>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="ค้นหาตามหัวข้อข่าว..." class="w-full pl-9 pr-3 py-2 text-xs bg-[#FAF8F2] border border-[#D5CEBC] rounded-xl text-[#2C3E2D] font-medium focus:ring-2 focus:ring-[#5A6B47]">
                    </div>

                    <select name="category" onchange="this.form.submit()" class="px-3 py-2 text-xs bg-[#FAF8F2] border border-[#D5CEBC] rounded-xl text-[#2C3E2D] font-medium focus:ring-2 focus:ring-[#5A6B47]">
                        <option value="">-- ทุกหมวดหมู่ข่าว --</option>
                        <option value="ANNOUNCEMENT" {{ request('category') == 'ANNOUNCEMENT' ? 'selected' : '' }}>ประกาศ / ข่าวทางการ</option>
                        <option value="MEDITATION" {{ request('category') == 'MEDITATION' ? 'selected' : '' }}>กิจกรรมปฏิบัติธรรม</option>
                        <option value="ACADEMIC" {{ request('category') == 'ACADEMIC' ? 'selected' : '' }}>วิชาการวิปัสสนาธุระ</option>
                        <option value="GENERAL" {{ request('category') == 'GENERAL' ? 'selected' : '' }}>ข่าวทั่วไป</option>
                    </select>

                    <select name="org_unit_id" onchange="this.form.submit()" class="px-3 py-2 text-xs bg-[#FAF8F2] border border-[#D5CEBC] rounded-xl text-[#2C3E2D] font-medium focus:ring-2 focus:ring-[#5A6B47] max-w-xs">
                        <option value="">-- ทุกส่วนงาน --</option>
                        @foreach ($orgUnits as $org)
                            <option value="{{ $org->id }}" {{ request('org_unit_id') == $org->id ? 'selected' : '' }}>
                                {{ $org->name_th }}
                            </option>
                        @endforeach
                    </select>

                    <button type="submit" class="px-4 py-2 bg-[#2C3E2D] text-white rounded-xl text-xs font-semibold hover:bg-[#3D523E] transition flex items-center gap-1.5 shadow-sm">
                        <i data-lucide="filter" class="w-3.5 h-3.5"></i> ค้นหา
                    </button>

                    @if(request()->anyFilled(['search', 'category', 'org_unit_id']))
                        <a href="{{ route('news.index') }}" class="text-xs text-[#C86D51] hover:underline flex items-center gap-1 font-medium">
                            <i data-lucide="x" class="w-3.5 h-3.5"></i> ล้างตัวกรอง
                        </a>
                    @endif
                </div>

                <div class="text-xs text-[#7B8D65] font-mono shrink-0">
                    พบทั้งหมด <strong>{{ $newsList->total() }}</strong> ข่าว
                </div>
            </form>
        </div>

        <!-- News Grid (4 Columns) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
            @forelse ($newsList as $item)
                <div class="bg-white rounded-3xl overflow-hidden border border-[#E3DEC9] hover:border-[#5A6B47] transition duration-200 shadow-sm hover:shadow-md flex flex-col justify-between group relative">
                    
                    @if ($item->is_pinned)
                        <div class="absolute top-3 right-3 z-10 bg-[#C86D51] text-white text-[10px] font-bold px-2.5 py-1 rounded-full shadow-md flex items-center gap-1">
                            <i data-lucide="pin" class="w-3 h-3 fill-white"></i> ปักหมุด
                        </div>
                    @endif

                    @if ($item->cover_image)
                        <div class="aspect-square w-full overflow-hidden bg-stone-100 relative">
                            <img src="{{ $item->cover_image }}" alt="{{ $item->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                            <div class="absolute bottom-3 left-3">
                                @if ($item->category === 'ANNOUNCEMENT')
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-semibold bg-[#C86D51] text-white shadow-sm">ประกาศทางการ</span>
                                @elseif ($item->category === 'MEDITATION')
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-semibold bg-[#5A6B47] text-white shadow-sm">กิจกรรมปฏิบัติธรรม</span>
                                @elseif ($item->category === 'ACADEMIC')
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-semibold bg-[#4A3B32] text-white shadow-sm">วิชาการวิปัสสนา</span>
                                @else
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-semibold bg-stone-800 text-white shadow-sm">ข่าวทั่วไป</span>
                                @endif
                            </div>
                        </div>
                    @else
                        <div class="aspect-square w-full bg-[#FAF8F2] flex items-center justify-center text-[#D5CEBC] border-b border-[#E3DEC9] relative">
                            <i data-lucide="image" class="w-16 h-16 stroke-1"></i>
                            <div class="absolute bottom-3 left-3">
                                @if ($item->category === 'ANNOUNCEMENT')
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-semibold bg-[#C86D51] text-white shadow-sm">ประกาศทางการ</span>
                                @elseif ($item->category === 'MEDITATION')
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-semibold bg-[#5A6B47] text-white shadow-sm">กิจกรรมปฏิบัติธรรม</span>
                                @elseif ($item->category === 'ACADEMIC')
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-semibold bg-[#4A3B32] text-white shadow-sm">วิชาการวิปัสสนา</span>
                                @else
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-semibold bg-stone-800 text-white shadow-sm">ข่าวทั่วไป</span>
                                @endif
                            </div>
                        </div>
                    @endif

                    <div class="p-6 flex-grow flex flex-col justify-between">
                        <div>


                            <div class="flex items-center justify-between text-xs text-[#8C8275] mb-2 font-mono">
                                <span class="flex items-center gap-1 truncate max-w-[65%]">
                                    <i data-lucide="building" class="w-3 h-3 text-[#5A6B47] shrink-0"></i> 
                                    <span class="truncate">{{ $item->organizationUnit->name_th ?? 'สถาบันวิปัสสนาธุระ ส่วนกลาง' }}</span>
                                </span>
                                <span class="flex items-center gap-1 shrink-0">
                                    <i data-lucide="calendar" class="w-3 h-3"></i> 
                                    {{ substr($item->published_at ?? $item->created_at, 0, 10) }}
                                </span>
                            </div>

                            <h3 class="font-heading font-bold text-[#2C3E2D] text-base mb-2 group-hover:text-[#C86D51] transition line-clamp-2 leading-snug">
                                <a href="{{ route('news.detail', $item->id) }}">
                                    {{ $item->title }}
                                </a>
                            </h3>

                            <p class="text-xs text-[#6B6357] line-clamp-3 leading-relaxed mb-4">
                                {{ strip_tags($item->content) }}
                            </p>
                        </div>

                        <div class="pt-4 border-t border-[#F2EFE7] flex items-center justify-between text-xs">
                            <span class="text-[11px] font-semibold text-[#8C8275] flex items-center gap-1 font-mono">
                                <i data-lucide="eye" class="w-3.5 h-3.5 text-[#A3B88C]"></i>
                                {{ number_format($item->views) }} เข้าชม
                            </span>
                            <a href="{{ route('news.detail', $item->id) }}" class="text-[#5A6B47] font-semibold flex items-center gap-1 group-hover:text-[#C86D51] transition">
                                <span>อ่านเนื้อหาเต็ม</span>
                                <i data-lucide="chevron-right" class="w-3.5 h-3.5"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-16 text-center text-[#8C8275] bg-white rounded-3xl border border-dashed border-[#D5CEBC] p-8">
                    <i data-lucide="inbox" class="w-12 h-12 mx-auto mb-3 text-[#D5CEBC]"></i>
                    <p class="text-base font-semibold text-[#4A3B32]">ไม่พบข้อมูลข่าวสารตามเงื่อนไขที่ค้นหา</p>
                    <p class="text-xs text-[#8C8275] mt-1">ลองเปลี่ยนคำค้นหา หรือเลือกหมวดหมู่อื่น</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if ($newsList->hasPages())
            <div class="bg-white rounded-2xl p-4 border border-[#E3DEC9] flex justify-center shadow-sm">
                {{ $newsList->links() }}
            </div>
        @endif

    </main>

    <!-- Footer -->
    <footer class="bg-[#243325] text-[#D5CEBC] text-xs py-12 border-t border-[#1B271C]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-center gap-6 text-center md:text-left">
                <div>
                    <div class="flex items-center justify-center md:justify-start gap-3 mb-2">
                        <img src="{{ asset('images/mcu-logo.png') }}" alt="MCU Logo" class="w-8 h-8 object-contain">
                        <span class="font-heading font-bold text-white text-base">ระบบสารสนเทศการปฏิบัติวิปัสสนากรรมฐาน (MCUVMS)</span>
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
