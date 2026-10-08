<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UndergraduateController;
use App\Http\Controllers\GraduateController;
use App\Http\Controllers\CommunityController;
use App\Http\Controllers\AdminController;

// Public Portal Routes
Route::get('/', [HomeController::class, 'index'])->name('home');

// Module 1: Undergraduate
Route::get('/ug_register.php', [UndergraduateController::class, 'create'])->name('ug.register');
Route::get('/ug/register', [UndergraduateController::class, 'create']);
Route::get('/ug_check.php', [UndergraduateController::class, 'checkStatus'])->name('ug.check');
Route::get('/ug/check', [UndergraduateController::class, 'checkStatus']);
Route::get('/ug/lookup-student', [UndergraduateController::class, 'lookupStudent'])->name('ug.lookupStudent');
Route::post('/ug/register', [UndergraduateController::class, 'store'])->name('ug.store');
Route::get('/ug/certificate/{reg_no}', [UndergraduateController::class, 'certificate'])->name('ug.certificate');

// Module 2: Graduate Studies
Route::get('/grad.php', [GraduateController::class, 'requestForm'])->name('grad.index');
Route::get('/grad', [GraduateController::class, 'requestForm']);
Route::get('/grad/request', [GraduateController::class, 'requestForm'])->name('grad.request');
Route::get('/edoc/register.php', [GraduateController::class, 'requestForm']);
Route::get('/grad_progress.php', [GraduateController::class, 'index'])->name('grad.progress');
Route::get('/grad/progress', [GraduateController::class, 'index']);
Route::post('/grad/request', [GraduateController::class, 'storeRequest'])->name('grad.request.store');
Route::post('/grad/final-submit', [GraduateController::class, 'finalSubmit'])->name('grad.finalSubmit');
Route::get('/grad/certificate/{code}', [GraduateController::class, 'certificate'])->name('grad.certificate');

// Certificate Public Verification (Scan QR Engine)
Route::get('/certificate/verify', [HomeController::class, 'verifyCertificate'])->name('cert.verify');
Route::get('/verify.php', [HomeController::class, 'verifyCertificate']);


// Module 3: Public Community
Route::get('/public_register.php', [CommunityController::class, 'create'])->name('public.register');
Route::get('/public/register', [CommunityController::class, 'create']);
Route::get('/public_check.php', [CommunityController::class, 'checkStatus'])->name('public.check');
Route::get('/public/check', [CommunityController::class, 'checkStatus']);
Route::post('/public/register', [CommunityController::class, 'store'])->name('public.store');
Route::post('/public/registration/update/{id}', [CommunityController::class, 'updateRegistration'])->name('public.update');
Route::post('/public_update.php/{id}', [CommunityController::class, 'updateRegistration']);

// Auth Routes
Route::get('/login.php', [AdminController::class, 'showLogin'])->name('login');
Route::get('/login', [AdminController::class, 'showLogin']);
Route::post('/login', [AdminController::class, 'login'])->name('login.post');
Route::post('/login.php', [AdminController::class, 'login']);
Route::get('/logout.php', [AdminController::class, 'logout'])->name('logout');
Route::get('/logout', [AdminController::class, 'logout']);

// News Routes (Portal)
Route::get('/news.php', [HomeController::class, 'newsIndex'])->name('news.index');
Route::get('/news', [HomeController::class, 'newsIndex']);
Route::get('/news_detail.php', [HomeController::class, 'newsDetail'])->name('news.detail');
Route::get('/news/{id}', [HomeController::class, 'newsDetail'])->name('news.detail.clean');

// Contact Us Routes (Portal)
Route::get('/contact.php', [HomeController::class, 'contact'])->name('contact');
Route::get('/contact', [HomeController::class, 'contact']);
Route::post('/contact.php', [HomeController::class, 'contactSubmit'])->name('contact.submit');
Route::post('/contact', [HomeController::class, 'contactSubmit']);

// Donation Routes (Portal)
Route::get('/donation.php', [HomeController::class, 'donation'])->name('donation');
Route::get('/donation', [HomeController::class, 'donation']);
Route::post('/donation.php', [HomeController::class, 'donationSubmit'])->name('donation.submit');
Route::post('/donation', [HomeController::class, 'donationSubmit']);

// Language Switch Route
Route::get('/lang/{locale}', function ($locale) {
    if (in_array($locale, ['th', 'en'])) {
        session(['locale' => $locale]);
    }
    return redirect()->back();
})->name('lang.switch');

Route::get('/lang.php', function (\Illuminate\Http\Request $request) {
    $locale = $request->query('locale', 'th');
    if (in_array($locale, ['th', 'en'])) {
        session(['locale' => $locale]);
    }
    return redirect()->back();
})->name('lang.switch.compat');

// Admin Console Routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard.php', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/dashboard', [AdminController::class, 'dashboard']);
    
    Route::match(['get', 'post'], '/ug_batches.php', [AdminController::class, 'ugBatches'])->name('ug.batches');
    Route::get('/ug/batches', [AdminController::class, 'ugBatches']);
    Route::post('/ug/batches', [AdminController::class, 'ugBatchStore'])->name('ug.batches.store');
    Route::post('/ug/batches/update/{id}', [AdminController::class, 'ugBatchUpdate'])->name('ug.batches.update');
    Route::get('/ug/batches/status/{id}/{status}', [AdminController::class, 'ugBatchStatus'])->name('ug.batches.status');
    Route::get('/ug/batches/delete/{id}', [AdminController::class, 'ugBatchDelete'])->name('ug.batches.delete');

    // Module 1: Student Master Data & Import
    Route::get('/ug_import.php', [AdminController::class, 'ugImport'])->name('ug.import');
    Route::get('/ug/import', [AdminController::class, 'ugImport']);
    Route::post('/ug/import-csv', [AdminController::class, 'ugImportCsv'])->name('ug.import.csv');
    Route::get('/ug/import/template', [AdminController::class, 'ugDownloadTemplate'])->name('ug.import.template');

    Route::match(['get', 'post'], '/ug_students.php', [AdminController::class, 'ugStudents'])->name('ug.students');
    Route::get('/ug/students', [AdminController::class, 'ugStudents']);
    Route::post('/ug/students/update/{id}', [AdminController::class, 'ugStudentUpdate'])->name('ug.students.update');
    Route::get('/ug/students/delete/{id}', [AdminController::class, 'ugStudentDelete'])->name('ug.students.delete');
    Route::get('/ug/student/approve/{id}', [AdminController::class, 'ugStudentApprove'])->name('ug.student.approve');
    Route::post('/ug/student/reject/{id}', [AdminController::class, 'ugStudentReject'])->name('ug.student.reject');
    Route::get('/ug/checkin/{id}', [AdminController::class, 'ugCheckin'])->name('ug.checkin');
    Route::get('/ug/complete/{id}', [AdminController::class, 'ugComplete'])->name('ug.complete');
    Route::post('/ug/students/bulk-action', [AdminController::class, 'ugStudentsBulkAction'])->name('ug.students.bulk');

    // Module 1: QR Scanner, Print Sheet & Export
    Route::get('/ug_scanner.php', [AdminController::class, 'ugScanner'])->name('ug.scanner');
    Route::get('/ug/scanner', [AdminController::class, 'ugScanner']);
    Route::post('/ug/scanner/verify', [AdminController::class, 'ugScannerVerify'])->name('ug.scanner.verify');

    Route::get('/ug_attendance.php', [AdminController::class, 'ugAttendancePrint'])->name('ug.attendance');
    Route::get('/ug/attendance', [AdminController::class, 'ugAttendancePrint']);

    // Module 1: รายงานสถิติการปฏิบัติธรรม ป.ตรี (SAR & Analytics)
    Route::get('/ug_sar.php', [AdminController::class, 'ugSar'])->name('ug.sar');
    Route::get('/ug/sar', [AdminController::class, 'ugSar']);

    Route::get('/ug/export', [AdminController::class, 'ugExportRegistrar'])->name('ug.export');

    Route::get('/grad_sar.php', [AdminController::class, 'gradSar'])->name('grad.sar');
    Route::get('/grad/sar', [AdminController::class, 'gradSar']);
    Route::match(['get', 'post'], '/grad_approvals.php', [AdminController::class, 'gradApprovals'])->name('grad.approvals');
    Route::get('/grad/approvals', [AdminController::class, 'gradApprovals']);
    Route::post('/grad/approve', [AdminController::class, 'gradApprove'])->name('grad.approve');
    Route::post('/grad/reject', [AdminController::class, 'gradReject'])->name('grad.reject');
    Route::post('/grad/approvals/bulk-action', [AdminController::class, 'gradApprovalsBulkAction'])->name('grad.approvals.bulk');
    Route::post('/grad/student/update/{id}', [AdminController::class, 'gradStudentUpdate'])->name('grad.student.update');
    Route::get('/grad/student/delete/{id}', [AdminController::class, 'gradStudentDelete'])->name('grad.student.delete');
    Route::post('/grad/upload-response', [AdminController::class, 'gradUploadResponse'])->name('grad.uploadResponse');
    Route::post('/grad/toggle-edoc', [AdminController::class, 'gradToggleEdoc'])->name('grad.toggleEdoc');
    Route::get('/grad/export', [AdminController::class, 'gradExportExcel'])->name('grad.export');

    // Module 3: Public Community & Meditation Courses
    Route::match(['get', 'post'], '/public_events.php', [AdminController::class, 'publicEvents'])->name('public.events');
    Route::get('/public/events', [AdminController::class, 'publicEvents']);
    Route::post('/public/events', [AdminController::class, 'publicEventStore'])->name('public.events.store');
    Route::post('/public/events/update/{id}', [AdminController::class, 'publicEventUpdate'])->name('public.events.update');
    Route::get('/public/events/status/{id}/{status}', [AdminController::class, 'publicEventStatus'])->name('public.events.status');
    Route::get('/public/events/delete/{id}', [AdminController::class, 'publicEventDelete'])->name('public.events.delete');

    Route::match(['get', 'post'], '/public_students.php', [AdminController::class, 'publicStudents'])->name('public.students');
    Route::get('/public/students', [AdminController::class, 'publicStudents']);
    Route::get('/public/student/approve/{id}', [AdminController::class, 'publicStudentApprove'])->name('public.student.approve');
    Route::post('/public/student/reject/{id}', [AdminController::class, 'publicStudentReject'])->name('public.student.reject');
    Route::get('/public/export', [AdminController::class, 'publicExport'])->name('public.export');

    Route::match(['get', 'post'], '/public_sar.php', [AdminController::class, 'publicSar'])->name('public.sar');
    Route::get('/public/sar', [AdminController::class, 'publicSar']);
    Route::post('/public/sar/bulk-action', [AdminController::class, 'publicSarBulkAction'])->name('public.sar.bulk');
    Route::post('/public/sar/update/{id}', [AdminController::class, 'publicSarUpdate'])->name('public.sar.update');
    Route::get('/public/sar/delete/{id}', [AdminController::class, 'publicSarDelete'])->name('public.sar.delete');

    // News Management
    Route::get('/news.php', [AdminController::class, 'newsIndex'])->name('news.index');
    Route::get('/news', [AdminController::class, 'newsIndex']);
    Route::post('/news.php', [AdminController::class, 'newsStore']);
    Route::post('/news', [AdminController::class, 'newsStore'])->name('news.store');
    Route::post('/news/update/{id}', [AdminController::class, 'newsUpdate'])->name('news.update');
    Route::post('/news_update.php/{id}', [AdminController::class, 'newsUpdate']);
    Route::get('/news/delete/{id}', [AdminController::class, 'newsDelete'])->name('news.delete');
    Route::get('/news_delete.php/{id}', [AdminController::class, 'newsDelete']);
    Route::get('/news/toggle-pin/{id}', [AdminController::class, 'newsTogglePin'])->name('news.togglePin');
    Route::get('/news_pin.php/{id}', [AdminController::class, 'newsTogglePin']);

    // Users & Roles Management (Rule Matrix: ผู้ดูแลระบบส่วนกลาง)
    Route::get('/users.php', [AdminController::class, 'usersIndex'])->name('users.index');
    Route::get('/users', [AdminController::class, 'usersIndex']);
    Route::post('/users', [AdminController::class, 'userStore'])->name('users.store');
    Route::post('/users/update/{id}', [AdminController::class, 'userUpdate'])->name('users.update');
    Route::get('/users/toggle-status/{id}', [AdminController::class, 'userToggleStatus'])->name('users.toggleStatus');
    Route::get('/users/delete/{id}', [AdminController::class, 'userDelete'])->name('users.delete');

    // Executive Analytics & Comparative Dashboard (Rule Matrix: ผู้บริหาร)
    Route::get('/executive_analytics.php', [AdminController::class, 'executiveAnalytics'])->name('executive.analytics');
    Route::get('/executive/analytics', [AdminController::class, 'executiveAnalytics']);

    // System Settings Group (กลุ่มการตั้งค่า)
    // 1. Organization Units (รายชื่อส่วนงานภายใน มจร)
    Route::get('/org_units.php', [AdminController::class, 'orgUnitsIndex'])->name('org_units.index');
    Route::get('/org-units', [AdminController::class, 'orgUnitsIndex']);

    // 2. Site Settings: ติดต่อสอบถาม (Contact Settings & Inquiries)
    Route::get('/contact_settings.php', [AdminController::class, 'contactSettings'])->name('contact.settings');
    Route::get('/contact-settings', [AdminController::class, 'contactSettings']);
    Route::post('/contact-settings', [AdminController::class, 'contactSettingsUpdate'])->name('contact.settings.update');
    Route::get('/contact-inquiries/status/{id}/{status}', [AdminController::class, 'contactInquiryStatus'])->name('contact.inquiries.status');
    Route::get('/contact-inquiries/delete/{id}', [AdminController::class, 'contactInquiryDelete'])->name('contact.inquiries.delete');

    // 3. Donation Management & Analytics: จัดการการบริจาคและสถิติ
    Route::get('/donations.php', [AdminController::class, 'donationsIndex'])->name('donations.index');
    Route::get('/donations', [AdminController::class, 'donationsIndex']);
    Route::post('/donations/status/{id}', [AdminController::class, 'donationStatus'])->name('donations.status');
    Route::post('/donations/update/{id}', [AdminController::class, 'donationUpdate'])->name('donations.update');
    Route::get('/donations/delete/{id}', [AdminController::class, 'donationDelete'])->name('donations.delete');
    Route::post('/donations/settings', [AdminController::class, 'donationSettingsUpdate'])->name('donations.settings');
    Route::get('/donations/export', [AdminController::class, 'donationExport'])->name('donations.export');
});

