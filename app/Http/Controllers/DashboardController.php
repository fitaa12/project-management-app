<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Project;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Proyek yang dimiliki oleh user
        $ownedProjects = Project::where('user_id', $user->id)->get();

        // Proyek yang ditugaskan (dari relasi belongsToMany)
        $assignedProjects = $user->projects()->get();

        // Gabungkan semua proyek, hilangkan duplikat
        $allProjects = $ownedProjects->merge($assignedProjects)->unique('id');

        // Hitung berdasarkan status
        $totalProjects = $allProjects->count();
        $completedProjects = $allProjects->where('status', 'completed')->count();
        $cancelledProjects = $allProjects->where('status', 'cancelled')->count();
        $runningProjects = $allProjects->where('status', 'in_progress')->count();
        $pendingProjects = $allProjects->where('status', 'pending')->count();

        // Monitoring = proyek yang berjalan atau pending
        $projectsForMonitoring = $allProjects->filter(function ($project) {
            return in_array($project->status, ['in_progress', 'pending']);
        });

        // Urgent = deadline hari ini
        $urgentProjects = $allProjects->filter(function ($project) {
            return \Carbon\Carbon::parse($project->end_date)->isToday();
        });

        return view('dashboard', compact(
            'totalProjects',
            'completedProjects',
            'cancelledProjects',
            'runningProjects',
            'pendingProjects',
            'projectsForMonitoring',
            'urgentProjects'
        ));
    }
}
