@extends('layouts.app')

@section('title', 'E-Learning - Ruang Budaya')

@section('content')

<!-- Alert untuk pesan sukses -->
@if (session('success'))
<div id="success-alert" class="fixed top-5 right-5 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded shadow-md" role="alert">
    <strong>Berhasil!</strong> {{ session('success') }}
</div>
@endif

<div class="min-h-full flex justify-center items-center pt-12 bg-white"> <!-- Background putih -->
    <div class="relative overflow-hidden isolate max-w-screen-xl w-full px-8 rounded-[30px] bg-white shadow-lg"> 
      <!-- Gambar Hero -->
      <img src="https://images.unsplash.com/photo-1532012197267-da84d127e765?q=80&w=1887&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="Hero Image" class="absolute inset-0 object-cover w-full h-full rounded-[30px] -z-10" style="max-height: 500px;">

      <!-- Overlay putih dengan transparansi -->
      <div class="absolute inset-0 bg-white opacity-30 rounded-[30px] -z-10"></div>

      <div class="absolute inset-x-0 overflow-hidden -top-40 -z-10 transform-gpu blur-3xl sm:-top-80" aria-hidden="true">
        <div class="relative left-[calc(50%-11rem)] aspect-[1155/678] w-[36.125rem] -translate-x-1/2 rotate-[30deg] bg-gradient-to-tr from-[#ff80b5] to-[#9089fc] opacity-20 sm:left-[calc(50%-30rem)] sm:w-[72.1875rem]" style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)"></div>
      </div>
      
      <div class="max-w-2xl py-36 mx-auto sm:py-48 lg:py-56">
        <div class="text-center">
          <h1 class="text-4xl font-bold tracking-tight text-blue-900 sm:text-5xl">Perpustakaan Buku</h1>
        </div>
      </div>
    </div>
</div>

<!-- Search and Add Book Section -->
<div class="bg-white py-12"> <!-- Background tetap putih -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-end items-center gap-4"> <!-- Flexbox untuk menempatkan search bar dan tombol di kanan -->
        
        <!-- Search Bar -->
        <div class="relative w-full max-w-lg">
            <input type="text" class="w-full py-3 px-5 rounded-full border-2 border-blue-400 shadow-lg focus:ring-2 focus:ring-blue-500 focus:outline-none text-gray-700 placeholder-gray-400 transition duration-300" placeholder="Cari judul, penulis, atau kategori...">
            <button class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-full shadow-md transition duration-300">Cari</button>
        </div>

        <!-- Tombol Tambah Buku -->
        @auth
            @if (Auth::user()->role == 'admin')
                <a href="{{ route('library.create') }}" class="px-6 py-3 bg-gradient-to-r from-blue-500 to-blue-600 text-white text-sm font-semibold rounded-full shadow-lg hover:from-blue-600 hover:to-blue-700 transition-all duration-300">
                    Tambah Buku
                </a>
            @endif
        @endauth
    </div>
</div>

<!-- Book List Section -->
<div class="bg-white py-16"> <!-- Bagian ini tetap putih -->
    <div class="mx-auto max-w-2xl px-4 sm:px-6 lg:max-w-7xl lg:px-8">
        <div class="grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-3 xl:gap-x-8">
            @forelse ( $books as $book )
                <div class="group block rounded-lg shadow-lg overflow-hidden bg-white hover:shadow-xl transition duration-300">
                    <a href="{{ route('library.show', $book->slug) }}" class="block">
                        <div class="aspect-w-3 aspect-h-4 sm:aspect-w-2 sm:aspect-h-3">
                            <img src="{{ asset('storage/'. $book->thumbnail) }}" alt="Buku Warisan Budaya" class="h-full w-full object-cover object-center group-hover:opacity-90">
                        </div>
                    </a>
                    <div class="p-4">
                        <a href="{{ route('library.show', $book->slug) }}">
                            <h3 class="font-semibold text-lg text-gray-900">
                                {{ $book->title }}
                            </h3>
                        </a>
                        <p class="mt-1 text-sm text-gray-600">{{ $book->author }}</p>
                        @auth
                            @if (Auth::user()->role == 'admin')
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('library.edit', $book->slug) }}" class="text-white bg-green-500/90 p-2 rounded-lg">
                                    <i class='bx bx-edit-alt'></i>
                                </a>
                                <form action="{{ route('library.destroy', $book->slug) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus berita ini?')" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-white bg-red-500/90 p-2 rounded-lg">
                                      <i class='bx bxs-trash'></i>
                                    </button>
                                </form>
                            </div>
                            @endif
                        @endauth
                    </div>
                </div>            
            @empty
                
            @endforelse
        </div>
    </div>
</div>

<script>
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
