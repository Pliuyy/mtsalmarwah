@extends('layouts.app')

@section('title', 'Profil Guru')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-4xl font-bold text-navy-blue mb-8 text-center">Profil Guru-Guru Kami</h1>
    <p class="text-lg text-center text-gray-700 mb-10">Dedikasi dan keahlian para guru adalah pilar utama pendidikan di sekolah kami.</p>

    @if($teachers->isEmpty())
    <p class="text-center text-gray-600">Belum ada data guru yang tersedia saat ini.</p>
    @else
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach ($teachers as $teacher)
        <div class="bg-white rounded-lg shadow-md overflow-hidden transform transition duration-300 hover:scale-105">
            {{-- Foto guru dari storage atau fallback placeholder --}}
            @if($teacher->photo)
            <div class="w-full aspect-[4/3]">
                <img src="{{ asset('storage/' . $teacher->photo) }}" alt="{{ $teacher->name }}"
                    class="w-full h-full object-cover">
            </div>
            @else
            <div class="w-full aspect-[4/3]">
                <img src="https://via.placeholder.com/400x300/000080/FFFFFF?text=Guru" alt="Foto tidak tersedia"
                    class="w-full h-full object-cover">
            </div>
            @endif

            {{-- Card --}}
            <div class="p-6 text-center group relative cursor-pointer"
                data-name="{{ e($teacher->name) }}"
                data-subject="{{ e($teacher->subject) }}"
                data-bio='@json($teacher->bio)'
                onmouseenter="showHoverBioFromElement(this, event)"
                onmouseleave="hideHoverBio()"
                onclick="openBioModalFromElement(this)">
                <h2 class="text-2xl font-semibold text-navy-blue mb-2">{{ $teacher->name }}</h2>
                <p class="text-royal-blue font-medium mb-2">{{ $teacher->subject }}</p>
                <p class="mb-4 text-sm text-gray-600">
                    <i class="mr-1 far fa-calendar-alt"></i>
                    Update : {{ \Carbon\Carbon::parse($teacher->published_at)->format('d F Y') }}
                </p>
                <p class="text-gray-700 mt-4 leading-relaxed">{{ Str::limit($teacher->bio, 50) }}</p>
                <p class="text-navy-blue mt-4 leading-relaxed">Klik untuk melihat selengkapnya...</p>
            </div>

            {{-- Hover Popup (desktop only) --}}
            <div id="hover-bio"
                class="hidden absolute z-50 max-w-md p-4 bg-white rounded-lg shadow-lg border border-gray-200 text-left"
                style="pointer-events:none;">
                <h3 class="text-lg font-bold mb-1" id="hover-bio-name"></h3>
                <p class="text-sm text-gray-500 mb-2" id="hover-bio-subject"></p>
                <p class="text-gray-700 leading-relaxed" id="hover-bio-text"></p>
            </div>

            {{-- Modal (click - mobile & desktop) --}}
            <div id="bio-modal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center p-4">
                <div class="bg-white rounded-lg shadow-lg max-w-lg w-full p-6 relative">
                    <button type="button" class="absolute top-3 right-3 text-gray-500 hover:text-gray-800"
                        onclick="closeBioModal()">X</button>

                    <h3 class="text-2xl font-bold mb-1" id="modal-bio-name"></h3>
                    <p class="text-royal-blue font-medium mb-3" id="modal-bio-subject"></p>
                    <div class="text-gray-700 leading-relaxed" id="modal-bio-text"></div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>
<script>
/* helper: try parse JSON, or return raw string */
function tryParseJSON(value) {
  try { return JSON.parse(value); }
  catch (e) { return value; }
}

/* Hover from element */
function showHoverBioFromElement(el, event) {
  if (window.innerWidth < 1024) return; // hanya desktop
  const hoverBio = document.getElementById('hover-bio');
  const name = el.dataset.name || '';
  const subject = el.dataset.subject || '';
  let bio = el.dataset.bio || '';
  bio = tryParseJSON(bio);

  document.getElementById('hover-bio-name').innerText = name;
  document.getElementById('hover-bio-subject').innerText = subject;
  document.getElementById('hover-bio-text').innerText = bio;

  // posisi sederhana dekat kursor (sesuaikan kalau overflow)
  const x = event.pageX + 15;
  let y = event.pageY - 20;

  hoverBio.style.left = x + 'px';
  hoverBio.style.top = y + 'px';
  hoverBio.classList.remove('hidden');
}

/* hide hover */
function hideHoverBio() {
  const hoverBio = document.getElementById('hover-bio');
  hoverBio.classList.add('hidden');
}

/* Open modal from element */
function openBioModalFromElement(el) {
  const name = el.dataset.name || '';
  const subject = el.dataset.subject || '';
  let bio = el.dataset.bio || '';
  bio = tryParseJSON(bio);

  document.getElementById('modal-bio-name').innerText = name;
  document.getElementById('modal-bio-subject').innerText = subject;

  // jika bio ada HTML yang aman, kamu bisa innerHTML, tapi default pakai text:
  document.getElementById('modal-bio-text').innerText = bio;

  document.getElementById('bio-modal').classList.remove('hidden');
}

function closeBioModal() {
  document.getElementById('bio-modal').classList.add('hidden');
}
</script>
@endsection