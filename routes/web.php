<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PpdbController;
use App\Http\Controllers\ContactController;

// Admin Controllers
use App\Http\Controllers\Admin\Auth\LoginController as AdminLoginController;
use App\Http\Controllers\Admin\Auth\ForgotPasswordController as AdminForgotPasswordController;
use App\Http\Controllers\Admin\Auth\ResetPasswordController as AdminResetPasswordController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\TeacherController;
use App\Http\Controllers\Admin\StaffController;
use App\Http\Controllers\Admin\ExtracurricularController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\GalleryCategoryController;
use App\Http\Controllers\Admin\AdminPpdbController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\AchievementController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Frontend Routes
Route::get('/', [HomeController::class, 'index'])->name('home');

// Profile Routes
Route::prefix('profil')->name('profile.')->group(function () {
    Route::get('/sekolah', [HomeController::class, 'profileSchool'])->name('school');
    Route::get('/guru', [HomeController::class, 'profileTeachers'])->name('teachers');
    Route::get('/staf', [HomeController::class, 'profileStaff'])->name('staff');
    Route::get('/berprestasi', [HomeController::class, 'profileAchievements'])->name('achievements');
    Route::get('/kepala-sekolah', [HomeController::class, 'profilePrincipal'])->name('principal');
    Route::get('/sejarah', [HomeController::class, 'profileHistory'])->name('history');
});

// Other Frontend Routes
Route::get('/ekskul', [HomeController::class, 'extracurriculars'])->name('extracurriculars');
Route::get('/kegiatan', [HomeController::class, 'events'])->name('events');
Route::get('/galeri', [HomeController::class, 'gallery'])->name('gallery');
Route::get('/berita', [HomeController::class, 'news'])->name('news');
Route::get('/berita/{slug}', [HomeController::class, 'newsDetail'])->name('news.detail');

Route::get('/kontak', [HomeController::class, 'contact'])->name('contact');
Route::post('/kontak/kirim', [ContactController::class, 'send'])->name('contact.send');

// Route untuk pesan kontak
Route::get('/pesan-kontak', [ContactController::class, 'index'])->name('admin.contact.messages');
Route::get('/pesan-kontak/{contactMessage}', [ContactController::class, 'show'])->name('admin.contact.show');
Route::delete('/pesan-kontak/{contactMessage}', [ContactController::class, 'destroy'])->name('admin.contact.destroy');


// PPDB Routes
Route::prefix('ppdb')->name('ppdb.')->group(function () {
    Route::get('/', [PpdbController::class, 'index'])->name('index');
    Route::get('/formulir', [PpdbController::class, 'form'])->name('form');
    Route::post('/formulir', [PpdbController::class, 'submitForm'])->name('submit_form');
    Route::get('/hasil-seleksi', [PpdbController::class, 'results'])->name('results');
    Route::post('/cek-hasil-seleksi', [PpdbController::class, 'checkResults'])->name('check_results');
    Route::get('/cetak-formulir', [PpdbController::class, 'printForm'])->name('print_form');
    Route::post('/cetak-dokumen-pdf', [PpdbController::class, 'generatePrintFormPdf'])->name('generate_print_form_pdf');
    Route::get('/download', [PpdbController::class, 'downloadResources'])->name('download');
});

// Admin Routes
Route::prefix('admin')->name('admin.')->group(function () {
    // Authentication
    Route::get('/login', [AdminLoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AdminLoginController::class, 'login']);
    Route::post('/logout', [AdminLoginController::class, 'logout'])->name('logout');

    // Password Reset
    Route::get('/password/reset', [AdminForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/password/email', [AdminForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('/password/reset/{token}', [AdminResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/password/reset', [AdminResetPasswordController::class, 'reset'])->name('password.update');

    // Authenticated Admin Routes
    Route::middleware(['auth', 'role:admin,superadmin'])->group(function () {
        // Dashboard
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        // Profile
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.update-password');

        // CRUD Resources
        Route::resource('news', NewsController::class);
        Route::patch('/news/{news}/toggle', [NewsController::class, 'toggle'])->name('news.toggle');
        Route::resource('teachers', TeacherController::class);
        Route::resource('staffs', StaffController::class);
        Route::resource('achievements', AchievementController::class);
        Route::resource('extracurriculars', ExtracurricularController::class);
        Route::resource('events', EventController::class);
        Route::resource('galleries', GalleryController::class);
        Route::resource('gallery-categories', GalleryCategoryController::class)->except(['show']);
        Route::resource('carousels', \App\Http\Controllers\Admin\CarouselController::class);

        // PPDB Settings
        Route::prefix('ppdb-settings')->name('ppdb-settings.')->group(function () {
            Route::get('/', [AdminPpdbController::class, 'index'])->name('index');
            Route::get('/edit', [AdminPpdbController::class, 'edit'])->name('edit');
            Route::put('/', [AdminPpdbController::class, 'update'])->name('update');
            Route::get('/schedule/edit', [AdminPpdbController::class, 'editSchedule'])->name('schedule.edit');
            Route::put('/schedule/update', [AdminPpdbController::class, 'updateSchedule'])->name('schedule.update');
        });

        // PPDB Applicants Management
        Route::prefix('ppdb-applicants')->name('ppdb-applicants.')->group(function () {
            Route::get('/', [AdminPpdbController::class, 'applicantsIndex'])->name('index');
            Route::get('/{applicant}', [AdminPpdbController::class, 'show'])->name('show');
            Route::patch('/{applicant}/status', [AdminPpdbController::class, 'updateStatus'])->name('updateStatus');
            Route::delete('/{applicant}', [AdminPpdbController::class, 'destroyApplicant'])->name('destroy'); 
        });

        // Settings
        Route::get('settings', [SettingController::class, 'edit'])->name('settings.edit');
        Route::put('settings', [SettingController::class, 'update'])->name('settings.update');
        Route::get('principal-settings', [SettingController::class, 'editPrincipal'])->name('principal.edit');
        Route::put('principal-settings', [SettingController::class, 'updatePrincipal'])->name('principal.update');

        // Contact Messages Management
        Route::prefix('contact-messages')->name('contact-messages.')->group(function () {
            Route::get('/pesan-kontak', [ContactController::class, 'index'])->name('admin.contact.messages');
            Route::get('/pesan-kontak/{contactMessage}', [ContactController::class, 'show'])->name('admin.contact.show');
            Route::delete('/pesan-kontak/{contactMessage}', [ContactController::class, 'destroy'])->name('admin.contact.destroy');
            Route::post('/{contactMessage}/mark-as-read', [ContactController::class, 'markAsRead'])->name('mark-as-read');
        });
    });
});
