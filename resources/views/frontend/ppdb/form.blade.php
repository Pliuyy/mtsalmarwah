@extends('layouts.app')

@section('title', 'Formulir Pendaftaran PPDB')

@section('content')


<div class="container mx-auto px-4">

    @include('components.hero_carousel')

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8 mt-6">
        <div class="lg:col-span-1">
            @include('frontend.ppdb.ppdb_sidebar')
        </div>

        <div class="lg:col-span-3 bg-white rounded-lg shadow-lg p-8">
            <h2 class="text-3xl font-bold text-navy-blue mb-6 flex items-center">
                <i class="fas fa-user-graduate mr-3 text-royal-blue"></i>
                Lengkapi Formulir Pendaftaran Anda
            </h2>

            @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                {{ session('success') }}
            </div>
            @endif

            <div class="mb-8">
                <div class="flex justify-between mb-1 text-sm text-gray-600">
                    <span id="progress-percentage" style="left: 98%; position: relative">0%</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-3">
                    <div id="progress-bar" class="bg-royal-blue h-3 rounded-full transition-all duration-300" style="width: 0%"></div>
                </div>
            </div>

            <form id="ppdb-form" action="{{ route('ppdb.submit_form') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Data Calon Peseerta Didik -->
                <fieldset class="border-2 border-royal-blue p-6 rounded-lg mb-8 bg-blue-50">
                    <legend class="text-royal-blue text-xl font-semibold mb-4">Data Calon Peserta Didik</legend>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="form-group">
                            <label for="nama_lengkap" class="block text-gray-700 text-sm font-bold mb-2">
                                Nama Lengkap:
                            </label>
                            <input type="text" id="nama_lengkap" name="nama_lengkap" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('nama_lengkap') border-red-500 @enderror" value="{{ old('nama_lengkap') }}" required>
                            @error('nama_lengkap')<p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div class="form-group">
                            <label for="tempat_lahir" class="block text-gray-700 text-sm font-bold mb-2">Tempat Lahir:</label>
                            <input type="text" id="tempat_lahir" name="tempat_lahir" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('tempat_lahir') border-red-500 @enderror" value="{{ old('tempat_lahir') }}" required>
                            @error('tempat_lahir')<p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div class="form-group">
                            <label for="tanggal_lahir" class="block text-gray-700 text-sm font-bold mb-2">Tanggal Lahir:</label>
                            <input type="date" id="tanggal_lahir" name="tanggal_lahir" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('tanggal_lahir') border-red-500 @enderror" value="{{ old('tanggal_lahir') }}" required>
                            @error('tanggal_lahir')<p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div class="form-group">
                            <label for="jenis_kelamin" class="block text-gray-700 text-sm font-bold mb-2">Jenis Kelamin:</label>
                            <select id="jenis_kelamin" name="jenis_kelamin" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('jenis_kelamin') border-red-500 @enderror" required>
                                <option value="" hidden>Pilih</option>
                                <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                            @error('jenis_kelamin')<p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div class="md:col-span-2">
                            <label for="alamat_lengkap" class="block text-gray-700 text-sm font-bold mb-2">Alamat Lengkap:</label>
                            <textarea id="alamat_lengkap" name="alamat_lengkap" rows="3" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('alamat_lengkap') border-red-500 @enderror" required>{{ old('alamat_lengkap') }}</textarea>
                            @error('alamat_lengkap')<p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div class="form-group">
                            <label for="asal_sekolah" class="block text-gray-700 text-sm font-bold mb-2">Asal Sekolah:</label>
                            <input type="text" id="asal_sekolah" name="asal_sekolah" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('asal_sekolah') border-red-500 @enderror" value="{{ old('asal_sekolah') }}" required>
                            @error('asal_sekolah')<p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div class="form-group">
                            <label for="nisn" class="block text-gray-700 text-sm font-bold mb-2">NISN (Opsional):</label>
                            <input type="text" id="nisn" name="nisn" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('nisn') border-red-500 @enderror" value="{{ old('nisn') }}">
                            @error('nisn')<p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </fieldset>

                <fieldset class="border-2 border-royal-blue p-6 rounded-lg mb-8 bg-blue-50">
                    <legend class="text-royal-blue text-xl font-semibold mb-4">Data Orang Tua/Wali</legend>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4">
                        <div class="form-group">
                            <label for="nama_ayah" class="block text-gray-700 text-sm font-bold mb-2">Nama Ayah:</label>
                            <input type="text" id="nama_ayah" name="nama_ayah" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('nama_ayah') border-red-500 @enderror" value="{{ old('nama_ayah') }}" required>
                            @error('nama_ayah')<p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div class="form-group">
                            <label for="nama_ibu" class="block text-gray-700 text-sm font-bold mb-2">Nama Ibu:</label>
                            <input type="text" id="nama_ibu" name="nama_ibu" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('nama_ibu') border-red-500 @enderror" value="{{ old('nama_ibu') }}" required>
                            @error('nama_ibu')<p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div class="form-group">
                            <label for="pekerjaan_ayah" class="block text-gray-700 text-sm font-bold mb-2">Pekerjaan Ayah:</label>
                            <input type="text" id="pekerjaan_ayah" name="pekerjaan_ayah" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('pekerjaan_ayah') border-red-500 @enderror" value="{{ old('pekerjaan_ayah') }}" required>
                            @error('pekerjaan_ayah')<p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div class="form-group">
                            <label for="pekerjaan_ibu" class="block text-gray-700 text-sm font-bold mb-2">Pekerjaan Ibu:</label>
                            <input type="text" id="pekerjaan_ibu" name="pekerjaan_ibu" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('pekerjaan_ibu') border-red-500 @enderror" value="{{ old('pekerjaan_ibu') }}" required>
                            @error('pekerjaan_ibu')<p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div class="form-group">
                            <label for="penghasilan_ayah" class="block text-gray-700 text-sm font-bold mb-2">
                                Penghasilan Ayah:
                            </label>
                            <select id="penghasilan_ayah" name="penghasilan_ayah"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('penghasilan_ayah') border-red-500 @enderror" required>
                                <option value="" hidden>Pilih</option>
                                <option value="< 1 juta" {{ old('penghasilan_ayah') == '< 1 juta' ? 'selected' : '' }}>
                                    < 1 juta</option>
                                <option value="1 - 3 juta" {{ old('penghasilan_ayah') == '1 - 3 juta' ? 'selected' : '' }}>1 - 3 juta</option>
                                <option value="3 - 5 juta" {{ old('penghasilan_ayah') == '3 - 5 juta' ? 'selected' : '' }}>3 - 5 juta</option>
                                <option value="5 - 10 juta" {{ old('penghasilan_ayah') == '5 - 10 juta' ? 'selected' : '' }}>5 - 10 juta</option>
                                <option value="> 10 juta" {{ old('penghasilan_ayah') == '> 10 juta' ? 'selected' : '' }}>> 10 juta</option>
                            </select>
                            @error('penghasilan_ayah')<p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div class="form-group">
                            <label for="penghasilan_ibu" class="block text-gray-700 text-sm font-bold mb-2">
                                Penghasilan Ibu:
                            </label>
                            <select id="penghasilan_ibu" name="penghasilan_ibu"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('penghasilan_ibu') border-red-500 @enderror">
                                <option value="" hidden>Pilih</option>
                                <option value="< 1 juta" {{ old('penghasilan_ibu') == '< 1 juta' ? 'selected' : '' }}>
                                    < 1 juta</option>
                                <option value="1 - 3 juta" {{ old('penghasilan_ibu') == '1 - 3 juta' ? 'selected' : '' }}>1 - 3 juta</option>
                                <option value="3 - 5 juta" {{ old('penghasilan_ibu') == '3 - 5 juta' ? 'selected' : '' }}>3 - 5 juta</option>
                                <option value="5 - 10 juta" {{ old('penghasilan_ibu') == '5 - 10 juta' ? 'selected' : '' }}>5 - 10 juta</option>
                                <option value="> 10 juta" {{ old('penghasilan_ibu') == '> 10 juta' ? 'selected' : '' }}>> 10 juta</option>
                            </select>
                            @error('penghasilan_ibu')<p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div class="form-group">
                            <label for="telepon_ortu" class="block text-gray-700 text-sm font-bold mb-2">No. Telepon Orang Tua:</label>
                            <input type="text" id="telepon_ortu" name="telepon_ortu" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('telepon_ortu') border-red-500 @enderror" value="{{ old('telepon_ortu') }}" required>
                            @error('telepon_ortu')<p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div class="form-group">
                            <label for="email_ortu" class="block text-gray-700 text-sm font-bold mb-2">Email Orang Tua (Opsional):</label>
                            <input type="email" id="email_ortu" name="email_ortu" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('email_ortu') border-red-500 @enderror" value="{{ old('email_ortu') }}">
                            @error('email_ortu')<p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </fieldset>

                <fieldset class="border-2 border-royal-blue p-6 rounded-lg mb-8 bg-blue-50">
                    <legend class="text-royal-blue text-xl font-semibold mb-4">Upload Dokumen Pendukung</legend>
                    <p class="text-gray-700 mb-4 text-sm italic">
                        Ukuran maksimal per dokumen 2MB. Format file: PDF/JPG/PNG.
                    </p>
                    <div class="space-y-4">
                        <div class="form-group">
                            <label for="upload_akta_kelahiran" class="block text-gray-700 text-sm font-bold mb-2">Akta Kelahiran:</label>
                            <div id="dropzone-akta-kelahiran" class="dropzone border-2 border-dashed border-gray-400 rounded-lg p-6 text-center cursor-pointer hover:border-royal-blue transition-colors duration-200">
                                <input type="file" id="upload_akta_kelahiran" name="upload_akta_kelahiran" class="hidden" accept=".pdf,.jpg,.png">
                                <div class="flex items-center justify-center space-x-2">
                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18"></path>
                                    </svg>
                                    <p class="text-gray-500 text-sm">
                                        Seret dan lepas file di sini atau
                                        <span class="text-royal-blue font-semibold">klik untuk memilih</span>
                                    </p>
                                </div>
                                <div class="preview-area mt-4"></div>
                            </div>
                            @error('upload_akta_kelahiran')<p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div class="form-group">
                            <label for="upload_kk" class="block text-gray-700 text-sm font-bold mb-2">Kartu Keluarga (KK):</label>
                            <div id="dropzone-kk" class="dropzone border-2 border-dashed border-gray-400 rounded-lg p-6 text-center cursor-pointer hover:border-royal-blue transition-colors duration-200">
                                <input type="file" id="upload_kk" name="upload_kk" class="hidden" accept=".pdf,.jpg,.png">
                                <div class="flex items-center justify-center space-x-2">
                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18"></path>
                                    </svg>
                                    <p class="text-gray-500 text-sm">
                                        Seret dan lepas file di sini atau
                                        <span class="text-royal-blue font-semibold">klik untuk memilih</span>
                                    </p>
                                </div>
                                <div class="preview-area mt-4"></div>
                            </div>
                            @error('upload_kk')<p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div class="form-group">
                            <label for="upload_ijazah" class="block text-gray-700 text-sm font-bold mb-2">Ijazah/SKL Terakhir:</label>
                            <div id="dropzone-ijazah" class="dropzone border-2 border-dashed border-gray-400 rounded-lg p-6 text-center cursor-pointer hover:border-royal-blue transition-colors duration-200">
                                <input type="file" id="upload_ijazah" name="upload_ijazah" class="hidden" accept=".pdf,.jpg,.png">
                                <div class="flex items-center justify-center space-x-2">
                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18"></path>
                                    </svg>
                                    <p class="text-gray-500 text-sm">
                                        Seret dan lepas file di sini atau
                                        <span class="text-royal-blue font-semibold">klik untuk memilih</span>
                                    </p>
                                </div>
                                <div class="preview-area mt-4"></div>
                            </div>
                            @error('upload_ijazah')<p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div class="form-group">
                            <label for="upload_pas" class="block text-gray-700 text-sm font-bold mb-2">Pas foto 3x4:</label>
                            <div id="dropzone-pas" class="dropzone border-2 border-dashed border-gray-400 rounded-lg p-6 text-center cursor-pointer hover:border-royal-blue transition-colors duration-200">
                                <input type="file" id="upload_pas" name="upload_pas" class="hidden" accept=".pdf,.jpg,.png">
                                <div class="flex items-center justify-center space-x-2">
                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18"></path>
                                    </svg>
                                    <p class="text-gray-500 text-sm">
                                        Seret dan lepas file di sini atau
                                        <span class="text-royal-blue font-semibold">klik untuk memilih</span>
                                    </p>
                                </div>
                                <div class="preview-area mt-4"></div>
                            </div>
                            @error('upload_pas')<p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </fieldset>

                <div class="text-center">
                    <button type="submit" class="bg-navy-blue hover:bg-royal-blue text-white font-bold py-3 px-8 rounded-full transition duration-300">
                        <i class="fas fa-paper-plane mr-2"></i> Kirim Formulir Pendaftaran
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    document.querySelectorAll('.dropzone').forEach(dropzone => {
        const input = dropzone.querySelector('input[type="file"]');
        const previewArea = dropzone.querySelector('.preview-area');
        const defaultText = dropzone.querySelector('.text-sm');

        // Klik untuk memilih file
        dropzone.addEventListener('click', () => input.click());

        // Mencegah perilaku default browser saat drag over
        dropzone.addEventListener('dragover', (e) => {
            e.preventDefault();
            dropzone.classList.add('border-royal-blue');
            dropzone.classList.add('bg-blue-100');
        });

        // Mengembalikan tampilan normal saat drag leave
        dropzone.addEventListener('dragleave', (e) => {
            e.preventDefault();
            dropzone.classList.remove('border-royal-blue');
            dropzone.classList.remove('bg-blue-100');
        });

        // Menangani file yang di-drop
        dropzone.addEventListener('drop', (e) => {
            e.preventDefault();
            dropzone.classList.remove('border-royal-blue');
            dropzone.classList.remove('bg-blue-100');
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                input.files = files;
                handleFiles(files);
            }
        });

        // Menangani file yang dipilih dari input
        input.addEventListener('change', (e) => {
            const files = e.target.files;
            if (files.length > 0) {
                handleFiles(files);
            }
        });

        function handleFiles(files) {
            previewArea.innerHTML = '';
            defaultText.style.display = 'none';

            Array.from(files).forEach(file => {
                const reader = new FileReader();
                reader.onload = (e) => {
                    const fileType = file.type;
                    const previewContainer = document.createElement('div');
                    previewContainer.className = 'flex items-center justify-between p-2 mt-2 bg-white rounded-lg shadow-md';

                    if (fileType.startsWith('image/')) {
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.className = 'h-12 w-12 object-cover rounded-md';
                        previewContainer.appendChild(img);
                    } else if (fileType === 'application/pdf') {
                        const icon = document.createElement('svg');
                        icon.className = 'h-12 w-12 text-red-500';
                        icon.innerHTML = '<path fill-rule="evenodd" d="M14 2.5a.5.5 0 01.5.5v13a.5.5 0 01-.5.5H6a.5.5 0 01-.5-.5V3a.5.5 0 01.5-.5h8zM6 2a.5.5 0 00-.5.5v15a.5.5 0 00.5.5h8a.5.5 0 00.5-.5V3a.5.5 0 00-.5-.5H6zM8 4a.5.5 0 01.5.5v1a.5.5 0 01-1 0v-1a.5.5 0 01.5-.5zM7 6a.5.5 0 01.5.5v1a.5.5 0 01-1 0v-1a.5.5 0 01.5-.5zm2 0a.5.5 0 01.5.5v1a.5.5 0 01-1 0v-1a.5.5 0 01.5-.5zm-2 2a.5.5 0 01.5.5v1a.5.5 0 01-1 0v-1a.5.5 0 01.5-.5zm2 0a.5.5 0 01.5.5v1a.5.5 0 01-1 0v-1a.5.5 0 01.5-.5zm2 0a.5.5 0 01.5.5v1a.5.5 0 01-1 0v-1a.5.5 0 01.5-.5zM7 10a.5.5 0 01.5.5v1a.5.5 0 01-1 0v-1a.5.5 0 01.5-.5zm2 0a.5.5 0 01.5.5v1a.5.5 0 01-1 0v-1a.5.5 0 01.5-.5zm2 0a.5.5 0 01.5.5v1a.5.5 0 01-1 0v-1a.5.5 0 01.5-.5z" clip-rule="evenodd" fill="currentColor"></path>';
                        previewContainer.appendChild(icon);
                    }

                    const fileName = document.createElement('span');
                    fileName.className = 'text-sm text-gray-700 flex-1 ml-4';
                    fileName.textContent = file.name;
                    previewContainer.appendChild(fileName);

                    const removeButton = document.createElement('button');
                    removeButton.className = 'text-red-500 hover:text-red-700 focus:outline-none';
                    removeButton.innerHTML = '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>';
                    removeButton.addEventListener('click', (e) => {
                        e.stopPropagation();
                        previewArea.innerHTML = '';
                        input.value = '';
                        defaultText.style.display = 'flex';
                    });
                    previewContainer.appendChild(removeButton);

                    previewArea.appendChild(previewContainer);
                };
                reader.readAsDataURL(file);
            });
        }
    });
    document.addEventListener("DOMContentLoaded", function() {
        const form = document.getElementById("ppdb-form");
        const inputs = form.querySelectorAll("input, select, textarea");
        const progressBar = document.getElementById("progress-bar");
        const progressText = document.getElementById("progress-percentage");

        function updateProgress() {
            let filled = 0;
            let total = 0;
            inputs.forEach(input => {
                if (input.type !== "hidden" && input.type !== "submit" && input.name) {
                    total++;
                    if (input.value.trim() !== "") {
                        filled++;
                    }
                }
            });
            let percent = Math.round((filled / total) * 100);
            progressBar.style.width = percent + "%";
            progressText.textContent = percent + "%";
        }

        inputs.forEach(input => {
            input.addEventListener("input", updateProgress);
        });

        updateProgress();
    });
</script>
@endsection