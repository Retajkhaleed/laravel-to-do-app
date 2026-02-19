@extends('layouts.app')
@section('title', 'Todo')

@section('content')

{{-- My Projects --}}
<div class="card" style="margin-bottom:15px">
    <div class="p" style="border-bottom:1px solid var(--line);display:flex;justify-content:space-between;align-items:center">
        <h3 style="margin:0">My Projects</h3>
        <a class="btn" href="{{ route('projects.create') }}">+ New</a>
    </div>

    @forelse($myProjects as $project)
        <div style="border-bottom:1px solid var(--line)">
            <div class="task">
                <div style="flex:1">
                    <p class="title" style="margin:0">{{ $project->name }}</p>
                    @if($project->description)
                        <small class="muted" style="display:block">{{ $project->description }}</small>
                    @endif
                    <small class="muted">{{ $project->tasks->count() }} tasks</small>
                </div>
                <form method="POST" action="{{ route('projects.toggle', $project) }}">
                    @csrf @method('PATCH')
                    <button class="btn" type="submit" style="font-size:11px">{{ $project->status == 'todo' ? 'Todo' : ($project->status == 'in_progress' ? 'In Progress' : 'Done') }}</button>
                </form>
                <a class="btn" href="{{ route('tasks.create', ['project' => $project->id]) }}" style="font-size:11px">+ Task</a>
                <a class="btn" href="{{ route('projects.edit', $project) }}" style="font-size:11px">Edit</a>
            </div>

            @forelse($project->tasks as $task)
                <div class="task" style="padding-left:28px">
                    <div class="dot {{ $task->status == 'done' ? 'done' : '' }}"></div>
                    <div style="flex:1">
                        <p class="title {{ $task->status == 'done' ? 'done' : '' }}" style="margin:0;font-size:14px">{{ $task->title }}</p>
                        @if($task->description)
                            <small class="muted" style="display:block">{{ $task->description }}</small>
                        @endif
                        <small class="muted">{{ $task->assignee?->username ?? 'Unassigned' }}</small>
                    </div>
                    <form method="POST" action="{{ route('tasks.toggle', $task) }}">
                        @csrf @method('PATCH')
                        <button class="btn" type="submit" style="font-size:11px">{{ $task->status == 'todo' ? 'Todo' : ($task->status == 'in_progress' ? 'In Progress' : 'Done') }}</button>
                    </form>
                    @can('addMember', $project)
                        <button class="btn" style="font-size:11px" onclick="this.closest('.task').nextElementSibling.classList.toggle('hidden')">+ Assign</button>
                    @endcan
                    <a class="btn" href="{{ route('tasks.edit', $task) }}" style="font-size:11px">Edit</a>
                </div>
                <div class="hidden" style="padding:8px 16px 8px 44px;border-top:1px solid var(--line)">
                    <form method="POST" action="{{ route('tasks.assign', $task) }}">
                        @csrf @method('PATCH')
                        <div class="row">
                            <input class="input" name="username" placeholder="Username" required style="max-width:200px">
                            <button class="btn" type="submit">Assign</button>
                        </div>
                    </form>
                </div>
            @empty
                <p class="muted" style="padding:10px 28px;margin:0;font-size:13px">No tasks yet.</p>
            @endforelse
        </div>
    @empty
        <div class="p muted">No projects yet.</div>
    @endforelse
</div>

{{-- Shared With Me --}}
<div class="card" style="margin-bottom:15px">
    <div class="p" style="border-bottom:1px solid var(--line)">
        <h3 style="margin:0">Shared With Me</h3>
    </div>
    @forelse($sharedProjects as $project)
        <div style="border-bottom:1px solid var(--line)">
            <div class="task">
                <div style="flex:1">
                    <p class="title" style="margin:0">{{ $project->name }}</p>
                    <small class="muted">by {{ $project->owner->username }}</small>
                </div>
            </div>
            @forelse($project->tasks->where('assigned_to', auth()->id()) as $task)
                <div class="task" style="padding-left:28px">
                    <div class="dot {{ $task->status == 'done' ? 'done' : '' }}"></div>
                    <div style="flex:1">
                        <p class="title {{ $task->status == 'done' ? 'done' : '' }}" style="margin:0;font-size:14px">{{ $task->title }}</p>
                        @if($task->description)
                            <small class="muted" style="display:block">{{ $task->description }}</small>
                        @endif
                        <small class="muted">{{ $task->status }}</small>
                    </div>
                    <form method="POST" action="{{ route('tasks.toggle', $task) }}">
                        @csrf @method('PATCH')
                        <button class="btn" type="submit" style="font-size:11px">{{ $task->status == 'todo' ? 'Todo' : ($task->status == 'in_progress' ? 'In Progress' : 'Done') }}</button>
                    </form>
                    <a class="btn" href="{{ route('tasks.edit', $task) }}" style="font-size:11px">Edit</a>
                </div>
            @empty
                <p class="muted" style="padding:10px 28px;margin:0;font-size:13px">No tasks assigned to you.</p>
            @endforelse
        </div>
    @empty
        <div class="p muted">No shared projects.</div>
    @endforelse
</div>

{{-- My Tasks --}}
<div class="card">
    <div class="p" style="border-bottom:1px solid var(--line);display:flex;justify-content:space-between;align-items:center">
        <h3 style="margin:0">My Tasks</h3>
        <a class="btn" href="{{ route('tasks.create') }}">+ Task</a>
    </div>
    @forelse($myTasks as $task)
        <div class="task">
            <div class="dot {{ $task->status == 'done' ? 'done' : '' }}"></div>
            <div style="flex:1">
                <p class="title {{ $task->status == 'done' ? 'done' : '' }}" style="margin:0">{{ $task->title }}</p>
                @if($task->description)
                    <small class="muted" style="display:block">{{ $task->description }}</small>
                @endif
                <small class="muted">{{ $task->project?->name ?? 'Personal Task' }}</small>
            </div>
            <form method="POST" action="{{ route('tasks.toggle', $task) }}">
                @csrf @method('PATCH')
                <button class="btn" type="submit" style="font-size:11px">{{ $task->status == 'todo' ? 'Todo' : ($task->status == 'in_progress' ? 'In Progress' : 'Done') }}</button>
            </form>
            <a class="btn" href="{{ route('tasks.edit', $task) }}" style="font-size:11px">Edit</a>
        </div>
    @empty
        <div class="p muted">No tasks yet.</div>
    @endforelse
</div>

@endsection