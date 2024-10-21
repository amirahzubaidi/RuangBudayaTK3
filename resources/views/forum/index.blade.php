@extends('layouts.app')

@section('title', 'Forum - Ruang Budaya')

@section('content')

<!-- Alert untuk pesan sukses -->
@if (session('success'))
<div id="success-alert" class="fixed top-5 right-5 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded shadow-md" role="alert">
    <strong>Berhasil!</strong> {{ session('success') }}
</div>
@endif

<head>
  <!-- Memastikan CSS Boxicons dimuat -->
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>

<!-- Hero Section -->
<div class="min-h-full flex justify-center items-center pt-12 bg-white"> 
    <div class="relative overflow-hidden isolate max-w-screen-xl w-full px-8 rounded-[30px] bg-white shadow-lg"> 
      <!-- Gambar Hero -->
      <img src="https://images.unsplash.com/photo-1588196749597-9ff075ee6b5b?q=80&w=1974&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="Hero Image" class="absolute inset-0 object-cover w-full h-full rounded-[30px] -z-10" style="max-height: 500px;">

      <!-- Overlay putih dengan transparansi -->
      <div class="absolute inset-0 bg-white opacity-30 rounded-[30px] -z-10"></div>

      <!-- Efek Blur Background -->
      <div class="absolute inset-x-0 overflow-hidden -top-40 -z-10 transform-gpu blur-3xl sm:-top-80" aria-hidden="true">
        <div class="relative left-[calc(50%-11rem)] aspect-[1155/678] w-[36.125rem] -translate-x-1/2 rotate-[30deg] bg-gradient-to-tr from-[#ff80b5] to-[#9089fc] opacity-20 sm:left-[calc(50%-30rem)] sm:w-[72.1875rem]" style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)"></div>
      </div>
      
      <div class="max-w-2xl py-36 mx-auto sm:py-48 lg:py-56">
        <div class="text-center">
          <h1 class="text-4xl font-bold tracking-tight text-blue-900 sm:text-5xl">Forum Diskusi</h1>
        </div>
      </div>
    </div>
</div>

<!-- Konten Forum Diskusi -->
<div class="min-h-screen bg-white py-12">
  <div class="container mx-auto px-6">
    
    <!-- Search Bar dan Add Thread -->
    <div class="flex items-center justify-between mb-6">
      
      <!-- Tombol Add Thread -->
      @auth
        <a href="{{ route('forum.create') }}" class="bg-blue-900 text-white py-3 px-6 rounded-lg flex items-center space-x-2 hover:bg-blue-700 shadow-md transition duration-200">
          <span class="font-semibold">Buat Topik Baru</span>
          <i class='bx bx-plus text-xl'></i>
        </a>
      @endauth

      <!-- Search Bar -->
      <div class="relative w-full sm:w-auto max-w-md ml-auto">
        <input type="text" placeholder="Cari topik diskusi..." class="w-full py-3 pl-4 pr-12 text-sm bg-white border border-gray-300 rounded-full shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent transition duration-200">
        <div class="absolute inset-y-0 right-0 flex items-center pr-3">
          <i class='bx bx-search text-xl text-gray-500'></i>
        </div>
      </div>
    </div>
    
<!-- Forum -->
@forelse ($forums as $thread)
  <div class="bg-white p-6 rounded-lg shadow-lg mb-6 hover:shadow-xl transition duration-200">
    <div class="flex items-center justify-between">
      <h2 class="text-2xl font-bold text-gray-800">{{ $thread->title }}</h2>

      <!-- Ikon titik tiga di ujung kanan atas -->
      <div class="relative">
        <button id="dropdownButton-{{ $thread->id }}" class="focus:outline-none">
          <i class='bx bx-dots-horizontal-rounded text-2xl'></i>
        </button>

        <!-- Dropdown untuk Edit dan Hapus -->
        <div id="dropdownMenu-{{ $thread->id }}" class="hidden absolute right-0 mt-2 w-32 bg-white border border-gray-200 rounded-lg shadow-lg">
            <a href="{{ route('forum.edit', $thread->slug) }}" class="block px-4 py-2 text-sm text-black hover:bg-gray-100">Edit</a>
            <form action="{{ route('forum.destroy', $thread->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus thread ini?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="w-full text-left block px-4 py-2 text-sm text-black hover:bg-gray-100">Hapus</button>
            </form>
        </div>
      </div>
    </div>
    
    <div class="mt-4 flex items-center space-x-4">
      @if ($thread->user->profile_picture == null)
          @if ($thread->user->role == 'user')
              <img class="w-10 h-10 rounded-full shadow" src="{{ asset('img/profile-icon/user.png') }}" alt="User Avatar">
          @elseif ($thread->user->role == 'admin')
              <img class="w-10 h-10 rounded-full shadow" src="{{ asset('img/profile-icon/admin.png') }}" alt="Admin Avatar">
          @endif
      @else
          <img class="w-10 h-10 rounded-full shadow" src="{{ asset('storage/' . $thread->user->profile_picture) }}" alt="User Avatar">
      @endif
      <div>
        <p class="font-semibold text-gray-700">{{ ucwords($thread->user->name) }}</p>
        <p class="text-sm text-gray-500">{{ $thread->created_at->diffForHumans() }}</p>
      </div>
    </div>

    <p class="mt-4 text-gray-600 leading-relaxed line-clamp-4">
      {!! str_replace('&nbsp;', ' ', strip_tags($thread->content)) !!}
    </p>

    <!-- Response dan Interaksi -->
    <div class="mt-6 flex justify-between items-center">
      <button class="bg-gray-100 hover:bg-gray-200 text-gray-600 font-semibold py-2 px-4 rounded-lg flex items-center space-x-2 transition duration-200">
        <i class='bx bx-message'></i>
        <a href="{{ route('forum.show', $thread->slug) }}">Komentar</a>
      </button>

      <div class="flex items-center space-x-3">
          <div class="flex -space-x-2 ">
              @foreach ($thread->comments->take(3) as $comment)
                  <img src="{{ $comment->user->profile_picture ? asset('storage/' . $comment->user->profile_picture) : asset('img/profile-icon/user.png') }}" 
                      alt="{{ $comment->user->name }}" 
                      class="w-8 h-8 rounded-full border-2 border-white shadow-sm">
              @endforeach
          </div>
          <span class="text-sm text-gray-500">
              @if ($thread->comments->count() > 3)
                  +{{ $thread->comments->count() - 3 }}
              @endif
          </span>
      </div>
    </div>
  </div>
@empty
    <p class="text-gray-500">Belum ada topik diskusi. Jadilah yang pertama untuk memulai!</p>
@endforelse

  </div>
</div>

<script>
  // Fungsi untuk toggle dropdown
  @foreach ($forums as $thread)
    document.getElementById('dropdownButton-{{ $thread->id }}').addEventListener('click', function () {
        var dropdown = document.getElementById('dropdownMenu-{{ $thread->id }}');
        dropdown.classList.toggle('hidden');
    });

    // Menutup dropdown jika mengklik di luar area dropdown
    document.addEventListener('click', function(event) {
        var dropdown = document.getElementById('dropdownMenu-{{ $thread->id }}');
        var button = document.getElementById('dropdownButton-{{ $thread->id }}');

        if (!dropdown.contains(event.target) && !button.contains(event.target)) {
            dropdown.classList.add('hidden');
        }
    });
  @endforeach

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
