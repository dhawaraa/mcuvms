<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ตรวจสอบและอนุมัติวันสะสม บัณฑิตศึกษา (ป.โท/เอก) - MCUVMS Admin (Laravel)</title>
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
        
        <!-- Top bar -->
        <div class="flex flex-col sm:flex-row justify-between sm:items-center pb-6 mb-8 border-b border-[#D5CEBC] gap-4">
            <div>
                <h1 class="text-2xl font-heading font-bold text-[#2C3E2D]">การอนุมัติผลสะสมวัน ระดับบัณฑิตศึกษา (Module 2)</h1>
                <p class="text-xs text-[#7B8D65] mt-1 font-medium">เกณฑ์: ป.โท 30 วัน / ป.เอก 45 วัน &bull; ตรวจสอบประวัติสะสมวันและอนุมัติใบรับรองอิเล็กทรอนิกส์</p>
            </div>
            <div class="text-xs text-[#4A3B32] flex items-center gap-2 bg-[#FAF8F2] px-3.5 py-2 rounded-xl border border-[#EAE5D9]">
                <i data-lucide="user-check" class="w-4 h-4 text-[#5A6B47]"></i>
                <span>ผู้ใช้งาน: <strong class="text-[#2C3E2D]">{{ Session::get('admin_user')['name'] ?? 'Admin' }}</strong></span>
            </div>
        </div>

        @if (session('success'))
            <div class="bg-[#5A6B47]/10 border border-[#5A6B47]/30 text-[#2C3E2D] px-4 py-3 rounded-2xl mb-6 text-sm flex items-center gap-2">
                <i data-lucide="check" class="w-5 h-5 text-[#5A6B47]"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <!-- Filter & Search Bar -->
        <div class="earth-admin-card p-4 mb-6">
            <form method="GET" action="{{ route('admin.grad.approvals') }}" class="flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="flex flex-wrap items-center gap-3 w-full sm:w-auto">
                    <div class="flex items-center gap-2">
                        <i data-lucide="search" class="w-4 h-4 text-[#5A6B47]"></i>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="ค้นหารหัสนิสิต หรือชื่อ..." class="px-3 py-1.5 text-xs bg-[#FAF8F2] border border-[#EAE5D9] rounded-lg text-[#2C3E2D] focus:ring-1 focus:ring-[#5A6B47]">
                    </div>

                    <select name="degree_level" onchange="this.form.submit()" class="px-3 py-1.5 text-xs bg-[#FAF8F2] border border-[#EAE5D9] rounded-lg text-[#2C3E2D] font-medium focus:ring-1 focus:ring-[#5A6B47]">
                        <option value="">-- ทุกระดับการศึกษา --</option>
                        <option value="MASTER" {{ request('degree_level') === 'MASTER' ? 'selected' : '' }}>ปริญญาโท (30 วัน)</option>
                        <option value="DOCTORAL" {{ request('degree_level') === 'DOCTORAL' ? 'selected' : '' }}>ปริญญาเอก (45 วัน)</option>
                    </select>

                    <select name="status" onchange="this.form.submit()" class="px-3 py-1.5 text-xs bg-[#FAF8F2] border border-[#EAE5D9] rounded-lg text-[#2C3E2D] font-medium focus:ring-1 focus:ring-[#5A6B47]">
                        <option value="">-- ทุกสถานะ --</option>
                        <option value="SUBMITTED" {{ request('status') === 'SUBMITTED' ? 'selected' : '' }}>รออนุมัติ (Lock)</option>
                        <option value="APPROVED" {{ request('status') === 'APPROVED' ? 'selected' : '' }}>ผ่านเกณฑ์สมบูรณ์</option>
                        <option value="ACCUMULATING" {{ request('status') === 'ACCUMULATING' ? 'selected' : '' }}>กำลังสะสมวัน</option>
                        <option value="REJECTED" {{ request('status') === 'REJECTED' ? 'selected' : '' }}>ส่งกลับแก้ไข</option>
                    </select>

                    @if ($isCentralOrSuper)
                        <select name="filter_org" onchange="this.form.submit()" class="px-3 py-1.5 text-xs bg-[#FAF8F2] border border-[#EAE5D9] rounded-lg text-[#2C3E2D] font-medium focus:ring-1 focus:ring-[#5A6B47]">
                            <option value="">-- ทุกส่วนงาน (52 ส่วนงาน) --</option>
                            @foreach ($orgUnits as $org)
                                <option value="{{ $org->id }}" {{ request('filter_org') == $org->id ? 'selected' : '' }}>
                                    {{ $org->name_th }}
                                </option>
                            @endforeach
                        </select>
                    @endif

                    <button type="submit" class="bg-[#5A6B47] hover:bg-[#2C3E2D] text-white px-3 py-1.5 rounded-lg text-xs font-medium transition">
                        ค้นหา
                    </button>
                    @if(request()->hasAny(['search', 'degree_level', 'status', 'filter_org']))
                        <a href="{{ route('admin.grad.approvals') }}" class="text-xs text-[#C86D51] hover:underline">ล้างตัวกรอง</a>
                    @endif
                </div>
                <div class="text-xs text-[#7B8D65]">
                    พบทั้งหมด <strong>{{ $students->total() }}</strong> รายการ
                </div>
            </form>
        </div>

        <!-- Approval Table -->
        <form id="bulk-form" method="POST" action="{{ route('admin.grad.approvals.bulk') }}">
            @csrf
            <div class="earth-admin-card overflow-hidden">
                <div class="p-5 border-b border-[#EAE5D9] flex flex-col sm:flex-row justify-between sm:items-center gap-3 bg-[#FAF8F2]/60">
                    <h2 class="font-heading font-bold text-[#2C3E2D] flex items-center gap-2">
                        <i data-lucide="file-check-2" class="w-4 h-4 text-[#5A6B47]"></i>
                        <span>รายการยื่นขออนุมัติสะสมวันทั้งหมด</span>
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
                        <span class="text-xs bg-[#FAF8F2] border border-[#EAE5D9] px-3 py-1 rounded-full text-[#7B8D65] font-medium">ทั้งหมด {{ $students->total() }} รูป/คน</span>
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
                            <option value="APPROVE">✅ อนุมัติผลการสะสมวัน (Approve All)</option>
                            <option value="REJECT">↩️ ส่งกลับแก้ไขแฟ้มสะสมวัน (Reject All)</option>
                            <option value="RESET">⏳ ปรับสถานะกลับเป็น: กำลังสะสมวัน</option>
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
                                <th class="p-4">รหัสนิสิต / ชื่อ-สกุล</th>
                                <th class="p-4">ระดับ / สาขาวิชา</th>
                                <th class="p-4">ส่วนงานสังกัด</th>
                                <th class="p-4 text-center">วันสะสม / เกณฑ์</th>
                                <th class="p-4 text-center">สถานะ</th>
                                <th class="p-4 text-right">ดำเนินการ (Action)</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#EAE5D9]">
                            @forelse ($students as $s)
                                @php 
                                    $isFull = ($s->accumulated_days >= $s->target_days);
                                @endphp
                                <tr class="hover:bg-[#FAF8F2]/80 transition">
                                    <td class="p-4 text-center">
                                        <input type="checkbox" name="selected_ids[]" value="{{ $s->id }}" onchange="updateSelectedCount()" class="row-checkbox rounded text-[#5A6B47] focus:ring-[#5A6B47]">
                                    </td>
                                    <td class="p-4">
                                        <div class="font-heading font-bold text-[#2C3E2D] text-sm">
                                            {{ $s->prefix . $s->first_name . ' ' . $s->last_name }}
                                        </div>
                                        <div class="font-mono text-[#7B8D65] text-[11px]">{{ $s->student_code }}</div>
                                    </td>
                                    <td class="p-4">
                                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-semibold border {{ $s->degree_level === 'DOCTORAL' ? 'bg-[#5A6B47]/15 text-[#5A6B47] border-[#5A6B47]/30' : 'bg-[#2C3E2D]/10 text-[#2C3E2D] border-[#2C3E2D]/20' }}">
                                            {{ $s->degree_level === 'DOCTORAL' ? 'ปริญญาเอก' : 'ปริญญาโท' }}
                                        </span>
                                        <div class="text-[#7B8D65] mt-1">{{ $s->program_name }}</div>
                                    </td>
                                    <td class="p-4">
                                        <div class="text-[#2C3E2D] font-medium">{{ $s->organizationUnit->name_th ?? 'มจร' }}</div>
                                        <span class="text-[10px] text-[#7B8D65] font-mono">{{ $s->organizationUnit->code_provincial ?? $s->organizationUnit->code }}</span>
                                    </td>
                                    <td class="p-4 text-center">
                                        <span class="font-bold text-sm {{ $isFull ? 'text-[#5A6B47]' : 'text-[#C86D51]' }}">
                                            {{ $s->accumulated_days }} / {{ $s->target_days }}
                                        </span> วัน
                                    </td>
                                    <td class="p-4 text-center">
                                        @if ($s->submission_status === 'APPROVED')
                                            <span class="px-3 py-1 rounded-full text-[11px] font-semibold bg-[#5A6B47]/15 text-[#5A6B47] border border-[#5A6B47]/30 inline-flex items-center gap-1">
                                                <i data-lucide="check" class="w-3.5 h-3.5"></i> ผ่านเกณฑ์สมบูรณ์
                                            </span>
                                        @elseif ($s->submission_status === 'SUBMITTED')
                                            <span class="px-3 py-1 rounded-full text-[11px] font-semibold bg-[#C86D51]/15 text-[#C86D51] border border-[#C86D51]/30 animate-pulse inline-flex items-center gap-1">
                                                <i data-lucide="lock" class="w-3.5 h-3.5"></i> รออนุมัติ (Lock)
                                            </span>
                                        @elseif ($s->submission_status === 'REJECTED')
                                            <span class="px-3 py-1 rounded-full text-[11px] font-semibold bg-red-100 text-red-800 border border-red-200 inline-flex items-center gap-1">
                                                <i data-lucide="rotate-ccw" class="w-3.5 h-3.5"></i> ส่งกลับแก้ไข
                                            </span>
                                        @else
                                            <span class="px-3 py-1 rounded-full text-[11px] font-semibold bg-[#FAF8F2] text-[#7B8D65] border border-[#EAE5D9] inline-flex items-center gap-1">
                                                <i data-lucide="file-edit" class="w-3.5 h-3.5"></i> กำลังสะสมวัน
                                            </span>
                                        @endif
                                    </td>
                                    <td class="p-4 text-right space-x-2">
                                        @if ($s->submission_status === 'APPROVED')
                                            <a href="{{ route('grad.certificate', ['code' => $s->student_code]) }}" target="_blank" class="bg-[#5A6B47] hover:bg-[#2C3E2D] text-white px-3 py-1.5 rounded-lg text-xs font-medium inline-flex items-center gap-1 shadow-sm transition">
                                                <i data-lucide="award" class="w-3.5 h-3.5"></i> ใบรับรอง
                                            </a>
                                            <a href="{{ route('grad.progress', ['student_code' => $s->student_code]) }}" target="_blank" class="text-[#7B8D65] hover:text-[#2C3E2D] hover:underline font-medium inline-flex items-center gap-1 transition text-xs">
                                                <i data-lucide="external-link" class="w-3.5 h-3.5"></i> ประวัติ
                                            </a>
                                        @elseif ($s->submission_status === 'SUBMITTED')
                                            <form action="{{ route('admin.grad.approve') }}" method="POST" class="inline-block" onsubmit="return confirm('ยืนยันอนุมัติผลสะสมวันของนิสิตท่านนี้?')">
                                                @csrf
                                                <input type="hidden" name="student_id" value="{{ $s->id }}">
                                                <button type="submit" class="bg-[#5A6B47] hover:bg-[#2C3E2D] text-white px-3 py-1.5 rounded-lg text-xs font-medium inline-flex items-center gap-1 shadow-sm transition">
                                                    <i data-lucide="check" class="w-3.5 h-3.5"></i> อนุมัติผล
                                                </button>
                                            </form>
                                            <form action="{{ route('admin.grad.reject') }}" method="POST" class="inline-block" onsubmit="return confirm('ส่งกลับให้นิสิตแก้ไข?')">
                                                @csrf
                                                <input type="hidden" name="student_id" value="{{ $s->id }}">
                                                <button type="submit" class="bg-[#C86D51] hover:bg-[#A85238] text-white px-3 py-1.5 rounded-lg text-xs font-medium inline-flex items-center gap-1 shadow-sm transition">
                                                    <i data-lucide="rotate-ccw" class="w-3.5 h-3.5"></i> ส่งกลับแก้ไข
                                                </button>
                                            </form>
                                        @else
                                            <a href="{{ route('grad.progress', ['student_code' => $s->student_code]) }}" target="_blank" class="text-[#5A6B47] hover:text-[#2C3E2D] hover:underline font-medium inline-flex items-center gap-1 transition">
                                                <i data-lucide="external-link" class="w-3.5 h-3.5"></i> ดูประวัติ
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-10 text-[#8C8275]">
                                        <i data-lucide="inbox" class="w-8 h-8 mx-auto mb-2 text-[#D5CEBC]"></i>
                                        <div>ไม่พบรายการยื่นขออนุมัติสะสมวันตามเงื่อนไข</div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($students->hasPages())
                    <div class="p-4 border-t border-[#EAE5D9] bg-[#FAF8F2]/60">
                        {{ $students->links() }}
                    </div>
                @endif
            </div>
        </form>

    </main>

    <script>
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
                alert('กรุณาติ๊กเลือกรายการนิสิตที่ต้องการจัดการอย่างน้อย 1 รายการ');
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
            if (confirm(confirmText)) {
                document.getElementById('bulk-form').submit();
            }
        }

        lucide.createIcons();
    </script>
</body>
</html>
