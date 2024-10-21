@extends('layouts.app')

@section('title', 'Tambah Data Buku - Ruang Budaya')

@section('content')
<!-- Form Section -->
<div class="min-h-screen flex flex-col justify-center items-center py-12">
    
  <!-- Judul di Tengah Atas -->
  <h1 class="text-4xl font-bold tracking-tight text-gray-900 mb-8">Tambah Buku Digital</h1>

  <form action="{{ route('library.store') }}" method="POST" enctype="multipart/form-data" class="w-full max-w-4xl">
      @csrf <!-- CSRF Token -->
      <div class="space-y-12">
          <div class="grid grid-cols-1 gap-x-8 gap-y-10 pb-12 md:grid-cols-3">
              <div>
                  <h2 class="text-lg font-semibold leading-7 text-gray-900">Informasi Buku</h2>
                  <p class="mt-1 text-sm leading-6 text-gray-600">Silakan isi informasi yang diperlukan untuk menambahkan buku digital baru.</p>
              </div>

              <div class="grid max-w-2xl grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6 md:col-span-2">
                  
                  <!-- Input Judul Buku -->
                  <div class="sm:col-span-4">
                      <label for="judul" class="block text-sm font-medium leading-6 text-gray-900">Judul Buku</label>
                      <div class="mt-2">
                          <input type="text" name="judul" id="judul" value="{{ old('judul') }}" class="block w-full rounded-md border-0 py-2 px-4 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder="Masukkan judul buku">
                          @error('judul')
                              <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                          @enderror
                      </div>
                  </div>

                  <!-- Input Pengarang -->
                  <div class="sm:col-span-4">
                      <label for="pengarang" class="block text-sm font-medium leading-6 text-gray-900">Pengarang</label>
                      <div class="mt-2">
                          <input type="text" name="pengarang" id="pengarang" value="{{ old('pengarang') }}" class="block w-full rounded-md border-0 py-2 px-4 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder="Nama pengarang">
                          @error('pengarang')
                              <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                          @enderror
                      </div>
                  </div>

                  <!-- Input Tahun Publikasi -->
                  <div class="sm:col-span-4">
                      <label for="tahun-publikasi" class="block text-sm font-medium leading-6 text-gray-900">Tahun Publikasi</label>
                      <div class="mt-2">
                          <input type="number" name="tahun-publikasi" id="tahun-publikasi" min="1900" max="2099" step="1" value="{{ old('tahun-publikasi') }}" class="block w-full rounded-md border-0 py-2 px-4 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder="Tahun publikasi">
                          @error('tahun-publikasi')
                              <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                          @enderror
                      </div>
                  </div>                        

                  <!-- Input Dokumen PDF untuk File Buku Digital -->
                  <div class="col-span-full">
                      <label for="file_input" class="block text-sm font-medium leading-6 text-gray-900">Upload Buku Digital</label>
                      <div class="mt-2">
                          <label for="file_input" class="inline-flex items-center justify-center rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white cursor-pointer hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:ring-offset-2">
                              Pilih File
                          </label>
                          <input type="file" name="pdf-file" id="file_input" accept=".pdf" class="sr-only" onchange="updateFileName(this)">
                          <span id="file-name" class="ml-2 text-gray-900">Belum ada file yang dipilih</span>
                          @error('pdf-file')
                              <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                          @enderror
                      </div>
                      <p class="mt-1 text-sm text-gray-600">Format file: PDF.</p>
                  </div>         

                  <!-- Input Foto Sampul dengan Preview -->
                  <div class="col-span-full">
                      <label for="thumbnail" class="block text-sm font-medium leading-6 text-gray-900">Foto Sampul</label>
                      <div class="mt-2 flex justify-center rounded-lg border border-dashed border-gray-900/25 px-6 py-10">
                          <div class="text-center">
                              <svg class="mx-auto h-12 w-12 text-gray-300" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                  <path fill-rule="evenodd" d="M1.5 6a2.25 2.25 0 012.25-2.25h16.5A2.25 2.25 0 0122.5 6v12a2.25 2.25 0 01-2.25 2.25H3.75A2.25 2.25 0 011.5 18V6zM3 16.06V18c0 .414.336.75.75.75h16.5A.75.75 0 0021 18v-1.94l-2.69-2.689a1.5 1.5 0 00-2.12 0l-.88.879.97.97a.75.75 0 11-1.06 1.06l-5.16-5.159a1.5 1.5 0 00-2.12 0L3 16.061zm10.125-7.81a1.125 1.125 0 112.25 0 1.125 1.125 0 01-2.25 0z" clip-rule="evenodd" />
                              </svg>
                              <div class="mt-4 flex text-sm leading-6 text-gray-600">
                                  <label for="thumbnail" class="relative cursor-pointer rounded-md bg-white font-semibold text-indigo-600 focus-within:outline-none focus-within:ring-2 focus-within:ring-indigo-600 focus-within:ring-offset-2 hover:text-indigo-500">
                                      <span>Upload foto</span>
                                      <input id="thumbnail" name="thumbnail" type="file" class="sr-only" onchange="previewImage(event)">
                                  </label>
                                  <p class="pl-1">atau seret file ke sini</p>
                              </div>
                              <p class="text-xs leading-5 text-gray-600">PNG, JPG, GIF up to 10MB</p>
                              <!-- Tempat menampilkan preview gambar -->
                              <img id="image-preview" class="mt-5 mx-auto h-48 w-48 object-cover rounded-lg" style="display: none;">
                          </div>
                      </div>
                      @error('thumbnail')
                          <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                      @enderror
                  </div>

              </div>
          </div>
      </div>

      <!-- Tombol Save dan Cancel -->
      <div class="mt-6 flex items-center justify-end gap-x-6">
          <button type="button" class="text-sm font-semibold leading-6 text-gray-900">Kembali</button>
          <button type="submit" class="rounded-md bg-indigo-600 px-5 py-2 text-sm font-semibold text-white shadow-lg hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Simpan</button>
      </div>
  </form>
</div>

<!-- Script untuk preview gambar -->
<script>
  function updateFileName(input) {
      const fileName = input.files.length > 0 ? input.files[0].name : 'Belum ada file yang dipilih';
      document.getElementById('file-name').textContent = fileName;
  }

  // Fungsi untuk preview gambar
  function previewImage(event) {
      var input = event.target;
      var reader = new FileReader();

      reader.onload = function(){
          var imagePreview = document.getElementById('image-preview');
          imagePreview.src = reader.result;
          imagePreview.style.display = 'block';
      }

      if (input.files && input.files[0]) {
          reader.readAsDataURL(input.files[0]);
      }
  }
</script>

@endsection
