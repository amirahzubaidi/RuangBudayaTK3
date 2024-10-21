@extends('layouts.app')

@section('title', ' - Ruang Budaya')

@section('content')
    
<!-- Form Section -->
<div class="min-h-screen flex flex-col justify-center items-center py-12">
    
    <!-- Judul di Tengah Atas -->
    <h1 class="text-4xl font-bold tracking-tight text-gray-900 mb-8">Tambah Topik Baru</h1>

    <form action="{{ route('forum.store') }}" method="POST" enctype="multipart/form-data" class="w-full max-w-4xl bg-white p-10 rounded-lg shadow-sm">
        @csrf <!-- CSRF Token -->
        <div class="space-y-12">
            <div class="grid grid-cols-1 gap-x-8 gap-y-10 pb-12 md:grid-cols-3">
                <div>
                    <h2 class="text-lg font-semibold leading-7 text-gray-900">Informasi Topik</h2>
                    <p class="mt-1 text-sm leading-6 text-gray-600">Silakan isi informasi yang diperlukan untuk menambahkan topik baru.</p>
                </div>

                <div class="grid max-w-2xl grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6 md:col-span-2">
                    
                    <!-- Input Judul Berita -->
                    <div class="col-span-full">
                        <label for="judul" class="block text-sm font-medium leading-6 text-gray-900">Topik Forum Diskusi</label>
                        <div class="mt-2">
                            <input type="text" name="title" id="judul" value="{{ old('title') }}" class="block w-full rounded-md border-0 py-2 px-4 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder="Masukkan topik baru">
                            @error('title')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Input Konten Berita dengan TinyMCE -->
                    <div class="col-span-full">
                        <label for="konten" class="block text-sm font-medium leading-6 text-gray-900">Tulis Pertanyaan  Anda</label>
                        <div class="mt-2">
                            <textarea id="konten" name="content" rows="6" class="block w-full rounded-md border-0 py-2 px-4 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder="Tulis pertanyaan Anda di sini">{{ old('content') }}</textarea>
                            @error('content')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <input type="hidden" value="{{ Auth::user()->id }}" name="user_id">

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
</script>

@endsection
