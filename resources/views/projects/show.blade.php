@extends('layouts.app')
@section('title',$project->name)

@section('content')

<div class="card p">
    <p class="muted">{{ $project->description }}</p>

    @can('update',$project)
        <a class="btn" href="{{ route('projects.edit',$project) }}">Edit Project</a>
        <a class="btn" href="{{ route('tasks.create',['project'=>$project->id]) }}">
            + Add Task
        </a>
    @endcan
</div>

<div class="card" style="margin-top:15px;">
@foreach($project->tasks as $task)
    <div class="task">
        <div class="dot {{ $task->status=='done'?'done':'' }}"></div>

        <div style="flex:1">
            <p class="title {{ $task->status=='done'?'done':'' }}">
                {{ $task->title }}
            </p>
            <small class="muted">{{ $task->description }}</small>
        </div>

        @can('update',$task)
            <a class="btn" href="{{ route('tasks.edit',$task) }}">Edit</a>
        @endcan
    </div>
@endforeach
</div>

@endsection