<?php

namespace App\Http\Controllers\Admin; // PASTIKAN NAMESPACE INI

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event; // Import Model Event
use Illuminate\Support\Facades\Storage; // Untuk upload dan hapus foto

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     * Menampilkan daftar semua kegiatan di halaman admin.
     */
    public function index()
    {
        // Mengambil semua data kegiatan terbaru, bisa ditambahkan paginasi
        $events = Event::latest('date')->paginate(10); // Urutkan berdasarkan tanggal terbaru
        return view('admin.events.index', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     * Menampilkan form untuk menambah data kegiatan baru.
     */
    public function create()
    {
        return view('admin.events.create');
    }

    /**
     * Store a newly created resource in storage.
     * Menyimpan data kegiatan baru dari form ke database.
     */
    public function store(Request $request)
    {
        // Validasi data input dari form
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'date' => 'required|date',
            'time' => 'nullable|string|max:255', // Menggunakan string untuk fleksibilitas format waktu
            'location' => 'nullable|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Gambar, max 2MB
        ]);

        $photoPath = null;
        // Proses upload foto jika ada
        if ($request->hasFile('photo')) {
            // Menyimpan gambar ke storage/app/public/event_photos
            $photoPath = $request->file('photo')->store('event_photos', 'public');
        }

        // Simpan data kegiatan baru ke database
        Event::create([
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
            'date' => $validatedData['date'],
            'time' => $validatedData['time'],
            'location' => $validatedData['location'],
            'photo' => $photoPath,
        ]);

        return redirect()->route('admin.events.index')->with('success', 'Data kegiatan berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     * Biasanya tidak perlu view terpisah di admin, bisa redirect ke form edit.
     */
    public function show(string $id)
    {
        return redirect()->route('admin.events.edit', $id);
    }

    /**
     * Show the form for editing the specified resource.
     * Menampilkan form untuk mengedit data kegiatan yang sudah ada.
     */
    public function edit(string $id)
    {
        $event = Event::findOrFail($id); // Temukan kegiatan berdasarkan ID
        return view('admin.events.edit', compact('event'));
    }

    /**
     * Update the specified resource in storage.
     * Mengupdate data kegiatan yang sudah ada di database.
     */
    public function update(Request $request, string $id)
    {
        $event = Event::findOrFail($id); // Temukan kegiatan berdasarkan ID

        // Validasi data input
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'date' => 'required|date',
            'time' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $photoPath = $event->photo; // Pertahankan path foto lama secara default
        // Proses upload foto baru jika ada
        if ($request->hasFile('photo')) {
            // Hapus foto lama jika ada
            if ($photoPath) {
                Storage::disk('public')->delete($photoPath);
            }
            $photoPath = $request->file('photo')->store('event_photos', 'public');
        }

        // Update data kegiatan di database
        $event->update([
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
            'date' => $validatedData['date'],
            'time' => $validatedData['time'],
            'location' => $validatedData['location'],
            'photo' => $photoPath,
        ]);

        return redirect()->route('admin.events.index')->with('success', 'Data kegiatan berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     * Menghapus data kegiatan dari database.
     */
    public function destroy(string $id)
    {
        $event = Event::findOrFail($id); // Temukan kegiatan berdasarkan ID

        // Hapus foto terkait jika ada
        if ($event->photo) {
            Storage::disk('public')->delete($event->photo);
        }

        // Hapus kegiatan dari database
        $event->delete();

        return redirect()->route('admin.events.index')->with('success', 'Data kegiatan berhasil dihapus!');
    }
}
