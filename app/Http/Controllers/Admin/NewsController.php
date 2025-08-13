<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\News;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class NewsController extends Controller
{
    public function index()
    {
        $news = News::with('author')->latest()->paginate(10);
        return view('admin.news.index', compact('news'));
    }

    public function create()
    {
        return view('admin.news.create');
    }

    public function toggle(News $news)
    {
        $news->is_active = !$news->is_active;
        $news->save();

        $status = $news->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return redirect()->back()->with('success', "Berita berhasil $status.");
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'published_at' => 'nullable|date',
        ]);

        $thumbnailPath = null;
        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $request->file('thumbnail')->store('news_thumbnails', 'public');
        }

        $slug = Str::slug($validatedData['title']);
        $originalSlug = $slug;
        $count = 1;
        while (News::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count++;
        }

        News::create([
            'title' => $validatedData['title'],
            'slug' => $slug,
            'content' => $validatedData['content'],
            'thumbnail' => $thumbnailPath,
            'user_id' => Auth::id(),
            'published_at' => $validatedData['published_at'] ?? now(),
            'is_active' => true,
        ]);

        return redirect()->route('admin.news.index')->with('success', 'Berita berhasil ditambahkan!');
    }

    public function show(string $id)
    {
        return redirect()->route('admin.news.edit', $id);
    }

    public function edit(string $id)
    {
        $news = News::findOrFail($id);
        return view('admin.news.edit', compact('news'));
    }

    public function update(Request $request, string $id)
    {
        $news = News::findOrFail($id);

        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'published_at' => 'nullable|date',
        ]);

        $thumbnailPath = $news->thumbnail;
        if ($request->hasFile('thumbnail')) {
            if ($thumbnailPath) {
                Storage::disk('public')->delete($thumbnailPath);
            }
            $thumbnailPath = $request->file('thumbnail')->store('news_thumbnails', 'public');
        }

        $slug = Str::slug($validatedData['title']);
        $originalSlug = $slug;
        $count = 1;
        while (News::where('slug', $slug)->where('id', '!=', $id)->exists()) {
            $slug = $originalSlug . '-' . $count++;
        }

        $news->update([
            'title' => $validatedData['title'],
            'slug' => $slug,
            'content' => $validatedData['content'],
            'thumbnail' => $thumbnailPath,
            'published_at' => $validatedData['published_at'] ?? now(),
        ]);

        return redirect()->route('admin.news.index')->with('success', 'Berita berhasil diperbarui!');
    }

    public function destroy(string $id)
    {
        $news = News::findOrFail($id);

        if ($news->thumbnail) {
            Storage::disk('public')->delete($news->thumbnail);
        }

        $news->delete();

        return redirect()->route('admin.news.index')->with('success', 'Berita berhasil dihapus!');
    }
}
