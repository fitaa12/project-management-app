<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

     protected $fillable = [
        'team_id',
        'user_id',
        'name',
        'description',
        'start_date',
        'end_date',
        'status',
    ];

    public function user()
{
    return $this->belongsTo(User::class);
}


    // Relasi: Project milik sebuah Team
    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    // Relasi: Project memiliki banyak Tasks
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    // Relasi: Project memiliki banyak User (anggota team)
    public function members()
    {
        return $this->belongsToMany(User::class, 'project_user'); // nama pivot table
    }

    public function owner()
    {
    return $this->belongsTo(User::class, 'user_id');
    }

    // Atribut mutator untuk mendapatkan persentase progres
    public function getProgressPercentageAttribute()
    {
        $totalTasks = $this->tasks()->count();
        if ($totalTasks === 0) {
            return 0;
        }
        $completedTasks = $this->tasks()->where('status', 'done')->count();
        return round(($completedTasks / $totalTasks) * 100);
    }
}