<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function search(Request $request)
    {
        // Mock data for demonstration
        $searchParams = [
            'departure' => $request->get('departure', 'Vientiane'),
            'arrival' => $request->get('arrival', 'Vang Vieng'),
            'date' => $request->get('date', date('Y-m-d', strtotime('+1 day'))),
            'select_date' => $request->get('selectDate', date('Y-m-d', strtotime('+1 day')))
        ];

        // Mock train data
        $trains = [
            [
                'id' => 1,
                'train_number' => 'C1',
                'departure_time' => '08:00',
                'arrival_time' => '09:30',
                'duration' => '1h 30m',
                'price_2nd' => 25000,
                'price_1st' => 45000,
                'available_2nd' => 28,
                'available_1st' => 12,
                'train_type' => 'Express',
                'amenities' => ['wifi', 'ac', 'food']
            ],
            [
                'id' => 2,
                'train_number' => 'C3',
                'departure_time' => '14:00',
                'arrival_time' => '15:30',
                'duration' => '1h 30m',
                'price_2nd' => 25000,
                'price_1st' => 45000,
                'available_2nd' => 15,
                'available_1st' => 8,
                'train_type' => 'Express',
                'amenities' => ['wifi', 'ac', 'food']
            ],
            [
                'id' => 3,
                'train_number' => 'C5',
                'departure_time' => '18:30',
                'arrival_time' => '20:00',
                'duration' => '1h 30m',
                'price_2nd' => 25000,
                'price_1st' => 45000,
                'available_2nd' => 32,
                'available_1st' => 16,
                'train_type' => 'Express',
                'amenities' => ['wifi', 'ac', 'food']
            ]
        ];

        return view('pages.tickets.search', compact('searchParams', 'trains'));
    }

    public function selectSeat(Request $request, $ticketId)
    {
        // Mock ticket data
        $ticket = [
            'id' => $ticketId,
            'train_number' => 'C1',
            'departure' => 'Vientiane',
            'arrival' => 'Vang Vieng',
            'departure_time' => '08:00',
            'arrival_time' => '09:30',
            'date' => '2025-08-15',
            'class' => $request->get('class', '2nd'),
            'price' => $request->get('class', '2nd') == '2nd' ? 25000 : 45000
        ];

        return view('pages.tickets.select-seat', compact('ticket'));
    }

    public function book(Request $request)
    {
        // Handle booking logic here
        return redirect()->route('tickets.search')->with('success', 'Ticket booked successfully!');
    }
}