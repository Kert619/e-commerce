<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Traits\HttpResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    use HttpResponse;
    /**
     * Handle an authentication attempt.
     */
    public function authenticate(LoginRequest $request)
    {
        $credentials = $request->validated();

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return $this->success(Auth::user(), 'Logged in successfully');
        }

        return $this->error('Email or password is incorrect');
    }

    /**
     * Log the user out of the application.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return $this->success(null, 'Logged out successfully, 204');
    }

    /**
     * Get the current logged in user.
     */
    public function user()
    {
        $user = Auth::user();

        return $this->success($user);
    }
}
