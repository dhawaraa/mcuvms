<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('portal.public_check_header_title') }} - VPSMCU</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@300;400;500;600;700&family=Prompt:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
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
    <nav class="bg-[#FAF8F2]/90 backdrop-blur-md border-b border-[#EAE5D9] sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <a href="{{ route('home') }}" class="flex items-center space-x-3">
                    <img src="{{ asset('images/mcu-logo.png') }}" alt="MCU Logo" class="w-10 h-10 object-contain drop-shadow-sm">
                    <div>
                        <div class="font-heading font-bold text-[#2C3E2D] leading-tight">VPSMCU</div>
                        <div class="text-xs text-[#7B8D65]">{{ __('portal.university_name') }}</div>
                    </div>
                </a>

                <!-- Module 3 Navigation Tabs: สมัครคอร์ส vs ตรวจสอบสถานะ (Active) -->
                <div class="hidden sm:flex items-center bg-[#EAE5D9]/80 p-1 rounded-2xl border border-[#D5CEBC]">
                    <a href="{{ route('public.register') }}" class="px-4 py-2 rounded-xl text-xs font-bold transition flex items-center gap-1.5 text-[#4A3B32] hover:text-[#2C3E2D] hover:bg-[#FAF8F2]">
                        <i data-lucide="user-plus" class="w-4 h-4 text-[#5A6B47]"></i>
                        <span>{{ __('portal.public_tab_register') }}</span>
                    </a>
                    <a href="{{ route('public.check') }}" class="px-4 py-2 rounded-xl text-xs font-bold transition flex items-center gap-1.5 bg-[#5A6B47] text-white shadow-sm">
                        <i data-lucide="search" class="w-4 h-4"></i>
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

                    <a href="{{ route('home') }}" class="text-[#4A3B32] hover:text-[#5A6B47] font-semibold text-[15px] flex items-center gap-1.5 transition">
                        <i data-lucide="arrow-left" class="w-4.5 h-4.5 text-[#5A6B47]"></i> <span class="hidden sm:inline">{{ __('portal.nav_back_home') }}</span>
                    </a>
                </div>
            </div>

            <!-- Mobile Sub-Navigation -->
            <div class="flex sm:hidden items-center justify-center pb-3 pt-1 border-t border-[#EAE5D9] gap-2">
                <a href="{{ route('public.register') }}" class="flex-1 text-center py-1.5 px-3 rounded-lg text-xs font-bold bg-white text-[#4A3B32] border border-[#D5CEBC]">
                    {{ __('portal.public_tab_register') }}
                </a>
                <a href="{{ route('public.check') }}" class="flex-1 text-center py-1.5 px-3 rounded-lg text-xs font-bold bg-[#5A6B47] text-white">
                    {{ __('portal.public_tab_check') }}
                </a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full flex-grow">
        
        <!-- Header Banner -->
        <div class="bg-gradient-to-r from-[#2C3E2D] via-[#3A4F3C] to-[#5A6B47] rounded-3xl p-6 md:p-8 text-white shadow-lg shadow-[#2C3E2D]/15 mb-8 border border-[#2C3E2D]/20 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <div class="inline-flex items-center gap-1.5 px-3 py-1 bg-white/15 backdrop-blur-sm rounded-full text-xs font-semibold uppercase tracking-wider mb-2 border border-white/20 text-[#FAF8F2]">
                    <i data-lucide="shield-check" class="w-3.5 h-3.5 text-[#EAE5D9]"></i>
                    <span>{{ __('portal.public_check_header_badge') }}</span>
                </div>
                <h1 class="text-2xl md:text-3xl font-heading font-bold mb-2">{{ __('portal.public_check_header_title') }}</h1>
                <p class="text-[#EAE5D9] text-sm leading-relaxed max-w-2xl">
                    {{ __('portal.public_check_header_desc') }}
                </p>
            </div>
            <div class="shrink-0">
                <a href="{{ route('public.register') }}" class="inline-flex items-center gap-2 bg-white text-[#2C3E2D] hover:bg-[#FAF8F2] px-5 py-3 rounded-xl font-medium text-sm transition shadow-lg">
                    <i data-lucide="user-plus" class="w-4 h-4 text-[#5A6B47]"></i>
                    <span>{{ __('portal.public_tab_register') }}</span>
                </a>
            </div>
        </div>

        <!-- Search Box (ค้นหาด้วยเบอร์โทรศัพท์ หรือรหัสการสมัคร) -->
        <div class="bg-white border border-[#E3DEC9] rounded-2xl p-6 shadow-sm mb-8">
            <form action="{{ route('public.check') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
                <div class="relative flex-grow">
                    <i data-lucide="phone" class="w-4 h-4 text-[#8C8275] absolute left-3.5 top-3.5"></i>
                    <input type="text" name="search" value="{{ $search }}" placeholder="{{ __('portal.public_check_search_ph') }}" class="w-full pl-10 pr-4 py-2.5 border border-[#D5CEBC] rounded-xl text-sm focus:ring-2 focus:ring-[#5A6B47] font-mono bg-[#FAF8F2] text-[#2C3E2D]">
                </div>
                <button type="submit" class="bg-[#2C3E2D] hover:bg-[#3D523E] text-white font-medium px-6 py-2.5 rounded-xl text-sm transition flex items-center justify-center gap-2 shadow-sm">
                    <i data-lucide="search" class="w-4 h-4 text-[#A3B88C]"></i>
                    <span>{{ __('portal.public_check_btn_search') }}</span>
                </button>
            </form>
            <div class="text-xs text-[#8C8275] mt-2.5 flex items-center gap-1.5">
                <i data-lucide="lightbulb" class="w-3.5 h-3.5 text-[#C86D51]"></i>
                <span>{{ __('portal.public_check_sample_hint') }} <a href="{{ route('public.check', ['search' => '0818889999']) }}" class="text-[#C86D51] underline font-mono">0818889999</a> หรือ <a href="{{ route('public.check', ['search' => 'PUB-20261023-0001']) }}" class="text-[#C86D51] underline font-mono">PUB-20261023-0001</a></span>
            </div>
        </div>

        @if ($search)
            @if ($registrations->count() > 0)
                @php
                    $firstReg = $registrations->first();
                @endphp
                <!-- Applicant Profile Card -->
                <div class="bg-white border border-[#E3DEC9] rounded-2xl p-6 shadow-sm mb-8">
                    <div class="flex items-center gap-2 border-b border-[#E3DEC9] pb-3 mb-4">
                        <i data-lucide="user" class="w-5 h-5 text-[#5A6B47]"></i>
                        <h2 class="text-base font-heading font-bold text-[#2C3E2D]">{{ __('portal.public_check_profile_title') }}</h2>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="bg-[#FAF8F2] p-4 rounded-xl border border-[#EAE5D9]">
                            <div class="text-[11px] text-[#7B8D65]">ชื่อ-นามสกุล ผู้สมัคร</div>
                            <div class="text-base font-bold text-[#2C3E2D]">{{ $firstReg->full_name }}</div>
                            <div class="text-xs text-[#6B6357] mt-0.5">
                                {{ $firstReg->applicant_type === 'STUDENT' ? 'นิสิต มจร' : 'ประชาชนทั่วไป' }} 
                                &bull; เพศ {{ $firstReg->gender === 'FEMALE' ? 'หญิง' : ($firstReg->gender === 'MALE' ? 'ชาย' : '-') }}
                            </div>
                            @if ($firstReg->applicant_type === 'STUDENT')
                                <div class="mt-2 pt-2 border-t border-[#EAE5D9] text-[11px] space-y-0.5 text-[#5A6B47]">
                                    <div>รหัสนิสิต: <strong class="font-mono text-[#2C3E2D]">{{ $firstReg->student_id ?: '-' }}</strong></div>
                                    @if ($firstReg->degree_level || $firstReg->faculty)
                                        <div>ระดับ: {{ $firstReg->degree_level ?: '-' }} &bull; คณะ: {{ $firstReg->faculty ?: '-' }}</div>
                                    @endif
                                    @if ($firstReg->program_name)
                                        <div>หลักสูตร: {{ $firstReg->program_name }}</div>
                                    @endif
                                    @if ($firstReg->organizationUnit)
                                        <div class="text-[#7B8D65]">สังกัด: {{ $firstReg->organizationUnit->name_th }}</div>
                                    @endif
                                </div>
                            @endif
                        </div>

                        <div class="bg-[#FAF8F2] p-4 rounded-xl border border-[#EAE5D9]">
                            <div class="text-[11px] text-[#7B8D65]">เบอร์โทรศัพท์ติดต่อ</div>
                            <div class="text-base font-mono font-bold text-[#2C3E2D]">{{ $firstReg->phone }}</div>
                            <div class="text-xs text-[#6B6357] mt-0.5">
                                จังหวัด: {{ $firstReg->province ?? '-' }}
                            </div>
                        </div>

                        <div class="bg-[#FAF8F2] p-4 rounded-xl border border-[#EAE5D9]">
                            <div class="text-[11px] text-[#7B8D65]">ประเภทอาหาร / ความต้องการพิเศษ</div>
                            <div class="text-sm font-semibold text-[#C86D51]">{{ $firstReg->dietary_restriction ?? 'อาหารทั่วไป' }}</div>
                            <div class="text-xs text-[#6B6357] mt-0.5">
                                โรคประจำตัว: {{ $firstReg->congenital_disease ?? 'ไม่มี' }}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Registration History Table -->
                <div class="bg-white border border-[#E3DEC9] rounded-2xl p-6 shadow-sm mb-8">
                    <div class="flex items-center justify-between border-b border-[#E3DEC9] pb-3 mb-4">
                        <div class="flex items-center gap-2">
                            <i data-lucide="clipboard-check" class="w-5 h-5 text-[#5A6B47]"></i>
                            <h2 class="text-base font-heading font-bold text-[#2C3E2D]">{{ __('portal.public_check_courses_title') }}</h2>
                        </div>
                        <span class="text-xs font-mono px-2.5 py-1 rounded-full bg-[#FAF8F2] border border-[#EAE5D9] text-[#7B8D65]">
                            {{ $registrations->count() }} {{ __('portal.grad_records_unit') }}
                        </span>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="border-b border-[#EAE5D9] text-[11px] font-semibold text-[#7B8D65] uppercase tracking-wider bg-[#FAF8F2]">
                                    <th class="py-3 px-4">{{ __('portal.public_check_th_reg_no') }}</th>
                                    <th class="py-3 px-4">{{ __('portal.public_check_th_course') }}</th>
                                    <th class="py-3 px-4">{{ __('portal.public_check_th_dates') }}</th>
                                    <th class="py-3 px-4 text-center">{{ __('portal.public_check_th_queue') }}</th>
                                    <th class="py-3 px-4">{{ __('portal.public_check_th_status') }}</th>
                                    <th class="py-3 px-4 text-center">{{ __('portal.public_check_th_action') }}</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-[#EAE5D9] text-xs">
                                @foreach ($registrations as $reg)
                                    <tr class="hover:bg-[#FAF8F2]/60 transition">
                                        <td class="py-3.5 px-4 font-mono font-bold text-[#2C3E2D]">
                                            {{ $reg->registration_no }}
                                            <div class="text-[10px] text-[#8C8275] font-normal">
                                                {{ $reg->registered_at ? date('d/m/Y H:i', strtotime($reg->registered_at)) : '-' }}
                                            </div>
                                        </td>
                                        <td class="py-3.5 px-4">
                                            <div class="font-medium text-[#2C3E2D]">
                                                {{ $reg->event->title ?? '-' }}
                                            </div>
                                            <div class="text-[11px] text-[#7B8D65]">
                                                {{ $reg->event->location ?? ($reg->event->organizationUnit->name_th ?? '') }}
                                            </div>
                                        </td>
                                        <td class="py-3.5 px-4 whitespace-nowrap text-[#4A3B32]">
                                            @if ($reg->event && $reg->event->start_date)
                                                {{ date('d/m/Y', strtotime($reg->event->start_date)) }} - {{ date('d/m/Y', strtotime($reg->event->end_date)) }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td class="py-3.5 px-4 text-center font-mono font-bold text-[#5A6B47]">
                                            #{{ $reg->queue_no ?? '-' }}
                                        </td>
                                        <td class="py-3.5 px-4 whitespace-nowrap">
                                            @if ($reg->status === 'CONFIRMED')
                                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-semibold bg-[#E9EFE2] text-[#3D523E] border border-[#CADBC0]">
                                                    <i data-lucide="check-circle" class="w-3.5 h-3.5 text-[#5A6B47]"></i>
                                                    {{ __('portal.public_status_confirmed') }}
                                                </span>
                                            @elseif ($reg->status === 'WAITING_LIST')
                                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-semibold bg-amber-50 text-amber-800 border border-amber-200">
                                                    <i data-lucide="hourglass" class="w-3.5 h-3.5 text-amber-600"></i>
                                                    {{ __('portal.public_status_waiting') }}
                                                </span>
                                            @elseif ($reg->status === 'REJECTED')
                                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-semibold bg-red-50 text-red-700 border border-red-200">
                                                    <i data-lucide="x-circle" class="w-3.5 h-3.5 text-red-600"></i>
                                                    {{ __('portal.public_status_rejected') }}
                                                </span>
                                            @else
                                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-semibold bg-blue-50 text-blue-700 border border-blue-200">
                                                    <i data-lucide="clock" class="w-3.5 h-3.5 text-blue-600"></i>
                                                    {{ __('portal.public_status_pending') }}
                                                </span>
                                            @endif
                                        </td>
                                        <td class="py-3.5 px-4 text-center whitespace-nowrap">
                                            <button type="button" onclick="openSlipModal('{{ $reg->registration_no }}', '{{ $reg->full_name }}', '{{ $reg->event->title ?? '' }}', '{{ $reg->queue_no }}', '{{ $reg->status }}', '{{ $reg->dietary_restriction }}')" class="bg-[#FAF8F2] hover:bg-[#EAE5D9] text-[#2C3E2D] border border-[#D5CEBC] px-3 py-1.5 rounded-lg text-xs font-medium transition flex items-center gap-1.5 mx-auto shadow-sm">
                                                <i data-lucide="printer" class="w-3.5 h-3.5 text-[#5A6B47]"></i>
                                                <span>{{ __('portal.public_btn_print_slip') }}</span>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @else
                <!-- No Result Found Card -->
                <div class="text-center py-10 bg-white rounded-2xl border border-[#E3DEC9] p-8 shadow-sm">
                    <i data-lucide="phone-missed" class="w-12 h-12 text-[#8C8275] mx-auto mb-3"></i>
                    <h3 class="text-base font-heading font-bold text-[#2C3E2D]">{{ __('portal.public_check_no_result') }}</h3>
                    <p class="text-xs text-[#8C8275] mt-1 max-w-md mx-auto">
                        กรุณาตรวจสอบหมายเลขโทรศัพท์ (ตัวเลข 10 หลักโดยไม่ต้องมีเครื่องหมายขีด) หรือเลือกลงทะเบียนสมัครคอร์สใหม่
                    </p>
                    <a href="{{ route('public.register') }}" class="mt-4 inline-flex items-center gap-1.5 bg-[#5A6B47] hover:bg-[#2C3E2D] text-white px-5 py-2.5 rounded-xl text-xs font-semibold shadow-sm transition">
                        <i data-lucide="user-plus" class="w-3.5 h-3.5"></i>
                        <span>{{ __('portal.public_tab_register') }}</span>
                    </a>
                </div>
            @endif
        @else
            <!-- Initial Instruction Card -->
            <div class="bg-white border border-[#E3DEC9] rounded-2xl p-8 text-center shadow-sm">
                <div class="w-16 h-16 bg-[#FAF8F2] text-[#5A6B47] rounded-full flex items-center justify-center mx-auto mb-4 border border-[#EAE5D9]">
                    <i data-lucide="search" class="w-8 h-8"></i>
                </div>
                <h3 class="text-lg font-heading font-bold text-[#2C3E2D] mb-1">กรอกเบอร์โทรศัพท์เพื่อตรวจสอบสถานะ</h3>
                <p class="text-xs text-[#6B6357] max-w-md mx-auto leading-relaxed">
                    ค้นหาด้วยเบอร์โทรศัพท์มือถือ (เช่น 0818889999) หรือรหัสใบสมัคร เพื่อดูผลการอนุมัติสิทธิ์ ลำดับคิว และพิมพ์ใบยืนยันการเข้าร่วมโครงการ
                </p>
            </div>
        @endif

    </main>

    <!-- Slip Modal -->
    <div id="slipModal" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 flex items-center justify-center p-4 hidden">
        <div class="bg-white rounded-3xl max-w-md w-full p-6 text-left shadow-2xl border border-[#EAE5D9] relative animate-fade-in" id="printArea">
            <button type="button" onclick="closeSlipModal()" class="absolute right-4 top-4 text-[#8C8275] hover:text-[#2C3E2D] transition p-1 rounded-full bg-[#FAF8F2]">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
            
            <div class="text-center pb-4 border-b border-[#EAE5D9]">
                <img src="{{ asset('images/mcu-logo.png') }}" alt="MCU Logo" class="w-12 h-12 mx-auto mb-2 object-contain">
                <h3 class="text-base font-heading font-bold text-[#2C3E2D]">ใบยืนยันการสมัครปฏิบัติธรรม มจร</h3>
                <p class="text-xs text-[#7B8D65]">โครงการคอร์สวิปัสสนากรรมฐานสำหรับประชาชน</p>
            </div>

            <div class="my-4 space-y-2.5 text-xs">
                <div class="flex justify-between py-1 border-b border-[#FAF8F2]">
                    <span class="text-[#7B8D65]">รหัสการสมัคร:</span>
                    <strong class="font-mono text-[#2C3E2D]" id="modalRegNo">-</strong>
                </div>
                <div class="flex justify-between py-1 border-b border-[#FAF8F2]">
                    <span class="text-[#7B8D65]">ชื่อ-นามสกุล:</span>
                    <strong class="text-[#2C3E2D]" id="modalName">-</strong>
                </div>
                <div class="flex justify-between py-1 border-b border-[#FAF8F2]">
                    <span class="text-[#7B8D65]">คอร์สที่สมัคร:</span>
                    <strong class="text-[#2C3E2D] text-right" id="modalCourse">-</strong>
                </div>
                <div class="flex justify-between py-1 border-b border-[#FAF8F2]">
                    <span class="text-[#7B8D65]">ลำดับคิว / ลำดับที่:</span>
                    <strong class="font-mono text-[#5A6B47] text-sm" id="modalQueue">-</strong>
                </div>
                <div class="flex justify-between py-1 border-b border-[#FAF8F2]">
                    <span class="text-[#7B8D65]">สถานะ:</span>
                    <span id="modalStatus">-</span>
                </div>
                <div class="flex justify-between py-1">
                    <span class="text-[#7B8D65]">ประเภทอาหาร:</span>
                    <span id="modalFood" class="text-[#4A3B32]">-</span>
                </div>
            </div>

            <div class="p-3 bg-[#FAF8F2] rounded-xl border border-[#EAE5D9] text-[11px] text-[#6B6357] leading-relaxed">
                กรุณานำเอกสารฉบับนี้ หรือภาพถ่ายหน้าจอ แสดงต่อเจ้าหน้าที่ในวันเปิดโครงการเพื่อรายงานตัวเข้าปฏิบัติธรรม
            </div>

            <div class="flex items-center gap-2 mt-5">
                <button type="button" onclick="window.print()" class="flex-1 bg-[#5A6B47] hover:bg-[#2C3E2D] text-white text-xs font-semibold py-2.5 px-4 rounded-xl shadow-sm transition flex items-center justify-center gap-1.5">
                    <i data-lucide="printer" class="w-4 h-4"></i>
                    <span>พิมพ์ใบสมัคร</span>
                </button>
                <button type="button" onclick="closeSlipModal()" class="bg-[#FAF8F2] hover:bg-[#EAE5D9] text-[#4A3B32] text-xs font-semibold py-2.5 px-4 rounded-xl border border-[#D5CEBC] transition">
                    ปิด
                </button>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-[#FAF8F2] border-t border-[#E3DEC9] py-6 text-center text-xs text-[#8C8275]">
        {{ __('portal.footer_brand') }}
    </footer>

    <script>
        function openSlipModal(regNo, name, course, queue, status, food) {
            document.getElementById('modalRegNo').textContent = regNo;
            document.getElementById('modalName').textContent = name;
            document.getElementById('modalCourse').textContent = course;
            document.getElementById('modalQueue').textContent = '#' + queue;
            document.getElementById('modalFood').textContent = food || 'อาหารทั่วไป';
            
            const statusEl = document.getElementById('modalStatus');
            if (status === 'CONFIRMED') {
                statusEl.innerHTML = '<strong class="text-emerald-700">อนุมัติสิทธิ์ (Confirmed)</strong>';
            } else if (status === 'WAITING_LIST') {
                statusEl.innerHTML = '<strong class="text-amber-700">รายชื่อสำรอง (Waiting List)</strong>';
            } else if (status === 'REJECTED') {
                statusEl.innerHTML = '<strong class="text-red-700">ไม่อนุมัติ (Rejected)</strong>';
            } else {
                statusEl.innerHTML = '<strong class="text-blue-700">รอตรวจสอบ (Pending)</strong>';
            }

            document.getElementById('slipModal').classList.remove('hidden');
        }

        function closeSlipModal() {
            document.getElementById('slipModal').classList.add('hidden');
        }

        lucide.createIcons();
    </script>
</body>
</html>
