<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>จัดการข่าวสารประชาสัมพันธ์ - MCUVMS Admin</title>
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

    <!-- Main Content Standardized Layout -->
    <main class="flex-grow p-6 md:p-10 overflow-y-auto">
        
        <!-- Header Section -->
        <div class="flex flex-col sm:flex-row justify-between sm:items-center pb-6 mb-8 border-b border-[#D5CEBC] gap-4">
            <div>
                <div class="flex items-center gap-2 mb-1">
                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-semibold tracking-wider uppercase bg-[#5A6B47]/15 text-[#5A6B47] border border-[#5A6B47]/30">
                        @if ($isCentralOrSuper)
                            <i data-lucide="shield-check" class="w-3 h-3 inline mr-1"></i> ส่วนกลาง: จัดการข่าวสารทุกส่วนงาน
                        @else
                            <i data-lucide="building-2" class="w-3 h-3 inline mr-1"></i> วิทยาเขต: จัดการข่าวสารประจำส่วนงาน
                        @endif
                    </span>
                </div>
                <h1 class="text-2xl font-heading font-bold text-[#2C3E2D]">ระบบจัดการข่าวสาร & ประชาสัมพันธ์</h1>
                <p class="text-xs text-[#7B8D65] mt-1 font-medium">เผยแพร่ข่าวสาร กิจกรรมปฏิบัติธรรม ประกาศ และข้อมูลวิชาการวิปัสสนาธุระสู่หน้าพอร์ทัล</p>
            </div>
            <button onclick="document.getElementById('add-news-modal').classList.remove('hidden')" class="bg-[#5A6B47] hover:bg-[#2C3E2D] text-white px-4 py-2.5 rounded-xl text-xs font-medium shadow-md transition flex items-center gap-2 self-start sm:self-auto">
                <i data-lucide="plus-circle" class="w-4 h-4"></i> เพิ่มข่าวประชาสัมพันธ์ใหม่
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

        <!-- Filter & Search Bar -->
        <div class="earth-admin-card p-4 mb-6">
            <form method="GET" action="{{ route('admin.news.index') }}" class="flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="flex flex-wrap items-center gap-3 w-full sm:w-auto">
                    <div class="relative flex-grow sm:flex-grow-0 sm:w-64">
                        <i data-lucide="search" class="w-4 h-4 absolute left-3 top-2.5 text-[#8C8275]"></i>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="ค้นหาตามหัวข้อข่าว..." class="w-full pl-9 pr-3 py-1.5 text-xs bg-[#FAF8F2] border border-[#EAE5D9] rounded-lg text-[#2C3E2D] font-medium focus:ring-1 focus:ring-[#5A6B47]">
                    </div>

                    <select name="category" onchange="this.form.submit()" class="px-3 py-1.5 text-xs bg-[#FAF8F2] border border-[#EAE5D9] rounded-lg text-[#2C3E2D] font-medium focus:ring-1 focus:ring-[#5A6B47]">
                        <option value="">-- ทุกหมวดหมู่ --</option>
                        <option value="ANNOUNCEMENT" {{ request('category') == 'ANNOUNCEMENT' ? 'selected' : '' }}>ประกาศ / ข่าวทางการ</option>
                        <option value="MEDITATION" {{ request('category') == 'MEDITATION' ? 'selected' : '' }}>กิจกรรมปฏิบัติธรรม</option>
                        <option value="ACADEMIC" {{ request('category') == 'ACADEMIC' ? 'selected' : '' }}>วิชาการวิปัสสนาธุระ</option>
                        <option value="GENERAL" {{ request('category') == 'GENERAL' ? 'selected' : '' }}>ข่าวทั่วไป</option>
                    </select>

                    <select name="status" onchange="this.form.submit()" class="px-3 py-1.5 text-xs bg-[#FAF8F2] border border-[#EAE5D9] rounded-lg text-[#2C3E2D] font-medium focus:ring-1 focus:ring-[#5A6B47]">
                        <option value="">-- ทุกสถานะ --</option>
                        <option value="PUBLISHED" {{ request('status') == 'PUBLISHED' ? 'selected' : '' }}>เผยแพร่แล้ว (Published)</option>
                        <option value="DRAFT" {{ request('status') == 'DRAFT' ? 'selected' : '' }}>แบบร่าง (Draft)</option>
                        <option value="ARCHIVED" {{ request('status') == 'ARCHIVED' ? 'selected' : '' }}>เก็บถาวร (Archived)</option>
                    </select>

                    <button type="submit" class="px-3 py-1.5 bg-[#2C3E2D] text-white rounded-lg text-xs font-medium hover:bg-[#3D523E] transition flex items-center gap-1.5">
                        <i data-lucide="filter" class="w-3.5 h-3.5"></i> กรอง
                    </button>
                    @if(request()->anyFilled(['search', 'category', 'status']))
                        <a href="{{ route('admin.news.index') }}" class="text-xs text-[#C86D51] hover:underline flex items-center gap-1">
                            <i data-lucide="x" class="w-3 h-3"></i> ล้างตัวกรอง
                        </a>
                    @endif
                </div>

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
                    <div class="text-xs text-[#7B8D65]">
                        ข่าวทั้งหมด <strong>{{ $newsList->total() }}</strong> รายการ
                    </div>
                </div>
            </form>
        </div>

        <!-- News Table -->
        <div class="earth-admin-card overflow-hidden">
            <div class="p-5 border-b border-[#EAE5D9] flex justify-between items-center bg-[#FAF8F2]/60">
                <h2 class="font-heading font-bold text-[#2C3E2D] flex items-center gap-2">
                    <i data-lucide="newspaper" class="w-4 h-4 text-[#5A6B47]"></i>
                    <span>รายการข่าวสารประชาสัมพันธ์</span>
                </h2>
                <a href="{{ route('news.index') }}" target="_blank" class="text-xs text-[#5A6B47] hover:text-[#2C3E2D] font-medium flex items-center gap-1">
                    <i data-lucide="external-link" class="w-3.5 h-3.5"></i> ดูหน้าข่าวบนพอร์ทัล
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-[#4A3B32]">
                    <thead class="bg-[#FAF8F2] text-[#4A3B32] font-heading border-b border-[#EAE5D9] uppercase text-[11px]">
                        <tr>
                            <th class="p-4 w-12 text-center whitespace-nowrap">หมุด</th>
                            <th class="p-4 w-16 text-center whitespace-nowrap">รูปภาพ (1:1)</th>
                            <th class="p-4 min-w-[260px]">หัวข้อข่าวประชาสัมพันธ์</th>
                            <th class="p-4 whitespace-nowrap min-w-[130px]">หมวดหมู่</th>
                            <th class="p-4 min-w-[200px]">ส่วนงานเจ้าของเรื่อง</th>
                            <th class="p-4 text-center whitespace-nowrap min-w-[110px]">สถานะ</th>
                            <th class="p-4 text-center whitespace-nowrap min-w-[90px]">ยอดเข้าชม</th>
                            <th class="p-4 whitespace-nowrap min-w-[110px]">วันที่เผยแพร่</th>
                            <th class="p-4 text-right whitespace-nowrap min-w-[100px]">ดำเนินการ</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#EAE5D9]">
                        @forelse ($newsList as $item)
                            <tr class="hover:bg-[#FAF8F2]/80 transition {{ $item->is_pinned ? 'bg-[#5A6B47]/5' : '' }}">
                                <td class="p-4 text-center align-middle">
                                    <a href="{{ route('admin.news.togglePin', $item->id) }}" title="{{ $item->is_pinned ? 'คลิกเพื่อยกเลิกการปักหมุด' : 'คลิกเพื่อปักหมุดไว้บนสุด' }}" class="inline-flex items-center justify-center p-1 rounded-lg hover:bg-white/80 transition transform hover:scale-110">
                                        @if($item->is_pinned)
                                            <i data-lucide="pin" class="w-4 h-4 text-[#C86D51] fill-[#C86D51]"></i>
                                        @else
                                            <i data-lucide="pin" class="w-4 h-4 text-[#D5CEBC] hover:text-[#8C8275]"></i>
                                        @endif
                                    </a>
                                </td>
                                <td class="p-4 text-center align-middle">
                                    @if ($item->cover_image)
                                        <div class="w-12 h-12 rounded-xl overflow-hidden border border-[#D5CEBC] shadow-xs mx-auto shrink-0 bg-[#FAF8F2]">
                                            <img src="{{ $item->cover_image }}" alt="{{ $item->title }}" class="w-full h-full object-cover aspect-square">
                                        </div>
                                    @else
                                        <div class="w-12 h-12 rounded-xl border border-dashed border-[#D5CEBC] bg-[#FAF8F2] flex items-center justify-center mx-auto text-[#8C8275]">
                                            <i data-lucide="image" class="w-5 h-5 text-[#D5CEBC]"></i>
                                        </div>
                                    @endif
                                </td>
                                <td class="p-4 align-middle">
                                    <div class="font-heading font-semibold text-[#2C3E2D] text-sm hover:text-[#C86D51] transition">
                                        <a href="{{ route('news.detail', $item->id) }}" target="_blank" class="inline-flex items-center gap-1.5 group">
                                            <span class="line-clamp-1">{{ $item->title }}</span>
                                            <i data-lucide="external-link" class="w-3.5 h-3.5 text-[#A3B88C] group-hover:text-[#C86D51] shrink-0"></i>
                                        </a>
                                    </div>
                                    <div class="text-[#7B8D65] text-[11px] line-clamp-1 mt-0.5 max-w-lg">
                                        {{ strip_tags($item->content) }}
                                    </div>
                                </td>
                                <td class="p-4 align-middle whitespace-nowrap">
                                    @if ($item->category === 'ANNOUNCEMENT')
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-semibold bg-[#C86D51]/15 text-[#A85238] border border-[#C86D51]/30">ประกาศทางการ</span>
                                    @elseif ($item->category === 'MEDITATION')
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-semibold bg-[#5A6B47]/15 text-[#3D523E] border border-[#5A6B47]/30">กิจกรรมปฏิบัติธรรม</span>
                                    @elseif ($item->category === 'ACADEMIC')
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-semibold bg-[#4A3B32]/15 text-[#4A3B32] border border-[#4A3B32]/30">วิชาการวิปัสสนา</span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-semibold bg-stone-100 text-stone-700 border border-stone-200">ข่าวทั่วไป</span>
                                    @endif
                                </td>
                                <td class="p-4 align-middle">
                                    <span class="px-2.5 py-1 rounded-lg bg-[#FAF8F2] border border-[#EAE5D9] text-[#2C3E2D] font-medium text-[11px] inline-flex items-center gap-1.5 max-w-xs truncate">
                                        <i data-lucide="building" class="w-3.5 h-3.5 text-[#5A6B47] shrink-0"></i>
                                        <span class="truncate">{{ $item->organizationUnit->name_th ?? 'ส่วนกลาง (สถาบันวิปัสสนาธุระ)' }}</span>
                                    </span>
                                </td>
                                <td class="p-4 text-center align-middle whitespace-nowrap">
                                    @if ($item->status === 'PUBLISHED')
                                        <span class="inline-flex px-3 py-1 rounded-full text-[11px] font-semibold bg-[#E9EFE2] text-[#3D523E] border border-[#CADBC0]">เผยแพร่แล้ว</span>
                                    @elseif ($item->status === 'DRAFT')
                                        <span class="inline-flex px-3 py-1 rounded-full text-[11px] font-semibold bg-[#F7F5EE] text-[#8C8275] border border-[#D5CEBC]">แบบร่าง</span>
                                    @else
                                        <span class="inline-flex px-3 py-1 rounded-full text-[11px] font-semibold bg-stone-100 text-stone-500 border border-stone-300">เก็บถาวร</span>
                                    @endif
                                </td>
                                <td class="p-4 text-center align-middle font-mono text-[#6B6357] whitespace-nowrap">
                                    <span class="inline-flex items-center gap-1">
                                        <i data-lucide="eye" class="w-3.5 h-3.5 text-[#A3B88C]"></i>
                                        <span>{{ number_format($item->views) }}</span>
                                    </span>
                                </td>
                                <td class="p-4 align-middle text-[#6B6357] font-mono text-[11px] whitespace-nowrap">
                                    {{ substr($item->published_at ?? $item->created_at, 0, 10) }}
                                </td>
                                <td class="p-4 text-right align-middle space-x-1.5 whitespace-nowrap">
                                    <button onclick="editNews({{ json_encode($item) }})" class="p-1.5 bg-[#FAF8F2] hover:bg-[#5A6B47]/15 text-[#5A6B47] rounded-lg border border-[#EAE5D9] transition inline-flex items-center" title="แก้ไขข่าว">
                                        <i data-lucide="edit-3" class="w-4 h-4"></i>
                                    </button>
                                    <a href="{{ route('admin.news.delete', $item->id) }}" onclick="return confirm('ยืนยันที่จะลบข่าวสารนี้หรือไม่?')" class="p-1.5 bg-[#FAF8F2] hover:bg-[#C86D51]/15 text-[#C86D51] rounded-lg border border-[#EAE5D9] transition inline-flex items-center" title="ลบข่าว">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-12 text-[#8C8275]">
                                    <i data-lucide="inbox" class="w-8 h-8 mx-auto mb-2 text-[#D5CEBC]"></i>
                                    <p>ยังไม่มีรายการข่าวสารในระบบ</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if ($newsList->hasPages())
                <div class="p-4 border-t border-[#EAE5D9] bg-[#FAF8F2]/60">
                    {{ $newsList->links() }}
                </div>
            @endif
        </div>

    </main>

    <!-- Modal: Add News -->
    <div id="add-news-modal" class="fixed inset-0 z-50 bg-black/50 backdrop-blur-sm hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl max-w-2xl w-full max-h-[90vh] overflow-y-auto shadow-2xl border border-[#D5CEBC] p-6 md:p-8">
            <div class="flex justify-between items-center pb-4 mb-4 border-b border-[#EAE5D9]">
                <h3 class="font-heading font-bold text-lg text-[#2C3E2D] flex items-center gap-2">
                    <i data-lucide="plus-circle" class="w-5 h-5 text-[#5A6B47]"></i>
                    <span>เพิ่มข่าวสารประชาสัมพันธ์ใหม่</span>
                </h3>
                <button onclick="document.getElementById('add-news-modal').classList.add('hidden')" class="p-1 text-gray-400 hover:text-gray-600 rounded-lg">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>

            <form action="{{ route('admin.news.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4 text-xs">
                @csrf
                <div>
                    <label class="block font-semibold text-[#4A3B32] mb-1">หัวข้อข่าวประชาสัมพันธ์ <span class="text-red-500">*</span></label>
                    <input type="text" name="title" required placeholder="ระบุหัวข้อข่าวที่ชัดเจนและกระชับ" class="w-full px-3.5 py-2.5 bg-[#FAF8F2] border border-[#D5CEBC] rounded-xl text-xs focus:ring-2 focus:ring-[#5A6B47]">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block font-semibold text-[#4A3B32] mb-1">หมวดหมู่ข่าว <span class="text-red-500">*</span></label>
                        <select name="category" required class="w-full px-3.5 py-2.5 bg-[#FAF8F2] border border-[#D5CEBC] rounded-xl text-xs focus:ring-2 focus:ring-[#5A6B47]">
                            <option value="ANNOUNCEMENT">ประกาศ / ข่าวทางการ (Announcement)</option>
                            <option value="MEDITATION" selected>กิจกรรมปฏิบัติธรรม (Meditation)</option>
                            <option value="ACADEMIC">วิชาการวิปัสสนาธุระ (Academic)</option>
                            <option value="GENERAL">ข่าวสารทั่วไป (General)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block font-semibold text-[#4A3B32] mb-1">สถานะการเผยแพร่ <span class="text-red-500">*</span></label>
                        <select name="status" required class="w-full px-3.5 py-2.5 bg-[#FAF8F2] border border-[#D5CEBC] rounded-xl text-xs focus:ring-2 focus:ring-[#5A6B47]">
                            <option value="PUBLISHED" selected>เผยแพร่ทันที (Published)</option>
                            <option value="DRAFT">บันทึกเป็นแบบร่าง (Draft)</option>
                            <option value="ARCHIVED">เก็บถาวร (Archived)</option>
                        </select>
                    </div>
                </div>

                @if ($isCentralOrSuper)
                    <div>
                        <label class="block font-semibold text-[#4A3B32] mb-1">ส่วนงานเจ้าของข่าว (52 ส่วนงาน)</label>
                        <select name="org_unit_id" class="w-full px-3.5 py-2.5 bg-[#FAF8F2] border border-[#D5CEBC] rounded-xl text-xs focus:ring-2 focus:ring-[#5A6B47]">
                            <option value="">-- ส่วนกลาง (สถาบันวิปัสสนาธุระ / มจร ส่วนกลาง) --</option>
                            @foreach ($orgUnits as $org)
                                <option value="{{ $org->id }}">{{ $org->name_th }}</option>
                            @endforeach
                        </select>
                    </div>
                @endif

                <!-- Image Upload (1:1 Ratio) -->
                <div class="p-4 bg-[#FAF8F2] rounded-2xl border border-[#EAE5D9] space-y-3">
                    <label class="block font-semibold text-[#2C3E2D]">
                        รูปภาพหน้าปกข่าว (แนะนำอัตราส่วน 1:1 สี่เหลี่ยมจัตุรัส)
                    </label>

                    <div class="flex flex-col sm:flex-row items-center gap-4">
                        <!-- Preview Box 1:1 -->
                        <div class="w-24 h-24 sm:w-28 sm:h-28 rounded-2xl border-2 border-dashed border-[#D5CEBC] bg-white flex flex-col items-center justify-center overflow-hidden shrink-0 relative group">
                            <img id="add-cover-preview" src="" alt="พรีวิวรูปภาพ 1:1" class="w-full h-full object-cover hidden aspect-square">
                            <div id="add-cover-placeholder" class="text-center p-2 text-[#8C8275]">
                                <i data-lucide="image" class="w-6 h-6 mx-auto mb-1 text-[#D5CEBC]"></i>
                                <span class="text-[10px] block font-mono">1:1</span>
                            </div>
                        </div>

                        <div class="flex-grow space-y-2 w-full">
                            <div>
                                <label class="block text-[11px] font-medium text-[#4A3B32] mb-1 flex items-center gap-1.5">
                                    <i data-lucide="upload" class="w-3.5 h-3.5 text-[#5A6B47]"></i> อัปโหลดรูปภาพจากอุปกรณ์ (JPG, PNG, WebP ขนาดไม่เกิน 5MB)
                                </label>
                                <input type="file" name="cover_file" id="add_cover_file" accept="image/jpeg,image/png,image/jpg,image/webp,image/gif" onchange="previewImage(this, 'add-cover-preview', 'add-cover-placeholder')" class="w-full text-xs text-[#6B6357] file:mr-3 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-[#5A6B47] file:text-white hover:file:bg-[#2C3E2D] file:cursor-pointer cursor-pointer">
                            </div>

                            <div>
                                <label class="block text-[11px] font-medium text-[#8C8275] mb-0.5">หรือระบุ URL รูปภาพโดยตรง</label>
                                <input type="url" name="cover_image" id="add_cover_image" placeholder="https://example.com/cover.jpg" oninput="previewUrl(this.value, 'add-cover-preview', 'add-cover-placeholder')" class="w-full px-3 py-1.5 bg-white border border-[#D5CEBC] rounded-xl text-xs focus:ring-1 focus:ring-[#5A6B47]">
                            </div>
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block font-semibold text-[#4A3B32] mb-1">เนื้อหาข่าว / รายละเอียด <span class="text-red-500">*</span></label>
                    <textarea name="content" rows="6" required placeholder="พิมพ์รายละเอียดข่าวสารประชาสัมพันธ์ หรือข้อความประกาศ..." class="w-full px-3.5 py-2.5 bg-[#FAF8F2] border border-[#D5CEBC] rounded-xl text-xs focus:ring-2 focus:ring-[#5A6B47] leading-relaxed"></textarea>
                </div>

                <div class="flex items-center gap-2 pt-2">
                    <input type="checkbox" id="add_is_pinned" name="is_pinned" value="1" class="rounded border-[#D5CEBC] text-[#5A6B47] focus:ring-[#5A6B47]">
                    <label for="add_is_pinned" class="text-xs text-[#4A3B32] font-medium flex items-center gap-1">
                        <i data-lucide="pin" class="w-3.5 h-3.5 text-[#C86D51]"></i> ปักหมุดข่าวนี้ไว้ด้านบนสุด (Pinned Article)
                    </label>
                </div>

                <div class="pt-4 border-t border-[#EAE5D9] flex justify-end gap-2">
                    <button type="button" onclick="document.getElementById('add-news-modal').classList.add('hidden')" class="px-4 py-2 text-[#6B6357] hover:text-[#2C3E2D] font-medium">ยกเลิก</button>
                    <button type="submit" class="px-5 py-2 bg-[#5A6B47] hover:bg-[#2C3E2D] text-white font-medium rounded-xl shadow-md transition flex items-center gap-1.5">
                        <i data-lucide="save" class="w-4 h-4"></i> บันทึกข้อมูลข่าว
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal: Edit News -->
    <div id="edit-news-modal" class="fixed inset-0 z-50 bg-black/50 backdrop-blur-sm hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl max-w-2xl w-full max-h-[90vh] overflow-y-auto shadow-2xl border border-[#D5CEBC] p-6 md:p-8">
            <div class="flex justify-between items-center pb-4 mb-4 border-b border-[#EAE5D9]">
                <h3 class="font-heading font-bold text-lg text-[#2C3E2D] flex items-center gap-2">
                    <i data-lucide="edit-3" class="w-5 h-5 text-[#5A6B47]"></i>
                    <span>แก้ไขข่าวสารประชาสัมพันธ์</span>
                </h3>
                <button onclick="document.getElementById('edit-news-modal').classList.add('hidden')" class="p-1 text-gray-400 hover:text-gray-600 rounded-lg">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>

            <form id="edit-news-form" method="POST" enctype="multipart/form-data" class="space-y-4 text-xs">
                @csrf
                <div>
                    <label class="block font-semibold text-[#4A3B32] mb-1">หัวข้อข่าวประชาสัมพันธ์ <span class="text-red-500">*</span></label>
                    <input type="text" id="edit_title" name="title" required class="w-full px-3.5 py-2.5 bg-[#FAF8F2] border border-[#D5CEBC] rounded-xl text-xs focus:ring-2 focus:ring-[#5A6B47]">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block font-semibold text-[#4A3B32] mb-1">หมวดหมู่ข่าว <span class="text-red-500">*</span></label>
                        <select id="edit_category" name="category" required class="w-full px-3.5 py-2.5 bg-[#FAF8F2] border border-[#D5CEBC] rounded-xl text-xs focus:ring-2 focus:ring-[#5A6B47]">
                            <option value="ANNOUNCEMENT">ประกาศ / ข่าวทางการ (Announcement)</option>
                            <option value="MEDITATION">กิจกรรมปฏิบัติธรรม (Meditation)</option>
                            <option value="ACADEMIC">วิชาการวิปัสสนาธุระ (Academic)</option>
                            <option value="GENERAL">ข่าวสารทั่วไป (General)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block font-semibold text-[#4A3B32] mb-1">สถานะการเผยแพร่ <span class="text-red-500">*</span></label>
                        <select id="edit_status" name="status" required class="w-full px-3.5 py-2.5 bg-[#FAF8F2] border border-[#D5CEBC] rounded-xl text-xs focus:ring-2 focus:ring-[#5A6B47]">
                            <option value="PUBLISHED">เผยแพร่ทันที (Published)</option>
                            <option value="DRAFT">บันทึกเป็นแบบร่าง (Draft)</option>
                            <option value="ARCHIVED">เก็บถาวร (Archived)</option>
                        </select>
                    </div>
                </div>

                @if ($isCentralOrSuper)
                    <div>
                        <label class="block font-semibold text-[#4A3B32] mb-1">ส่วนงานเจ้าของข่าว (52 ส่วนงาน)</label>
                        <select id="edit_org_unit_id" name="org_unit_id" class="w-full px-3.5 py-2.5 bg-[#FAF8F2] border border-[#D5CEBC] rounded-xl text-xs focus:ring-2 focus:ring-[#5A6B47]">
                            <option value="">-- ส่วนกลาง (สถาบันวิปัสสนาธุระ / มจร ส่วนกลาง) --</option>
                            @foreach ($orgUnits as $org)
                                <option value="{{ $org->id }}">{{ $org->name_th }}</option>
                            @endforeach
                        </select>
                    </div>
                @endif

                <!-- Image Upload (1:1 Ratio) for Edit -->
                <div class="p-4 bg-[#FAF8F2] rounded-2xl border border-[#EAE5D9] space-y-3">
                    <label class="block font-semibold text-[#2C3E2D]">
                        รูปภาพหน้าปกข่าว (แนะนำอัตราส่วน 1:1 สี่เหลี่ยมจัตุรัส)
                    </label>

                    <div class="flex flex-col sm:flex-row items-center gap-4">
                        <!-- Preview Box 1:1 -->
                        <div class="w-24 h-24 sm:w-28 sm:h-28 rounded-2xl border-2 border-dashed border-[#D5CEBC] bg-white flex flex-col items-center justify-center overflow-hidden shrink-0 relative group">
                            <img id="edit-cover-preview" src="" alt="พรีวิวรูปภาพ 1:1" class="w-full h-full object-cover hidden aspect-square">
                            <div id="edit-cover-placeholder" class="text-center p-2 text-[#8C8275]">
                                <i data-lucide="image" class="w-6 h-6 mx-auto mb-1 text-[#D5CEBC]"></i>
                                <span class="text-[10px] block font-mono">1:1</span>
                            </div>
                        </div>

                        <div class="flex-grow space-y-2 w-full">
                            <div>
                                <label class="block text-[11px] font-medium text-[#4A3B32] mb-1 flex items-center gap-1.5">
                                    <i data-lucide="upload" class="w-3.5 h-3.5 text-[#5A6B47]"></i> อัปโหลดรูปภาพใหม่เพื่อแทนที่ (JPG, PNG, WebP ขนาดไม่เกิน 5MB)
                                </label>
                                <input type="file" name="cover_file" id="edit_cover_file" accept="image/jpeg,image/png,image/jpg,image/webp,image/gif" onchange="previewImage(this, 'edit-cover-preview', 'edit-cover-placeholder')" class="w-full text-xs text-[#6B6357] file:mr-3 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-[#5A6B47] file:text-white hover:file:bg-[#2C3E2D] file:cursor-pointer cursor-pointer">
                            </div>

                            <div>
                                <label class="block text-[11px] font-medium text-[#8C8275] mb-0.5">หรือระบุ URL รูปภาพโดยตรง</label>
                                <input type="url" id="edit_cover_image" name="cover_image" placeholder="https://example.com/cover.jpg" oninput="previewUrl(this.value, 'edit-cover-preview', 'edit-cover-placeholder')" class="w-full px-3 py-1.5 bg-white border border-[#D5CEBC] rounded-xl text-xs focus:ring-1 focus:ring-[#5A6B47]">
                            </div>
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block font-semibold text-[#4A3B32] mb-1">เนื้อหาข่าว / รายละเอียด <span class="text-red-500">*</span></label>
                    <textarea id="edit_content" name="content" rows="6" required class="w-full px-3.5 py-2.5 bg-[#FAF8F2] border border-[#D5CEBC] rounded-xl text-xs focus:ring-2 focus:ring-[#5A6B47] leading-relaxed"></textarea>
                </div>

                <div class="flex items-center gap-2 pt-2">
                    <input type="checkbox" id="edit_is_pinned" name="is_pinned" value="1" class="rounded border-[#D5CEBC] text-[#5A6B47] focus:ring-[#5A6B47]">
                    <label for="edit_is_pinned" class="text-xs text-[#4A3B32] font-medium flex items-center gap-1">
                        <i data-lucide="pin" class="w-3.5 h-3.5 text-[#C86D51]"></i> ปักหมุดข่าวนี้ไว้ด้านบนสุด (Pinned Article)
                    </label>
                </div>

                <div class="pt-4 border-t border-[#EAE5D9] flex justify-end gap-2">
                    <button type="button" onclick="document.getElementById('edit-news-modal').classList.add('hidden')" class="px-4 py-2 text-[#6B6357] hover:text-[#2C3E2D] font-medium">ยกเลิก</button>
                    <button type="submit" class="px-5 py-2 bg-[#5A6B47] hover:bg-[#2C3E2D] text-white font-medium rounded-xl shadow-md transition flex items-center gap-1.5">
                        <i data-lucide="save" class="w-4 h-4"></i> อัปเดตข้อมูลข่าว
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        lucide.createIcons();

        function previewImage(input, previewId, placeholderId) {
            const preview = document.getElementById(previewId);
            const placeholder = document.getElementById(placeholderId);
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                    if (placeholder) placeholder.classList.add('hidden');
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        function previewUrl(url, previewId, placeholderId) {
            const preview = document.getElementById(previewId);
            const placeholder = document.getElementById(placeholderId);
            if (url && url.trim().length > 0) {
                preview.src = url.trim();
                preview.classList.remove('hidden');
                if (placeholder) placeholder.classList.add('hidden');
            } else {
                preview.src = '';
                preview.classList.add('hidden');
                if (placeholder) placeholder.classList.remove('hidden');
            }
        }

        function editNews(item) {
            const form = document.getElementById('edit-news-form');
            form.action = `/admin/news/update/${item.id}`;

            document.getElementById('edit_title').value = item.title || '';
            document.getElementById('edit_category').value = item.category || 'GENERAL';
            document.getElementById('edit_status').value = item.status || 'PUBLISHED';
            document.getElementById('edit_cover_image').value = item.cover_image || '';
            document.getElementById('edit_content').value = item.content ? item.content.replace(/<[^>]*>?/gm, '') : '';
            document.getElementById('edit_is_pinned').checked = item.is_pinned == 1;

            // Clear file input
            const fileInput = document.getElementById('edit_cover_file');
            if (fileInput) fileInput.value = '';

            // Update preview
            previewUrl(item.cover_image, 'edit-cover-preview', 'edit-cover-placeholder');

            const orgSelect = document.getElementById('edit_org_unit_id');
            if (orgSelect) {
                orgSelect.value = item.org_unit_id || '';
            }

            document.getElementById('edit-news-modal').classList.remove('hidden');
        }
    </script>
</body>
</html>
