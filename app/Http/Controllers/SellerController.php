<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Exports\SellersExport; // Import the export class
use Maatwebsite\Excel\Facades\Excel; // Import the Excel facade

class SellerController extends Controller
{
    public function export()
    {
        return Excel::download(new SellersExport, 'sellers.xlsx');
    }

    public function index()
    {
        $sellers = User::where('role_id', 3)->get(); // Assuming role_id = 3 is for sellers
        return view('admin.approve_seller', compact('sellers'));
    }

    // Approve seller
    public function approve(User $user)
    {
        $user->approval_status = 'approved';
        $user->activity_status = 'active';
        $user->save();

        return redirect()->route('sellers.index')->with('success', 'Seller approved successfully.');
    }

    // Reject seller
    public function reject(User $user)
    {
        $user->approval_status = 'rejected';
        $user->save();

        return redirect()->route('sellers.index')->with('success', 'Seller rejected successfully.');
    }
}
