<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VPSMCU Admin - แผงควบคุมระบบสารสนเทศวิปัสสนากรรมฐาน มจร</title>
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

    <!-- Earth Tones Sidebar (Deep Forest & Olive) with Collapsible Submenus -->
    @include('admin.layouts.sidebar')

    <!-- Main Workspace -->
    <main class="flex-grow p-6 md:p-10 overflow-y-auto">
        
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-6 mb-8 border-b border-[#D5CEBC] gap-4">
            <div>
                <span class="text-xs font-bold text-[#5A6B47] uppercase tracking-wider font-mono flex items-center gap-1.5">
                    <i data-lucide="layout-dashboard" class="w-4 h-4"></i> Admin Control Center
                </span>
                <h1 class="text-2xl sm:text-3xl font-heading font-extrabold text-[#2C3E2D] mt-1">ภาพรวมระบบสารสนเทศวิปัสสนากรรมฐาน</h1>
                <p class="text-xs text-[#6B6357] mt-1">มหาวิทยาลัยมหาจุฬาลงกรณราชวิทยาลัย</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.executive.analytics') }}" class="text-xs bg-[#C86D51] hover:bg-[#A85238] text-white px-3.5 py-2 rounded-xl font-semibold shadow-sm flex items-center gap-2 transition">
                    <i data-lucide="bar-chart-3" class="w-4 h-4"></i>
                    <span>สถิติวิเคราะห์ผู้บริหาร</span>
                </a>
                <span class="text-xs bg-white border border-[#D5CEBC] px-3.5 py-2 rounded-xl font-mono text-[#4A3B32] shadow-sm flex items-center gap-2">
                    <i data-lucide="shield-check" class="w-4 h-4 text-[#5A6B47]"></i>
                    <span>Status: <strong class="text-[#2C3E2D]">Active</strong></span>
                </span>
            </div>
        </div>

        <!-- 4 KPI Summary Cards (Earth Tone Finish) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
            
            <a href="{{ route('admin.org_units.index') }}" class="earth-admin-card p-6 relative overflow-hidden block hover:border-[#5A6B47] transition group">
                <div class="flex justify-between items-start mb-4">
                    <span class="text-xs font-bold uppercase tracking-wider text-[#8C8275] font-mono group-hover:text-[#5A6B47] transition">เครือข่ายส่วนงาน มจร</span>
                    <span class="p-2.5 rounded-xl bg-[#EAE5D9] text-[#4A3B32] group-hover:bg-[#5A6B47] group-hover:text-white transition">
                        <i data-lucide="building-2" class="w-5 h-5"></i>
                    </span>
                </div>
                <div class="text-3xl font-heading font-extrabold text-[#2C3E2D] group-hover:text-[#5A6B47] transition">{{ number_format($totalOrgs) }}</div>
                <p class="text-xs text-[#6B6357] mt-1 flex items-center justify-between">
                    <span>ส่วนงาน (วิทยาเขต/วส.)</span>
                    <span class="text-[10px] text-[#5A6B47] font-semibold flex items-center gap-0.5">ดูรายชื่อ <i data-lucide="chevron-right" class="w-3 h-3"></i></span>
                </p>
            </a>

            <div class="earth-admin-card p-6 relative overflow-hidden">
                <div class="flex justify-between items-start mb-4">
                    <span class="text-xs font-bold uppercase tracking-wider text-[#8C8275] font-mono">ปริญญาตรี (UG)</span>
                    <span class="p-2.5 rounded-xl bg-[#F3E7E3] text-[#C86D51]">
                        <i data-lucide="graduation-cap" class="w-5 h-5"></i>
                    </span>
                </div>
                <div class="text-3xl font-heading font-extrabold text-[#2C3E2D]">{{ number_format($totalUG) }}</div>
                <p class="text-xs text-[#6B6357] mt-1">รูป/คน (เกณฑ์ 10 วัน/ปี)</p>
            </div>

            <div class="earth-admin-card p-6 relative overflow-hidden">
                <div class="flex justify-between items-start mb-4">
                    <span class="text-xs font-bold uppercase tracking-wider text-[#8C8275] font-mono">บัณฑิตศึกษา (Grad)</span>
                    <span class="p-2.5 rounded-xl bg-[#EAE5D9] text-[#4A3B32]">
                        <i data-lucide="scroll-text" class="w-5 h-5"></i>
                    </span>
                </div>
                <div class="text-3xl font-heading font-extrabold text-[#2C3E2D]">{{ number_format($totalGrad) }}</div>
                <p class="text-xs text-[#6B6357] mt-1">รูป/คน (สะสม 30/45 วัน)</p>
            </div>

            <div class="earth-admin-card p-6 relative overflow-hidden">
                <div class="flex justify-between items-start mb-4">
                    <span class="text-xs font-bold uppercase tracking-wider text-[#8C8275] font-mono">บริการสังคม (Public)</span>
                    <span class="p-2.5 rounded-xl bg-[#E9EFE2] text-[#5A6B47]">
                        <i data-lucide="users" class="w-5 h-5"></i>
                    </span>
                </div>
                <div class="text-3xl font-heading font-extrabold text-[#2C3E2D]">{{ number_format($totalPublic) }}</div>
                <p class="text-xs text-[#6B6357] mt-1">คน (บริการวิชาการแก่สังคม)</p>
            </div>

        </div>

        <!-- Section: สถิติและแผนภูมิกราฟแท่งผลการดำเนินงานแยกตามส่วนงาน/หน่วยงาน -->
        <div class="space-y-6">
            <div class="earth-admin-card p-6">
                <div class="flex flex-col sm:flex-row justify-between sm:items-center pb-4 mb-6 border-b border-[#EAE5D9] gap-3">
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="p-1.5 rounded-lg bg-[#5A6B47]/10 text-[#5A6B47]">
                                <i data-lucide="bar-chart-2" class="w-4 h-4"></i>
                            </span>
                            <h2 class="text-lg font-heading font-bold text-[#2C3E2D]">สถิติจำนวนผู้เข้าร่วมปฏิบัติวิปัสสนากรรมฐานแยกตามหน่วยงาน</h2>
                        </div>
                        <p class="text-xs text-[#6B6357] mt-1">เปรียบเทียบสัดส่วน 3 กลุ่มเป้าหมาย (ปริญญาตรี, บัณฑิตศึกษา, และบริการวิชาการแก่สังคม)</p>
                    </div>
                    <div class="flex items-center gap-3">
                        <a href="{{ route('admin.executive.analytics') }}" class="text-xs text-[#5A6B47] hover:text-[#2C3E2D] font-semibold flex items-center gap-1">
                            <span>ดูสถิติวิเคราะห์เชิงลึก</span>
                            <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                        </a>
                    </div>
                </div>

                <!-- Bar Chart Canvas Container -->
                <div class="relative w-full h-[340px] sm:h-[380px]">
                    <canvas id="campusBarChart"></canvas>
                </div>

                <div class="mt-4 pt-4 border-t border-[#EAE5D9] flex flex-wrap items-center justify-between gap-4 text-xs text-[#6B6357]">
                    <div class="flex items-center gap-4 flex-wrap">
                        <span class="inline-flex items-center gap-1.5">
                            <span class="w-3 h-3 rounded bg-[#C86D51]"></span>
                            <span>ปริญญาตรี (UG)</span>
                        </span>
                        <span class="inline-flex items-center gap-1.5">
                            <span class="w-3 h-3 rounded bg-[#4A3B32]"></span>
                            <span>บัณฑิตศึกษา (Grad)</span>
                        </span>
                        <span class="inline-flex items-center gap-1.5">
                            <span class="w-3 h-3 rounded bg-[#5A6B47]"></span>
                            <span>บริการวิชาการแก่สังคม</span>
                        </span>
                    </div>
                    <span class="font-mono text-[11px] text-[#8C8275]">แสดงเฉพาะส่วนงานที่มีผู้เข้าร่วมปฏิบัติธรรม</span>
                </div>
            </div>

            <!-- ตารางสรุปยอดแยกตามส่วนงาน -->
            <div class="earth-admin-card overflow-hidden">
                <div class="p-5 border-b border-[#EAE5D9] flex items-center justify-between">
                    <h3 class="text-sm font-heading font-bold text-[#2C3E2D] flex items-center gap-2">
                        <i data-lucide="layers" class="w-4 h-4 text-[#5A6B47]"></i>
                        <span>สรุปยอดสะสมจำแนกตามส่วนงาน (Campus Data Table)</span>
                    </h3>
                    <span class="text-xs text-[#6B6357] font-mono">{{ count($campusChartData) }} ส่วนงาน</span>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs text-[#4A3B32]">
                        <thead class="bg-[#FAF8F2] text-[#2C3E2D] font-heading font-semibold border-b border-[#EAE5D9]">
                            <tr>
                                <th class="p-3.5 w-12 text-center">ลำดับ</th>
                                <th class="p-3.5">รหัสย่อ</th>
                                <th class="p-3.5">ชื่อส่วนงาน / วิทยาเขต / วิทยาลัยสงฆ์</th>
                                <th class="p-3.5 text-center">ประเภทส่วนงาน</th>
                                <th class="p-3.5 text-center text-[#C86D51]">ป.ตรี (รูป/คน)</th>
                                <th class="p-3.5 text-center text-[#4A3B32]">บัณฑิตศึกษา (รูป/คน)</th>
                                <th class="p-3.5 text-center text-[#5A6B47]">บริการสังคม (คน)</th>
                                <th class="p-3.5 text-center font-bold text-[#2C3E2D]">ยอดรวมสุทธิ</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#EAE5D9]">
                            @forelse($campusChartData as $index => $campus)
                                <tr class="hover:bg-[#FAF8F2]/70 transition">
                                    <td class="p-3.5 text-center font-mono font-semibold text-[#8C8275]">{{ $index + 1 }}</td>
                                    <td class="p-3.5 font-mono font-bold text-[#C86D51]">{{ $campus['code'] }}</td>
                                    <td class="p-3.5">
                                        <div class="font-heading font-medium text-[#2C3E2D] text-sm">{{ $campus['name'] }}</div>
                                    </td>
                                    <td class="p-3.5 text-center">
                                        <span class="px-2 py-0.5 rounded-full text-[10px] font-semibold bg-[#EAE5D9] text-[#4A3B32]">
                                            {{ $campus['type'] }}
                                        </span>
                                    </td>
                                    <td class="p-3.5 text-center font-mono">{{ number_format($campus['ug']) }}</td>
                                    <td class="p-3.5 text-center font-mono">{{ number_format($campus['grad']) }}</td>
                                    <td class="p-3.5 text-center font-mono">{{ number_format($campus['public']) }}</td>
                                    <td class="p-3.5 text-center font-mono font-bold text-[#5A6B47] text-sm">{{ number_format($campus['total']) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="p-6 text-center text-[#8C8275]">ยังไม่มีข้อมูลสถิติของส่วนงาน</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </main>

    <script>
        lucide.createIcons();

        // Render Campus Statistics Bar Chart
        document.addEventListener('DOMContentLoaded', function () {
            const chartData = @json($campusChartData);
            
            const labels = chartData.map(item => item.short_name);
            const ugData = chartData.map(item => item.ug);
            const gradData = chartData.map(item => item.grad);
            const publicData = chartData.map(item => item.public);

            const ctx = document.getElementById('campusBarChart').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: 'ปริญญาตรี (UG)',
                            data: ugData,
                            backgroundColor: '#C86D51', // Clay
                            borderRadius: 6,
                            borderSkipped: false,
                        },
                        {
                            label: 'บัณฑิตศึกษา (Grad)',
                            data: gradData,
                            backgroundColor: '#4A3B32', // Bark
                            borderRadius: 6,
                            borderSkipped: false,
                        },
                        {
                            label: 'บริการวิชาการแก่สังคม',
                            data: publicData,
                            backgroundColor: '#5A6B47', // Olive
                            borderRadius: 6,
                            borderSkipped: false,
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: {
                        mode: 'index',
                        intersect: false,
                    },
                    scales: {
                        x: {
                            stacked: false,
                            grid: {
                                display: false,
                                drawBorder: false,
                            },
                            ticks: {
                                font: {
                                    family: 'Sarabun',
                                    size: 11,
                                },
                                color: '#4A3B32'
                            }
                        },
                        y: {
                            beginAtZero: true,
                            stacked: false,
                            grid: {
                                color: 'rgba(234, 229, 217, 0.7)',
                                drawBorder: false,
                            },
                            ticks: {
                                precision: 0,
                                font: {
                                    family: 'Inter',
                                    size: 11,
                                },
                                color: '#8C8275'
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false,
                        },
                        tooltip: {
                            backgroundColor: '#2C3E2D',
                            titleFont: { family: 'Prompt', size: 13, weight: '600' },
                            bodyFont: { family: 'Sarabun', size: 12 },
                            padding: 12,
                            cornerRadius: 8,
                            boxPadding: 4,
                            callbacks: {
                                footer: function(tooltipItems) {
                                    let sum = 0;
                                    tooltipItems.forEach(function(tooltipItem) {
                                        sum += tooltipItem.parsed.y;
                                    });
                                    return 'ยอดรวมทั้งหมด: ' + sum.toLocaleString() + ' รูป/คน';
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
</body>
</html>
