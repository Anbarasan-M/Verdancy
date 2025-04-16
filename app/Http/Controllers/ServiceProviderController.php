<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

use App\Imports\ServiceProvidersImport; // Import the export class
use Maatwebsite\Excel\Facades\Excel; // Import the Excel facade

class ServiceProviderController extends Controller
{

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv,xls',
        ]);

        // Import the service providers from the uploaded file
        Excel::import(new ServiceProvidersImport, $request->file('file'));

        return redirect()->back()->with('success', 'Service providers imported successfully!');
    }

    
    public function index()
    {
        $serviceProviders = User::where('role_id', 5)->get(); // Assuming role_id = 5 is for service providers
        return view('admin.approve_service_provider', compact('serviceProviders'));
    }

    // Approve service provider
    public function approve(User $user)
    {
        $user->approval_status = 'approved';
        $user->activity_status = 'active';
        $user->save();

        return redirect()->route('serviceProviders.index')->with('success', 'Service Provider approved successfully.');
    }

    // Reject service provider
    public function reject(User $user)
    {
        $user->approval_status = 'rejected';
        $user->save();

        return redirect()->route('serviceProviders.index')->with('success', 'Service Provider rejected successfully.');
    }
}
