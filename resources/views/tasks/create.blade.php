@extends('tasks.app')
@section('title','Create Todo')

@section('content')
  <div class="card">
    <div class="p" style="font-weight:700">Create a new todo</div>
    <div class="divider"></div>

    <div class="p">
      <form method="POST" action="/store-data">
        @csrf

        <div style="margin-bottom:12px">
          <label class="muted">Name</label>
          <input class="input" name="name" value="{{ old('name') }}" placeholder="e.g. Study Networks">
          @error('name') <div class="error">{{ $message }}</div> @enderror
        </div>

        <div style="margin-bottom:12px">
          <label class="muted">Description</label>
          <textarea class="textarea" name="description" placeholder="Write details...">{{ old('description') }}</textarea>
          @error('description') <div class="error">{{ $message }}</div> @enderror
        </div>

        <button class="btn btn-primary" type="submit">Save</button>
        <a class="btn" href="/">Cancel</a>
      </form>
    </div>
  </div>
@endsection