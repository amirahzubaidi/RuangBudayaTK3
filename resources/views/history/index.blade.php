@extends('layouts.app')

@section('title', 'History')

@section('content')

<!-- Alert untuk pesan sukses -->
@if (session('success'))
<div id="success-alert" class="fixed top-5 right-5 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded shadow-md z-100" role="alert">
    <strong>Berhasil!</strong> {{ session('success') }}
</div>
@endif

<div class="min-h-full flex justify-center items-center pt-12 bg-white"> <!-- Menambahkan bg-white untuk latar belakang putih -->
  <div class="relative overflow-hidden isolate max-w-screen-xl w-full px-8 rounded-[30px] bg-white shadow-lg z-0"> <!-- Lebar kanan-kiri lebih besar -->
    <!-- Gambar Hero -->
    <img src="https://api.rostro.io/file/city/453/us-passport-photos-near-me-in-bekasi.webp" class="absolute inset-0 object-cover w-full h-full rounded-[30px] -z-10">

    <!-- Overlay putih dengan transparansi -->
    <div class="absolute inset-0 bg-white opacity-30 rounded-[30px] -z-10"></div>

    <div class="absolute inset-x-0 overflow-hidden -top-40 -z-10 transform-gpu blur-3xl sm:-top-80" aria-hidden="true">
      <div class="relative left-[calc(50%-11rem)] aspect-[1155/678] w-[36.125rem] -translate-x-1/2 rotate-[30deg] bg-gradient-to-tr from-[#ff80b5] to-[#9089fc] opacity-20 sm:left-[calc(50%-30rem)] sm:w-[72.1875rem]" style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)"></div>
    </div>
    
    <div class="max-w-2xl py-36 mx-auto sm:py-48 lg:py-56"> <!-- Menambahkan padding vertikal -->
      <div class="text-center">
        <h1 class="text-4xl font-bold tracking-tight text-gray-950 sm:text-5xl">Sejarah Kebudayaan</h1>
      </div>
    </div>
  </div>
</div>

<div class="bg-white py-24 sm:py-32">
  <div class="mx-auto max-w-7xl px-6 lg:px-8">
    <div class="mx-auto max-w-2xl text-center">
      <!-- <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">From the blog</h2> -->
      <p class="mt-2 text-lg leading-8 text-gray-600">Mengenal lebih dalam tentang warisan budaya Indonesia dan jejak kebudayaan yang membentuk jati diri bangsa.</p>
    </div>

    @auth
      @if(Auth::user()->role == 'admin')
        <div class="mt-16 flex justify-center"> <!-- Mengurangi jarak antar section -->
          <a href="{{ route('history.create') }}" class="px-4 py-2 bg-indigo-600 text-white text-sm font-semibold rounded-md hover:bg-indigo-500">
            Tambah Artikel
          </a>
        </div>
      @endif
    @endauth

    <div class="mx-auto mt-16 grid max-w-2xl grid-cols-1 gap-x-8 gap-y-20 lg:mx-0 lg:max-w-none lg:grid-cols-3">
      @forelse ( $histories as $article )
        
      <article class="flex flex-col items-start justify-between">
        <div class="relative w-full">
          <img src="{{ asset('storage/' . $article->thumbnail) }}">
          <div class="absolute inset-0 rounded-2xl ring-1 ring-inset ring-gray-900/10"></div>
        </div>
        <div class="max-w-xl">
          <div class="group relative">
            <h3 class="mt-3 text-lg font-semibold leading-6 text-gray-900 group-hover:text-gray-600">
              <a href="{{ route('history.show', $article->slug) }}">
                {{ $article->title }}
              </a>
            </h3>
            <p class="mt-5 text-sm leading-6 text-gray-600 line-clamp-4">
              {!! str_replace('&nbsp;', ' ', strip_tags($article->content)) !!}
            </p>          
          </div>
          <div class="relative mt-8 flex items-center gap-x-4">
            <div class="text-sm leading-6">
              <p class="font-semibold text-gray-900">
                <a href="#">
                  <span class="absolute inset-0"></span>
                  {{ ucwords($article->author) }}
                </a>
              </p>
            </div>
          </div>
        </div>
        @auth
            @if (Auth::user()->role == 'admin')
            <div class="flex justify-end gap-2">
                <a href="{{ route('history.edit', $article->slug) }}" class="text-white bg-green-500/90 p-2 rounded-lg">
                    <i class='bx bx-edit-alt'></i>
                </a>
                <form action="{{ route('history.destroy', $article->slug) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus berita ini?')" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-white bg-red-500/90 p-2 rounded-lg">
                      <i class='bx bxs-trash'></i>
                    </button>
                </form>
            </div>
            @endif
        @endauth
      </article>
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
