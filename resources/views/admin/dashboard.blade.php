@extends('layouts.app')
@section('title', 'Admin Dashboard')

@section('content')

<div style="display:grid;grid-template-columns:repeat(3,1fr);gap:15px;margin-bottom:20px">
    <div class="card p" style="text-align:center">
        <p class="muted" style="margin:0;font-size:13px">Projects</p>
        <h2 style="margin:5px 0;color:var(--pink)">{{ $totalProjects }}</h2>
        <small class="muted">{{ $completedProjects }} done</small>
    </div>
    <div class="card p" style="text-align:center">
        <p class="muted" style="margin:0;font-size:13px">Tasks</p>
        <h2 style="margin:5px 0;color:var(--pink)">{{ $totalTasks }}</h2>
        <small class="muted">{{ $completedTasks }} done</small>
    </div>
    <div class="card p" style="text-align:center">
        <p class="muted" style="margin:0;font-size:13px">Users</p>
        <h2 style="margin:5px 0;color:var(--pink)">{{ $totalUsers }}</h2>
    </div>
</div>

<div class="card" style="margin-bottom:15px">
    <div class="p" style="border-bottom:1px solid var(--line)">
        <h3 style="margin:0">All Projects</h3>
    </div>

    @forelse($allProjects as $project)
        <div style="border-bottom:1px solid var(--line)">
            <div class="task">
                <div style="flex:1">
                    <p class="title" style="margin:0">{{ $project->name }}</p>
                    <small class="muted">{{ $project->owner->username }} &middot; {{ $project->tasks->count() }} tasks</small>
                </div>
                <small class="muted">{{ $project->status }}</small>
            </div>

            @forelse($project->tasks as $task)
                <div class="task" style="padding-left:28px">
                    <div class="dot {{ $task->status == 'done' ? 'done' : '' }}"></div>
                    <div style="flex:1">
                        <p class="title {{ $task->status == 'done' ? 'done' : '' }}" style="margin:0;font-size:14px">{{ $task->title }}</p>
                        <small class="muted">{{ $task->assignee?->username ?? 'Unassigned' }} &middot; {{ $task->status }}</small>
                    </div>
                </div>
            @empty
                <p class="muted" style="padding:10px 28px;margin:0;font-size:13px">No tasks.</p>
            @endforelse
        </div>
    @empty
        <div class="p muted">No projects.</div>
    @endforelse
</div>

<div class="card">
    <div class="p" style="border-bottom:1px solid var(--line)">
        <h3 style="margin:0">All Users</h3>
    </div>

    @forelse($allUsers as $user)
        <div class="task">
            <div style="flex:1">
                <p class="title" style="margin:0">{{ $user->username }}</p>
                <small class="muted">{{ $user->email }}</small>
            </div>
            <small class="muted" style="color:{{ $user->role == 'super_admin' ? '#ec4899' : '#6b7280' }}">
                {{ $user->role }}
            </small>
        </div>
    @empty
        <div class="p muted">No users.</div>
    @endforelse
</div>

@endsection