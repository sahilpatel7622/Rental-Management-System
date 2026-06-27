<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Payment;
use App\Models\Property;
use App\Models\Booking;

class AdminController extends Controller
{
    public function adminDashboard()
    {
        $totalUsers      = User::count();
        $totalProperties = Property::count();
        $totalBookings   = Booking::count();
        $totalPayments = Payment::count();
        $totalAmount = Payment::sum('amount');
        return view('admin.dashboard', compact(
            'totalUsers',
            'totalProperties',
            'totalBookings',
            'totalPayments',
            'totalAmount'
        ));
    }

    public function users(Request $request)
    {
        if ($request->ajax()) {
            $users = User::where('role', 'user')->latest();
            return DataTables::of($users)
                ->addIndexColumn()
                ->addColumn('status', function ($row) {
                    if ($row->status == 'active') {
                        return '<span class="badge bg-success">Active</span>';
                    }
                    return '<span class="badge bg-danger">Inactive</span>';
                })
                ->addColumn('action', function ($row) {
                    return '
                        <a href="'.route('admin.user.delete',$row->id).'"
                        class="btn btn-danger btn-sm">
                            <i class="fa fa-trash"></i>
                        </a>
                    ';
                })
                ->rawColumns(['status','action'])
                ->make(true);
        }
        return view('admin.users    ');
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->back()->with('success', 'User deleted successfully!');
    }

    // Payment
    public function payments()
    {
        $payments = Payment::with(['booking.property', 'user'])
                    ->latest()
                    ->get();
        return view('admin.payments', compact('payments'));
    }


    public function paymentStatus($id)
    {
        $payment = Payment::findOrFail($id);
        if ($payment->payment_status == 'pending') {
            $payment->payment_status = 'success';
        } else {
            $payment->payment_status = 'pending';
        }
        $payment->save();
        return back()->with('success', 'Payment status updated successfully.');
    }

}