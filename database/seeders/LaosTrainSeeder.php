<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Country;
use App\Models\AdministrativeUnit;
use App\Models\Station;
use App\Models\SeatClass;
use App\Models\Route;
use App\Models\Train;
use App\Models\TrainSeatClass;
use Carbon\Carbon;

class LaosTrainSeeder extends Seeder
{
    public function run()
    {
        // 1. Create Laos Country
        $laos = Country::firstOrCreate([
            'code' => 'LA'
        ], [
            'name' => 'Laos',
            'local_name' => 'ລາວ',
            'currency_code' => 'LAK',
            'currency_symbol' => '₭',
            'timezone' => 'Asia/Vientiane',
            'is_active' => true
        ]);

        // 2. Create Administrative Units (Provinces in Laos)
        $vientiane = AdministrativeUnit::firstOrCreate([
            'country_id' => $laos->id,
            'code' => 'VTE',
            'name' => 'Vientiane Capital'
        ], [
            'local_name' => 'ນະຄອນຫຼວງວຽງຈັນ',
            'type' => AdministrativeUnit::TYPE_PROVINCE,
            'level' => AdministrativeUnit::LEVEL_PROVINCE,
            'latitude' => 17.9757,
            'longitude' => 102.6331,
            'is_active' => true
        ]);

        $luangPrabang = AdministrativeUnit::firstOrCreate([
            'country_id' => $laos->id,
            'code' => 'LPB',
            'name' => 'Luang Prabang'
        ], [
            'local_name' => 'ຫຼວງພະບາງ',
            'type' => AdministrativeUnit::TYPE_PROVINCE,
            'level' => AdministrativeUnit::LEVEL_PROVINCE,
            'latitude' => 19.8563,
            'longitude' => 102.1355,
            'is_active' => true
        ]);

        $champasak = AdministrativeUnit::firstOrCreate([
            'country_id' => $laos->id,
            'code' => 'CPS',
            'name' => 'Champasak'
        ], [
            'local_name' => 'ຈໍາປາສັກ',
            'type' => AdministrativeUnit::TYPE_PROVINCE,
            'level' => AdministrativeUnit::LEVEL_PROVINCE,
            'latitude' => 15.1202,
            'longitude' => 105.7794,
            'is_active' => true
        ]);

        $savannakhet = AdministrativeUnit::firstOrCreate([
            'country_id' => $laos->id,
            'code' => 'SVK',
            'name' => 'Savannakhet'
        ], [
            'local_name' => 'ສະຫວັນນະເຂດ',
            'type' => AdministrativeUnit::TYPE_PROVINCE,
            'level' => AdministrativeUnit::LEVEL_PROVINCE,
            'latitude' => 16.5563,
            'longitude' => 104.7540,
            'is_active' => true
        ]);

        $vangVieng = AdministrativeUnit::firstOrCreate([
            'country_id' => $laos->id,
            'code' => 'VV',
            'name' => 'Vang Vieng'
        ], [
            'local_name' => 'ວັງວຽງ',
            'type' => AdministrativeUnit::TYPE_DISTRICT,
            'level' => AdministrativeUnit::LEVEL_DISTRICT,
            'parent_id' => $vientiane->id,
            'latitude' => 18.9244,
            'longitude' => 102.4481,
            'is_active' => true
        ]);

        // 3. Create Stations
        $stationVientiane = Station::firstOrCreate([
            'code' => 'VTE'
        ], [
            'administrative_unit_id' => $vientiane->id,
            'name' => 'Vientiane Central Station',
            'address' => 'Chanthabouly District, Vientiane Capital',
            'latitude' => 17.9757,
            'longitude' => 102.6331,
            'is_active' => true
        ]);

        $stationLuangPrabang = Station::firstOrCreate([
            'code' => 'LPB'
        ], [
            'administrative_unit_id' => $luangPrabang->id,
            'name' => 'Luang Prabang Station',
            'address' => 'Luang Prabang City',
            'latitude' => 19.8563,
            'longitude' => 102.1355,
            'is_active' => true
        ]);

        $stationPakse = Station::firstOrCreate([
            'code' => 'PKS'
        ], [
            'administrative_unit_id' => $champasak->id,
            'name' => 'Pakse Station',
            'address' => 'Pakse City, Champasak Province',
            'latitude' => 15.1202,
            'longitude' => 105.7794,
            'is_active' => true
        ]);

        $stationSavannakhet = Station::firstOrCreate([
            'code' => 'SVK'
        ], [
            'administrative_unit_id' => $savannakhet->id,
            'name' => 'Savannakhet Station',
            'address' => 'Savannakhet City',
            'latitude' => 16.5563,
            'longitude' => 104.7540,
            'is_active' => true
        ]);

        $stationVangVieng = Station::firstOrCreate([
            'code' => 'VV'
        ], [
            'administrative_unit_id' => $vangVieng->id,
            'name' => 'Vang Vieng Station',
            'address' => 'Vang Vieng District',
            'latitude' => 18.9244,
            'longitude' => 102.4481,
            'is_active' => true
        ]);

        // 4. Create Seat Classes
        $economyClass = SeatClass::firstOrCreate([
            'code' => 'ECO'
        ], [
            'name' => 'Economy Class',
            'description' => 'Standard seating with basic amenities',
            'sort_order' => 1,
            'is_active' => true
        ]);

        $businessClass = SeatClass::firstOrCreate([
            'code' => 'BUS'
        ], [
            'name' => 'Business Class',
            'description' => 'Enhanced comfort with more legroom',
            'sort_order' => 2,
            'is_active' => true
        ]);

        $firstClass = SeatClass::firstOrCreate([
            'code' => 'FST'
        ], [
            'name' => 'First Class',
            'description' => 'Premium experience with luxury amenities',
            'sort_order' => 3,
            'is_active' => true
        ]);

        $sleeperClass = SeatClass::firstOrCreate([
            'code' => 'SLP'
        ], [
            'name' => 'Sleeper',
            'description' => 'Private berths for overnight travel',
            'sort_order' => 4,
            'is_active' => true
        ]);

        // 5. Create Routes
        $route1 = Route::firstOrCreate([
            'code' => 'VTE-LPB'
        ], [
            'name' => 'Vientiane - Luang Prabang Express',
            'departure_station_id' => $stationVientiane->id,
            'arrival_station_id' => $stationLuangPrabang->id,
            'distance_km' => 400,
            'estimated_duration_minutes' => 480, // 8 hours
            'is_active' => true
        ]);

        $route2 = Route::firstOrCreate([
            'code' => 'VTE-PKS'
        ], [
            'name' => 'Vientiane - Pakse Southern Route',
            'departure_station_id' => $stationVientiane->id,
            'arrival_station_id' => $stationPakse->id,
            'distance_km' => 650,
            'estimated_duration_minutes' => 780, // 13 hours
            'is_active' => true
        ]);

        $route3 = Route::firstOrCreate([
            'code' => 'LPB-PKS'
        ], [
            'name' => 'Luang Prabang - Pakse Central',
            'departure_station_id' => $stationLuangPrabang->id,
            'arrival_station_id' => $stationPakse->id,
            'distance_km' => 450,
            'estimated_duration_minutes' => 540, // 9 hours
            'is_active' => true
        ]);

        $route4 = Route::firstOrCreate([
            'code' => 'VTE-SVK'
        ], [
            'name' => 'Vientiane - Savannakhet',
            'departure_station_id' => $stationVientiane->id,
            'arrival_station_id' => $stationSavannakhet->id,
            'distance_km' => 350,
            'estimated_duration_minutes' => 420, // 7 hours
            'is_active' => true
        ]);

        $route5 = Route::firstOrCreate([
            'code' => 'VTE-VV'
        ], [
            'name' => 'Vientiane - Vang Vieng',
            'departure_station_id' => $stationVientiane->id,
            'arrival_station_id' => $stationVangVieng->id,
            'distance_km' => 150,
            'estimated_duration_minutes' => 180, // 3 hours
            'is_active' => true
        ]);

        // 6. Create Trains
        $train1 = Train::firstOrCreate([
            'train_number' => 'LT001'
        ], [
            'route_id' => $route1->id,
            'train_type' => 'Express',
            'operator' => 'Lao Railway Corporation',
            'total_seats' => 200,
            'is_active' => true
        ]);

        $train2 = Train::firstOrCreate([
            'train_number' => 'LT002'
        ], [
            'route_id' => $route2->id,
            'train_type' => 'Standard',
            'operator' => 'Lao Railway Corporation',
            'total_seats' => 180,
            'is_active' => true
        ]);

        $train3 = Train::firstOrCreate([
            'train_number' => 'LT003'
        ], [
            'route_id' => $route3->id,
            'train_type' => 'Express',
            'operator' => 'Lao Railway Corporation',
            'total_seats' => 160,
            'is_active' => true
        ]);

        $train4 = Train::firstOrCreate([
            'train_number' => 'LT004'
        ], [
            'route_id' => $route4->id,
            'train_type' => 'Standard',
            'operator' => 'Lao Railway Corporation',
            'total_seats' => 150,
            'is_active' => true
        ]);

        $train5 = Train::firstOrCreate([
            'train_number' => 'LT005'
        ], [
            'route_id' => $route5->id,
            'train_type' => 'Local',
            'operator' => 'Lao Railway Corporation',
            'total_seats' => 120,
            'is_active' => true
        ]);

        // 7. Create TrainSeatClasses for each train
        $trainSeatConfigs = [
            $train1->id => [
                [$economyClass->id, 80],
                [$businessClass->id, 60],
                [$firstClass->id, 40],
                [$sleeperClass->id, 20]
            ],
            $train2->id => [
                [$economyClass->id, 100],
                [$businessClass->id, 50],
                [$sleeperClass->id, 30]
            ],
            $train3->id => [
                [$economyClass->id, 70],
                [$businessClass->id, 50],
                [$firstClass->id, 40]
            ],
            $train4->id => [
                [$economyClass->id, 90],
                [$businessClass->id, 60]
            ],
            $train5->id => [
                [$economyClass->id, 120]
            ]
        ];

        foreach ($trainSeatConfigs as $trainId => $configs) {
            foreach ($configs as [$seatClassId, $totalSeats]) {
                TrainSeatClass::firstOrCreate([
                    'train_id' => $trainId,
                    'seat_class_id' => $seatClassId,
                ], [
                    'total_seats' => $totalSeats,
                    'available_seats' => $totalSeats,
                    'is_active' => true
                ]);
            }
        }

        $this->command->info('Laos Train base data seeded successfully!');
        $this->command->info('Created:');
        $this->command->info('- 1 Country (Laos)');
        $this->command->info('- 5 Administrative Units');
        $this->command->info('- 5 Stations');
        $this->command->info('- 4 Seat Classes');
        $this->command->info('- 5 Routes');
        $this->command->info('- 5 Trains with seat configurations');
        $this->command->info('');
        $this->command->info('To create daily schedules, run:');
        $this->command->info('php artisan schedules:create-daily');
    }
}
