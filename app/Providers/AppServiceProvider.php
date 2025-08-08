<?php

namespace App\Providers;

use App\Models\Faq;
use App\Models\Blog;
use App\Models\Glossary;
use App\Models\FaqCategory;
use App\Models\SocialMedia;
use App\Models\BusinessLoan;
use App\Models\SelectedType;
use Illuminate\Http\Request;
use App\Observers\FaqObserver;
use App\Observers\BlogObserver;
use App\Observers\GlossaryObserver;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Event;
use App\Observers\FaqCategoryObserver;
use App\Observers\ProgramLoanObserver;
use Illuminate\Support\Facades\Schema;
use App\Observers\BusinessLoanObserver;
use App\Observers\SelectedTypeObserver;
use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\Http\Events\RequestHandled;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);

        // Register model observers
        Blog::observe(BlogObserver::class);
        Faq::observe(FaqObserver::class);
        FaqCategory::observe(FaqCategoryObserver::class);

        try {
            if (!app()->runningInConsole() && !request()->is('admin/*') && !request()->is('api/*')) {

                $socialLinks = SocialMedia::where('status', true)->orderBy('order', 'asc')->get();
                View::share('socialLinks', $socialLinks);
            }
        } catch (\Exception $e) {
            report($e);
        }
    }
}
