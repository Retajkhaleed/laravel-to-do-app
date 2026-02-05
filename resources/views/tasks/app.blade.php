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
      --text:#1f2937;
      --muted:#6b7280;
      --line:#f1d5e5;
      --pink:#ec4899;
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
      display:flex;justify-content:space-between;align-items:center;gap:10px;
      margin-bottom:16px;
    }
    .brand h1{margin:0;font-size:26px}
    .brand small{color:var(--muted)}
    .card{
      background:var(--card);
      border:1px solid var(--line);
      border-radius:var(--radius);
      box-shadow:var(--shadow);
      overflow:hidden;
    }
    .p{padding:16px}
    .divider{height:1px;background:var(--line)}
    a{color:inherit;text-decoration:none}
    .btn{
      display:inline-flex;align-items:center;gap:8px;
      border:1px solid var(--line);
      background:#fff;
      padding:10px 12px;
      border-radius:14px;
      cursor:pointer;
      font-size:14px;
      transition:.15s ease;
    }
    .btn:hover{transform:translateY(-1px);box-shadow:0 10px 20px rgba(236,72,153,.10)}
    .btn-primary{
      background:linear-gradient(135deg, var(--pink-50), #ffffff);
      border-color:#f6bfdc;
      color:#9d174d;
      font-weight:600;
    }
    .btn-danger{
      background:#fff5f8;
      border-color:#f8b4cf;
      color:#9f1239;
    }
    .input{
      width:100%;
      border:1px solid var(--line);
      background:#fff;
      padding:12px 14px;
      border-radius:14px;
      outline:none;
      font-size:14px;
    }
    .row{display:flex;gap:10px;align-items:center}
    .muted{color:var(--muted)}
    .flash{
      margin-bottom:14px;
      padding:12px 14px;
      border-radius:14px;
      border:1px solid #f6bfdc;
      background:var(--pink-50);
      color:#9d174d;
    }
    .task{
      display:flex;gap:12px;align-items:flex-start;
      padding:14px 16px;
    }
    .task + .task{border-top:1px solid var(--line)}
    .dot{
      width:18px;height:18px;border-radius:6px;
      border:1px solid var(--line);
      margin-top:2px;flex:0 0 auto;background:#fff;
    }
    .dot.done{background:#ec4899;border-color:#ec4899}
    .title{flex:1;margin:0;font-size:15px;line-height:1.4}
    .title.done{color:var(--muted);text-decoration:line-through}
    .error{
      margin-top:10px;
      padding:10px 12px;
      border-radius:14px;
      border:1px solid #f8b4cf;
      background:#fff1f7;
      color:#9f1239;
      font-size:13px;
    }
  </style>
</head>

<body>
<div class="container">

  <div class="topbar">
    <div class="brand">
      <h1>Todo</h1>
    </div>
    <a class="btn btn-primary" href="{{ route('tasks.index') }}">All Tasks</a>
  </div>

  @if(session()->has('success'))
    <div class="flash">{{ session('success') }}</div>
  @endif

  @yield('content')

</div>
</body>
</html>