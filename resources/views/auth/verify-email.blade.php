@extends('layouts.app')

@section('title','Verify Email')

@section('content')
<div class="card">
    <div class="p">

        <h2 style="margin:0 0 12px 0;font-size:20px">
            Verify Your Email
        </h2>

        <p class="muted" style="margin:0 0 15px 0">
            We sent a verification link to your email address.
        </p>

        @if (session('status'))
            <p style="color:green;margin-bottom:10px">
                {{ session('status') }}
            </p>
        @endif

        <form method="POST" action="{{ route('verification.send') }}"
              style="display:flex;flex-direction:column;gap:10px">
            @csrf

            <button class="btn" type="submit">
                Resend Verification Email
            </button>
        </form>

       
        <form method="POST" action="{{ route('logout') }}"
              style="margin-top:10px">
            @csrf
            <button class="btn" type="submit">
                Logout
            </button>
        </form>
@if ($errors->any())
  <div style="color:red;margin-bottom:10px">
    @foreach ($errors->all() as $error)
      <div>{{ $error }}</div>
    @endforeach
  </div>
@endif
    </div>
</div>
@endsection