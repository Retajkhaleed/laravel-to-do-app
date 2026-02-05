@extends('tasks.app')
@section('title','Tasks')

@section('content')
  <div class="card">
    <div class="p">
      <form class="row" method="POST" action="{{ route('tasks.store') }}">
        @csrf
        <input class="input" type="text" name="title" placeholder="Add a task..." value="{{ old('title') }}">
        <button class="btn btn-primary" type="submit">+ Add</button>
      </form>

      @error('title')
        <div class="error">{{ $message }}</div>
      @enderror
    </div>

    <div class="divider"></div>

    @if($tasks->isEmpty())
      <div class="p muted">No tasks yet.</div>
    @else
      @foreach($tasks as $task)
        <div class="task">
          <div class="dot {{ $task->is_done ? 'done' : '' }}"></div>

          <div style="flex:1">
            <p class="title {{ $task->is_done ? 'done' : '' }}">{{ $task->title }}</p>
            <div class="muted" style="font-size:12px;margin-top:6px">
              {{ $task->created_at->format('Y-m-d H:i') }}
            </div>

            <form class="row" style="margin-top:10px" method="POST" action="{{ route('tasks.update', $task) }}">
              @csrf @method('PUT')
              <input class="input" type="text" name="title" value="{{ $task->title }}">
              <button class="btn" type="submit">Save</button>
            </form>
          </div>

          <div style="display:flex;gap:8px;flex-wrap:wrap;justify-content:flex-end">
            <form method="POST" action="{{ route('tasks.toggle', $task) }}">
              @csrf @method('PATCH')
              <button class="btn" type="submit">{{ $task->is_done ? 'Undo' : 'Done' }}</button>
            </form>

            <form method="POST" action="{{ route('tasks.destroy', $task) }}"
                  onsubmit="return confirm('Delete this task?')">
              @csrf @method('DELETE')
              <button class="btn btn-danger" type="submit">Delete</button>
            </form>
          </div>
        </div>
      @endforeach
    @endif
  </div>
@endsection