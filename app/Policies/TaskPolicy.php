<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;

class TaskPolicy
{
    /**
     * Determine if the user can update the full task (only owner).
     */
    public function update(User $user, Task $task): bool
    {
        return $user->id === $task->project->user_id;
    }

    /**
     * Determine if the user can update only the status (team member or owner).
     */
    public function updateStatus(User $user, Task $task): bool
    {
        $project = $task->project;
        return $user->id === $project->user_id || $project->members->contains($user->id);
    }

    /**
     * Determine if the user can delete the task.
     */
    public function delete(User $user, Task $task): bool
    {
        return $user->id === $task->project->user_id;
    }

    /**
     * Determine if the user can view the task.
     */
    public function view(User $user, Task $task): bool
    {
        $project = $task->project;
        return $user->id === $project->user_id || $project->members->contains($user->id);
    }
}
