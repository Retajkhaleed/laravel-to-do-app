<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TaskPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Task $task): bool
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
 public function update(User $user, Task $task)
{
    if ($user->isSuperAdmin()) return true;
    if ($task->assigned_to == $user->id) return true;
    if ($task->project && $task->project->owner_id == $user->id) return true;
    if ($task->project && $task->project->members->contains($user->id)) return true;
    return false;
}

public function delete(User $user, Task $task)
{
    if ($user->isSuperAdmin()) return true;
    if ($task->project && $task->project->owner_id == $user->id) return true;
    return false;
}
    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Task $task): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Task $task): bool
    {
        return false;
    }
}
