<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting; // Import Model Setting
use App\Models\PpdbSchedule; // Import Model PpdbSchedule
use App\Models\PpdbRequirement; // Import Model PpdbRequirement
use App\Models\PpdbResult; // Import Model PpdbResult
use App\Models\PpdbApplicant; // <<< TAMBAHAN INI
use Illuminate\Support\Facades\Storage; // <<< TAMBAHKAN BARIS INI UNTUK STORAGE

class AdminPpdbController extends Controller
{
    /**
     * Display a listing of the resource.
     * Menampilkan ringkasan pengaturan PPDB di halaman admin.
     * Dalam kasus ini, kita akan langsung menampilkan form edit.
     */
    public function index()
    {
        // Mengambil semua pengaturan PPDB yang relevan dari tabel settings
        $settings = Setting::pluck('value', 'key')->toArray();
        
        // Mengambil jadwal PPDB untuk ditampilkan
        $schedules = PpdbSchedule::orderBy('start_date')->get();

        return view('admin.ppdb-settings.index', compact('settings', 'schedules'));
    }

    /**
     * Show the form for editing the specified resource.
     * Menampilkan form untuk mengedit pengaturan PPDB.
     */
    public function edit()
    {
        // Mengambil semua pengaturan PPDB yang relevan dari tabel settings
        $settings = Setting::pluck('value', 'key')->toArray();
        
        // Mengambil jadwal PPDB untuk ditampilkan dan diedit
        $schedules = PpdbSchedule::orderBy('start_date')->get();
        
        // Mengambil persyaratan PPDB untuk ditampilkan dan diedit
        $requirements = PpdbRequirement::all();

        // Mengambil hasil seleksi PPDB untuk ditampilkan dan diedit
        $results = PpdbResult::orderBy('published_at', 'desc')->get();

        return view('admin.ppdb-settings.edit', compact('settings', 'schedules', 'requirements', 'results'));
    }

    /**
     * Update the specified resource in storage.
     * Mengupdate pengaturan PPDB di database.
     */
    public function update(Request $request)
    {
        // Validasi data input
        $validatedData = $request->validate([
            'ppdb_status' => 'required|in:open,closed',
            'ppdb_start_date' => 'required|string|max:255', // Disimpan sebagai string
            'ppdb_end_date' => 'required|string|max:255', // Disimpan sebagai string
            'ppdb_contact_person' => 'nullable|string|max:255',
            'ppdb_welcome_text' => 'nullable|string',
            
            // Validasi untuk jadwal (jika diupdate di sini)
            'schedule_id.*' => 'nullable|exists:ppdb_schedules,id',
            'schedule_title.*' => 'nullable|string|max:255',
            'schedule_start_date.*' => 'nullable|date',
            'schedule_end_date.*' => 'nullable|date',
            'schedule_description.*' => 'nullable|string',

            // Validasi untuk persyaratan
            'requirement_id.*' => 'nullable|exists:ppdb_requirements,id',
            'requirement_title.*' => 'nullable|string|max:255',
            'requirement_description.*' => 'nullable|string',

            // Validasi untuk hasil seleksi
            'result_id.*' => 'nullable|exists:ppdb_results,id',
            'result_title.*' => 'nullable|string|max:255',
            'result_file_upload.*' => 'nullable|file|mimes:pdf|max:5120', // Max 5MB PDF
            'result_content.*' => 'nullable|string',
            'result_published_at.*' => 'nullable|date',
        ]);

        // Update pengaturan PPDB di tabel settings
        foreach ([
            'ppdb_status',
            'ppdb_start_date',
            'ppdb_end_date',
            'ppdb_contact_person',
            'ppdb_welcome_text'
        ] as $key) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $validatedData[$key] ?? null]
            );
        }

        // Update atau tambah jadwal PPDB
        if ($request->has('schedule_title')) {
            foreach ($request->schedule_title as $index => $title) {
                if (!empty($title)) {
                    $scheduleData = [
                        'title' => $title,
                        'start_date' => $request->schedule_start_date[$index],
                        'end_date' => $request->schedule_end_date[$index],
                        'description' => $request->schedule_description[$index] ?? null,
                    ];
                    if (isset($request->schedule_id[$index]) && $request->schedule_id[$index]) {
                        PpdbSchedule::find($request->schedule_id[$index])->update($scheduleData);
                    } else {
                        PpdbSchedule::create($scheduleData);
                    }
                }
            }
        }
        // Hapus jadwal yang ditandai untuk dihapus (jika ada input delete_schedule_id)
        if ($request->has('delete_schedule_id')) {
            PpdbSchedule::whereIn('id', $request->delete_schedule_id)->delete();
        }

        // Update atau tambah persyaratan PPDB
        if ($request->has('requirement_title')) {
            foreach ($request->requirement_title as $index => $title) {
                if (!empty($title)) {
                    $requirementData = [
                        'title' => $title,
                        'description' => $request->requirement_description[$index] ?? null,
                    ];
                    if (isset($request->requirement_id[$index]) && $request->requirement_id[$index]) {
                        PpdbRequirement::find($request->requirement_id[$index])->update($requirementData);
                    } else {
                        PpdbRequirement::create($requirementData);
                    }
                }
            }
        }
        // Hapus persyaratan yang ditandai untuk dihapus
        if ($request->has('delete_requirement_id')) {
            PpdbRequirement::whereIn('id', $request->delete_requirement_id)->delete();
        }

        // Update atau tambah hasil seleksi PPDB
        if ($request->has('result_title')) {
            foreach ($request->result_title as $index => $title) {
                if (!empty($title)) {
                    $resultData = [
                        'title' => $title,
                        'content' => $request->result_content[$index] ?? null,
                        'published_at' => $request->result_published_at[$index] ?? now(),
                    ];
                    $filePath = null;
                    if ($request->hasFile('result_file_upload') && isset($request->result_file_upload[$index])) {
                        $filePath = $request->file('result_file_upload')[$index]->store('ppdb_results', 'public');
                        $resultData['file_path'] = $filePath;
                    }

                    if (isset($request->result_id[$index]) && $request->result_id[$index]) {
                        $result = PpdbResult::find($request->result_id[$index]);
                        // Hapus file lama jika ada file baru diupload
                        if ($filePath && $result->file_path) { // Akses $result->file_path
                            Storage::disk('public')->delete($result->file_path);
                        }
                        $result->update($resultData);
                    } else {
                        PpdbResult::create($resultData);
                    }
                }
            }
        }
        // Hapus hasil seleksi yang ditandai untuk dihapus
        if ($request->has('delete_result_id')) {
            // Hapus file PDF terkait sebelum menghapus entri
            $resultsToDelete = PpdbResult::whereIn('id', $request->delete_result_id)->get();
            foreach ($resultsToDelete as $result) {
                if ($result->file_path) { // Akses $result->file_path
                    Storage::disk('public')->delete($result->file_path);
                }
                $result->delete();
            }
        }


        return redirect()->route('admin.ppdb-settings.index')->with('success', 'Pengaturan PPDB berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     * Tidak digunakan untuk pengaturan, karena pengaturan diupdate/dibuat.
     */
    public function destroy(string $id)
    {
        // Tidak digunakan
        abort(404);
    }


    // <<< INI ADALAH BAGIAN TAMBAHAN UNTUK MENGELOLA PENDAFTAR >>>

    /**
     * Menampilkan daftar semua pendaftar PPDB.
     */
    public function applicantsIndex()
    {
        $applicants = PpdbApplicant::latest()->paginate(10); 
        return view('admin.ppdb.applicants.index', compact('applicants'));
    }

    /**
     * Menampilkan detail pendaftar.
     */
    public function show(PpdbApplicant $applicant)
    {
        return view('admin.ppdb.applicants.show', compact('applicant'));
    }

    /**
     * Memperbarui status pendaftar.
     */
    public function updateStatus(Request $request, PpdbApplicant $applicant)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,accepted,rejected',
        ]);

        $applicant->status = $validated['status'];
        $applicant->save();

        return redirect()->route('admin.ppdb-applicants.index')->with('success', 'Status pendaftar berhasil diperbarui.');
    }

    /**
     * Menghapus pendaftar.
     */
    public function destroyApplicant(PpdbApplicant $applicant)
    {
        // Hapus file-file pendaftar dari storage
        if ($applicant->akta_kelahiran_path) {
            Storage::disk('public')->delete($applicant->akta_kelahiran_path);
        }
        if ($applicant->kk_path) {
            Storage::disk('public')->delete($applicant->kk_path);
        }
        if ($applicant->ijazah_path) {
            Storage::disk('public')->delete($applicant->ijazah_path);
        }
        if ($applicant->pas_foto_path) {
            Storage::disk('public')->delete($applicant->pas_foto_path);
        }
        
        $applicant->delete();

        return redirect()->route('admin.ppdb-applicants.index')->with('success', 'Data pendaftar berhasil dihapus.');
    }
}
