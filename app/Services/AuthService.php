<?php

//Create auth service class
namespace App\Services;

use App\Models\User;
use Illuminate\Support\Str;

class AuthService
{
    public function getSessionId()
    {
        $sessionId = session('cart_id');
        // Check if the user is authenticated
        if (auth()->check()) {
            $sessionId = auth()->id();
        } else {
            //check if session is null
            if ($sessionId == null) {
                // Generate a new session ID if it doesn't exist
                $sessionId = (string) Str::uuid();
                session(['cart_id' => $sessionId]);
                $sessionId = session('cart_id');
            }
        }

        return $sessionId;
    }
}
