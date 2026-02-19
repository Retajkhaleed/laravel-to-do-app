@extends('layouts.app')

@section('title','Reset Password')

@section('content')
<div class="card">
  <div class="p">
    <h2 style="margin:0 0 12px 0;font-size:20px">Reset Password</h2>

    <form method="POST" action="{{ route('password.update') }}"
          style="display:flex;flex-direction:column;gap:10px">
      @csrf

      <input type="hidden" name="token" value="{{ $token }}">

      <input class="input" type="email" name="email" placeholder="Email Address" required>
      @error('email') <p style="color:red">{{ $message }}</p> @enderror

      <input class="input" type="password" name="password" placeholder="New Password" required>
      @error('password') <p style="color:red">{{ $message }}</p> @enderror

      <input class="input" type="password" name="password_confirmation" placeholder="Confirm Password" required>

      <button class="btn" type="submit">Reset</button>
    </form>
  </div>
</div>
@endsection