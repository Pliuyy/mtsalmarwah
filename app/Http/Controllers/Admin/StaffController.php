<?php

namespace App\Http\Controllers\Admin; // PASTIKAN NAMESPACE INI

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Staff; // Import Model Staff
use Illuminate\Support\Facades\Storage; // Untuk upload dan hapus foto

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     * Menampilkan daftar semua staf di halaman admin.
     */
    public function index()
    {
        // Mengambil semua data staf, bisa ditambahkan paginasi
        $staffs = Staff::latest()->paginate(10);
        return view('admin.staffs.index', compact('staffs'));
    }

    /**
     * Show the form for creating a new resource.
     * Menampilkan form untuk menambah data staf baru.
     */
    public function create()
    {
        return view('admin.staffs.create');
    }

    /**
     * Store a newly created resource in storage.
     * Menyimpan data staf baru dari form ke database.
     */
    public function store(Request $request)
    {
        // Validasi data input dari form
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'published_at' => 'nullable|date',
            'position' => 'required|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Gambar, max 2MB
            'bio' => 'nullable|string',
        ]);

        $photoPath = null;
        // Proses upload foto jika ada
        if ($request->hasFile('photo')) {
            // Menyimpan gambar ke storage/app/public/staff_photos
            $photoPath = $request->file('photo')->store('staff_photos', 'public');
        }

        // Simpan data staf baru ke database
        Staff::create([
            'name' => $validatedData['name'],
            'published_at' => $validatedData['published_at'] ?? now(),
            'position' => $validatedData['position'],
            'photo' => $photoPath,
            'bio' => $validatedData['bio'],
        ]);

        return redirect()->route('admin.staffs.index')->with('success', 'Data staf berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     * Biasanya tidak perlu view terpisah di admin, bisa redirect ke form edit.
     */
    public function show(string $id)
    {
        return redirect()->route('admin.staffs.edit', $id);
    }

    /**
     * Show the form for editing the specified resource.
     * Menampilkan form untuk mengedit data staf yang sudah ada.
     */
    public function edit(string $id)
    {
        $staff = Staff::findOrFail($id); // Temukan staf berdasarkan ID
        return view('admin.staffs.edit', compact('staff'));
    }

    /**
     * Update the specified resource in storage.
     * Mengupdate data staf yang sudah ada di database.
     */
    public function update(Request $request, string $id)
    {
        $staff = Staff::findOrFail($id); // Temukan staf berdasarkan ID

        // Validasi data input
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'published_at' => 'nullable|date',
            'position' => 'required|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'bio' => 'nullable|string',
        ]);

        $photoPath = $staff->photo; // Pertahankan path foto lama secara default
        // Proses upload foto baru jika ada
        if ($request->hasFile('photo')) {
            // Hapus foto lama jika ada
            if ($photoPath) {
                Storage::disk('public')->delete($photoPath);
            }
            $photoPath = $request->file('photo')->store('staff_photos', 'public');
        }

        // Update data staf di database
        $staff->update([
            'name' => $validatedData['name'],
            'published_at' => $validatedData['published_at'] ?? now(),
            'position' => $validatedData['position'],
            'photo' => $photoPath,
            'bio' => $validatedData['bio'],
        ]);

        return redirect()->route('admin.staffs.index')->with('success', 'Data staf berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     * Menghapus data staf dari database.
     */
    public function destroy(string $id)
    {
        $staff = Staff::findOrFail($id); // Temukan staf berdasarkan ID

        // Hapus foto terkait jika ada
        if ($staff->photo) {
            Storage::disk('public')->delete($staff->photo);
        }

        // Hapus staf dari database
        $staff->delete();

        return redirect()->route('admin.staffs.index')->with('success', 'Data staf berhasil dihapus!');
    }
}
