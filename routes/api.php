<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\User;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/sanctum/token', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
        'device_name' => 'required',
    ]);
 
    $user = User::where('email', $request->email)->first();
 
    // if (! $user || ! Hash::check($request->password, $user->password)) {
    //     throw ValidationException::withMessages([
    //         'email' => ['The provided credentials are incorrect.'],
    //     ]);
    // }
 
    return $user->createToken($request->device_name)->plainTextToken;
});
