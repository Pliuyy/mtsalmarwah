<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;
use App\Models\Extracurricular;
use App\Models\Teacher;
use App\Models\Staff;
use App\Models\Achievement;
use App\Models\Event;
use App\Models\Gallery;
use App\Models\GalleryCategory;
use App\Models\PpdbSchedule;
use App\Models\PpdbRequirement;
use App\Models\PpdbResult;
use App\Models\Setting;
use App\Models\Carousel;
use Illuminate\Support\Str;

class HomeController extends Controller
{
    public function index()
    {
        $latestNews = News::latest()->take(3)->get();
        $settings = Setting::pluck('value', 'key')->toArray();
        $latestGalleryItems = Gallery::latest()->take(3)->get();
        $latestEvents = Event::latest('date')->take(3)->get();

        // Ambil semua slide carousel yang aktif, diurutkan
        $carousels = Carousel::where('is_active', true)
            ->orderBy('order')
            ->get();

        // Ambil video carousel YouTube yang aktif untuk ditampilkan di section sekolah
        $youtubeVideoCarousel = $this->getRandomActiveYoutubeVideo();

        return view('welcome', compact(
            'latestNews',
            'settings',
            'latestGalleryItems',
            'latestEvents',
            'carousels',
            'youtubeVideoCarousel'
        ));
    }

    /**
     * Mengambil satu video YouTube acak dari carousel yang aktif
     */
    private function getRandomActiveYoutubeVideo()
    {
        return Carousel::where('is_active', true)
            ->where('type', 'video')
            ->whereNotNull('video_url')
            ->inRandomOrder()
            ->first();
    }

    // --- Halaman Profil ---
    public function profileSchool()
    {
        $settings = Setting::pluck('value', 'key')->toArray();
        return view('frontend.profile.school', compact('settings'));
    }

    public function profileTeachers()
    {
        $teachers = Teacher::all();
        return view('frontend.profile.teachers', compact('teachers'));
    }

    public function profileStaff()
    {
        $staffs = Staff::all();
        return view('frontend.profile.staff', compact('staffs'));
    }

    public function profileAchievements()
    {
        $achievements = Achievement::orderBy('published_at', 'desc')->get();
        return view('frontend.profile.achievements', compact('achievements'));
    }

    public function profilePrincipal()
    {
        $settings = Setting::pluck('value', 'key')->toArray();
        return view('frontend.profile.principal', compact('settings'));
    }

    public function profileHistory()
    {
        $settings = Setting::pluck('value', 'key')->toArray();
        return view('frontend.profile.history', compact('settings'));
    }

    // --- Halaman Ekstrakurikuler ---
    public function extracurriculars()
    {
        $extracurriculars = Extracurricular::all();
        return view('frontend.extracurriculars', compact('extracurriculars'));
    }

    // --- Halaman Kegiatan ---
    public function events()
    {
        $events = Event::orderBy('date', 'desc')->get();
        return view('frontend.events', compact('events'));
    }

    // --- Halaman Galeri ---
    public function gallery(Request $request)
    {
        $categories = GalleryCategory::all();
        $galleries = Gallery::query();

        if ($request->has('category') && $request->category) {
            $galleries->where('gallery_category_id', (int)$request->category);
        }

        $galleries = $galleries->get();
        $carousels = Carousel::where('is_active', true)->orderBy('order')->get();

        return view('frontend.gallery', compact('categories', 'galleries', 'carousels'));
    }

    // --- Halaman Berita ---
    public function news()
    {
        $allNews = News::with('author')->where('is_active', 1)->latest()->paginate(9);
        return view('frontend.news.index', compact('allNews'));
    }

    public function newsDetail($slug)
    {
        $news = News::where('slug', $slug)->firstOrFail();
        return view('frontend.news.show', compact('news'));
    }

    // --- Halaman Kontak ---
    public function contact()
    {
        $settings = Setting::pluck('value', 'key')->toArray();
        return view('frontend.contact', compact('settings'));
    }
}
