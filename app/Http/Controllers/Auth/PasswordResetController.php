<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class PasswordResetController extends Controller
{
    public function showResetForm(Request $request)
    {
        return view('auth.reset-password', ['email' => $request->email]);
    }

    public function reset(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:8|confirmed',
        ]);

        Log::info('Password reset request for email: ' . $request->email);

        $user = \App\Models\User::where('email', $request->email)->first();

        if (!$user) {
            Log::error('User not found with email: ' . $request->email);
            return back()->withErrors(['email' => 'Email tidak ditemukan.']);
        }

        $user->forceFill([
            'password' => Hash::make($request->password),
            'remember_token' => Str::random(60),
        ])->save();

        Log::info('Password reset successful for user: ' . $user->email);

        return redirect()->route('login')->with('status', 'Password berhasil diperbarui.');
    }
}
