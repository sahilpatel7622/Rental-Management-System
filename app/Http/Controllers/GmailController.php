<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class GmailController extends Controller
{
    public function forgotPassword()
    {
        return view('user.forget-password.index');
    }

    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:user,email',
        ]);
        $user = User::where('email', $request->email)->first();
        $otp = rand(100000, 999999);
        $user->reset_otp = $otp;
        $user->reset_otp_expiry = now()->addMinutes(5);
        $user->save();
        Mail::html("
        <div style='max-width:600px;margin:auto;padding:30px;
                    font-family:Arial,sans-serif;
                    border:1px solid #e5e7eb;
                    border-radius:10px;
                    background:#f9fafb;'>

            <div style='text-align:center;padding-bottom:20px;'>
                <h2 style='color:#4f46e5;margin:0;'>Rental Management</h2>
                <p style='color:#6b7280;margin-top:5px;'>
                    Password Reset Verification
                </p>
            </div>

            <p>Hello <strong>{$user->name}</strong>,</p>

            <p>
                We received a request to reset your password.
                Please use the OTP below to continue.
            </p>

            <div style='text-align:center;margin:30px 0;'>
                <span style='display:inline-block;
                            background:#4f46e5;
                            color:#fff;
                            font-size:28px;
                            font-weight:bold;
                            letter-spacing:8px;
                            padding:15px 30px;
                            border-radius:8px;'>
                    {$otp}
                </span>
            </div>

            <p>
                <strong>OTP Validity:</strong> 5 Minutes
            </p>

            <p style='color:#dc2626;font-size:14px;'>
                Do not share this OTP with anyone.
            </p>

            <hr>

            <p style='font-size:13px;color:#6b7280;text-align:center;'>
                If you didn't request a password reset,
                you can safely ignore this email.
            </p>

            <p style='text-align:center;margin-top:25px;'>
                <strong>Rental Management Team</strong>
            </p>

        </div>
        ",

        function ($message) use ($user) {
            $message->to($user->email)
                    ->subject('Password Reset OTP');
        });
        session([
            'reset_email' => $user->email
        ]);
        return redirect()->route('verify.email.otp.form')
            ->with('success', 'OTP sent successfully to your email.');
    }

    public function otpForm()
    {
        return view('user.forget-password.verify-otp');
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:6',
        ]);
        $email = session('reset_email');
        $user = User::where('email', $email)->first();

        // OTP expired
        if (!$user->reset_otp_expiry || now()->greaterThan($user->reset_otp_expiry)) {
            $user->reset_otp = null;
            $user->reset_otp_expiry = null;
            $user->save();
            session()->forget('reset_email');
            return redirect()->route('forget.password')
                ->with('error', 'OTP expired. Please request a new OTP.');
        }

        // OTP wrong
        if ($user->reset_otp != $request->otp) {
            return back()->with('error', 'Invalid OTP.');
        }

        session(['reset_otp_verified' => true]);
        return redirect()->route('reset.password.form')
            ->with('success', 'OTP verified. Please create new password.');
    }

    public function resetPasswordForm()
    {
        return view('user.forget-password.reset-password');
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|min:6|confirmed',
        ]);
        $email = session('reset_email');
        if (!$email || !session('reset_otp_verified')) {
            return redirect()->route('forget.password')
                ->with('error', 'Session expired. Please try again.');
        }

        $user = User::where('email', $email)->first();
        if (!$user) {
            return redirect()->route('forget.password')
                ->with('error', 'User not found.');
        }

        if (Hash::check($request->password, $user->password)) {
            return back()->with('error', 'New password cannot be the same as your old password.');
        }

        $user->password = Hash::make($request->password);
        $user->reset_otp = null;
        $user->reset_otp_expiry = null;
        $user->save();

        session()->forget(['reset_email', 'reset_otp_verified']);
        return redirect()->route('login')
            ->with('success', 'Password reset successfully.');
    }

}
