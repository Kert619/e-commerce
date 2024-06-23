<?php

namespace App\Http\Controllers;

use App\Traits\HttpResponse;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    use HttpResponse;


    /**
     * Get the current logged in user.
     */
    public function user()
    {
        $user = Auth::user();

        return $this->success($user);
    }
}
