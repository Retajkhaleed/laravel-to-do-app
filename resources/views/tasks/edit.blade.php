@extends('layouts.app')
@section('title', 'Edit Task')

@section('content')
<div class="card p">
<form method="POST" action="{{ route('tasks.update', $task) }}">
@csrf
@method('PUT')

<input type="hidden" name="assigned_to" value="{{ $task->assigned_to }}">

<label>Title</label>
<input class="input" name="title" value="{{ $task->title }}" placeholder="Task title" required style="margin-bottom:10px">

<label>Description</label>
<textarea class="input" name="description" placeholder="Task description" style="margin-bottom:10px">{{ $task->description }}</textarea>

<label>Status</label>
<select class="input" name="status" style="margin-bottom:10px">
    <option value="todo"        {{ $task->status == 'todo'        ? 'selected' : '' }}>Todo</option>
    <option value="in_progress" {{ $task->status == 'in_progress' ? 'selected' : '' }}>In Progress</option>
    <option value="done"        {{ $task->status == 'done'        ? 'selected' : '' }}>Done</option>
</select>

<button class="btn">Save</button>
</form>
</div>
@endsection