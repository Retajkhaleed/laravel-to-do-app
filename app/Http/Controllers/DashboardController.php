<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;

class DashboardController extends Controller
{
    public function index()
    {
        $u = auth()->user();

        $myProjects = Project::where('owner_id', $u->id)
            ->with(['tasks.assignee:id,username'])
            ->latest()
            ->get();

        $sharedProjects = $u->projects()
            ->with(['owner:id,username', 'tasks.assignee:id,username'])
            ->latest()
            ->get();

        $myTasks = Task::where('assigned_to', $u->id)
            ->whereNull('project_id')
            ->with('project')
            ->latest()
            ->get();

        return view('dashboard', compact('myProjects', 'sharedProjects', 'myTasks'));
    }
}