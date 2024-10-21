@extends('layouts.app')

@section('title', 'Edit Berita - Ruang Budaya')

@section('content')

<!-- Form Section -->
<div class="min-h-screen flex flex-col justify-center items-center py-12">
    
    <!-- Judul di Tengah Atas -->
    <h1 class="text-4xl font-bold tracking-tight text-gray-900 mb-8">Edit Berita</h1>

    <form action="{{ route('news.update', $article->slug) }}" method="POST" enctype="multipart/form-data" class="w-full max-w-4xl bg-white p-10 rounded-lg shadow-sm">
        @csrf
        @method('PUT')
        <div class="space-y-12">
            <div class="grid grid-cols-1 gap-x-8 gap-y-10 pb-12 md:grid-cols-3">
                <div>
                    <h2 class="text-lg font-semibold leading-7 text-gray-900">Informasi Berita</h2>
                    <p class="mt-1 text-sm leading-6 text-gray-600">Silakan isi informasi yang diperlukan untuk memperbarui berita ini.</p>
                </div>

                <div class="grid max-w-2xl grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6 md:col-span-2">
                    
                    <!-- Input Judul Berita -->
                    <div class="col-span-full">
                        <label for="judul" class="block text-sm font-medium leading-6 text-gray-900">Judul Berita</label>
                        <div class="mt-2">
                            <input type="text" name="title" id="judul" value="{{ old('title', $article->title) }}" class="block w-full rounded-md border-0 py-2 px-4 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder="Masukkan judul berita">
                            @error('title')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Input Konten Berita dengan TinyMCE -->
                    <div class="col-span-full">
                        <label for="konten" class="block text-sm font-medium leading-6 text-gray-900">Konten Berita</label>
                        <div class="mt-2">
                            <textarea id="konten" name="content" rows="6" class="block w-full rounded-md border-0 py-2 px-4 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder="Tulis konten berita di sini">{{ old('content', $article->content) }}</textarea>
                            @error('content')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Input Foto Sampul dengan Preview -->
                    <div class="col-span-full">
                        <label for="thumbnail" class="block text-sm font-medium leading-6 text-gray-900">Foto Sampul</label>
                        <div class="mt-2 flex justify-center rounded-lg border border-dashed border-gray-900/25 px-6 py-10">
                            <div class="text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-300" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M1.5 6a2.25 2.25 0 012.25-2.25h16.5A2.25 2.25 0 0122.5 6v12a2.25 2.25 0 01-2.25 2.25H3.75A2.25 2.25 0 011.5 18V6zM3 16.06V18c0 .414.336.75.75.75h16.5A.75.75 0 0021 18v-1.94l-2.69-2.689a1.5 1.5 0 00-2.12 0l-.88.879.97.97a.75.75 0 11-1.06 1.06l-5.16-5.159a1.5 1.5 0 00-2.12 0L3 16.061zm10.125-7.81a1.125 1.125 0 112.25 0 1.125 1.125 0 01-2.25 0z" clip-rule="evenodd" />
                                </svg>
                                <div class="mt-4 flex text-sm leading-6 text-gray-600">
                                    <label for="thumbnail" class="relative cursor-pointer rounded-md bg-white font-semibold text-indigo-600 focus-within:outline-none focus-within:ring-2 focus-within:ring-indigo-600 focus-within:ring-offset-2 hover:text-indigo-500">
                                        <span>Upload foto</span>
                                        <input id="thumbnail" name="thumbnail" type="file" class="sr-only" onchange="previewImage(event)">
                                    </label>
                                    <p class="pl-1">atau seret file ke sini</p>
                                </div>
                                <p class="text-xs leading-5 text-gray-600">PNG, JPG, GIF up to 10MB</p>
                                <!-- Tempat menampilkan preview gambar -->
                                <img id="image-preview" class="mt-5 mx-auto h-48 w-48 object-cover rounded-lg" style="display: {{ $article->thumbnail ? 'block' : 'none' }};" src="{{ asset('storage/' . $article->thumbnail) }}">
                            </div>
                        </div>
                        @error('thumbnail')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- Tombol Save dan Cancel -->
        <div class="mt-6 flex items-center justify-end gap-x-6">
            <a href="{{ url()->previous() }}" class="text-sm font-semibold leading-6 text-gray-900">Kembali</a>
            <button type="submit" class="rounded-md bg-indigo-600 px-5 py-2 text-sm font-semibold text-white shadow-lg hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Simpan</button>
        </div>
    </form>
</div>

<!-- Script untuk TinyMCE dan preview gambar -->
@php
    $apiKey = env('TinyMCE_API_KEY');
@endphp
<script src="https://cdn.tiny.cloud/1/{{ $apiKey }}/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    // Inisialisasi TinyMCE
    tinymce.init({
        selector: '#konten',
        plugins: 'lists link image paste help wordcount',
        toolbar: 'undo redo | formatselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist | link image',
        height: 300
    });

    // Fungsi untuk preview gambar
    function previewImage(event) {
        var input = event.target;
        var reader = new FileReader();

        reader.onload = function(){
            var imagePreview = document.getElementById('image-preview');
            imagePreview.src = reader.result;
            imagePreview.style.display = 'block';
        }

        if (input.files && input.files[0]) {
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>

@endsection
