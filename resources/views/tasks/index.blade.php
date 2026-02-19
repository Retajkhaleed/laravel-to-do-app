@extends('layouts.app')
@section('page_title','My Tasks')

@section('content')

<div class="card">
@foreach($tasks as $task)
    <div class="task">
        <p class="title">{{ $task->title }}</p>
        <small class="muted">
            {{ $task->project?->name ?? 'Personal Task' }}
        </small>
    </div>
@endforeach
</div>

@endsection