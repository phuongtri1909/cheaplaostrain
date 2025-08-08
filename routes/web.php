<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FaqController;
use Illuminate\Support\Facades\Artisan;
use PHPUnit\Framework\Attributes\Group;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\AboutUsController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\Admin\LanguageController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/clear-cache', function () {
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('route:clear');
    Artisan::call('view:clear');
    return "Cache is cleared";
})->name('clear.cache');

// Sitemap Routes
Route::get('sitemap.xml', [SitemapController::class, 'index'])->name('sitemap.index');
Route::get('sitemap-pages.xml', [SitemapController::class, 'pages'])->name('sitemap.pages');
Route::get('sitemap-blogs.xml', [SitemapController::class, 'blogs'])->name('sitemap.blogs');
Route::get('sitemap-loan-programs.xml', [SitemapController::class, 'loanPrograms'])->name('sitemap.loan-programs');

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/tickets', [TicketController::class, 'search'])->name('tickets.search');
Route::get('/tickets/select-seat/{ticket}', [TicketController::class, 'selectSeat'])->name('tickets.select-seat');
Route::post('/tickets/book', [TicketController::class, 'book'])->name('tickets.book');

Route::get('about-us', [AboutUsController::class, 'index'])->name('about.us');

// Client Pages
Route::get('faq', [FaqController::class, 'indexClient'])->name('faq');
Route::get('/faqs/search', [FaqController::class, 'search'])->name('faqs.search');

Route::get('news', [BlogController::class, 'indexClient'])->name('blogs');
Route::get('news/{slug}', [BlogController::class, 'showClient'])->name('blogs.show');

// Language Switch
Route::get('language/{locale}', [LanguageController::class, 'switchLanguage'])
    ->name('language.switch');

// Authentication Routes
Route::group(['middleware' => 'auth'], function () {
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::group(['middleware' => 'guest'], function () {
    Route::get('/login', function () {
        return view('pages.auth.login');
    })->name('login');

    Route::post('/login', [AuthController::class, 'login'])->name('login');
});
