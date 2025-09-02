<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     */
    public function __invoke(EmailVerificationRequest $request): RedirectResponse
    {
        $user = $request->user();

        if (!$user->hasVerifiedEmail()) {
            if ($user->markEmailAsVerified()) {
                event(new Verified($user));
            }
        }

        return $this->redirectToDashboard($user)->with('verified', 1);
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
