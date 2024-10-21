@extends('layouts.app')

@section('title', 'Profil Anda - Ruang Budaya')

@section('content')

<!-- Alert untuk pesan sukses -->
@if (session('success'))
<div id="success-alert" class="fixed top-5 right-5 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded shadow-md" role="alert">
    <strong>Berhasil!</strong> {{ session('success') }}
</div>
@endif

<div class="min-h-screen flex justify-center items-center py-12">
    <div class="w-full max-w-4xl bg-white p-10 rounded-lg shadow-sm space-y-12">
        <!-- Form Data Diri -->
        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-12">
            @csrf
            @method('PUT') <!-- Menggunakan method PUT untuk update -->
            <div class="grid grid-cols-1 gap-x-8 gap-y-10  md:grid-cols-3">
                <div>
                    <h2 class="text-lg font-semibold leading-7 text-gray-900">Data Diri</h2>
                    <p class="mt-1 text-sm leading-6 text-gray-600">Informasi ini akan ditampilkan secara publik. Harap berhati-hati dengan apa yang Anda bagikan.</p>
                </div>

                <div class="grid max-w-2xl grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6 md:col-span-2">
                    <!-- Input Foto Profil -->
                    <div class="col-span-full">
                        <label for="photo" class="block text-sm font-medium leading-6 text-gray-900">Foto Profil</label>
                        <div class="mt-2 flex items-center gap-x-3">
                            @if (Auth::user()->profile_picture == null)
                                @if (Auth::user()->role == 'user')
                                    <img id="profileImagePreview" class="h-12 w-12 rounded-full" src="{{ asset('img/profile-icon/user.png') }}" alt="Profil Default">
                                @elseif (Auth::user()->role == 'admin')
                                    <img id="profileImagePreview" class="h-12 w-12 rounded-full" src="{{ asset('img/profile-icon/admin.png') }}" alt="Profil Default Admin">
                                @endif
                            @else
                                <img id="profileImagePreview" class="h-12 w-12 rounded-full" src="{{ asset('storage/' . Auth::user()->profile_picture) }}" alt="Profil User">
                            @endif
                            <button type="button" id="changePhotoBtn" class="rounded-md bg-white px-2.5 py-1.5 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">Ubah</button>
                            <input type="file" id="photoInput" name="photo" class="hidden"> <!-- Input file yang disembunyikan -->
                        </div>
                    </div>

                    <!-- Input Nama -->
                    <div class="sm:col-span-4">
                        <label for="nama" class="block text-sm font-medium leading-6 text-gray-900">Nama</label>
                        <div class="mt-2">
                            <input type="text" name="nama" id="nama" class="block w-full rounded-md border-gray-300 py-2 px-4 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="Masukkan nama" value="{{ Auth::user()->name }}">
                        </div>
                    </div>

                    <!-- Input Username -->
                    <div class="sm:col-span-4">
                        <label for="username" class="block text-sm font-medium leading-6 text-gray-900">Username</label>
                        <div class="mt-2">
                            <input type="text" name="username" id="username" class="block w-full rounded-md border-gray-300 py-2 px-4 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="Masukkan username" value="{{ Auth::user()->username }}">
                        </div>
                    </div>

                    <!-- Input Email -->
                    <div class="sm:col-span-4">
                        <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Alamat Email</label>
                        <div class="mt-2">
                            <input type="email" name="email" id="email" class="block w-full rounded-md border-gray-300 py-2 px-4 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="Masukkan email" value="{{ Auth::user()->email }}">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tombol Simpan untuk Data Diri -->
            <div class="mt-6 flex items-center justify-end gap-x-6">
                <a href="{{ url()->previous() }}" class="text-sm font-semibold leading-6 text-gray-900">Kembali</a>
                <button type="submit" class="rounded-md bg-indigo-600 px-5 py-2 text-sm font-semibold text-white shadow-lg hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:ring-offset-2">Simpan</button>
            </div>
        </form>

        <!-- Form Keamanan -->
        <form action="{{ route('profile.updatePassword') }}" method="POST" class="space-y-12">
            @csrf
            @method('PUT') <!-- Menggunakan method PUT untuk update -->
            <div class="grid grid-cols-1 gap-x-8 gap-y-10 border-t border-gray-900/10 pt-12 md:grid-cols-3">
                <div>
                    <h2 class="text-lg font-semibold leading-7 text-gray-900">Keamanan</h2>
                    <p class="mt-1 text-sm leading-6 text-gray-600">Pastikan kata sandi Anda aman.</p>
                </div>

                <div class="grid max-w-2xl grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6 md:col-span-2">
                    <!-- Input Kata Sandi Lama -->
                    <div class="sm:col-span-4">
                        <label for="current_password" class="block text-sm font-medium leading-6 text-gray-900">Kata Sandi Lama</label>
                        <div class="mt-2">
                            <input type="password" name="current_password" id="current_password" class="block w-full rounded-md border-gray-300 py-2 px-4 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="Masukkan kata sandi lama">
                        </div>
                    </div>

                    <!-- Input Kata Sandi Baru -->
                    <div class="sm:col-span-4">
                        <label for="new_password" class="block text-sm font-medium leading-6 text-gray-900">Kata Sandi Baru</label>
                        <div class="mt-2">
                            <input type="password" name="new_password" id="new_password" class="block w-full rounded-md border-gray-300 py-2 px-4 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="Masukkan kata sandi baru">
                        </div>
                    </div>

                    <!-- Konfirmasi Kata Sandi Baru -->
                    <div class="sm:col-span-4">
                        <label for="confirm_new_password" class="block text-sm font-medium leading-6 text-gray-900">Konfirmasi Kata Sandi Baru</label>
                        <div class="mt-2">
                            <input type="password" name="confirm_new_password" id="confirm_new_password" class="block w-full rounded-md border-gray-300 py-2 px-4 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="Konfirmasi kata sandi baru">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tombol Simpan untuk Keamanan -->
            <div class="mt-6 flex items-center justify-end gap-x-6">
                <a href="{{ url()->previous() }}" class="text-sm font-semibold leading-6 text-gray-900">Kembali</a>
                <button type="submit" class="rounded-md bg-indigo-600 px-5 py-2 text-sm font-semibold text-white shadow-lg hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:ring-offset-2">Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- JavaScript to trigger file input and handle alert -->
<script>
    document.getElementById('changePhotoBtn').addEventListener('click', function() {
        document.getElementById('photoInput').click();
    });

    document.getElementById('photoInput').addEventListener('change', function(event) {
        const input = event.target;
        const reader = new FileReader();
        
        reader.onload = function() {
            const imagePreview = document.getElementById('profileImagePreview');
            imagePreview.src = reader.result;
        };

        if (input.files && input.files[0]) {
            reader.readAsDataURL(input.files[0]);
        }
    });

    // Menghapus alert secara otomatis setelah beberapa detik
    document.addEventListener('DOMContentLoaded', function() {
        const alertBox = document.getElementById('success-alert');
        if (alertBox) {
            setTimeout(() => {
                alertBox.remove();
            }, 5000); // Menghapus alert setelah 5 detik
        }
    });
    
</script>

@endsection