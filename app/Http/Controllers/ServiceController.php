<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Booking; // Import the Booking model
use Illuminate\Support\Facades\Storage;

class ServiceController extends Controller
{
    
    public function showServices()
    {
        $userId = auth()->user()->id;

        // Fetch services and bookings for the logged-in user
        $bookings = Booking::where('user_id', $userId)->get();

        $services = Service::all();
        return view('services.index', compact('services', 'bookings'));
    }

    public function showBookingForm($serviceId)
    {
        $service = Service::findOrFail($serviceId);
        $workers = User::where('role_id', 5)->get(); // Assuming role_id 4 is for workers
        return view('services.book', compact('service', 'workers'));
    }

    public function bookService(Request $request, $serviceId)
    {
        $request->validate([
            'booking_date' => 'required|date',
            'worker_id' => 'required|exists:users,id',
            'booking_time' => 'required|date_format:H:i', // Ensure this matches the format you want

        ]);

        Booking::create([
            'user_id' => auth()->id(),
            'service_id' => $serviceId,
            'worker_id' => $request->worker_id,
            'booking_date' => $request->booking_date,
            'booking_time' => $request->booking_time,
            'status' => 'pending',
        ]);

        session()->flash('service_booked', 'Service Booked successfully!');

        return redirect()->back()->with('success', 'Service Booked successfully!');
    }

    private function getUserBookings()
    {
        $user = auth()->user();
        if ($user) {
            return Booking::where('user_id', $user->id)
                ->with(['service', 'worker'])
                ->orderBy('booking_date', 'desc')
                ->get();
        }
        return collect(); // Return an empty collection if the user is not logged in
    }

    public function bookings()
    {
        // Get all bookings for the logged-in service provider
        $bookings = Booking::where('worker_id', auth()->user()->id)->get();

        return view('service_provider.bookings', compact('bookings'));
    }

    public function complete($id)
    {
        $booking = Booking::findOrFail($id);
        
        if ($booking->status == 'confirmed') {
            $booking->status = 'completed';
            $booking->save();
        }
    
        return redirect()->back()->with('success', 'Booking marked as completed.');
    }

    public function index()
    {
        $userId = auth()->user()->id;

        // Fetch services and bookings for the logged-in user
        $services = Service::all();
        $bookings = Booking::where('user_id', $userId)->get();

        // Pass both services and bookings to the view
        return view('services.index', compact('services', 'bookings'));
    }

    public function create()
    {
        return view('services.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required',
            'price' => 'required|numeric'
        ]);

        Service::create($request->all());

        return redirect()->route('services.index')->with('success', 'Service created successfully.');
    }

    public function show(Service $service)
    {
        return view('services.show', compact('service'));
    }

    public function destroy(Service $service)
    {
        $service->delete();
        return redirect()->route('services.index')->with('success', 'Service deleted successfully.');
    }

    public function edit($id)
    {
        $service = Service::findOrFail($id);
        return view('services.edit', compact('service'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|max:2048', // Optional image upload
        ]);

        $service = Service::findOrFail($id);

        $service->name = $request->input('name');
        $service->description = $request->input('description');
        $service->price = $request->input('price');

        if ($request->hasFile('image')) {
            if ($service->image) {
                Storage::disk('public')->delete($service->image);
            }

            $service->image = $request->file('image')->store('service_images', 'public');
        }

        $service->save();

        return redirect()->route('admin.services')->with('success', 'Service updated successfully!');
    }
}
