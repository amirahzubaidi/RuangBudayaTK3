@extends('layouts.app')

@section('title', ' - Ruang Budaya')

@section('content')
<!-- Blog post with featured image -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="max-w-3xl mx-auto">
        <!-- Tombol Kembali di atas artikel -->
        <a href="{{ url()->previous() }}" class="text-blue-600 font-semibold text-sm hover:text-blue-800 transition duration-300">
            &larr; Kembali
        </a>

        <!-- Blog post header -->
        <div class="pb-8">
            <h1 class="text-3xl font-bold mb-2">{{ $article->title }}</h1>
            <p class="text-gray-500 text-sm">Published on <time datetime="{{ $article->created_at->toDateString() }}">
                {{ $article->created_at->format('D, d F Y') }}
              </time>     
            </p>
        </div>

        <!-- Featured image -->
        <img src="{{ asset('storage/' . $article->thumbnail) }}" alt="Featured image" class="w-full h-auto mb-8">

        <!-- Blog post content -->
        <div class="prose prose-sm sm:prose lg:prose-lg xl:prose-xl mx-auto">
            {!! $article->content !!}
        </div>

        <!-- Tombol Kembali di bawah artikel -->
        <div class="mt-8">
            <a href="{{ url()->previous() }}" class="text-blue-600 font-semibold text-sm hover:text-blue-800 transition duration-300">
                &larr; Kembali
            </a>
        </div>
    </div>
</div>
@endsection