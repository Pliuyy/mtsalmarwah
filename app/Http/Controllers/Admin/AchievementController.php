<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Achievement;
use Illuminate\Support\Facades\Storage;

class AchievementController extends Controller
{
    public function index()
    {
        $achievements = Achievement::latest()->paginate(10);
        return view('admin.achievements.index', compact('achievements'));
    }

    public function create()
    {
        return view('admin.achievements.create');
    }

    public function store(Request $request)
    {
        // Validasi data input dari form
        $validatedData = $request->validate([
            'student_name' => 'required|string|max:255',
            'achievement' => 'required|string|max:255',
            'published_at' => 'nullable|date',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Gambar, max 2MB
        ]);

        $photoPath = null;
        // Proses upload foto jika ada
        if ($request->hasFile('photo')) {
            // Menyimpan gambar ke storage/app/public/achievement_photos
            $photoPath = $request->file('photo')->store('achievement_photos', 'public');
        }

        // Simpan data staf baru ke database
        Achievement::create([
            'student_name' => $validatedData['student_name'],
            'achievement' => $validatedData['achievement'],
            'photo' => $photoPath,
            'published_at' => $validatedData['published_at'] ?? now(),
        ]);

        return redirect()->route('admin.achievements.index')->with('success', 'Data murid berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     * Biasanya tidak perlu view terpisah di admin, bisa redirect ke form edit.
     */
    public function show(string $id)
    {
        return redirect()->route('admin.achievements.edit', $id);
    }

    /**
     * Show the form for editing the specified resource.
     * Menampilkan form untuk mengedit data staf yang sudah ada.
     */
    public function edit(string $id)
    {
        $achievement = Achievement::findOrFail($id); // Temukan achievement berdasarkan ID
        return view('admin.achievements.edit', compact('achievement'));
    }

    /**
     * Update the specified resource in storage.
     * Mengupdate data staf yang sudah ada di database.
     */
    public function update(Request $request, string $id)
    {
        $achievement = Achievement::findOrFail($id); // Temukan staf berdasarkan ID

        // Validasi data input
        $validatedData = $request->validate([
            'student_name' => 'required|string|max:255',
            'achievement' => 'required|string|max:255',
            'published_at' => 'nullable|date',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $photoPath = $achievement->photo; // Pertahankan path foto lama secara default
        // Proses upload foto baru jika ada
        if ($request->hasFile('photo')) {
            // Hapus foto lama jika ada
            if ($photoPath) {
                Storage::disk('public')->delete($photoPath);
            }
            $photoPath = $request->file('photo')->store('achievement_photos', 'public');
        }

        // Update data staf di database
        $achievement->update([
            'student_name' => $validatedData['student_name'],
            'achievement' => $validatedData['achievement'],
            'photo' => $photoPath,
            'published_at' => $validatedData['published_at'] ?? now(),
        ]);

        return redirect()->route('admin.achievements.index')->with('success', 'Data murid berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     * Menghapus data staf dari database.
     */
    public function destroy(string $id)
    {
        $achievement = Achievement::findOrFail($id); // Temukan staf berdasarkan ID

        // Hapus foto terkait jika ada
        if ($achievement->photo) {
            Storage::disk('public')->delete($achievement->photo);
        }

        // Hapus staf dari database
        $achievement->delete();

        return redirect()->route('admin.achievements.index')->with('success', 'Data murid berhasil dihapus!');
    }
}
