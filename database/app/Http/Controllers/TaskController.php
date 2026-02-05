<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index() {
        $tasks = Task::latest()->get();
        return view('tasks.index', compact('tasks'));
    }

    public function store(Request $request)
{
    $request->validate([
        'title' => 'required|min:2',
        'description' => 'nullable|max:1000',
    ]);

    Task::create([
        'title' => $request->title,
        'description' => $request->description,
    ]);

    return back()->with('success', 'Task added ✅');
}

    public function update(Request $request, Task $task)
{
    $request->validate([
        'title' => 'required|min:2',
        'description' => 'nullable',
    ]);

    $task->update($request->only('title', 'description'));

    return back()->with('success', 'Task updated');
}

    public function destroy(Task $task) {
        $task->delete();
        return back();
    }

    public function toggle(Task $task) {
        $task->update(['is_done' => !$task->is_done]);
        return back();
    }
}