<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Property;
use App\Models\Payment;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function store(Request $request, $slug)
    {
        $request->validate([
            'check_in'       => 'required|date|after_or_equal:today',
            'check_out'      => 'required|date|after:check_in',
            'payment_method' => 'required',
        ],
        [
            'check_in.required' => 'Check In date is required.',
            'check_in.after_or_equal' => 'Check In date cannot be in the past.',
            'check_out.required' => 'Check Out date is required.',
            'check_out.after' => 'Check Out date must be after Check In date.',
            'payment_method.required' => 'Please select a payment method.',
        ]);

        if (!session()->has('user_id')) {
            return redirect('/login')->with('error', 'Please login first.');
        }
        $userId = session('user_id');

        $room = Property::where('slug', $slug)->firstOrFail();
        $days = \Carbon\Carbon::parse($request->check_in)
                    ->diffInDays(\Carbon\Carbon::parse($request->check_out));
        $perDay = $room->rent_price / 30;
        $totalAmount = $perDay * $days;

        $booking = Booking::create([
            'user_id' =>  $userId,
            'property_id' => $room->id,
            'check_in' => $request->check_in,
            'check_out' => $request->check_out,
            'total_days' => $days,
            'total_amount' => $totalAmount,
            'payment_method' => $request->payment_method,
        ]);

        $status = $request->payment_method == 'Cash'
            ? 'pending'
            : 'success';
            
        Payment::create([
            'booking_id'      => $booking->id,
            'user_id'         =>  $userId,
            'amount'          => $booking->total_amount,
            'payment_method'  => $request->payment_method,
            'payment_status'  => $status
        ]);
        $room->status = 'Rented';
        $room->save();

        return redirect('/dashboard')
            ->with('success', 'Room booked successfully.');
    }

    public function index() 
    {
        $bookings = Booking::with(['property'])
                    ->where('user_id', session('user_id'))
                    ->latest()
                    ->get();

        return view('user.my-bookings', compact('bookings'));
    }

    // Admin Booking
    public function bookings()
    {
        $bookings = Booking::with(['property', 'user'])
                    ->latest()
                    ->get();
        return view('admin.bookings', compact('bookings'));
    }



}