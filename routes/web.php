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

// Public routes
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Auth routes
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::post('/register', [RegisterController::class, 'register'])->name('register');

// Admin routes
Route::prefix('admin')->middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    
    // User Management - Menggunakan resource controller
    Route::resource('users', UserController::class)->names([
        'index' => 'admin.users.index',
        'create' => 'admin.users.create',
        'store' => 'admin.users.store',
        'show' => 'admin.users.show',
        'edit' => 'admin.users.edit',
        'update' => 'admin.users.update',
        'destroy' => 'admin.users.destroy',
    ]);

    // Subject Management
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

     // News Management - Resource routes
    Route::resource('news', NewsController::class)->names([
        'index' => 'admin.news.index',
        'create' => 'admin.news.create', 
        'store' => 'admin.news.store',
        'show' => 'admin.news.show',
        'edit' => 'admin.news.edit',
        'update' => 'admin.news.update',
        'destroy' => 'admin.news.destroy',
    ]);
    
    // Additional News routes
    Route::patch('news/{news}/toggle-featured', [NewsController::class, 'toggleFeatured'])->name('admin.news.toggle-featured');
    Route::post('news/bulk-action', [NewsController::class, 'bulkAction'])->name('admin.news.bulk-action');
    
    // // Rute lainnya yang menggunakan closure
    // Route::get('/subjects', function () {
    //     return view('admin.subjects.index');
    // })->name('admin.subjects.index');
    
    Route::get('/mentors', function () {
        return view('admin.mentors.index');
    })->name('admin.mentors.index');
    
    Route::get('/students', function () {
        return view('admin.students.index');
    })->name('admin.students.index');
    
    Route::get('/sessions', function () {
        return view('admin.sessions.index');
    })->name('admin.sessions.index');

    Route::get('/payments', function () {
        return view('admin.payments.index');
    })->name('admin.payments.index');

});

// Mentor routes
Route::prefix('mentor')->middleware(['auth'])->group(function () {
    Route::get('/dashboard', [MentorDashboardController::class, 'index'])->name('mentor.dashboard_mentor');
    
    // Profile Mentor routes
    Route::get('/profile', [ProfileMentorController::class, 'index'])->name('mentor.profile');
    Route::put('/profile/update', [ProfileMentorController::class, 'update'])->name('mentor.profile.update');
    Route::get('/change-password', [ProfileMentorController::class, 'showChangePasswordForm'])->name('mentor.password.form');
    Route::post('/change-password', [ProfileMentorController::class, 'changePassword'])->name('mentor.password.update');
    
    Route::get('/schedule', function () {
        return view('mentor.schedule');
    })->name('mentor.schedule');
    
    Route::get('/subjects', function () {
        return view('mentor.subjects');
    })->name('mentor.subjects');
    
    Route::get('/history', function () {
        return view('mentor.history');
    })->name('mentor.history');
    
    Route::get('/reviews', function () {
        return view('mentor.reviews');
    })->name('mentor.reviews');
});

// Student routes
Route::prefix('student')->middleware(['auth'])->group(function () {
    Route::get('/dashboard', [StudentDashboardController::class, 'index'])->name('student.dashboard');
    
    // Profile
    Route::get('/profile', [ProfileStudentController::class, 'index'])->name('student.profile');
    Route::put('/profile/update', [ProfileStudentController::class, 'update'])->name('student.profile.update');
    Route::get('/change-password', [ProfileStudentController::class, 'showChangePasswordForm'])->name('student.password.form');
    Route::post('/change-password', [ProfileStudentController::class, 'changePassword'])->name('student.password.update');
    
    Route::get('/menu', function () {
        return view('student.menu');
    })->name('student.menu');
    
    // Route::get('/subjects', function () {
    //     return view('student.subjects');
    // })->name('student.subjects');

    Route::get('/subjects', [StudentSubjectController::class, 'index'])->name('student.subjects');
    
    Route::get('/find', function () {
        return view('student.find');
    })->name('student.find');
    
    Route::get('/history', function () {
        return view('student.history');
    })->name('student.history');

    // Route untuk student news
    Route::get('/news', [StudentNewsController::class, 'index'])->name('student.news.index');
    Route::get('/news/search', [StudentNewsController::class, 'search'])->name('student.news.search');
    Route::get('/news/{id}', [StudentNewsController::class, 'show'])->name('student.news.show');
});


// Route fallback untuk menangani 404
Route::fallback(function () {
    return view('errors.404');
});