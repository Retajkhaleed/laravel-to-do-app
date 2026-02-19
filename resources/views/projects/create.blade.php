@extends('layouts.app')
@section('title','Create Project')

@section('content')

<div class="card p">
<form method="POST" action="{{ route('projects.store') }}">
@csrf

<label>Name</label>
<input class="input" name="name" required>

<label>Description</label>
<textarea class="input" name="description"></textarea>

<button class="btn">Create</button>
</form>
</div>

@endsection