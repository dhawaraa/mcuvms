<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>รายชื่อส่วนงานภายใน มจร และรหัสย่อจังหวัด | MCUVMS Admin</title>
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
                    <i data-lucide="settings" class="w-4 h-4"></i> System Settings & Organization Directory
                </span>
                <h1 class="text-2xl sm:text-3xl font-heading font-extrabold text-[#2C3E2D] mt-1">รายชื่อส่วนงานภายใน มจร และรหัสย่อจังหวัด</h1>
                <p class="text-xs text-[#6B6357] mt-1">ทะเบียนแม่แบบส่วนงาน คณะ วิทยาเขต วิทยาลัยสงฆ์ และสถาบัน มหาวิทยาลัยมหาจุฬาลงกรณราชวิทยาลัย</p>
            </div>
            <div class="flex items-center gap-3">
                <span class="text-xs bg-white border border-[#D5CEBC] px-3.5 py-2 rounded-xl font-mono text-[#4A3B32] shadow-2xs flex items-center gap-2">
                    <i data-lucide="building-2" class="w-4 h-4 text-[#5A6B47]"></i>
                    <span>ทั้งหมด <strong class="text-[#2C3E2D]">{{ number_format($totalOrgs) }}</strong> ส่วนงาน</span>
                </span>
            </div>
        </div>

        <!-- 4 Summary Stat Mini-Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
            <div class="earth-admin-card p-5">
                <div class="flex justify-between items-center mb-2">
                    <span class="text-xs font-mono font-bold text-[#8C8275] uppercase">ส่วนงานทั้งหมด</span>
                    <span class="p-2 rounded-xl bg-[#5A6B47]/10 text-[#5A6B47]"><i data-lucide="network" class="w-4 h-4"></i></span>
                </div>
                <div class="text-2xl font-bold font-heading text-[#2C3E2D]">{{ $totalOrgs }}</div>
                <div class="text-[11px] text-[#7B8D65] mt-0.5">ส่วนงานที่เปิดใช้งานในระบบ</div>
            </div>

            <div class="earth-admin-card p-5">
                <div class="flex justify-between items-center mb-2">
                    <span class="text-xs font-mono font-bold text-[#8C8275] uppercase">วิทยาเขต (Campuses)</span>
                    <span class="p-2 rounded-xl bg-[#C86D51]/10 text-[#C86D51]"><i data-lucide="map-pin" class="w-4 h-4"></i></span>
                </div>
                <div class="text-2xl font-bold font-heading text-[#2C3E2D]">{{ $totalCampuses }}</div>
                <div class="text-[11px] text-[#7B8D65] mt-0.5">วิทยาเขตประจำภูมิภาค</div>
            </div>

            <div class="earth-admin-card p-5">
                <div class="flex justify-between items-center mb-2">
                    <span class="text-xs font-mono font-bold text-[#8C8275] uppercase">วิทยาลัยสงฆ์ (Colleges)</span>
                    <span class="p-2 rounded-xl bg-[#2C3E2D]/10 text-[#2C3E2D]"><i data-lucide="landmark" class="w-4 h-4"></i></span>
                </div>
                <div class="text-2xl font-bold font-heading text-[#2C3E2D]">{{ $totalColleges }}</div>
                <div class="text-[11px] text-[#7B8D65] mt-0.5">วิทยาลัยสงฆ์ประจำจังหวัด</div>
            </div>

            <div class="earth-admin-card p-5">
                <div class="flex justify-between items-center mb-2">
                    <span class="text-xs font-mono font-bold text-[#8C8275] uppercase">ส่วนกลาง / คณะวิชา</span>
                    <span class="p-2 rounded-xl bg-[#7B8D65]/10 text-[#5A6B47]"><i data-lucide="building" class="w-4 h-4"></i></span>
                </div>
                <div class="text-2xl font-bold font-heading text-[#2C3E2D]">{{ $totalCentral }}</div>
                <div class="text-[11px] text-[#7B8D65] mt-0.5">คณะ/วิทยาลัย/สถาบันส่วนกลาง</div>
            </div>
        </div>

        <!-- Filter & Search Toolbar -->
        <div class="earth-admin-card p-5 mb-6">
            <form method="GET" action="{{ route('admin.org_units.index') }}" class="flex flex-col md:flex-row items-center justify-between gap-4">
                <div class="flex flex-wrap items-center gap-3 w-full md:w-auto flex-grow">
                    <div class="relative flex-grow sm:flex-grow-0 sm:w-80">
                        <i data-lucide="search" class="w-4 h-4 absolute left-3 top-3 text-[#8C8275]"></i>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="ค้นหาชื่อส่วนงาน, รหัส, จังหวัด..." class="w-full pl-9 pr-3 py-2 text-xs bg-[#FAF8F2] border border-[#D5CEBC] rounded-xl text-[#2C3E2D] font-medium focus:ring-2 focus:ring-[#5A6B47]">
                    </div>

                    <select name="type" onchange="this.form.submit()" class="px-3 py-2 text-xs bg-[#FAF8F2] border border-[#D5CEBC] rounded-xl text-[#2C3E2D] font-medium focus:ring-2 focus:ring-[#5A6B47]">
                        <option value="">-- ทุกประเภทส่วนงาน --</option>
                        <option value="CENTRAL" {{ request('type') == 'CENTRAL' ? 'selected' : '' }}>ส่วนกลาง (Central)</option>
                        <option value="CAMPUS" {{ request('type') == 'CAMPUS' ? 'selected' : '' }}>วิทยาเขต (Campus)</option>
                        <option value="COLLEGE" {{ request('type') == 'COLLEGE' ? 'selected' : '' }}>วิทยาลัยสงฆ์ (College)</option>
                    </select>

                    <button type="submit" class="px-4 py-2 bg-[#5A6B47] hover:bg-[#2C3E2D] text-white rounded-xl text-xs font-semibold transition">
                        ค้นหา
                    </button>
                    @if (request()->hasAny(['search', 'type']))
                        <a href="{{ route('admin.org_units.index') }}" class="text-xs text-[#8C8275] hover:text-[#C86D51]">ล้างตัวกรอง</a>
                    @endif
                </div>

                <!-- Per Page Selector (10, 20, 50, 100, All) -->
                <div class="flex items-center gap-2 text-xs text-[#4A3B32]">
                    <span>แสดงต่อหน้า:</span>
                    <select name="per_page" onchange="this.form.submit()" class="px-2.5 py-1.5 rounded-lg border border-[#D5CEBC] bg-white text-xs font-semibold focus:ring-1 focus:ring-[#5A6B47]">
                        <option value="10" {{ request('per_page') == '10' ? 'selected' : '' }}>10</option>
                        <option value="20" {{ request('per_page', '20') == '20' ? 'selected' : '' }}>20</option>
                        <option value="50" {{ request('per_page') == '50' ? 'selected' : '' }}>50</option>
                        <option value="100" {{ request('per_page') == '100' ? 'selected' : '' }}>100</option>
                        <option value="all" {{ request('per_page') == 'all' ? 'selected' : '' }}>All (ทั้งหมด)</option>
                    </select>
                </div>
            </form>
        </div>

        <!-- Table of Organization Units -->
        <div class="earth-admin-card overflow-hidden shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-[#4A3B32]">
                    <thead class="bg-[#FAF8F2] text-[#2C3E2D] font-bold border-b border-[#EAE5D9]">
                        <tr>
                            <th class="p-4 w-16 text-center whitespace-nowrap">ลำดับ</th>
                            <th class="p-4 whitespace-nowrap">รหัสย่อ</th>
                            <th class="p-4">ชื่อส่วนงานภายใน มจร</th>
                            <th class="p-4 whitespace-nowrap">ประเภทส่วนงาน</th>
                            <th class="p-4 whitespace-nowrap">จังหวัด</th>
                            <th class="p-4 text-center whitespace-nowrap">นิสิต ป.ตรี</th>
                            <th class="p-4 text-center whitespace-nowrap">นิสิต บัณฑิตศึกษา</th>
                            <th class="p-4 text-center whitespace-nowrap">สถานะ</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#EAE5D9]">
                        @forelse ($orgUnits as $idx => $org)
                            <tr class="hover:bg-[#FAF8F2]/60 transition">
                                <td class="p-4 text-center font-mono text-[#8C8275]">
                                    {{ $orgUnits instanceof \Illuminate\Pagination\LengthAwarePaginator ? $orgUnits->firstItem() + $idx : $idx + 1 }}
                                </td>
                                <td class="p-4 font-mono font-bold text-[#C86D51] whitespace-nowrap">
                                    {{ $org->code_provincial ?: $org->code }}
                                </td>
                                <td class="p-4">
                                    <div class="font-heading font-semibold text-[#2C3E2D] text-sm">{{ $org->name_th }}</div>
                                    <div class="text-[10px] text-[#8C8275] font-mono">{{ $org->code }}</div>
                                </td>
                                <td class="p-4 whitespace-nowrap">
                                    @if ($org->type === 'CAMPUS')
                                        <span class="px-2.5 py-1 rounded-full text-[10px] font-semibold bg-[#C86D51]/15 text-[#C86D51] border border-[#C86D51]/30">
                                            วิทยาเขต
                                        </span>
                                    @elseif ($org->type === 'COLLEGE')
                                        <span class="px-2.5 py-1 rounded-full text-[10px] font-semibold bg-[#2C3E2D]/15 text-[#2C3E2D] border border-[#2C3E2D]/30">
                                            วิทยาลัยสงฆ์
                                        </span>
                                    @else
                                        <span class="px-2.5 py-1 rounded-full text-[10px] font-semibold bg-[#5A6B47]/15 text-[#5A6B47] border border-[#5A6B47]/30">
                                            ส่วนกลาง
                                        </span>
                                    @endif
                                </td>
                                <td class="p-4 font-medium text-[#4A3B32] whitespace-nowrap">
                                    {{ $org->province_th ?: '-' }}
                                    @if ($org->province_code)
                                        <span class="text-[10px] font-mono text-[#8C8275]">({{ $org->province_code }})</span>
                                    @endif
                                </td>
                                <td class="p-4 text-center font-bold text-[#2C3E2D] whitespace-nowrap">
                                    <span class="px-2 py-0.5 rounded-lg bg-[#FAF8F2] border border-[#EAE5D9]">
                                        {{ number_format($org->ug_count) }}
                                    </span>
                                </td>
                                <td class="p-4 text-center font-bold text-[#2C3E2D] whitespace-nowrap">
                                    <span class="px-2 py-0.5 rounded-lg bg-[#FAF8F2] border border-[#EAE5D9]">
                                        {{ number_format($org->grad_count) }}
                                    </span>
                                </td>
                                <td class="p-4 text-center whitespace-nowrap">
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-semibold bg-[#5A6B47]/15 text-[#5A6B47]">
                                        <span class="w-1.5 h-1.5 rounded-full bg-[#5A6B47]"></span>
                                        ใช้งาน
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="py-12 text-center text-[#8C8275]">
                                    <i data-lucide="building" class="w-8 h-8 mx-auto mb-2 text-[#D5CEBC]"></i>
                                    <span>ไม่พบข้อมูลส่วนงานที่ตรงกับเงื่อนไขการค้นหา</span>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if ($orgUnits instanceof \Illuminate\Pagination\LengthAwarePaginator && $orgUnits->hasPages())
                <div class="p-4 border-t border-[#EAE5D9] flex flex-col sm:flex-row items-center justify-between gap-3">
                    <div class="text-xs text-[#7B8D65]">
                        แสดง {{ $orgUnits->firstItem() }} - {{ $orgUnits->lastItem() }} จากทั้งหมด {{ $orgUnits->total() }} ส่วนงาน
                    </div>
                    <div>
                        {{ $orgUnits->appends(request()->query())->links() }}
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
