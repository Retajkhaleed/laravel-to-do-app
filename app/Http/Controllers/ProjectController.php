<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;
use App\Notifications\ProjectInvitedNotification;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        $u = auth()->user();

        $projects = Project::query()
            ->when(!$u->isSuperAdmin(), function ($q) use ($u) {
                $q->where('owner_id', $u->id)
                  ->orWhereHas('members', fn($m) => $m->where('users.id', $u->id));
            })
            ->with([
                'owner:id,username',
                'members:id,username,email',
                'tasks.assignee:id,username'
            ])
            ->latest()
            ->get();

        return view('projects.index', compact('projects'));
    }

    public function create()
    {
        return view('projects.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|min:2',
            'description' => 'nullable|max:2000',
        ]);

        $data['owner_id'] = auth()->id();
        $data['status'] = 'todo';

        Project::create($data);

        return redirect()->route('dashboard')->with('success', 'Project created');
    }

    public function show(Project $project)
    {
        $this->authorize('view', $project);

        $project->load(['owner', 'members', 'tasks.assignee']);

        return view('projects.show', compact('project'));
    }

    public function edit(Project $project)
    {
        $this->authorize('update', $project);

        return view('projects.edit', compact('project'));
    }

    public function update(Request $request, Project $project)
    {
        $this->authorize('update', $project);

        $data = $request->validate([
            'name'        => 'required|min:2|max:255',
            'description' => 'nullable|max:2000',
        ]);

        $project->update($data);

        return redirect()->route('dashboard')->with('success', 'Project updated');
    }

    public function destroy(Project $project)
    {
        $this->authorize('delete', $project);

        $project->delete();

        return redirect()->route('dashboard')->with('success', 'Project deleted');
    }

    public function toggleStatus(Project $project)
    {
        $this->authorize('update', $project);

        $next = match ($project->status) {
            'todo'      => 'in_progress',
            'in_progress' => 'done',
            default       => 'todo',
        };

        $project->update(['status' => $next]);

        return back();
    }

    public function addMember(Request $request, Project $project)
    {
        $this->authorize('addMember', $project);

        $data = $request->validate([
            'username' => 'required|string'
        ]);

        $user = User::where('username', $data['username'])->first();

        if (!$user)
            return back()->with('error', 'User not found');

        if ($user->id == $project->owner_id)
            return back()->with('error', 'Owner already leader');

        $project->members()->syncWithoutDetaching([$user->id]);

        $user->notify(new ProjectInvitedNotification($project, auth()->user()));

        return back()->with('success', 'Member added');
    }

    public function myProjects()
    {
        $projects = Project::where('owner_id', auth()->id())
            ->with(['tasks'])
            ->latest()
            ->get();

        return view('projects.index', compact('projects'));
    }

    public function sharedProjects()
    {
        $projects = auth()->user()->projects()
            ->with(['owner:id,username', 'tasks'])
            ->latest()
            ->get();

        return view('projects.index', compact('projects'));
    }
}