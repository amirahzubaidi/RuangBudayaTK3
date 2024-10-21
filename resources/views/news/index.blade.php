@extends('layouts.app')

@section('title', 'Berita Terkini - Ruang Budaya')

@section('content')

<!-- Alert untuk pesan sukses -->
@if (session('success'))
<div id="success-alert" class="fixed top-5 right-5 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded shadow-md" role="alert">
    <strong>Berhasil!</strong> {{ session('success') }}
</div>
@endif

<div class="min-h-full flex justify-center items-center pt-12 bg-white">
    <div class="relative overflow-hidden isolate max-w-screen-xl w-full px-8 rounded-[30px] bg-white shadow-lg">
      <img src="https://img.freepik.com/free-photo/nyepi-day-celebration-indonesia_23-2151325665.jpg?t=st=1729437501~exp=1729441101~hmac=37fcb030c5997f2e58886e6fef0a7d821b83987f109a3b814b0f1b085d4edf97&w=1060" alt="Hero Image" class="absolute inset-0 object-cover w-full h-full rounded-[30px] -z-10">
      <div class="absolute inset-0 bg-white opacity-30 rounded-[30px] -z-10"></div>
      <div class="absolute inset-x-0 overflow-hidden -top-40 -z-10 transform-gpu blur-3xl sm:-top-80" aria-hidden="true">
        <div class="relative left-[calc(50%-11rem)] aspect-[1155/678] w-[36.125rem] -translate-x-1/2 rotate-[30deg] bg-gradient-to-tr from-[#ff80b5] to-[#9089fc] opacity-20 sm:left-[calc(50%-30rem)] sm:w-[72.1875rem]" style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)"></div>
      </div>
      
      <div class="max-w-2xl py-36 mx-auto sm:py-48 lg:py-56">
        <div class="text-center">
          <h1 class="text-4xl font-bold tracking-tight text-gray-950 sm:text-5xl">Berita Terkini</h1>
        </div>
      </div>
    </div>
</div>

<div class="bg-white py-24 sm:py-32 relative">
    <div class="mx-auto max-w-7xl px-6 lg:px-8">
      <div class="flex items-center justify-between">
        <div class="mx-auto max-w-2xl text-center">
            <p class="mt-2 text-lg leading-8 text-gray-600">Kumpulan Informasi Terbaru dan Terlengkap tentang Perkembangan Budaya, Sosial, dan Isu-Isu Terkini</p>
          </div>
      </div>
  
         @auth
          @if(Auth::user()->role == 'admin')
          <div class="mt-16 flex justify-center">
            <a href="{{ route('news.create') }}" class="px-4 py-2 bg-indigo-600 text-white text-sm font-semibold rounded-md hover:bg-indigo-500">
              Tambah Berita
              </a>
            </div>
            @endif
          @endauth
      <div class="mx-auto mt-16 grid max-w-2xl auto-rows-fr grid-cols-1 gap-8 sm:mt-20 lg:mx-0 lg:max-w-none lg:grid-cols-3">
        @forelse ($news as $article)
          <article class="relative isolate flex flex-col justify-end overflow-hidden rounded-2xl bg-gray-900 px-8 pb-8 pt-80 sm:pt-48 lg:pt-80">
            <img src="{{ asset('storage/' . $article->thumbnail) }}" alt="" class="absolute inset-0 -z-10 h-full w-full object-cover">
            <div class="absolute inset-0 -z-10 bg-gradient-to-t from-gray-900 via-gray-900/40"></div>
            <div class="absolute inset-0 -z-10 rounded-2xl ring-1 ring-inset ring-gray-900/10"></div>
    
            <div class="flex flex-wrap items-center gap-y-1 overflow-hidden text-sm leading-6 text-gray-300">
            <time datetime="{{ $article->created_at->toDateString() }}" class="mr-8">
                {{ $article->created_at->format('D, d F Y') }}
              </time>            
              <div class="-ml-4 flex items-center gap-x-4">
                <svg viewBox="0 0 2 2" class="-ml-0.5 h-0.5 w-0.5 flex-none fill-white/50">
                  <circle cx="1" cy="1" r="1" />
                </svg>
                <div class="flex gap-x-2.5">
                  <span class="font-semibold">
                    {{ $article->author }}
                  </span>
                </div>
              </div>
            </div>
            <h3 class="mt-3 text-lg font-semibold leading-6 text-white">
              <a href="{{ route('news.show', $article->slug) }}">
                {{ $article->title }}
              </a>
            </h3>
            @auth
              @if (Auth::user()->role == 'admin')
                <div class="absolute top-5 right-5 flex flex-col gap-4 text-xl rounded-md">
                  <a href="{{ route('news.edit', $article->slug) }}" class="text-white bg-green-500/90 p-2 rounded-lg">
                    <i class='bx bx-edit-alt'></i>
                  </a>
                  <form action="{{ route('news.destroy', $article->slug) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus berita ini?')" class="inline">
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
          <p class="text-center text-gray-500">Belum ada berita yang ditambahkan.</p>
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