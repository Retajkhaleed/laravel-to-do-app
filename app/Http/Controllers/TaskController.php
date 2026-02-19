<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Project;
use App\Http\Requests\TaskRequest;

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

        if (empty($validated['project_id'])) {
            $validated['assigned_to'] = auth()->id();
        }

        $validated['status'] = $validated['status'] ?? 'todo';

        Task::create($validated);

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
}