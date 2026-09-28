<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mobile QR Scanner เช็คชื่อปฏิบัติธรรม ป.ตรี - MCUVMS Admin</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@300;400;500;600;700&family=Prompt:wght@400;500;600;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Lucide Icons -->
    <script src="/assets/js/lucide.min.js"></script>

    <!-- Tailwind CSS -->
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

        /* Scanner Target Frame Animation */
        @keyframes scanLine {
            0% { top: 4%; opacity: 0.8; }
            50% { top: 92%; opacity: 1; }
            100% { top: 4%; opacity: 0.8; }
        }
        .scanner-laser {
            position: absolute;
            left: 4%;
            right: 4%;
            height: 3px;
            background: linear-gradient(90deg, transparent, #5A6B47, #A3B88C, #5A6B47, transparent);
            box-shadow: 0 0 12px #7B8D65;
            animation: scanLine 2.5s infinite linear;
        }
    </style>
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/mcu-logo.png') }}">
    <link rel="shortcut icon" href="{{ asset('images/mcu-logo.png') }}">
    
    <!-- HTML5 QR Code Scanner Library -->
    <script src="https://unpkg.com/html5-qrcode"></script>
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
                        <i data-lucide="smartphone" class="w-3 h-3 inline mr-1"></i> รองรับกล้องมือถือ & เครื่องอ่านบาร์โค้ดหน้างาน
                    </span>
                </div>
                <h1 class="text-2xl font-heading font-bold text-[#2C3E2D]">สแกน QR Code เช็คชื่อรายงานตัวนิสิต (Mobile Scanner)</h1>
                <p class="text-xs text-[#7B8D65] mt-1 font-medium">สแกนบัตรลงทะเบียน E-Ticket หรือกรอกรหัสนิสิต เพื่อบันทึกการรายงานตัวเข้าปฏิบัติธรรม 10 วัน แบบ Real-time</p>
            </div>
            
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.ug.attendance', ['batch_id' => $selectedBatchId]) }}" class="bg-[#FAF8F2] hover:bg-[#EAE5D9] text-[#2C3E2D] border border-[#D5CEBC] px-4 py-2.5 rounded-xl text-xs font-medium transition flex items-center gap-2 shadow-sm">
                    <i data-lucide="printer" class="w-4 h-4 text-[#5A6B47]"></i> พิมพ์ใบเซ็นชื่อ
                </a>
                <a href="{{ route('admin.ug.students') }}" class="bg-[#2C3E2D] hover:bg-[#1E2B1F] text-white px-4 py-2.5 rounded-xl text-xs font-medium transition flex items-center gap-2 shadow-sm">
                    <i data-lucide="list" class="w-4 h-4"></i> ดูรายชื่อทั้งหมด
                </a>
            </div>
        </div>

        <!-- โครงการที่เลือก & สถิติหน้างาน -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
            <!-- ตัวเลือกโครงการ -->
            <div class="earth-admin-card p-5 lg:col-span-1 flex flex-col justify-between">
                <div>
                    <label class="block text-xs font-semibold text-[#6B6357] uppercase tracking-wider mb-2 font-mono flex items-center gap-1.5">
                        <i data-lucide="calendar" class="w-4 h-4 text-[#5A6B47]"></i> โครงการปฏิบัติธรรมที่กำลังเช็คชื่อ:
                    </label>
                    <form method="GET" action="{{ route('admin.ug.scanner') }}" id="batchForm">
                        <select name="batch_id" onchange="document.getElementById('batchForm').submit()" class="w-full px-3.5 py-2.5 bg-[#FAF8F2] border border-[#D5CEBC] rounded-xl text-xs font-medium text-[#2C3E2D] focus:ring-2 focus:ring-[#5A6B47] focus:outline-none">
                            @foreach ($batches as $b)
                                <option value="{{ $b->id }}" {{ $selectedBatchId == $b->id ? 'selected' : '' }}>
                                    ปี {{ $b->academic_year }}: {{ $b->title }} ({{ $b->organizationUnit->name_th ?? 'มจร' }})
                                </option>
                            @endforeach
                        </select>
                    </form>
                </div>

                @if ($selectedBatch)
                    <div class="mt-4 pt-4 border-t border-[#EAE5D9] text-xs text-[#6B6357] space-y-1">
                        <div class="font-medium text-[#2C3E2D]">{{ $selectedBatch->title }}</div>
                        <div class="text-[11px] flex items-center gap-1 text-[#7B8D65]">
                            <i data-lucide="map-pin" class="w-3.5 h-3.5 text-[#C86D51]"></i> {{ $selectedBatch->location }}
                        </div>
                        <div class="text-[11px] font-mono text-[#7B8D65]">
                            {{ $selectedBatch->start_date }} ถึง {{ $selectedBatch->end_date }}
                        </div>
                    </div>
                @endif
            </div>

            <!-- กล่องสรุปสถานะการรายงานตัว -->
            <div class="lg:col-span-2 grid grid-cols-2 sm:grid-cols-4 gap-4">
                <div class="earth-admin-card p-4 flex flex-col justify-between">
                    <span class="text-xs text-[#7B8D65] font-medium flex items-center gap-1">
                        <i data-lucide="users" class="w-3.5 h-3.5"></i> ลงทะเบียนทั้งหมด
                    </span>
                    <div class="text-2xl font-heading font-bold text-[#2C3E2D] mt-2 font-mono" id="statTotal">{{ $stats['total'] }}</div>
                    <span class="text-[10px] text-[#8C8275]">ท่านในโครงการนี้</span>
                </div>

                <div class="earth-admin-card p-4 flex flex-col justify-between bg-gradient-to-br from-white to-[#E9EFE2]">
                    <span class="text-xs text-[#5A6B47] font-semibold flex items-center gap-1">
                        <i data-lucide="user-check" class="w-3.5 h-3.5"></i> รายงานตัวแล้ว
                    </span>
                    <div class="text-2xl font-heading font-bold text-[#5A6B47] mt-2 font-mono" id="statCheckedIn">{{ $stats['checked_in'] }}</div>
                    <span class="text-[10px] text-[#5A6B47] font-medium">เข้าปฏิบัติธรรมแล้ว</span>
                </div>

                <div class="earth-admin-card p-4 flex flex-col justify-between">
                    <span class="text-xs text-[#C86D51] font-medium flex items-center gap-1">
                        <i data-lucide="clock" class="w-3.5 h-3.5"></i> รอรายงานตัว
                    </span>
                    <div class="text-2xl font-heading font-bold text-[#C86D51] mt-2 font-mono" id="statRegistered">{{ $stats['registered'] }}</div>
                    <span class="text-[10px] text-[#8C8275]">ยังไม่เช็คอิน</span>
                </div>

                <div class="earth-admin-card p-4 flex flex-col justify-between">
                    <span class="text-xs text-[#2C3E2D] font-medium flex items-center gap-1">
                        <i data-lucide="award" class="w-3.5 h-3.5 text-[#5A6B47]"></i> ผ่านเกณฑ์ 10 วัน
                    </span>
                    <div class="text-2xl font-heading font-bold text-[#2C3E2D] mt-2 font-mono" id="statCompleted">{{ $stats['completed'] }}</div>
                    <span class="text-[10px] text-[#8C8275]">ประเมินผลเสร็จสิ้น</span>
                </div>
            </div>
        </div>

        <!-- หน้าต่างสแกนเนอร์ & ช่องกรอกรหัส -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            
            <!-- คอลัมน์ซ้าย: กล้องสแกน QR Code (6 ส่วน) -->
            <div class="lg:col-span-7 space-y-6">
                <div class="earth-admin-card overflow-hidden">
                    <div class="p-4 border-b border-[#EAE5D9] bg-[#FAF8F2]/80 flex justify-between items-center">
                        <div class="font-heading font-bold text-[#2C3E2D] text-sm flex items-center gap-2">
                            <i data-lucide="camera" class="w-4 h-4 text-[#5A6B47]"></i>
                            <span>กล้องสแกน QR Code หน้างาน</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <button id="toggleCameraBtn" onclick="toggleCamera()" class="px-3 py-1 bg-[#5A6B47] hover:bg-[#2C3E2D] text-white rounded-lg text-xs font-medium transition flex items-center gap-1 shadow-sm">
                                <i data-lucide="video" class="w-3.5 h-3.5"></i> <span id="cameraBtnText">เปิดกล้อง</span>
                            </button>
                        </div>
                    </div>

                    <div class="p-6">
                        <!-- Camera Viewport Box -->
                        <div class="relative bg-black rounded-2xl overflow-hidden aspect-square max-w-sm mx-auto flex items-center justify-center border-2 border-[#D5CEBC] shadow-inner">
                            <div id="qr-reader" class="w-full h-full"></div>
                            
                            <!-- Scanner Overlay (แสดงตอนยังไม่เปิดกล้อง) -->
                            <div id="cameraPlaceholder" class="absolute inset-0 flex flex-col items-center justify-center p-6 text-center bg-[#243325] text-white">
                                <div class="w-16 h-16 rounded-2xl bg-white/10 flex items-center justify-center mb-3 text-[#A3B88C]">
                                    <i data-lucide="qr-code" class="w-8 h-8"></i>
                                </div>
                                <div class="font-heading font-bold text-base mb-1">กล้องสแกนเนอร์ยังไม่เปิด</div>
                                <p class="text-xs text-[#D5CEBC]/80 mb-4 max-w-xs leading-relaxed">
                                    กดปุ่ม "เปิดกล้อง" ด้านล่าง เพื่อใช้กล้องจากสมาร์ตโฟนหรือเว็บแคมสแกน E-Ticket ของนิสิต
                                </p>
                                <button onclick="startCamera()" class="bg-[#5A6B47] hover:bg-[#7B8D65] text-white text-xs font-semibold px-4 py-2.5 rounded-xl transition flex items-center gap-2 shadow-lg">
                                    <i data-lucide="video" class="w-4 h-4"></i> เริ่มต้นสแกนด้วยกล้อง
                                </button>
                            </div>

                            <!-- เลเซอร์สแกนตอนเปิดกล้อง -->
                            <div id="scannerLaser" class="scanner-laser hidden"></div>
                        </div>

                        <!-- Manual Input Fallback -->
                        <div class="mt-6 pt-6 border-t border-[#EAE5D9]">
                            <label class="block text-xs font-semibold text-[#4A3B32] mb-1.5 flex items-center gap-1.5">
                                <i data-lucide="barcode" class="w-4 h-4 text-[#C86D51]"></i> 
                                หรือกรอกรหัสนิสิต / เลขที่ใบสมัคร / เลขบัตรประชาชน:
                            </label>
                            <form onsubmit="handleManualSubmit(event)" class="flex gap-2">
                                <input type="text" id="manualCodeInput" placeholder="เช่น 6601201001 หรือ UG-2569-xxxx" 
                                    class="flex-grow px-3.5 py-2.5 bg-[#FAF8F2] border border-[#D5CEBC] rounded-xl text-xs font-mono font-medium focus:ring-2 focus:ring-[#5A6B47] focus:outline-none">
                                <button type="submit" class="bg-[#2C3E2D] hover:bg-[#1E2B1F] text-white px-5 py-2.5 rounded-xl text-xs font-medium transition flex items-center gap-1.5 shadow-sm shrink-0">
                                    <i data-lucide="check-circle" class="w-4 h-4"></i> เช็คชื่อ
                                </button>
                            </form>
                            <div class="text-[11px] text-[#8C8275] mt-1.5">รองรับการยิงด้วย Barcode/QR Scanner ผ่านพอร์ต USB โดยตรง</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- คอลัมน์ขวา: ผลการตรวจสอบล่าสุด & ประวัติการเช็คอิน (5 ส่วน) -->
            <div class="lg:col-span-5 space-y-6">
                <!-- การ์ดผลการสแกน (Scan Result Card) -->
                <div class="earth-admin-card p-6" id="resultCardContainer">
                    <div class="flex items-center justify-between pb-3 border-b border-[#EAE5D9] mb-4">
                        <h2 class="font-heading font-bold text-sm text-[#2C3E2D] flex items-center gap-2">
                            <i data-lucide="badge-check" class="w-4 h-4 text-[#5A6B47]"></i>
                            <span>ผลการเช็คอินล่าสุด (Scan Status)</span>
                        </h2>
                        <span id="scanStatusBadge" class="text-[10px] font-semibold uppercase tracking-wider px-2 py-0.5 rounded-full bg-stone-100 text-stone-600 border border-stone-200">
                            รอสแกนข้อมูล
                        </span>
                    </div>

                    <!-- แสดงเมื่อยังไม่มีการสแกน -->
                    <div id="noScanYet" class="text-center py-8 text-[#8C8275]">
                        <i data-lucide="scan-line" class="w-10 h-10 mx-auto mb-2 text-[#D5CEBC]"></i>
                        <p class="text-xs">นำ QR Code บัตรลงทะเบียนของนิสิตมาจ่อหน้ากล้อง<br>ระบบจะทำการเช็คชื่อและแจ้งผลอัตโนมัติ</p>
                    </div>

                    <!-- รายละเอียดนิสิตเมื่อสแกนผ่าน -->
                    <div id="studentResultCard" class="hidden space-y-4">
                        <div class="p-4 rounded-xl bg-[#E9EFE2] border border-[#CADBC0] text-center" id="resultAlertBox">
                            <div class="w-10 h-10 rounded-full bg-[#5A6B47] text-white flex items-center justify-center mx-auto mb-2 shadow-sm">
                                <i data-lucide="check" class="w-6 h-6"></i>
                            </div>
                            <div class="font-heading font-bold text-[#2C3E2D] text-base" id="resStudentName">-</div>
                            <div class="text-xs font-mono text-[#5A6B47] font-semibold mt-0.5" id="resStudentCode">-</div>
                            <div class="text-[11px] text-[#5A6B47] mt-1 font-medium" id="resStatusMsg">เช็คอินรายงานตัวเรียบร้อยแล้ว</div>
                        </div>

                        <div class="bg-[#FAF8F2] border border-[#EAE5D9] rounded-xl p-3.5 text-xs space-y-2">
                            <div class="flex justify-between">
                                <span class="text-[#7B8D65]">เลขที่สมัคร:</span>
                                <span class="font-mono font-bold text-[#C86D51]" id="resRegNo">-</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-[#7B8D65]">ส่วนงานสังกัด:</span>
                                <span class="font-medium text-[#2C3E2D]" id="resOrgUnit">-</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-[#7B8D65]">ชั้นปี / โครงการ:</span>
                                <span class="text-[#2C3E2D]" id="resStudyYear">-</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-[#7B8D65]">เวลาที่รายงานตัว:</span>
                                <span class="font-mono text-[#2C3E2D]" id="resCheckinTime">-</span>
                            </div>
                        </div>

                        <div class="text-center pt-2">
                            <button onclick="resetResultCard()" class="text-xs text-[#7B8D65] hover:text-[#2C3E2D] underline font-medium">
                                เคลียร์ผลลัพธ์เพื่อสแกนคนต่อไป
                            </button>
                        </div>
                    </div>
                </div>

                <!-- รายชื่อผู้เพิ่งเช็คอินล่าสุดในโครงการนี้ -->
                <div class="earth-admin-card p-5">
                    <div class="flex items-center justify-between pb-3 border-b border-[#EAE5D9] mb-3">
                        <div class="font-heading font-bold text-xs text-[#2C3E2D] flex items-center gap-2">
                            <i data-lucide="history" class="w-4 h-4 text-[#5A6B47]"></i>
                            <span>ประวัติการรายงานตัวล่าสุด (10 ลำดับ)</span>
                        </div>
                        <span class="text-[10px] text-[#7B8D65] font-mono">Live Sync</span>
                    </div>

                    <div class="divide-y divide-[#EAE5D9] max-h-72 overflow-y-auto" id="recentCheckinsList">
                        @forelse ($recentCheckins as $chk)
                            <div class="py-2.5 flex items-center justify-between text-xs">
                                <div>
                                    <div class="font-semibold text-[#2C3E2D]">{{ $chk->prefix . $chk->first_name . ' ' . $chk->last_name }}</div>
                                    <div class="text-[10px] text-[#7B8D65] font-mono">{{ $chk->student_code }} &bull; {{ $chk->organizationUnit->name_th ?? 'มจร' }}</div>
                                </div>
                                <div class="text-right">
                                    <span class="inline-flex px-2 py-0.5 rounded-full text-[10px] font-semibold bg-[#5A6B47]/15 text-[#5A6B47] border border-[#5A6B47]/30">
                                        รายงานตัวแล้ว
                                    </span>
                                    <div class="text-[9px] text-[#8C8275] font-mono mt-0.5">
                                        {{ $chk->checked_in_at ? \Carbon\Carbon::parse($chk->checked_in_at)->format('H:i:s น.') : '-' }}
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="py-8 text-center text-xs text-[#8C8275]">
                                ยังไม่มีข้อมูลการรายงานตัวในโครงการนี้
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

        </div>

    </main>

    <!-- Audio Beep effects using Web Audio API -->
    <script>
        const audioCtx = new (window.AudioContext || window.webkitAudioContext)();
        function playBeep(success = true) {
            try {
                if (audioCtx.state === 'suspended') {
                    audioCtx.resume();
                }
                const osc = audioCtx.createOscillator();
                const gain = audioCtx.createGain();
                osc.connect(gain);
                gain.connect(audioCtx.destination);
                
                if (success) {
                    osc.frequency.setValueAtTime(880, audioCtx.currentTime); // High pitch (A5)
                    gain.gain.setValueAtTime(0.15, audioCtx.currentTime);
                    osc.start();
                    osc.stop(audioCtx.currentTime + 0.15);
                } else {
                    osc.frequency.setValueAtTime(300, audioCtx.currentTime); // Low buzz
                    gain.gain.setValueAtTime(0.2, audioCtx.currentTime);
                    osc.start();
                    osc.stop(audioCtx.currentTime + 0.35);
                }
            } catch(e) {
                console.log('Audio notification error:', e);
            }
        }
    </script>

    <!-- QR Code Scanning Logic -->
    <script>
        let html5QrCode = null;
        let isCameraRunning = false;
        let isProcessing = false;
        const currentBatchId = {{ $selectedBatchId ?? 'null' }};

        function toggleCamera() {
            if (isCameraRunning) {
                stopCamera();
            } else {
                startCamera();
            }
        }

        function startCamera() {
            if (isCameraRunning) return;

            const placeholder = document.getElementById('cameraPlaceholder');
            const laser = document.getElementById('scannerLaser');
            const btnText = document.getElementById('cameraBtnText');

            html5QrCode = new Html5Qrcode("qr-reader");

            const config = { 
                fps: 10, 
                qrbox: { width: 250, height: 250 },
                aspectRatio: 1.0 
            };

            html5QrCode.start(
                { facingMode: "environment" }, 
                config, 
                onScanSuccess, 
                onScanError
            ).then(() => {
                isCameraRunning = true;
                placeholder.classList.add('hidden');
                laser.classList.remove('hidden');
                btnText.textContent = 'ปิดกล้อง';
            }).catch(err => {
                console.error("Camera start failed:", err);
                alert("ไม่สามารถเปิดกล้องได้ กรุณาตรวจสอบการอนุญาตใช้งานกล้อง (Camera Permission) ในเบราว์เซอร์");
            });
        }

        function stopCamera() {
            if (!isCameraRunning || !html5QrCode) return;

            html5QrCode.stop().then(() => {
                isCameraRunning = false;
                document.getElementById('cameraPlaceholder').classList.remove('hidden');
                document.getElementById('scannerLaser').classList.add('hidden');
                document.getElementById('cameraBtnText').textContent = 'เปิดกล้อง';
            }).catch(err => console.error("Camera stop error:", err));
        }

        function onScanSuccess(decodedText, decodedResult) {
            if (isProcessing) return;
            isProcessing = true;

            verifyCode(decodedText);

            // หน่วงเวลา 2.5 วินาทีก่อนให้สแกนใหม่ เพื่อป้องกันสแกนซ้ำรัวๆ
            setTimeout(() => {
                isProcessing = false;
            }, 2500);
        }

        function onScanError(errorMessage) {
            // ไม่ต้องทำอะไร ปล่อยให้วนจับภาพต่อไป
        }

        function handleManualSubmit(e) {
            e.preventDefault();
            const input = document.getElementById('manualCodeInput');
            const code = input.value.trim();
            if (!code) {
                alert('กรุณากรอกรหัสนิสิตหรือเลขที่ลงทะเบียน');
                return;
            }
            verifyCode(code);
            input.value = '';
        }

        function verifyCode(code) {
            const formData = new FormData();
            formData.append('code', code);
            if (currentBatchId) {
                formData.append('batch_id', currentBatchId);
            }
            formData.append('_token', '{{ csrf_token() }}');

            fetch("{{ route('admin.ug.scanner.verify') }}", {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    playBeep(true);
                    renderStudentResult(data);
                    updateStats();
                    appendRecentCheckin(data.student);
                } else {
                    playBeep(false);
                    renderErrorResult(data.message);
                }
            })
            .catch(err => {
                console.error(err);
                playBeep(false);
                renderErrorResult('เกิดข้อผิดพลาดในการเชื่อมต่อเซิร์ฟเวอร์');
            });
        }

        function renderStudentResult(data) {
            const student = data.student;
            document.getElementById('noScanYet').classList.add('hidden');
            const resCard = document.getElementById('studentResultCard');
            resCard.classList.remove('hidden');

            const alertBox = document.getElementById('resultAlertBox');
            const badge = document.getElementById('scanStatusBadge');

            if (data.already_checked_in) {
                alertBox.className = "p-4 rounded-xl bg-amber-50 border border-amber-200 text-center";
                badge.className = "text-[10px] font-semibold uppercase tracking-wider px-2.5 py-0.5 rounded-full bg-amber-100 text-amber-800 border border-amber-300";
                badge.textContent = "เคยเช็คอินแล้ว";
            } else {
                alertBox.className = "p-4 rounded-xl bg-[#E9EFE2] border border-[#CADBC0] text-center";
                badge.className = "text-[10px] font-semibold uppercase tracking-wider px-2.5 py-0.5 rounded-full bg-[#5A6B47]/15 text-[#5A6B47] border border-[#5A6B47]/30";
                badge.textContent = "เช็คอินสำเร็จ";
            }

            document.getElementById('resStudentName').textContent = student.full_name;
            document.getElementById('resStudentCode').textContent = student.student_code;
            document.getElementById('resStatusMsg').textContent = data.message;
            document.getElementById('resRegNo').textContent = student.registration_no;
            document.getElementById('resOrgUnit').textContent = student.org_unit_name;
            document.getElementById('resStudyYear').textContent = `ชั้นปี ${student.study_year} (${student.faculty})`;
            document.getElementById('resCheckinTime').textContent = student.checked_in_at;

            lucide.createIcons();
        }

        function renderErrorResult(msg) {
            document.getElementById('noScanYet').classList.add('hidden');
            const resCard = document.getElementById('studentResultCard');
            resCard.classList.remove('hidden');

            const alertBox = document.getElementById('resultAlertBox');
            alertBox.className = "p-4 rounded-xl bg-red-50 border border-red-200 text-center";
            
            const badge = document.getElementById('scanStatusBadge');
            badge.className = "text-[10px] font-semibold uppercase tracking-wider px-2.5 py-0.5 rounded-full bg-red-100 text-red-700 border border-red-200";
            badge.textContent = "ไม่พบข้อมูล";

            document.getElementById('resStudentName').textContent = "ไม่พบข้อมูล";
            document.getElementById('resStudentCode').textContent = "-";
            document.getElementById('resStatusMsg').textContent = msg;
            document.getElementById('resRegNo').textContent = "-";
            document.getElementById('resOrgUnit').textContent = "-";
            document.getElementById('resStudyYear').textContent = "-";
            document.getElementById('resCheckinTime').textContent = "-";

            lucide.createIcons();
        }

        function resetResultCard() {
            document.getElementById('studentResultCard').classList.add('hidden');
            document.getElementById('noScanYet').classList.remove('hidden');
            const badge = document.getElementById('scanStatusBadge');
            badge.className = "text-[10px] font-semibold uppercase tracking-wider px-2 py-0.5 rounded-full bg-stone-100 text-stone-600 border border-stone-200";
            badge.textContent = "รอสแกนข้อมูล";
            lucide.createIcons();
        }

        function updateStats() {
            const chkEl = document.getElementById('statCheckedIn');
            const regEl = document.getElementById('statRegistered');
            let chkCount = parseInt(chkEl.textContent) || 0;
            let regCount = parseInt(regEl.textContent) || 0;
            chkEl.textContent = chkCount + 1;
            if (regCount > 0) {
                regEl.textContent = regCount - 1;
            }
        }

        function appendRecentCheckin(student) {
            const list = document.getElementById('recentCheckinsList');
            const item = document.createElement('div');
            item.className = "py-2.5 flex items-center justify-between text-xs bg-[#5A6B47]/10 px-2 rounded-lg mb-1 animate-pulse";
            item.innerHTML = `
                <div>
                    <div class="font-semibold text-[#2C3E2D]">${student.full_name}</div>
                    <div class="text-[10px] text-[#7B8D65] font-mono">${student.student_code} &bull; ${student.org_unit_name}</div>
                </div>
                <div class="text-right">
                    <span class="inline-flex px-2 py-0.5 rounded-full text-[10px] font-semibold bg-[#5A6B47]/15 text-[#5A6B47] border border-[#5A6B47]/30">
                        เพิ่งเช็คอิน
                    </span>
                    <div class="text-[9px] text-[#8C8275] font-mono mt-0.5">
                        ${student.checked_in_at}
                    </div>
                </div>
            `;
            list.insertBefore(item, list.firstChild);
            setTimeout(() => {
                item.classList.remove('animate-pulse', 'bg-[#5A6B47]/10');
            }, 3000);
        }

        lucide.createIcons();
    </script>
</body>
</html>
