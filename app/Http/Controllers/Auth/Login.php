<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;


class Login extends Controller
{   
    //one function controller to handle login logic
    public function __invoke(Request $request)
    {
        // Validate the incoming request data is correct
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        //login the user using the provided credentials, if failed return back with error message
        if (! Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            return back()->withErrors([
                'email' => 'Invalid credentials.',
            ])->onlyInput('email');
        }

        $request->session()->regenerate();

        if (auth()->user()->isSuperAdmin()) {
            return redirect()->route('admin.dashboard')->with('success', 'Welcome Admin!');
        }

        return redirect()->route('dashboard')->with('success', 'Welcome back!');
    }
}
