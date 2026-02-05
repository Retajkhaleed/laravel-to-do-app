@extends('tasks.app')
@section('title','Todo Details')

@section('content')
  <div class="card">
    <div class="p" style="display:flex;justify-content:space-between;align-items:center;gap:10px">
      <div>
        <div class="muted" style="font-size:13px">Todo</div>
        <div style="font-weight:800;font-size:18px">{{ $todos->name }}</div>
      </div>

      <div style="display:flex;gap:8px;flex-wrap:wrap">
        <a class="btn" href="/edit/{{ $todos->id }}">Edit</a>
        <a class="btn btn-danger" href="/delete/{{ $todos->id }}" onclick="return confirm('Delete this todo?')">Delete</a>
      </div>
    </div>

    <div class="divider"></div>

    <div class="p">
      <div class="muted" style="margin-bottom:8px">Description</div>
      <div style="line-height:1.6">{{ $todos->description }}</div>
    </div>
  </div>
@endsection