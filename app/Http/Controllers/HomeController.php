<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Route;
use App\Models\Rating;
use App\Models\Comment;
use App\Models\Station;
use App\Models\Schedule;
use App\Models\BannerHome;
use App\Models\SmtpSetting;
use App\Models\SocialMedia;
use Illuminate\Http\Request;
use App\Models\MortgageMilestone;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class HomeController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        $sevenDaysLater = $today->copy()->addDays(7);

        // 1. Lấy banners
        $banners = BannerHome::orderBy('order', 'asc')->get();

        // 2. Lấy stations
        $stations = Station::where('is_active', true)
            ->orderBy('name')
            ->get();

        // 3. Lấy routes kèm departure/arrival stations
        $availableRoutes = Route::where('is_active', true)
            ->with(['departureStation', 'arrivalStation'])
            ->get();

        // 4. Lấy giá vé thấp nhất của mỗi route trong 7 ngày tới
        $minPrices = Schedule::select('route_id', DB::raw('MIN(schedule_prices.price) as min_price'))
            ->join('schedule_prices', function ($join) {
                $join->on('schedules.id', '=', 'schedule_prices.schedule_id')
                    ->where('schedule_prices.is_active', true);
            })
            ->where('schedules.is_active', true)
            ->whereBetween('departure_datetime', [$today, $sevenDaysLater])
            ->groupBy('route_id')
            ->pluck('min_price', 'route_id');

        // 5. Map dữ liệu cho view
        $popularRoutes = $availableRoutes->map(function ($route) use ($minPrices) {
            $minPrice = $minPrices[$route->id] ?? 0;

            return [
                'from_code' => $route->departureStation->code ?? $route->departureStation->id,
                'from_name' => $route->departureStation->name ?? '',
                'to_code' => $route->arrivalStation->code ?? $route->arrivalStation->id,
                'to_name' => $route->arrivalStation->name ?? '',
                'price' => $minPrice > 0
                    ? '$' . number_format($minPrice, 2)
                    : __('Contact us'),
            ];
        });

        // 6. Trả view
        return view('pages.home', compact('banners', 'stations', 'popularRoutes'));
    }


    private function formatDuration($minutes)
    {
        if (!$minutes || $minutes <= 0) return '';

        $hours = floor($minutes / 60);
        $mins = round($minutes % 60);

        if ($hours > 0) {
            return $hours . 'h' . ($mins > 0 ? ' ' . $mins . 'm' : '');
        }

        return $mins . 'm';
    }

    private function getAvailabilityText($route, $today)
    {
        // Đếm số schedules trong 7 ngày tới
        $scheduleCount = Schedule::where('route_id', $route->id)
            ->where('is_active', true)
            ->whereDate('departure_datetime', '>=', $today)
            ->whereDate('departure_datetime', '<=', $today->copy()->addDays(7))
            ->count();

        // Đếm số ngày có schedule
        $daysWithSchedules = Schedule::where('route_id', $route->id)
            ->where('is_active', true)
            ->whereDate('departure_datetime', '>=', $today)
            ->whereDate('departure_datetime', '<=', $today->copy()->addDays(7))
            ->selectRaw('DATE(departure_datetime) as date')
            ->distinct()
            ->count();

        if ($daysWithSchedules >= 7) {
            return __('Daily departures');
        } elseif ($daysWithSchedules >= 5) {
            return __('Multiple weekly');
        } elseif ($scheduleCount >= 3) {
            return __('Multiple times');
        } else {
            return __('Available');
        }
    }
}
