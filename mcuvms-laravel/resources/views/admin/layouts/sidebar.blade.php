@php
    $currentRoute = Route::currentRouteName();
    $currentUrl = request()->path();

    // ตรวจสอบว่าอยู่ในหมวด ป.ตรี หรือไม่
    $isUgActive = in_array($currentRoute, [
        'admin.ug.batches',
        'admin.ug.import',
        'admin.ug.students',
        'admin.ug.scanner',
        'admin.ug.attendance',
    ]) || str_contains($currentUrl, 'admin/ug');

    // ตรวจสอบว่าอยู่ในกลุ่ม การตั้งค่า หรือไม่
    $isSettingsActive = in_array($currentRoute, [
        'admin.org_units.index',
        'admin.users.index',
        'admin.contact.settings',
    ]) || str_contains($currentUrl, 'org_units') || str_contains($currentUrl, 'users') || str_contains($currentUrl, 'contact_settings') || str_contains($currentUrl, 'contact-settings');
@endphp

<!-- Earth Tones Sidebar (Deep Forest & Olive) with Expand/Collapse Engine -->
<aside id="admin-sidebar" class="no-print w-full md:w-72 md:h-screen md:sticky md:top-0 bg-[#243325] text-[#D5CEBC] flex flex-col justify-between shrink-0 shadow-xl border-r border-[#1B271C] z-30 transition-all duration-300 ease-in-out">
    <!-- Header Brand (Fixed Top) -->
    <div class="p-4 md:p-5 border-b border-[#2C3E2D] flex items-center justify-between shrink-0">
        <div class="flex items-center space-x-3 overflow-hidden">
            <div class="w-10 h-10 rounded-xl bg-white/10 p-1 flex items-center justify-center shadow-md ring-1 ring-white/10 shrink-0">
                <img src="{{ asset('images/mcu-logo.png') }}" alt="MCU Logo" class="w-full h-full object-contain">
            </div>
            <div class="sidebar-text transition-opacity duration-200">
                <div class="font-heading font-bold text-white text-base tracking-tight leading-tight whitespace-nowrap">MCUVMS Admin</div>
                <div class="text-[10px] text-[#A3B88C] font-mono tracking-wider uppercase font-semibold whitespace-nowrap">มจร ส่วนกลาง & วิทยาเขต</div>
            </div>
        </div>
        <!-- Toggle Button (ย่อ/ขยาย Sidebar) -->
        <button type="button" 
            onclick="toggleSidebarCollapse()" 
            id="sidebar-toggle-btn"
            title="ย่อ/ขยายแถบเมนู (Collapse Sidebar)"
            class="hidden md:flex p-1.5 rounded-lg bg-white/5 hover:bg-white/15 text-[#A3B88C] hover:text-white transition shrink-0 items-center justify-center">
            <i id="sidebar-toggle-icon" data-lucide="panel-left-close" class="w-4 h-4"></i>
        </button>
    </div>

    <!-- Nav Items (Scrollable when items expand) -->
    <div class="flex-1 overflow-y-auto custom-scrollbar">
        <nav class="p-3 md:p-4 space-y-1.5 text-xs font-medium">
            <div class="sidebar-text px-3 py-2 text-[10px] font-bold text-[#7E8B73] uppercase tracking-widest font-mono">แผงควบคุมหลัก</div>
            
            <!-- 1. ภาพรวมระบบ -->
            @if ($currentRoute === 'admin.dashboard')
                <a href="{{ route('admin.dashboard') }}" title="ภาพรวมระบบ (Overview)" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl bg-gradient-to-r from-[#5A6B47] to-[#465337] text-white shadow-md shadow-[#1B271C]/30 border border-[#7B8D65]/30">
                    <span class="flex items-center gap-3">
                        <i data-lucide="layout-dashboard" class="w-4 h-4 text-[#EAE5D9] shrink-0"></i>
                        <div class="sidebar-text whitespace-nowrap">
                            <div class="leading-tight font-semibold">ภาพรวมระบบ</div>
                            <div class="text-[10px] text-[#D5CEBC]/80 font-mono">Overview</div>
                        </div>
                    </span>
                    <span class="sidebar-text w-2 h-2 rounded-full bg-[#A3B88C] animate-pulse shrink-0"></span>
                </a>
            @else
                <a href="{{ route('admin.dashboard') }}" title="ภาพรวมระบบ (Overview)" class="flex items-center px-3.5 py-2.5 rounded-xl text-[#B8B1A2] hover:text-white hover:bg-[#2C3E2D] transition gap-3">
                    <i data-lucide="layout-dashboard" class="w-4 h-4 text-[#A3B88C] shrink-0"></i>
                    <div class="sidebar-text whitespace-nowrap">
                        <div class="leading-tight">ภาพรวมระบบ</div>
                        <div class="text-[10px] text-[#8C9B80] font-mono">Overview</div>
                    </div>
                </a>
            @endif

            <!-- 1.2 สถิติและวิเคราะห์ผู้บริหาร (Rule Matrix: ผู้บริหาร) -->
            @if ($currentRoute === 'admin.executive.analytics')
                <a href="{{ route('admin.executive.analytics') }}" title="สถิติวิเคราะห์ผู้บริหาร (Executive Analytics)" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl bg-gradient-to-r from-[#C86D51] to-[#A85238] text-white shadow-md shadow-[#1B271C]/30 border border-[#C86D51]/30">
                    <span class="flex items-center gap-3">
                        <i data-lucide="bar-chart-3" class="w-4 h-4 text-[#FAF8F2] shrink-0"></i>
                        <div class="sidebar-text whitespace-nowrap">
                            <div class="leading-tight font-semibold">สถิติวิเคราะห์ผู้บริหาร</div>
                            <div class="text-[10px] text-[#FAF8F2]/80 font-mono">Executive Analytics</div>
                        </div>
                    </span>
                    <span class="sidebar-text w-2 h-2 rounded-full bg-white animate-pulse shrink-0"></span>
                </a>
            @else
                <a href="{{ route('admin.executive.analytics') }}" title="สถิติวิเคราะห์ผู้บริหาร (Executive Analytics)" class="flex items-center px-3.5 py-2.5 rounded-xl text-[#B8B1A2] hover:text-white hover:bg-[#2C3E2D] transition gap-3">
                    <i data-lucide="bar-chart-3" class="w-4 h-4 text-[#C86D51] shrink-0"></i>
                    <div class="sidebar-text whitespace-nowrap">
                        <div class="leading-tight">สถิติวิเคราะห์ผู้บริหาร</div>
                        <div class="text-[10px] text-[#8C9B80] font-mono">Executive Analytics</div>
                    </div>
                </a>
            @endif

            <div class="sidebar-text pt-3 px-3 py-1.5 text-[10px] font-bold text-[#7E8B73] uppercase tracking-widest font-mono">ระบบงานสารสนเทศ</div>

            <!-- 2. เมนูแม่: ปริญญาตรี (ย่อ/ขยาย Dropdown เมนูย่อย 5 เมนู) -->
            <div class="rounded-xl overflow-hidden {{ $isUgActive ? 'bg-[#1C281D] border border-[#2C3E2D]' : '' }}">
                <button type="button" 
                    title="ปฏิบัติธรรม ป.ตรี (40 วัน)"
                    onclick="toggleSubmenu('submenu-ug', 'chevron-ug')" 
                    class="w-full flex items-center justify-between px-3.5 py-2.5 rounded-xl transition gap-3 {{ $isUgActive ? 'text-white font-semibold' : 'text-[#B8B1A2] hover:text-white hover:bg-[#2C3E2D]' }}">
                    <span class="flex items-center gap-3">
                        <i data-lucide="graduation-cap" class="w-4 h-4 {{ $isUgActive ? 'text-[#A3B88C]' : 'text-[#A3B88C]' }} shrink-0"></i>
                        <span class="sidebar-text text-left whitespace-nowrap">
                            <div class="leading-tight">ปฏิบัติธรรม ป.ตรี (40 วัน)</div>
                            <div class="text-[10px] text-[#8C9B80] font-mono font-normal">Undergraduate Module</div>
                        </span>
                    </span>
                    <i id="chevron-ug" data-lucide="chevron-down" class="sidebar-text w-4 h-4 text-[#8C9B80] transition-transform duration-200 {{ $isUgActive ? 'rotate-180 text-white' : '' }}"></i>
                </button>

                <!-- รายการเมนูย่อยของ ป.ตรี -->
                <div id="submenu-ug" class="space-y-1 px-2.5 pb-2.5 pt-1 border-t border-[#263727] {{ $isUgActive ? '' : 'hidden' }}">
                    
                    <!-- ย่อย 1: กำหนดการประจำปี -->
                    <a href="{{ route('admin.ug.batches') }}" title="กำหนดการโครงการ" class="flex items-center px-3 py-2 rounded-lg text-xs transition gap-2.5 {{ $currentRoute === 'admin.ug.batches' ? 'bg-[#5A6B47] text-white font-medium shadow-sm' : 'text-[#A8A190] hover:text-white hover:bg-[#2C3E2D]/80' }}">
                        <i data-lucide="calendar" class="w-3.5 h-3.5 shrink-0 {{ $currentRoute === 'admin.ug.batches' ? 'text-white' : 'text-[#8C9B80]' }}"></i>
                        <span class="sidebar-text whitespace-nowrap">กำหนดการโครงการ</span>
                    </a>

                    <!-- ย่อย 2: นำเข้าข้อมูลนิสิต CSV -->
                    <a href="{{ route('admin.ug.import') }}" title="นำเข้าข้อมูลนิสิต (CSV)" class="flex items-center px-3 py-2 rounded-lg text-xs transition gap-2.5 {{ $currentRoute === 'admin.ug.import' ? 'bg-[#5A6B47] text-white font-medium shadow-sm' : 'text-[#A8A190] hover:text-white hover:bg-[#2C3E2D]/80' }}">
                        <i data-lucide="file-up" class="w-3.5 h-3.5 shrink-0 {{ $currentRoute === 'admin.ug.import' ? 'text-white' : 'text-[#8C9B80]' }}"></i>
                        <span class="sidebar-text whitespace-nowrap">นำเข้าข้อมูลนิสิต (CSV)</span>
                    </a>

                    <!-- ย่อย 3: ทะเบียนนิสิตลงทะเบียน -->
                    <a href="{{ route('admin.ug.students') }}" title="ทะเบียนนิสิตลงทะเบียน" class="flex items-center px-3 py-2 rounded-lg text-xs transition gap-2.5 {{ $currentRoute === 'admin.ug.students' ? 'bg-[#5A6B47] text-white font-medium shadow-sm' : 'text-[#A8A190] hover:text-white hover:bg-[#2C3E2D]/80' }}">
                        <i data-lucide="users" class="w-3.5 h-3.5 shrink-0 {{ $currentRoute === 'admin.ug.students' ? 'text-white' : 'text-[#8C9B80]' }}"></i>
                        <span class="sidebar-text whitespace-nowrap">ทะเบียนนิสิตลงทะเบียน</span>
                    </a>

                    <!-- ย่อย 4: สแกน QR เช็คชื่อ -->
                    <a href="{{ route('admin.ug.scanner') }}" title="สแกน QR เช็คชื่อ" class="flex items-center px-3 py-2 rounded-lg text-xs transition gap-2.5 {{ $currentRoute === 'admin.ug.scanner' ? 'bg-[#5A6B47] text-white font-medium shadow-sm' : 'text-[#A8A190] hover:text-white hover:bg-[#2C3E2D]/80' }}">
                        <i data-lucide="qr-code" class="w-3.5 h-3.5 shrink-0 {{ $currentRoute === 'admin.ug.scanner' ? 'text-white' : 'text-[#8C9B80]' }}"></i>
                        <span class="sidebar-text whitespace-nowrap">สแกน QR เช็คชื่อ</span>
                    </a>

                    <!-- ย่อย 5: พิมพ์ใบเซ็นชื่อ -->
                    <a href="{{ route('admin.ug.attendance') }}" title="พิมพ์ใบเซ็นชื่อ (10 วัน)" class="flex items-center px-3 py-2 rounded-lg text-xs transition gap-2.5 {{ $currentRoute === 'admin.ug.attendance' ? 'bg-[#5A6B47] text-white font-medium shadow-sm' : 'text-[#A8A190] hover:text-white hover:bg-[#2C3E2D]/80' }}">
                        <i data-lucide="printer" class="w-3.5 h-3.5 shrink-0 {{ $currentRoute === 'admin.ug.attendance' ? 'text-white' : 'text-[#8C9B80]' }}"></i>
                        <span class="sidebar-text whitespace-nowrap">พิมพ์ใบเซ็นชื่อ (10 วัน)</span>
                    </a>

                </div>
            </div>

            <!-- 3. บัณฑิตศึกษา (ป.โท / ป.เอก) -->
            @if ($currentRoute === 'admin.grad.approvals')
                <a href="{{ route('admin.grad.approvals') }}" title="บัณฑิตศึกษา (30/45 วัน)" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl bg-gradient-to-r from-[#5A6B47] to-[#465337] text-white shadow-md shadow-[#1B271C]/30 border border-[#7B8D65]/30">
                    <span class="flex items-center gap-3">
                        <i data-lucide="scroll-text" class="w-4 h-4 text-[#EAE5D9] shrink-0"></i>
                        <div class="sidebar-text whitespace-nowrap">
                            <div class="leading-tight font-semibold">บัณฑิตศึกษา (30/45 วัน)</div>
                            <div class="text-[10px] text-[#D5CEBC]/80 font-mono">Graduate Studies</div>
                        </div>
                    </span>
                    <span class="sidebar-text w-2 h-2 rounded-full bg-[#A3B88C] animate-pulse shrink-0"></span>
                </a>
            @else
                <a href="{{ route('admin.grad.approvals') }}" title="บัณฑิตศึกษา (30/45 วัน)" class="flex items-center px-3.5 py-2.5 rounded-xl text-[#B8B1A2] hover:text-white hover:bg-[#2C3E2D] transition gap-3">
                    <i data-lucide="scroll-text" class="w-4 h-4 text-[#A3B88C] shrink-0"></i>
                    <div class="sidebar-text whitespace-nowrap">
                        <div class="leading-tight">บัณฑิตศึกษา (30/45 วัน)</div>
                        <div class="text-[10px] text-[#8C9B80] font-mono">Graduate Studies</div>
                    </div>
                </a>
            @endif

            <!-- 4. ภาคประชาชน (บริการสังคม) -->
            @if ($currentRoute === 'admin.public.sar')
                <a href="{{ route('admin.public.sar') }}" title="ภาคประชาชน (Public Community Events)" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl bg-gradient-to-r from-[#5A6B47] to-[#465337] text-white shadow-md shadow-[#1B271C]/30 border border-[#7B8D65]/30">
                    <span class="flex items-center gap-3">
                        <i data-lucide="users" class="w-4 h-4 text-[#EAE5D9] shrink-0"></i>
                        <div class="sidebar-text whitespace-nowrap">
                            <div class="leading-tight font-semibold">ภาคประชาชน</div>
                            <div class="text-[10px] text-[#D5CEBC]/80 font-mono">Public Community Events</div>
                        </div>
                    </span>
                    <span class="sidebar-text w-2 h-2 rounded-full bg-[#A3B88C] animate-pulse shrink-0"></span>
                </a>
            @else
                <a href="{{ route('admin.public.sar') }}" title="ภาคประชาชน (Public Community Events)" class="flex items-center px-3.5 py-2.5 rounded-xl text-[#B8B1A2] hover:text-white hover:bg-[#2C3E2D] transition gap-3">
                    <i data-lucide="users" class="w-4 h-4 text-[#A3B88C] shrink-0"></i>
                    <div class="sidebar-text whitespace-nowrap">
                        <div class="leading-tight">ภาคประชาชน</div>
                        <div class="text-[10px] text-[#8C9B80] font-mono">Public Community Events</div>
                    </div>
                </a>
            @endif

            <!-- 5. ข่าวสารประชาสัมพันธ์ -->
            @if ($currentRoute === 'admin.news.index')
                <a href="{{ route('admin.news.index') }}" title="ข่าวสารประชาสัมพันธ์ (News & Announcements)" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl bg-gradient-to-r from-[#5A6B47] to-[#465337] text-white shadow-md shadow-[#1B271C]/30 border border-[#7B8D65]/30">
                    <span class="flex items-center gap-3">
                        <i data-lucide="newspaper" class="w-4 h-4 text-[#EAE5D9] shrink-0"></i>
                        <div class="sidebar-text whitespace-nowrap">
                            <div class="leading-tight font-semibold">ข่าวสารประชาสัมพันธ์</div>
                            <div class="text-[10px] text-[#D5CEBC]/80 font-mono">News & Announcements</div>
                        </div>
                    </span>
                    <span class="sidebar-text w-2 h-2 rounded-full bg-[#A3B88C] animate-pulse shrink-0"></span>
                </a>
            @else
                <a href="{{ route('admin.news.index') }}" title="ข่าวสารประชาสัมพันธ์ (News & Announcements)" class="flex items-center px-3.5 py-2.5 rounded-xl text-[#B8B1A2] hover:text-white hover:bg-[#2C3E2D] transition gap-3">
                    <i data-lucide="newspaper" class="w-4 h-4 text-[#A3B88C] shrink-0"></i>
                    <div class="sidebar-text whitespace-nowrap">
                        <div class="leading-tight">ข่าวสารประชาสัมพันธ์</div>
                        <div class="text-[10px] text-[#8C9B80] font-mono">News & Announcements</div>
                    </div>
                </a>
            @endif

            @php
                $userRole = session('admin_user.role', '');
                $canManageUsers = in_array($userRole, ['SUPER_ADMIN', 'CENTRAL_OFFICER']);
            @endphp

            <!-- 6. เมนูแม่: การตั้งค่าระบบ (Settings Group with Dropdown Submenus) -->
            <div class="rounded-xl overflow-hidden {{ $isSettingsActive ? 'bg-[#1C281D] border border-[#2C3E2D]' : '' }}">
                <button type="button" 
                    title="การตั้งค่าระบบ (System Settings)"
                    onclick="toggleSubmenu('submenu-settings', 'chevron-settings')" 
                    class="w-full flex items-center justify-between px-3.5 py-2.5 rounded-xl transition gap-3 {{ $isSettingsActive ? 'text-white font-semibold' : 'text-[#B8B1A2] hover:text-white hover:bg-[#2C3E2D]' }}">
                    <span class="flex items-center gap-3">
                        <i data-lucide="settings" class="w-4 h-4 text-[#A3B88C] shrink-0"></i>
                        <span class="sidebar-text text-left whitespace-nowrap">
                            <div class="leading-tight">การตั้งค่าระบบ</div>
                            <div class="text-[10px] text-[#8C9B80] font-mono font-normal">System Settings</div>
                        </span>
                    </span>
                    <i id="chevron-settings" data-lucide="chevron-down" class="sidebar-text w-4 h-4 text-[#8C9B80] transition-transform duration-200 {{ $isSettingsActive ? 'rotate-180 text-white' : '' }}"></i>
                </button>

                <!-- รายการเมนูย่อยของกลุ่ม การตั้งค่า -->
                <div id="submenu-settings" class="space-y-1 px-2.5 pb-2.5 pt-1 border-t border-[#263727] {{ $isSettingsActive ? '' : 'hidden' }}">
                    
                    <!-- เมนูย่อย 1: รายชื่อส่วนงานภายใน มจร และรหัสย่อจังหวัด -->
                    <a href="{{ route('admin.org_units.index') }}" title="รายชื่อส่วนงานภายใน มจร" class="flex items-center px-3 py-2 rounded-lg text-xs transition gap-2.5 {{ $currentRoute === 'admin.org_units.index' ? 'bg-[#5A6B47] text-white font-medium shadow-sm' : 'text-[#A8A190] hover:text-white hover:bg-[#2C3E2D]/80' }}">
                        <i data-lucide="network" class="w-3.5 h-3.5 shrink-0 {{ $currentRoute === 'admin.org_units.index' ? 'text-white' : 'text-[#8C9B80]' }}"></i>
                        <span class="sidebar-text whitespace-nowrap">รายชื่อส่วนงานภายใน มจร</span>
                    </a>

                    @if ($canManageUsers)
                        <!-- เมนูย่อย 2: จัดการผู้ใช้งานและกำหนดสิทธิ์ -->
                        <a href="{{ route('admin.users.index') }}" title="ผู้ใช้งานและกำหนดสิทธิ์" class="flex items-center px-3 py-2 rounded-lg text-xs transition gap-2.5 {{ $currentRoute === 'admin.users.index' ? 'bg-[#5A6B47] text-white font-medium shadow-sm' : 'text-[#A8A190] hover:text-white hover:bg-[#2C3E2D]/80' }}">
                            <i data-lucide="shield-alert" class="w-3.5 h-3.5 shrink-0 {{ $currentRoute === 'admin.users.index' ? 'text-white' : 'text-[#8C9B80]' }}"></i>
                            <span class="sidebar-text whitespace-nowrap">ผู้ใช้งานและกำหนดสิทธิ์</span>
                        </a>
                    @endif

                    <!-- เมนูย่อย 3: ตั้งค่าระบบสำหรับติดต่อสอบถาม -->
                    <a href="{{ route('admin.contact.settings') }}" title="ตั้งค่าระบบติดต่อสอบถาม" class="flex items-center px-3 py-2 rounded-lg text-xs transition gap-2.5 {{ $currentRoute === 'admin.contact.settings' ? 'bg-[#5A6B47] text-white font-medium shadow-sm' : 'text-[#A8A190] hover:text-white hover:bg-[#2C3E2D]/80' }}">
                        <i data-lucide="phone-call" class="w-3.5 h-3.5 shrink-0 {{ $currentRoute === 'admin.contact.settings' ? 'text-white' : 'text-[#8C9B80]' }}"></i>
                        <span class="sidebar-text whitespace-nowrap">ตั้งค่าระบบติดต่อสอบถาม</span>
                    </a>

                </div>
            </div>

            <div class="sidebar-text pt-3 px-3 py-1.5 text-[10px] font-bold text-[#7E8B73] uppercase tracking-widest font-mono">พอร์ทัลภายนอก</div>
            
            <a href="{{ route('home') }}" target="_blank" title="หน้าพอร์ทัลหลัก" class="flex items-center px-3.5 py-2.5 rounded-xl text-[#B8B1A2] hover:text-white hover:bg-[#2C3E2D] transition gap-3">
                <i data-lucide="globe" class="w-4 h-4 text-[#A3B88C] shrink-0"></i>
                <div class="sidebar-text whitespace-nowrap">
                    <div class="leading-tight">หน้าพอร์ทัลหลัก</div>
                    <div class="text-[10px] text-[#8C9B80] font-mono">Portal Main</div>
                </div>
            </a>
        </nav>
    </div>

    <!-- User Profile & Logout (Fixed Bottom) -->
    <div class="p-3 md:p-4 border-t border-[#2C3E2D] bg-[#1E2B1F]/90 shrink-0">
        <div class="flex items-center justify-between mb-3 px-1">
            <div class="flex items-center space-x-2.5 overflow-hidden">
                <div class="w-8 h-8 rounded-lg bg-[#5A6B47] text-white flex items-center justify-center font-bold text-xs font-heading shrink-0">
                    {{ mb_substr(session('admin_user.name', 'Admin'), 0, 1) }}
                </div>
                <div class="sidebar-text transition-opacity duration-200 overflow-hidden whitespace-nowrap">
                    <div class="text-xs font-bold text-stone-200 truncate">{{ session('admin_user.name', 'ผู้ดูแลระบบ') }}</div>
                    <div class="text-[10px] text-[#A3B88C] font-mono truncate">
                        @php
                            $role = session('admin_user.role', '');
                        @endphp
                        @if ($role === 'SUPER_ADMIN')
                            Super Administrator
                        @elseif ($role === 'CENTRAL_OFFICER')
                            เจ้าหน้าที่ส่วนกลาง
                        @elseif ($role === 'EXECUTIVE')
                            ผู้บริหาร (Executive)
                        @else
                            เจ้าหน้าที่ประจำวิทยาเขต
                        @endif
                    </div>
                </div>
            </div>
            <span class="sidebar-text w-2.5 h-2.5 rounded-full bg-[#5A6B47] ring-4 ring-[#5A6B47]/20 shrink-0"></span>
        </div>
        <a href="{{ route('logout') }}" title="ออกจากระบบ" class="w-full flex items-center justify-center gap-2 px-3 py-2 rounded-lg bg-[#2F1F1D] text-[#E08A70] hover:bg-[#3D2522] hover:text-[#F3A58E] text-xs font-medium transition border border-[#C86D51]/20">
            <i data-lucide="log-out" class="w-3.5 h-3.5 shrink-0"></i>
            <span class="sidebar-text whitespace-nowrap">ออกจากระบบ</span>
        </a>
    </div>
</aside>

<!-- Script & Styles สำหรับคลิกย่อ/ขยายเมนูย่อย Dropdown & Sidebar Collapsing -->
<style>
    .custom-scrollbar::-webkit-scrollbar {
        width: 4px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: transparent;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: rgba(123, 141, 101, 0.3);
        border-radius: 4px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: rgba(123, 141, 101, 0.6);
    }

    /* Collapsed Sidebar Styles on Desktop */
    @media (min-width: 768px) {
        #admin-sidebar.sidebar-collapsed {
            width: 4.75rem !important; /* ~76px */
        }
        #admin-sidebar.sidebar-collapsed .sidebar-text {
            display: none !important;
        }
        #admin-sidebar.sidebar-collapsed nav a,
        #admin-sidebar.sidebar-collapsed nav button {
            justify-content: center !important;
            padding-left: 0.75rem !important;
            padding-right: 0.75rem !important;
        }
        #admin-sidebar.sidebar-collapsed nav a span.flex,
        #admin-sidebar.sidebar-collapsed nav button span.flex {
            justify-content: center !important;
        }
        #admin-sidebar.sidebar-collapsed #submenu-ug,
        #admin-sidebar.sidebar-collapsed #submenu-settings {
            display: none !important;
        }
        #admin-sidebar.sidebar-collapsed .border-b,
        #admin-sidebar.sidebar-collapsed .border-t {
            justify-content: center !important;
        }
        #admin-sidebar.sidebar-collapsed #sidebar-toggle-btn {
            margin: 0 auto;
        }
    }
</style>

<script>
    // ตรวจสอบและตั้งค่าสถานะ Sidebar Collapse จาก localStorage เมื่อโหลดหน้า
    (function initSidebarState() {
        const isCollapsed = localStorage.getItem('mcuvms_sidebar_collapsed') === 'true';
        if (isCollapsed) {
            const sidebar = document.getElementById('admin-sidebar');
            if (sidebar) {
                sidebar.classList.add('sidebar-collapsed');
            }
        }
    })();

    document.addEventListener('DOMContentLoaded', function() {
        updateToggleIcon();
    });

    function toggleSidebarCollapse() {
        const sidebar = document.getElementById('admin-sidebar');
        if (!sidebar) return;

        sidebar.classList.toggle('sidebar-collapsed');
        const isCollapsed = sidebar.classList.contains('sidebar-collapsed');
        localStorage.setItem('mcuvms_sidebar_collapsed', isCollapsed ? 'true' : 'false');
        updateToggleIcon();
    }

    function updateToggleIcon() {
        const sidebar = document.getElementById('admin-sidebar');
        const toggleBtn = document.getElementById('sidebar-toggle-btn');
        if (!sidebar || !toggleBtn) return;

        const isCollapsed = sidebar.classList.contains('sidebar-collapsed');
        const iconName = isCollapsed ? 'panel-left-open' : 'panel-left-close';
        toggleBtn.innerHTML = `<i data-lucide="${iconName}" class="w-4 h-4"></i>`;
        toggleBtn.setAttribute('title', isCollapsed ? 'ขยายแถบเมนู (Expand Sidebar)' : 'ย่อแถบเมนู (Collapse Sidebar)');
        if (window.lucide && typeof window.lucide.createIcons === 'function') {
            window.lucide.createIcons();
        }
    }

    function toggleSubmenu(menuId, chevronId) {
        const sidebar = document.getElementById('admin-sidebar');
        // หาก sidebar ย่ออยู่แล้วคลิกเมนู ให้ขยาย sidebar อัตโนมัติเพื่อให้เห็นเมนูย่อย
        if (sidebar && sidebar.classList.contains('sidebar-collapsed')) {
            toggleSidebarCollapse();
        }

        const menu = document.getElementById(menuId);
        const chevron = document.getElementById(chevronId);
        if (menu) {
            menu.classList.toggle('hidden');
        }
        if (chevron) {
            chevron.classList.toggle('rotate-180');
        }
    }
</script>
