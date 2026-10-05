<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>รายงานสถิติวิปัสสนา - VPSMCU Admin</title>
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
            border-radius: 1.25rem;
        }
    </style>
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/mcu-logo.png') }}">
    <link rel="shortcut icon" href="{{ asset('images/mcu-logo.png') }}">
</head>
<body class="antialiased min-h-screen flex flex-col md:flex-row selection:bg-[#5A6B47] selection:text-white">

    <!-- Earth Tones Sidebar (Deep Forest & Olive) with Collapsible Submenus -->
    @include('admin.layouts.sidebar')

    <!-- Main Content -->
    <main class="flex-grow p-6 md:p-10 overflow-y-auto">
        <div class="flex flex-col sm:flex-row justify-between sm:items-center pb-6 mb-8 border-b border-[#D5CEBC] gap-4">
            <div>
                <h1 class="text-2xl font-heading font-bold text-[#2C3E2D]">รายงานสถิติวิปัสสนา (โมดูล 3)</h1>
                <p class="text-xs text-[#7B8D65] mt-1 font-medium">สถิติผู้เข้ารับการอบรมคอร์สวิปัสสนากรรมฐานสำหรับประชาชนและการบริการวิชาการแก่สังคม มจร</p>
            </div>
            <button onclick="window.print()" class="bg-[#5A6B47] hover:bg-[#2C3E2D] text-white px-4 py-2.5 rounded-xl text-xs font-medium shadow-md transition flex items-center gap-2 self-start sm:self-auto">
                <i data-lucide="printer" class="w-4 h-4"></i> พิมพ์รายงานสรุป
            </button>
        </div>

        <!-- Summary Stat Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-4 gap-5 mb-6">
            <div class="earth-admin-card p-5">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-xs text-[#7B8D65] font-medium">ยอดผู้สมัครทั้งหมด</span>
                    <div class="w-8 h-8 rounded-xl bg-[#5A6B47]/15 text-[#5A6B47] flex items-center justify-center">
                        <i data-lucide="users" class="w-4 h-4"></i>
                    </div>
                </div>
                <div class="text-2xl font-heading font-bold text-[#2C3E2D] mt-1">{{ number_format($total_registered) }} <span class="text-xs text-[#7B8D65] font-normal">ท่าน</span></div>
            </div>
            <div class="earth-admin-card p-5">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-xs text-amber-700 font-medium">รอการตรวจสอบ (Pending)</span>
                    <div class="w-8 h-8 rounded-xl bg-amber-100 text-amber-800 flex items-center justify-center">
                        <i data-lucide="clock" class="w-4 h-4"></i>
                    </div>
                </div>
                <div class="text-2xl font-heading font-bold text-amber-700 mt-1">{{ number_format($pending_count ?? 0) }} <span class="text-xs text-[#7B8D65] font-normal">ท่าน</span></div>
            </div>
            <div class="earth-admin-card p-5">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-xs text-[#5A6B47] font-medium">อนุมัติสิทธิ์แล้ว (Confirmed)</span>
                    <div class="w-8 h-8 rounded-xl bg-[#5A6B47]/15 text-[#5A6B47] flex items-center justify-center">
                        <i data-lucide="check-circle-2" class="w-4 h-4"></i>
                    </div>
                </div>
                <div class="text-2xl font-heading font-bold text-[#5A6B47] mt-1">{{ number_format($confirmed_count) }} <span class="text-xs text-[#7B8D65] font-normal">ท่าน</span></div>
            </div>
            <div class="earth-admin-card p-5">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-xs text-[#C86D51] font-medium">บัญชีสำรอง (Waiting List)</span>
                    <div class="w-8 h-8 rounded-xl bg-[#C86D51]/15 text-[#C86D51] flex items-center justify-center">
                        <i data-lucide="hourglass" class="w-4 h-4"></i>
                    </div>
                </div>
                <div class="text-2xl font-heading font-bold text-[#C86D51] mt-1">{{ number_format($waiting_count) }} <span class="text-xs text-[#7B8D65] font-normal">ท่าน</span></div>
            </div>
        </div>

        <!-- Demographic Analysis for Academic Service -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div class="earth-admin-card p-5">
                <h3 class="font-heading font-bold text-[#2C3E2D] text-sm mb-4 flex items-center gap-2">
                    <i data-lucide="pie-chart" class="w-4 h-4 text-[#5A6B47]"></i>
                    <span>สถิติจำแนกตามช่วงอายุ (Age Distribution)</span>
                </h3>
                <div class="space-y-3.5">
                    @foreach ($age_stats as $a)
                        <div>
                            <div class="flex justify-between text-xs mb-1.5 text-[#4A3B32]">
                                <span class="font-medium">{{ $a->age_group }}</span>
                                <span class="font-bold text-[#2C3E2D]">{{ $a->count }} คน</span>
                            </div>
                            <div class="w-full bg-[#FAF8F2] border border-[#EAE5D9] rounded-full h-2.5 overflow-hidden">
                                <div class="bg-[#5A6B47] h-2.5 rounded-full" style="width: {{ $total_registered > 0 ? ($a->count / $total_registered) * 100 : 0 }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="earth-admin-card p-5">
                <h3 class="font-heading font-bold text-[#2C3E2D] text-sm mb-4 flex items-center gap-2">
                    <i data-lucide="users-2" class="w-4 h-4 text-[#C86D51]"></i>
                    <span>สถิติจำแนกตามเพศสภาพ (Gender Ratio)</span>
                </h3>
                <div class="space-y-3.5">
                    @foreach ($gender_stats as $g)
                        <div>
                            <div class="flex justify-between text-xs mb-1.5 text-[#4A3B32]">
                                <span class="font-medium">{{ $g->gender === 'MALE' ? 'ชาย' : ($g->gender === 'FEMALE' ? 'หญิง' : 'ไม่ระบุ') }}</span>
                                <span class="font-bold text-[#2C3E2D]">{{ $g->count }} คน</span>
                            </div>
                            <div class="w-full bg-[#FAF8F2] border border-[#EAE5D9] rounded-full h-2.5 overflow-hidden">
                                <div class="bg-[#C86D51] h-2.5 rounded-full" style="width: {{ $total_registered > 0 ? ($g->count / $total_registered) * 100 : 0 }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Flash Messages -->
        @if (session('success'))
            <div class="mb-6 p-4 rounded-xl bg-[#5A6B47]/10 border border-[#5A6B47]/30 text-[#2C3E2D] flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <i data-lucide="check-circle" class="w-5 h-5 text-[#5A6B47]"></i>
                    <span class="text-sm font-medium">{{ session('success') }}</span>
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="text-[#8C8275] hover:text-[#2C3E2D]">
                    <i data-lucide="x" class="w-4 h-4"></i>
                </button>
            </div>
        @endif

        @if (session('error'))
            <div class="mb-6 p-4 rounded-xl bg-[#C86D51]/10 border border-[#C86D51]/30 text-[#C86D51] flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <i data-lucide="alert-circle" class="w-5 h-5 text-[#C86D51]"></i>
                    <span class="text-sm font-medium">{{ session('error') }}</span>
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="text-[#8C8275] hover:text-[#C86D51]">
                    <i data-lucide="x" class="w-4 h-4"></i>
                </button>
            </div>
        @endif

        <!-- Filter & Search Bar -->
        <div class="earth-admin-card p-4 mb-6">
            <form method="GET" action="{{ route('admin.public.sar') }}" class="flex flex-col lg:flex-row items-center justify-between gap-4">
                <div class="flex flex-wrap items-center gap-3 w-full lg:w-auto">
                    <div class="relative w-full sm:w-64">
                        <i data-lucide="search" class="w-4 h-4 text-[#8C8275] absolute left-3 top-2.5"></i>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="ค้นหาชื่อ-สกุล, เบอร์โทร, ลำดับคิว..." class="w-full pl-9 pr-3 py-1.5 text-xs bg-[#FAF8F2] border border-[#EAE5D9] rounded-lg text-[#2C3E2D] focus:ring-1 focus:ring-[#5A6B47]">
                    </div>

                    <select name="event_id" onchange="this.form.submit()" class="px-3 py-1.5 text-xs bg-[#FAF8F2] border border-[#EAE5D9] rounded-lg text-[#2C3E2D] font-medium focus:ring-1 focus:ring-[#5A6B47] max-w-xs truncate">
                        <option value="">-- ทุกโครงการบริการสังคม --</option>
                        @foreach ($events as $ev)
                            <option value="{{ $ev->id }}" {{ request('event_id') == $ev->id ? 'selected' : '' }}>
                                {{ $ev->title }}
                            </option>
                        @endforeach
                    </select>

                    <select name="status" onchange="this.form.submit()" class="px-3 py-1.5 text-xs bg-[#FAF8F2] border border-[#EAE5D9] rounded-lg text-[#2C3E2D] font-medium focus:ring-1 focus:ring-[#5A6B47]">
                        <option value="">-- ทุกสถานะ --</option>
                        <option value="CONFIRMED" {{ request('status') === 'CONFIRMED' ? 'selected' : '' }}>ได้รับสิทธิ์เข้าร่วม (Confirmed)</option>
                        <option value="WAITING_LIST" {{ request('status') === 'WAITING_LIST' ? 'selected' : '' }}>รายชื่อสำรอง (Waiting List)</option>
                        <option value="ATTENDED" {{ request('status') === 'ATTENDED' ? 'selected' : '' }}>เข้าร่วมอบรมแล้ว</option>
                        <option value="CANCELLED" {{ request('status') === 'CANCELLED' ? 'selected' : '' }}>ยกเลิก</option>
                    </select>

                    @if ($isCentralOrSuper)
                        <select name="filter_org" onchange="this.form.submit()" class="px-3 py-1.5 text-xs bg-[#FAF8F2] border border-[#EAE5D9] rounded-lg text-[#2C3E2D] font-medium focus:ring-1 focus:ring-[#5A6B47] max-w-xs truncate">
                            <option value="">-- ทุกส่วนงาน (52 ส่วนงาน) --</option>
                            @foreach ($orgUnits as $org)
                                <option value="{{ $org->id }}" {{ request('filter_org') == $org->id ? 'selected' : '' }}>
                                    {{ $org->name_th }}
                                </option>
                            @endforeach
                        </select>
                    @endif

                    <button type="submit" class="bg-[#5A6B47] hover:bg-[#2C3E2D] text-white px-3.5 py-1.5 rounded-lg text-xs font-medium transition flex items-center gap-1.5">
                        <i data-lucide="filter" class="w-3.5 h-3.5"></i> ค้นหา
                    </button>

                    @if(request()->hasAny(['search', 'event_id', 'status', 'filter_org']))
                        <a href="{{ route('admin.public.sar') }}" class="text-xs text-[#C86D51] hover:underline flex items-center gap-1">
                            <i data-lucide="rotate-ccw" class="w-3 h-3"></i> ล้างตัวกรอง
                        </a>
                    @endif
                </div>
                <div class="text-xs text-[#7B8D65] self-end lg:self-auto whitespace-nowrap">
                    พบทั้งหมด <strong>{{ $registrations->total() }}</strong> คน
                </div>
            </form>
        </div>

        <!-- Participants Table with Bulk Actions -->
        <div class="earth-admin-card overflow-hidden">
            <form id="bulk-form" method="POST" action="{{ route('admin.public.sar.bulk') }}">
                @csrf
                <div class="p-5 border-b border-[#EAE5D9] flex flex-wrap justify-between items-center gap-4 bg-[#FAF8F2]/60">
                    <h2 class="font-heading font-bold text-[#2C3E2D] flex items-center gap-2">
                        <i data-lucide="user-check" class="w-4 h-4 text-[#5A6B47]"></i>
                        <span>รายชื่อประชาชนที่ลงทะเบียน</span>
                    </h2>
                    <div class="flex items-center gap-3">
                        <div class="flex items-center gap-1.5 text-xs text-[#7B8D65]">
                            <span>แสดง:</span>
                            <select onchange="location.href=this.value" class="px-2 py-1 text-xs bg-white border border-[#D5CEBC] rounded-lg text-[#2C3E2D] focus:ring-1 focus:ring-[#5A6B47]">
                                <option value="{{ request()->fullUrlWithQuery(['per_page' => 10, 'page' => 1]) }}" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                                <option value="{{ request()->fullUrlWithQuery(['per_page' => 20, 'page' => 1]) }}" {{ request('per_page', 20) == 20 ? 'selected' : '' }}>20</option>
                                <option value="{{ request()->fullUrlWithQuery(['per_page' => 50, 'page' => 1]) }}" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                                <option value="{{ request()->fullUrlWithQuery(['per_page' => 100, 'page' => 1]) }}" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                                <option value="{{ request()->fullUrlWithQuery(['per_page' => 'all', 'page' => 1]) }}" {{ request('per_page') === 'all' ? 'selected' : '' }}>ทั้งหมด (All)</option>
                            </select>
                            <span>รายการ/หน้า</span>
                        </div>
                        <span class="text-xs bg-[#FAF8F2] border border-[#EAE5D9] px-3 py-1 rounded-full text-[#7B8D65] font-medium">ทั้งหมด {{ $registrations->total() }} คน</span>
                    </div>
                </div>

                <!-- Bulk Action Bar -->
                <div id="bulk-action-bar" class="p-3 bg-[#5A6B47]/10 border-b border-[#5A6B47]/20 flex flex-wrap items-center justify-between gap-3 text-xs">
                    <div class="flex items-center gap-2 font-medium text-[#2C3E2D]">
                        <i data-lucide="check-square" class="w-4 h-4 text-[#5A6B47]"></i>
                        <span>เลือกแล้ว <strong id="selected-count" class="text-[#5A6B47]">0</strong> รายการ</span>
                    </div>
                    <div class="flex flex-wrap items-center gap-2">
                        <select name="bulk_action" id="bulk-action-select" class="px-3 py-1.5 text-xs bg-white border border-[#D5CEBC] rounded-lg text-[#2C3E2D] font-medium focus:ring-1 focus:ring-[#5A6B47]">
                            <option value="">-- เลือกการจัดการจำนวนมาก (Bulk Action) --</option>
                            <option value="CONFIRMED">ยืนยันสิทธิ์เข้าร่วม (Confirmed)</option>
                            <option value="ATTENDED">บันทึกเข้าร่วมอบรมแล้ว (Attended)</option>
                            <option value="WAITING_LIST">ปรับเป็นรายชื่อสำรอง (Waiting List)</option>
                            <option value="CANCELLED">ยกเลิกสิทธิ์ (Cancelled)</option>
                            <option value="DELETE">ลบข้อมูลที่เลือก (Delete)</option>
                        </select>
                        <button type="button" onclick="submitBulkAction()" class="bg-[#2C3E2D] hover:bg-[#1E2B1F] text-white px-4 py-1.5 rounded-lg text-xs font-medium shadow-sm transition flex items-center gap-1.5">
                            <i data-lucide="play" class="w-3.5 h-3.5"></i> นำไปใช้ (Apply)
                        </button>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs text-[#4A3B32]">
                        <thead class="bg-[#FAF8F2] text-[#4A3B32] font-heading border-b border-[#EAE5D9] uppercase text-[11px]">
                            <tr>
                                <th class="p-4 w-10 text-center">
                                    <input type="checkbox" id="select-all" onclick="toggleSelectAll(this)" class="rounded text-[#5A6B47] focus:ring-[#5A6B47]">
                                </th>
                                <th class="p-4">รหัสสมัคร</th>
                                <th class="p-4">ชื่อ - สกุล</th>
                                <th class="p-4">โครงการที่สมัคร</th>
                                <th class="p-4">ที่พำนัก / ประเภทอาหาร</th>
                                <th class="p-4 text-center">สถานะ</th>
                                <th class="p-4 text-right">ดำเนินการ (Action)</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#EAE5D9]">
                            @forelse ($registrations as $r)
                                <tr class="hover:bg-[#FAF8F2]/80 transition">
                                    <td class="p-4 text-center">
                                        <input type="checkbox" name="selected_ids[]" value="{{ $r->id }}" onchange="updateSelectedCount()" class="row-checkbox rounded text-[#5A6B47] focus:ring-[#5A6B47]">
                                    </td>
                                    <td class="p-4 font-mono font-bold text-[#C86D51]">Q-{{ str_pad($r->queue_no, 3, '0', STR_PAD_LEFT) }}</td>
                                    <td class="p-4">
                                        <div class="font-heading font-semibold text-[#2C3E2D] text-sm">
                                            {{ $r->full_name }}
                                        </div>
                                        <div class="text-[11px] text-[#7B8D65]">โทร: {{ $r->phone }} (อายุ {{ $r->age }} ปี)</div>
                                    </td>
                                    <td class="p-4">
                                        <div class="font-medium text-[#2C3E2D]">{{ $r->event->title ?? '-' }}</div>
                                        <div class="text-[10px] text-[#7B8D65]">{{ $r->event->organizationUnit->name_th ?? 'มจร' }}</div>
                                    </td>
                                    <td class="p-4">
                                        <div class="text-[#2C3E2D]">{{ $r->province ?: '-' }}</div>
                                        <div class="text-[10px] text-[#C86D51] font-medium">อาหาร: {{ $r->dietary_restriction ?: 'ทั่วไป' }}</div>
                                    </td>
                                    <td class="p-4 text-center">
                                        @if ($r->status === 'CONFIRMED')
                                            <span class="px-3 py-1 rounded-full text-[11px] font-semibold bg-[#5A6B47]/15 text-[#5A6B47] border border-[#5A6B47]/30 inline-flex items-center gap-1">
                                                <i data-lucide="check" class="w-3.5 h-3.5"></i> ได้สิทธิ์เข้าร่วม
                                            </span>
                                        @elseif ($r->status === 'ATTENDED')
                                            <span class="px-3 py-1 rounded-full text-[11px] font-semibold bg-[#2C3E2D]/15 text-[#2C3E2D] border border-[#2C3E2D]/30 inline-flex items-center gap-1">
                                                <i data-lucide="check-check" class="w-3.5 h-3.5"></i> เข้าร่วมอบรมแล้ว
                                            </span>
                                        @elseif ($r->status === 'CANCELLED')
                                            <span class="px-3 py-1 rounded-full text-[11px] font-semibold bg-[#8C8275]/15 text-[#8C8275] border border-[#8C8275]/30 inline-flex items-center gap-1">
                                                <i data-lucide="x" class="w-3.5 h-3.5"></i> ยกเลิก
                                            </span>
                                        @else
                                            <span class="px-3 py-1 rounded-full text-[11px] font-semibold bg-[#C86D51]/15 text-[#C86D51] border border-[#C86D51]/30 inline-flex items-center gap-1">
                                                <i data-lucide="clock" class="w-3.5 h-3.5"></i> สำรอง (Waiting)
                                            </span>
                                        @endif
                                    </td>
                                    <td class="p-4 text-right space-x-1.5 whitespace-nowrap">
                                        <!-- View Details -->
                                        <button type="button"
                                            onclick="openViewPublicModal({
                                                id: {{ $r->id }},
                                                queue_no: 'Q-{{ str_pad($r->queue_no, 3, '0', STR_PAD_LEFT) }}',
                                                prefix: @js($r->prefix ?? ''),
                                                full_name: @js($r->full_name),
                                                age: {{ $r->age ?? 0 }},
                                                gender: @js($r->gender),
                                                phone: @js($r->phone),
                                                email: @js($r->email ?? '-'),
                                                province: @js($r->province ?? '-'),
                                                dietary: @js($r->dietary_restriction ?? 'ทั่วไป'),
                                                medical: @js($r->medical_condition ?? '-'),
                                                applicant_type: @js($r->applicant_type),
                                                student_id: @js($r->student_id ?? ''),
                                                degree_level: @js($r->degree_level ?? ''),
                                                faculty: @js($r->faculty ?? ''),
                                                program_name: @js($r->program_name ?? ''),
                                                student_org: @js($r->organizationUnit->name_th ?? ''),
                                                event_title: @js($r->event->title ?? '-'),
                                                org_name: @js($r->event->organizationUnit->name_th ?? 'มจร'),
                                                event_dates: @js(($r->event->start_date ?? '') . ' ถึง ' . ($r->event->end_date ?? '')),
                                                registered_at: @js($r->registered_at ?? '-'),
                                                status: @js($r->status)
                                            })"
                                            title="ดูรายละเอียดข้อมูลผู้สมัคร"
                                            class="p-1.5 bg-[#FAF8F2] hover:bg-[#5A6B47]/15 text-[#2C3E2D] rounded-lg border border-[#EAE5D9] transition inline-flex items-center">
                                            <i data-lucide="eye" class="w-3.5 h-3.5"></i>
                                        </button>

                                        <!-- Edit Participant -->
                                        <button type="button"
                                            onclick="openEditPublicModal({
                                                id: {{ $r->id }},
                                                prefix: @js($r->prefix ?? ''),
                                                full_name: @js($r->full_name),
                                                age: {{ $r->age ?? 0 }},
                                                gender: @js($r->gender),
                                                phone: @js($r->phone),
                                                email: @js($r->email ?? ''),
                                                province: @js($r->province ?? ''),
                                                dietary_restriction: @js($r->dietary_restriction ?? ''),
                                                medical_condition: @js($r->medical_condition ?? ''),
                                                status: @js($r->status)
                                            })"
                                            title="แก้ไขข้อมูลผู้สมัคร"
                                            class="p-1.5 bg-[#FAF8F2] hover:bg-[#5A6B47]/15 text-[#5A6B47] rounded-lg border border-[#EAE5D9] transition inline-flex items-center">
                                            <i data-lucide="pencil" class="w-3.5 h-3.5"></i>
                                        </button>

                                        <!-- Delete Participant -->
                                        <a href="{{ route('admin.public.sar.delete', ['id' => $r->id]) }}" onclick="return confirm('ยืนยันลบข้อมูลผู้สมัครเข้าร่วมท่านนี้หรือไม่?')" title="ลบข้อมูล" class="p-1.5 bg-red-50 hover:bg-red-100 text-red-600 rounded-lg border border-red-200 transition inline-flex items-center">
                                            <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-10 text-[#8C8275]">
                                        <i data-lucide="inbox" class="w-8 h-8 mx-auto mb-2 text-[#D5CEBC]"></i>
                                        <div>ยังไม่มีรายการลงทะเบียนของประชาชนในระบบ</div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($registrations->hasPages())
                    <div class="p-4 border-t border-[#EAE5D9] bg-[#FAF8F2]/60">
                        {{ $registrations->links() }}
                    </div>
                @endif
            </form>
        </div>

    </main>

    <!-- Modal: ดูรายละเอียดผู้สมัครภาคประชาชน (View Details) -->
    <div id="view-public-modal" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4 hidden">
        <div class="bg-white rounded-3xl border border-[#EAE5D9] shadow-2xl max-w-xl w-full p-6 md:p-8 overflow-y-auto max-h-[90vh]">
            <div class="flex justify-between items-center pb-4 border-b border-[#EAE5D9] mb-5">
                <div class="flex items-center gap-2.5">
                    <div class="w-9 h-9 rounded-xl bg-[#5A6B47]/15 text-[#5A6B47] flex items-center justify-center">
                        <i data-lucide="user" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-heading font-bold text-[#2C3E2D]">รายละเอียดผู้สมัครอบรมวิปัสสนา</h3>
                        <p class="text-xs text-[#7B8D65]" id="view_public_queue">ลำดับคิว</p>
                    </div>
                </div>
                <button type="button" onclick="document.getElementById('view-public-modal').classList.add('hidden')" class="p-1.5 text-[#8C8275] hover:text-[#2C3E2D] rounded-lg">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>

            <div class="space-y-4 text-xs">
                <!-- Status & Date -->
                <div class="p-3.5 rounded-2xl bg-[#FAF8F2] border border-[#EAE5D9] flex flex-wrap items-center justify-between gap-3">
                    <div>
                        <span class="text-[10px] text-[#7B8D65] block">สถานะปัจจุบัน</span>
                        <span id="view_public_status_badge" class="font-bold text-xs"></span>
                    </div>
                    <div>
                        <span class="text-[10px] text-[#7B8D65] block">วันที่สมัครเข้าร่วม</span>
                        <span id="view_public_registered_at" class="font-mono text-[#2C3E2D] font-medium">-</span>
                    </div>
                </div>

                <!-- Personal Info -->
                <div class="border border-[#EAE5D9] rounded-2xl p-4 space-y-2 bg-white">
                    <h4 class="font-heading font-bold text-[#2C3E2D] text-xs flex items-center gap-1.5 border-b border-[#FAF8F2] pb-2">
                        <i data-lucide="id-card" class="w-3.5 h-3.5 text-[#5A6B47]"></i> ข้อมูลส่วนบุคคล
                    </h4>
                    <div class="grid grid-cols-2 gap-2 text-[#4A3B32]">
                        <div><span class="text-[#7B8D65]">ชื่อ-สกุล:</span> <strong id="view_public_name" class="text-[#2C3E2D]"></strong></div>
                        <div><span class="text-[#7B8D65]">อายุ:</span> <span id="view_public_age"></span> ปี</div>
                        <div><span class="text-[#7B8D65]">เพศ:</span> <span id="view_public_gender"></span></div>
                        <div><span class="text-[#7B8D65]">จังหวัดที่พำนัก:</span> <span id="view_public_province"></span></div>
                        <div><span class="text-[#7B8D65]">เบอร์โทร:</span> <span id="view_public_phone" class="font-mono"></span></div>
                        <div><span class="text-[#7B8D65]">อีเมล:</span> <span id="view_public_email" class="font-mono"></span></div>
                    </div>
                </div>

                <!-- Student Info (MCU) -->
                <div id="view_student_section" class="hidden border border-blue-200 bg-blue-50/40 rounded-2xl p-4 space-y-2">
                    <h4 class="font-heading font-bold text-[#2C3E2D] text-xs flex items-center gap-1.5 border-b border-blue-200/60 pb-2">
                        <i data-lucide="graduation-cap" class="w-3.5 h-3.5 text-blue-600"></i> ข้อมูลนิสิต มจร
                    </h4>
                    <div class="grid grid-cols-2 gap-2 text-[#4A3B32]">
                        <div><span class="text-[#7B8D65]">รหัสนิสิต:</span> <strong id="view_student_code" class="text-blue-800 font-mono"></strong></div>
                        <div><span class="text-[#7B8D65]">ระดับการศึกษา:</span> <span id="view_student_degree" class="font-medium text-[#2C3E2D]"></span></div>
                        <div><span class="text-[#7B8D65]">คณะ:</span> <span id="view_student_faculty"></span></div>
                        <div><span class="text-[#7B8D65]">หลักสูตร/สาขา:</span> <span id="view_student_program"></span></div>
                        <div class="col-span-2"><span class="text-[#7B8D65]">ส่วนจัดการศึกษา:</span> <span id="view_student_org" class="font-medium text-[#2C3E2D]"></span></div>
                    </div>
                </div>

                <!-- Event Info & Health -->
                <div class="border border-[#EAE5D9] rounded-2xl p-4 space-y-2 bg-white">
                    <h4 class="font-heading font-bold text-[#2C3E2D] text-xs flex items-center gap-1.5 border-b border-[#FAF8F2] pb-2">
                        <i data-lucide="clipboard-list" class="w-3.5 h-3.5 text-[#5A6B47]"></i> โครงการอบรมและข้อจำกัดสุขภาพ
                    </h4>
                    <div class="space-y-1.5 text-[#4A3B32]">
                        <div><span class="text-[#7B8D65]">โครงการ:</span> <strong id="view_public_event" class="text-[#2C3E2D]"></strong></div>
                        <div><span class="text-[#7B8D65]">ส่วนงานจัดอบรม:</span> <span id="view_public_org"></span></div>
                        <div class="text-[11px] text-[#7B8D65]">ช่วงเวลาจัด: <span id="view_public_dates"></span></div>
                        <div class="pt-2 border-t border-[#FAF8F2] grid grid-cols-2 gap-2">
                            <div><span class="text-[#7B8D65]">ประเภทอาหาร:</span> <span id="view_public_dietary" class="font-medium text-[#C86D51]"></span></div>
                            <div><span class="text-[#7B8D65]">โรคประจำตัว:</span> <span id="view_public_medical"></span></div>
                        </div>
                    </div>
                </div>

                <div class="pt-3 border-t border-[#EAE5D9] flex justify-end">
                    <button type="button" onclick="document.getElementById('view-public-modal').classList.add('hidden')" class="px-5 py-2 bg-[#2C3E2D] text-white rounded-xl text-xs font-medium hover:bg-[#1E2B1F] transition">
                        ปิดหน้าต่าง
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal: แก้ไขข้อมูลผู้สมัครภาคประชาชน (Edit Modal) -->
    <div id="edit-public-modal" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4 hidden">
        <div class="bg-white rounded-3xl border border-[#EAE5D9] shadow-2xl max-w-xl w-full p-6 md:p-8 overflow-y-auto max-h-[90vh]">
            <div class="flex justify-between items-center pb-4 border-b border-[#EAE5D9] mb-5">
                <div>
                    <h3 class="text-lg font-heading font-bold text-[#2C3E2D]">แก้ไขข้อมูลผู้สมัคร (ภาคประชาชน)</h3>
                    <p class="text-xs text-[#7B8D65]">แก้ไขข้อมูลการติดต่อ ข้อมูลสุขภาพ และสถานะการได้รับสิทธิ์</p>
                </div>
                <button type="button" onclick="document.getElementById('edit-public-modal').classList.add('hidden')" class="p-1.5 text-[#8C8275] hover:text-[#2C3E2D] rounded-lg">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>

            <form id="edit-public-form" method="POST" class="space-y-4 text-xs">
                @csrf
                <div class="grid grid-cols-3 gap-3">
                    <div>
                        <label class="block font-semibold text-[#4A3B32] mb-1">คำนำหน้า</label>
                        <input type="text" id="edit_pub_prefix" name="prefix" placeholder="เช่น นาย/นาง/คุณ" class="w-full px-3 py-2 bg-[#FAF8F2] border border-[#EAE5D9] rounded-xl text-xs focus:ring-1 focus:ring-[#5A6B47]">
                    </div>
                    <div class="col-span-2">
                        <label class="block font-semibold text-[#4A3B32] mb-1">ชื่อ - นามสกุล <span class="text-[#C86D51]">*</span></label>
                        <input type="text" id="edit_pub_name" name="full_name" required class="w-full px-3 py-2 bg-[#FAF8F2] border border-[#EAE5D9] rounded-xl text-xs focus:ring-1 focus:ring-[#5A6B47]">
                    </div>
                </div>

                <div class="grid grid-cols-3 gap-3">
                    <div>
                        <label class="block font-semibold text-[#4A3B32] mb-1">อายุ (ปี)</label>
                        <input type="number" id="edit_pub_age" name="age" min="1" max="120" class="w-full px-3 py-2 bg-[#FAF8F2] border border-[#EAE5D9] rounded-xl text-xs focus:ring-1 focus:ring-[#5A6B47]">
                    </div>
                    <div>
                        <label class="block font-semibold text-[#4A3B32] mb-1">เพศสภาพ <span class="text-[#C86D51]">*</span></label>
                        <select id="edit_pub_gender" name="gender" required class="w-full px-3 py-2 bg-[#FAF8F2] border border-[#EAE5D9] rounded-xl text-xs focus:ring-1 focus:ring-[#5A6B47]">
                            <option value="MALE">ชาย (Male)</option>
                            <option value="FEMALE">หญิง (Female)</option>
                            <option value="OTHER">อื่น ๆ (Other)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block font-semibold text-[#4A3B32] mb-1">จังหวัดที่พำนัก</label>
                        <input type="text" id="edit_pub_province" name="province" class="w-full px-3 py-2 bg-[#FAF8F2] border border-[#EAE5D9] rounded-xl text-xs focus:ring-1 focus:ring-[#5A6B47]">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block font-semibold text-[#4A3B32] mb-1">เบอร์โทรศัพท์ <span class="text-[#C86D51]">*</span></label>
                        <input type="text" id="edit_pub_phone" name="phone" required class="w-full px-3 py-2 bg-[#FAF8F2] border border-[#EAE5D9] rounded-xl text-xs focus:ring-1 focus:ring-[#5A6B47] font-mono">
                    </div>
                    <div>
                        <label class="block font-semibold text-[#4A3B32] mb-1">อีเมล</label>
                        <input type="email" id="edit_pub_email" name="email" class="w-full px-3 py-2 bg-[#FAF8F2] border border-[#EAE5D9] rounded-xl text-xs focus:ring-1 focus:ring-[#5A6B47] font-mono">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block font-semibold text-[#4A3B32] mb-1">อาหารที่รับประทาน</label>
                        <input type="text" id="edit_pub_dietary" name="dietary_restriction" placeholder="เช่น มังสวิรัติ, เจ, ทั่วไป" class="w-full px-3 py-2 bg-[#FAF8F2] border border-[#EAE5D9] rounded-xl text-xs focus:ring-1 focus:ring-[#5A6B47]">
                    </div>
                    <div>
                        <label class="block font-semibold text-[#4A3B32] mb-1">โรคประจำตัว / ข้อจำกัด</label>
                        <input type="text" id="edit_pub_medical" name="medical_condition" placeholder="เช่น ความดัน, เบาหวาน (ถ้ามี)" class="w-full px-3 py-2 bg-[#FAF8F2] border border-[#EAE5D9] rounded-xl text-xs focus:ring-1 focus:ring-[#5A6B47]">
                    </div>
                </div>

                <div>
                    <label class="block font-semibold text-[#4A3B32] mb-1">สถานะการสมัครเข้าร่วม <span class="text-[#C86D51]">*</span></label>
                    <select id="edit_pub_status" name="status" required class="w-full px-3 py-2 bg-[#FAF8F2] border border-[#EAE5D9] rounded-xl text-xs focus:ring-1 focus:ring-[#5A6B47]">
                        <option value="CONFIRMED">ได้รับสิทธิ์เข้าร่วม (Confirmed)</option>
                        <option value="WAITING_LIST">รายชื่อสำรอง (Waiting List)</option>
                        <option value="ATTENDED">เข้าร่วมอบรมแล้ว (Attended)</option>
                        <option value="CANCELLED">ยกเลิกการเข้าร่วม (Cancelled)</option>
                    </select>
                </div>

                <div class="pt-4 border-t border-[#EAE5D9] flex justify-end gap-2.5">
                    <button type="button" onclick="document.getElementById('edit-public-modal').classList.add('hidden')" class="px-4 py-2 text-[#6B6357] hover:text-[#2C3E2D] rounded-xl">ยกเลิก</button>
                    <button type="submit" class="px-5 py-2 bg-[#5A6B47] hover:bg-[#2C3E2D] text-white rounded-xl font-medium shadow-md transition flex items-center gap-1.5">
                        <i data-lucide="check" class="w-4 h-4"></i>
                        <span>บันทึกการแก้ไข</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openViewPublicModal(data) {
            document.getElementById('view_public_queue').innerText = 'ลำดับคิวการสมัคร: ' + data.queue_no;
            document.getElementById('view_public_name').innerText = (data.prefix ? data.prefix + ' ' : '') + data.full_name;
            document.getElementById('view_public_age').innerText = data.age || '-';
            document.getElementById('view_public_gender').innerText = data.gender === 'MALE' ? 'ชาย' : (data.gender === 'FEMALE' ? 'หญิง' : 'อื่น ๆ');
            document.getElementById('view_public_province').innerText = data.province;
            document.getElementById('view_public_phone').innerText = data.phone;
            document.getElementById('view_public_email').innerText = data.email;
            document.getElementById('view_public_event').innerText = data.event_title;
            document.getElementById('view_public_org').innerText = data.org_name;
            document.getElementById('view_public_dates').innerText = data.event_dates;
            document.getElementById('view_public_dietary').innerText = data.dietary;
            document.getElementById('view_public_medical').innerText = data.medical;
            document.getElementById('view_public_registered_at').innerText = data.registered_at;

            const studentSec = document.getElementById('view_student_section');
            if (data.applicant_type === 'STUDENT' || data.student_id) {
                document.getElementById('view_student_code').innerText = data.student_id || '-';
                document.getElementById('view_student_degree').innerText = data.degree_level || '-';
                document.getElementById('view_student_faculty').innerText = data.faculty || '-';
                document.getElementById('view_student_program').innerText = data.program_name || '-';
                document.getElementById('view_student_org').innerText = data.student_org || '-';
                studentSec.classList.remove('hidden');
            } else {
                studentSec.classList.add('hidden');
            }

            const badge = document.getElementById('view_public_status_badge');
            if (data.status === 'CONFIRMED') {
                badge.className = 'px-3 py-1 rounded-full text-[11px] font-semibold bg-[#5A6B47]/15 text-[#5A6B47] border border-[#5A6B47]/30 inline-block';
                badge.innerText = 'ได้รับสิทธิ์เข้าร่วม (Confirmed)';
            } else if (data.status === 'ATTENDED') {
                badge.className = 'px-3 py-1 rounded-full text-[11px] font-semibold bg-[#2C3E2D]/15 text-[#2C3E2D] border border-[#2C3E2D]/30 inline-block';
                badge.innerText = 'เข้าร่วมอบรมแล้ว (Attended)';
            } else if (data.status === 'CANCELLED') {
                badge.className = 'px-3 py-1 rounded-full text-[11px] font-semibold bg-[#8C8275]/15 text-[#8C8275] border border-[#8C8275]/30 inline-block';
                badge.innerText = 'ยกเลิก (Cancelled)';
            } else {
                badge.className = 'px-3 py-1 rounded-full text-[11px] font-semibold bg-[#C86D51]/15 text-[#C86D51] border border-[#C86D51]/30 inline-block';
                badge.innerText = 'รายชื่อสำรอง (Waiting List)';
            }

            document.getElementById('view-public-modal').classList.remove('hidden');
        }

        function openEditPublicModal(data) {
            const form = document.getElementById('edit-public-form');
            form.action = "{{ url('/admin/public/sar/update') }}/" + data.id;

            document.getElementById('edit_pub_prefix').value = data.prefix || '';
            document.getElementById('edit_pub_name').value = data.full_name || '';
            document.getElementById('edit_pub_age').value = data.age || '';
            document.getElementById('edit_pub_gender').value = data.gender || 'MALE';
            document.getElementById('edit_pub_province').value = data.province || '';
            document.getElementById('edit_pub_phone').value = data.phone || '';
            document.getElementById('edit_pub_email').value = data.email || '';
            document.getElementById('edit_pub_dietary').value = data.dietary_restriction || '';
            document.getElementById('edit_pub_medical').value = data.medical_condition || '';
            document.getElementById('edit_pub_status').value = data.status || 'CONFIRMED';

            document.getElementById('edit-public-modal').classList.remove('hidden');
        }

        function toggleSelectAll(master) {
            const checkboxes = document.querySelectorAll('.row-checkbox');
            checkboxes.forEach(cb => cb.checked = master.checked);
            updateSelectedCount();
        }

        function updateSelectedCount() {
            const checkedBoxes = document.querySelectorAll('.row-checkbox:checked');
            const count = checkedBoxes.length;
            const countEl = document.getElementById('selected-count');
            if (countEl) countEl.innerText = count;

            const master = document.getElementById('select-all');
            const totalBoxes = document.querySelectorAll('.row-checkbox');
            if (master && totalBoxes.length > 0) {
                master.checked = (checkedBoxes.length === totalBoxes.length);
            }
        }

        function submitBulkAction() {
            const checkedBoxes = document.querySelectorAll('.row-checkbox:checked');
            if (checkedBoxes.length === 0) {
                alert('กรุณาติ๊กเลือกรายการที่ต้องการจัดการอย่างน้อย 1 รายการ');
                return;
            }

            const actionSelect = document.getElementById('bulk-action-select');
            const action = actionSelect.value;
            if (!action) {
                alert('กรุณาเลือกรูปแบบการจัดการ (Bulk Action)');
                actionSelect.focus();
                return;
            }

            let confirmText = `ยืนยันดำเนินการ "${actionSelect.options[actionSelect.selectedIndex].text}" กับรายการที่เลือกทั้งหมด ${checkedBoxes.length} รายการหรือไม่?`;
            if (action === 'DELETE') {
                confirmText = `คำเตือน: คุณกำลังจะลบรายการที่เลือกทั้งหมด ${checkedBoxes.length} รายการ การกระทำนี้ไม่สามารถย้อนกลับได้ ยืนยันหรือไม่?`;
            }

            if (confirm(confirmText)) {
                document.getElementById('bulk-form').submit();
            }
        }

        lucide.createIcons();
    </script>
</body>
</html>
