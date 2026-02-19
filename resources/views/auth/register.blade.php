@extends('layouts.app')

@section('title', 'Register')

@section('content')
<div class="card">
  <div class="p">
    <h2 style="margin:0 0 12px 0;font-size:20px">Create Account</h2>
    <p class="muted" style="margin:0 0 16px 0"></p>
@if ($errors->any())
  <div style="color:red;margin-bottom:10px">
    @foreach ($errors->all() as $error)
      <div>{{ $error }}</div>
    @endforeach
  </div>
@endif

<form action="{{ route('register.post') }}" method="POST"
      style="display:flex;flex-direction:column;gap:10px">
            @csrf

<input
    class="input"
    type="text"
    name="username"
    placeholder="Username"
    required
>

      <input class="input" type="email" name="email" placeholder="Email Address"
             value="{{ old('email') }}" required>

      <input class="input" type="password" name="password" placeholder="Password" required>

      <input class="input" type="password" name="password_confirmation"
             placeholder="Confirm Password" required>

      <button class="btn" type="submit">Register</button>

      <p class="muted" style="margin:6px 0 0 0;font-size:13px">
        Already have an account?
        <a href="{{ route('login') }}"
           style="text-decoration:underline;color:#9d174d">
          Login
        </a>
      </p>
    </form>

  </div>
</div>
@endsection