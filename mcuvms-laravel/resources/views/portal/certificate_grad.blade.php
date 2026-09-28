<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>หนังสือรับรองผลการสะสมวันปฏิบัติวิปัสสนากรรมฐาน (ระดับบัณฑิตศึกษา) - {{ $student->student_code ?? $student->student_id }}</title>
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
            background: #EDEAE1; 
            color: #2D2A26;
        }
        h1, h2, h3, h4, .font-heading { font-family: 'Prompt', sans-serif; }

        /* A4 Certificate Box */
        .cert-container {
            width: 100%;
            max-width: 860px;
            background: #FFFFFF;
            position: relative;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.08);
            border: 1px solid #D5CEBC;
        }

        .cert-outer-border {
            border: 2px solid #2C3E2D;
            padding: 8px;
        }
        .cert-inner-border {
            border: 1px dashed #5A6B47;
            padding: 36px 44px;
            position: relative;
            background: radial-gradient(circle at center, #FFFFFF 0%, #FAF8F2 100%);
        }

        .cert-watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 320px;
            opacity: 0.04;
            pointer-events: none;
        }

        @media print {
            body {
                background: white !important;
                padding: 0 !important;
                margin: 0 !important;
            }
            .no-print {
                display: none !important;
            }
            .cert-container {
                box-shadow: none !important;
                border: none !important;
                max-width: 100% !important;
                margin: 0 !important;
            }
            @page {
                size: A4 portrait;
                margin: 10mm;
            }
        }
    </style>
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/mcu-logo.png') }}">
</head>
<body class="min-h-screen py-8 px-4 flex flex-col items-center justify-between">

    <!-- Action Bar (No Print) -->
    <div class="no-print max-w-[860px] w-full mb-6 flex flex-col sm:flex-row justify-between items-center bg-white p-4 rounded-2xl border border-[#D5CEBC] shadow-sm gap-3">
        <div class="flex items-center gap-2">
            <a href="{{ route('grad.progress', ['student_code' => $student->student_code ?? $student->student_id]) }}" class="px-3.5 py-2 text-xs font-semibold text-[#4A3B32] hover:text-[#2C3E2D] bg-[#FAF8F2] hover:bg-[#EAE5D9] rounded-xl border border-[#D5CEBC] transition flex items-center gap-1.5">
                <i data-lucide="arrow-left" class="w-4 h-4 text-[#5A6B47]"></i> กลับหน้าประวัติสะสมวัน
            </a>
            <span class="text-xs text-[#7B8D65] font-mono">
                รหัสนิสิต: <strong class="text-[#2C3E2D]">{{ $student->student_code ?? $student->student_id }}</strong>
            </span>
        </div>
        <div class="flex items-center gap-2.5">
            <button onclick="window.print()" class="bg-[#2C3E2D] hover:bg-[#3D523E] text-white px-5 py-2 rounded-xl text-xs font-semibold shadow-sm transition flex items-center gap-2">
                <i data-lucide="printer" class="w-4 h-4 text-[#A3B88C]"></i> พิมพ์หนังสือรับรอง (Print A4)
            </button>
        </div>
    </div>

    <!-- Official Certificate Container (A4 Style) -->
    <div class="cert-container rounded-2xl overflow-hidden p-3">
        <div class="cert-outer-border rounded-xl">
            <div class="cert-inner-border rounded-lg text-center">
                
                <!-- Watermark Logo -->
                <img src="{{ asset('images/mcu-logo.png') }}" class="cert-watermark" alt="Watermark">

                <!-- Header Logo -->
                <div class="w-20 h-20 mx-auto mb-3">
                    <img src="{{ asset('images/mcu-logo.png') }}" alt="MCU Logo" class="w-full h-full object-contain">
                </div>

                <div class="text-[11px] font-mono font-bold tracking-widest text-[#2C3E2D] uppercase mb-1">
                    GRADUATE SCHOOL &bull; MAHACHULALONGKORNRAJAVIDYALAYA UNIVERSITY
                </div>
                <h1 class="text-xl md:text-2xl font-heading font-extrabold text-[#2C3E2D] tracking-tight">
                    มหาวิทยาลัยมหาจุฬาลงกรณราชวิทยาลัย
                </h1>
                <h2 class="text-sm font-heading font-semibold text-[#6B6357] mt-0.5">
                    บัณฑิตวิทยาลัย ร่วมกับ สถาบันวิปัสสนาธุระ
                </h2>

                <div class="w-28 h-0.5 bg-[#C86D51] mx-auto my-5"></div>

                <div class="inline-block px-4 py-1 rounded-full bg-[#2C3E2D]/10 text-[#2C3E2D] border border-[#2C3E2D]/20 text-xs font-heading font-bold uppercase tracking-wider mb-5">
                    หนังสือรับรองผลการปฏิบัติวิปัสสนากรรมฐาน (e-Certificate of Meditation Completion)
                </div>

                <p class="text-xs text-[#6B6357] mb-2 font-medium">หนังสือรับรองฉบับนี้ให้ไว้เพื่อแสดงว่า</p>

                <!-- Recipient Name -->
                <div class="text-2xl md:text-3xl font-heading font-bold text-[#2C3E2D] mb-1">
                    {{ ($student->prefix ?? '') . ($student->full_name ?? ($student->first_name . ' ' . $student->last_name)) }}
                </div>

                <div class="text-xs font-mono font-medium text-[#4A3B32] mb-4 space-x-2">
                    <span>รหัสนิสิต: <strong class="text-[#2C3E2D] font-bold">{{ $student->student_code ?? $student->student_id }}</strong></span>
                    <span>&bull;</span>
                    <span>ระดับการศึกษา: <strong class="text-[#2C3E2D]">{{ $student->degree_level === 'DOCTORAL' ? 'ปริญญาเอก' : 'ปริญญาโท' }}</strong></span>
                    <span>&bull;</span>
                    <span>สาขาวิชา: <strong class="text-[#2C3E2D]">{{ $student->major ?? ($student->program_name ?? 'พุทธศาสน์ศึกษา') }}</strong></span>
                </div>

                <!-- Retreat Details Paragraph -->
                <div class="max-w-xl mx-auto text-xs md:text-sm text-[#4A3B32] leading-relaxed my-5">
                    ได้ปฏิบัติวิปัสสนากรรมฐานและสอบอารมณ์กับพระวิปัสสนาจารย์ตามระเบียบมหาวิทยาลัย<br>
                    สะสมวันปฏิบัติธรรมครบถ้วนตามเกณฑ์มาตรฐานหลักสูตร <strong class="text-[#5A6B47]">ครบจำนวน {{ $student->target_days }} วัน</strong> (สะสมจริง {{ $student->accumulated_days }} วัน)<br>
                    ได้รับการตรวจสอบและอนุมัติรับรองผลอย่างเป็นทางการจากคณะกรรมการบัณฑิตวิทยาลัย<br>
                    มีคุณสมบัติครบถ้วนตามเกณฑ์วิปัสสนากรรมฐานเพื่อยื่นขอสอบวิทยานิพนธ์และสำเร็จการศึกษา
                </div>

                <p class="text-xs text-[#6B6357] mt-3">
                    ขอผลานิสงส์แห่งการเจริญสติปัฏฐานภาวนา จงเป็นพลวปัจจัยหนุนนำให้เจริญด้วยปัญญาญาณในพระสัจธรรมยิ่งๆ ขึ้นไป
                </p>

                <!-- Signatures Section -->
                <div class="mt-12 pt-6 grid grid-cols-2 gap-8 text-center text-xs">
                    <div>
                        <div class="h-10"></div>
                        <div class="font-semibold text-[#2C3E2D]">(........................................................)</div>
                        <div class="font-heading font-medium text-[#4A3B32] mt-1">คณบดีบัณฑิตวิทยาลัย</div>
                        <div class="text-[10px] text-[#7B8D65]">มหาวิทยาลัยมหาจุฬาลงกรณราชวิทยาลัย</div>
                    </div>
                    <div>
                        <div class="h-10"></div>
                        <div class="font-semibold text-[#2C3E2D]">(........................................................)</div>
                        <div class="font-heading font-medium text-[#4A3B32] mt-1">ผู้อำนวยการสถาบันวิปัสสนาธุระ</div>
                        <div class="text-[10px] text-[#7B8D65]">มหาวิทยาลัยมหาจุฬาลงกรณราชวิทยาลัย</div>
                    </div>
                </div>

                <!-- Footer QR Code Verification & Stamp -->
                <div class="mt-10 pt-4 border-t border-[#EAE5D9] flex flex-col sm:flex-row justify-between items-center text-[10px] text-[#7B8D65] gap-3">
                    <div class="flex items-center gap-3 text-left">
                        <div class="p-1 bg-white border border-[#D5CEBC] rounded-lg shadow-sm">
                            <img src="https://api.qrserver.com/v1/create-qr-code/?size=80x80&data={{ urlencode($verifyUrl) }}" alt="Verify QR" class="w-16 h-16 object-contain">
                        </div>
                        <div>
                            <div class="font-semibold text-[#2C3E2D] flex items-center gap-1">
                                <i data-lucide="shield-check" class="w-3.5 h-3.5 text-[#5A6B47]"></i> MCU Graduate Official Certificate
                            </div>
                            <div class="font-mono">รหัสรับรอง: GRAD-CERT-{{ $student->student_code ?? $student->student_id }}</div>
                            <div class="text-[9px] text-[#8C8275]">สแกนเพื่อตรวจสอบความถูกต้องของเอกสารผ่านระบบกลาง</div>
                        </div>
                    </div>

                    <div class="text-right font-mono">
                        <div>อนุมัติสมบูรณ์เมื่อ: {{ $student->approved_at ? \Carbon\Carbon::parse($student->approved_at)->format('d/m/Y H:i') : \Carbon\Carbon::now()->format('d/m/Y H:i') }}</div>
                        <div class="text-[9px] text-[#8C8275]">MCUVMS Lock Engine & Security Certification</div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Footer Note (No Print) -->
    <footer class="no-print mt-6 text-center text-xs text-[#8C8275]">
        ระบบสารสนเทศการปฏิบัติวิปัสสนากรรมฐาน (MCUVMS) &bull; บัณฑิตวิทยาลัย มหาวิทยาลัยมหาจุฬาลงกรณราชวิทยาลัย
    </footer>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>
