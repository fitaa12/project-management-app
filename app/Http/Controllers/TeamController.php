<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Team; // Asumsi Anda memiliki model Team

class TeamController extends Controller
{
    /**
     * Menampilkan daftar semua team.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Menggunakan paginasi untuk mengambil data team
        // Ini lebih efisien untuk jumlah data yang banyak
        $teams = Team::orderBy('name')->paginate(10); // Ambil 10 team per halaman, diurutkan berdasarkan nama

        // Mengirimkan data team ke view 'team.index'
        // CATATAN PENTING: Jika Anda menggunakan controller ini,
        // maka view 'team.index.blade.php' Anda harus mengiterasi variabel '$teams',
        // BUKAN '$users'.
        return view('team.index', compact('teams'));
    }

    /**
     * Menampilkan form untuk membuat team baru.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('team.create');
    }

    /**
     * Menyimpan team baru ke database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validasi data input
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            // Tambahkan validasi lain sesuai kebutuhan
        ]);

        // Buat team baru
        Team::create([
            'name' => $request->name,
            'description' => $request->description,
            // Isi kolom lain sesuai kebutuhan model Team Anda
        ]);

        return redirect()->route('teams.index')->with('success', 'Team berhasil ditambahkan!');
    }

    /**
     * Menampilkan detail team tertentu.
     *
     * @param  \App\Models\Team  $team
     * @return \Illuminate\View\View
     */
    public function show(Team $team)
    {
        // Anda mungkin ingin memuat relasi anggota team di sini jika ada
        // $team->load('members'); // Asumsi ada relasi 'members' di model Team
        return view('team.show', compact('team'));
    }

    /**
     * Menampilkan form untuk mengedit team.
     *
     * @param  \App\Models\Team  $team
     * @return \Illuminate\View\View
     */
    public function edit(Team $team)
    {
        return view('team.edit', compact('team'));
    }

    /**
     * Memperbarui data team di database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Team  $team
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Team $team)
    {
        // Validasi data input
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            // Tambahkan validasi lain sesuai kebutuhan
        ]);

        // Perbarui data team
        $team->update([
            'name' => $request->name,
            'description' => $request->description,
            // Isi kolom lain sesuai kebutuhan model Team Anda
        ]);

        return redirect()->route('teams.index')->with('success', 'Team berhasil diperbarui!');
    }

    /**
     * Menghapus team dari database.
     *
     * @param  \App\Models\Team  $team
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Team $team)
    {
        $team->delete();

        return redirect()->route('teams.index')->with('success', 'Team berhasil dihapus!');
    }
}