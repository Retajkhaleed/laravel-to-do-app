<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;

class AdminController extends Controller
{
    public function dashboard()
    {
        //calculate 
        $totalProjects     = Project::count();
        $completedProjects = Project::where('status', 'done')->count();
        $totalTasks        = Task::count();
        $completedTasks    = Task::where('status', 'done')->count();
        $totalUsers        = User::count();
        $allProjects = Project::with([
            'owner:id,username',
            'tasks.assignee:id,username'
        ])->latest()->get();

        $allUsers = User::with(['ownedProjects', 'assignedTasks'])
            ->latest()
            ->get();

        return view('admin.dashboard', compact(
            'totalProjects',
            'completedProjects',
            'totalTasks',
            'completedTasks',
            'totalUsers',
            'allProjects',
            'allUsers'
        ));
    }
}