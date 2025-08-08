<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\AboutUsController;
use App\Http\Controllers\Admin\LanguageController;
use App\Http\Controllers\Admin\BannerHomeController;
use App\Http\Controllers\Admin\FaqCategoryController;
use App\Http\Controllers\Admin\SmtpSettingController;
use App\Http\Controllers\Admin\SocialMediaController;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register admin routes for your application.
| These routes are loaded by the RouteServiceProvider within a group which
| contains the "admin" middleware group.
|
*/

Route::get('/', function () {
    return view('admin.pages.dashboard');
})->name('dashboard');

// User Management
Route::resource('users', UserController::class)->except(['show']);
Route::post('/users/{user}/logout', [UserController::class, 'logoutUser'])->name('users.logout');

// FAQ Management
Route::resource('faq-categories', FaqCategoryController::class);
Route::resource('faqs', FaqController::class);

// Blog Management
Route::resource('blogs', BlogController::class)->except(['show']);
Route::post('blogs/upload-image', [BlogController::class, 'uploadImage'])->name('blogs.upload.image');

// Banner Management
Route::resource('banner-home', BannerHomeController::class)->except(['show']);

// Social Media Management
Route::resource('socials', SocialMediaController::class)->except(['show']);

// Language Management
Route::get('languages', [LanguageController::class, 'index'])->name('languages.index');
Route::post('languages/update', [LanguageController::class, 'update'])->name('languages.update');

// SMTP Settings
Route::get('/smtp-settings', [SmtpSettingController::class, 'edit'])->name('smtp-settings.edit');
Route::post('/smtp-settings', [SmtpSettingController::class, 'update'])->name('smtp-settings.update');
Route::post('/smtp-settings/test', [SmtpSettingController::class, 'sendTest'])->name('smtp-settings.test');

// About Us Management
Route::get('about-us', [AboutUsController::class, 'index'])->name('about-us.index');
Route::put('about-us', [AboutUsController::class, 'update'])->name('about-us.update');
