<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Models\Faq;
use App\Models\Blog;
use App\Models\Glossary;
use App\Models\BusinessLoan;
use Illuminate\Http\Request;
use App\Observers\FaqObserver;
use App\Observers\BlogObserver;
use App\Observers\GlossaryObserver;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use App\Observers\ProgramLoanObserver;
use App\Observers\BusinessLoanObserver;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;

class LanguageController extends Controller
{
    /**
     * Switch the application language
     *
     * @param string $locale
     * @return \Illuminate\Http\RedirectResponse
     */
    public function switchLanguage($locale)
    {
        // Validate if locale exists
        if (!in_array($locale, ['en', 'vi'])) {
            $locale = 'en'; // Default to English
        }

        // Store the locale in session
        Session::put('locale', $locale);

        // If user is logged in, update their language preference
        if (Auth::check()) {
            $user = Auth::user();
            $user->is_language = $locale;
            $user->save();
        }

        // Set application locale
        App::setLocale($locale);

        Faq::observe(FaqObserver::class);
        Blog::observe(BlogObserver::class);

        // Redirect back to the previous page
        return redirect()->back();
    }

    public function index()
    {
        $enPath = base_path('lang/en.json');
        $viPath = base_path('lang/vi.json');

        $enContent = File::exists($enPath) ? File::get($enPath) : '{}';
        $viContent = File::exists($viPath) ? File::get($viPath) : '{}';

        return view('admin.pages.language.index', compact('enContent', 'viContent'));
    }

    public function update(Request $request)
    {
        try {
            $request->validate([
                'locale' => 'required|in:en,vi',
                'content' => 'required|json'
            ]);

            $path = base_path("lang/{$request->locale}.json");

            // Format JSON with proper indentation
            $decodedContent = json_decode($request->content, true);
            $formattedContent = json_encode($decodedContent, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

            File::put($path, $formattedContent);

            return response()->json([
                'status' => 'success',
                'message' => __('messages.success.update', ['name' => __('language.file')])
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
