<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class TaskController extends Controller
{
    use AuthorizesRequests; // ✅ Ini WAJIB ditambahkan

    /**
     * Authorize user access to the project.
     */
    private function authorizeProjectAccess(Project $project)
    {
        if ($project->user_id !== Auth::id() && !$project->members->contains(Auth::id())) {
            abort(403, 'Unauthorized action.');
        }
    }

    /**
     * Display a listing of tasks for a specific project.
     */
    public function index(Project $project)
    {
        $this->authorizeProjectAccess($project);

        $tasks = $project->tasks()->orderBy('created_at', 'desc')->paginate(10);
        return view('tasks.index', compact('project', 'tasks'));
    }

    /**
     * Show the form for creating a new task.
     */
    public function create(Project $project)
    {
        if ($project->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        return view('tasks.create', compact('project'));
    }

    /**
     * Store a newly created task in storage.
     */
    public function store(Request $request, Project $project)
    {
        if ($project->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:todo,in_progress,done',
            'due_date' => 'nullable|date',
        ]);

        $project->tasks()->create($request->all());

        return redirect()->route('projects.show', $project)->with('success', 'Task created successfully.');
    }

    /**
     * Display the specified task.
     */
    public function show(Project $project, Task $task)
    {
        $this->authorizeProjectAccess($project);

        if ($task->project_id !== $project->id) {
            abort(403, 'Unauthorized action.');
        }

        return view('tasks.show', compact('project', 'task'));
    }

    /**
     * Show the form for editing the specified task.
     */
    public function edit(Project $project, Task $task)
    {
        if ($project->user_id !== Auth::id() || $task->project_id !== $project->id) {
            abort(403, 'Unauthorized action.');
        }
        return view('tasks.edit', compact('project', 'task'));
    }

    /**
     * Update the specified task in storage.
     */
public function update(Request $request, Project $project, Task $task)
{
    $this->authorize('update', $task);

    $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'status' => 'required|in:todo,in_progress,done',
        'due_date' => 'nullable|date',
    ]);

    $task->update($request->only(['name', 'description', 'status', 'due_date']));

    return redirect()->route('projects.show', $project)->with('success', 'Tugas berhasil diperbarui.');
}

public function updateStatus(Request $request, Project $project, Task $task)
{
    $this->authorize('updateStatus', $task);

    $request->validate([
        'status' => 'required|in:todo,in_progress,done',
    ]);

    $task->update(['status' => $request->status]);

    return redirect()->route('projects.show', $project)->with('success', 'Status tugas diperbarui.');
}



}
