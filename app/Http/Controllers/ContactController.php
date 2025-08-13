<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactFormMail;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    // Frontend - Tampilkan form
    public function showForm()
    {
        return view('frontend.contact');
    }

    // Proses pengiriman form
    public function send(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|min:1|max:1000',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'subject' => $request->subject,
            'message' => $request->message,
            'ip_address' => $request->ip(),
        ];

        $message = ContactMessage::create($data);

        try {
            $schoolEmail = config('settings.school_email', 'info@sekolah.com');
            Mail::to($schoolEmail)->send(new ContactFormMail($data));

            return back()->with('success', 'Pesan Anda telah terkirim. Terima kasih!');
        } catch (\Exception $e) {
            Log::error('Email gagal dikirim: ' . $e->getMessage()); // Perbaikan di sini
            return back()->with('error', 'Gagal mengirim pesan. Silakan coba lagi nanti.');
        }
    }

    // Admin - Tampilkan semua pesan
    // app/Http/Controllers/ContactController.php

    public function index()
    {
        $messages = ContactMessage::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.contact.index', compact('messages'));
    }

    public function show(ContactMessage $contactMessage)
    {
        // Tandai sebagai sudah dibaca jika belum
        if (!$contactMessage->read_at) {
            $contactMessage->update(['read_at' => now()]);
        }

        return view('admin.contact.show', compact('contactMessage'));
    }

    // Admin - Hapus pesan
    public function destroy(ContactMessage $contactMessage)
    {
        try {
            $contactMessage->delete();
            return redirect()->route('admin.contact.messages')
                ->with('success', 'Pesan berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menghapus pesan');
        }
    }
}
