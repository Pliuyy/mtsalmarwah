<?php

namespace App\Http\Controllers\Admin; // <<< PASTIKAN NAMESPACE INI

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Teacher; // Import model yang dibutuhkan untuk statistik
use App\Models\News;
use App\Models\Gallery;
use App\Models\Extracurricular; // Import model ekskul
use App\Models\Event; // Import model event
use App\Models\User; // Import model User untuk hitung admin/user

class DashboardController extends Controller
{
    public function index()
    {
        // Hitung statistik yang akan ditampilkan di dashboard
        $teacherCount = Teacher::count();
        $newsCount = News::count();
        $galleryCount = Gallery::count();
        $extracurricularCount = Extracurricular::count(); // Jumlah ekskul
        $eventCount = Event::count(); // Jumlah kegiatan
        $adminUserCount = User::where('role', 'admin')->orWhere('role', 'superadmin')->count(); // Jumlah user admin

        return view('admin.dashboard', compact(
            'teacherCount',
            'newsCount',
            'galleryCount',
            'extracurricularCount',
            'eventCount',
            'adminUserCount'
        ));
    }
}