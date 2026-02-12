<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ImpersonationController extends Controller
{
    /**
     * Impersonate a user.
     */
    public function impersonate(User $user)
    {
        // Safety check: Only admins can impersonate
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        // Store the original admin ID in the session
        session(['impersonator_id' => auth()->id()]);

        // Login as the user
        Auth::login($user);

        return redirect()->route('home')->with('success', "You are now logged in as {$user->name}");
    }

    /**
     * Stop impersonating and return to admin.
     */
    public function stop()
    {
        if (!session()->has('impersonator_id')) {
            return redirect()->route('home');
        }

        $adminId = session()->pull('impersonator_id');
        $admin = User::findOrFail($adminId);

        // Login back as admin
        Auth::login($admin);

        return redirect()->route('admin.dashboard')->with('success', 'Welcome back, Admin!');
    }
}
