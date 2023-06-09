<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Mail\WelcomeMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get('/', function () {
    return redirect(route('login'));
});
Route::group(['middleware' => ['auth:sanctum', 'verified'], 'namespace' => 'App\Http\Controllers\Admin'], function () {

    Route::get('/profile', function () {
        return Inertia::render('Profile/Show');
    })->name('profile.show');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('categories', TaskCategoryController::class);
    Route::resource('admins', AdminController::class);
    Route::resource('teamMembers', TeamMemberController::class);
});
Route::get('/email', function () {
    Mail::to('razanhasan896@gmail.com')->send(new WelcomeMail());
    return new WelcomeMail();
});
