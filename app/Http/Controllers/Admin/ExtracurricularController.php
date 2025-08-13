<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Extracurricular;
use Illuminate\Support\Facades\Storage;

class ExtracurricularController extends Controller
{
    public function index()
    {
        $extracurriculars = Extracurricular::latest()->paginate(10);
        return view('admin.extracurriculars.index', compact('extracurriculars'));
    }

    public function create()
    {
        return view('admin.extracurriculars.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:500', // ← Batas maksimal 500 karakter
            'schedule' => 'nullable|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('extracurricular_photos', 'public');
        }

        Extracurricular::create([
            'name' => $validatedData['name'],
            'description' => $validatedData['description'],
            'schedule' => $validatedData['schedule'],
            'photo' => $photoPath,
        ]);

        return redirect()->route('admin.extracurriculars.index')
            ->with('success', 'Data ekstrakurikuler berhasil ditambahkan!');
    }

    public function show(string $id)
    {
        return redirect()->route('admin.extracurriculars.edit', $id);
    }

    public function edit(string $id)
    {
        $extracurricular = Extracurricular::findOrFail($id);
        return view('admin.extracurriculars.edit', compact('extracurricular'));
    }

    public function update(Request $request, string $id)
    {
        $extracurricular = Extracurricular::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:500', // ← Batas maksimal 500 karakter
            'schedule' => 'nullable|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $photoPath = $extracurricular->photo;
        if ($request->hasFile('photo')) {
            if ($photoPath) {
                Storage::disk('public')->delete($photoPath);
            }
            $photoPath = $request->file('photo')->store('extracurricular_photos', 'public');
        }

        $extracurricular->update([
            'name' => $validatedData['name'],
            'description' => $validatedData['description'],
            'schedule' => $validatedData['schedule'],
            'photo' => $photoPath,
        ]);

        return redirect()->route('admin.extracurriculars.index')
            ->with('success', 'Data ekstrakurikuler berhasil diperbarui!');
    }

    public function destroy(string $id)
    {
        $extracurricular = Extracurricular::findOrFail($id);

        if ($extracurricular->photo) {
            Storage::disk('public')->delete($extracurricular->photo);
        }

        $extracurricular->delete();

        return redirect()->route('admin.extracurriculars.index')
            ->with('success', 'Data ekstrakurikuler berhasil dihapus!');
    }
}
