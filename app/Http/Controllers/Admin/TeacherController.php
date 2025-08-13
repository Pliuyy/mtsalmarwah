<?php

namespace App\Http\Controllers\Admin; // PASTIKAN NAMESPACE INI

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Teacher; // Import Model Teacher
use Illuminate\Support\Str; // Untuk slug jika diperlukan, atau bisa dihapus jika tidak ada slug
use Illuminate\Support\Facades\Storage; // Untuk upload dan hapus foto

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     * Menampilkan daftar semua guru di halaman admin.
     */
    public function index()
    {
        // Mengambil semua data guru, bisa ditambahkan paginasi
        $teachers = Teacher::latest()->paginate(10);
        return view('admin.teachers.index', compact('teachers'));
    }

    /**
     * Show the form for creating a new resource.
     * Menampilkan form untuk menambah data guru baru.
     */
    public function create()
    {
        return view('admin.teachers.create');
    }

    /**
     * Store a newly created resource in storage.
     * Menyimpan data guru baru dari form ke database.
     */
    public function store(Request $request)
    {
        // Validasi data input dari form
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'published_at' => 'nullable|date',
            'subject' => 'required|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Gambar, max 2MB
            'bio' => 'nullable|string',
        ]);

        $photoPath = null;
        // Proses upload foto jika ada
        if ($request->hasFile('photo')) {
            // Menyimpan gambar ke storage/app/public/teacher_photos
            $photoPath = $request->file('photo')->store('teacher_photos', 'public');
        }

        // Simpan data guru baru ke database
        Teacher::create([
            'name' => $validatedData['name'],
            'published_at' => $validatedData['published_at'] ?? now(),
            'subject' => $validatedData['subject'],
            'photo' => $photoPath,
            'bio' => $validatedData['bio'],
        ]);

        return redirect()->route('admin.teachers.index')->with('success', 'Data guru berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     * Biasanya tidak perlu view terpisah di admin, bisa redirect ke form edit.
     */
    public function show(string $id)
    {
        return redirect()->route('admin.teachers.edit', $id);
    }

    /**
     * Show the form for editing the specified resource.
     * Menampilkan form untuk mengedit data guru yang sudah ada.
     */
    public function edit(string $id)
    {
        $teacher = Teacher::findOrFail($id); // Temukan guru berdasarkan ID
        return view('admin.teachers.edit', compact('teacher'));
    }

    /**
     * Update the specified resource in storage.
     * Mengupdate data guru yang sudah ada di database.
     */
    public function update(Request $request, string $id)
    {
        $teacher = Teacher::findOrFail($id); // Temukan guru berdasarkan ID

        // Validasi data input
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'published_at' => 'nullable|date',
            'subject' => 'required|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'bio' => 'nullable|string',
        ]);

        $photoPath = $teacher->photo; // Pertahankan path foto lama secara default
        // Proses upload foto baru jika ada
        if ($request->hasFile('photo')) {
            // Hapus foto lama jika ada
            if ($photoPath) {
                Storage::disk('public')->delete($photoPath);
            }
            $photoPath = $request->file('photo')->store('teacher_photos', 'public');
        }

        // Update data guru di database
        $teacher->update([
            'name' => $validatedData['name'],
            'published_at' => $validatedData['published_at'] ?? now(),
            'is_active' => true,
            'subject' => $validatedData['subject'],
            'photo' => $photoPath,
            'bio' => $validatedData['bio'],
        ]);

        return redirect()->route('admin.teachers.index')->with('success', 'Data guru berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     * Menghapus data guru dari database.
     */
    public function destroy(string $id)
    {
        $teacher = Teacher::findOrFail($id); // Temukan guru berdasarkan ID

        // Hapus foto terkait jika ada
        if ($teacher->photo) {
            Storage::disk('public')->delete($teacher->photo);
        }

        // Hapus guru dari database
        $teacher->delete();

        return redirect()->route('admin.teachers.index')->with('success', 'Data guru berhasil dihapus!');
    }
}
