<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Project;
use App\Http\Requests\TaskRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Notifications\TaskAssignedNotification;
use Illuminate\Http\Request;



class TaskController extends Controller
{
    public function index()
    {
        $u = auth()->user();

        $tasks = Task::query()
            ->with(['project', 'assignee'])
            ->when(!$u->isSuperAdmin(), function ($q) use ($u) {
                $q->where('assigned_to', $u->id)
                  ->orWhereHas('project', fn($p) => $p->where('owner_id', $u->id));
            })
            ->latest()
            ->get();

        return view('tasks.index', compact('tasks'));
    }

   public function create()
{
    $project = null;
    $members = collect();

    if (request('project')) {
        $project = Project::with('members')->findOrFail(request('project'));
        
        
        $owner = \App\Models\User::find($project->owner_id);
        $members = $project->members->push($owner)->unique('id');
    }

    return view('tasks.create', compact('project', 'members'));
}

    public function store(TaskRequest $request)
{
    $validated = $request->validated();

    if (!empty($validated['project_id'])) {
        $project = Project::findOrFail($validated['project_id']);
        $this->authorize('update', $project);
    }

    if (empty($validated['assigned_to'])) {
        $validated['assigned_to'] = auth()->id();
    }

    $validated['status'] = $validated['status'] ?? 'todo';

    $task = Task::create($validated);

    if (!empty($validated['assigned_to']) && $validated['assigned_to'] !== auth()->id()) {
        $assignee = \App\Models\User::find($validated['assigned_to']);
        $assignee?->notify(new \App\Notifications\TaskAssignedNotification($task));
    }

    return redirect()->route('dashboard')->with('success', 'Task added');
}

    public function edit(Task $task)
    {
        $this->authorize('update', $task);

        $members = collect();
        if ($task->project) {
            $members = $task->project->members;
        }

        return view('tasks.edit', compact('task', 'members'));
    }

    public function update(TaskRequest $request, Task $task)
{
    $this->authorize('update', $task);

    $validated = $request->validated();

    unset($validated['project_id']);

    if (!array_key_exists('assigned_to', $validated)) {
        $validated['assigned_to'] = $task->assigned_to;
    }

    $task->update($validated);

    return redirect()->route('dashboard')->with('success', 'Task updated');
}
    public function destroy(Task $task)
    {
        $this->authorize('update', $task);

        $task->delete();

        return redirect()->route('dashboard')->with('success', 'Task deleted');
    }

   public function toggle(Task $task)
{
    $this->authorize('update', $task);

    $next = match ($task->status) {
        'todo'        => 'in_progress',
        'in_progress' => 'done',
        default       => 'todo',
    };

    $task->update(['status' => $next]);

    return back();
}

public function assign(Request $request, Task $task)
{
    $this->authorize('update', $task);

    $validated = $request->validate([
        'username' => 'required|string'
    ]);

    $user = \App\Models\User::where('username', $validated['username'])->first();

    if (!$user)
        return back()->with('error', 'User not found');

    
    if ($task->project) {
        $task->project->members()->syncWithoutDetaching([$user->id]);
    }

    $task->update(['assigned_to' => $user->id]);

    $user->notify(new TaskAssignedNotification($task));

    return back()->with('success', 'Task assigned');
}

    public function myTasks()
    {
        $tasks = Task::where('assigned_to', auth()->id())
            ->with(['project'])
            ->latest()
            ->get();

        return view('tasks.index', compact('tasks'));
    }
}   
