<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\Schedule;
use App\Models\Train;
use App\Models\Route;
use App\Models\RouteSegment;
use App\Models\SeatClass;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function index(Request $request)
    {
        $query = Ticket::with(['schedule', 'train', 'route', 'routeSegment', 'seatClass']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('ticket_number', 'LIKE', '%' . $search . '%')
                  ->orWhere('passenger_name', 'LIKE', '%' . $search . '%')
                  ->orWhere('passenger_email', 'LIKE', '%' . $search . '%');
            });
        }

        if ($request->filled('booking_status')) {
            $query->where('booking_status', $request->booking_status);
        }

        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }

        if ($request->filled('train_id')) {
            $query->where('train_id', $request->train_id);
        }

        if ($request->filled('travel_date')) {
            $query->where('travel_date', $request->travel_date);
        }

        $tickets = $query->orderBy('created_at', 'desc')->paginate(15)->withQueryString();

        $trains = Train::orderBy('train_number')->get();

        return view('admin.pages.tickets.index', compact('tickets', 'trains'));
    }

    public function create()
    {
        $schedules = Schedule::with(['train', 'route'])->where('is_active', true)->orderBy('departure_time')->get();
        $trains = Train::where('is_active', true)->orderBy('train_number')->get();
        $routes = Route::where('is_active', true)->orderBy('name')->get();
        $routeSegments = RouteSegment::with(['originStation', 'destinationStation'])->where('is_active', true)->get();
        $seatClasses = SeatClass::where('is_active', true)->orderBy('sort_order')->get();

        return view('admin.pages.tickets.create', compact('schedules', 'trains', 'routes', 'routeSegments', 'seatClasses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'ticket_number' => 'nullable|string|max:50|unique:tickets,ticket_number',
            'schedule_id' => 'required|exists:schedules,id',
            'train_id' => 'required|exists:trains,id',
            'route_id' => 'required|exists:routes,id',
            'route_segment_id' => 'nullable|exists:route_segments,id',
            'seat_class_id' => 'required|exists:seat_classes,id',
            'travel_date' => 'required|date',
            'passenger_name' => 'required|string|max:255',
            'passenger_email' => 'nullable|email|max:255',
            'seat_number' => 'nullable|string|max:50',
            'price' => 'required|numeric|min:0',
            'currency' => 'nullable|string|max:10',
            'booking_status' => 'required|in:pending,confirmed,cancelled',
            'payment_status' => 'required|in:unpaid,paid,refunded',
            'payment_method' => 'nullable|string|max:50',
            'payment_reference' => 'nullable|string|max:100',
            'booked_at' => 'nullable|date',
            'expires_at' => 'nullable|date',
            'ip_address' => 'nullable|ip'
        ], [
            'schedule_id.required' => 'Lịch trình là bắt buộc',
            'train_id.required' => 'Tàu là bắt buộc',
            'route_id.required' => 'Tuyến đường là bắt buộc',
            'seat_class_id.required' => 'Hạng ghế là bắt buộc',
            'travel_date.required' => 'Ngày đi là bắt buộc',
            'passenger_name.required' => 'Tên hành khách là bắt buộc',
            'price.required' => 'Giá vé là bắt buộc',
            'booking_status.required' => 'Trạng thái đặt vé là bắt buộc',
            'payment_status.required' => 'Trạng thái thanh toán là bắt buộc',
        ]);

        try {
            Ticket::create($request->all());
            return redirect()->route('admin.tickets.index')
                ->with('success', 'Vé đã được tạo thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()
                ->with('error', 'Có lỗi xảy ra khi tạo vé: ' . $e->getMessage());
        }
    }

    public function show(Ticket $ticket)
    {
        $ticket->load(['schedule', 'train', 'route', 'routeSegment.originStation', 'routeSegment.destinationStation', 'seatClass']);
        return view('admin.pages.tickets.show', compact('ticket'));
    }

    public function edit(Ticket $ticket)
    {
        $schedules = Schedule::with(['train', 'route'])->where('is_active', true)->orderBy('departure_time')->get();
        $trains = Train::where('is_active', true)->orderBy('train_number')->get();
        $routes = Route::where('is_active', true)->orderBy('name')->get();
        $routeSegments = RouteSegment::with(['originStation', 'destinationStation'])->where('is_active', true)->get();
        $seatClasses = SeatClass::where('is_active', true)->orderBy('sort_order')->get();

        return view('admin.pages.tickets.edit', compact('ticket', 'schedules', 'trains', 'routes', 'routeSegments', 'seatClasses'));
    }

    public function update(Request $request, Ticket $ticket)
    {
        $request->validate([
            'ticket_number' => 'nullable|string|max:50|unique:tickets,ticket_number,' . $ticket->id,
            'schedule_id' => 'required|exists:schedules,id',
            'train_id' => 'required|exists:trains,id',
            'route_id' => 'required|exists:routes,id',
            'route_segment_id' => 'nullable|exists:route_segments,id',
            'seat_class_id' => 'required|exists:seat_classes,id',
            'travel_date' => 'required|date',
            'passenger_name' => 'required|string|max:255',
            'passenger_email' => 'nullable|email|max:255',
            'seat_number' => 'nullable|string|max:50',
            'price' => 'required|numeric|min:0',
            'currency' => 'nullable|string|max:10',
            'booking_status' => 'required|in:pending,confirmed,cancelled',
            'payment_status' => 'required|in:unpaid,paid,refunded',
            'payment_method' => 'nullable|string|max:50',
            'payment_reference' => 'nullable|string|max:100',
            'booked_at' => 'nullable|date',
            'expires_at' => 'nullable|date',
            'ip_address' => 'nullable|ip'
        ], [
            'schedule_id.required' => 'Lịch trình là bắt buộc',
            'train_id.required' => 'Tàu là bắt buộc',
            'route_id.required' => 'Tuyến đường là bắt buộc',
            'seat_class_id.required' => 'Hạng ghế là bắt buộc',
            'travel_date.required' => 'Ngày đi là bắt buộc',
            'passenger_name.required' => 'Tên hành khách là bắt buộc',
            'price.required' => 'Giá vé là bắt buộc',
            'booking_status.required' => 'Trạng thái đặt vé là bắt buộc',
            'payment_status.required' => 'Trạng thái thanh toán là bắt buộc',
        ]);

        try {
            $ticket->update($request->all());
            return redirect()->route('admin.tickets.index')
                ->with('success', 'Vé đã được cập nhật thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()
                ->with('error', 'Có lỗi xảy ra khi cập nhật vé: ' . $e->getMessage());
        }
    }

    public function destroy(Ticket $ticket)
    {
        try {
            $ticket->delete();
            return redirect()->route('admin.tickets.index')
                ->with('success', 'Vé đã được xóa thành công!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Có lỗi xảy ra khi xóa vé: ' . $e->getMessage());
        }
    }
}
