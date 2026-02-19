@extends('layouts.app')
@section('title', 'Create Task')

@section('content')
<div class="card p">
<form method="POST" action="{{ route('tasks.store') }}">
@csrf

<input type="hidden" name="project_id" value="{{ request('project') }}">
<input type="hidden" name="status" value="todo">

@if($project)
    <p class="muted" style="margin-bottom:10px">
        Adding task to: <strong>{{ $project->name }}</strong>
    </p>
@else
    <p class="muted" style="margin-bottom:10px">Personal Task</p>
@endif

@if ($errors->any())
    <div class="error" style="margin-bottom:10px">
        @foreach ($errors->all() as $error)
            <div>{{ $error }}</div>
        @endforeach
    </div>
@endif

<label>Title</label>
<input class="input" name="title" required style="margin-bottom:10px">

<label>Description</label>
<textarea class="input" name="description" style="margin-bottom:10px"></textarea>

@if($project && $members->count())
    <label>Assign To</label>
    <select class="input" name="assigned_to" style="margin-bottom:10px">
        <option value="">-- Unassigned --</option>
        @foreach($members as $member)
            <option value="{{ $member->id }}">{{ $member->username }}</option>
        @endforeach
    </select>
@endif

<button class="btn">Add Task</button>
</form>
</div>
@endsection