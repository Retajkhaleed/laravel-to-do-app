@extends('layouts.app')

@section('title','Forgot Password')

@section('content')
<div class="card">
    <div class="p">

        <h2 style="margin:0 0 12px 0;font-size:20px">
            Forgot Password
        </h2>

        @if(session('status'))
            <p style="color:green;margin-bottom:10px">
                {{ session('status') }}
            </p>
        @endif

        <form method="POST" action="{{ route('password.email') }}"
              style="display:flex;flex-direction:column;gap:10px">
            @csrf

            <input class="input"
                   type="email"
                   name="email"
                   placeholder="Email Address"
                   required>

            @error('email')
                <p style="color:red">{{ $message }}</p>
            @enderror

            <button class="btn" type="submit">
                Send Reset Link
            </button>
        </form>

        <p style="margin-top:10px;font-size:13px">
            <a href="{{ route('login') }}"
               style="text-decoration:underline;color:#9d174d">
                Back to Login
            </a>
        </p>

    </div>
</div>
@endsection