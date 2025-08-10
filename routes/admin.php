<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\RouteController;
use App\Http\Controllers\Admin\TrainController;
use App\Http\Controllers\Admin\TicketController;
use App\Http\Controllers\Admin\AboutUsController;
use App\Http\Controllers\Admin\CountryController;
use App\Http\Controllers\Admin\StationController;
use App\Http\Controllers\Admin\LanguageController;
use App\Http\Controllers\Admin\ScheduleController;
use App\Http\Controllers\Admin\SeatClassController;
use App\Http\Controllers\Admin\TrainStopController;
use App\Http\Controllers\Admin\BannerHomeController;
use App\Http\Controllers\Admin\FaqCategoryController;
use App\Http\Controllers\Admin\SmtpSettingController;
use App\Http\Controllers\Admin\SocialMediaController;
use App\Http\Controllers\Admin\RouteSegmentController;
use App\Http\Controllers\Admin\SegmentPriceController;
use App\Http\Controllers\Admin\SchedulePriceController;
use App\Http\Controllers\Admin\TrainSeatClassController;
use App\Http\Controllers\Admin\AdministrativeUnitController;

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

Route::resource('countries', CountryController::class);

Route::resource('administrative-units', AdministrativeUnitController::class);
Route::get('administrative-units-by-country', [AdministrativeUnitController::class, 'getByCountry'])
    ->name('administrative-units.by-country');

Route::resource('stations', StationController::class);
Route::get('stations-by-unit', [StationController::class, 'getByAdministrativeUnit'])
    ->name('stations.by-unit');

Route::resource('seat-classes', SeatClassController::class);

Route::resource('routes', RouteController::class);

Route::resource('trains', TrainController::class);

Route::resource('tickets', TicketController::class);

Route::resource('schedules', ScheduleController::class);

Route::resource('schedule-prices', SchedulePriceController::class);;

Route::resource('train-seat-classes', TrainSeatClassController::class);
