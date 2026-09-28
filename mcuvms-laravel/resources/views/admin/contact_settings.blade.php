<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ตั้งค่าระบบข้อมูลติดต่อสอบถาม | MCUVMS Admin</title>
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
                    <i data-lucide="settings" class="w-4 h-4"></i> System Settings & Helpdesk
                </span>
                <h1 class="text-2xl sm:text-3xl font-heading font-extrabold text-[#2C3E2D] mt-1">ตั้งค่าระบบสำหรับติดต่อสอบถาม</h1>
                <p class="text-xs text-[#6B6357] mt-1">จัดการข้อมูลการติดต่อ หมายเลขโทรศัพท์ แผนที่ และกล่องข้อความสอบถามจากหน้าบ้าน</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('contact') }}" target="_blank" class="text-xs bg-white border border-[#D5CEBC] hover:border-[#5A6B47] text-[#2C3E2D] px-3.5 py-2 rounded-xl font-semibold shadow-2xs flex items-center gap-2 transition">
                    <i data-lucide="external-link" class="w-4 h-4 text-[#5A6B47]"></i>
                    <span>ดูหน้าติดต่อสอบถาม (หน้าบ้าน)</span>
                </a>
            </div>
        </div>

        @if (session('success'))
            <div class="bg-[#5A6B47]/10 border-l-4 border-[#5A6B47] p-4 rounded-r-xl mb-6 shadow-sm flex items-center justify-between">
                <div class="flex items-center gap-2.5 text-xs text-[#2C3E2D] font-medium">
                    <i data-lucide="check-circle" class="w-5 h-5 text-[#5A6B47] shrink-0"></i>
                    <span>{{ session('success') }}</span>
                </div>
            </div>
        @endif

        <!-- Form for Settings -->
        <div class="earth-admin-card p-6 md:p-8 mb-10">
            <div class="flex items-center justify-between pb-4 mb-6 border-b border-[#EAE5D9]">
                <div class="flex items-center gap-3">
                    <span class="w-10 h-10 rounded-xl bg-[#5A6B47]/15 text-[#5A6B47] flex items-center justify-center font-bold">
                        <i data-lucide="sliders" class="w-5 h-5"></i>
                    </span>
                    <div>
                        <h2 class="font-heading font-bold text-lg text-[#2C3E2D]">ข้อมูลติดต่อหน่วยงาน (General Contact Info)</h2>
                        <p class="text-xs text-[#7B8D65]">ข้อมูลเหล่านี้จะแสดงบนหน้าเว็บ [ติดต่อสอบถาม] และส่วนท้าย (Footer) ของระบบ</p>
                    </div>
                </div>
            </div>

            <form action="{{ route('admin.contact.settings.update') }}" method="POST" class="space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach ($settings as $s)
                        <div class="{{ in_array($s->field_type, ['textarea']) ? 'md:col-span-2' : '' }}">
                            <label class="block text-xs font-semibold text-[#4A3B32] mb-1.5 flex items-center gap-1.5">
                                <span class="w-1.5 h-1.5 rounded-full bg-[#5A6B47]"></span>
                                <span>{{ $s->label ?? $s->setting_key }}</span>
                                <span class="text-[10px] text-[#8C8275] font-mono font-normal">({{ $s->setting_key }})</span>
                            </label>

                            @if ($s->field_type === 'textarea')
                                <textarea name="{{ $s->setting_key }}" rows="3" class="w-full px-3.5 py-2.5 bg-[#FAF8F2] border border-[#D5CEBC] rounded-xl text-xs text-[#2D2A26] focus:ring-2 focus:ring-[#5A6B47] focus:border-[#5A6B47] leading-relaxed">{{ $s->setting_value }}</textarea>
                            @else
                                <input type="text" name="{{ $s->setting_key }}" value="{{ $s->setting_value }}" class="w-full px-3.5 py-2.5 bg-[#FAF8F2] border border-[#D5CEBC] rounded-xl text-xs text-[#2D2A26] focus:ring-2 focus:ring-[#5A6B47] focus:border-[#5A6B47]">
                            @endif
                        </div>
                    @endforeach
                </div>

                <div class="pt-4 border-t border-[#EAE5D9] flex items-center justify-end">
                    <button type="submit" class="bg-[#5A6B47] hover:bg-[#2C3E2D] text-white font-medium px-6 py-2.5 rounded-xl text-xs shadow-md transition flex items-center gap-2">
                        <i data-lucide="save" class="w-4 h-4"></i>
                        <span>บันทึกการตั้งค่าข้อมูลติดต่อ (Save Settings)</span>
                    </button>
                </div>
            </form>
        </div>

        <!-- Inquiries Inbox Section -->
        <div class="earth-admin-card p-6 md:p-8">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-4 mb-6 border-b border-[#EAE5D9] gap-4">
                <div class="flex items-center gap-3">
                    <span class="w-10 h-10 rounded-xl bg-[#C86D51]/15 text-[#C86D51] flex items-center justify-center font-bold">
                        <i data-lucide="inbox" class="w-5 h-5"></i>
                    </span>
                    <div>
                        <h2 class="font-heading font-bold text-lg text-[#2C3E2D]">กล่องข้อความสอบถามจากประชาชนและนิสิต (Inquiries Inbox)</h2>
                        <p class="text-xs text-[#7B8D65]">รายการข้อความที่ส่งเข้ามาผ่านแบบฟอร์มหน้าติดต่อสอบถาม ทั้งหมด {{ number_format($inquiries->total()) }} รายการ</p>
                    </div>
                </div>

                <!-- Per Page Selector (10, 20, 50, 100, All) -->
                <div class="flex items-center gap-2 text-xs text-[#4A3B32]">
                    <span>แสดงต่อหน้า:</span>
                    <form method="GET" action="{{ route('admin.contact.settings') }}" class="inline">
                        <select name="per_page" onchange="this.form.submit()" class="px-2.5 py-1.5 rounded-lg border border-[#D5CEBC] bg-white text-xs font-semibold focus:ring-1 focus:ring-[#5A6B47]">
                            <option value="10" {{ request('per_page') == '10' ? 'selected' : '' }}>10</option>
                            <option value="20" {{ request('per_page', '20') == '20' ? 'selected' : '' }}>20</option>
                            <option value="50" {{ request('per_page') == '50' ? 'selected' : '' }}>50</option>
                            <option value="100" {{ request('per_page') == '100' ? 'selected' : '' }}>100</option>
                            <option value="all" {{ request('per_page') == 'all' ? 'selected' : '' }}>All (ทั้งหมด)</option>
                        </select>
                    </form>
                </div>
            </div>

            <!-- Table of Inquiries -->
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-[#4A3B32]">
                    <thead class="bg-[#FAF8F2] text-[#2C3E2D] font-bold border-b border-[#EAE5D9]">
                        <tr>
                            <th class="p-3.5 whitespace-nowrap">Ticket ID</th>
                            <th class="p-3.5 whitespace-nowrap">ผู้ติดต่อ / เบอร์โทร</th>
                            <th class="p-3.5 whitespace-nowrap">หมวดหมู่</th>
                            <th class="p-3.5">หัวข้อเรื่อง & ข้อความ</th>
                            <th class="p-3.5 whitespace-nowrap">วันที่ส่งเรื่อง</th>
                            <th class="p-3.5 whitespace-nowrap text-center">สถานะ</th>
                            <th class="p-3.5 whitespace-nowrap text-right">ดำเนินการ</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#EAE5D9]">
                        @forelse ($inquiries as $inq)
                            <tr class="hover:bg-[#FAF8F2]/60 transition">
                                <td class="p-3.5 font-mono font-semibold text-[#5A6B47] whitespace-nowrap">
                                    {{ $inq->ticket_no }}
                                </td>
                                <td class="p-3.5 whitespace-nowrap">
                                    <div class="font-bold text-[#2C3E2D]">{{ $inq->sender_name }}</div>
                                    <div class="text-[11px] font-mono text-[#7B8D65] flex items-center gap-1 mt-0.5">
                                        <i data-lucide="phone" class="w-3 h-3 text-[#5A6B47]"></i>
                                        <span>{{ $inq->phone }}</span>
                                    </div>
                                    @if ($inq->email)
                                        <div class="text-[10px] text-[#8C8275]">{{ $inq->email }}</div>
                                    @endif
                                </td>
                                <td class="p-3.5 whitespace-nowrap">
                                    <span class="px-2.5 py-1 rounded-full text-[11px] font-medium bg-[#EAE5D9] text-[#4A3B32]">
                                        {{ $inq->category }}
                                    </span>
                                </td>
                                <td class="p-3.5">
                                    <div class="font-bold text-[#2C3E2D] mb-1 line-clamp-1">{{ $inq->subject }}</div>
                                    <div class="text-[11px] text-[#6B6357] line-clamp-2 leading-relaxed bg-[#FAF8F2] p-2 rounded-lg border border-[#EAE5D9]">
                                        {{ $inq->message }}
                                    </div>
                                </td>
                                <td class="p-3.5 whitespace-nowrap font-mono text-[11px] text-[#6B6357]">
                                    {{ \Carbon\Carbon::parse($inq->created_at)->format('d/m/Y H:i') }}
                                </td>
                                <td class="p-3.5 whitespace-nowrap text-center">
                                    @if ($inq->status === 'NEW')
                                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-[#C86D51]/15 text-[#C86D51] border border-[#C86D51]/30">เรื่องใหม่</span>
                                    @elseif ($inq->status === 'READ')
                                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-blue-50 text-blue-700 border border-blue-200">เปิดอ่านแล้ว</span>
                                    @else
                                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-[#5A6B47]/15 text-[#5A6B47] border border-[#5A6B47]/30">ตอบกลับแล้ว</span>
                                    @endif
                                </td>
                                <td class="p-3.5 whitespace-nowrap text-right space-x-1.5">
                                    @if ($inq->status !== 'RESPONDED')
                                        <a href="{{ route('admin.contact.inquiries.status', ['id' => $inq->id, 'status' => 'RESPONDED']) }}" class="px-2.5 py-1.5 bg-[#5A6B47] hover:bg-[#2C3E2D] text-white rounded-lg text-[10px] font-semibold transition inline-flex items-center gap-1 shadow-2xs" title="ทำเครื่องหมายว่าตอบกลับแล้ว">
                                            <i data-lucide="check" class="w-3 h-3"></i>
                                            <span>ตอบแล้ว</span>
                                        </a>
                                    @endif
                                    <a href="{{ route('admin.contact.inquiries.delete', $inq->id) }}" onclick="return confirm('ยืนยันการลบข้อความนี้?')" class="px-2 py-1.5 text-red-600 hover:bg-red-50 rounded-lg text-[10px] font-semibold transition inline-flex items-center gap-1" title="ลบข้อความ">
                                        <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-10 text-center text-[#8C8275]">
                                    <i data-lucide="inbox" class="w-8 h-8 mx-auto mb-2 text-[#D5CEBC]"></i>
                                    <span>ยังไม่มีข้อความติดต่อสอบถามส่งเข้ามา</span>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if ($inquiries instanceof \Illuminate\Pagination\LengthAwarePaginator && $inquiries->hasPages())
                <div class="pt-4 border-t border-[#EAE5D9] flex items-center justify-between">
                    <div class="text-xs text-[#7B8D65]">
                        แสดง {{ $inquiries->firstItem() }} - {{ $inquiries->lastItem() }} จาก {{ $inquiries->total() }} รายการ
                    </div>
                    <div>
                        {{ $inquiries->appends(request()->query())->links() }}
                    </div>
                </div>
            @endif
        </div>

    </main>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>
