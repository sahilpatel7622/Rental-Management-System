<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Models\Property;
use App\Models\Booking;
use App\Models\Payment;
use Twilio\Rest\Client;


class UserController extends Controller
{
    public function login()
    {
        return view('user.login');
    }

    public function register()
    {
        return view('user.register');
    }

    public function registerStore(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:user,email',
            'phone' => 'required|numeric|digits:10|unique:user,phone',
            'password' => 'required|min:6',
        ]);

        session([
            'register_data' => [
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => $request->password,
            ],
            'otp_sent' => true
        ]);

        $twilio = new Client(env('TWILIO_SID'), env('TWILIO_AUTH_TOKEN'));
        $twilio->verify->v2
            ->services(env('TWILIO_VERIFY_SID'))
            ->verifications
            ->create('+91'.$request->phone, 'sms');

        return redirect()->route('otp.form')
            ->with('success', 'OTP sent successfully.');

    }

    public function otpForm()
    {
        return view('user.otp');
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:6',
        ]);

        $data = session('register_data');
        if (!$data) {
            return redirect()->route('register')
                ->with('error', 'Session expired. Please register again.');
        }

        $twilio = new Client(env('TWILIO_SID'), env('TWILIO_AUTH_TOKEN'));
        $result = $twilio->verify->v2
            ->services(env('TWILIO_VERIFY_SID'))
            ->verificationChecks
            ->create([
                'to' => '+91'.$data['phone'],
                'code' => $request->otp,
            ]);

        if ($result->status == 'approved') {
            User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'password' => Hash::make($data['password']),
                'role' => 'user',
                'status' => 'active',
            ]);

            session()->forget('register_data');

            return redirect()->route('login')
                ->with('success', 'Registration completed successfully.');
        }

        return back()->with('error', 'Invalid OTP.');
    }

    public function loginStore(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return back()->with('error', 'Email not found');
        }


        if ($user->role == 'admin') {
            if ($request->password != $user->password) {
                return back()->with('error', 'Password incorrect');
            }
        } else {
            if (!Hash::check($request->password, $user->password)) {
                return back()->with('error', 'Password incorrect');
            }
        }

        $request->session()->put('user_id', $user->id);
        $request->session()->put('user_name', $user->name);
        $request->session()->put('user_email', $user->email);
        $request->session()->put('user_phone', $user->phone);
        $request->session()->put('user_role', $user->role);
        $request->session()->save();

       if ($user->role == 'admin') {
            return redirect()->route('admin.dashboard')
                ->with('success', 'Admin Login Successfully!');
        }

        return redirect()->route('user.dashboard')
            ->with('success', 'User Login Successfully!');
    }

    public function userDashboard()
    {
        $userId = session('user_id');
        $availableRooms = Property::where('status', 'Available')->count();
        $myBookings = Booking::where('user_id', $userId)->count();
        $myPayments = Payment::where('user_id', $userId)->count();
        return view('user.dashboard', compact(
            'availableRooms',
            'myBookings',
            'myPayments'
        ));
    }

    public function logout(Request $request)
    {
        $request->session()->flush();
        return redirect()->route('user.dashboard')->with('success', 'Logout successfully');
    }


    // Room
    public function rooms(Request $request)
    {
        $query = Property::where('status', 'available');
        if ($request->filled('location')) {
            $query->where('location', $request->location);
        }
        $rooms = $query->latest()->get();

        if ($request->ajax()) {
            return view('user.rooms_list', compact('rooms'))->render();
        }

        $locations = Property::select('location')
                        ->distinct()
                        ->orderBy('location')
                        ->get();
        return view('user.rooms', compact('rooms', 'locations'));
    }

    // View Room
    public function roomDetails($slug)
    {
        $room = Property::where('slug', $slug)->firstOrFail();
        return view('user.room-details', compact('room'));
    }

    public function bookingSummary(Request $request, $slug)
    {
        $room = Property::where('slug', $slug)->firstOrFail();
        return view('user.booking-summary', compact('room'));
    }

    // My-Booking
    public function index() 
    {
        $bookings = Booking::with(['property', 'payment'])
            ->where('user_id', session('user_id'))
            ->latest()
            ->get();
        return view('user.my-bookings', compact('bookings'));
    }

    // Profile
    public function profile()
    {
        $user = User::findOrFail(session('user_id'));   
        return view('user.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = User::findOrFail(session('user_id'));
        $request->validate([
            'name'  => 'required',
            'email' => 'required|email|unique:user,email,' . $user->id,
            'phone' => 'required|numeric|digits:10|unique:user,phone,' . $user->id,
        ]);
        if (
            $user->name == $request->name &&
            $user->email == $request->email &&
            $user->phone == $request->phone
        ) 
        {
            return back()->with('info', 'No changes were made.');
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->save();
        session(['user_name' => $user->name]);
        return back()->with('success', 'Profile updated successfully.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ],[
            'current_password.required' => 'Current password is required.',
            'new_password.required' => 'New password is required.',
            'new_password.min' => 'Password must be at least 6 characters.',
            'new_password.confirmed' => 'Confirm password does not match.',
        ]);
        $user = User::findOrFail(session('user_id'));
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->with('error', 'Current password is incorrect.');
        }
        if (Hash::check($request->new_password, $user->password)) {
            return back()->with('info', 'New password cannot be same as current password.');
        }
        $user->password = Hash::make($request->new_password);
        $user->save();
        return back()->with('success', 'Password changed successfully.');
    }

}