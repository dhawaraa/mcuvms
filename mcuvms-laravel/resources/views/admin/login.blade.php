<!DOCTYPE html>
<html lang="th" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เข้าสู่ระบบเจ้าหน้าที่ - MCUVMS Admin (Laravel)</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@300;400;500;600;700&family=Prompt:wght@400;500;600;700&display=swap" rel="stylesheet">
    
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
                    },
                    colors: {
                        earth: {
                            sand: '#F7F4EA',
                            stone: '#EAE5D9',
                            clay: '#C86D51',
                            clayDark: '#A85238',
                            forest: '#2C3E2D',
                            olive: '#5A6B47',
                            oliveLight: '#7B8D65',
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
            background-color: #F7F5EE;
            color: #2D2A26;
        }
        h1, h2, h3, h4, .font-heading { font-family: 'Prompt', sans-serif; }
        .organic-card {
            background: rgba(255, 255, 255, 0.94);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(220, 215, 201, 0.85);
            box-shadow: 0 15px 35px -10px rgba(74, 59, 50, 0.08), 0 0 0 1px rgba(90, 107, 71, 0.08);
        }
        .organic-mesh {
            background-image: 
                radial-gradient(at 15% 15%, rgba(90, 107, 71, 0.15) 0px, transparent 50%),
                radial-gradient(at 85% 20%, rgba(200, 109, 81, 0.12) 0px, transparent 50%),
                radial-gradient(at 50% 85%, rgba(44, 62, 45, 0.10) 0px, transparent 60%);
        }
    </style>
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/mcu-logo.png') }}">
    <link rel="shortcut icon" href="{{ asset('images/mcu-logo.png') }}">
</head>
<body class="antialiased min-h-screen flex items-center justify-center p-4 selection:bg-[#5A6B47] selection:text-white relative">

    <!-- Organic Background Layer -->
    <div class="fixed inset-0 pointer-events-none z-[-1] organic-mesh"></div>

    <div class="max-w-md w-full relative z-10">
        <!-- Logo & Header -->
        <div class="text-center mb-8">
            <div class="w-20 h-20 mx-auto mb-4 flex items-center justify-center p-2 rounded-3xl bg-white shadow-xl shadow-[#2C3E2D]/10 border border-[#EAE5D9]">
                <img src="{{ asset('images/mcu-logo.png') }}" alt="MCU Logo" class="w-full h-full object-contain">
            </div>
            <h1 class="text-2xl font-heading font-bold text-[#2C3E2D]">MCUVMS Admin Console</h1>
            <p class="text-xs text-[#7B8D65] mt-1 font-medium">ระบบสารสนเทศการปฏิบัติวิปัสสนากรรมฐาน มจร</p>
        </div>

        @if (session('error'))
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-2xl mb-6 text-sm flex items-center shadow-sm">
                <i data-lucide="alert-circle" class="w-4 h-4 mr-2 text-red-600 shrink-0"></i>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <!-- Card Login -->
        <div class="organic-card rounded-3xl p-8">
            <form action="{{ route('login.post') }}" method="POST" class="space-y-5">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-[#4A3B32] mb-2 flex items-center gap-1.5">
                        <i data-lucide="user" class="w-3.5 h-3.5 text-[#5A6B47]"></i>
                        <span>ชื่อผู้ใช้ (Username)</span>
                    </label>
                    <input type="text" name="username" value="admin" required class="w-full px-4 py-3 bg-[#FAF8F2] border border-[#EAE5D9] rounded-xl text-sm focus:ring-2 focus:ring-[#5A6B47] focus:border-[#5A6B47] font-mono text-[#2C3E2D]">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-[#4A3B32] mb-2 flex items-center gap-1.5">
                        <i data-lucide="key-round" class="w-3.5 h-3.5 text-[#5A6B47]"></i>
                        <span>รหัสผ่าน (Password)</span>
                    </label>
                    <input type="password" name="password" value="password" required class="w-full px-4 py-3 bg-[#FAF8F2] border border-[#EAE5D9] rounded-xl text-sm focus:ring-2 focus:ring-[#5A6B47] focus:border-[#5A6B47] font-mono text-[#2C3E2D]">
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full py-3.5 bg-[#5A6B47] hover:bg-[#2C3E2D] text-white font-medium rounded-xl text-sm transition shadow-lg shadow-[#5A6B47]/25 font-heading flex items-center justify-center gap-2">
                        <i data-lucide="log-in" class="w-4 h-4"></i>
                        <span>เข้าสู่ระบบ (Sign In)</span>
                    </button>
                </div>
            </form>

            <div class="mt-6 pt-6 border-t border-[#EAE5D9] text-center">
                <div class="text-xs font-semibold text-[#7B8D65] mb-2">
                    บัญชีทดสอบในระบบ (รหัสผ่านทุกบัญชีคือ: <strong class="text-[#2C3E2D]">password</strong>):
                </div>
                <div class="space-y-1.5 text-[11px] font-mono text-[#4A3B32]">
                    <div class="bg-[#FAF8F2] py-1 px-2.5 rounded-lg border border-[#EAE5D9] flex justify-between">
                        <span>ส่วนกลาง (ทุก 52 วิทยาเขต):</span>
                        <strong class="text-[#2C3E2D]">central</strong>
                    </div>
                    <div class="bg-[#FAF8F2] py-1 px-2.5 rounded-lg border border-[#EAE5D9] flex justify-between">
                        <span>วิทยาเขตเชียงใหม่:</span>
                        <strong class="text-[#2C3E2D]">officer_cmi</strong>
                    </div>
                    <div class="bg-[#FAF8F2] py-1 px-2.5 rounded-lg border border-[#EAE5D9] flex justify-between">
                        <span>Super Administrator:</span>
                        <strong class="text-[#2C3E2D]">admin</strong>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center mt-6">
            <a href="{{ route('home') }}" class="text-xs text-[#7B8D65] hover:text-[#2C3E2D] font-medium inline-flex items-center gap-1.5 transition">
                <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i>
                <span>กลับไปยังหน้าพอร์ทัลหลัก</span>
            </a>
        </div>
    </div>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>
