<?php

namespace App\Http\Controllers;

use App\Models\Route;
use App\Models\Schedule;
use App\Models\Station;
use App\Models\Train;
use App\Models\TrainSeatClass;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TicketController extends Controller
{

    const LAOS_TIMEZONE = 'Asia/Vientiane';

    public function ticketList(Request $request)
    {
        $departureCode = $request->input('departure') ?? $request->input('from');
        $arrivalCode = $request->input('arrival') ?? $request->input('to');
        $travelDate = $request->input('travel_date') ?? $request->input('date');

        $validatedTravelDate = $this->validateAndFixTravelDate($travelDate);

        if ($travelDate && $travelDate !== $validatedTravelDate) {
            $queryParams = $request->query();
            $queryParams['travel_date'] = $validatedTravelDate;

            return redirect()->route('tickets.list', $queryParams);
        }

        $stations = [];
        if ($departureCode || $arrivalCode) {
            $codes = array_filter([$departureCode, $arrivalCode]);
            $stationsCollection = Station::whereIn('code', $codes)->get()->keyBy('code');

            $departureStation = $stationsCollection->get($departureCode);
            $arrivalStation = $stationsCollection->get($arrivalCode);
        }

        $searchParams = [
            'departure_code' => $departureCode,
            'arrival_code' => $arrivalCode,
            'departure_id' => $departureStation?->id,
            'arrival_id' => $arrivalStation?->id,
            'departure_name' => $departureStation?->name,
            'arrival_name' => $arrivalStation?->name,
            'travel_date' => $travelDate ?: Carbon::today()->addDays(2)->format('Y-m-d'),
            'passengers' => $request->input('passengers', 1),
        ];

        $trains = [];

        if ($searchParams['departure_id'] && $searchParams['arrival_id']) {
            $trains = $this->searchTrains($searchParams);
        }

        $stations = Station::select('code', 'name')
            ->active()
            ->orderBy('name')
            ->get();

        return view('pages.tickets.ticket-list', compact('trains', 'searchParams', 'stations'));
    }

    private function validateAndFixTravelDate($travelDate)
    {
        $laosToday = Carbon::now(self::LAOS_TIMEZONE)->startOfDay();
        $defaultDate = $laosToday->copy()->addDays(2)->format('Y-m-d');

        if (!$travelDate) {
            return $defaultDate;
        }
        try {
            $parsedDate = Carbon::parse($travelDate, self::LAOS_TIMEZONE)->startOfDay();

            if ($parsedDate->gte($laosToday)) {
                return $parsedDate->format('Y-m-d');
            }
            return $defaultDate;
        } catch (\Exception $e) {
            return $defaultDate;
        }
    }

    private function searchTrains($searchParams)
    {
        $departureStationId = $searchParams['departure_id'];
        $arrivalStationId = $searchParams['arrival_id'];
        $travelDate = Carbon::parse($searchParams['travel_date']);

        $route = Route::with(['departureStation:id,name', 'arrivalStation:id,name'])
            ->active()
            ->where('departure_station_id', $departureStationId)
            ->where('arrival_station_id', $arrivalStationId)
            ->first(['id', 'name', 'departure_station_id', 'arrival_station_id', 'distance_km']);

        if (!$route) {
            return [];
        }

        $schedules = Schedule::select([
            'id',
            'train_id',
            'route_id',
            'departure_datetime',
            'arrival_datetime',
            'is_active'
        ])
            ->with([
                'train:id,train_number,train_type,operator',

                'train.trainSeatClasses' => function ($query) {
                    $query->select('id', 'train_id', 'seat_class_id', 'total_seats')
                        ->where('is_active', true);
                },
                'train.trainSeatClasses.seatClass:id,name,code,description,image',

                'schedulePrices' => function ($query) {
                    $query->select('id', 'schedule_id', 'train_seat_class_id', 'price', 'currency')
                        ->where('is_active', true);
                },
                'schedulePrices.trainSeatClass:id,seat_class_id',

                'tickets' => function ($query) use ($travelDate) {
                    $query->select('id', 'schedule_id', 'seat_class_id')
                        ->whereDate('travel_date', $travelDate->toDateString());
                }
            ])
            ->where('route_id', $route->id)
            ->where('is_active', true)
            ->whereDate('departure_datetime', $travelDate->toDateString())
            ->orderBy('departure_datetime')
            ->get();

        return $this->processSchedulesToTrains($schedules, $route, $travelDate);
    }

    private function processSchedulesToTrains($schedules, $route, $travelDate)
    {
        $trains = [];

        foreach ($schedules as $schedule) {
            $train = $schedule->train;
            $seatClasses = $this->processSeatClasses($schedule, $train);

            if (empty($seatClasses)) {
                continue;
            }

            $departureDateTime = Carbon::parse($schedule->departure_datetime);
            $arrivalDateTime = Carbon::parse($schedule->arrival_datetime);
            $durationMinutes = $departureDateTime->diffInMinutes($arrivalDateTime);

            $trains[] = [
                'id' => $train->id,
                'train_number' => $train->train_number,
                'train_type' => $train->train_type ?? 'Standard',
                'operator' => $train->operator ?? 'Laos Railway',
                'route' => [
                    'name' => $route->name,
                    'departure_station' => $route->departureStation->name,
                    'arrival_station' => $route->arrivalStation->name,
                    'distance_km' => $route->distance_km ?? 0,
                    'estimated_duration_minutes' => $durationMinutes
                ],
                'schedule' => [
                    'id' => $schedule->id,
                    'departure_datetime' => $schedule->departure_datetime,
                    'arrival_datetime' => $schedule->arrival_datetime,
                    'departure_time' => $departureDateTime->format('H:i'),
                    'arrival_time' => $arrivalDateTime->format('H:i'),
                    'duration' => $this->formatDuration($durationMinutes)
                ],
                'seat_classes' => $seatClasses,
                'min_price' => min(array_column($seatClasses, 'price')),
                'travel_date' => $travelDate->format('Y-m-d')
            ];
        }

        return $trains;
    }

    private function processSeatClasses($schedule, $train)
    {
        $seatClasses = [];

        foreach ($train->trainSeatClasses as $trainSeatClass) {
            $bookedSeats = $schedule->tickets
                ->where('seat_class_id', $trainSeatClass->id)
                ->count();

            $availableSeats = max(0, $trainSeatClass->total_seats - $bookedSeats);

            $schedulePrice = $schedule->schedulePrices
                ->firstWhere('train_seat_class_id', $trainSeatClass->id);

            if ($availableSeats > 0 && $schedulePrice) {
                $seatClasses[] = [
                    'id' => $trainSeatClass->seat_class_id,
                    'image' => $trainSeatClass->seatClass->image ? $trainSeatClass->seatClass->getImageUrlAttribute() : asset('assets/images/defaults/seat-class-default.jpg'),
                    'description' => $trainSeatClass->seatClass->description,
                    'name' => $trainSeatClass->seatClass->name,
                    'code' => $trainSeatClass->seatClass->code ?? 'N/A',
                    'available_seats' => $availableSeats,
                    'total_seats' => $trainSeatClass->total_seats,
                    'price' => $schedulePrice->price,
                    'currency' => $schedulePrice->currency ?? 'USD'
                ];
            }
        }
        return $seatClasses;
    }

    private function formatDuration($minutes)
    {
        if (!$minutes) return '';

        $hours = floor($minutes / 60);
        $mins = $minutes % 60;

        if ($hours > 0) {
            return $hours . 'h' . ($mins > 0 ? ' ' . $mins . 'm' : '');
        }

        return $mins . 'm';
    }
}
