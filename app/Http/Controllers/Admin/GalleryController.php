<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Gallery;
use App\Models\GalleryCategory;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    public function index()
    {
        $galleries = Gallery::with('category')->latest()->paginate(10);
        return view('admin.galleries.index', compact('galleries'));
    }

    public function create()
    {
        $categories = GalleryCategory::all();
        return view('admin.galleries.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date' => 'nullable|date',
            'type' => 'required|in:photo,video',
            'file_upload' => 'nullable|file|mimes:jpeg,png,jpg,gif,mp4,mov,avi|max:20480',
            'video_id' => 'nullable|string|max:255',
            'gallery_category_id' => 'nullable|exists:gallery_categories,id',
        ]);

        $filePath = null;
        $videoId = null;

        if ($validatedData['type'] === 'photo' && $request->hasFile('file_upload')) {
            $filePath = $request->file('file_upload')->store('gallery_images', 'public');
        }

        if ($validatedData['type'] === 'video') {
            if ($request->hasFile('file_upload')) {
                $filePath = $request->file('file_upload')->store('gallery_videos', 'public');
            } elseif (!empty($validatedData['video_id'])) {
                $videoId = $validatedData['video_id'];
            }
        }

        Gallery::create([
            'title' => $validatedData['title'],
            'description' => $validatedData['description'] ?? null,
            'type' => $validatedData['type'],
            'file_path' => $filePath,
            'video_id' => $videoId,
            'thumbnail_path' => null,
            'gallery_category_id' => $validatedData['gallery_category_id'] ?? null,
            'date' => $validatedData['date'] ?? null,
        ]);

        return redirect()->route('admin.galleries.index')->with('success', 'Item galeri berhasil ditambahkan!');
    }

    public function show(string $id)
    {
        return redirect()->route('admin.galleries.edit', $id);
    }

    public function edit(string $id)
    {
        $gallery = Gallery::findOrFail($id);
        $categories = GalleryCategory::all();
        return view('admin.galleries.edit', compact('gallery', 'categories'));
    }

    public function update(Request $request, string $id)
    {
        $gallery = Gallery::findOrFail($id);

        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:photo,video',
            'date' => 'nullable|date',
            'file_upload' => 'nullable|file|mimes:jpeg,png,jpg,gif,mp4,mov,avi|max:20480',
            'video_id' => 'nullable|string|max:255',
            'gallery_category_id' => 'nullable|exists:gallery_categories,id',
        ]);

        $filePath = $gallery->file_path;
        $videoId = $gallery->video_id;

        if ($validatedData['type'] === 'photo') {
            if ($request->hasFile('file_upload')) {
                if ($gallery->type === 'photo' && $filePath) {
                    Storage::disk('public')->delete($filePath);
                }
                $filePath = $request->file('file_upload')->store('gallery_images', 'public');
            }
            $videoId = null; // Clear video_id when type is photo
        } elseif ($validatedData['type'] === 'video') {
            if ($request->hasFile('file_upload')) {
                if ($gallery->type === 'photo' && $filePath) {
                    Storage::disk('public')->delete($filePath);
                }
                $filePath = $request->file('file_upload')->store('gallery_videos', 'public');
                $videoId = null; // Clear video_id when uploading file
            } elseif (!empty($validatedData['video_id'])) {
                if ($gallery->type === 'photo' && $filePath) {
                    Storage::disk('public')->delete($filePath);
                }
                $filePath = null; // Clear file_path when using video_id
                $videoId = $validatedData['video_id'];
            }
        }

        $gallery->update([
            'title' => $validatedData['title'],
            'description' => $validatedData['description'] ?? null,
            'type' => $validatedData['type'],
            'file_path' => $filePath,
            'video_id' => $videoId,
            'thumbnail_path' => null,
            'gallery_category_id' => $validatedData['gallery_category_id'] ?? $gallery->gallery_category_id,
            'date' => $validatedData['date'] ?? null,
        ]);

        return redirect()->route('admin.galleries.index')->with('success', 'Item galeri berhasil diperbarui!');
    }

    public function destroy(string $id)
    {
        $gallery = Gallery::findOrFail($id);

        if ($gallery->type === 'photo' && $gallery->file_path) {
            Storage::disk('public')->delete($gallery->file_path);
        }

        $gallery->delete();

        return redirect()->route('admin.galleries.index')->with('success', 'Item galeri berhasil dihapus!');
    }
}
