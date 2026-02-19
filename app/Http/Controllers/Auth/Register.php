<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Auth\Events\Registered;

class Register extends Controller
{
    public function __invoke(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255|unique:users,username',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:6',
        ]);

        $user = User::create([
    'username' => $request->username,
    'email'    => $request->email,
    'password' => Hash::make($request->password), 
]);
        event(new Registered($user));
        Auth::login($user);
        return redirect()->route('verification.notice');
    }
}