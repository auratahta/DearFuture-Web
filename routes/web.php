<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Mentor\DashboardController as MentorDashboardController;
use App\Http\Controllers\Student\DashboardController as StudentDashboardController;

// Public routes
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Auth routes
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::post('/register', [RegisterController::class, 'register'])->name('register');

// Admin routes
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    // Tambahkan route lainnya untuk admin
});
// Mentor routes
Route::prefix('mentor')->middleware(['auth'])->group(function () {
    Route::get('/dashboard', [MentorDashboardController::class, 'index'])->name('mentor.dashboard_mentor');
    // Tambahkan route lainnya untuk mentor
});

// Student routes
Route::prefix('student')->middleware(['auth'])->group(function () {
    // Route::get('/menu', [StudentDashboardController::class, 'index'])->name('student.menu');
    // Tambahkan route lainnya untuk student
});

// Public pages accessible from welcome
Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

// Admin routes
Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    
    // Admin menu routes
    Route::get('/subjects', function () {
        return view('admin.subjects.index');
    })->name('admin.subjects.index');
    
    Route::get('/users', function () {
        return view('admin.users.index');
    })->name('admin.users.index');
    
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

    Route::get('/index', function () {
        return view('admin.index');
    })->name('admin.index');

    Route::get('/edit', function () {
        return view('admin.edit');
    })->name('admin.edit');

    Route::get('/news', function () {
        return view('admin.news.index');
    })->name('admin.news.index');
});

// Mentor routes
Route::prefix('mentor')->middleware(['auth'])->group(function () {
    Route::get('/dashboard_mentor', [MentorDashboardController::class, 'index'])->name('mentor.dashboard_mentor');
    
    // Mentor menu routes
    Route::get('/schedule', function () {
        return view('student.menu');
    })->name('student.menu');
    
    Route::get('/subjects', function () {
        return view('mentor.subjects');
    })->name('mentor.subjects');
    
    Route::get('/history', function () {
        return view('mentor.history');
    })->name('mentor.history');
    
    Route::get('/profile', function () {
        return view('mentor.profile');
    })->name('mentor.profile');
    
    Route::get('/reviews', function () {
        return view('mentor.reviews');
    })->name('mentor.reviews');
});

// Student routes
Route::prefix('student')->middleware(['auth'])->group(function () {
    // Route::get('/menu', [StudentDashboardController::class, 'index'])->name('student.menu');
    
    // Student menu routes
    Route::get('/menu', function () {
        return view('student.menu');
    })->name('student.menu');
    
    Route::get('/subjects', function () {
        return view('student.subjects');
    })->name('student.subjects');
    
    Route::get('/find', function () {
        return view('student.find');
    })->name('student.find');
    
    Route::get('/history', function () {
        return view('student.history');
    })->name('student.history');
    
    Route::get('/profile', function () {
        return view('student.profile');
    })->name('student.profile');
});

// Route fallback untuk menangani 404
Route::fallback(function () {
    return view('errors.404');
});
