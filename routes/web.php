<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MailController;
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
Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->name('dashboard');
Route::middleware(['auth:sanctum', 'verified'])->get('/home', [DashboardController::class, 'index'])->name('home');
Route::get('send-basic-email',[MailController::class,'basic_email']);
Route::get('send-html-email',[MailController::class,'html_email']);
Route::get('send-attachment-email',[MailController::class,'attachment_email']);
Route::get('/email',function ()
{
    Mail::to('razanhasan896@gmail.com')->send(new WelcomeMail());
    return new WelcomeMail();
});
