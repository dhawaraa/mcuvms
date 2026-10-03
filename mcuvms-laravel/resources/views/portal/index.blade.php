<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VPSMCU - {{ __('portal.system_title') }} {{ __('portal.mcu_short') }}</title>
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
                            sand: '#F7F4EA',       // สีทราย/ครีมธรรมชาติ
                            stone: '#EAE5D9',      // สีก้อนหินอ่อน
                            clay: '#C86D51',       // สีน้ำตาลอิฐ/ดินเผา
                            clayDark: '#A85238',   // สีน้ำตาลอิฐเข้ม
                            forest: '#2C3E2D',     // สีเขียวป่าลึก
                            olive: '#5A6B47',      // สีเขียวมะกอก
                            oliveLight: '#7B8D65', // สีเขียวมะกอกอ่อน
                            bark: '#4A3B32',       // สีเปลือกไม้/ผืนดิน
                            cream: '#FAF8F2',      // สีครีมละมุน
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
            background: rgba(255, 255, 255, 0.88);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(220, 215, 201, 0.8);
            box-shadow: 0 15px 35px -10px rgba(74, 59, 50, 0.07), 0 0 0 1px rgba(123, 141, 101, 0.1);
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .organic-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 22px 40px -12px rgba(168, 82, 56, 0.15), 0 0 0 1px rgba(168, 82, 56, 0.3);
            border-color: rgba(200, 109, 81, 0.4);
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

    <!-- Top Announcement Bar -->
    <div class="bg-[#2C3E2D] text-[#EAE5D9] text-xs py-2 px-4 border-b border-[#3D523E]">
        <div class="max-w-7xl mx-auto flex flex-col sm:flex-row justify-between items-center gap-1 font-medium">
            <div class="flex items-center space-x-2">
                <span class="inline-block w-2 h-2 rounded-full bg-[#7B8D65] animate-pulse"></span>
                <span>{{ __('portal.top_announcement') }}</span>
            </div>
            <div class="flex items-center space-x-4 text-[#D8D2C2] text-[11px]">
                <span class="flex items-center gap-1.5"><i data-lucide="shield-check" class="w-3.5 h-3.5 text-[#A3B88C]"></i> {{ __('portal.institute_name') }}</span>
            </div>
        </div>
    </div>

    <!-- Main Navigation Header (Organic Glass Nav) -->
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
                            VPSMCU
                            <span class="text-[10px] uppercase font-mono px-2 py-0.5 rounded-full bg-[#EAE5D9] text-[#4A3B32] border border-[#D5CEBC]">{{ __('portal.mcu_short') }}</span>
                        </a>
                        <p class="text-xs text-[#6B6357] font-medium">{{ __('portal.system_title') }}</p>
                    </div>
                </div>

                <!-- Nav Links: ปฏิทิน (Dropdown), ปริญญาตรี, บัณฑิตศึกษา, ประชาชนทั่วไป, ติดต่อ, ร่วมบริจาค -->
                <nav class="hidden xl:flex items-center space-x-6 text-[15px] font-semibold text-[#4A3B32]">
                    <!-- Schedule Dropdown Menu -->
                    <div class="relative group py-2">
                        <a href="#calendar" onclick="switchCategory('ALL')" class="hover:text-[#C86D51] transition flex items-center gap-1.5 focus:outline-none whitespace-nowrap py-1">
                            <i data-lucide="calendar" class="w-4 h-4 text-[#5A6B47]"></i>
                            <span>{{ __('portal.nav_calendar') }}</span>
                            <i data-lucide="chevron-down" class="w-3.5 h-3.5 text-[#8C8275] group-hover:rotate-180 transition-transform duration-200"></i>
                        </a>
                        <!-- Dropdown Panel -->
                        <div class="absolute left-0 top-full pt-2 w-64 hidden group-hover:block z-50 transition-all">
                            <div class="bg-white/95 backdrop-blur-md border border-[#D5CEBC] rounded-2xl shadow-xl p-2 space-y-1">
                                <a href="#calendar" onclick="switchCategory('ALL')" class="flex items-center gap-3 px-3 py-2 rounded-xl text-sm text-[#2C3E2D] hover:bg-[#FAF8F2] transition">
                                    <span class="w-8 h-8 rounded-lg bg-[#5A6B47]/10 flex items-center justify-center text-[#5A6B47] shrink-0">
                                        <i data-lucide="calendar-range" class="w-4 h-4"></i>
                                    </span>
                                    <div>
                                        <div class="font-semibold text-sm">{{ __('portal.nav_all_schedules') }}</div>
                                        <div class="text-xs text-[#7B8D65]">{{ __('portal.nav_all_schedules_desc') }}</div>
                                    </div>
                                </a>
                                <a href="#calendar" onclick="switchCategory('UG')" class="flex items-center gap-3 px-3 py-2 rounded-xl text-sm text-[#2C3E2D] hover:bg-[#FAF8F2] transition">
                                    <span class="w-8 h-8 rounded-lg bg-[#5A6B47]/15 flex items-center justify-center text-[#5A6B47] shrink-0">
                                        <i data-lucide="graduation-cap" class="w-4 h-4"></i>
                                    </span>
                                    <div>
                                        <div class="font-semibold text-sm text-[#5A6B47]">{{ __('portal.nav_ug_schedules') }}</div>
                                        <div class="text-xs text-[#7B8D65]">{{ __('portal.nav_ug_schedules_desc') }}</div>
                                    </div>
                                </a>
                                <a href="#calendar" onclick="switchCategory('PUBLIC')" class="flex items-center gap-3 px-3 py-2 rounded-xl text-sm text-[#2C3E2D] hover:bg-[#FAF8F2] transition">
                                    <span class="w-8 h-8 rounded-lg bg-[#C86D51]/15 flex items-center justify-center text-[#C86D51] shrink-0">
                                        <i data-lucide="users" class="w-4 h-4"></i>
                                    </span>
                                    <div>
                                        <div class="font-semibold text-sm text-[#C86D51]">{{ __('portal.nav_public_schedules') }}</div>
                                        <div class="text-xs text-[#7B8D65]">{{ __('portal.nav_public_schedules_desc') }}</div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>

                    <a href="{{ route('ug.register') }}" class="hover:text-[#C86D51] transition flex items-center gap-1.5 whitespace-nowrap py-1">
                        <i data-lucide="graduation-cap" class="w-4.5 h-4.5 text-[#5A6B47]"></i>
                        <span>{{ __('portal.nav_ug') }}</span>
                    </a>
                    <a href="{{ route('grad.request') }}" class="hover:text-[#C86D51] transition flex items-center gap-1.5 whitespace-nowrap py-1">
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

                <!-- Actions: Language Switcher & Admin Panel Shortcut (if logged in) -->
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
                </div>
            </div>
        </div>
    </header>

    <!-- Hero Section (Earth Tones & Organic Aesthetics) -->
    <section class="relative pt-12 pb-20 px-4 sm:px-6 lg:px-8 overflow-hidden">
        <div class="max-w-7xl mx-auto text-center relative z-10">
            
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-[#EAE5D9] border border-[#D5CEBC] text-[#4A3B32] text-xs font-semibold mb-6 shadow-sm">
                <i data-lucide="leaf" class="w-3.5 h-3.5 text-[#5A6B47]"></i>
                <span>{{ __('portal.system_subtitle') }}</span>
            </div>

            <h1 class="text-3xl sm:text-5xl md:text-6xl font-heading font-extrabold text-[#2C3E2D] tracking-tight leading-[1.18] mb-6">
                {{ __('portal.hero_title_1') }}<br class="hidden sm:inline">
                <span class="bg-gradient-to-r from-[#2C3E2D] via-[#5A6B47] to-[#C86D51] bg-clip-text text-transparent">
                    {{ __('portal.hero_title_2') }}
                </span>
            </h1>

            <p class="text-[#5A544A] max-w-3xl mx-auto text-sm sm:text-base md:text-lg mb-12 leading-relaxed">
                {{ __('portal.hero_desc') }}
            </p>

            <!-- 3 Main Interactive Feature Cards (Organic Style) -->
            <div id="modules" class="grid grid-cols-1 md:grid-cols-3 gap-6 text-left max-w-7xl mx-auto">
                
                <!-- Card 1: Undergraduate -->
                <div class="organic-card rounded-3xl p-7 relative group">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-[#C86D51] to-[#A85238] text-white flex items-center justify-center text-2xl font-bold mb-6 shadow-md shadow-[#C86D51]/20 group-hover:scale-105 transition">
                        <i data-lucide="graduation-cap" class="w-7 h-7 text-[#FAF8F2]"></i>
                    </div>
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-[11px] font-bold uppercase tracking-wider text-[#A85238] font-mono">Module 01</span>
                        <span class="px-2.5 py-0.5 rounded-full bg-[#F3E7E3] text-[#A85238] text-[10px] font-semibold border border-[#E8D1CB]">{{ __('portal.module_1_badge') }}</span>
                    </div>
                    <h3 class="font-heading font-bold text-xl text-[#2C3E2D] mb-2">{{ __('portal.module_1_title') }}</h3>
                    <p class="text-xs text-[#6B6357] mb-6 leading-relaxed">
                        {{ __('portal.module_1_desc') }}
                    </p>
                    <a href="{{ route('ug.register') }}" class="w-full inline-flex justify-between items-center py-2.5 px-4 rounded-xl text-xs font-semibold bg-[#2C3E2D] hover:bg-[#C86D51] text-white transition shadow-sm">
                        <span>{{ __('portal.module_1_btn') }}</span>
                        <i data-lucide="arrow-right" class="w-4 h-4"></i>
                    </a>
                </div>

                <!-- Card 2: Graduate Studies -->
                <div class="organic-card rounded-3xl p-7 relative group">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-[#4A3B32] to-[#2C3E2D] text-white flex items-center justify-center text-2xl font-bold mb-6 shadow-md shadow-[#4A3B32]/20 group-hover:scale-105 transition">
                        <i data-lucide="scroll-text" class="w-7 h-7 text-[#FAF8F2]"></i>
                    </div>
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-[11px] font-bold uppercase tracking-wider text-[#4A3B32] font-mono">Module 02</span>
                        <span class="px-2.5 py-0.5 rounded-full bg-[#EAE5D9] text-[#4A3B32] text-[10px] font-semibold border border-[#D5CEBC]">{{ __('portal.module_2_badge') }}</span>
                    </div>
                    <h3 class="font-heading font-bold text-xl text-[#2C3E2D] mb-2">{{ __('portal.module_2_title') }}</h3>
                    <p class="text-xs text-[#6B6357] mb-6 leading-relaxed">
                        {{ __('portal.module_2_desc') }}
                    </p>
                    <a href="{{ route('grad.request') }}" class="w-full inline-flex justify-between items-center py-2.5 px-4 rounded-xl text-xs font-semibold bg-[#2C3E2D] hover:bg-[#5A6B47] text-white transition shadow-sm">
                        <span>{{ __('portal.module_2_btn') }}</span>
                        <i data-lucide="arrow-right" class="w-4 h-4"></i>
                    </a>
                </div>

                <!-- Card 3: Public Community -->
                <div class="organic-card rounded-3xl p-7 relative group">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-[#5A6B47] to-[#2C3E2D] text-white flex items-center justify-center text-2xl font-bold mb-6 shadow-md shadow-[#5A6B47]/20 group-hover:scale-105 transition">
                        <i data-lucide="users" class="w-7 h-7 text-[#FAF8F2]"></i>
                    </div>
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-[11px] font-bold uppercase tracking-wider text-[#5A6B47] font-mono">Module 03</span>
                        <span class="px-2.5 py-0.5 rounded-full bg-[#E9EFE2] text-[#3D523E] text-[10px] font-semibold border border-[#CADBC0]">{{ __('portal.module_3_badge') }}</span>
                    </div>
                    <h3 class="font-heading font-bold text-xl text-[#2C3E2D] mb-2">{{ __('portal.module_3_title') }}</h3>
                    <p class="text-xs text-[#6B6357] mb-6 leading-relaxed">
                        {{ __('portal.module_3_desc') }}
                    </p>
                    <a href="{{ route('public.register') }}" class="w-full inline-flex justify-between items-center py-2.5 px-4 rounded-xl text-xs font-semibold bg-[#2C3E2D] hover:bg-[#5A6B47] text-white transition shadow-sm">
                        <span>{{ __('portal.module_3_btn') }}</span>
                        <i data-lucide="arrow-right" class="w-4 h-4"></i>
                    </a>
                </div>

            </div>

        </div>
    </section>

    <!-- Meditation Calendar & 52 Org Units Section -->
    <section id="calendar" class="py-16 bg-[#F2EFE7] border-t border-[#E3DEC9]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-8 pb-6 border-b border-[#D5CEBC] gap-4">
                <div>
                    <span class="text-xs font-bold text-[#5A6B47] uppercase tracking-widest font-mono flex items-center gap-1.5">
                        <i data-lucide="network" class="w-4 h-4"></i> {{ __('portal.calendar_network') }}
                    </span>
                    <h2 class="text-2xl sm:text-3xl font-heading font-bold text-[#2C3E2D] mt-1">{{ __('portal.calendar_title') }}</h2>
                    <p class="text-xs text-[#6B6357] mt-1">{{ __('portal.calendar_desc') }}</p>
                </div>
                <div class="w-full md:w-auto">
                    <form method="GET" action="{{ route('home') }}#calendar">
                        <select name="filter_org" onchange="this.form.submit()" class="w-full md:w-80 text-xs bg-white border border-[#D5CEBC] rounded-xl px-4 py-3 text-[#4A3B32] focus:outline-none focus:ring-2 focus:ring-[#5A6B47] font-medium shadow-sm">
                            <option value="">{{ __('portal.calendar_filter_all') }}</option>
                            @foreach ($orgUnits as $org)
                                <option value="{{ $org->id }}" {{ request('filter_org') == $org->id ? 'selected' : '' }}>
                                    [{{ $org->code_provincial ?: $org->code }}] {{ $currentLang === 'en' && !empty($org->name_en) ? $org->name_en : $org->name_th }}
                                </option>
                            @endforeach
                        </select>
                    </form>
                </div>
            </div>

            <!-- Category Filter Tabs: ทั้งหมด, ปริญญาตรี, ภาคประชาชน -->
            <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
                <div class="inline-flex p-1.5 rounded-2xl bg-white border border-[#D5CEBC] shadow-xs gap-1.5" id="category-tabs">
                    <button type="button" onclick="switchCategory('ALL')" id="tab-cat-ALL" class="px-4 py-2 rounded-xl text-xs font-semibold transition flex items-center gap-1.5 bg-[#2C3E2D] text-white shadow-xs">
                        <i data-lucide="layers" class="w-3.5 h-3.5"></i>
                        <span>{{ __('portal.calendar_tab_all') }}</span>
                        <span id="badge-count-all" class="px-1.5 py-0.2 rounded-full text-[10px] bg-white/20 font-mono">0</span>
                    </button>
                    <button type="button" onclick="switchCategory('UG')" id="tab-cat-UG" class="px-4 py-2 rounded-xl text-xs font-semibold text-[#4A3B32] hover:text-[#2C3E2D] hover:bg-[#FAF8F2] transition flex items-center gap-1.5">
                        <i data-lucide="graduation-cap" class="w-3.5 h-3.5 text-[#5A6B47]"></i>
                        <span>{{ __('portal.calendar_tab_ug') }}</span>
                        <span id="badge-count-ug" class="px-1.5 py-0.2 rounded-full text-[10px] bg-[#5A6B47]/15 text-[#5A6B47] font-mono font-bold">0</span>
                    </button>
                    <button type="button" onclick="switchCategory('PUBLIC')" id="tab-cat-PUBLIC" class="px-4 py-2 rounded-xl text-xs font-semibold text-[#4A3B32] hover:text-[#2C3E2D] hover:bg-[#FAF8F2] transition flex items-center gap-1.5">
                        <i data-lucide="users" class="w-3.5 h-3.5 text-[#C86D51]"></i>
                        <span>{{ __('portal.calendar_tab_public') }}</span>
                        <span id="badge-count-public" class="px-1.5 py-0.2 rounded-full text-[10px] bg-[#C86D51]/15 text-[#C86D51] font-mono font-bold">0</span>
                    </button>
                </div>

                <div class="text-xs text-[#7B8D65] flex items-center gap-2">
                    <span class="inline-block w-2 h-2 rounded-full bg-[#5A6B47]"></span>
                    <span>{{ __('portal.calendar_legend_ug') }}</span>
                    <span class="inline-block w-2 h-2 rounded-full bg-[#C86D51] ml-2"></span>
                    <span>{{ __('portal.calendar_legend_public') }}</span>
                </div>
            </div>

            <!-- Monthly Calendar View & Side-by-Side Events List -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-stretch">
                
                <!-- Left Column: Interactive Monthly Calendar (7 cols) -->
                <div class="lg:col-span-7 flex flex-col">
                    <div class="bg-white rounded-3xl p-6 sm:p-7 border border-[#D5CEBC] shadow-sm flex flex-col justify-between h-full">
                        <!-- Calendar Header & Month Navigation -->
                        <div class="flex items-center justify-between pb-5 mb-5 border-b border-[#EAE5D9]">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-2xl bg-[#5A6B47]/15 text-[#5A6B47] flex items-center justify-center font-bold">
                                    <i data-lucide="calendar-days" class="w-5 h-5"></i>
                                </div>
                                <div>
                                    <h3 id="calendar-month-year" class="font-heading font-bold text-lg text-[#2C3E2D]">
                                        <!-- Dynamic: e.g. ธันวาคม 2569 -->
                                    </h3>
                                    <p class="text-[11px] text-[#7B8D65]">{{ __('portal.calendar_hint_click') }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-1.5">
                                <button onclick="changeMonth(-1)" class="p-2 rounded-xl border border-[#D5CEBC] hover:bg-[#FAF8F2] text-[#4A3B32] hover:text-[#2C3E2D] transition shadow-2xs" title="{{ __('portal.calendar_prev_month') }}">
                                    <i data-lucide="chevron-left" class="w-4 h-4"></i>
                                </button>
                                <button onclick="goToCurrentMonth()" class="px-3 py-1.5 rounded-xl border border-[#D5CEBC] text-xs font-semibold text-[#5A6B47] hover:bg-[#5A6B47] hover:text-white transition shadow-2xs">
                                    {{ __('portal.calendar_this_month') }}
                                </button>
                                <button onclick="changeMonth(1)" class="p-2 rounded-xl border border-[#D5CEBC] hover:bg-[#FAF8F2] text-[#4A3B32] hover:text-[#2C3E2D] transition shadow-2xs" title="{{ __('portal.calendar_next_month') }}">
                                    <i data-lucide="chevron-right" class="w-4 h-4"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Days of Week Header -->
                        <div class="grid grid-cols-7 gap-1 text-center font-heading text-xs font-semibold mb-2">
                            <span class="text-[#C86D51] py-1.5">{{ $currentLang === 'en' ? 'Sun' : 'อา.' }}</span>
                            <span class="text-[#4A3B32] py-1.5">{{ $currentLang === 'en' ? 'Mon' : 'จ.' }}</span>
                            <span class="text-[#4A3B32] py-1.5">{{ $currentLang === 'en' ? 'Tue' : 'อ.' }}</span>
                            <span class="text-[#4A3B32] py-1.5">{{ $currentLang === 'en' ? 'Wed' : 'พ.' }}</span>
                            <span class="text-[#4A3B32] py-1.5">{{ $currentLang === 'en' ? 'Thu' : 'พฤ.' }}</span>
                            <span class="text-[#4A3B32] py-1.5">{{ $currentLang === 'en' ? 'Fri' : 'ศ.' }}</span>
                            <span class="text-[#5A6B47] py-1.5">{{ $currentLang === 'en' ? 'Sat' : 'ส.' }}</span>
                        </div>

                        <!-- Calendar Grid Cells -->
                        <div id="calendar-days-grid" class="grid grid-cols-7 gap-1.5 flex-grow">
                            <!-- Populated via JavaScript -->
                        </div>

                        <!-- Legend & Status -->
                        <div class="pt-4 mt-4 border-t border-[#EAE5D9] flex flex-wrap items-center justify-between gap-3 text-[11px] text-[#6B6357]">
                            <div class="flex flex-wrap items-center gap-3">
                                <span class="flex items-center gap-1.5">
                                    <span class="w-2.5 h-2.5 rounded-full bg-[#5A6B47]"></span>
                                    <span>{{ __('portal.calendar_legend_ug') }}</span>
                                </span>
                                <span class="flex items-center gap-1.5">
                                    <span class="w-2.5 h-2.5 rounded-full bg-[#C86D51]"></span>
                                    <span>{{ __('portal.calendar_legend_public') }}</span>
                                </span>
                                <span class="flex items-center gap-1.5">
                                    <span class="w-2.5 h-2.5 rounded-full border-2 border-[#2C3E2D]"></span>
                                    <span>{{ __('portal.calendar_legend_today') }}</span>
                                </span>
                            </div>
                            <span id="calendar-month-event-count" class="font-mono text-[#5A6B47] font-semibold">
                                <!-- e.g. 5 projects this month -->
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Scrollable Events List (5 cols, exact matching height) -->
                <div class="lg:col-span-5 flex flex-col">
                    <div class="bg-white rounded-3xl p-6 sm:p-7 border border-[#D5CEBC] shadow-sm flex flex-col h-full max-h-[560px]">
                        <!-- List Header -->
                        <div class="flex items-center justify-between pb-4 mb-4 border-b border-[#EAE5D9]">
                            <div>
                                <h3 id="events-list-title" class="font-heading font-bold text-base text-[#2C3E2D]">
                                    {{ __('portal.calendar_side_title') }}
                                </h3>
                                <p id="events-list-subtitle" class="text-[11px] text-[#7B8D65]">
                                    {{ __('portal.calendar_side_desc') }}
                                </p>
                            </div>
                            <button id="reset-filter-btn" onclick="filterBySelectedDay(null)" class="hidden text-[11px] text-[#C86D51] hover:underline font-medium flex items-center gap-1">
                                <i data-lucide="rotate-ccw" class="w-3 h-3"></i> {{ __('portal.calendar_view_all_month') }}
                            </button>
                        </div>

                        <!-- Scrollable Cards Container (styled custom scrollbar) -->
                        <div id="calendar-events-container" class="space-y-3.5 overflow-y-auto pr-1 flex-grow divide-y divide-[#F2EFE7]">
                            <!-- Populated via JavaScript -->
                        </div>

                        <!-- Footer Link -->
                        <div class="pt-4 mt-2 border-t border-[#EAE5D9] flex justify-between items-center text-xs">
                            <span class="text-[#8C8275]">{{ __('portal.calendar_contact_info') }}</span>
                            <a href="{{ route('ug.register') }}" class="font-semibold text-[#5A6B47] hover:text-[#2C3E2D] flex items-center gap-1">
                                <span>{{ __('portal.calendar_reg_page') }}</span>
                                <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                            </a>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </section>

    <!-- News & Activities Section -->
    <section class="py-16 bg-[#F7F5EE] border-t border-[#E3DEC9]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-8">
                <div>
                    <span class="text-xs font-bold text-[#5A6B47] uppercase tracking-widest font-mono flex items-center gap-1.5">
                        <i data-lucide="bell" class="w-4 h-4"></i> {{ __('portal.news_badge') }}
                    </span>
                    <h2 class="text-2xl font-heading font-bold text-[#2C3E2D] mt-1">{{ __('portal.news_title') }}</h2>
                </div>
                <a href="{{ route('news.index') }}" class="text-xs font-semibold text-[#5A6B47] hover:text-[#2C3E2D] flex items-center gap-1 group bg-white border border-[#D5CEBC] px-3.5 py-2 rounded-xl shadow-sm hover:border-[#5A6B47] transition">
                    <span>{{ __('portal.news_view_all') }}</span>
                    <i data-lucide="arrow-right" class="w-3.5 h-3.5 group-hover:translate-x-0.5 transition"></i>
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @forelse ($recentNews as $news)
                    <div class="bg-white rounded-2xl overflow-hidden border border-[#E3DEC9] hover:border-[#5A6B47] transition shadow-sm flex flex-col justify-between group">
                        @if ($news->cover_image)
                            <div class="aspect-square w-full overflow-hidden bg-stone-100">
                                <img src="{{ $news->cover_image }}" alt="{{ $news->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                            </div>
                        @else
                            <div class="aspect-square w-full bg-[#FAF8F2] flex items-center justify-center text-[#D5CEBC] border-b border-[#E3DEC9]">
                                <i data-lucide="image" class="w-16 h-16 stroke-1"></i>
                            </div>
                        @endif
                        <div class="p-6 flex-grow flex flex-col justify-between">
                            <div>
                                <div class="flex items-center justify-between text-xs text-[#8C8275] mb-2 font-mono">
                                    <span class="flex items-center gap-1 truncate max-w-[65%]">
                                        <i data-lucide="building" class="w-3 h-3 text-[#5A6B47] shrink-0"></i> 
                                        <span class="truncate">{{ $currentLang === 'en' && !empty($news->organizationUnit->name_en) ? $news->organizationUnit->name_en : ($news->organizationUnit->name_th ?? __('portal.university_name')) }}</span>
                                    </span>
                                    <span class="flex items-center gap-1 shrink-0">
                                        <i data-lucide="calendar" class="w-3 h-3"></i> 
                                        {{ substr($news->published_at ?? $news->created_at, 0, 10) }}
                                    </span>
                                </div>
                                <h3 class="font-heading font-bold text-[#2C3E2D] text-base mb-2 group-hover:text-[#C86D51] transition line-clamp-2">
                                    <a href="{{ route('news.detail', $news->id) }}">
                                        {{ $news->localized_title }}
                                    </a>
                                </h3>
                                <p class="text-xs text-[#6B6357] line-clamp-3 leading-relaxed mb-4">
                                    {{ strip_tags($news->localized_content) }}
                                </p>
                            </div>
                            <div class="pt-3 border-t border-[#F2EFE7] flex items-center justify-between text-xs">
                                <span class="text-[11px] font-semibold text-[#8C8275] flex items-center gap-1 font-mono">
                                    <i data-lucide="eye" class="w-3 h-3 text-[#A3B88C]"></i>
                                    {{ number_format($news->views) }} {{ __('portal.news_views') }}
                                </span>
                                <a href="{{ route('news.detail', $news->id) }}" class="text-[#5A6B47] font-semibold flex items-center gap-1 group-hover:text-[#C86D51] transition">
                                    <span>{{ __('portal.news_read_more') }}</span>
                                    <i data-lucide="chevron-right" class="w-3.5 h-3.5"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-12 text-center text-[#8C8275] bg-white rounded-2xl border border-dashed border-[#D5CEBC]">
                        <p class="text-xs">{{ __('portal.news_empty') }}</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Footer (Organic Earth Forest) / Contact Section -->
    <footer id="contact" class="bg-[#243325] text-[#D5CEBC] text-xs py-12 border-t border-[#1B271C]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-center gap-6 text-center md:text-left">
                <div>
                    <div class="flex items-center justify-center md:justify-start gap-3 mb-2">
                        <img src="{{ asset('images/mcu-logo.png') }}" alt="MCU Logo" class="w-8 h-8 object-contain">
                        <span class="font-heading font-bold text-white text-base">{{ __('portal.footer_brand') }}</span>
                    </div>
                    <p class="text-[#A3B88C]">มหาวิทยาลัยมหาจุฬาลงกรณราชวิทยาลัย 79 หมู่ 1 ต.ลำไทร อ.วังน้อย จ.พระนครศรีอยุธยา 13170</p>
                    <p class="text-[#8C8275] mt-1">
                        สถาบันวิปัสสนาธุระ มหาวิทยาลัยมหาจุฬาลงกรณราชวิทยาลัย &bull; 
                        <a href="{{ route('contact') }}" class="text-[#A3B88C] hover:text-white underline">ดูช่องทางติดต่อสอบถาม & แผนที่</a>
                    </p>
                </div>
                <div class="flex flex-col items-center md:items-end gap-2.5">
                    @if (Session::has('admin_user'))
                        <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-white/10 hover:bg-white/20 text-white font-medium text-xs border border-white/15 transition shadow-sm">
                            <i data-lucide="layout-dashboard" class="w-4 h-4 text-[#A3B88C]"></i>
                            <span>{{ __('portal.nav_admin_panel') }}</span>
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-[#2C3E2D] hover:bg-[#385039] text-[#EAE5D9] hover:text-white font-medium text-xs border border-[#3E5540] transition shadow-sm group">
                            <i data-lucide="shield-alert" class="w-3.5 h-3.5 text-[#A3B88C] group-hover:text-white transition"></i>
                            <span>{{ __('portal.nav_admin_login') }}</span>
                        </a>
                    @endif
                    <div class="text-[10px] text-[#7A7367] font-mono">
                        {{ __('portal.university_name') }} &bull; VPSMCU
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <script>
        lucide.createIcons();

        const currentLocale = '{{ app()->getLocale() }}';

        // Raw Data from Controller
        const rawBatches = @json($openBatches);
        const rawPublicEvents = @json($openPublicEvents);

        // Standardize both UG Batches and Public Events into unified event objects
        const ugEvents = rawBatches.map(b => ({
            id: 'ug-' + b.id,
            raw_id: b.id,
            type: 'UG',
            type_label: currentLocale === 'en' ? 'Undergraduate (10 Days)' : 'ปริญญาตรี (10 วัน)',
            title: (currentLocale === 'en' && b.title_en) ? b.title_en : b.title,
            start_date: b.start_date,
            end_date: b.end_date || b.start_date,
            location: (currentLocale === 'en' && b.location_en) ? b.location_en : (b.location || (currentLocale === 'en' ? 'MCU Meditation Center' : 'ศูนย์วิปัสสนากรรมฐาน มจร')),
            max_quota: b.max_quota,
            reg_count: b.registrations ? b.registrations.length : 0,
            academic_year: b.academic_year,
            org_name: b.organization_unit ? ((currentLocale === 'en' && b.organization_unit.name_en) ? b.organization_unit.name_en : b.organization_unit.name_th) : (currentLocale === 'en' ? 'MCU Campus' : 'ส่วนงาน มจร'),
            org_code: b.organization_unit ? (b.organization_unit.code_provincial || b.organization_unit.code) : 'MCU',
            register_url: "{{ route('ug.register') }}"
        }));

        const publicEvents = rawPublicEvents.map(p => ({
            id: 'pub-' + p.id,
            raw_id: p.id,
            type: 'PUBLIC',
            type_label: currentLocale === 'en' ? 'General Public' : 'ภาคประชาชน',
            title: (currentLocale === 'en' && p.title_en) ? p.title_en : p.title,
            start_date: p.start_date,
            end_date: p.end_date || p.start_date,
            location: (currentLocale === 'en' && p.location_name_en) ? p.location_name_en : (p.location_name || (currentLocale === 'en' ? 'MCU Meditation Center' : 'ศูนย์วิปัสสนากรรมฐาน มจร')),
            max_quota: p.max_quota,
            reg_count: p.registrations ? p.registrations.length : (p.confirmed_count || 0),
            academic_year: null,
            org_name: p.organization_unit ? ((currentLocale === 'en' && p.organization_unit.name_en) ? p.organization_unit.name_en : p.organization_unit.name_th) : (currentLocale === 'en' ? 'MCU' : 'มจร'),
            org_code: p.organization_unit ? (p.organization_unit.code_provincial || p.organization_unit.code) : 'MCU',
            register_url: "{{ route('public.register') }}?event_id=" + p.id
        }));

        const allEvents = [...ugEvents, ...publicEvents];

        // Update Tab Badges Count
        document.getElementById('badge-count-all').textContent = allEvents.length;
        document.getElementById('badge-count-ug').textContent = ugEvents.length;
        document.getElementById('badge-count-public').textContent = publicEvents.length;

        let activeCategory = 'ALL'; // 'ALL', 'UG', 'PUBLIC'

        const thaiMonths = [
            'มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน',
            'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'
        ];
        const engMonths = [
            'January', 'February', 'March', 'April', 'May', 'June',
            'July', 'August', 'September', 'October', 'November', 'December'
        ];

        // Determine initial month: if any event exists, default to month of first event, else today
        let currentDate = new Date();
        if (allEvents.length > 0) {
            const firstDate = new Date(allEvents[0].start_date);
            if (!isNaN(firstDate.getTime())) {
                currentDate = firstDate;
            }
        }

        let selectedDay = null; // YYYY-MM-DD string or null

        function getFilteredEvents() {
            if (activeCategory === 'UG') return ugEvents;
            if (activeCategory === 'PUBLIC') return publicEvents;
            return allEvents;
        }

        function switchCategory(cat) {
            activeCategory = cat;
            selectedDay = null;

            // Update Tab UI
            const tabs = {
                'ALL': document.getElementById('tab-cat-ALL'),
                'UG': document.getElementById('tab-cat-UG'),
                'PUBLIC': document.getElementById('tab-cat-PUBLIC')
            };

            for (const [key, btn] of Object.entries(tabs)) {
                if (!btn) continue;
                if (key === cat) {
                    btn.className = "px-4 py-2 rounded-xl text-xs font-semibold transition flex items-center gap-1.5 bg-[#2C3E2D] text-white shadow-xs";
                } else {
                    btn.className = "px-4 py-2 rounded-xl text-xs font-semibold text-[#4A3B32] hover:text-[#2C3E2D] hover:bg-[#FAF8F2] transition flex items-center gap-1.5";
                }
            }

            renderCalendar();
        }

        function initCalendar() {
            renderCalendar();
        }

        function changeMonth(offset) {
            currentDate.setMonth(currentDate.getMonth() + offset);
            selectedDay = null;
            renderCalendar();
        }

        function goToCurrentMonth() {
            currentDate = new Date();
            selectedDay = null;
            renderCalendar();
        }

        function filterBySelectedDay(dateStr) {
            selectedDay = dateStr;
            renderCalendar();
        }

        function renderCalendar() {
            const year = currentDate.getFullYear();
            const month = currentDate.getMonth();

            if (currentLocale === 'en') {
                document.getElementById('calendar-month-year').textContent = `${engMonths[month]} ${year}`;
            } else {
                const thaiYear = year + 543;
                document.getElementById('calendar-month-year').textContent = `${thaiMonths[month]} ${thaiYear}`;
            }

            const firstDayIndex = new Date(year, month, 1).getDay();
            const totalDays = new Date(year, month + 1, 0).getDate();
            const prevMonthTotalDays = new Date(year, month, 0).getDate();

            const grid = document.getElementById('calendar-days-grid');
            grid.innerHTML = '';

            const today = new Date();
            const isCurrentMonth = today.getFullYear() === year && today.getMonth() === month;
            const todayDate = today.getDate();

            // 1. Previous month trailing days
            for (let i = firstDayIndex - 1; i >= 0; i--) {
                const dayNum = prevMonthTotalDays - i;
                const cell = document.createElement('div');
                cell.className = 'h-12 sm:h-14 p-1 rounded-xl bg-transparent text-[#D5CEBC] flex flex-col items-center justify-start text-xs opacity-50 select-none';
                cell.innerHTML = `<span>${dayNum}</span>`;
                grid.appendChild(cell);
            }

            const activeEvents = getFilteredEvents();
            const monthEvents = [];

            // 2. Current month days
            for (let day = 1; day <= totalDays; day++) {
                const dateStr = `${year}-${String(month + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
                
                // Find events spanning across this date
                const dayEvents = activeEvents.filter(e => {
                    const start = e.start_date.substring(0, 10);
                    const end = (e.end_date || e.start_date).substring(0, 10);
                    return dateStr >= start && dateStr <= end;
                });

                dayEvents.forEach(e => {
                    if (!monthEvents.some(me => me.id === e.id)) {
                        monthEvents.push(e);
                    }
                });

                const hasEvents = dayEvents.length > 0;
                const eventCount = dayEvents.length;
                const isSelected = selectedDay === dateStr;
                const isToday = isCurrentMonth && day === todayDate;

                const hasUg = dayEvents.some(e => e.type === 'UG');
                const hasPublic = dayEvents.some(e => e.type === 'PUBLIC');

                const cell = document.createElement('button');
                cell.type = 'button';
                cell.onclick = () => filterBySelectedDay(isSelected ? null : dateStr);

                // Tooltip summarizing events for that day
                if (hasEvents) {
                    const tooltipText = dayEvents.map(e => `• [${e.type_label}] ${e.org_name}: ${e.title}`).join('\n');
                    cell.title = `${day} ${thaiMonths[month]} (${eventCount} โครงการ):\n${tooltipText}`;
                }

                let cellClasses = 'min-h-[56px] sm:min-h-[62px] p-1 rounded-2xl transition flex flex-col items-center justify-between text-xs relative group ';

                if (isSelected) {
                    cellClasses += 'bg-[#2C3E2D] text-white font-bold shadow-md ring-2 ring-[#2C3E2D]/50';
                } else if (hasEvents) {
                    cellClasses += 'bg-[#5A6B47]/10 hover:bg-[#5A6B47]/25 text-[#2C3E2D] font-bold border border-[#5A6B47]/25 hover:border-[#5A6B47]';
                } else if (isToday) {
                    cellClasses += 'bg-[#FAF8F2] text-[#5A6B47] font-bold border-2 border-[#2C3E2D] hover:bg-[#FAF8F2]';
                } else {
                    cellClasses += 'hover:bg-[#FAF8F2] text-[#4A3B32] border border-transparent';
                }

                // Render Dots with distinctive colors
                let dotsHtml = '';
                if (hasUg && hasPublic) {
                    dotsHtml = `
                        <div class="flex items-center gap-1 mb-0.5">
                            <span class="w-2 h-2 rounded-full ${isSelected ? 'bg-emerald-300' : 'bg-[#5A6B47]'}" title="ปริญญาตรี"></span>
                            <span class="w-2 h-2 rounded-full ${isSelected ? 'bg-orange-300' : 'bg-[#C86D51]'}" title="ภาคประชาชน"></span>
                        </div>
                    `;
                } else if (hasUg) {
                    dotsHtml = `<span class="w-2 h-2 rounded-full ${isSelected ? 'bg-white' : 'bg-[#5A6B47]'} shadow-2xs mb-0.5" title="ปริญญาตรี"></span>`;
                } else if (hasPublic) {
                    dotsHtml = `<span class="w-2 h-2 rounded-full ${isSelected ? 'bg-white' : 'bg-[#C86D51]'} shadow-2xs mb-0.5" title="ภาคประชาชน"></span>`;
                }

                cell.className = cellClasses;
                cell.innerHTML = `
                    <div class="flex items-center justify-between w-full px-1">
                        <span class="text-[12px] font-medium leading-none">${day}</span>
                        ${eventCount > 1 && !isSelected ? `<span class="text-[8px] font-mono text-[#7B8D65] font-normal sm:inline hidden">${eventCount}</span>` : ''}
                    </div>
                    <div class="flex items-center justify-center w-full mt-auto">
                        ${dotsHtml}
                    </div>
                `;
                grid.appendChild(cell);
            }

            // 3. Next month leading days (fill up grid to multiples of 7)
            const totalCellsRendered = firstDayIndex + totalDays;
            const remainingCells = (7 - (totalCellsRendered % 7)) % 7;
            for (let day = 1; day <= remainingCells; day++) {
                const cell = document.createElement('div');
                cell.className = 'min-h-[56px] sm:min-h-[62px] p-1 rounded-2xl bg-transparent text-[#D5CEBC] flex flex-col items-center justify-start text-xs opacity-40 select-none';
                cell.innerHTML = `<span>${day}</span>`;
                grid.appendChild(cell);
            }

            // Update month event counter
            document.getElementById('calendar-month-event-count').textContent = currentLocale === 'en' 
                ? `${monthEvents.length} {{ __('portal.calendar_month_projects') }}`
                : `${monthEvents.length} โครงการในเดือนนี้`;

            // Render Events in right list
            renderEventsList(monthEvents);
        }

        function renderEventsList(monthEvents) {
            const container = document.getElementById('calendar-events-container');
            const title = document.getElementById('events-list-title');
            const subtitle = document.getElementById('events-list-subtitle');
            const resetBtn = document.getElementById('reset-filter-btn');

            let displayEvents = [];
            const activeEvents = getFilteredEvents();

            if (selectedDay) {
                resetBtn.classList.remove('hidden');
                const [y, m, d] = selectedDay.split('-');
                let dateDisplay = '';
                if (currentLocale === 'en') {
                    dateDisplay = `${engMonths[parseInt(m) - 1]} ${parseInt(d)}, ${parseInt(y)}`;
                    title.textContent = `Projects on ${dateDisplay}`;
                } else {
                    dateDisplay = `${parseInt(d)} ${thaiMonths[parseInt(m) - 1]} ${parseInt(y) + 543}`;
                    title.textContent = `โครงการวันที่ ${dateDisplay}`;
                }
                
                displayEvents = activeEvents.filter(e => {
                    const start = e.start_date.substring(0, 10);
                    const end = (e.end_date || e.start_date).substring(0, 10);
                    return selectedDay >= start && selectedDay <= end;
                });
                subtitle.textContent = currentLocale === 'en'
                    ? `Found ${displayEvents.length} retreats on this date`
                    : `พบ ${displayEvents.length} โครงการที่กำลังดำเนินการในวันนี้`;
            } else {
                resetBtn.classList.add('hidden');
                title.textContent = currentLocale === 'en' ? `{{ __('portal.calendar_side_title') }}` : `รายการโครงการในเดือนนี้`;
                subtitle.textContent = currentLocale === 'en'
                    ? `Total ${monthEvents.length} retreats this month`
                    : `มีทั้งหมด ${monthEvents.length} โครงการ เลื่อนเพื่อดูรายละเอียด`;
                displayEvents = monthEvents;
            }

            if (displayEvents.length === 0) {
                container.innerHTML = `
                    <div class="py-12 text-center text-[#8C8275]">
                        <i data-lucide="calendar-x" class="w-10 h-10 mx-auto mb-2 text-[#D5CEBC]"></i>
                        <p class="font-medium text-xs text-[#4A3B32]">${currentLocale === 'en' ? '{{ __('portal.calendar_empty_day') }}' : 'ไม่พบโครงการปฏิบัติธรรมในวันที่เลือก'}</p>
                        <p class="text-[11px] text-[#8C8275] mt-1">${currentLocale === 'en' ? '{{ __('portal.calendar_empty_day_sub') }}' : 'คลิกเลือกวันที่มีจุดสี หรือกดปุ่ม "ดูทั้งเดือน"'}</p>
                    </div>
                `;
                lucide.createIcons();
                return;
            }

            let html = '';
            displayEvents.forEach(e => {
                const regCount = e.reg_count;
                const isFull = e.max_quota > 0 && regCount >= e.max_quota;
                const isUg = e.type === 'UG';

                const badgeBg = isUg ? 'bg-[#5A6B47]/15 text-[#3D523E] border-[#5A6B47]/30' : 'bg-[#C86D51]/15 text-[#A85238] border-[#C86D51]/30';
                const typeIcon = isUg ? 'graduation-cap' : 'users';

                let btnLabel = '';
                if (isFull) {
                    btnLabel = currentLocale === 'en' ? '{{ __('portal.calendar_full_badge') }}' : 'ดูรายละเอียด (ที่นั่งเต็ม)';
                } else if (isUg) {
                    btnLabel = currentLocale === 'en' ? '{{ __('portal.calendar_ug_register_btn') }}' : 'ลงทะเบียนนิสิต ป.ตรี';
                } else {
                    btnLabel = currentLocale === 'en' ? '{{ __('portal.calendar_public_register_btn') }}' : 'สมัครเข้าร่วม (ประชาชน)';
                }

                html += `
                    <div class="pt-3.5 first:pt-0 group">
                        <div class="p-3.5 rounded-2xl bg-[#FAF8F2]/70 hover:bg-[#FAF8F2] border border-[#EAE5D9] hover:border-[#5A6B47] transition">
                            <div class="flex items-center justify-between gap-2 mb-1.5">
                                <div class="flex items-center gap-1.5">
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-semibold border flex items-center gap-1 ${badgeBg}">
                                        <i data-lucide="${typeIcon}" class="w-3 h-3"></i>
                                        <span>${e.type_label}</span>
                                    </span>
                                    <span class="px-1.5 py-0.5 rounded text-[10px] font-mono text-[#6B6357] bg-white border border-[#D5CEBC]">
                                        ${e.org_code}
                                    </span>
                                </div>
                                <span class="text-[10px] font-mono ${isFull ? 'text-[#C86D51] font-bold' : 'text-[#7B8D65]'}">
                                    ${regCount} / ${e.max_quota} ${currentLocale === 'en' ? '{{ __('portal.calendar_seats') }}' : 'ที่นั่ง'}
                                </span>
                            </div>
                            <h4 class="font-heading font-bold text-xs text-[#2C3E2D] mb-1.5 leading-snug group-hover:text-[#C86D51] transition line-clamp-2">
                                ${e.title}
                            </h4>
                            <div class="text-[11px] text-[#6B6357] space-y-1 mb-3 font-sans">
                                <div class="flex items-center gap-1.5 truncate">
                                    <i data-lucide="building" class="w-3.5 h-3.5 text-[#5A6B47] shrink-0"></i>
                                    <span class="truncate">${e.org_name}</span>
                                </div>
                                <div class="flex items-center gap-1.5">
                                    <i data-lucide="calendar" class="w-3.5 h-3.5 text-[#5A6B47] shrink-0"></i>
                                    <span class="font-mono text-[#2C3E2D] font-medium">${e.start_date} &bull; ${e.end_date}</span>
                                </div>
                                <div class="flex items-center gap-1.5 truncate text-[#8C8275]">
                                    <i data-lucide="map-pin" class="w-3.5 h-3.5 text-[#C86D51] shrink-0"></i>
                                    <span class="truncate">${e.location}</span>
                                </div>
                            </div>
                            <div class="pt-2 border-t border-[#EAE5D9]/80 flex items-center justify-end">
                                <a href="${e.register_url}" class="px-3 py-1.5 rounded-lg text-[11px] font-semibold transition inline-flex items-center gap-1 ${isFull ? 'bg-[#C86D51] text-white' : (isUg ? 'bg-[#2C3E2D] hover:bg-[#5A6B47]' : 'bg-[#C86D51] hover:bg-[#A85238]')} text-white shadow-xs">
                                    <span>${btnLabel}</span>
                                    <i data-lucide="chevron-right" class="w-3 h-3"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                `;
            });

            container.innerHTML = html;
            lucide.createIcons();
        }

        // Initialize on DOM load
        document.addEventListener('DOMContentLoaded', initCalendar);
    </script>
</body>
</html>
