<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ระบบจัดการการบริจาคและสถิติการเงิน | VPSMCU Admin</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@300;400;500;600;700&family=Prompt:wght@400;500;600;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Lucide Icons -->
    <script src="/assets/js/lucide.min.js"></script>

    <!-- Chart.js -->
    <script src="/assets/js/chart.min.js"></script>

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
                            oliveLight: '#7B8D65',
                            bark: '#4A3B32',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        body { 
            font-family: 'Sarabun', sans-serif; 
            background: #F4F1EA; 
            color: #2D2A26;
        }
        h1, h2, h3, h4, .font-heading { font-family: 'Prompt', sans-serif; }

        .earth-admin-card {
            background: rgba(255, 255, 255, 0.94);
            backdrop-filter: blur(14px);
            border: 1px solid rgba(220, 215, 201, 0.85);
            box-shadow: 0 10px 25px -10px rgba(74, 59, 50, 0.05);
            border-radius: 1rem;
        }
    </style>
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/mcu-logo.png') }}">
    <link rel="shortcut icon" href="{{ asset('images/mcu-logo.png') }}">
</head>
<body class="antialiased min-h-screen flex flex-col md:flex-row">

    <!-- Earth Tones Sidebar (Deep Forest & Olive) -->
    @include('admin.layouts.sidebar')

    <!-- Main Workspace -->
    <main class="flex-grow p-6 md:p-10 overflow-y-auto">
        
        <!-- Header Section -->
        <div class="flex flex-col sm:flex-row justify-between sm:items-center pb-6 mb-8 border-b border-[#D5CEBC] gap-4">
            <div>
                <span class="text-xs font-bold text-[#5A6B47] uppercase tracking-wider font-mono flex items-center gap-1.5">
                    <i data-lucide="gift" class="w-4 h-4"></i> Donation & Fund Management
                </span>
                <h1 class="text-2xl sm:text-3xl font-heading font-extrabold text-[#2C3E2D] mt-1">ระบบจัดการการบริจาคและสรุปสถิติ</h1>
                <p class="text-xs text-[#6B6357] mt-1">ตรวจสอบรายการโอนเงิน สลิปหลักฐาน จัดการสถานะ ออกใบอนุโมทนาบัตร และสรุปสถิติยอดบริจาค</p>
            </div>
            <div class="flex flex-wrap items-center gap-3">
                <a href="{{ route('admin.donations.export', request()->query()) }}" class="text-xs bg-white border border-[#D5CEBC] hover:border-[#5A6B47] text-[#2C3E2D] px-3.5 py-2 rounded-xl font-semibold shadow-2xs flex items-center gap-2 transition">
                    <i data-lucide="file-spreadsheet" class="w-4 h-4 text-[#5A6B47]"></i>
                    <span>ส่งออกข้อมูล (Excel/CSV)</span>
                </a>
                <button type="button" onclick="openSettingsModal()" class="text-xs bg-[#2C3E2D] hover:bg-[#3A4F3C] text-white px-3.5 py-2 rounded-xl font-semibold shadow-sm flex items-center gap-2 transition">
                    <i data-lucide="sliders" class="w-4 h-4 text-[#A3B88C]"></i>
                    <span>ตั้งค่าบัญชีรับบริจาค</span>
                </button>
                <a href="{{ route('donation') }}" target="_blank" class="text-xs bg-[#5A6B47] hover:bg-[#465337] text-white px-3.5 py-2 rounded-xl font-semibold shadow-sm flex items-center gap-2 transition">
                    <i data-lucide="external-link" class="w-4 h-4"></i>
                    <span>หน้าฟอร์มบริจาค (หน้าบ้าน)</span>
                </a>
            </div>
        </div>

        <!-- Success Alert -->
        @if (session('success'))
            <div class="bg-[#5A6B47]/10 border-l-4 border-[#5A6B47] p-4 rounded-r-xl mb-6 shadow-sm flex items-center justify-between">
                <div class="flex items-center gap-2.5 text-xs text-[#2C3E2D] font-medium">
                    <i data-lucide="check-circle" class="w-5 h-5 text-[#5A6B47] shrink-0"></i>
                    <span>{{ session('success') }}</span>
                </div>
            </div>
        @endif

        <!-- Error Alert -->
        @if ($errors->any())
            <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-r-xl mb-6 shadow-sm">
                <div class="flex items-center mb-1">
                    <i data-lucide="alert-circle" class="w-5 h-5 text-red-500 mr-2 shrink-0"></i>
                    <h5 class="text-xs font-bold text-red-800">เกิดข้อผิดพลาดในการบันทึกข้อมูล</h5>
                </div>
                <ul class="list-disc list-inside text-xs text-red-700 ml-2">
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Summary Statistics Cards (Earth Organic Palette) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
            <!-- 1. ยอดบริจาคทั้งหมด -->
            <div class="earth-admin-card p-5 relative overflow-hidden">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-[11px] font-mono uppercase tracking-wider text-[#7B8D65] font-semibold">ยอดรวมทั้งสิ้น (Total)</span>
                    <span class="w-8 h-8 rounded-lg bg-[#5A6B47]/10 text-[#5A6B47] flex items-center justify-center">
                        <i data-lucide="coins" class="w-4 h-4"></i>
                    </span>
                </div>
                <div class="text-2xl font-heading font-bold text-[#2C3E2D]">
                    {{ number_format($metrics['total_amount'], 2) }} <span class="text-xs font-normal text-[#6B6357]">บาท</span>
                </div>
                <div class="text-[11px] text-[#6B6357] mt-1 flex items-center gap-1">
                    <i data-lucide="receipt" class="w-3 h-3 text-[#5A6B47]"></i>
                    <span>รวมทั้งหมด <strong>{{ number_format($metrics['total_count']) }}</strong> รายการ</span>
                </div>
            </div>

            <!-- 2. ตรวจสอบยืนยันแล้ว -->
            <div class="earth-admin-card p-5 relative overflow-hidden">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-[11px] font-mono uppercase tracking-wider text-[#5A6B47] font-semibold">ยืนยันยอดแล้ว (Verified)</span>
                    <span class="w-8 h-8 rounded-lg bg-[#5A6B47]/15 text-[#5A6B47] flex items-center justify-center">
                        <i data-lucide="check-check" class="w-4 h-4"></i>
                    </span>
                </div>
                <div class="text-2xl font-heading font-bold text-[#5A6B47]">
                    {{ number_format($metrics['verified_amount'], 2) }} <span class="text-xs font-normal text-[#6B6357]">บาท</span>
                </div>
                <div class="text-[11px] text-[#6B6357] mt-1 flex items-center gap-1">
                    <span class="w-2 h-2 rounded-full bg-[#5A6B47]"></span>
                    <span>อนุมัติแล้ว <strong>{{ number_format($metrics['verified_count']) }}</strong> รายการ</span>
                </div>
            </div>

            <!-- 3. รอตรวจสอบ -->
            <div class="earth-admin-card p-5 relative overflow-hidden">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-[11px] font-mono uppercase tracking-wider text-[#C86D51] font-semibold">รอตรวจสอบ (Pending)</span>
                    <span class="w-8 h-8 rounded-lg bg-[#C86D51]/15 text-[#C86D51] flex items-center justify-center">
                        <i data-lucide="clock" class="w-4 h-4"></i>
                    </span>
                </div>
                <div class="text-2xl font-heading font-bold text-[#C86D51]">
                    {{ number_format($metrics['pending_amount'], 2) }} <span class="text-xs font-normal text-[#6B6357]">บาท</span>
                </div>
                <div class="text-[11px] text-[#6B6357] mt-1 flex items-center gap-1">
                    <span class="w-2 h-2 rounded-full bg-[#C86D51] animate-pulse"></span>
                    <span>รอดำเนินการ <strong>{{ number_format($metrics['pending_count']) }}</strong> รายการ</span>
                </div>
            </div>

            <!-- 4. ขอลดหย่อนภาษี -->
            <div class="earth-admin-card p-5 relative overflow-hidden">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-[11px] font-mono uppercase tracking-wider text-[#2C3E2D] font-semibold">ขอลดหย่อนภาษี (Tax Deduct)</span>
                    <span class="w-8 h-8 rounded-lg bg-[#2C3E2D]/10 text-[#2C3E2D] flex items-center justify-center">
                        <i data-lucide="file-text" class="w-4 h-4"></i>
                    </span>
                </div>
                <div class="text-2xl font-heading font-bold text-[#2C3E2D]">
                    {{ number_format($metrics['tax_deductible_amount'], 2) }} <span class="text-xs font-normal text-[#6B6357]">บาท</span>
                </div>
                <div class="text-[11px] text-[#6B6357] mt-1 flex items-center gap-1">
                    <i data-lucide="shield-check" class="w-3 h-3 text-[#5A6B47]"></i>
                    <span>ระบุเลขผู้เสียภาษี <strong>{{ number_format($metrics['tax_deductible_count']) }}</strong> ราย</span>
                </div>
            </div>
        </div>

        <!-- Monthly Trends Chart (Chart.js) -->
        <div class="earth-admin-card p-6 mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-4 mb-4 border-b border-[#EAE5D9] gap-2">
                <div class="flex items-center gap-2.5">
                    <span class="w-8 h-8 rounded-lg bg-[#5A6B47]/15 text-[#5A6B47] flex items-center justify-center">
                        <i data-lucide="bar-chart-3" class="w-4 h-4"></i>
                    </span>
                    <div>
                        <h3 class="font-heading font-bold text-sm text-[#2C3E2D]">สถิติแนวโน้มยอดเงินบริจาครายเดือน</h3>
                        <p class="text-[11px] text-[#7B8D65]">แสดงยอดเงินบริจาค (บาท) ตามรอบเดือนเพื่อการบริหารจัดการกองทุน</p>
                    </div>
                </div>
                <span class="text-xs font-mono text-[#6B6357] bg-[#FAF8F2] px-3 py-1 rounded-lg border border-[#D5CEBC]">
                    Monthly Trend
                </span>
            </div>
            <div class="h-64 w-full">
                <canvas id="donationChart"></canvas>
            </div>
        </div>

        <!-- Filter & Search Toolbar -->
        <div class="earth-admin-card p-5 mb-6">
            <form method="GET" action="{{ route('admin.donations.index') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-12 gap-3 text-xs">
                
                <!-- Search Input -->
                <div class="lg:col-span-4">
                    <label class="block text-[11px] font-semibold text-[#4A3B32] mb-1">ค้นหา (ชื่อ / เลขผู้เสียภาษี / เลขที่ใบแจ้ง / เบอร์โทร)</label>
                    <div class="relative">
                        <i data-lucide="search" class="w-3.5 h-3.5 absolute left-3 top-2.5 text-[#8C8275]"></i>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="พิมพ์คำค้นหา..." class="w-full pl-9 pr-3 py-2 bg-white border border-[#D5CEBC] rounded-xl text-xs focus:ring-2 focus:ring-[#5A6B47]">
                    </div>
                </div>

                <!-- Status Filter -->
                <div class="lg:col-span-2">
                    <label class="block text-[11px] font-semibold text-[#4A3B32] mb-1">สถานะ</label>
                    <select name="status" class="w-full px-3 py-2 bg-white border border-[#D5CEBC] rounded-xl text-xs focus:ring-2 focus:ring-[#5A6B47]">
                        <option value="ALL" {{ request('status') == 'ALL' ? 'selected' : '' }}>ทุกสถานะ</option>
                        <option value="PENDING" {{ request('status') == 'PENDING' ? 'selected' : '' }}>รอตรวจสอบ (Pending)</option>
                        <option value="VERIFIED" {{ request('status') == 'VERIFIED' ? 'selected' : '' }}>ยืนยันแล้ว (Verified)</option>
                        <option value="REJECTED" {{ request('status') == 'REJECTED' ? 'selected' : '' }}>ไม่อนุมัติ (Rejected)</option>
                    </select>
                </div>

                <!-- Tax Deductible Filter -->
                <div class="lg:col-span-2">
                    <label class="block text-[11px] font-semibold text-[#4A3B32] mb-1">ลดหย่อนภาษี</label>
                    <select name="tax_deductible" class="w-full px-3 py-2 bg-white border border-[#D5CEBC] rounded-xl text-xs focus:ring-2 focus:ring-[#5A6B47]">
                        <option value="ALL" {{ request('tax_deductible') == 'ALL' ? 'selected' : '' }}>ทั้งหมด</option>
                        <option value="1" {{ request('tax_deductible') == '1' ? 'selected' : '' }}>ขอลดหย่อนภาษี</option>
                        <option value="0" {{ request('tax_deductible') == '0' ? 'selected' : '' }}>ไม่ลดหย่อน</option>
                    </select>
                </div>

                <!-- Date Range -->
                <div class="lg:col-span-2">
                    <label class="block text-[11px] font-semibold text-[#4A3B32] mb-1">ตั้งแต่วันที่</label>
                    <input type="date" name="date_from" value="{{ request('date_from') }}" class="w-full px-3 py-2 bg-white border border-[#D5CEBC] rounded-xl text-xs focus:ring-2 focus:ring-[#5A6B47]">
                </div>

                <div class="lg:col-span-2 flex items-end gap-2">
                    <button type="submit" class="flex-1 py-2 bg-[#5A6B47] hover:bg-[#465337] text-white rounded-xl font-semibold transition flex items-center justify-center gap-1.5 shadow-2xs">
                        <i data-lucide="filter" class="w-3.5 h-3.5"></i>
                        <span>กรองข้อมูล</span>
                    </button>
                    @if(request()->hasAny(['search', 'status', 'tax_deductible', 'date_from', 'date_to']))
                        <a href="{{ route('admin.donations.index') }}" title="ล้างตัวกรอง" class="p-2 bg-white border border-[#D5CEBC] hover:bg-[#FAF8F2] text-[#4A3B32] rounded-xl transition flex items-center justify-center">
                            <i data-lucide="rotate-ccw" class="w-4 h-4"></i>
                        </a>
                    @endif
                </div>

            </form>
        </div>

        <!-- Donations Table -->
        <div class="earth-admin-card overflow-hidden mb-8">
            <div class="p-4 md:p-5 border-b border-[#EAE5D9] flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                <div class="flex items-center gap-2">
                    <h3 class="font-heading font-bold text-sm text-[#2C3E2D]">รายการแจ้งการบริจาคทั้งหมด</h3>
                    <span class="text-[11px] font-mono text-[#5A6B47] bg-[#5A6B47]/10 px-2.5 py-0.5 rounded-full font-bold">
                        {{ $donations->total() }} รายการ
                    </span>
                </div>
                <div class="text-[11px] text-[#7B8D65]">
                    แสดงหน้า {{ $donations->currentPage() }} จากทั้งหมด {{ $donations->lastPage() }}
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-[#2D2A26]">
                    <thead class="bg-[#FAF8F2] text-[#4A3B32] font-semibold border-b border-[#EAE5D9]">
                        <tr>
                            <th class="py-3 px-4 whitespace-nowrap">เลขที่รายการ</th>
                            <th class="py-3 px-4 whitespace-nowrap">ผู้บริจาค / วัตถุประสงค์</th>
                            <th class="py-3 px-4 whitespace-nowrap">ลดหย่อนภาษี</th>
                            <th class="py-3 px-4 whitespace-nowrap text-right">จำนวนเงิน (บาท)</th>
                            <th class="py-3 px-4 whitespace-nowrap">วันที่/เวลาโอน</th>
                            <th class="py-3 px-4 whitespace-nowrap text-center">สลิป</th>
                            <th class="py-3 px-4 whitespace-nowrap text-center">สถานะ</th>
                            <th class="py-3 px-4 whitespace-nowrap text-center">การจัดการ</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#EAE5D9]">
                        @forelse ($donations as $d)
                            <tr class="hover:bg-[#FAF8F2]/60 transition">
                                <!-- เลขที่รายการ -->
                                <td class="py-3.5 px-4 font-mono font-bold text-[#C86D51] whitespace-nowrap align-middle">
                                    {{ $d->donation_no }}
                                    <div class="text-[10px] text-[#8C8275] font-normal font-sans">
                                        {{ $d->created_at ? $d->created_at->format('d/m/Y H:i') : '-' }}
                                    </div>
                                </td>

                                <!-- ผู้บริจาค / วัตถุประสงค์ -->
                                <td class="py-3.5 px-4 align-middle">
                                    <div class="flex items-center gap-3">
                                        @if ($d->avatar_path)
                                            <button type="button" onclick="viewAvatarModal('{{ asset('storage/' . $d->avatar_path) }}', '{{ addslashes($d->donor_name) }}', '{{ $d->donation_no }}')" class="relative shrink-0 group" title="คลิกเพื่อดูภาพประจำตัว">
                                                <img src="{{ asset('storage/' . $d->avatar_path) }}" alt="{{ $d->donor_name }}" class="w-10 h-10 rounded-full object-cover border-2 border-[#5A6B47] shadow-xs group-hover:scale-110 transition">
                                                <span class="absolute -bottom-1 -right-1 bg-[#C86D51] text-white p-0.5 rounded-full" title="ภาพทำโปสเตอร์">
                                                    <i data-lucide="sparkles" class="w-2.5 h-2.5"></i>
                                                </span>
                                            </button>
                                        @else
                                            <div class="w-10 h-10 rounded-full bg-[#EAE5D9] text-[#7B8D65] flex items-center justify-center font-bold text-xs shrink-0 border border-[#D5CEBC]">
                                                {{ mb_substr($d->donor_name, 0, 1) }}
                                            </div>
                                        @endif
                                        <div class="min-w-0">
                                            <div class="font-bold text-[#2C3E2D] truncate">{{ $d->donor_name }}</div>
                                            <div class="text-[11px] text-[#6B6357] line-clamp-1 max-w-xs" title="{{ $d->purpose }}">
                                                {{ $d->purpose ?? 'บำรุงศูนย์ปฏิบัติธรรม' }}
                                            </div>
                                            @if($d->phone || $d->email)
                                                <div class="text-[10px] text-[#8C8275] font-mono mt-0.5">
                                                    {{ $d->phone }} {{ $d->email ? '&bull; ' . $d->email : '' }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </td>

                                <!-- ลดหย่อนภาษี -->
                                <td class="py-3.5 px-4 align-middle whitespace-nowrap">
                                    @if ($d->is_tax_deductible)
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-[#5A6B47]/15 text-[#5A6B47] border border-[#5A6B47]/30">
                                            <i data-lucide="check" class="w-3 h-3"></i>
                                            <span>ลดหย่อนภาษี</span>
                                        </span>
                                        @if($d->tax_id)
                                            <div class="text-[10px] text-[#4A3B32] font-mono mt-1">
                                                ID: {{ $d->tax_id }}
                                            </div>
                                        @endif
                                    @else
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-medium bg-[#EAE5D9] text-[#6B6357]">
                                            ไม่ขอลดหย่อน
                                        </span>
                                    @endif
                                </td>

                                <!-- จำนวนเงิน -->
                                <td class="py-3.5 px-4 align-middle text-right font-mono font-bold text-sm text-[#2C3E2D] whitespace-nowrap">
                                    {{ number_format($d->amount, 2) }}
                                    <div class="text-[10px] font-normal text-[#7B8D65]">
                                        {{ $d->bank_account ?? 'โอนเงินเข้าบัญชี' }}
                                    </div>
                                </td>

                                <!-- วันที่โอน -->
                                <td class="py-3.5 px-4 align-middle whitespace-nowrap">
                                    <div class="font-medium text-[#2C3E2D]">
                                        {{ $d->transfer_date ? $d->transfer_date->format('d/m/Y') : '-' }}
                                    </div>
                                    <div class="text-[10px] font-mono text-[#8C8275]">
                                        {{ $d->transfer_time ? $d->transfer_time . ' น.' : '-' }}
                                    </div>
                                </td>

                                <!-- สลิปหลักฐาน -->
                                <td class="py-3.5 px-4 align-middle text-center whitespace-nowrap">
                                    @if ($d->slip_path)
                                        <button type="button" onclick="viewSlipModal('{{ asset('storage/' . $d->slip_path) }}', '{{ $d->donation_no }}')" class="p-1.5 bg-white border border-[#D5CEBC] hover:border-[#5A6B47] text-[#5A6B47] rounded-lg shadow-2xs transition inline-flex items-center gap-1" title="ดูหลักฐานสลิป">
                                            <i data-lucide="file-search" class="w-4 h-4"></i>
                                            <span class="text-[10px] font-semibold">ดูสลิป</span>
                                        </button>
                                    @else
                                        <span class="text-[10px] text-[#A8A190] italic">ไม่มีสลิป</span>
                                    @endif
                                </td>

                                <!-- สถานะ (คลิกเพื่อเปลี่ยนสถานะด่วน) -->
                                <td class="py-3.5 px-4 align-middle text-center whitespace-nowrap">
                                    <button type="button" 
                                        onclick="openQuickStatusModal({{ $d->id }}, '{{ $d->donation_no }}', '{{ addslashes($d->donor_name) }}', '{{ $d->status }}', '{{ addslashes($d->admin_notes ?? '') }}')"
                                        title="คลิกเพื่อเปลี่ยนสถานะด่วน"
                                        class="group inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-[11px] font-bold transition duration-150 cursor-pointer shadow-2xs hover:scale-105 {{ $d->status === 'VERIFIED' ? 'bg-[#5A6B47] text-white hover:bg-[#465337]' : ($d->status === 'REJECTED' ? 'bg-[#C86D51] text-white hover:bg-[#A85238]' : 'bg-[#EAE5D9] text-[#7B8D65] border border-[#D5CEBC] hover:bg-[#DDD7C8]') }}">
                                        @if ($d->status === 'VERIFIED')
                                            <i data-lucide="check-circle" class="w-3.5 h-3.5"></i>
                                            <span>ยืนยันแล้ว</span>
                                        @elseif ($d->status === 'REJECTED')
                                            <i data-lucide="x-circle" class="w-3.5 h-3.5"></i>
                                            <span>ไม่อนุมัติ</span>
                                        @else
                                            <i data-lucide="clock" class="w-3.5 h-3.5 text-[#C86D51]"></i>
                                            <span>รอตรวจสอบ</span>
                                        @endif
                                        <i data-lucide="chevron-down" class="w-3 h-3 opacity-60 group-hover:opacity-100 transition-transform"></i>
                                    </button>
                                </td>

                                <!-- การจัดการ -->
                                <td class="py-3.5 px-4 align-middle text-center whitespace-nowrap">
                                    <div class="flex items-center justify-center gap-1.5">
                                        <!-- ดูรายละเอียด / ตรวจสอบ -->
                                        <button type="button" onclick="openActionModal({{ json_encode($d) }})" title="ตรวจสอบและเปลี่ยนสถานะ" class="p-1.5 rounded-lg bg-white border border-[#D5CEBC] hover:bg-[#5A6B47] hover:text-white text-[#2C3E2D] transition shadow-2xs">
                                            <i data-lucide="edit-3" class="w-3.5 h-3.5"></i>
                                        </button>

                                        <!-- ลบรายการ -->
                                        <a href="{{ url('/admin/donations.php?action=delete&id=' . $d->id) }}" onclick="return confirm('ยืนยันที่จะลบรายการบริจาคนี้หรือไม่?')" title="ลบรายการ" class="p-1.5 rounded-lg bg-white border border-[#D5CEBC] hover:bg-red-600 hover:text-white text-red-600 transition shadow-2xs">
                                            <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-10 text-xs text-[#8C8275]">
                                    <i data-lucide="inbox" class="w-8 h-8 mx-auto text-[#D5CEBC] mb-2"></i>
                                    ยังไม่พบรายการบริจาคตามเงื่อนไขที่เลือก
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if ($donations->hasPages())
                <div class="p-4 border-t border-[#EAE5D9] bg-[#FAF8F2]">
                    {{ $donations->links() }}
                </div>
            @endif
        </div>

    </main>

    <!-- Modal: ตรวจสอบและแก้ไขข้อมูลการบริจาคทั้งหมด (Comprehensive Full Edit Modal) -->
    <div id="actionModal" class="hidden fixed inset-0 z-50 overflow-y-auto bg-black/60 backdrop-blur-xs flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl max-w-2xl w-full p-6 md:p-8 shadow-2xl border border-[#D5CEBC] text-xs max-h-[90vh] overflow-y-auto custom-scrollbar">
            <div class="flex items-center justify-between pb-4 mb-5 border-b border-[#EAE5D9]">
                <div class="flex items-center gap-2.5">
                    <span class="w-9 h-9 rounded-xl bg-[#5A6B47]/15 text-[#5A6B47] flex items-center justify-center font-bold">
                        <i data-lucide="edit-3" class="w-5 h-5"></i>
                    </span>
                    <div>
                        <h3 class="font-heading font-bold text-base text-[#2C3E2D]">แก้ไขข้อมูลการบริจาค & แนบสลิปเพิ่มเติม</h3>
                        <p class="text-[11px] text-[#7B8D65]">เลขที่รายการ: <strong id="modal-donation-no-badge" class="font-mono text-[#C86D51]"></strong></p>
                    </div>
                </div>
                <button type="button" onclick="closeActionModal()" class="text-[#8C8275] hover:text-[#2C3E2D]">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>

            <form id="actionForm" method="POST" action="{{ url('/admin/donations.php') }}" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <input type="hidden" name="action" value="update">
                <input type="hidden" name="id" id="edit_donation_id">

                <!-- แถวที่ 1: ชื่อผู้บริจาค และ จำนวนเงิน -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-[#4A3B32] mb-1">
                            ชื่อ-นามสกุล ผู้บริจาค / คณะศรัทธา <span class="text-[#C86D51]">*</span>
                        </label>
                        <input type="text" name="donor_name" id="edit_donor_name" required class="w-full px-3.5 py-2 bg-white border border-[#D5CEBC] rounded-xl text-xs focus:ring-2 focus:ring-[#5A6B47]">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-[#4A3B32] mb-1">
                            จำนวนเงินบริจาค (บาท) <span class="text-[#C86D51]">*</span>
                        </label>
                        <input type="number" step="0.01" min="1" name="amount" id="edit_amount" required class="w-full px-3.5 py-2 bg-white border border-[#D5CEBC] rounded-xl text-xs font-mono font-bold focus:ring-2 focus:ring-[#5A6B47]">
                    </div>
                </div>

                <!-- แถวที่ 2: สิทธิประโยชน์ลดหย่อนภาษี และ เลขผู้เสียภาษี -->
                <div class="p-3.5 rounded-2xl bg-[#FAF8F2] border border-[#EAE5D9] space-y-2.5">
                    <div class="flex items-center">
                        <input type="checkbox" id="edit_is_tax_deductible" name="is_tax_deductible" value="1" onchange="toggleEditTaxId(this)" class="w-4 h-4 text-[#5A6B47] border-[#D5CEBC] rounded focus:ring-[#5A6B47]">
                        <label for="edit_is_tax_deductible" class="ml-2 text-xs font-semibold text-[#2C3E2D] cursor-pointer">
                            ขอลดหย่อนภาษี (ระบบ e-Donation สรรพากร)
                        </label>
                    </div>

                    <div id="edit_tax_id_wrapper" class="hidden pt-2 border-t border-[#EAE5D9]">
                        <label class="block text-[11px] font-semibold text-[#4A3B32] mb-1">
                            เลขประจำตัวผู้เสียภาษีอากร / เลขบัตรประชาชน 13 หลัก
                        </label>
                        <input type="text" name="tax_id" id="edit_tax_id" maxlength="20" placeholder="ระบุเลขประจำตัวผู้เสียภาษี 13 หลัก" class="w-full px-3 py-1.5 bg-white border border-[#D5CEBC] rounded-xl text-xs font-mono focus:ring-2 focus:ring-[#5A6B47]">
                    </div>
                </div>

                <!-- แถวที่ 3: บัญชีธนาคารปลายทาง -->
                <div>
                    <label class="block text-xs font-semibold text-[#4A3B32] mb-1">
                        บัญชีธนาคารปลายทางที่โอนเข้า <span class="text-[#C86D51]">*</span>
                    </label>
                    <input type="text" name="bank_account" id="edit_bank_account" required class="w-full px-3.5 py-2 bg-white border border-[#D5CEBC] rounded-xl text-xs focus:ring-2 focus:ring-[#5A6B47]">
                </div>

                <!-- แถวที่ 4: วันที่และเวลาโอนเงิน -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-[#4A3B32] mb-1">
                            วันที่โอนเงินตามสลิป <span class="text-[#C86D51]">*</span>
                        </label>
                        <input type="date" name="transfer_date" id="edit_transfer_date" required class="w-full px-3.5 py-2 bg-white border border-[#D5CEBC] rounded-xl text-xs focus:ring-2 focus:ring-[#5A6B47]">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-[#4A3B32] mb-1">
                            เวลาที่โอนเงินตามสลิป
                        </label>
                        <input type="time" name="transfer_time" id="edit_transfer_time" class="w-full px-3.5 py-2 bg-white border border-[#D5CEBC] rounded-xl text-xs focus:ring-2 focus:ring-[#5A6B47]">
                    </div>
                </div>

                <!-- แถวที่ 5: ช่องทางการติดต่อ (เบอร์โทร, อีเมล) -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-[#4A3B32] mb-1">
                            เบอร์โทรศัพท์ติดต่อ
                        </label>
                        <input type="tel" name="phone" id="edit_phone" placeholder="เช่น 081-234-5678" class="w-full px-3.5 py-2 bg-white border border-[#D5CEBC] rounded-xl text-xs focus:ring-2 focus:ring-[#5A6B47]">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-[#4A3B32] mb-1">
                            อีเมลสำหรับรับเอกสาร
                        </label>
                        <input type="email" name="email" id="edit_email" placeholder="example@email.com" class="w-full px-3.5 py-2 bg-white border border-[#D5CEBC] rounded-xl text-xs focus:ring-2 focus:ring-[#5A6B47]">
                    </div>
                </div>

                <!-- แถวที่ 6: วัตถุประสงค์และที่อยู่ -->
                <div>
                    <label class="block text-xs font-semibold text-[#4A3B32] mb-1">
                        วัตถุประสงค์การบริจาค
                    </label>
                    <input type="text" name="purpose" id="edit_purpose" class="w-full px-3.5 py-2 bg-white border border-[#D5CEBC] rounded-xl text-xs focus:ring-2 focus:ring-[#5A6B47]">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-[#4A3B32] mb-1">
                        ที่อยู่สำหรับจัดส่งใบอนุโมทนาบัตร
                    </label>
                    <textarea name="address" id="edit_address" rows="2" placeholder="ระบุที่อยู่จัดส่งทางไปรษณีย์..." class="w-full px-3.5 py-2 bg-white border border-[#D5CEBC] rounded-xl text-xs focus:ring-2 focus:ring-[#5A6B47]"></textarea>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-[#4A3B32] mb-1">
                        คำอธิษฐานจิต / หมายเหตุจากผู้บริจาค
                    </label>
                    <textarea name="note" id="edit_note" rows="2" placeholder="คำอธิษฐานจิต..." class="w-full px-3.5 py-2 bg-white border border-[#D5CEBC] rounded-xl text-xs focus:ring-2 focus:ring-[#5A6B47]"></textarea>
                </div>

                <!-- แถวที่ 7: การจัดการสลิปหลักฐานโอนเงิน & ภาพประจำตัวทำโปสเตอร์ -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- 7.1 สลิปโอนเงิน -->
                    <div class="p-4 rounded-2xl bg-[#FAF8F2] border border-[#EAE5D9] space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-semibold text-[#2C3E2D] flex items-center gap-1.5">
                                <i data-lucide="receipt" class="w-4 h-4 text-[#5A6B47]"></i>
                                <span>หลักฐานสลิปการโอนเงิน (Slip)</span>
                            </span>
                            <div id="current_slip_preview_btn" class="hidden">
                                <button type="button" id="btn_open_current_slip" onclick="" class="px-2.5 py-1 bg-white border border-[#D5CEBC] hover:border-[#5A6B47] text-[#5A6B47] rounded-lg text-[11px] font-semibold flex items-center gap-1 shadow-2xs">
                                    <i data-lucide="eye" class="w-3.5 h-3.5"></i>
                                    <span>เปิดดูสลิป</span>
                                </button>
                            </div>
                        </div>

                        <div>
                            <label class="block text-[11px] text-[#6B6357] mb-1">
                                แนบสลิปใหม่เพิ่มเติม หรืออัปโหลดแทนที่เดิม (JPG, PNG, PDF ไม่เกิน 10MB)
                            </label>
                            <input type="file" name="slip" id="edit_slip_input" accept="image/jpeg,image/png,image/jpg,application/pdf" class="w-full px-3 py-1.5 bg-white border border-[#D5CEBC] rounded-xl text-xs file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-[#5A6B47]/10 file:text-[#5A6B47] hover:file:bg-[#5A6B47]/20">
                        </div>
                    </div>

                    <!-- 7.2 ภาพประจำตัวสำหรับทำโปสเตอร์อนุโมทนาบุญ -->
                    <div class="p-4 rounded-2xl bg-[#FAF8F2] border border-[#EAE5D9] space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-semibold text-[#2C3E2D] flex items-center gap-1.5">
                                <i data-lucide="sparkles" class="w-4 h-4 text-[#C86D51]"></i>
                                <span>ภาพถ่ายทำโปสเตอร์ (Avatar)</span>
                            </span>
                            <div id="current_avatar_preview_btn" class="hidden">
                                <button type="button" id="btn_open_current_avatar" onclick="" class="px-2.5 py-1 bg-white border border-[#D5CEBC] hover:border-[#C86D51] text-[#C86D51] rounded-lg text-[11px] font-semibold flex items-center gap-1 shadow-2xs">
                                    <i data-lucide="eye" class="w-3.5 h-3.5"></i>
                                    <span>เปิดดูภาพ</span>
                                </button>
                            </div>
                        </div>

                        <div>
                            <label class="block text-[11px] text-[#6B6357] mb-1">
                                แนบภาพประจำตัวใหม่ หรืออัปโหลดแทนที่เดิม (JPG, PNG ไม่เกิน 10MB)
                            </label>
                            <input type="file" name="avatar" id="edit_avatar_input" accept="image/jpeg,image/png,image/jpg,image/webp" class="w-full px-3 py-1.5 bg-white border border-[#D5CEBC] rounded-xl text-xs file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-[#C86D51]/10 file:text-[#C86D51] hover:file:bg-[#C86D51]/20">
                        </div>
                    </div>
                </div>

                <!-- แถวที่ 8: สถานะการตรวจสอบ และ บันทึกเจ้าหน้าที่ -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-2 border-t border-[#EAE5D9]">
                    <div>
                        <label class="block text-xs font-semibold text-[#4A3B32] mb-1">
                            สถานะการตรวจสอบ <span class="text-[#C86D51]">*</span>
                        </label>
                        <select name="status" id="edit_status" required class="w-full px-3.5 py-2 bg-white border border-[#D5CEBC] rounded-xl text-xs focus:ring-2 focus:ring-[#5A6B47]">
                            <option value="PENDING">รอตรวจสอบ (PENDING)</option>
                            <option value="VERIFIED">ยืนยันยอดเงินเรียบร้อย / ออกใบอนุโมทนาบัตร (VERIFIED)</option>
                            <option value="REJECTED">ปฏิเสธ / สลิปไม่ถูกต้อง (REJECTED)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-[#4A3B32] mb-1">
                            เลขที่ใบอนุโมทนาบัตร / บันทึกเจ้าหน้าที่
                        </label>
                        <input type="text" name="admin_notes" id="edit_admin_notes" placeholder="เช่น MCU-REC-2569/089" class="w-full px-3.5 py-2 bg-white border border-[#D5CEBC] rounded-xl text-xs focus:ring-2 focus:ring-[#5A6B47]">
                    </div>
                </div>

                <div class="pt-4 border-t border-[#EAE5D9] flex justify-end gap-2.5">
                    <button type="button" onclick="closeActionModal()" class="px-4 py-2.5 bg-white border border-[#D5CEBC] hover:bg-[#FAF8F2] text-[#4A3B32] rounded-xl font-semibold">
                        ยกเลิก
                    </button>
                    <button type="submit" class="px-5 py-2.5 bg-gradient-to-r from-[#5A6B47] to-[#435235] hover:from-[#435235] hover:to-[#2C3E2D] text-white rounded-xl font-semibold shadow-sm flex items-center gap-1.5">
                        <i data-lucide="save" class="w-4 h-4"></i>
                        <span>บันทึกการแก้ไขทั้งหมด</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal: เปลี่ยนสถานะด่วน (Quick Status Change Modal) -->
    <div id="quickStatusModal" class="hidden fixed inset-0 z-50 overflow-y-auto bg-black/60 backdrop-blur-xs flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl max-w-md w-full p-6 shadow-2xl border border-[#D5CEBC] text-xs">
            <div class="flex items-center justify-between pb-3.5 mb-4 border-b border-[#EAE5D9]">
                <div class="flex items-center gap-2">
                    <span class="w-8 h-8 rounded-lg bg-[#5A6B47]/15 text-[#5A6B47] flex items-center justify-center font-bold">
                        <i data-lucide="check-check" class="w-4 h-4"></i>
                    </span>
                    <div>
                        <h3 class="font-heading font-bold text-sm text-[#2C3E2D]">เปลี่ยนสถานะการบริจาคด่วน</h3>
                        <p class="text-[10px] text-[#7B8D65]">เลขที่: <span id="quick_modal_donation_no" class="font-mono font-bold text-[#C86D51]"></span></p>
                    </div>
                </div>
                <button type="button" onclick="closeQuickStatusModal()" class="text-[#8C8275] hover:text-[#2C3E2D]">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>

            <form id="quickStatusForm" method="POST" action="{{ url('/admin/donations.php') }}" class="space-y-4">
                @csrf
                <input type="hidden" name="action" value="status">
                <input type="hidden" name="id" id="quick_donation_id">

                <div class="p-3 bg-[#FAF8F2] rounded-xl border border-[#EAE5D9] text-[11px]">
                    <span class="text-[#6B6357]">ผู้บริจาค:</span>
                    <strong id="quick_modal_donor_name" class="text-[#2C3E2D] ml-1"></strong>
                </div>

                <!-- Radio Cards for Status Selection -->
                <div class="space-y-2">
                    <label class="block text-xs font-semibold text-[#4A3B32]">
                        เลือกสถานะที่ต้องการเปลี่ยน:
                    </label>

                    <!-- PENDING Option -->
                    <label class="flex items-center justify-between p-3 rounded-xl border border-[#D5CEBC] hover:border-[#5A6B47] bg-white cursor-pointer transition">
                        <div class="flex items-center gap-2.5">
                            <input type="radio" name="status" value="PENDING" id="radio_pending" class="w-4 h-4 text-[#5A6B47] focus:ring-[#5A6B47]">
                            <div>
                                <div class="font-bold text-[#4A3B32] flex items-center gap-1.5">
                                    <i data-lucide="clock" class="w-3.5 h-3.5 text-[#C86D51]"></i>
                                    <span>รอตรวจสอบ (Pending)</span>
                                </div>
                                <div class="text-[10px] text-[#8C8275]">อยู่ระหว่างรอตรวจสอบยอดเงินหรือสลิป</div>
                            </div>
                        </div>
                    </label>

                    <!-- VERIFIED Option -->
                    <label class="flex items-center justify-between p-3 rounded-xl border border-[#D5CEBC] hover:border-[#5A6B47] bg-white cursor-pointer transition">
                        <div class="flex items-center gap-2.5">
                            <input type="radio" name="status" value="VERIFIED" id="radio_verified" class="w-4 h-4 text-[#5A6B47] focus:ring-[#5A6B47]">
                            <div>
                                <div class="font-bold text-[#5A6B47] flex items-center gap-1.5">
                                    <i data-lucide="check-circle" class="w-3.5 h-3.5 text-[#5A6B47]"></i>
                                    <span>ยืนยันแล้ว (Verified)</span>
                                </div>
                                <div class="text-[10px] text-[#7B8D65]">ยอดเงินถูกต้อง ออกใบอนุโมทนาบัตรได้</div>
                            </div>
                        </div>
                    </label>

                    <!-- REJECTED Option -->
                    <label class="flex items-center justify-between p-3 rounded-xl border border-[#D5CEBC] hover:border-red-400 bg-white cursor-pointer transition">
                        <div class="flex items-center gap-2.5">
                            <input type="radio" name="status" value="REJECTED" id="radio_rejected" class="w-4 h-4 text-[#C86D51] focus:ring-[#C86D51]">
                            <div>
                                <div class="font-bold text-[#C86D51] flex items-center gap-1.5">
                                    <i data-lucide="x-circle" class="w-3.5 h-3.5 text-[#C86D51]"></i>
                                    <span>ไม่อนุมัติ (Rejected)</span>
                                </div>
                                <div class="text-[10px] text-[#8C8275]">สลิปไม่ถูกต้อง / ไม่มียอดเงินโอนจริง</div>
                            </div>
                        </div>
                    </label>
                </div>

                <!-- Admin Notes / Receipt Number -->
                <div>
                    <label class="block text-[11px] font-semibold text-[#4A3B32] mb-1">
                        บันทึกหมายเหตุ / เลขที่ใบอนุโมทนาบัตร (ถ้ามี)
                    </label>
                    <input type="text" name="admin_notes" id="quick_modal_admin_notes" placeholder="เช่น MCU-REC-2569/089" class="w-full px-3 py-2 bg-white border border-[#D5CEBC] rounded-xl text-xs focus:ring-2 focus:ring-[#5A6B47]">
                </div>

                <div class="pt-3 border-t border-[#EAE5D9] flex justify-end gap-2">
                    <button type="button" onclick="closeQuickStatusModal()" class="px-4 py-2 bg-white border border-[#D5CEBC] hover:bg-[#FAF8F2] text-[#4A3B32] rounded-xl font-semibold">
                        ยกเลิก
                    </button>
                    <button type="submit" class="px-4 py-2 bg-[#5A6B47] hover:bg-[#465337] text-white rounded-xl font-semibold shadow-sm flex items-center gap-1.5">
                        <i data-lucide="check" class="w-4 h-4"></i>
                        <span>อัปเดตสถานะ</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal: ดูสลิปหลักฐาน (Slip Modal) -->
    <div id="slipModal" class="hidden fixed inset-0 z-50 overflow-y-auto bg-black/60 backdrop-blur-xs flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl max-w-lg w-full p-6 shadow-2xl border border-[#D5CEBC] text-center">
            <div class="flex items-center justify-between pb-3 mb-4 border-b border-[#EAE5D9]">
                <h4 id="slipModalTitle" class="font-heading font-bold text-sm text-[#2C3E2D]">สลิปหลักฐานการโอนเงิน</h4>
                <button type="button" onclick="closeSlipModal()" class="text-[#8C8275] hover:text-[#2C3E2D]">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>
            <div class="max-h-[70vh] overflow-auto rounded-2xl border border-[#EAE5D9] bg-[#FAF8F2] p-2 flex items-center justify-center">
                <img id="slipModalImage" src="#" alt="Slip Preview" class="max-w-full h-auto rounded-lg shadow-sm">
            </div>
            <div class="mt-4 flex justify-center gap-3">
                <a id="slipDownloadBtn" href="#" target="_blank" download class="px-4 py-2 bg-[#5A6B47] hover:bg-[#465337] text-white rounded-xl text-xs font-semibold flex items-center gap-1.5 shadow-sm">
                    <i data-lucide="download" class="w-3.5 h-3.5"></i>
                    <span>เปิดภาพเต็ม / ดาวน์โหลด</span>
                </a>
                <button type="button" onclick="closeSlipModal()" class="px-4 py-2 bg-white border border-[#D5CEBC] text-[#4A3B32] rounded-xl text-xs font-semibold">
                    ปิดหน้าต่าง
                </button>
            </div>
        </div>
    </div>

    <!-- Modal: ดูภาพประจำตัวผู้บริจาคสำหรับทำโปสเตอร์ (Avatar Modal) -->
    <div id="avatarModal" class="hidden fixed inset-0 z-50 overflow-y-auto bg-black/60 backdrop-blur-xs flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl max-w-md w-full p-6 shadow-2xl border border-[#D5CEBC] text-center">
            <div class="flex items-center justify-between pb-3 mb-4 border-b border-[#EAE5D9]">
                <div class="text-left">
                    <h4 id="avatarModalTitle" class="font-heading font-bold text-sm text-[#2C3E2D]">ภาพประจำตัวผู้บริจาค</h4>
                    <p class="text-[11px] text-[#7B8D65]">สำหรับจัดทำโปสเตอร์อนุโมทนาบุญ</p>
                </div>
                <button type="button" onclick="closeAvatarModal()" class="text-[#8C8275] hover:text-[#2C3E2D]">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>
            <div class="max-h-[60vh] overflow-auto rounded-2xl border border-[#EAE5D9] bg-[#FAF8F2] p-4 flex items-center justify-center">
                <img id="avatarModalImage" src="#" alt="Avatar Preview" class="max-w-full max-h-[50vh] rounded-2xl shadow-sm object-contain">
            </div>
            <div class="mt-4 flex justify-center gap-3">
                <a id="avatarDownloadBtn" href="#" target="_blank" download class="px-4 py-2 bg-[#C86D51] hover:bg-[#A85238] text-white rounded-xl text-xs font-semibold flex items-center gap-1.5 shadow-sm">
                    <i data-lucide="download" class="w-3.5 h-3.5"></i>
                    <span>ดาวน์โหลดไฟล์ต้นฉบับ</span>
                </a>
                <button type="button" onclick="closeAvatarModal()" class="px-4 py-2 bg-white border border-[#D5CEBC] text-[#4A3B32] rounded-xl text-xs font-semibold">
                    ปิดหน้าต่าง
                </button>
            </div>
        </div>
    </div>

    <!-- Modal: ตั้งค่าบัญชีรับบริจาค (Settings Modal) -->
    <div id="settingsModal" class="hidden fixed inset-0 z-50 overflow-y-auto bg-black/50 backdrop-blur-xs flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl max-w-xl w-full p-6 md:p-8 shadow-2xl border border-[#D5CEBC] text-xs">
            <div class="flex items-center justify-between pb-4 mb-4 border-b border-[#EAE5D9]">
                <div class="flex items-center gap-2">
                    <span class="w-8 h-8 rounded-lg bg-[#5A6B47]/15 text-[#5A6B47] flex items-center justify-center font-bold">
                        <i data-lucide="sliders" class="w-4 h-4"></i>
                    </span>
                    <h3 class="font-heading font-bold text-base text-[#2C3E2D]">ตั้งค่าบัญชีธนาคารสำหรับรับบริจาค</h3>
                </div>
                <button type="button" onclick="closeSettingsModal()" class="text-[#8C8275] hover:text-[#2C3E2D]">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>

            <form method="POST" action="{{ route('admin.donations.settings') }}" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-xs font-semibold text-[#4A3B32] mb-1">
                        ชื่อธนาคาร
                    </label>
                    <input type="text" name="donation_bank_name" value="{{ $donationSettings['donation_bank_name'] ?? 'ธนาคารกรุงไทย (Krungthai Bank)' }}" required class="w-full px-3.5 py-2.5 bg-white border border-[#D5CEBC] rounded-xl text-xs focus:ring-2 focus:ring-[#5A6B47]">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-[#4A3B32] mb-1">
                        ชื่อบัญชีเงินฝาก
                    </label>
                    <input type="text" name="donation_account_name" value="{{ $donationSettings['donation_account_name'] ?? 'มหาวิทยาลัยมหาจุฬาลงกรณราชวิทยาลัย (กองทุนวิปัสสนาธุระ)' }}" required class="w-full px-3.5 py-2.5 bg-white border border-[#D5CEBC] rounded-xl text-xs focus:ring-2 focus:ring-[#5A6B47]">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-[#4A3B32] mb-1">
                            เลขที่บัญชีเงินฝาก
                        </label>
                        <input type="text" name="donation_account_number" value="{{ $donationSettings['donation_account_number'] ?? '123-4-56789-0' }}" required class="w-full px-3.5 py-2.5 bg-white border border-[#D5CEBC] rounded-xl text-xs font-mono font-bold focus:ring-2 focus:ring-[#5A6B47]">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-[#4A3B32] mb-1">
                            พร้อมเพย์ (เลขผู้เสียภาษี มจร)
                        </label>
                        <input type="text" name="donation_promptpay" value="{{ $donationSettings['donation_promptpay'] ?? '0994000159451' }}" class="w-full px-3.5 py-2.5 bg-white border border-[#D5CEBC] rounded-xl text-xs font-mono font-bold focus:ring-2 focus:ring-[#5A6B47]">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-[#4A3B32] mb-1">
                        คำชี้แจงการบริจาคและการลดหย่อนภาษี
                    </label>
                    <textarea name="donation_info_notes" rows="3" class="w-full px-3.5 py-2.5 bg-white border border-[#D5CEBC] rounded-xl text-xs focus:ring-2 focus:ring-[#5A6B47]">{{ $donationSettings['donation_info_notes'] ?? '' }}</textarea>
                </div>

                <div class="pt-3 border-t border-[#EAE5D9] flex justify-end gap-2">
                    <button type="button" onclick="closeSettingsModal()" class="px-4 py-2 bg-white border border-[#D5CEBC] hover:bg-[#FAF8F2] text-[#4A3B32] rounded-xl font-semibold">
                        ยกเลิก
                    </button>
                    <button type="submit" class="px-4 py-2 bg-[#5A6B47] hover:bg-[#465337] text-white rounded-xl font-semibold shadow-sm flex items-center gap-1.5">
                        <i data-lucide="save" class="w-4 h-4"></i>
                        <span>บันทึกการตั้งค่า</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        // Modal Control Functions
        function toggleEditTaxId(checkbox) {
            const wrapper = document.getElementById('edit_tax_id_wrapper');
            if (checkbox.checked) {
                wrapper.classList.remove('hidden');
            } else {
                wrapper.classList.add('hidden');
            }
        }

        function openActionModal(donation) {
            document.getElementById('actionForm').action = "{{ url('/admin/donations.php') }}";
            document.getElementById('edit_donation_id').value = donation.id;
            document.getElementById('modal-donation-no-badge').textContent = donation.donation_no;
            
            // Populate all inputs
            document.getElementById('edit_donor_name').value = donation.donor_name || '';
            document.getElementById('edit_amount').value = donation.amount || '';
            
            const isTaxDeduct = !!donation.is_tax_deductible;
            const taxCheckbox = document.getElementById('edit_is_tax_deductible');
            taxCheckbox.checked = isTaxDeduct;
            toggleEditTaxId(taxCheckbox);
            document.getElementById('edit_tax_id').value = donation.tax_id || '';

            document.getElementById('edit_bank_account').value = donation.bank_account || '';
            
            // Format transfer_date (YYYY-MM-DD)
            let dateVal = '';
            if (donation.transfer_date) {
                dateVal = donation.transfer_date.split('T')[0];
            }
            document.getElementById('edit_transfer_date').value = dateVal;
            document.getElementById('edit_transfer_time').value = donation.transfer_time || '';

            document.getElementById('edit_phone').value = donation.phone || '';
            document.getElementById('edit_email').value = donation.email || '';
            document.getElementById('edit_purpose').value = donation.purpose || '';
            document.getElementById('edit_address').value = donation.address || '';
            document.getElementById('edit_note').value = donation.note || '';

            // Handle current slip preview button
            const slipBtnWrapper = document.getElementById('current_slip_preview_btn');
            const openSlipBtn = document.getElementById('btn_open_current_slip');
            if (donation.slip_path) {
                slipBtnWrapper.classList.remove('hidden');
                openSlipBtn.onclick = function() {
                    viewSlipModal('/storage/' + donation.slip_path, donation.donation_no);
                };
            } else {
                slipBtnWrapper.classList.add('hidden');
            }

            // Handle current avatar preview button
            const avatarBtnWrapper = document.getElementById('current_avatar_preview_btn');
            const openAvatarBtn = document.getElementById('btn_open_current_avatar');
            if (donation.avatar_path) {
                avatarBtnWrapper.classList.remove('hidden');
                openAvatarBtn.onclick = function() {
                    viewAvatarModal('/storage/' + donation.avatar_path, donation.donor_name, donation.donation_no);
                };
            } else {
                avatarBtnWrapper.classList.add('hidden');
            }

            // Reset file inputs
            document.getElementById('edit_slip_input').value = '';
            document.getElementById('edit_avatar_input').value = '';

            document.getElementById('edit_status').value = donation.status;
            document.getElementById('edit_admin_notes').value = donation.admin_notes || '';

            document.getElementById('actionModal').classList.remove('hidden');
        }

        function closeActionModal() {
            document.getElementById('actionModal').classList.add('hidden');
        }

        // Quick Status Modal Functions
        function openQuickStatusModal(id, donationNo, donorName, currentStatus, adminNotes) {
            document.getElementById('quickStatusForm').action = "{{ url('/admin/donations.php') }}";
            document.getElementById('quick_donation_id').value = id;
            document.getElementById('quick_modal_donation_no').textContent = donationNo;
            document.getElementById('quick_modal_donor_name').textContent = donorName;
            document.getElementById('quick_modal_admin_notes').value = adminNotes || '';

            // Check current radio button
            const radios = document.getElementsByName('status');
            for (let r of radios) {
                if (r.value === currentStatus) {
                    r.checked = true;
                }
            }

            document.getElementById('quickStatusModal').classList.remove('hidden');
        }

        function closeQuickStatusModal() {
            document.getElementById('quickStatusModal').classList.add('hidden');
        }

        function viewSlipModal(slipUrl, donationNo) {
            document.getElementById('slipModalTitle').textContent = 'หลักฐานสลิปการโอนเงิน [' + donationNo + ']';
            document.getElementById('slipModalImage').src = slipUrl;
            document.getElementById('slipDownloadBtn').href = slipUrl;
            document.getElementById('slipModal').classList.remove('hidden');
        }

        function closeSlipModal() {
            document.getElementById('slipModal').classList.add('hidden');
        }

        function viewAvatarModal(avatarUrl, donorName, donationNo) {
            document.getElementById('avatarModalTitle').textContent = donorName ? 'ภาพประจำตัว: ' + donorName : 'ภาพประจำตัวผู้บริจาค';
            document.getElementById('avatarModalImage').src = avatarUrl;
            document.getElementById('avatarDownloadBtn').href = avatarUrl;
            document.getElementById('avatarModal').classList.remove('hidden');
        }

        function closeAvatarModal() {
            document.getElementById('avatarModal').classList.add('hidden');
        }

        function openSettingsModal() {
            document.getElementById('settingsModal').classList.remove('hidden');
        }

        function closeSettingsModal() {
            document.getElementById('settingsModal').classList.add('hidden');
        }

        // Render Monthly Trend Chart
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('donationChart').getContext('2d');
            
            @php
                $chartLabels = $monthlyStats->pluck('month')->map(function($m) {
                    return date('M Y', strtotime($m . '-01'));
                })->toArray();
                $chartValues = $monthlyStats->pluck('total_amount')->toArray();
            @endphp

            const chartLabels = {!! json_encode($chartLabels) !!};
            const chartValues = {!! json_encode($chartValues) !!};

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: chartLabels.length ? chartLabels : ['ก.ย. 2569', 'ต.ค. 2569'],
                    datasets: [{
                        label: 'ยอดเงินบริจาค (บาท)',
                        data: chartValues.length ? chartValues : [18500, 0],
                        backgroundColor: '#5A6B47',
                        borderColor: '#435235',
                        borderWidth: 1,
                        borderRadius: 8,
                        hoverBackgroundColor: '#C86D51',
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { color: '#EAE5D9' },
                            ticks: {
                                font: { family: 'Inter', size: 11 },
                                callback: function(value) { return value.toLocaleString() + ' ฿'; }
                            }
                        },
                        x: {
                            grid: { display: false },
                            ticks: { font: { family: 'Prompt', size: 11 } }
                        }
                    },
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return 'ยอดเงิน: ' + Number(context.raw).toLocaleString('th-TH') + ' บาท';
                                }
                            }
                        }
                    }
                }
            });
        });

        lucide.createIcons();
    </script>
</body>
</html>
