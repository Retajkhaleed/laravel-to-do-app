@extends('layouts.app')
@section('title','Edit Project')

@section('content')

<div class="card p">
<form method="POST" action="{{ route('projects.update',$project) }}">
@csrf
@method('PUT')

<input class="input" name="name" value="{{ $project->name }}" required>
<textarea class="input" name="description">{{ $project->description }}</textarea>

<button class="btn">Save</button>
</form>
</div>

@endsection