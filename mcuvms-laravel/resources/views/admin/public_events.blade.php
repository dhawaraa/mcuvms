<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>จัดการคอร์ส/โครงการปฏิบัติธรรม (โมดูล 3) - VPSMCU Admin</title>
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
                        @if ($isCentralOrSuper)
                            <i data-lucide="shield-check" class="w-3 h-3 inline mr-1"></i> ส่วนกลาง: ดูแลและจัดการคอร์สได้ 52 ส่วนงานทั่วประเทศ
                        @else
                            <i data-lucide="building-2" class="w-3 h-3 inline mr-1"></i> สิทธิ์ประจำวิทยาเขต: จัดการเฉพาะคอร์สของส่วนงานตนเอง
                        @endif
                    </span>
                </div>
                <h1 class="text-2xl font-heading font-bold text-[#2C3E2D]">คอร์สวิปัสสนากรรมฐานสำหรับประชาชน (โมดูล 3)</h1>
                <p class="text-xs text-[#7B8D65] mt-1 font-medium">จัดการคอร์สวิปัสสนากรรมฐานสำหรับประชาชนและนิสิต มจร พร้อมระบบบริหารโควตาและ Waiting List</p>
            </div>
            <button onclick="document.getElementById('add-event-modal').classList.remove('hidden')" class="bg-[#5A6B47] hover:bg-[#2C3E2D] text-white px-4 py-2.5 rounded-xl text-xs font-medium shadow-md transition flex items-center gap-2 self-start sm:self-auto">
                <i data-lucide="plus-circle" class="w-4 h-4"></i> เพิ่มคอร์สปฏิบัติธรรมใหม่
            </button>
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

        @if (isset($errors) && $errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-2xl mb-6 text-xs">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Filter Bar -->
        <div class="earth-admin-card p-4 mb-6">
            <form method="GET" action="{{ route('admin.public.events') }}" class="flex flex-col lg:flex-row items-center justify-between gap-4">
                <div class="flex flex-wrap items-center gap-3 w-full lg:w-auto">
                    <div class="relative w-full sm:w-64">
                        <i data-lucide="search" class="w-3.5 h-3.5 text-[#8C8275] absolute left-3 top-2.5"></i>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="ค้นหาชื่อคอร์ส หรือสถานที่..." class="w-full pl-9 pr-3 py-1.5 text-xs bg-[#FAF8F2] border border-[#EAE5D9] rounded-lg text-[#2C3E2D] focus:ring-1 focus:ring-[#5A6B47]">
                    </div>

                    <select name="status" onchange="this.form.submit()" class="px-3 py-1.5 text-xs bg-[#FAF8F2] border border-[#EAE5D9] rounded-lg text-[#2C3E2D] font-medium focus:ring-1 focus:ring-[#5A6B47]">
                        <option value="">-- ทุกสถานะ --</option>
                        <option value="OPEN" {{ request('status') === 'OPEN' ? 'selected' : '' }}>เปิดรับสมัคร (Open)</option>
                        <option value="CLOSED" {{ request('status') === 'CLOSED' ? 'selected' : '' }}>ปิดรับสมัคร (Closed)</option>
                        <option value="COMPLETED" {{ request('status') === 'COMPLETED' ? 'selected' : '' }}>เสร็จสิ้นโครงการ (Completed)</option>
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

                    @if(request()->hasAny(['search', 'status', 'filter_org']))
                        <a href="{{ route('admin.public.events') }}" class="text-xs text-[#C86D51] hover:underline flex items-center gap-1">
                            <i data-lucide="rotate-ccw" class="w-3 h-3"></i> ล้างตัวกรอง
                        </a>
                    @endif
                </div>

                <div class="text-xs text-[#7B8D65] self-end lg:self-auto whitespace-nowrap">
                    พบทั้งหมด <strong>{{ $events->total() }}</strong> คอร์ส
                </div>
            </form>
        </div>

        <!-- Events Table -->
        <div class="earth-admin-card overflow-hidden">
            <div class="p-5 border-b border-[#EAE5D9] flex justify-between items-center bg-[#FAF8F2]/60">
                <h2 class="font-heading font-bold text-[#2C3E2D] flex items-center gap-2 text-sm">
                    <i data-lucide="calendar" class="w-4 h-4 text-[#5A6B47]"></i>
                    <span>ตารางคอร์สและโครงการปฏิบัติธรรม</span>
                </h2>
                <span class="text-xs bg-white border border-[#EAE5D9] px-3 py-1 rounded-full text-[#7B8D65] font-medium">ทั้งหมด {{ $events->total() }} รายการ</span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-[#4A3B32]">
                    <thead class="bg-[#FAF8F2] text-[#4A3B32] font-heading border-b border-[#EAE5D9] uppercase text-[11px]">
                        <tr>
                            <th class="p-4">ชื่อคอร์ส & สถานที่</th>
                            <th class="p-4">ส่วนงานผู้จัด</th>
                            <th class="p-4">ช่วงเวลาจัดอบรม</th>
                            <th class="p-4 text-center">โควตา / สมัครแล้ว</th>
                            <th class="p-4 text-center">คิวสำรอง</th>
                            <th class="p-4 text-center">สถานะ</th>
                            <th class="p-4 text-right">ดำเนินการ (Action)</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#EAE5D9]">
                        @forelse ($events as $e)
                            @php
                                $confirmed = $e->confirmed_count ?? 0;
                                $quota = $e->max_quota ?? 50;
                                $isFull = ($confirmed >= $quota);
                            @endphp
                            <tr class="hover:bg-[#FAF8F2]/80 transition">
                                <td class="p-4">
                                    <div class="font-heading font-semibold text-[#2C3E2D] text-sm">
                                        {{ $e->title }}
                                    </div>
                                    <div class="text-[#7B8D65] text-[11px] flex items-center gap-1 mt-0.5">
                                        <i data-lucide="map-pin" class="w-3 h-3 text-[#C86D51]"></i>
                                        <span>{{ $e->location_name }}</span>
                                    </div>
                                </td>
                                <td class="p-4">
                                    <span class="px-2.5 py-1 rounded-lg bg-[#FAF8F2] border border-[#EAE5D9] text-[#2C3E2D] font-medium text-[11px]">
                                        {{ $e->organizationUnit->name_th ?? 'มจร ส่วนกลาง' }}
                                    </span>
                                </td>
                                <td class="p-4 font-mono text-[11px]">
                                    <div class="text-[#2C3E2D] font-semibold">{{ \Carbon\Carbon::parse($e->start_date)->format('d/m/Y') }}</div>
                                    <div class="text-[#7B8D65]">ถึง {{ \Carbon\Carbon::parse($e->end_date)->format('d/m/Y') }}</div>
                                </td>
                                <td class="p-4 text-center">
                                    <span class="font-mono font-bold {{ $isFull ? 'text-red-600' : 'text-[#5A6B47]' }} text-sm">
                                        {{ $confirmed }}
                                    </span>
                                    <span class="text-[#7B8D65]">/ {{ $quota }}</span>
                                    @if ($isFull)
                                        <div class="text-[10px] text-red-600 font-semibold mt-0.5">ที่นั่งเต็ม</div>
                                    @endif
                                </td>
                                <td class="p-4 text-center font-mono">
                                    @if ($e->waiting_count > 0)
                                        <span class="px-2 py-0.5 text-xs rounded-full bg-amber-100 text-amber-800 font-bold border border-amber-300">
                                            {{ $e->waiting_count }} คน
                                        </span>
                                    @else
                                        <span class="text-[#8C8275]">-</span>
                                    @endif
                                </td>
                                <td class="p-4 text-center">
                                    @if ($e->status === 'OPEN')
                                        <span class="px-2.5 py-1 rounded-full text-[10px] font-semibold bg-[#5A6B47]/15 text-[#5A6B47] border border-[#5A6B47]/30">
                                            เปิดรับสมัคร
                                        </span>
                                    @elseif ($e->status === 'CLOSED')
                                        <span class="px-2.5 py-1 rounded-full text-[10px] font-semibold bg-[#C86D51]/15 text-[#C86D51] border border-[#C86D51]/30">
                                            ปิดรับสมัคร
                                        </span>
                                    @else
                                        <span class="px-2.5 py-1 rounded-full text-[10px] font-semibold bg-stone-100 text-stone-700 border border-stone-300">
                                            เสร็จสิ้นโครงการ
                                        </span>
                                    @endif
                                </td>
                                <td class="p-4 text-right">
                                    <div class="flex items-center justify-end gap-1.5">
                                        <!-- ดูรายชื่อผู้สมัครในคอร์สนี้ -->
                                        <a href="{{ route('admin.public.students', ['event_id' => $e->id]) }}" title="ดูรายชื่อผู้สมัครคอร์สนี้" class="p-1.5 text-[#5A6B47] hover:bg-[#5A6B47]/10 rounded-lg transition">
                                            <i data-lucide="users" class="w-4 h-4"></i>
                                        </a>

                                        <!-- ปุ่มเปลี่ยนสถานะ -->
                                        @if ($e->status === 'OPEN')
                                            <a href="{{ route('admin.public.events.status', ['id' => $e->id, 'status' => 'CLOSED']) }}" title="ปิดรับสมัคร" onclick="return confirm('ยืนยันปิดรับสมัครคอร์สนี้หรือไม่?')" class="p-1.5 text-amber-600 hover:bg-amber-50 rounded-lg transition">
                                                <i data-lucide="lock" class="w-4 h-4"></i>
                                            </a>
                                        @else
                                            <a href="{{ route('admin.public.events.status', ['id' => $e->id, 'status' => 'OPEN']) }}" title="เปิดรับสมัคร" onclick="return confirm('ยืนยันเปิดรับสมัครคอร์สนี้หรือไม่?')" class="p-1.5 text-[#5A6B47] hover:bg-[#5A6B47]/10 rounded-lg transition">
                                                <i data-lucide="unlock" class="w-4 h-4"></i>
                                            </a>
                                        @endif

                                        <!-- ปุ่มแก้ไข -->
                                        <button type="button" onclick="openEditModal({{ json_encode($e) }})" title="แก้ไขโครงการ" class="p-1.5 text-[#4A3B32] hover:bg-[#FAF8F2] rounded-lg transition">
                                            <i data-lucide="edit-3" class="w-4 h-4"></i>
                                        </button>

                                        <!-- ปุ่มลบ -->
                                        <a href="{{ route('admin.public.events.delete', $e->id) }}" onclick="return confirm('ยืนยันลบคอร์สปฏิบัตินี้? ข้อมูลการลงทะเบียนจะถูกลบด้วย')" title="ลบโครงการ" class="p-1.5 text-red-500 hover:bg-red-50 rounded-lg transition">
                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-10 text-[#8C8275]">
                                    <i data-lucide="calendar-x" class="w-8 h-8 mx-auto mb-2 text-[#C86D51]"></i>
                                    <div>ยังไม่มีคอร์ส/โครงการปฏิบัติธรรมในส่วนงานนี้</div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($events->hasPages())
                <div class="p-4 border-t border-[#EAE5D9] bg-[#FAF8F2]/60">
                    {{ $events->links() }}
                </div>
            @endif
        </div>

    </main>

    <!-- Modal Form: เพิ่มคอร์สปฏิบัติธรรมใหม่ -->
    <div id="add-event-modal" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4 hidden">
        <div class="bg-white rounded-3xl border border-[#EAE5D9] shadow-2xl max-w-xl w-full p-6 md:p-8 overflow-y-auto max-h-[90vh]">
            <div class="flex justify-between items-center pb-4 border-b border-[#EAE5D9] mb-5">
                <div>
                    <h3 class="text-lg font-heading font-bold text-[#2C3E2D]">เพิ่มคอร์สปฏิบัติธรรมใหม่ (Module 3)</h3>
                    <p class="text-xs text-[#7B8D65]">กำหนดช่วงเวลา สถานที่จัด และโควตาที่นั่งรับสมัคร</p>
                </div>
                <button type="button" onclick="document.getElementById('add-event-modal').classList.add('hidden')" class="p-1.5 text-[#8C8275] hover:text-[#2C3E2D] rounded-lg">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>

            <form action="{{ route('admin.public.events.store') }}" method="POST" class="space-y-4 text-xs">
                @csrf

                @if ($isCentralOrSuper)
                    <div>
                        <label class="block font-semibold text-[#4A3B32] mb-1">ส่วนงานเจ้าของโครงการ (52 ส่วนงาน) <span class="text-[#C86D51]">*</span></label>
                        <select name="org_unit_id" required class="w-full px-3 py-2 bg-[#FAF8F2] border border-[#EAE5D9] rounded-xl text-xs focus:ring-1 focus:ring-[#5A6B47]">
                            @foreach ($orgUnits as $org)
                                <option value="{{ $org->id }}">{{ $org->name_th }} ({{ $org->province_th ?: 'มจร' }})</option>
                            @endforeach
                        </select>
                    </div>
                @endif

                <div>
                    <label class="block font-semibold text-[#4A3B32] mb-1">ชื่อคอร์ส/โครงการปฏิบัติธรรม <span class="text-[#C86D51]">*</span></label>
                    <input type="text" name="title" placeholder="เช่น คอร์สพัฒนาจิตเพื่อสันติสุข ประจำปี 2569" required class="w-full px-3 py-2 bg-[#FAF8F2] border border-[#EAE5D9] rounded-xl text-xs focus:ring-1 focus:ring-[#5A6B47]">
                </div>

                <div>
                    <label class="block font-semibold text-[#4A3B32] mb-1">สถานที่จัดโครงการ / อาคารปฏิบัติธรรม <span class="text-[#C86D51]">*</span></label>
                    <input type="text" name="location_name" placeholder="เช่น อาคาร 72 พรรษา หรือ ศูนย์วิปัสสนา มจร วังน้อย" required class="w-full px-3 py-2 bg-[#FAF8F2] border border-[#EAE5D9] rounded-xl text-xs focus:ring-1 focus:ring-[#5A6B47]">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block font-semibold text-[#4A3B32] mb-1">วันที่เริ่มต้น <span class="text-[#C86D51]">*</span></label>
                        <input type="date" name="start_date" required class="w-full px-3 py-2 bg-[#FAF8F2] border border-[#EAE5D9] rounded-xl text-xs focus:ring-1 focus:ring-[#5A6B47]">
                    </div>
                    <div>
                        <label class="block font-semibold text-[#4A3B32] mb-1">วันที่สิ้นสุด <span class="text-[#C86D51]">*</span></label>
                        <input type="date" name="end_date" required class="w-full px-3 py-2 bg-[#FAF8F2] border border-[#EAE5D9] rounded-xl text-xs focus:ring-1 focus:ring-[#5A6B47]">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block font-semibold text-[#4A3B32] mb-1">โควตาที่นั่งรับสมัคร (คน) <span class="text-[#C86D51]">*</span></label>
                        <input type="number" name="max_quota" value="50" min="1" max="1000" required class="w-full px-3 py-2 bg-[#FAF8F2] border border-[#EAE5D9] rounded-xl text-xs focus:ring-1 focus:ring-[#5A6B47]">
                    </div>
                    <div>
                        <label class="block font-semibold text-[#4A3B32] mb-1">สถานะโครงการ</label>
                        <select name="status" class="w-full px-3 py-2 bg-[#FAF8F2] border border-[#EAE5D9] rounded-xl text-xs focus:ring-1 focus:ring-[#5A6B47]">
                            <option value="OPEN">เปิดรับสมัคร (Open)</option>
                            <option value="CLOSED">ปิดรับสมัคร (Closed)</option>
                            <option value="COMPLETED">เสร็จสิ้นโครงการ (Completed)</option>
                        </select>
                    </div>
                </div>

                <div class="pt-4 border-t border-[#EAE5D9] flex justify-end gap-2">
                    <button type="button" onclick="document.getElementById('add-event-modal').classList.add('hidden')" class="px-4 py-2 border border-[#EAE5D9] rounded-xl hover:bg-stone-50 font-medium">ยกเลิก</button>
                    <button type="submit" class="bg-[#5A6B47] hover:bg-[#2C3E2D] text-white px-5 py-2 rounded-xl font-medium shadow-md transition flex items-center gap-1.5">
                        <i data-lucide="check" class="w-4 h-4"></i> บันทึกข้อมูลคอร์ส
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Form: แก้ไขคอร์สปฏิบัติธรรม -->
    <div id="edit-event-modal" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4 hidden">
        <div class="bg-white rounded-3xl border border-[#EAE5D9] shadow-2xl max-w-xl w-full p-6 md:p-8 overflow-y-auto max-h-[90vh]">
            <div class="flex justify-between items-center pb-4 border-b border-[#EAE5D9] mb-5">
                <div>
                    <h3 class="text-lg font-heading font-bold text-[#2C3E2D]">แก้ไขคอร์ส/โครงการปฏิบัติธรรม</h3>
                    <p class="text-xs text-[#7B8D65]">ปรับปรุงช่วงเวลา สถานที่ และโควตาที่นั่ง</p>
                </div>
                <button type="button" onclick="document.getElementById('edit-event-modal').classList.add('hidden')" class="p-1.5 text-[#8C8275] hover:text-[#2C3E2D] rounded-lg">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>

            <form id="edit-event-form" method="POST" action="" class="space-y-4 text-xs">
                @csrf

                @if ($isCentralOrSuper)
                    <div>
                        <label class="block font-semibold text-[#4A3B32] mb-1">ส่วนงานเจ้าของโครงการ <span class="text-[#C86D51]">*</span></label>
                        <select name="org_unit_id" id="edit-org-unit-id" required class="w-full px-3 py-2 bg-[#FAF8F2] border border-[#EAE5D9] rounded-xl text-xs focus:ring-1 focus:ring-[#5A6B47]">
                            @foreach ($orgUnits as $org)
                                <option value="{{ $org->id }}">{{ $org->name_th }}</option>
                            @endforeach
                        </select>
                    </div>
                @endif

                <div>
                    <label class="block font-semibold text-[#4A3B32] mb-1">ชื่อคอร์ส/โครงการปฏิบัติธรรม <span class="text-[#C86D51]">*</span></label>
                    <input type="text" name="title" id="edit-title" required class="w-full px-3 py-2 bg-[#FAF8F2] border border-[#EAE5D9] rounded-xl text-xs focus:ring-1 focus:ring-[#5A6B47]">
                </div>

                <div>
                    <label class="block font-semibold text-[#4A3B32] mb-1">สถานที่จัดโครงการ / อาคารปฏิบัติธรรม <span class="text-[#C86D51]">*</span></label>
                    <input type="text" name="location_name" id="edit-location" required class="w-full px-3 py-2 bg-[#FAF8F2] border border-[#EAE5D9] rounded-xl text-xs focus:ring-1 focus:ring-[#5A6B47]">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block font-semibold text-[#4A3B32] mb-1">วันที่เริ่มต้น <span class="text-[#C86D51]">*</span></label>
                        <input type="date" name="start_date" id="edit-start-date" required class="w-full px-3 py-2 bg-[#FAF8F2] border border-[#EAE5D9] rounded-xl text-xs focus:ring-1 focus:ring-[#5A6B47]">
                    </div>
                    <div>
                        <label class="block font-semibold text-[#4A3B32] mb-1">วันที่สิ้นสุด <span class="text-[#C86D51]">*</span></label>
                        <input type="date" name="end_date" id="edit-end-date" required class="w-full px-3 py-2 bg-[#FAF8F2] border border-[#EAE5D9] rounded-xl text-xs focus:ring-1 focus:ring-[#5A6B47]">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block font-semibold text-[#4A3B32] mb-1">โควตาที่นั่งรับสมัคร (คน) <span class="text-[#C86D51]">*</span></label>
                        <input type="number" name="max_quota" id="edit-quota" min="1" max="1000" required class="w-full px-3 py-2 bg-[#FAF8F2] border border-[#EAE5D9] rounded-xl text-xs focus:ring-1 focus:ring-[#5A6B47]">
                    </div>
                    <div>
                        <label class="block font-semibold text-[#4A3B32] mb-1">สถานะโครงการ</label>
                        <select name="status" id="edit-status" class="w-full px-3 py-2 bg-[#FAF8F2] border border-[#EAE5D9] rounded-xl text-xs focus:ring-1 focus:ring-[#5A6B47]">
                            <option value="OPEN">เปิดรับสมัคร (Open)</option>
                            <option value="CLOSED">ปิดรับสมัคร (Closed)</option>
                            <option value="COMPLETED">เสร็จสิ้นโครงการ (Completed)</option>
                        </select>
                    </div>
                </div>

                <div class="pt-4 border-t border-[#EAE5D9] flex justify-end gap-2">
                    <button type="button" onclick="document.getElementById('edit-event-modal').classList.add('hidden')" class="px-4 py-2 border border-[#EAE5D9] rounded-xl hover:bg-stone-50 font-medium">ยกเลิก</button>
                    <button type="submit" class="bg-[#5A6B47] hover:bg-[#2C3E2D] text-white px-5 py-2 rounded-xl font-medium shadow-md transition flex items-center gap-1.5">
                        <i data-lucide="check" class="w-4 h-4"></i> บันทึกการแก้ไข
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openEditModal(event) {
            document.getElementById('edit-event-form').action = '/admin/public/events/update/' + event.id;
            document.getElementById('edit-title').value = event.title || '';
            document.getElementById('edit-location').value = event.location_name || '';
            document.getElementById('edit-start-date').value = event.start_date || '';
            document.getElementById('edit-end-date').value = event.end_date || '';
            document.getElementById('edit-quota').value = event.max_quota || 50;
            document.getElementById('edit-status').value = event.status || 'OPEN';

            const orgSelect = document.getElementById('edit-org-unit-id');
            if (orgSelect && event.org_unit_id) {
                orgSelect.value = event.org_unit_id;
            }

            document.getElementById('edit-event-modal').classList.remove('hidden');
        }

        lucide.createIcons();
    </script>

</body>
</html>
