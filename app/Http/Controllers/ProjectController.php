<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Response;

class ProjectController extends Controller
 {
    use AuthorizesRequests; 
    /**
     * Show the dashboard with project statistics.
     */
public function dashboard()
    {
    $user = Auth::user();

    $allProjects = Project::where(function ($query) use ($user) {
        $query->where('user_id', $user->id)
              ->orWhereHas('members', function ($q) use ($user) {
                  $q->where('user_id', $user->id);
              });
    });

    $totalProjects = (clone $allProjects)->count();
    $completedProjects = (clone $allProjects)->where('status', 'completed')->count();
    $runningProjects = (clone $allProjects)->where('status', 'in_progress')->count();
    $pendingProjects = (clone $allProjects)->where('status', 'pending')->count();
    $cancelledProjects = (clone $allProjects)->where('status', 'cancelled')->count();

    $projectsForMonitoring = (clone $allProjects)
        ->whereIn('status', ['in_progress', 'pending'])
        ->orderBy('end_date')
        ->get();

    $urgentProjects = (clone $allProjects)
        ->whereIn('status', ['pending', 'in_progress'])
        ->where('end_date', '<=', Carbon::now()->addDays(7))
        ->orderBy('end_date')
        ->get();

    return view('dashboard', compact(
        'totalProjects',
        'completedProjects',
        'runningProjects',
        'pendingProjects',
        'cancelledProjects',
        'projectsForMonitoring',
        'urgentProjects'
    ));

    }

    /**
     * Cek akses user terhadap proyek.
     */
  protected function authorizeProjectAccess($project)
    {
    $isOwner = $project->user_id === Auth::id();
    $isTeamMember = $project->members && $project->members->contains(Auth::id());

    if (! $isOwner && ! $isTeamMember) {
        abort(403, 'Anda tidak memiliki akses ke proyek ini.');
    }
    }

   public function index()
    {
    $user = Auth::user();

    $projects = Project::where(function ($query) use ($user) {
        $query->where('user_id', $user->id)
              ->orWhereHas('members', function ($q) use ($user) {
                  $q->where('user_id', $user->id);
              });
    })
    ->with('team')
    ->latest()
    ->paginate(10);

    return view('projects.index', compact('projects'));
    }



    public function create()
    {
        $teams = User::all(); // ambil semua user untuk dropdown tim
        return view('projects.create', compact('teams'));
    }

   public function store(Request $request)
    {
    $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'start_date' => 'nullable|date',
        'end_date' => 'nullable|date|after_or_equal:start_date',
        'status' => 'required|in:pending,in_progress,completed,cancelled',
    ]);

    $projectData = $request->only(['name', 'description', 'start_date', 'end_date', 'status']);
    $projectData['user_id'] = Auth::id(); // ✅ Ini yang ditambahkan

    Project::create($projectData); // ⬅️ Gunakan ini, bukan $request->all()

    return redirect()->route('projects.index')->with('success', 'Project created successfully.');
    }

    public function show(Project $project)
    {
    $users = User::all(); // <--- penting!
    return view('projects.show', compact('project', 'users'));
    }


    public function edit(Project $project)
    {
        $this->authorize('update', $project);
        return view('projects.edit', compact('project'));
    }

    public function update(Request $request, Project $project)
    {
        $this->authorize('update', $project);

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'status' => 'required|in:pending,in_progress,completed,cancelled',
        ]);

        $project->update($request->all());

        return redirect()->route('projects.index')->with('success', 'Project updated successfully.');
    }

    public function destroy(Project $project)
    {
        if ($project->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $project->delete();
        return redirect()->route('projects.index')->with('success', 'Project deleted successfully.');
    }

    public function addMember(Request $request, Project $project)
    {
        if ($project->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $user = User::findOrFail($request->user_id);

        if (!$project->members->contains($user)) {
            $project->members()->attach($user->id);
            return redirect()->route('projects.show', $project)->with('success', 'Member added successfully.');
        }

        return redirect()->route('projects.show', $project)->with('info', 'User is already a member of this project.');
    }

    public function removeMember(Project $project, User $user)
    {
        if ($project->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $project->members()->detach($user->id);
        return redirect()->route('projects.show', $project)->with('success', 'Member removed successfully.');
    }
}
