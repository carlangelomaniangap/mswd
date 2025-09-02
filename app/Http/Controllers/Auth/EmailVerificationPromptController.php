<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EmailVerificationPromptController extends Controller
{
    /**
     * Display the email verification prompt.
     */
    public function __invoke(Request $request): RedirectResponse|View
    {
        return $request->user()->hasVerifiedEmail()
                    ? $this->redirectToDashboard($request->user())
                    : view('auth.verify-email');
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
