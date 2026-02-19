@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="card">
    <div class="p">

        <h2 style="margin:0 0 12px 0;font-size:20px">Welcome Back</h2>
        <p class="muted" style="margin:0 0 16px 0"></p>
@if ($errors->any())
  <div style="color:red;margin-bottom:10px">
    @foreach ($errors->all() as $error)
      <div>{{ $error }}</div>
    @endforeach
  </div>
@endif
      <form action="{{ route('login.post') }}" method="POST"
      style="display:flex;flex-direction:column;gap:10px">            @csrf

            <input
                class="input"
                type="email"
                name="email"
                placeholder="Email Address"
                value="{{ old('email') }}"
                required
            >

            <input
                class="input"
                type="password"
                name="password"
                placeholder="Password"
                required
            >

            <button class="btn" type="submit">Sign In</button>

            <p class="muted" style="margin:6px 0 0 0;font-size:13px">
                Don't have an account?
                <a href="{{ route('register') }}"
                   style="text-decoration:underline;color:#9d174d">
                    Register
                </a>
            </p>    

             <p class="muted" style="margin:6px 0 0 0;font-size:13px">
                 Forgot your password?  
                <a href="{{ route('password.request') }}"
                   style="text-decoration:underline;color:#9d174d">
                    Reset Password
                </a>
            </p>
        </form>

    </div>
</div>
@endsection