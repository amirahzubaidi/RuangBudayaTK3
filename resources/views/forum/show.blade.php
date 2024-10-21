@extends('layouts.app')

@section('title', 'Forum Diskusi - Ruang Budaya')

@section('content')

<!-- Div Pertama: Forum -->
<div class="bg-white p-6 rounded-lg shadow-lg mb-6 hover:shadow-xl transition duration-200 max-w-screen-xl mx-auto mt-4">
    <div class="flex items-center justify-between">
        <h2 class="text-2xl font-bold text-gray-800">{{ $thread->title }}</h2>

        <!-- Ikon titik tiga di ujung kanan atas -->
        <div class="relative">
            <button id="dropdownButton" class="focus:outline-none">
                <i class='bx bx-dots-horizontal-rounded text-2xl'></i>
            </button>

            <!-- Dropdown untuk Edit dan Hapus -->
            <div id="dropdownMenu" class="hidden absolute right-0 mt-2 w-32 bg-white border border-gray-200 rounded-lg shadow-lg">
                <a href="#" class="block px-4 py-2 text-sm text-black hover:bg-gray-100">Edit</a>
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
</div>

<!-- Div Kedua: Input Komentar -->
<div class="bg-gray-100/50 p-6 rounded-lg shadow-lg mb-6 hover:shadow-xl transition duration-200 max-w-screen-xl mx-auto mt-4">
    <form action="{{ route('comments.store', $thread->id) }}" method="POST">
        @csrf
        <div class="flex items-center space-x-3">
            <input type="text" name="comment" id="comment" class="w-full p-3 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-600" placeholder="Tulis komentar Anda...">
            <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-500 transition duration-200">
                Kirim
            </button>
        </div>
        @error('comment')
            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
        @enderror
    </form>
</div>

<!-- Div Ketiga: Daftar Komentar -->
<div class="bg-white p-6 rounded-lg shadow-lg mb-6 hover:shadow-xl transition duration-200 max-w-screen-xl mx-auto mt-4">
  <h3 class="text-xl font-semibold text-gray-800 mb-4">Komentar</h3>
  @forelse ($thread->comments as $comment)
      <div class="flex items-start space-x-4 mb-4">
          @if ($comment->user->profile_picture == null)
              @if ($comment->user->role == 'user')
                  <img class="w-8 h-8 rounded-full shadow" src="{{ asset('img/profile-icon/user.png') }}" alt="User Avatar">
              @elseif ($comment->user->role == 'admin')
                  <img class="w-8 h-8 rounded-full shadow" src="{{ asset('img/profile-icon/admin.png') }}" alt="Admin Avatar">
              @endif
          @else
              <img class="w-8 h-8 rounded-full shadow" src="{{ asset('storage/' . $comment->user->profile_picture) }}" alt="User Avatar">
          @endif
          <div class="flex-1">
              <p class="font-semibold text-gray-700 mb-2">
                  {{ ucwords($comment->user->name) }}
                  @if ($comment->user->id == $thread->user_id)
                      <span class="text-sm text-gray-500 bg-gray-500/50 rounded-full px-2 p-1">Author</span>
                  @endif
              </p>
              <p class="text-sm text-gray-500">{{ $comment->created_at->diffForHumans() }}</p>
              <p class="mt-2 text-gray-600">{{ $comment->comment }}</p>

              <!-- Jika pengguna yang login adalah pemilik komentar, tampilkan tombol Edit dan Hapus menggunakan dropdown -->
              @if (Auth::id() == $comment->user_id)
                  <div class="relative">
                      <button id="commentDropdownButton{{ $comment->id }}" class="focus:outline-none mt-2">
                          <i class='bx bx-dots-horizontal-rounded text-xl'></i>
                      </button>

                      <!-- Dropdown untuk Edit dan Hapus Komentar -->
                      <div id="commentDropdownMenu{{ $comment->id }}" class="hidden absolute right-0 mt-2 w-32 bg-white border border-gray-200 rounded-lg shadow-lg z-10">
                          <a href="{{ route('forum.edit', $comment->id) }}" class="block px-4 py-2 text-sm text-black hover:bg-gray-100">Edit</a>
                          <form action="{{ route('forum.destroy', $comment->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus komentar ini?');">
                              @csrf
                              @method('DELETE')
                              <button type="submit" class="w-full text-left block px-4 py-2 text-sm text-black hover:bg-gray-100">Hapus</button>
                          </form>
                      </div>
                  </div>
              @endif
          </div>
      </div>
  @empty
      <p class="text-gray-500">
          Belum ada komentar. Jadilah yang pertama berkomentar!
      </p>
  @endforelse
</div>

<script>
  // Fungsi untuk toggle dropdown setiap komentar
  document.querySelectorAll('[id^="commentDropdownButton"]').forEach(function(button) {
      button.addEventListener('click', function () {
          var commentId = this.id.replace('commentDropdownButton', '');
          var dropdown = document.getElementById('commentDropdownMenu' + commentId);
          if (dropdown.classList.contains('hidden')) {
              dropdown.classList.remove('hidden');
          } else {
              dropdown.classList.add('hidden');
          }
      });
  });

  // Menutup dropdown komentar jika mengklik di luar area dropdown
  document.addEventListener('click', function(event) {
      document.querySelectorAll('[id^="commentDropdownMenu"]').forEach(function(dropdown) {
          var buttonId = dropdown.id.replace('commentDropdownMenu', 'commentDropdownButton');
          var button = document.getElementById(buttonId);

          if (!dropdown.contains(event.target) && !button.contains(event.target)) {
              dropdown.classList.add('hidden');
          }
      });
  });
</script>

@endsection
