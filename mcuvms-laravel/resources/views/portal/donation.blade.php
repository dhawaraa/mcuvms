@php
    $currentRoute = Route::currentRouteName();
    $bankName = $settings['donation_bank_name'] ?? 'ธนาคารทหารไทยธนชาต (ttb)';
    $accName = $settings['donation_account_name'] ?? 'เพื่อพัฒนาสถาบันวิปัสสนาธุระ มหาวิทยาลัยมหาจุฬาลงกรณราชวิทยาลัย';
    $accNum = $settings['donation_account_number'] ?? '231-2-93605-3';
    $promptpay = $settings['donation_promptpay'] ?? '0994000159451';
    $infoNotes = $settings['donation_info_notes'] ?? 'การบริจาคเพื่อสนับสนุนการศึกษาและปฏิบัติวิปัสสนากรรมฐาน สามารถนำไปลดหย่อนภาษีได้ตามที่กฎหมายกำหนด โดยมหาวิทยาลัยมหาจุฬาลงกรณราชวิทยาลัยจะออกใบเสร็จรับเงิน/ใบอนุโมทนาบัตร และเชื่อมโยงข้อมูลระบบ e-Donation ของกรมสรรพากร';
@endphp
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('portal.nav_donation') }} | VPSMCU {{ __('portal.system_title') }} {{ __('portal.mcu_short') }}</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@300;400;500;600;700&family=Prompt:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Lucide Icons -->
    <script src="/assets/js/lucide.min.js"></script>

    <!-- Tailwind CSS CDN -->
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
            background: rgba(255, 255, 255, 0.90);
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

    <!-- Top Announcement Bar (Deep Forest) -->
    <div class="bg-[#243325] text-[#D5CEBC] text-xs py-2 px-4 border-b border-[#1E2B1F]">
        <div class="max-w-7xl mx-auto flex flex-col sm:flex-row justify-between items-center gap-1 font-medium">
            <div class="flex items-center space-x-2">
                <span class="inline-block w-2 h-2 rounded-full bg-[#7B8D65]"></span>
                <span class="text-[#EAE5D9]">{{ __('portal.top_announcement') }}</span>
            </div>
            <div class="flex items-center space-x-4 text-[#D8D2C2] text-[11px]">
                <span class="flex items-center gap-1.5"><i data-lucide="shield-check" class="w-3.5 h-3.5 text-[#A3B88C]"></i> {{ __('portal.institute_name') }}</span>
            </div>
        </div>
    </div>

    <!-- Main Navigation Header -->
    <header class="sticky top-0 z-50 bg-[#FAF8F2]/95 backdrop-blur-xl border-b border-[#E3DEC9] shadow-xs transition">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                
                <!-- Logo & Brand (Matching Reference) -->
                <div class="flex items-center space-x-3.5">
                    <a href="{{ route('home') }}" class="shrink-0 flex items-center">
                        <img src="{{ asset('images/mcu-logo.png') }}" alt="MCU Logo" class="w-12 h-12 object-contain drop-shadow-sm hover:scale-105 transition">
                    </a>
                    <div>
                        <a href="{{ route('home') }}" class="font-heading font-extrabold text-xl text-[#2C3E2D] tracking-tight leading-tight flex items-center gap-2">
                            VPSMCU
                            <span class="text-[10px] font-semibold px-2 py-0.5 rounded-full bg-[#EAE5D9] text-[#4A3B32] border border-[#D5CEBC]">{{ __('portal.mcu_short') }}</span>
                        </a>
                        <p class="text-xs text-[#6B6357] font-medium">{{ __('portal.system_title') }}</p>
                    </div>
                </div>

                <!-- Nav Links: ปฏิทิน (Dropdown), ตรวจสอบวัน, ยื่นคำร้อง, ฐานข้อมูล, ติดต่อ, ร่วมบริจาค -->
                <nav class="hidden xl:flex items-center space-x-6 text-[15px] font-semibold text-[#4A3B32]">
                    <!-- Schedule Dropdown Menu -->
                    <div class="relative group py-2">
                        <a href="{{ route('home') }}#calendar" class="hover:text-[#5A6B47] transition flex items-center gap-1.5 focus:outline-none whitespace-nowrap py-1">
                            <i data-lucide="calendar" class="w-4 h-4 text-[#4A3B32]"></i>
                            <span>{{ __('portal.nav_calendar') }}</span>
                            <i data-lucide="chevron-down" class="w-3.5 h-3.5 text-[#8C8275] group-hover:rotate-180 transition-transform duration-200"></i>
                        </a>
                        <!-- Dropdown Panel -->
                        <div class="absolute left-0 top-full pt-2 w-64 hidden group-hover:block z-50 transition-all">
                            <div class="bg-white/95 backdrop-blur-md border border-[#D5CEBC] rounded-2xl shadow-xl p-2 space-y-1">
                                <a href="{{ route('home') }}#calendar" class="flex items-center gap-3 px-3 py-2 rounded-xl text-sm text-[#2C3E2D] hover:bg-[#FAF8F2] transition">
                                    <span class="w-8 h-8 rounded-lg bg-[#5A6B47]/10 flex items-center justify-center text-[#5A6B47] shrink-0">
                                        <i data-lucide="calendar-range" class="w-4 h-4"></i>
                                    </span>
                                    <div>
                                        <div class="font-semibold text-sm">{{ __('portal.nav_all_schedules') }}</div>
                                        <div class="text-xs text-[#7B8D65]">{{ __('portal.nav_all_schedules_desc') }}</div>
                                    </div>
                                </a>
                                <a href="{{ route('home') }}#calendar" class="flex items-center gap-3 px-3 py-2 rounded-xl text-sm text-[#2C3E2D] hover:bg-[#FAF8F2] transition">
                                    <span class="w-8 h-8 rounded-lg bg-[#5A6B47]/15 flex items-center justify-center text-[#5A6B47] shrink-0">
                                        <i data-lucide="graduation-cap" class="w-4 h-4"></i>
                                    </span>
                                    <div>
                                        <div class="font-semibold text-sm text-[#5A6B47]">{{ __('portal.nav_ug_schedules') }}</div>
                                        <div class="text-xs text-[#7B8D65]">{{ __('portal.nav_ug_schedules_desc') }}</div>
                                    </div>
                                </a>
                                <a href="{{ route('home') }}#calendar" class="flex items-center gap-3 px-3 py-2 rounded-xl text-sm text-[#2C3E2D] hover:bg-[#FAF8F2] transition">
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

                    <!-- ตรวจสอบวัน -->
                    <a href="{{ route('grad.progress') }}" class="hover:text-[#5A6B47] transition flex items-center gap-1.5 whitespace-nowrap py-1">
                        <i data-lucide="graduation-cap" class="w-4.5 h-4.5 text-[#4A3B32]"></i>
                        <span>{{ __('portal.nav_verify_days') }}</span>
                    </a>

                    <!-- ยื่นคำร้อง -->
                    <a href="{{ route('grad.request') }}" class="hover:text-[#5A6B47] transition flex items-center gap-1.5 whitespace-nowrap py-1">
                        <i data-lucide="file-text" class="w-4.5 h-4.5 text-[#4A3B32]"></i>
                        <span>{{ __('portal.nav_request_cert') }}</span>
                    </a>

                    <!-- ฐานข้อมูล -->
                    <a href="{{ route('ug.check') }}" class="hover:text-[#5A6B47] transition flex items-center gap-1.5 whitespace-nowrap py-1">
                        <i data-lucide="users" class="w-4.5 h-4.5 text-[#4A3B32]"></i>
                        <span>{{ __('portal.nav_database') }}</span>
                    </a>

                    <!-- ติดต่อ -->
                    <a href="{{ route('contact') }}" class="hover:text-[#5A6B47] transition flex items-center gap-1.5 whitespace-nowrap py-1">
                        <i data-lucide="phone" class="w-4.5 h-4.5 text-[#4A3B32]"></i>
                        <span>{{ __('portal.nav_contact') }}</span>
                    </a>

                    <!-- ร่วมบริจาค -->
                    <a href="{{ route('donation') }}" class="hover:text-[#A85238] transition flex items-center gap-1.5 text-[#C86D51] font-bold whitespace-nowrap py-1">
                        <i data-lucide="gift" class="w-4.5 h-4.5 text-[#C86D51]"></i>
                        <span>{{ __('portal.nav_donation') }}</span>
                    </a>
                </nav>

                <!-- Actions: Language Switcher (TH / EN in Pill Style as in Reference) -->
                <div class="flex items-center space-x-2.5">
                    @php
                        $currentLang = session('locale', 'th');
                    @endphp
                    <div class="flex items-center bg-[#D8D2C2] p-1 rounded-full text-xs font-bold font-mono">
                        <a href="{{ route('lang.switch', 'th') }}" title="ภาษาไทย" class="px-2.5 py-1 rounded-full transition {{ $currentLang === 'th' ? 'bg-[#5A6B47] text-white shadow-xs' : 'text-[#5A544A] hover:text-[#2C3E2D]' }}">
                            TH
                        </a>
                        <a href="{{ route('lang.switch', 'en') }}" title="English" class="px-2.5 py-1 rounded-full transition {{ $currentLang === 'en' ? 'bg-[#5A6B47] text-white shadow-xs' : 'text-[#5A544A] hover:text-[#2C3E2D]' }}">
                            EN
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full flex-grow">
        
        <!-- Header Banner (Organic Earth Deep Forest to Olive) -->
        <div class="bg-gradient-to-r from-[#2C3E2D] via-[#3A4F3C] to-[#5A6B47] rounded-3xl p-6 md:p-10 text-white shadow-lg shadow-[#2C3E2D]/15 mb-8 border border-[#2C3E2D]/20">
            <div class="inline-flex items-center gap-1.5 px-3 py-1 bg-white/15 backdrop-blur-sm rounded-full text-xs font-semibold uppercase tracking-wider mb-3 border border-white/20 text-[#FAF8F2]">
                <i data-lucide="heart-handshake" class="w-3.5 h-3.5 text-[#EAE5D9]"></i>
                <span>{{ __('portal.donation_header_badge') }}</span>
            </div>
            <h1 class="text-2xl md:text-4xl font-heading font-bold mb-3 text-[#FAF8F2]">{{ __('portal.donation_header_title') }}</h1>
            <p class="text-[#EAE5D9] text-sm md:text-base max-w-3xl leading-relaxed">
                {{ __('portal.donation_header_desc') }}
            </p>
        </div>

        <!-- Success Message -->
        @if (session('success'))
            <div class="bg-[#5A6B47]/10 border-l-4 border-[#5A6B47] p-6 rounded-r-2xl mb-8 shadow-sm">
                <div class="flex items-start">
                    <i data-lucide="check-circle" class="w-7 h-7 text-[#5A6B47] mr-3 shrink-0 mt-0.5"></i>
                    <div>
                        <h4 class="text-lg font-bold text-[#2C3E2D] font-heading">{{ session('success') }}</h4>
                        @if (session('donation_no'))
                            <div class="mt-2 p-3 bg-white/80 rounded-xl border border-[#D5CEBC] flex flex-wrap items-center gap-4 text-xs text-[#4A3B32]">
                                <div>
                                    {{ __('portal.donation_ref_label') }} <strong class="font-mono text-[#C86D51] font-bold text-sm">{{ session('donation_no') }}</strong>
                                </div>
                                <div>
                                    {{ __('portal.donation_donor_label') }} <strong class="text-[#2C3E2D]">{{ session('donor_name') }}</strong>
                                </div>
                                <div>
                                    {{ __('portal.donation_amount_summary') }} <strong class="text-[#5A6B47] font-bold">{{ session('amount') }} {{ __('portal.donation_baht') }}</strong>
                                </div>
                            </div>
                            <p class="text-[11px] text-[#7B8D65] mt-1.5">
                                {{ __('portal.donation_officer_note') }}
                            </p>
                        @endif
                    </div>
                </div>
            </div>
        @endif

        <!-- Error Alert -->
        @if ($errors->any())
            <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-r-2xl mb-8 shadow-sm">
                <div class="flex items-center mb-1">
                    <i data-lucide="alert-circle" class="w-5 h-5 text-red-500 mr-2 shrink-0"></i>
                    <h5 class="text-sm font-bold text-red-800">{{ __('portal.donation_error_heading') }}</h5>
                </div>
                <ul class="list-disc list-inside text-xs text-red-700 space-y-0.5 ml-2">
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Top Overview Stats Badges -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
            <div class="organic-card rounded-2xl p-5 border border-[#EAE5D9] flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-[#5A6B47]/15 text-[#5A6B47] flex items-center justify-center shrink-0">
                    <i data-lucide="coins" class="w-6 h-6"></i>
                </div>
                <div>
                    <div class="text-[11px] font-mono uppercase text-[#7B8D65] font-semibold">{{ __('portal.donation_stat_total') }}</div>
                    <div class="text-xl font-heading font-extrabold text-[#2C3E2D]">
                        {{ number_format($totalDonationsAmount ?? 0, 2) }} <span class="text-xs font-normal text-[#6B6357]">{{ __('portal.donation_baht') }}</span>
                    </div>
                </div>
            </div>

            <div class="organic-card rounded-2xl p-5 border border-[#EAE5D9] flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-[#C86D51]/15 text-[#C86D51] flex items-center justify-center shrink-0">
                    <i data-lucide="users" class="w-6 h-6"></i>
                </div>
                <div>
                    <div class="text-[11px] font-mono uppercase text-[#A85238] font-semibold">{{ __('portal.donation_stat_count') }}</div>
                    <div class="text-xl font-heading font-extrabold text-[#2C3E2D]">
                        {{ number_format($totalDonationsCount ?? 0) }} <span class="text-xs font-normal text-[#6B6357]">{{ __('portal.donation_records_unit') }}</span>
                    </div>
                </div>
            </div>

            <div class="organic-card rounded-2xl p-5 border border-[#EAE5D9] flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-[#2C3E2D]/10 text-[#2C3E2D] flex items-center justify-center shrink-0">
                    <i data-lucide="file-check-2" class="w-6 h-6"></i>
                </div>
                <div>
                    <div class="text-[11px] font-mono uppercase text-[#5A6B47] font-semibold">{{ __('portal.donation_tax_benefit') }}</div>
                    <div class="text-sm font-heading font-bold text-[#2C3E2D]">
                        {{ __('portal.donation_tax_deduct_100') }}
                    </div>
                    <div class="text-[10px] text-[#7B8D65]">{{ __('portal.donation_tax_edonation') }}</div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 mb-12">
            
            <!-- Left Column: Bank Account Details & Tax Deduction Information (5 cols) -->
            <div class="lg:col-span-5 space-y-6">
                
                <!-- Bank Account Transfer Card -->
                <div class="organic-card rounded-3xl p-6 md:p-7 border border-[#EAE5D9]">
                    <div class="flex items-center gap-3 mb-5 pb-4 border-b border-[#EAE5D9]">
                        <div class="w-12 h-12 rounded-2xl bg-[#5A6B47]/15 text-[#5A6B47] flex items-center justify-center shrink-0 border border-[#5A6B47]/20">
                            <i data-lucide="credit-card" class="w-6 h-6"></i>
                        </div>
                        <div>
                            <span class="text-[11px] font-mono uppercase text-[#7B8D65] font-semibold">{{ __('portal.donation_bank_channel') }}</span>
                            <h3 class="font-heading font-bold text-base text-[#2C3E2D] leading-tight">
                                {{ __('portal.donation_mcu_bank') }}
                            </h3>
                        </div>
                    </div>

                    <!-- Bank Details Box -->
                    <div class="bg-gradient-to-br from-[#FAF8F2] to-[#F2EFE7] rounded-2xl p-4 border border-[#E3DEC9] mb-5 space-y-3.5">
                        <div>
                            <div class="text-[11px] text-[#7B8D65]">{{ __('portal.donation_bank_receiver') }}</div>
                            <div class="font-bold text-sm text-[#2C3E2D] flex items-center gap-2 mt-0.5">
                                <div class="w-7 h-7 rounded-lg bg-[#2C3E2D]/10 text-[#2C3E2D] flex items-center justify-center shrink-0">
                                    <i data-lucide="landmark" class="w-4 h-4 text-[#5A6B47]"></i>
                                </div>
                                <span>{{ $bankName }}</span>
                            </div>
                        </div>

                        <div>
                            <div class="text-[11px] text-[#7B8D65]">{{ __('portal.donation_acc_name') }}</div>
                            <div class="font-bold text-xs md:text-sm text-[#2C3E2D] leading-relaxed mt-0.5">
                                {{ $accName }}
                            </div>
                        </div>

                        <div class="pt-2 border-t border-[#E3DEC9]">
                            <div class="text-[11px] text-[#7B8D65] mb-1.5">{{ __('portal.donation_acc_num') }}</div>
                            <div class="flex items-center justify-between bg-white px-3.5 py-2.5 rounded-xl border border-[#D5CEBC] shadow-xs">
                                <span id="bank-acc-text" class="font-mono font-extrabold text-lg md:text-xl text-[#C86D51] tracking-wider">{{ $accNum }}</span>
                                <button type="button" onclick="copyToClipboard('bank-acc-text', 'copy-badge-1')" class="px-2.5 py-1 text-[11px] bg-[#FAF8F2] hover:bg-[#5A6B47] hover:text-white rounded-lg border border-[#D5CEBC] transition flex items-center gap-1 font-semibold text-[#4A3B32]">
                                    <i data-lucide="copy" class="w-3.5 h-3.5"></i>
                                    <span id="copy-badge-1">{{ __('portal.donation_copy') }}</span>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- QR Code Payment Card -->
                    <div class="bg-white rounded-2xl p-5 border border-[#D5CEBC] shadow-sm mb-5 text-center">
                        <div class="inline-flex items-center gap-1.5 px-3 py-1 bg-[#5A6B47]/10 text-[#5A6B47] rounded-full text-xs font-semibold mb-2">
                            <i data-lucide="qr-code" class="w-3.5 h-3.5"></i>
                            <span>{{ __('portal.donation_qr_title') }}</span>
                        </div>
                        <p class="text-[11px] text-[#7B8D65] mb-4">
                            {{ __('portal.donation_qr_desc') }}
                        </p>
                        
                        <div class="relative inline-block mx-auto p-3 bg-white rounded-2xl border-2 border-[#5A6B47]/20 shadow-sm group">
                            <img src="{{ asset('images/qr-codepayment.jpg') }}" alt="QR Code Payment" class="w-56 h-auto max-w-full rounded-xl mx-auto object-contain transition duration-200 group-hover:scale-[1.02]">
                        </div>

                        <div class="mt-4 flex flex-wrap justify-center gap-2">
                            <a href="{{ asset('images/qr-codepayment.jpg') }}" target="_blank" download="VPSMCU-QR-Payment.jpg" class="inline-flex items-center gap-1.5 px-3.5 py-1.5 bg-[#FAF8F2] hover:bg-[#5A6B47] hover:text-white text-[#4A3B32] text-xs font-semibold rounded-xl border border-[#D5CEBC] transition">
                                <i data-lucide="download" class="w-3.5 h-3.5"></i>
                                <span>{{ __('portal.donation_qr_save') }}</span>
                            </a>
                        </div>
                    </div>

                    <!-- Tax Deduction Information -->
                    <div class="p-4 rounded-2xl bg-[#5A6B47]/10 border border-[#5A6B47]/20 text-xs text-[#2D2A26] space-y-2">
                        <div class="flex items-center gap-2 font-bold text-[#5A6B47]">
                            <i data-lucide="shield-check" class="w-4 h-4"></i>
                            <span>{{ __('portal.donation_tax_info_title') }}</span>
                        </div>
                        <p class="leading-relaxed text-[#4A3B32]">
                            {{ $infoNotes }}
                        </p>
                    </div>
                </div>

                <!-- Recent Donors (Recent Verified Donors) -->
                @if(isset($recentDonations) && $recentDonations->count() > 0)
                    <div class="organic-card rounded-3xl p-6 border border-[#EAE5D9]">
                        <div class="flex items-center justify-between mb-4 pb-3 border-b border-[#EAE5D9]">
                            <h4 class="font-heading font-bold text-sm text-[#2C3E2D] flex items-center gap-2">
                                <i data-lucide="award" class="w-4 h-4 text-[#C86D51]"></i>
                                <span>{{ __('portal.donation_recent_donors') }}</span>
                            </h4>
                            <span class="text-[10px] text-[#7B8D65] font-mono">{{ __('portal.donation_verified_badge') }}</span>
                        </div>
                        <div class="space-y-3">
                            @foreach($recentDonations as $rd)
                                <div class="flex items-center justify-between p-2.5 rounded-xl bg-[#FAF8F2] border border-[#EAE5D9]/70 text-xs">
                                    <div class="flex items-center gap-2.5 overflow-hidden">
                                        <div class="w-7 h-7 rounded-full bg-[#5A6B47]/15 text-[#5A6B47] flex items-center justify-center shrink-0 text-[10px] font-bold">
                                            <i data-lucide="heart" class="w-3.5 h-3.5"></i>
                                        </div>
                                        <div class="truncate">
                                            <div class="font-semibold text-[#2C3E2D] truncate">{{ $rd->donor_name }}</div>
                                            <div class="text-[10px] text-[#7B8D65]">
                                                {{ $rd->transfer_date ? $rd->transfer_date->format('d/m/Y') : '' }} &bull; {{ $rd->purpose ?? __('portal.donation_purpose_other') }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-right shrink-0 font-mono font-bold text-[#5A6B47]">
                                        {{ number_format($rd->amount, 2) }} ฿
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

            </div>

            <!-- Right Column: Donation Form & Slip Attachment (7 cols) -->
            <div class="lg:col-span-7">
                <div class="organic-card rounded-3xl p-6 md:p-8 border border-[#EAE5D9]">
                    <div class="flex items-center justify-between pb-4 mb-6 border-b border-[#EAE5D9]">
                        <div>
                            <h2 class="font-heading font-bold text-xl text-[#2C3E2D]">{{ __('portal.donation_form_title') }}</h2>
                            <p class="text-xs text-[#7B8D65] mt-1">{{ __('portal.donation_form_desc') }}</p>
                        </div>
                        <span class="p-3 rounded-2xl bg-[#C86D51]/15 text-[#C86D51]">
                            <i data-lucide="hand-heart" class="w-6 h-6"></i>
                        </span>
                    </div>

                    <form action="{{ route('donation.submit') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                        @csrf

                        <!-- 1. ชื่อผู้บริจาค และ เลขประจำตัวผู้เสียภาษี -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-[#4A3B32] mb-1.5">
                                    {{ __('portal.donation_donor_name') }} <span class="text-[#C86D51]">*</span>
                                </label>
                                <input type="text" name="donor_name" value="{{ old('donor_name') }}" required placeholder="{{ __('portal.donation_donor_name') }}" class="w-full px-3.5 py-2.5 bg-white border border-[#EAE5D9] rounded-xl text-xs text-[#2D2A26] focus:ring-2 focus:ring-[#5A6B47] focus:border-[#5A6B47]">
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-[#4A3B32] mb-1.5">
                                    {{ __('portal.donation_tax_id_label') }}
                                </label>
                                <input type="text" id="tax_id" name="tax_id" value="{{ old('tax_id') }}" maxlength="20" placeholder="เลข 13 หลัก / เลขประจำตัวผู้เสียภาษี" class="w-full px-3.5 py-2.5 bg-white border border-[#EAE5D9] rounded-xl text-xs font-mono text-[#2D2A26] focus:ring-2 focus:ring-[#5A6B47] focus:border-[#5A6B47]">
                            </div>
                        </div>

                        <!-- 2. เช็คบ็อกซ์ ลดหย่อนภาษี e-Donation -->
                        <div class="p-3.5 rounded-2xl bg-[#FAF8F2] border border-[#EAE5D9] flex items-center justify-between">
                            <div class="flex items-center">
                                <input type="checkbox" id="is_tax_deductible" name="is_tax_deductible" value="1" {{ old('is_tax_deductible', '1') ? 'checked' : '' }} onchange="toggleTaxIdHighlight(this)" class="w-4 h-4 text-[#5A6B47] border-[#D5CEBC] rounded focus:ring-[#5A6B47]">
                                <label for="is_tax_deductible" class="ml-2.5 text-xs font-semibold text-[#2C3E2D] cursor-pointer">
                                    {{ __('portal.donation_tax_check') }}
                                </label>
                            </div>
                            <span class="text-[10px] text-[#7B8D65] font-mono font-bold hidden sm:inline-block bg-white px-2 py-0.5 rounded-md border border-[#EAE5D9]">e-Donation 100%</span>
                        </div>

                        <!-- 3. จำนวนเงินบริจาค และ บัญชีปลายทาง -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-[#4A3B32] mb-1.5">
                                    {{ __('portal.donation_amount_label') }} <span class="text-[#C86D51]">*</span>
                                </label>
                                <div class="relative">
                                    <input type="number" step="0.01" min="1" name="amount" value="{{ old('amount') }}" required placeholder="1000.00" class="w-full px-3.5 py-2.5 bg-white border border-[#EAE5D9] rounded-xl text-xs font-mono font-bold text-[#2D2A26] focus:ring-2 focus:ring-[#5A6B47] focus:border-[#5A6B47] pr-10">
                                    <span class="absolute right-3 top-2.5 text-xs text-[#7B8D65]">{{ __('portal.donation_baht') }}</span>
                                </div>
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-[#4A3B32] mb-1.5">
                                    {{ __('portal.donation_dest_account') }} <span class="text-[#C86D51]">*</span>
                                </label>
                                <select name="bank_account" required class="w-full px-3.5 py-2.5 bg-white border border-[#EAE5D9] rounded-xl text-xs text-[#2D2A26] focus:ring-2 focus:ring-[#5A6B47] focus:border-[#5A6B47]">
                                    <option value="{{ $bankName }} ({{ $accNum }})" selected>{{ $bankName }} ({{ $accNum }})</option>
                                </select>
                            </div>
                        </div>

                        <!-- 4. วันที่และเวลาโอนเงิน -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-[#4A3B32] mb-1.5">
                                    {{ __('portal.donation_slip_date') }} <span class="text-[#C86D51]">*</span>
                                </label>
                                <input type="date" name="transfer_date" value="{{ old('transfer_date', date('Y-m-d')) }}" required class="w-full px-3.5 py-2.5 bg-white border border-[#EAE5D9] rounded-xl text-xs text-[#2D2A26] focus:ring-2 focus:ring-[#5A6B47] focus:border-[#5A6B47]">
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-[#4A3B32] mb-1.5">
                                    {{ __('portal.donation_slip_time') }} <span class="text-[#C86D51]">*</span>
                                </label>
                                <input type="time" name="transfer_time" value="{{ old('transfer_time', date('H:i')) }}" required class="w-full px-3.5 py-2.5 bg-white border border-[#EAE5D9] rounded-xl text-xs text-[#2D2A26] focus:ring-2 focus:ring-[#5A6B47] focus:border-[#5A6B47]">
                            </div>
                        </div>

                        <!-- 5. แนบหลักฐาน: สลิปโอนเงิน และ ภาพประจำตัวผู้บริจาคสำหรับทำโปสเตอร์ -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- 5.1 แนบสลิปโอนเงิน (บังคับ) -->
                            <div>
                                <label class="block text-xs font-semibold text-[#4A3B32] mb-1.5">
                                    {{ __('portal.donation_slip_upload_label') }} <span class="text-[#C86D51]">*</span>
                                </label>
                                <div class="border-2 border-dashed border-[#D5CEBC] hover:border-[#5A6B47] rounded-2xl p-3.5 transition bg-white/60 text-center h-32 flex flex-col items-center justify-center">
                                    <input type="file" name="slip" id="slip-file" required accept="image/jpeg,image/png,image/jpg,application/pdf" onchange="previewSlip(event)" class="hidden">
                                    <label for="slip-file" class="cursor-pointer flex flex-col items-center justify-center space-y-1.5 w-full">
                                        <div class="w-9 h-9 rounded-xl bg-[#5A6B47]/10 text-[#5A6B47] flex items-center justify-center">
                                            <i data-lucide="receipt" class="w-5 h-5"></i>
                                        </div>
                                        <span class="text-xs font-semibold text-[#2C3E2D] truncate max-w-[200px]" id="slip-file-label">{{ __('portal.donation_slip_select_file') }}</span>
                                        <span class="text-[10px] text-[#7B8D65]">JPG, PNG, PDF (Max 10MB)</span>
                                    </label>
                                </div>
                                <!-- Slip Preview -->
                                <div id="slip-preview-box" class="hidden mt-2 p-2 bg-white rounded-xl border border-[#EAE5D9] flex items-center gap-2.5">
                                    <img id="slip-img-preview" src="#" alt="Slip Preview" class="w-12 h-12 object-cover rounded-lg border border-[#D5CEBC]">
                                    <div class="text-[11px] truncate">
                                        <div id="slip-filename" class="font-semibold text-[#2C3E2D] truncate"></div>
                                        <div class="text-[10px] text-[#5A6B47] flex items-center gap-1">
                                            <i data-lucide="check" class="w-3 h-3"></i>
                                            <span>{{ __('portal.donation_slip_ready') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- 5.2 อัปโหลดภาพประจำตัวสำหรับทำโปสเตอร์อนุโมทนาบุญ (ไม่บังคับ) -->
                            <div>
                                <label class="block text-xs font-semibold text-[#4A3B32] mb-1.5 flex items-center justify-between">
                                    <span>{{ __('portal.donation_avatar_label') }}</span>
                                    <span class="text-[10px] text-[#7B8D65] font-normal">ทางเลือก</span>
                                </label>
                                <div class="border-2 border-dashed border-[#D5CEBC] hover:border-[#C86D51] rounded-2xl p-3.5 transition bg-white/60 text-center h-32 flex flex-col items-center justify-center">
                                    <input type="file" name="avatar" id="avatar-file" accept="image/jpeg,image/png,image/jpg,image/webp" onchange="previewAvatar(event)" class="hidden">
                                    <label for="avatar-file" class="cursor-pointer flex flex-col items-center justify-center space-y-1.5 w-full">
                                        <div class="w-9 h-9 rounded-xl bg-[#C86D51]/10 text-[#C86D51] flex items-center justify-center">
                                            <i data-lucide="image" class="w-5 h-5"></i>
                                        </div>
                                        <span class="text-xs font-semibold text-[#2C3E2D] truncate max-w-[200px]" id="avatar-file-label">{{ __('portal.donation_avatar_select_file') }}</span>
                                        <span class="text-[10px] text-[#7B8D65]">ภาพถ่ายเดี่ยว/ครอบครัว/โลโก้ (Max 10MB)</span>
                                    </label>
                                </div>
                                <!-- Avatar Preview -->
                                <div id="avatar-preview-box" class="hidden mt-2 p-2 bg-white rounded-xl border border-[#EAE5D9] flex items-center gap-2.5">
                                    <img id="avatar-img-preview" src="#" alt="Avatar Preview" class="w-12 h-12 object-cover rounded-full border-2 border-[#5A6B47]/30">
                                    <div class="text-[11px] truncate">
                                        <div id="avatar-filename" class="font-semibold text-[#2C3E2D] truncate"></div>
                                        <div class="text-[10px] text-[#5A6B47] flex items-center gap-1">
                                            <i data-lucide="sparkles" class="w-3 h-3 text-[#C86D51]"></i>
                                            <span>ภาพสำหรับทำโปสเตอร์พร้อมแล้ว</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 6. เบอร์โทร และ อีเมล -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-[#4A3B32] mb-1.5">
                                    {{ __('portal.ug_phone') }}
                                </label>
                                <input type="tel" name="phone" value="{{ old('phone') }}" placeholder="081-234-5678" class="w-full px-3.5 py-2.5 bg-white border border-[#EAE5D9] rounded-xl text-xs text-[#2D2A26] focus:ring-2 focus:ring-[#5A6B47] focus:border-[#5A6B47]">
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-[#4A3B32] mb-1.5">
                                    {{ __('portal.ug_email') }}
                                </label>
                                <input type="email" name="email" value="{{ old('email') }}" placeholder="example@email.com" class="w-full px-3.5 py-2.5 bg-white border border-[#EAE5D9] rounded-xl text-xs text-[#2D2A26] focus:ring-2 focus:ring-[#5A6B47] focus:border-[#5A6B47]">
                            </div>
                        </div>

                        <!-- 7. วัตถุประสงค์การบริจาค -->
                        <div>
                            <label class="block text-xs font-semibold text-[#4A3B32] mb-1.5">
                                {{ __('portal.donation_purpose_label') }}
                            </label>
                            <select name="purpose" class="w-full px-3.5 py-2.5 bg-white border border-[#EAE5D9] rounded-xl text-xs text-[#2D2A26] focus:ring-2 focus:ring-[#5A6B47] focus:border-[#5A6B47]">
                                <option value="{{ __('portal.donation_purpose_1') }}">{{ __('portal.donation_purpose_1') }}</option>
                                <option value="{{ __('portal.donation_purpose_2') }}">{{ __('portal.donation_purpose_2') }}</option>
                                <option value="{{ __('portal.donation_purpose_3') }}">{{ __('portal.donation_purpose_3') }}</option>
                                <option value="{{ __('portal.donation_purpose_4') }}">{{ __('portal.donation_purpose_4') }}</option>
                                <option value="{{ __('portal.donation_purpose_5') }}">{{ __('portal.donation_purpose_5') }}</option>
                            </select>
                        </div>

                        <!-- 8. ที่อยู่สำหรับจัดส่งใบอนุโมทนาบัตร (กรณีต้องการรับทางไปรษณีย์) -->
                        <div>
                            <label class="block text-xs font-semibold text-[#4A3B32] mb-1.5">
                                {{ __('portal.donation_address_label') }}
                            </label>
                            <textarea name="address" rows="2" placeholder="{{ __('portal.donation_address_placeholder') }}" class="w-full px-3.5 py-2.5 bg-white border border-[#EAE5D9] rounded-xl text-xs text-[#2D2A26] focus:ring-2 focus:ring-[#5A6B47] focus:border-[#5A6B47] leading-relaxed">{{ old('address') }}</textarea>
                        </div>

                        <!-- 9. ข้อความคำอธิษฐานจิต / หมายเหตุ -->
                        <div>
                            <label class="block text-xs font-semibold text-[#4A3B32] mb-1.5">
                                {{ __('portal.donation_note_label') }}
                            </label>
                            <textarea name="note" rows="2" placeholder="{{ __('portal.donation_note_placeholder') }}" class="w-full px-3.5 py-2.5 bg-white border border-[#EAE5D9] rounded-xl text-xs text-[#2D2A26] focus:ring-2 focus:ring-[#5A6B47] focus:border-[#5A6B47] leading-relaxed">{{ old('note') }}</textarea>
                        </div>

                        <!-- Submit Button -->
                        <div class="pt-4 border-t border-[#EAE5D9]">
                            <button type="submit" class="w-full py-3.5 px-6 rounded-2xl bg-gradient-to-r from-[#5A6B47] to-[#435235] hover:from-[#435235] hover:to-[#2C3E2D] text-white font-semibold text-sm shadow-md shadow-[#5A6B47]/20 flex items-center justify-center gap-2 transition duration-200">
                                <i data-lucide="check-circle-2" class="w-5 h-5 text-[#FAF8F2]"></i>
                                <span>{{ __('portal.donation_btn_submit') }}</span>
                            </button>
                            <p class="text-center text-[11px] text-[#7B8D65] mt-2">
                                {{ __('portal.donation_submit_note') }}
                            </p>
                        </div>
                    </form>
                </div>
            </div>

        </div>

    </main>

    <!-- Footer -->
    <footer id="contact" class="bg-[#243325] text-[#D5CEBC] text-xs py-12 border-t border-[#1B271C]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-center gap-6 text-center md:text-left">
                <div>
                    <div class="flex items-center justify-center md:justify-start gap-3 mb-2">
                        <img src="{{ asset('images/mcu-logo.png') }}" alt="MCU Logo" class="w-8 h-8 object-contain">
                        <span class="font-heading font-bold text-white text-base">{{ __('portal.footer_brand') }}</span>
                    </div>
                    <p class="text-[#A3B88C]">{{ __('portal.footer_address') }}</p>
                    <p class="text-[#8C8275] mt-1">{{ __('portal.institute_name') }} {{ __('portal.university_name') }} &bull; {{ $contactSettings['contact_phone'] ?? '035-248-000' }}</p>
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
        function toggleTaxIdHighlight(checkbox) {
            const taxInput = document.getElementById('tax_id');
            if (checkbox.checked) {
                taxInput.placeholder = "ระบุเลข 13 หลักเพื่อบันทึก e-Donation";
            } else {
                taxInput.placeholder = "เลข 13 หลัก (ไม่บังคับ)";
            }
        }

        function previewSlip(event) {
            const input = event.target;
            const label = document.getElementById('slip-file-label');
            const previewBox = document.getElementById('slip-preview-box');
            const imgPreview = document.getElementById('slip-img-preview');
            const filenameText = document.getElementById('slip-filename');

            if (input.files && input.files[0]) {
                const file = input.files[0];
                label.textContent = file.name;
                filenameText.textContent = file.name + ' (' + (file.size / 1024).toFixed(1) + ' KB)';
                
                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        imgPreview.src = e.target.result;
                        previewBox.classList.remove('hidden');
                    }
                    reader.readAsDataURL(file);
                } else {
                    previewBox.classList.remove('hidden');
                    imgPreview.src = '/images/mcu-logo.png';
                }
            }
        }

        function previewAvatar(event) {
            const input = event.target;
            const label = document.getElementById('avatar-file-label');
            const previewBox = document.getElementById('avatar-preview-box');
            const imgPreview = document.getElementById('avatar-img-preview');
            const filenameText = document.getElementById('avatar-filename');

            if (input.files && input.files[0]) {
                const file = input.files[0];
                label.textContent = file.name;
                filenameText.textContent = file.name + ' (' + (file.size / 1024).toFixed(1) + ' KB)';
                
                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        imgPreview.src = e.target.result;
                        previewBox.classList.remove('hidden');
                    }
                    reader.readAsDataURL(file);
                }
            }
        }

        function copyToClipboard(elementId, badgeId) {
            const text = document.getElementById(elementId).innerText.trim();
            navigator.clipboard.writeText(text).then(() => {
                const badge = document.getElementById(badgeId);
                const originalText = badge.textContent;
                badge.textContent = '{{ __('portal.donation_copy_done') }}';
                setTimeout(() => {
                    badge.textContent = originalText;
                }, 2000);
            });
        }

        lucide.createIcons();
    </script>
</body>
</html>
