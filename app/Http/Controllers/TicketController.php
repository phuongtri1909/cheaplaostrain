<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function index(Request $request)
    {
        // Mock data for demonstration
        $searchParams = [
            'departure' => $request->get('from', 'Vientiane'),
            'arrival' => $request->get('to', 'Vang Vieng'),
            'date' => $request->get('date', date('Y-m-d', strtotime('+1 day'))),
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

        return view('pages.tickets.ticket-list', compact('searchParams', 'trains'));
    }

    public function getSeatMap(Request $request)
    {
        $trainId = $request->get('train_id');
        $class = $request->get('class');

        // Mock seat data - in real app, fetch from database
        $occupiedSeats = ['1A', '1B', '3C', '5A', '7B', '9D'];

        return response()->json([
            'occupied_seats' => $occupiedSeats,
            'total_seats' => 40,
            'available_seats' => 40 - count($occupiedSeats)
        ]);
    }

    public function book(Request $request)
    {
        // Validate booking data
        $validated = $request->validate([
            'train_id' => 'required|integer',
            'class' => 'required|in:1st,2nd',
            'seats' => 'required|array|min:1|max:4',
            'total_price' => 'required|numeric|min:0',
        ]);

        // In real application, save booking to database
        // Create booking record, send confirmation email, etc.

        return response()->json([
            'success' => true,
            'booking_id' => 'LAO' . time(),
            'message' => 'Booking confirmed successfully!'
        ]);
    }

    // Keep legacy methods for compatibility
    public function search(Request $request)
    {
        return $this->index($request);
    }

    public function selectSeat(Request $request, $ticketId)
    {
        return redirect()->route('tickets.index')->with('train_id', $ticketId);
    }
}
