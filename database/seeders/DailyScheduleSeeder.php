<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Train;
use App\Models\Route;
use App\Models\Schedule;
use App\Models\SchedulePrice;
use App\Models\SeatClass;
use Carbon\Carbon;

class DailyScheduleSeeder extends Seeder
{
    public function run()
    {
        // Get days from environment or default to 5
        $days = (int) (env('SCHEDULE_DAYS') ?? 5);

        // Tạo danh sách ngày sẽ được tạo schedules
        $datesToCreate = [];
        for ($day = 0; $day < $days; $day++) {
            $datesToCreate[] = Carbon::today()->addDays($day)->format('Y-m-d');
        }

        // Chỉ xóa schedules của những ngày sẽ được tạo lại
        $this->command->info('Clearing existing schedules for dates: ' . implode(', ', $datesToCreate));

        $existingSchedules = Schedule::whereIn(\DB::raw('DATE(departure_datetime)'), $datesToCreate)->get();

        if ($existingSchedules->count() > 0) {
            $this->command->info("Found {$existingSchedules->count()} existing schedules to remove");

            // Xóa prices trước
            $scheduleIds = $existingSchedules->pluck('id')->toArray();
            SchedulePrice::whereIn('schedule_id', $scheduleIds)->delete();

            // Xóa schedules
            Schedule::whereIn('id', $scheduleIds)->delete();

            $this->command->info('Cleared existing schedules and prices');
        } else {
            $this->command->info('No existing schedules found for these dates');
        }

        // Lấy tất cả trains và routes
        $trains = Train::with(['trainSeatClasses.seatClass', 'route'])->where('is_active', true)->get();
        $routes = Route::where('is_active', true)->get();

        if ($trains->isEmpty() || $routes->isEmpty()) {
            $this->command->error('No trains or routes found. Please run LaosTrainSeeder first.');
            return;
        }

        $this->command->info("Creating schedules for {$days} days...");

        // Tạo schedules cho số ngày được chỉ định
        $allSchedules = [];

        for ($day = 0; $day < $days; $day++) {
            $currentDate = Carbon::today()->addDays($day);
            $this->command->info("Creating schedules for: {$currentDate->format('Y-m-d')}");

            $daySchedules = $this->createSchedulesForDate($currentDate, $trains);
            $allSchedules = array_merge($allSchedules, $daySchedules);
        }

        // Tạo prices cho tất cả schedules
        $this->createSchedulePrices($allSchedules);

        $this->command->info('Daily schedules created successfully!');
        $this->command->info("Created " . count($allSchedules) . " schedules for {$days} days starting from " . Carbon::today()->format('Y-m-d'));
    }

    private function createSchedulesForDate($date, $trains)
    {
        $schedules = [];

        foreach ($trains as $train) {
            if (!$train->route) {
                $this->command->warn("Train {$train->train_number} has no route assigned. Skipping...");
                continue;
            }

            // Tạo schedule patterns dựa trên loại train và route
            $schedulePatterns = $this->getSchedulePatterns($train, $date);

            foreach ($schedulePatterns as $pattern) {
                try {
                    $schedule = Schedule::create([
                        'train_id' => $train->id,
                        'route_id' => $train->route->id,
                        'departure_datetime' => $pattern['departure'],
                        'arrival_datetime' => $pattern['arrival'],
                        'is_active' => true
                    ]);

                    $schedules[] = $schedule;

                } catch (\Exception $e) {
                    $this->command->error("Failed to create schedule for train {$train->train_number}: " . $e->getMessage());
                }
            }
        }

        return $schedules;
    }

    private function getSchedulePatterns($train, $date)
    {
        $patterns = [];
        $route = $train->route;

        // Tính duration dựa trên estimated_duration_minutes của route
        $durationMinutes = $route->estimated_duration_minutes ?? 480; // Default 8 hours

        // Patterns dựa trên train type
        switch ($train->train_type) {
            case 'Express':
                // Express trains: 2 departures per day
                $patterns = [
                    [
                        'departure' => $date->copy()->setTime(6, 0),
                        'arrival' => $date->copy()->setTime(6, 0)->addMinutes($durationMinutes)
                    ],
                    [
                        'departure' => $date->copy()->setTime(18, 0),
                        'arrival' => $date->copy()->setTime(18, 0)->addMinutes($durationMinutes)
                    ]
                ];
                break;

            case 'Standard':
                // Standard trains: 1-2 departures per day
                $patterns = [
                    [
                        'departure' => $date->copy()->setTime(7, 30),
                        'arrival' => $date->copy()->setTime(7, 30)->addMinutes($durationMinutes)
                    ]
                ];

                // Thêm departure thứ 2 cho routes dài
                if ($durationMinutes >= 420) { // >= 7 hours
                    $patterns[] = [
                        'departure' => $date->copy()->setTime(16, 0),
                        'arrival' => $date->copy()->setTime(16, 0)->addMinutes($durationMinutes)
                    ];
                }
                break;

            case 'Local':
                // Local trains: Multiple short trips
                $patterns = [
                    [
                        'departure' => $date->copy()->setTime(8, 0),
                        'arrival' => $date->copy()->setTime(8, 0)->addMinutes($durationMinutes)
                    ],
                    [
                        'departure' => $date->copy()->setTime(10, 0),
                        'arrival' => $date->copy()->setTime(10, 0)->addMinutes($durationMinutes)
                    ],
                    [
                        'departure' => $date->copy()->setTime(15, 0),
                        'arrival' => $date->copy()->setTime(15, 0)->addMinutes($durationMinutes)
                    ]
                ];
                break;

            default:
                // Default pattern
                $patterns = [
                    [
                        'departure' => $date->copy()->setTime(9, 0),
                        'arrival' => $date->copy()->setTime(9, 0)->addMinutes($durationMinutes)
                    ]
                ];
        }

        // Adjust for weekend (Saturday and Sunday)
        if ($date->isWeekend()) {
            // Reduce frequency on weekends
            $patterns = array_slice($patterns, 0, max(1, count($patterns) - 1));
        }

        return $patterns;
    }

    private function createSchedulePrices($schedules)
    {
        // Base prices theo seat class code và route code (USD)
        $basePrices = [
            'ECO' => [ // Economy Class
                'VTE-LPB' => 5,    // Vientiane - Luang Prabang: $5
                'VTE-PKS' => 8,    // Vientiane - Pakse: $8
                'LPB-PKS' => 6,    // Luang Prabang - Pakse: $6
                'VTE-SVK' => 4,    // Vientiane - Savannakhet: $4
                'VTE-VV' => 2,     // Vientiane - Vang Vieng: $2
            ],
            'BUS' => [ // Business Class
                'VTE-LPB' => 7.5,
                'VTE-PKS' => 12,
                'LPB-PKS' => 9,
                'VTE-SVK' => 6,
                'VTE-VV' => 3,
            ],
            'FST' => [ // First Class
                'VTE-LPB' => 12,
                'VTE-PKS' => 18,
                'LPB-PKS' => 14,
                'VTE-SVK' => 0,    // Not available
                'VTE-VV' => 0,     // Not available
            ],
            'SLP' => [ // Sleeper
                'VTE-LPB' => 20,
                'VTE-PKS' => 30,
                'LPB-PKS' => 0,    // Not available
                'VTE-SVK' => 0,    // Not available
                'VTE-VV' => 0,     // Not available
            ],
        ];

        $this->command->info('Creating schedule prices...');
        $priceCount = 0;

        foreach ($schedules as $schedule) {
            try {
                $train = Train::with(['trainSeatClasses.seatClass', 'route'])->find($schedule->train_id);

                if (!$train || !$train->route) {
                    $this->command->warn("Schedule {$schedule->id}: Train or route not found. Skipping prices...");
                    continue;
                }

                $routeCode = $train->route->code;

                foreach ($train->trainSeatClasses as $trainSeatClass) {
                    $seatClass = $trainSeatClass->seatClass;

                    if (!$seatClass) {
                        continue;
                    }

                    $seatClassCode = $seatClass->code;

                    // Lấy base price
                    if (!isset($basePrices[$seatClassCode][$routeCode])) {
                        continue;
                    }

                    $basePrice = $basePrices[$seatClassCode][$routeCode];

                    if ($basePrice <= 0) {
                        continue; // Skip if not available
                    }

                    // Apply multipliers
                    $finalPrice = $basePrice;

                    // Weekend premium (5%)
                    if ($schedule->departure_datetime->isWeekend()) {
                        $finalPrice *= 1.05;
                    }

                    // Night/evening premium (10%)
                    $hour = $schedule->departure_datetime->hour;
                    if ($hour >= 18 || $hour <= 6) {
                        $finalPrice *= 1.1;
                    }

                    // Peak time premium (7-9 AM, 5-7 PM) (5%)
                    if (($hour >= 7 && $hour <= 9) || ($hour >= 17 && $hour <= 19)) {
                        $finalPrice *= 1.05;
                    }

                    // Create schedule price
                    SchedulePrice::create([
                        'schedule_id' => $schedule->id,
                        'train_seat_class_id' => $trainSeatClass->id,
                        'price' => round($finalPrice, 2),
                        'currency' => 'USD',
                        'effective_from' => Carbon::today(),
                        'effective_until' => Carbon::today()->addYear(), // Valid for 1 year
                        'is_active' => true
                    ]);

                    $priceCount++;
                }
            } catch (\Exception $e) {
                $this->command->error("Failed to create prices for schedule {$schedule->id}: " . $e->getMessage());
            }
        }

        $this->command->info("Created {$priceCount} schedule prices");
    }
}
