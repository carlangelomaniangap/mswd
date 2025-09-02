<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class EmailVerificationNotificationController extends Controller
{
    /**
     * Send a new email verification notification.
     */
    public function store(Request $request): RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return $this->redirectToDashboard($request->user());
        }

        $request->user()->sendEmailVerificationNotification();

        return back()->with('status', 'verification-link-sent');
    }

    private function redirectToDashboard($user): RedirectResponse
    {
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($user->role === 'pwd') {
            return redirect()->route('pwd.dashboard');
        } elseif ($user->role === 'aics') {
            return redirect()->route('aics.dashboard');
        } elseif ($user->role === 'senior_citizen') {
            return redirect()->route('senior_citizen.dashboard');
        } elseif ($user->role === 'solo_parent') {
            return redirect()->route('solo_parent.dashboard');
        } else {
            return redirect()->route('login');
        }
    }
}
