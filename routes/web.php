<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| These are the routes for guests, members, and admins, separated
| by prefix and grouped according to their roles and responsibilities.
|
*/

// Guest Routes (Public Pages, No Authentication)
Route::middleware(['guest'])->group(function () {
    // GET Routes
    Route::get('/', [GuestController::class, 'Index'])->name('user.login');
    Route::get('/login', [GuestController::class, 'Login'])->name('admin.login');
    Route::get('/register', [GuestController::class, 'register'])->name('user.register');

    // POST Routes
    Route::post('/login', [GuestController::class, 'postLogin'])->name('user.postLogin');
    Route::post('/register', [GuestController::class, 'postRegister'])->name('user.postRegister');
});

// Member Routes (Authenticated + Member Role Only)
Route::prefix('member')->middleware(['auth', 'member'])->group(function () {
    // GET Routes
    Route::get('/landingpage', [MemberController::class, 'LandingPage'])->name('member.landing');
    Route::get('/appointment', [MemberController::class, 'Appointment'])->name('member.appointment');

    // Optional: Direct route for dashboard
    Route::get('/', function () {
        return view('Components.memberDashboard');
    });

    // POST Routes
    Route::post('/logout', [MemberController::class, 'PostLogout'])->name('member.logout');
});

// Admin Routes (Authenticated + Admin Role Only)
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    // GET Routes
    Route::get('/dashboard', [AdminController::class, 'Dashboard'])->name('admin.dashboard');
    Route::get('/scheduled-appointment', [AdminController::class, 'ScheduledAppointment'])->name('admin.scheduledAppointment');
    Route::get('/appointment-list', [AdminController::class, 'AppointmentList'])->name('admin.appointmentList');

    // Services
    Route::get('/consultations', [AdminController::class, 'Consultations'])->name('admin.consultations');
    Route::get('/laboratory', [AdminController::class, 'Laboratory'])->name('admin.laboratory');
    Route::get('/imaging', [AdminController::class, 'Imaging'])->name('admin.imaging');
    Route::get('/anchillaries', [AdminController::class, 'Anchillaries'])->name('admin.anchillaries');

    // Management
    Route::get('/patients', [AdminController::class, 'Patients'])->name('admin.patients');
    Route::get('/doctor', [AdminController::class, 'Doctor'])->name('admin.doctor');
    Route::get('/rates', [AdminController::class, 'Rates'])->name('admin.rates');

    // Optional: Direct route for dashboard view
    Route::get('/', function () {
        return view('Components.adminDashboard');
    });

    // POST Routes
    Route::post('/logout', [AdminController::class, 'PostLogout'])->name('admin.logout');
});

// Shared Logout Route (Fallback)
Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [GuestController::class, 'logout'])->name('logout');
});
