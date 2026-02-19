@extends('layouts.app')
@section('title','My Projects')

@section('content')

<a class="btn" href="{{ route('projects.create') }}">+ New Project</a>

<div class="card" style="margin-top:15px;">
@foreach($projects as $project)
    <div class="task">
        <p class="title">
            <a href="{{ route('projects.show',$project) }}">
                {{ $project->name }}
            </a>
        </p>
    </div>
@endforeach
</div>

@endsection