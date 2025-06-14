<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Mentor\DashboardController as MentorDashboardController;
use App\Http\Controllers\Student\DashboardController as StudentDashboardController;
use App\Http\Controllers\Student\ProfileStudentController;
use App\Http\Controllers\Mentor\ProfileMentorController;
use App\Http\Controllers\Admin\SubjectController; 
use App\Http\Controllers\Student\SubjectController as StudentSubjectController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Student\NewsController as StudentNewsController;
use App\Http\Controllers\Admin\SessionController as AdminSessionController;
use App\Http\Controllers\Student\SessionController as StudentSessionController;
use App\Http\Controllers\Mentor\SessionController as MentorSessionController;
use App\Http\Controllers\Student\PaymentController;
use App\Http\Controllers\Student\HistoryController as StudentHistoryController;
use App\Http\Controllers\Mentor\HistoryController as MentorHistoryController;

// ===== MIDTRANS WEBHOOK (TANPA AUTH) =====
Route::post('/midtrans/notification', [PaymentController::class, 'handleNotification'])->name('midtrans.notification');

// ===== PUBLIC ROUTES =====
Route::get('/', function () {
    return view('welcome');
})->name('home');

// ===== AUTH ROUTES =====
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::post('/register', [RegisterController::class, 'register'])->name('register');

// ===== ADMIN ROUTES =====
Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    
    Route::resource('users', UserController::class)->names([
        'index' => 'admin.users.index',
        'create' => 'admin.users.create',
        'store' => 'admin.users.store',
        'show' => 'admin.users.show',
        'edit' => 'admin.users.edit',
        'update' => 'admin.users.update',
        'destroy' => 'admin.users.destroy',
    ]);

    Route::resource('subjects', SubjectController::class)->names([
        'index' => 'admin.subjects.index',
        'create' => 'admin.subjects.create',
        'store' => 'admin.subjects.store',
        'show' => 'admin.subjects.show',
        'edit' => 'admin.subjects.edit',
        'update' => 'admin.subjects.update',
        'destroy' => 'admin.subjects.destroy',
    ]);
    
    Route::patch('subjects/{subject}/toggle-active', [SubjectController::class, 'toggleActive'])->name('admin.subjects.toggle-active');
    Route::get('subjects/{subject}/mentors', [SubjectController::class, 'manageMentors'])->name('admin.subjects.mentors');
    Route::post('subjects/{subject}/mentors', [SubjectController::class, 'addMentor'])->name('admin.subjects.add-mentor');
    Route::delete('subjects/{subject}/mentors/{mentor}', [SubjectController::class, 'removeMentor'])->name('admin.subjects.remove-mentor');

    Route::prefix('sessions')->name('admin.sessions.')->group(function () {
        Route::get('/', [AdminSessionController::class, 'index'])->name('index');
        Route::get('/create', [AdminSessionController::class, 'create'])->name('create');
        Route::post('/', [AdminSessionController::class, 'store'])->name('store');
        Route::get('/export', [AdminSessionController::class, 'export'])->name('export');
        Route::get('/{session}', [AdminSessionController::class, 'show'])->name('show');
        Route::get('/{session}/edit', [AdminSessionController::class, 'edit'])->name('edit');
        Route::put('/{session}', [AdminSessionController::class, 'update'])->name('update');
        Route::patch('/{session}/status', [AdminSessionController::class, 'updateStatus'])->name('update-status');
        Route::patch('/{session}/reschedule', [AdminSessionController::class, 'reschedule'])->name('reschedule');
        Route::delete('/{session}', [AdminSessionController::class, 'destroy'])->name('destroy');
        Route::post('/bulk-update', [AdminSessionController::class, 'bulkUpdate'])->name('bulk-update');
    });
    
    Route::prefix('payments')->name('admin.payments.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\PaymentController::class, 'index'])->name('index');
        Route::get('/{payment}', [\App\Http\Controllers\Admin\PaymentController::class, 'show'])->name('show');
        Route::patch('/{payment}/status', [\App\Http\Controllers\Admin\PaymentController::class, 'updateStatus'])->name('update-status');
        Route::post('/{payment}/refund', [\App\Http\Controllers\Admin\PaymentController::class, 'refund'])->name('refund');
        Route::post('/bulk-update', [\App\Http\Controllers\Admin\PaymentController::class, 'bulkUpdate'])->name('bulk-update');
        Route::get('/export/csv', [\App\Http\Controllers\Admin\PaymentController::class, 'export'])->name('export');
    });

    Route::resource('news', NewsController::class)->names([
        'index' => 'admin.news.index',
        'create' => 'admin.news.create', 
        'store' => 'admin.news.store',
        'show' => 'admin.news.show',
        'edit' => 'admin.news.edit',
        'update' => 'admin.news.update',
        'destroy' => 'admin.news.destroy',
    ]);
    
    Route::patch('news/{news}/toggle-featured', [NewsController::class, 'toggleFeatured'])->name('admin.news.toggle-featured');
    Route::post('news/bulk-action', [NewsController::class, 'bulkAction'])->name('admin.news.bulk-action');
    
    Route::get('/mentors', function () {
        return view('admin.mentors.index');
    })->name('admin.mentors.index');
    
    Route::get('/students', function () {
        return view('admin.students.index');
    })->name('admin.students.index');
});

// ===== MENTOR ROUTES =====
Route::prefix('mentor')->middleware(['auth'])->group(function () {
    Route::get('/dashboard', [MentorDashboardController::class, 'index'])->name('mentor.dashboard_mentor');
    
    Route::get('/profile', [ProfileMentorController::class, 'index'])->name('mentor.profile');
    Route::put('/profile/update', [ProfileMentorController::class, 'update'])->name('mentor.profile.update');
    Route::get('/change-password', [ProfileMentorController::class, 'showChangePasswordForm'])->name('mentor.password.form');
    Route::post('/change-password', [ProfileMentorController::class, 'changePassword'])->name('mentor.password.update');

    Route::prefix('sessions')->name('mentor.sessions.')->group(function () {
        Route::get('/', [MentorSessionController::class, 'index'])->name('index');
        Route::get('/{session}', [MentorSessionController::class, 'show'])->name('show');
        Route::patch('/{session}/cancel', [MentorSessionController::class, 'cancel'])->name('cancel');
        Route::post('/{session}/reschedule', [MentorSessionController::class, 'reschedule'])->name('reschedule');
    });
    
    Route::get('/history', [MentorHistoryController::class, 'index'])->name('mentor.history');

    // SESSION DETAIL & ACTIONS (TAMBAHAN BARU)
    Route::get('/session/{session}', [MentorSessionController::class, 'show'])->name('mentor.session.show');
    Route::get('/session/{session}/complete', [MentorSessionController::class, 'complete'])->name('mentor.session.complete');
    Route::post('/session/{session}/complete', [MentorSessionController::class, 'markCompleted'])->name('mentor.session.mark-completed');
    
    Route::get('/subjects', function () {
        return view('mentor.subjects');
    })->name('mentor.subjects');
    
    Route::get('/reviews', function () {
        return view('mentor.reviews');
    })->name('mentor.reviews');
});

// ===== STUDENT ROUTES ===== 
Route::prefix('student')->middleware(['auth'])->name('student.')->group(function () {
    Route::get('/dashboard', [StudentDashboardController::class, 'index'])->name('dashboard');
    
    Route::get('/profile', [ProfileStudentController::class, 'index'])->name('profile');
    Route::put('/profile/update', [ProfileStudentController::class, 'update'])->name('profile.update');
    Route::get('/change-password', [ProfileStudentController::class, 'showChangePasswordForm'])->name('password.form');
    Route::post('/change-password', [ProfileStudentController::class, 'changePassword'])->name('password.update');
    
    Route::get('/menu', function () {
        return view('student.menu');
    })->name('menu');

    Route::get('/subjects', [StudentSubjectController::class, 'index'])->name('subjects');
    
    Route::get('/find', [StudentSessionController::class, 'find'])->name('find');

    // SESSION MANAGEMENT
    Route::prefix('sessions')->name('sessions.')->group(function () {
        // Main pages
        Route::get('/', [StudentSessionController::class, 'index'])->name('index');
        Route::get('/search', [StudentSessionController::class, 'search'])->name('search');
        Route::get('/browse', [StudentSessionController::class, 'browse'])->name('browse');
        Route::get('/subjects', [StudentSessionController::class, 'subjects'])->name('subjects');
        
        // Session detail and booking
        Route::get('/{session}', [StudentSessionController::class, 'show'])->name('show');
        Route::get('/{session}/booking', [StudentSessionController::class, 'booking'])->name('booking');
        Route::post('/{session}/book', [StudentSessionController::class, 'bookSession'])->name('book');
        
        // NEW: Booking success page
        Route::get('/{session}/booking-success', [StudentSessionController::class, 'bookingSuccess'])->name('booking-success');
        
        // Session actions
        Route::post('/{session}/feedback', [StudentSessionController::class, 'submitFeedback'])->name('feedback');
        Route::patch('/{session}/cancel', [StudentSessionController::class, 'cancelSession'])->name('cancel');
        Route::post('/{session}/request-reschedule', [StudentSessionController::class, 'requestReschedule'])->name('request-reschedule');
        Route::get('/{session}/join-meeting', [StudentSessionController::class, 'joinMeeting'])->name('join-meeting');
    });
    
    // HISTORY ROUTES
    Route::prefix('history')->name('history.')->group(function () {
        Route::get('/', [StudentHistoryController::class, 'index'])->name('index');
        Route::get('/export', [StudentHistoryController::class, 'export'])->name('export');
        Route::get('/statistik', [StudentHistoryController::class, 'getStatistik'])->name('statistik');
        Route::get('/{session}', [StudentHistoryController::class, 'show'])->name('show');
        Route::post('/{session}/review', [StudentHistoryController::class, 'review'])->name('review');
        Route::post('/{session}/cancel', [StudentHistoryController::class, 'cancel'])->name('cancel');
        Route::get('/{session}/details', [StudentHistoryController::class, 'getDetailSesi'])->name('details');
    });

    // NEWS ROUTES
    Route::prefix('news')->name('news.')->group(function () {
        Route::get('/', [StudentNewsController::class, 'index'])->name('index');
        Route::get('/search', [StudentNewsController::class, 'search'])->name('search');
        Route::get('/{id}', [StudentNewsController::class, 'show'])->name('show');
    });
    
    // Route alternatif untuk akses langsung
    Route::get('/riwayat', [StudentHistoryController::class, 'index'])->name('riwayat');
    Route::get('/sesi-saya', [StudentSessionController::class, 'mySessions'])->name('sesi-saya');
});

// ===== FALLBACK ROUTE =====
Route::fallback(function () {
    return view('errors.404');
});