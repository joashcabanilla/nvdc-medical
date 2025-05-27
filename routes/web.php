<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GuestController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [GuestController::class, 'Index'])->name('user.login');
Route::get('/login', [GuestController::class, 'Login'])->name('admin.login');
Route::get('/register', [GuestController::class, 'register'])->name('user.register');
