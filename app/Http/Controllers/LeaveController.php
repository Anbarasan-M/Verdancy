<?php

namespace App\Http\Controllers;

use App\Models\Leave;
use Illuminate\Http\Request;
use App\Models\User;

use Illuminate\Support\Facades\Mail;
use App\Mail\LeaveRequestUserMail;
use App\Mail\LeaveRequestAdminMail;


class LeaveController extends Controller
{
    public function leaveForm()
    {
        $leaveRequests = Leave::where('service_provider_id', auth()->user()->id)->get();

        return view('service_provider.apply_leave', compact('leaveRequests'));    
    }

    public function applyLeave(Request $request)
    {
        $request->validate([
            'leave_date' => 'required|date',
            'leave_reason' => 'required|string',
        ]);
    
        // Save leave request and capture it in a variable
        $leaveRequest = Leave::create([
            'service_provider_id' => auth()->user()->id,
            'leave_date' => $request->leave_date,
            'reason' => $request->leave_reason,
        ]);
    
        // Send email to the logged-in user
        Mail::to(auth()->user()->email)->send(new LeaveRequestUserMail($leaveRequest));
    
        // Send email to admins (role_id = 2)
        $admins = User::where('role_id', 2)->get();
        foreach ($admins as $admin) {
            Mail::to($admin->email)->send(new LeaveRequestAdminMail($leaveRequest));
        }
    
        session()->flash('leave_applied', 'Leave request submitted successfully!');
    
        return redirect()->back()->with('success', 'Leave request submitted successfully!');
    }
    

    public function index()
    {
        $pendingLeaves = Leave::where('status', Leave::PENDING)->get();
        $approvedLeaves = Leave::where('status', Leave::APPROVED)->get();
        $rejectedLeaves = Leave::where('status', Leave::REJECTED)->get();
    
        return view('admin.manage_leaves', compact('pendingLeaves', 'approvedLeaves', 'rejectedLeaves'));
    }
    

    // Approve a leave request
    public function approve($id)
    {
        $leave = Leave::findOrFail($id);
        $leave->status = Leave::APPROVED;
        $leave->save();

        return redirect()->back()->with('success', 'Leave approved successfully!');
    }

    // Reject a leave request
    public function reject($id)
    {
        $leave = Leave::findOrFail($id);
        $leave->status = Leave::REJECTED;
        $leave->save();

        return redirect()->back()->with('error', 'Leave rejected.');
    }
}
