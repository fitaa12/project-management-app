<?php

namespace App\Http\Controllers;

use App\Models\User; // Pastikan ini diimpor dengan benar
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Pastikan ini diimpor dengan benar

class UserController extends Controller
{
    /**
     * Display a listing of users (for team selection).
     * Menampilkan daftar pengguna (untuk pemilihan team/daftar pengguna).
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Kecuali user yang sedang login
        // Mengambil semua user kecuali user yang sedang login, diurutkan berdasarkan nama,
        // dan dipaginasi 10 item per halaman.
        $users = User::where('id', '!=', Auth::id())
                     ->orderBy('name')
                     ->paginate(10);

        // Mengembalikan view 'team.index' dengan data 'users'.
        // Pastikan Anda memiliki file resources/views/team/index.blade.php
        return view('team.index', compact('users'));
    }

    /**
     * Display the specified user (for team detail if needed, though not explicitly required).
     * Menampilkan detail pengguna tertentu (bisa digunakan untuk detail team jika diperlukan).
     *
     * @param  \App\Models\User  $user  // Laravel secara otomatis mengikat model User berdasarkan ID di URL
     * @return \Illuminate\View\View
     */
    public function show(User $user)
    {
        // Memuat relasi 'assignedProjects' untuk user ini.
        // Ini mengasumsikan bahwa model User Anda memiliki relasi 'assignedProjects'.
        // Contoh di model User.php:
        // public function assignedProjects()
        // {
        //     return $this->belongsToMany(Project::class, 'project_user', 'user_id', 'project_id');
        // }
        $user->load('assignedProjects'); 

        // Mengembalikan view 'team.show' dengan data 'user'.
        // Pastikan Anda memiliki file resources/views/team/show.blade.php
        return view('team.show', compact('user'));
    }
}