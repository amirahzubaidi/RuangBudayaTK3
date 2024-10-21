@extends('layouts.app')

@section('title', 'Tampilkan Buku - Ruang Budaya')

@section('content')

<div class="min-h-screen flex flex-col items-center py-12">
    
    <!-- Tombol Kembali di ujung kiri atas -->
    <div class="w-full max-w-5xl px-4 sm:px-6 lg:px-8 mb-4">
        <a href="{{ route('library.index') }}" class="text-blue-600 font-semibold text-sm hover:text-blue-800 transition duration-300">
            &larr; Kembali
        </a>
    </div>

    <!-- Informasi Buku -->
    <div class="w-full max-w-4xl bg-white p-6 mb-8">
        <div class="text-center">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">{{ $book->title }}</h1>
            <p class="text-lg text-gray-700">
                Penulis: <span class="font-semibold text-gray-900">{{ $book->author }}</span>
            </p>
            <p class="text-lg text-gray-700">
                Tahun Terbit: <span class="font-semibold text-gray-900">{{ $book->published_year }}</span>
            </p>
        </div>
    </div>

    <!-- PDF Viewer -->
    <div id="pdf-viewer" class="w-full max-w-5xl bg-gray-50 border border-gray-200 rounded-lg shadow-lg overflow-hidden">
        <iframe id="pdf-iframe" src="" class="w-full h-screen rounded-lg border-none" style="min-height: 600px;"></iframe>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Ambil URL dari PDF
        const pdfUrl = "{{ asset('storage/' . $book->file_url) }}"; // Pastikan ini mengarah ke path file yang benar

        // Set URL pada iframe
        const pdfIframe = document.getElementById('pdf-iframe');
        pdfIframe.src = pdfUrl;
    });
</script>

@endsection
