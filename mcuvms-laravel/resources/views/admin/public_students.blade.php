<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ทะเบียนรายชื่อผู้สมัครอบรมปฏิบัติธรรม - VPSMCU Admin</title>
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

        <!-- Header -->
        <div class="flex flex-col sm:flex-row justify-between sm:items-center pb-6 mb-8 border-b border-[#D5CEBC] gap-4">
            <div>
                <div class="flex items-center gap-2 mb-1">
                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-semibold tracking-wider uppercase bg-[#5A6B47]/15 text-[#5A6B47] border border-[#5A6B47]/30">
                        <i data-lucide="users" class="w-3 h-3 inline mr-1"></i> โมดูลที่ 3: ทะเบียนผู้สมัครอบรม (Public Registrations Master)
                    </span>
                </div>
                <h1 class="text-2xl font-heading font-bold text-[#2C3E2D]">ทะเบียนผู้สมัครคอร์สวิปัสสนากรรมฐานสำหรับประชาชน</h1>
                <p class="text-xs text-[#7B8D65] mt-1 font-medium">ตรวจสอบสถานะผู้สมัคร, จัดการข้อมูลห้องพัก ยานพาหนะ และอาหาร พร้อมส่งออกรายชื่อ (Export CSV)</p>
            </div>
            <div class="flex items-center gap-2 self-start sm:self-auto">
                <a href="{{ route('admin.public.export', request()->query()) }}" class="bg-[#FAF8F2] hover:bg-[#EAE5D9] text-[#2C3E2D] border border-[#D5CEBC] px-4 py-2.5 rounded-xl text-xs font-medium shadow-sm transition flex items-center gap-2">
                    <i data-lucide="download" class="w-4 h-4 text-[#5A6B47]"></i> ส่งออก Excel/CSV
                </a>
            </div>
        </div>

        @if (session('success'))
            <div class="bg-[#5A6B47]/10 border border-[#5A6B47]/30 text-[#2C3E2D] px-4 py-3 rounded-2xl mb-6 text-sm flex items-center gap-2">
                <i data-lucide="check-circle" class="w-5 h-5 text-[#5A6B47]"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-2xl mb-6 text-sm flex items-center gap-2">
                <i data-lucide="alert-circle" class="w-5 h-5 text-red-600"></i>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <!-- Filter & Search Bar -->
        <div class="earth-admin-card p-4 mb-6">
            <form method="GET" action="{{ route('admin.public.students') }}" class="flex flex-col lg:flex-row items-center justify-between gap-4">
                <div class="flex flex-wrap items-center gap-3 w-full lg:w-auto">
                    <div class="relative w-full sm:w-64">
                        <i data-lucide="search" class="w-3.5 h-3.5 text-[#8C8275] absolute left-3 top-2.5"></i>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="ค้นหาชื่อ, เบอร์โทร, รหัสนิสิต..." class="w-full pl-9 pr-3 py-1.5 text-xs bg-[#FAF8F2] border border-[#EAE5D9] rounded-lg text-[#2C3E2D] focus:ring-1 focus:ring-[#5A6B47]">
                    </div>

                    <select name="event_id" onchange="this.form.submit()" class="px-3 py-1.5 text-xs bg-[#FAF8F2] border border-[#EAE5D9] rounded-lg text-[#2C3E2D] font-medium focus:ring-1 focus:ring-[#5A6B47] max-w-xs truncate">
                        <option value="">-- ทุกคอร์ส/โครงการ --</option>
                        @foreach ($events as $ev)
                            <option value="{{ $ev->id }}" {{ request('event_id') == $ev->id ? 'selected' : '' }}>
                                {{ $ev->title }}
                            </option>
                        @endforeach
                    </select>

                    <select name="status" onchange="this.form.submit()" class="px-3 py-1.5 text-xs bg-[#FAF8F2] border border-[#EAE5D9] rounded-lg text-[#2C3E2D] font-medium focus:ring-1 focus:ring-[#5A6B47]">
                        <option value="">-- ทุกสถานะ --</option>
                        <option value="PENDING" {{ request('status') === 'PENDING' ? 'selected' : '' }}>รอตรวจสอบ (Pending)</option>
                        <option value="CONFIRMED" {{ request('status') === 'CONFIRMED' ? 'selected' : '' }}>อนุมัติสิทธิ์แล้ว (Confirmed)</option>
                        <option value="WAITING_LIST" {{ request('status') === 'WAITING_LIST' ? 'selected' : '' }}>รายชื่อสำรอง (Waiting List)</option>
                        <option value="ATTENDED" {{ request('status') === 'ATTENDED' ? 'selected' : '' }}>เข้าร่วมอบรมแล้ว (Attended)</option>
                        <option value="REJECTED" {{ request('status') === 'REJECTED' ? 'selected' : '' }}>ปฏิเสธ/ไม่ผ่าน (Rejected)</option>
                        <option value="CANCELLED" {{ request('status') === 'CANCELLED' ? 'selected' : '' }}>ยกเลิกสิทธิ์ (Cancelled)</option>
                    </select>

                    <select name="applicant_type" onchange="this.form.submit()" class="px-3 py-1.5 text-xs bg-[#FAF8F2] border border-[#EAE5D9] rounded-lg text-[#2C3E2D] font-medium focus:ring-1 focus:ring-[#5A6B47]">
                        <option value="">-- ทุกกลุ่มผู้สมัคร --</option>
                        <option value="PEOPLE" {{ request('applicant_type') === 'PEOPLE' ? 'selected' : '' }}>ประชาชนทั่วไป</option>
                        <option value="STUDENT" {{ request('applicant_type') === 'STUDENT' ? 'selected' : '' }}>นิสิต มจร</option>
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

                    @if(request()->hasAny(['search', 'event_id', 'status', 'applicant_type', 'filter_org']))
                        <a href="{{ route('admin.public.students') }}" class="text-xs text-[#C86D51] hover:underline flex items-center gap-1">
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
                    <h2 class="font-heading font-bold text-[#2C3E2D] flex items-center gap-2 text-sm">
                        <i data-lucide="list-checks" class="w-4 h-4 text-[#5A6B47]"></i>
                        <span>รายชื่อผู้สมัครอบรมในระบบ</span>
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
                        <span class="text-xs bg-white border border-[#EAE5D9] px-3 py-1 rounded-full text-[#7B8D65] font-medium">ทั้งหมด {{ $registrations->total() }} คน</span>
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
                            <option value="CONFIRMED">อนุมัติสิทธิ์เข้าร่วม (Approve/Confirmed)</option>
                            <option value="WAITING_LIST">จัดเป็นรายชื่อสำรอง (Waiting List)</option>
                            <option value="REJECTED">ปฏิเสธคำขอ (Reject)</option>
                            <option value="ATTENDED">บันทึกเข้าร่วมอบรมแล้ว (Attended)</option>
                            <option value="PENDING">ปรับเป็นรอตรวจสอบ (Pending)</option>
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
                                <th class="p-4">คิว / รหัสสมัคร</th>
                                <th class="p-4">ชื่อ - นามสกุล</th>
                                <th class="p-4">คอร์สที่สมัคร</th>
                                <th class="p-4">ที่อยู่ / ยานพาหนะ / ห้องพัก</th>
                                <th class="p-4">อาหาร & ความต้องการ</th>
                                <th class="p-4 text-center">สถานะการคัดกรอง</th>
                                <th class="p-4 text-right">ดำเนินการ (Action)</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#EAE5D9]">
                            @forelse ($registrations as $r)
                                <tr class="hover:bg-[#FAF8F2]/80 transition">
                                    <td class="p-4 text-center">
                                        <input type="checkbox" name="selected_ids[]" value="{{ $r->id }}" onchange="updateSelectedCount()" class="row-checkbox rounded text-[#5A6B47] focus:ring-[#5A6B47]">
                                    </td>
                                    <td class="p-4">
                                        <span class="font-mono font-bold text-[#C86D51] text-sm">Q-{{ str_pad($r->queue_no, 3, '0', STR_PAD_LEFT) }}</span>
                                        <div class="text-[10px] text-[#8C8275] font-mono mt-0.5">{{ $r->registration_no ?: '-' }}</div>
                                        @if ($r->applicant_type === 'STUDENT')
                                            <span class="inline-block mt-1 px-1.5 py-0.5 rounded text-[9px] bg-blue-50 text-blue-700 border border-blue-200">นิสิต มจร: {{ $r->student_id }}</span>
                                        @endif
                                    </td>
                                    <td class="p-4">
                                        <div class="font-heading font-semibold text-[#2C3E2D] text-sm">
                                            {{ $r->full_name }}
                                        </div>
                                        <div class="text-[11px] text-[#7B8D65] flex flex-wrap items-center gap-1.5 mt-0.5">
                                            <i data-lucide="phone" class="w-3 h-3 text-[#5A6B47]"></i>
                                            <span>{{ $r->phone }}</span>
                                            @if ($r->line_id)
                                                <span>&bull;</span>
                                                <span class="text-[#2C3E2D]">Line: {{ $r->line_id }}</span>
                                            @endif
                                            <span>&bull;</span>
                                            <span>อายุ {{ $r->age }} ปี</span>
                                            @if ($r->vassa > 0)
                                                <span>&bull; {{ $r->vassa }} พรรษา</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="p-4">
                                        <div class="font-medium text-[#2C3E2D] max-w-xs truncate" title="{{ $r->event->title ?? '-' }}">
                                            {{ $r->event->title ?? '-' }}
                                        </div>
                                        <div class="text-[10px] text-[#7B8D65] mt-0.5">
                                            {{ $r->event->organizationUnit->name_th ?? '-' }}
                                        </div>
                                    </td>
                                    <td class="p-4">
                                        <div class="text-[11px] text-[#2C3E2D]">
                                            {{ $r->province ?: 'ไม่ระบุจังหวัด' }}
                                        </div>
                                        @if ($r->room_info)
                                            <div class="text-[10px] text-[#5A6B47] flex items-center gap-1 mt-0.5">
                                                <i data-lucide="home" class="w-3 h-3"></i> {{ $r->room_info }}
                                            </div>
                                        @endif
                                        @if ($r->vehicle_info)
                                            <div class="text-[10px] text-[#7B8D65] flex items-center gap-1 mt-0.5">
                                                <i data-lucide="car" class="w-3 h-3"></i> {{ $r->vehicle_info }}
                                            </div>
                                        @endif
                                    </td>
                                    <td class="p-4">
                                        <div class="text-[11px] font-medium text-[#2C3E2D]">
                                            @if ($r->dietary_restriction === 'VEGETARIAN')
                                                <span class="text-[#5A6B47]">มังสวิรัติ</span>
                                            @elseif ($r->dietary_restriction === 'JAY')
                                                <span class="text-amber-700">อาหารเจ</span>
                                            @elseif ($r->dietary_restriction === 'HALAL')
                                                <span class="text-teal-700">ฮาลาล</span>
                                            @else
                                                <span class="text-stone-600">อาหารทั่วไป</span>
                                            @endif
                                        </div>
                                        @if ($r->congenital_disease)
                                            <div class="text-[10px] text-[#C86D51] mt-0.5" title="{{ $r->congenital_disease }}">
                                                * {{ Str::limit($r->congenital_disease, 30) }}
                                            </div>
                                        @endif
                                    </td>
                                    <td class="p-4 text-center">
                                        @if ($r->status === 'PENDING')
                                            <span class="px-2.5 py-1 rounded-full text-[10px] font-semibold bg-amber-100 text-amber-800 border border-amber-300 flex items-center justify-center gap-1 w-fit mx-auto">
                                                <i data-lucide="clock" class="w-3 h-3"></i> รอตรวจสอบ
                                            </span>
                                        @elseif ($r->status === 'CONFIRMED')
                                            <span class="px-2.5 py-1 rounded-full text-[10px] font-semibold bg-[#5A6B47]/15 text-[#5A6B47] border border-[#5A6B47]/30 flex items-center justify-center gap-1 w-fit mx-auto">
                                                <i data-lucide="check-circle-2" class="w-3 h-3"></i> อนุมัติสิทธิ์แล้ว
                                            </span>
                                        @elseif ($r->status === 'WAITING_LIST')
                                            <span class="px-2.5 py-1 rounded-full text-[10px] font-semibold bg-[#C86D51]/15 text-[#C86D51] border border-[#C86D51]/30 flex items-center justify-center gap-1 w-fit mx-auto">
                                                <i data-lucide="hourglass" class="w-3 h-3"></i> รายชื่อสำรอง
                                            </span>
                                        @elseif ($r->status === 'ATTENDED')
                                            <span class="px-2.5 py-1 rounded-full text-[10px] font-semibold bg-emerald-100 text-emerald-800 border border-emerald-300 flex items-center justify-center gap-1 w-fit mx-auto">
                                                <i data-lucide="user-check" class="w-3 h-3"></i> เข้าร่วมแล้ว
                                            </span>
                                        @elseif ($r->status === 'REJECTED')
                                            <span class="px-2.5 py-1 rounded-full text-[10px] font-semibold bg-red-100 text-red-800 border border-red-300 flex items-center justify-center gap-1 w-fit mx-auto" title="{{ $r->reject_reason }}">
                                                <i data-lucide="x-circle" class="w-3 h-3"></i> ไม่อนุมัติ
                                            </span>
                                        @else
                                            <span class="px-2.5 py-1 rounded-full text-[10px] font-semibold bg-stone-100 text-stone-700 border border-stone-300 flex items-center justify-center gap-1 w-fit mx-auto">
                                                <i data-lucide="slash" class="w-3 h-3"></i> ยกเลิก
                                            </span>
                                        @endif
                                    </td>
                                    <td class="p-4 text-right">
                                        <div class="flex items-center justify-end gap-1.5">
                                            <!-- ปุ่มอนุมัติสิทธิ์ -->
                                            @if ($r->status !== 'CONFIRMED' && $r->status !== 'ATTENDED')
                                                <a href="{{ route('admin.public.student.approve', $r->id) }}" onclick="return confirm('ยืนยันอนุมัติสิทธิ์การเข้าร่วมอบรมของ {{ $r->full_name }}?')" title="อนุมัติสิทธิ์เข้าร่วม (Approve)" class="p-1.5 text-[#5A6B47] hover:bg-[#5A6B47]/15 rounded-lg border border-[#5A6B47]/30 transition">
                                                    <i data-lucide="check" class="w-4 h-4"></i>
                                                </a>
                                            @endif

                                            <!-- ปุ่มปฏิเสธสิทธิ์ -->
                                            @if ($r->status !== 'REJECTED')
                                                <button type="button" onclick="openRejectModal({{ $r->id }}, '{{ addslashes($r->full_name) }}')" title="ปฏิเสธ/ไม่อนุมัติ (Reject)" class="p-1.5 text-amber-700 hover:bg-amber-100 rounded-lg border border-amber-300 transition">
                                                    <i data-lucide="x" class="w-4 h-4"></i>
                                                </button>
                                            @endif

                                            <!-- ปุ่มลบข้อมูล -->
                                            <a href="{{ route('admin.public.sar.delete', $r->id) }}" onclick="return confirm('ยืนยันลบข้อมูลผู้สมัครท่านนี้หรือไม่?')" title="ลบข้อมูล" class="p-1.5 text-red-500 hover:bg-red-50 rounded-lg transition">
                                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-10 text-[#8C8275]">
                                        <i data-lucide="user-x" class="w-8 h-8 mx-auto mb-2 text-[#C86D51]"></i>
                                        <div>ยังไม่มีข้อมูลผู้สมัครในเงื่อนไขนี้</div>
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

    <!-- Modal Form: ระบุเหตุผลการปฏิเสธคำขอ -->
    <div id="reject-modal" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4 hidden">
        <div class="bg-white rounded-3xl border border-[#EAE5D9] shadow-2xl max-w-md w-full p-6 md:p-8">
            <div class="flex justify-between items-center pb-3 border-b border-[#EAE5D9] mb-4">
                <div class="flex items-center gap-2">
                    <div class="p-2 rounded-xl bg-red-100 text-red-700">
                        <i data-lucide="alert-triangle" class="w-5 h-5"></i>
                    </div>
                    <h3 class="text-base font-heading font-bold text-[#2C3E2D]">ปฏิเสธคำขอเข้าร่วม</h3>
                </div>
                <button type="button" onclick="document.getElementById('reject-modal').classList.add('hidden')" class="p-1.5 text-[#8C8275] hover:text-[#2C3E2D] rounded-lg">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>

            <form id="reject-form" method="POST" action="" class="space-y-4 text-xs">
                @csrf
                <div>
                    <p class="text-[#4A3B32] mb-2">ผู้สมัคร: <strong id="reject-applicant-name" class="text-[#2C3E2D]"></strong></p>
                    <label class="block font-semibold text-[#4A3B32] mb-1">ระบุเหตุผลในการไม่อนุมัติ <span class="text-[#C86D51]">*</span></label>
                    <select name="reject_reason" id="reject-reason-select" onchange="toggleCustomReason(this.value)" class="w-full px-3 py-2 bg-[#FAF8F2] border border-[#EAE5D9] rounded-xl text-xs focus:ring-1 focus:ring-[#5A6B47] mb-2">
                        <option value="คุณสมบัติหรือข้อมูลไม่ผ่านเกณฑ์การอบรม">คุณสมบัติหรือข้อมูลไม่ผ่านเกณฑ์การอบรม</option>
                        <option value="ไม่สามารถติดต่อหมายเลขโทรศัพท์ที่ระบุได้">ไม่สามารถติดต่อหมายเลขโทรศัพท์ที่ระบุได้</option>
                        <option value="ข้อจำกัดด้านสุขภาพไม่เอื้ออำนวยต่อหลักสูตรเข้มข้น">ข้อจำกัดด้านสุขภาพไม่เอื้ออำนวยต่อหลักสูตรเข้มข้น</option>
                        <option value="ห้องพักสำหรับประเภทผู้สมัครเต็มแล้ว">ห้องพักสำหรับประเภทผู้สมัครเต็มแล้ว</option>
                        <option value="OTHER">ระบุเหตุผลอื่น ๆ...</option>
                    </select>
                    <input type="text" name="custom_reason" id="custom-reason-input" placeholder="พิมพ์เหตุผลเพิ่มเติม..." class="hidden w-full px-3 py-2 bg-white border border-[#EAE5D9] rounded-xl text-xs focus:ring-1 focus:ring-[#5A6B47]">
                </div>

                <div class="pt-3 border-t border-[#EAE5D9] flex justify-end gap-2">
                    <button type="button" onclick="document.getElementById('reject-modal').classList.add('hidden')" class="px-4 py-2 border border-[#EAE5D9] rounded-xl hover:bg-stone-50 font-medium">ยกเลิก</button>
                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-5 py-2 rounded-xl font-medium shadow-md transition flex items-center gap-1.5">
                        <i data-lucide="x-circle" class="w-4 h-4"></i> ยืนยันการปฏิเสธ
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function toggleSelectAll(master) {
            const checkboxes = document.querySelectorAll('.row-checkbox');
            checkboxes.forEach(cb => cb.checked = master.checked);
            updateSelectedCount();
        }

        function updateSelectedCount() {
            const checked = document.querySelectorAll('.row-checkbox:checked').length;
            document.getElementById('selected-count').innerText = checked;
        }

        function submitBulkAction() {
            const checked = document.querySelectorAll('.row-checkbox:checked').length;
            const action = document.getElementById('bulk-action-select').value;

            if (checked === 0) {
                alert('กรุณาเลือกรายการอย่างน้อย 1 รายการ');
                return;
            }

            if (!action) {
                alert('กรุณาเลือกการดำเนินการที่ต้องการ');
                return;
            }

            if (action === 'DELETE') {
                if (!confirm(`ยืนยันการลบข้อมูลจำนวน ${checked} รายการ หรือไม่? การกระทำนี้ไม่สามารถย้อนกลับได้`)) {
                    return;
                }
            } else {
                if (!confirm(`ยืนยันดำเนินการกับข้อมูลจำนวน ${checked} รายการ?`)) {
                    return;
                }
            }

            document.getElementById('bulk-form').submit();
        }

        function openRejectModal(id, name) {
            document.getElementById('reject-applicant-name').innerText = name;
            document.getElementById('reject-form').action = '/admin/public/student/reject/' + id;
            document.getElementById('reject-reason-select').value = 'คุณสมบัติหรือข้อมูลไม่ผ่านเกณฑ์การอบรม';
            document.getElementById('custom-reason-input').classList.add('hidden');
            document.getElementById('reject-modal').classList.remove('hidden');
        }

        function toggleCustomReason(val) {
            const input = document.getElementById('custom-reason-input');
            if (val === 'OTHER') {
                input.classList.remove('hidden');
                input.required = true;
            } else {
                input.classList.add('hidden');
                input.required = false;
            }
        }

        lucide.createIcons();
    </script>

</body>
</html>
