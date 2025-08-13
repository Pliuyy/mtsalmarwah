<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function edit()
    {
        $settings = Setting::pluck('value', 'key')->toArray();
        return view('admin.settings.edit', compact('settings'));
    }

    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'school_name' => 'required|string|max:255',
            'school_tagline' => 'nullable|string|max:255',
            'school_address' => 'required|string|max:255',
            'school_phone' => 'required|string|max:255',
            'school_email' => 'required|email|max:255',
            'school_description' => 'nullable|string',
            'school_founding_year' => 'nullable|integer|min:1900|max:' . date('Y'),
            'school_history' => 'nullable|string',
            'school_vision' => 'nullable|string',
            'school_vision_1' => 'nullable|string',
            'school_vision_2' => 'nullable|string',
            'school_vision_3' => 'nullable|string',
            'school_vision_4' => 'nullable|string',
            'school_vision_5' => 'nullable|string',
            'school_mission_1' => 'nullable|string',
            'school_mission_2' => 'nullable|string',
            'school_mission_3' => 'nullable|string',
            'school_mission_4' => 'nullable|string',
            'school_mission_5' => 'nullable|string',
            'facebook_link' => 'nullable|url|max:255',
            'instagram_link' => 'nullable|url|max:255',
            'youtube_link' => 'nullable|url|max:255',
            'tiktok_link' => 'nullable|url|max:255',
            'school_logo_file' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'old_school_logo' => 'nullable|string',
        ]);

        $schoolLogoPath = $request->input('old_school_logo');

        if ($request->hasFile('school_logo_file')) {
            if ($schoolLogoPath && Storage::disk('public')->exists($schoolLogoPath)) {
                Storage::disk('public')->delete($schoolLogoPath);
            }
            $schoolLogoPath = $request->file('school_logo_file')->store('settings', 'public');
        }

        foreach ($validatedData as $key => $value) {
            if (!in_array($key, ['school_logo_file', 'old_school_logo'])) {
                Setting::updateOrCreate(['key' => $key], ['value' => $value]);
            }
        }

        Setting::updateOrCreate(['key' => 'school_logo'], ['value' => $schoolLogoPath]);

        return redirect()->route('admin.settings.edit')->with('success', 'Pengaturan umum berhasil diperbarui!');
    }

    public function editPrincipal()
    {
        $settings = Setting::pluck('value', 'key')->toArray();
        return view('admin.principal-settings.edit', compact('settings'));
    }

    public function updatePrincipal(Request $request)
    {
        $validatedData = $request->validate([
            'principal_name' => 'required|string|max:255',
            'kepala_sekolah_sambutan' => 'nullable|string',
            'principal_photo_file' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'old_principal_photo' => 'nullable|string',
        ]);

        $principalPhotoPath = $request->input('old_principal_photo');

        if ($request->hasFile('principal_photo_file')) {
            if ($principalPhotoPath && Storage::disk('public')->exists($principalPhotoPath)) {
                Storage::disk('public')->delete($principalPhotoPath);
            }

            $principalPhotoPath = $request->file('principal_photo_file')->store('settings', 'public');
        }

        foreach ($validatedData as $key => $value) {
            if (!in_array($key, ['principal_photo_file', 'old_principal_photo'])) {
                Setting::updateOrCreate(['key' => $key], ['value' => $value]);
            }
        }

        Setting::updateOrCreate(['key' => 'principal_photo'], ['value' => $principalPhotoPath]);

        return redirect()->route('admin.principal.edit')->with('success', 'Pengaturan Kepala Sekolah diperbarui!');
    }
}
