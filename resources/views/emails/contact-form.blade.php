@component('mail::message')
# Pesan Baru dari Website Sekolah

**Nama:** {{ $data['name'] }}  
**Email:** {{ $data['email'] }}  
**Subjek:** {{ $data['subject'] }}  
**Waktu:** {{ now()->format('d F Y H:i') }}  

**Isi Pesan:**  
@component('mail::panel')
{{ $data['message'] }}
@endcomponent

@component('mail::button', ['url' => 'mailto:' . $data['email']])
Balas Email Ini
@endcomponent

@endcomponent