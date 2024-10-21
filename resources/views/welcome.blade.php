@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
{{-- Hero Section --}}
<div class="min-h-full bg-white"> <!-- Mengganti latar belakang Hero menjadi putih -->
    <div class="relative overflow-hidden isolate pt-14">
        <!-- Gambar Hero -->
        <img src="https://www.batiksimonet.id/wp-content/uploads/2024/02/3d41f0b2-dc02-4bbf-8169-6a9eafeb7c65-1536x878.webp" alt="Hero Image" class="absolute inset-0 object-cover w-full h-full -z-10">

        <!-- Overlay putih dengan transparansi -->
        <div class="absolute inset-0 bg-white opacity-30 -z-10"></div>

        <div class="absolute inset-x-0 overflow-hidden -top-40 -z-10 transform-gpu blur-3xl sm:-top-80" aria-hidden="true">
            <div class="relative left-[calc(50%-11rem)] aspect-[1155/678] w-[36.125rem] -translate-x-1/2 rotate-[30deg] bg-gradient-to-tr from-[#ff80b5] to-[#9089fc] opacity-20 sm:left-[calc(50%-30rem)] sm:w-[72.1875rem]" style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)"></div>
        </div>
        <div class="max-w-2xl py-32 mx-auto sm:py-48 lg:py-56">
            <div class="text-center">
                <h1 class="text-4xl font-bold tracking-tight text-gray-950 sm:text-6xl">Selamat Datang di Ruang Budaya</h1>
            </div>
        </div>
    </div>
</div>

<!-- Bagian Buku Populer -->
<div class="bg-white"> 
    <div class="max-w-2xl px-4 py-24 mx-auto sm:px-6 sm:py-32 lg:max-w-7xl lg:px-8">
        <!-- Details section -->
        <section aria-labelledby="details-heading">
            <div class="flex items-center justify-between">
                <h2 id="details-heading" class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Buku Populer Indonesia</h2>
                <a href="/library" class="text-indigo-600 hover:text-indigo-500 text-sm font-semibold">Lihat Semua</a>
            </div>

            <div class="grid grid-cols-1 mt-16 gap-y-16 lg:grid-cols-2 lg:gap-x-8">
                <!-- Buku 1 -->
                <div>
                    <!-- Membungkus gambar dengan tautan -->
                    <a href="/library">
                        <div class="w-full overflow-hidden rounded-lg aspect-h-2 aspect-w-3">
                            <img src="https://store.penerbitwidina.com/wp-content/uploads/2024/04/WhatsApp-Image-2024-04-19-at-14.52.03_780ace1d.jpg" alt="Buku tentang Filsafat" class="object-cover object-center w-full h-full">
                        </div>
                    </a>
                    <p class="mt-8 text-base text-gray-500">Buku ini mengulas berbagai perspektif dan konsep filsafat yang berpengaruh dalam kebudayaan Indonesia, menjadi rujukan penting bagi para akademisi dan peminat filsafat.</p>
                </div>

                <!-- Buku 2 -->
                <div>
                    <!-- Membungkus gambar dengan tautan -->
                    <a href="/library">
                        <div class="w-full overflow-hidden rounded-lg aspect-h-2 aspect-w-3">
                            <img src="https://store.penerbitwidina.com/wp-content/uploads/2023/09/WhatsApp-Image-2023-09-18-at-10.04.46-1.jpeg" alt="Buku Kearifan Lokal" class="object-cover object-center w-full h-full">
                        </div>
                    </a>
                    <p class="mt-8 text-base text-gray-500">Kearifan Lokal Indonesia: Panduan ini mengeksplorasi kebudayaan lokal dan bagaimana tradisi masyarakat Indonesia mempengaruhi perkembangan sosial dan ekonomi di masa kini.</p>
                </div>
            </div>
        </section>
    </div>
</div>


<!-- Bagian Berita Terkini -->
<div class="bg-white py-24 sm:py-32"> <!-- Menggunakan bg-white -->
    <div class="mx-auto max-w-7xl px-6 lg:px-8">
        <div class="flex items-center justify-between">
            <div class="max-w-2xl">
                <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Berita Terkini</h2>
            </div>
            <a href="/news" class="text-indigo-600 hover:text-indigo-500 text-sm font-semibold lg:mr-0">Lihat Semua</a>
        </div>

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
                        <img src="https://images.unsplash.com/photo-1519244703995-f4e0f30006d5?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="" class="h-6 w-6 flex-none rounded-full bg-white/10">
                        {{ $article->author }}
                        </div>
                    </div>
                    </div>
                    <h3 class="mt-3 text-lg font-semibold leading-6 text-white">
                    <a href="{{ route('news.show', $article->slug) }}">
                        {{ $article->title }}
                    </a>
                    </h3>
                    <div class="absolute top-5 right-5 flex flex-col gap-4 text-xl">
                    <a href="" class="text-white">
                        <i class='bx bx-edit-alt'></i>
                    </a>
                    <a href="" class="text-white" onclick="return confirm('Apakah Anda yakin ingin menghapus berita ini?')">
                        <i class='bx bxs-trash'></i>
                    </a>
                    </div>
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
