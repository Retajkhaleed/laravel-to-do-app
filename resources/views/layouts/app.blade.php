<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title','Todo')</title>

  <style>
    :root{
      --bg:#fff7fb;
      --card:#ffffff;
      --card2:#fff1f7;
      --text:#1f2937;
      --muted:#6b7280;
      --line:#f1d5e5;
      --pink:#ec4899;
      --pink-dark:#9d174d;
      --pink-50:#fff1f7;
      --pink-100:#ffe4f1;
      --shadow: 0 12px 30px rgba(17,24,39,.08);
      --radius:18px;
    }
    *{box-sizing:border-box}
    body{
      margin:0;
      font-family: ui-sans-serif, system-ui, -apple-system, Segoe UI, Roboto, Arial;
      color:var(--text);
      background:
        radial-gradient(900px 500px at 15% 10%, var(--pink-100) 0%, transparent 55%),
        radial-gradient(700px 420px at 85% 20%, #ffe9f5 0%, transparent 55%),
        var(--bg);
      min-height:100vh;
      padding:40px 16px;
    }
    .container{max-width:860px;margin:0 auto}
    .topbar{
      margin-bottom:20px;
      display:flex;
      justify-content:space-between;
      align-items:center;
    }
    .brand h1{
      margin:0;
      font-size:24px;
      font-weight:700;
      background:linear-gradient(135deg,#ec4899,#f97316);
      -webkit-background-clip:text;
      -webkit-text-fill-color:transparent;
    }
    .card{
      background:var(--card);
      border:1px solid var(--line);
      border-radius:var(--radius);
      box-shadow:var(--shadow);
      overflow:hidden;
    }
    .p{padding:16px}
    .divider{height:1px;background:var(--line)}
    .muted{color:var(--muted)}
    .flash{
      margin-bottom:14px;
      padding:12px 16px;
      border-radius:14px;
      border:1px solid #f6bfdc;
      background:var(--pink-50);
      color:#9d174d;
      font-size:14px;
    }
    .flash-error{
      margin-bottom:14px;
      padding:12px 16px;
      border-radius:14px;
      border:1px solid #f8b4cf;
      background:#fff5f8;
      color:#9f1239;
      font-size:14px;
    }
    .task{
      display:flex;gap:12px;align-items:center;
      padding:12px 16px;
    }
    .task + .task{border-top:1px solid var(--line)}
    .dot{
      width:18px;height:18px;border-radius:6px;
      border:1px solid var(--line);
      flex:0 0 auto;background:#fff;
    }
    .dot.done{background:#ec4899;border-color:#ec4899}
    .title{flex:1;margin:0;font-size:15px;line-height:1.4;color:var(--text)}
    .title.done{color:var(--muted);text-decoration:line-through}
    .input{
      width:100%;
      border:1px solid var(--line);
      background:#fff;
      color:var(--text);
      padding:12px 14px;
      border-radius:14px;
      outline:none;
      font-size:14px;
      transition:border .2s;
    }
    .input:focus{border-color:var(--pink)}
    .row{display:flex;gap:10px;align-items:center}
    .btn{
      border:1px solid var(--line);
      background:#fff;
      color:var(--text);
      padding:9px 14px;
      border-radius:14px;
      cursor:pointer;
      font-size:13px;
      white-space:nowrap;
      transition:border .2s, background .2s;
      text-decoration:none;
      display:inline-block;
    }
    .btn:hover{border-color:var(--pink);background:var(--pink-50)}
    .btn-danger{
      background:#fff5f8;
      border-color:#f8b4cf;
      color:#9f1239;
    }
    .btn-danger:hover{background:#ffe4f1}
    .error{
      margin-top:10px;
      padding:10px 14px;
      border-radius:14px;
      border:1px solid #f8b4cf;
      background:#fff1f7;
      color:#9f1239;
      font-size:13px;
    }
    .hidden{display:none}
    label{
      display:block;
      font-size:13px;
      color:var(--muted);
      margin-bottom:5px;
    }
    a{color:var(--pink-dark);text-decoration:none}
    a:hover{text-decoration:underline}
  </style>
</head>

<body>
<div class="container">

  <div class="topbar">
    <div class="brand">
      <h1>Todo</h1>
    </div>
    @auth
    <div style="display:flex;align-items:center;gap:10px">
      <span class="muted" style="font-size:13px">{{ auth()->user()->username }}</span>
      @if(auth()->user()->isSuperAdmin())
      <a class="btn" href="{{ route('admin.dashboard') }}" style="font-size:12px">Admin</a>
      @endif
      <a class="btn" href="{{ route('dashboard') }}" style="font-size:12px">Dashboard</a>
      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button class="btn btn-danger" type="submit" style="font-size:12px">Logout</button>
      </form>
    </div>
    @endauth
  </div>

  @if(session()->has('success'))
    <div class="flash">{{ session('success') }}</div>
  @endif

  @if(session()->has('error'))
    <div class="flash-error">{{ session('error') }}</div>
  @endif

  @yield('content')

</div>
</body>
</html>