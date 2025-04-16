<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index()
    {
        $userId = auth()->user()->id;
        $bookings = Booking::where('user_id', $userId)->get();
        return view('user.bookings', compact('bookings'));
    }

    public function markComplete($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->status = 'completed';
        $booking->save();

        return redirect()->route('bookings.list')->with('success', 'Booking marked as completed.');
    }


    public function create()
    {
        return view('bookings.create');
    }


    public function confirm($id)
    {
        $booking = Booking::findOrFail($id);

        if ($booking->status === 'pending') {
            $booking->status = 'confirmed';
            $booking->save();

            return redirect()->back()->with('success', 'Booking confirmed successfully.');
        }

        return redirect()->back()->with('error', 'Unable to confirm booking.');
    }

    public function complete($id)
    {
        $booking = Booking::findOrFail($id);

        if ($booking->status === 'confirmed') {
            $booking->status = 'completed';
            $booking->save();
            return redirect()->back()->with('success', 'Booking marked as completed.');
        }

        return redirect()->back()->with('error', 'Unable to mark booking as completed.');
    }


    public function cancel($id)
    {
        $booking = Booking::findOrFail($id);

        if ($booking->status === 'confirmed' || $booking->status === 'pending') {
            $booking->status = 'cancelled';
            $booking->save();
            return redirect()->back()->with('success', 'Booking cancelled successfully.');
        }

        return redirect()->back()->with('error', 'Unable to cancel booking.');
    }

    // Method to mark booking as completed



    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'service_id' => 'required',
            'worker_id' => 'required',
            'booking_date' => 'required|date',
            'status' => 'required'
        ]);

        Booking::create($request->all());

        return redirect()->route('bookings.index')->with('success', 'Booking created successfully.');
    }

    public function show(Booking $booking)
    {
        return view('bookings.show', compact('booking'));
    }


    public function cancelBooking($id)
    {
        $booking = Booking::findOrFail($id);

        if ($booking->status === 'pending' || $booking->status === 'confirmed') {
            $booking->status = 'cancelled';
            $booking->save();

            return redirect()->back()->with('success', 'Booking cancelled successfully.');
        }

        return redirect()->back()->with('error', 'Unable to cancel booking.');
    }
}
