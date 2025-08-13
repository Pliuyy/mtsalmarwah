<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GalleryCategory;
use Illuminate\Support\Facades\Storage;

class GalleryCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     * Menampilkan daftar semua kategori galeri di halaman admin.
     */
    public function index()
    {
        // Mengambil semua kategori galeri, diurutkan berdasarkan nama
        $categories = GalleryCategory::orderBy('name')->paginate(10);
        return view('admin.gallery-categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     * Menampilkan form untuk menambah kategori galeri baru.
     */
    public function create()
    {
        return view('admin.gallery-categories.create');
    }

    /**
     * Store a newly created resource in storage.
     * Menyimpan kategori galeri baru dari form ke database.
     */
    public function store(Request $request)
    {
        // Validasi data input dari form
        $request->validate([
            'name' => 'required|string|max:255|unique:gallery_categories,name', // Nama kategori harus unik
        ]);

        // Simpan kategori baru ke database
        GalleryCategory::create([
            'name' => $request->name,
        ]);

        return redirect()->route('admin.gallery-categories.index')->with('success', 'Kategori galeri berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     * Tidak diperlukan karena kita tidak punya halaman show untuk kategori.
     */
    public function show(string $id)
    {
        // Redirect ke edit atau tidak melakukan apa-apa
        return redirect()->route('admin.gallery-categories.edit', $id);
    }

    /**
     * Show the form for editing the specified resource.
     * Menampilkan form untuk mengedit kategori galeri yang sudah ada.
     */
    public function edit(string $id)
    {
        $category = GalleryCategory::findOrFail($id); // Temukan kategori berdasarkan ID
        return view('admin.gallery-categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     * Mengupdate data kategori galeri yang sudah ada di database.
     */
    public function update(Request $request, string $id)
    {
        $category = GalleryCategory::findOrFail($id); // Temukan kategori berdasarkan ID

        // Validasi data input
        $request->validate([
            'name' => 'required|string|max:255|unique:gallery_categories,name,' . $id, // Nama harus unik, kecuali untuk kategori ini sendiri
        ]);

        // Update data kategori di database
        $category->update([
            'name' => $request->name,
        ]);

        return redirect()->route('admin.gallery-categories.index')->with('success', 'Kategori galeri berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     * Menghapus kategori galeri dari database.
     */
    public function destroy(string $id)
    {
        $category = GalleryCategory::findOrFail($id); // Temukan kategori berdasarkan ID

        // Hapus folder gambar terkait jika ada di storage/app/public/gallery_photos/{id}
        $folderPath = 'public/gallery_photos/' . $id;
        if (Storage::exists($folderPath)) {
            Storage::deleteDirectory($folderPath);
        }

        // Hapus kategori dari database
        $category->delete();

        return redirect()->route('admin.gallery-categories.index')->with('success', 'Kategori galeri dan folder terkait berhasil dihapus!');
    }
}
