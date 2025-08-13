<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Carousel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CarouselController extends Controller
{
    public function index()
    {
        $carousels = Carousel::orderBy('order')->paginate(10);
        return view('admin.carousels.index', compact('carousels'));
    }

    public function create()
    {
        return view('admin.carousels.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'type' => 'required|in:image,video',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'video_url' => 'nullable|string|max:255',
            'button_text' => 'nullable|string|max:255',
            'button_link' => 'nullable|string|max:255',
            'order' => 'required|integer|min:0',
        ]);

        $imagePath = null;
        $videoUrl = null;

        if ($request->type === 'image') {
            if ($request->hasFile('image_file')) {
                $imagePath = $request->file('image_file')->store('carousels', 'public');
            }
        } elseif ($request->type === 'video') {
            $videoUrl = $this->extractYoutubeId($request->video_url);
            if (!$videoUrl) {
                return back()->withErrors(['video_url' => 'URL YouTube tidak valid'])->withInput();
            }
        }

        Carousel::create([
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'image_path' => $imagePath,
            'video_url' => $videoUrl,
            'type' => $request->type,
            'button_text' => $request->button_text,
            'button_link' => $request->button_link,
            'order' => $request->order,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.carousels.index')->with('success', 'Slide carousel berhasil ditambahkan!');
    }

    public function show(string $id)
    {
        return redirect()->route('admin.carousels.edit', $id);
    }

    public function edit(string $id)
    {
        $carousel = Carousel::findOrFail($id);
        return view('admin.carousels.edit', compact('carousel'));
    }

    public function toggle(Carousel $carousel)
    {
        $carousel->is_active = !$carousel->is_active;
        $carousel->save();

        return redirect()->back()->with('success', 'Status carousel berhasil diperbarui.');
    }

    public function update(Request $request, string $id)
    {
        $carousel = Carousel::findOrFail($id);

        $request->validate([
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'type' => 'required|in:image,video',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'video_url' => 'nullable|string|max:255',
            'button_text' => 'nullable|string|max:255',
            'button_link' => 'nullable|string|max:255',
            'order' => 'required|integer|min:0',
        ]);

        $imagePath = $carousel->image_path;
        $videoUrl = $carousel->video_url;

        if ($request->type === 'image') {
            if ($request->hasFile('image_file')) {
                if ($imagePath) {
                    Storage::disk('public')->delete($imagePath);
                }
                $imagePath = $request->file('image_file')->store('carousels', 'public');
            }
            $videoUrl = null;
        } elseif ($request->type === 'video') {
            $videoUrl = $this->extractYoutubeId($request->video_url);
            if (!$videoUrl) {
                return back()->withErrors(['video_url' => 'URL YouTube tidak valid'])->withInput();
            }
            if ($imagePath) {
                Storage::disk('public')->delete($imagePath);
                $imagePath = null;
            }
        }

        $carousel->update([
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'image_path' => $imagePath,
            'video_url' => $videoUrl,
            'type' => $request->type,
            'button_text' => $request->button_text,
            'button_link' => $request->button_link,
            'order' => $request->order,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.carousels.index')->with('success', 'Slide carousel berhasil diperbarui!');
    }

    public function destroy(string $id)
    {
        $carousel = Carousel::findOrFail($id);

        if ($carousel->image_path) {
            Storage::disk('public')->delete($carousel->image_path);
        }

        $carousel->delete();

        return redirect()->route('admin.carousels.index')->with('success', 'Slide carousel berhasil dihapus!');
    }

    /**
     * Ekstrak YouTube ID dari berbagai format URL
     */
    private function extractYoutubeId($url)
    {
        if (empty($url)) {
            return null;
        }

        // Jika sudah berupa ID (11 karakter alfanumerik)
        if (preg_match('/^[a-zA-Z0-9_-]{11}$/', $url)) {
            return $url;
        }

        // Ekstrak dari berbagai format URL YouTube
        $pattern = '/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=|youtu\.be\/)([^"&?\/\s]{11})/';
        preg_match($pattern, $url, $matches);
        
        return $matches[1] ?? null;
    }
}