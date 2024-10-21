<?php

namespace App\Http\Controllers\Library;

use App\Models\Library;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class LibraryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $books = Library::get();

        return view('library.index', compact('books'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('library.create');
    }

    public function store(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'judul' => 'required|string|max:255',
            'pengarang' => 'required|string|max:255',
            'tahun-publikasi' => 'required|numeric|digits:4|min:1900|max:' . date('Y'),
            'pdf-file' => 'required|mimes:pdf|max:20480', // Max size: 20MB
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif|max:10240', // Max size: 10MB
        ], [
            'judul.required' => 'Judul buku wajib diisi.',
            'pengarang.required' => 'Pengarang buku wajib diisi.',
            'tahun-publikasi.required' => 'Tahun publikasi wajib diisi.',
            'pdf-file.required' => 'File buku digital wajib diunggah.',
            'pdf-file.mimes' => 'File buku harus berupa PDF.',
            'pdf-file.max' => 'Ukuran file PDF maksimal 20MB.',
            'thumbnail.required' => 'File thumbnail wajib diisi.',
            'thumbnail.image' => 'File thumbnail harus berupa gambar.',
            'thumbnail.mimes' => 'Format gambar harus jpeg, png, jpg, atau gif.',
            'thumbnail.max' => 'Ukuran gambar maksimal 10MB.',
        ]);

        // Upload file PDF
        if ($request->hasFile('pdf-file')) {
            $pdfPath = $request->file('pdf-file')->store('books', 'public');
            $validatedData['file_url'] = $pdfPath;
        }

        // Upload thumbnail jika ada
        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $request->file('thumbnail')->store('thumbnails', 'public');
            $validatedData['thumbnail'] = $thumbnailPath;
        } else {
            $validatedData['thumbnail'] = null;
        }

        // Menyimpan data ke dalam tabel 'libraries'
        $validatedData['title'] = $request->judul;
        $validatedData['author'] = $request->pengarang;
        $validatedData['published_year'] = $request->input('tahun-publikasi');
        $validatedData['slug'] = Str::slug($request->judul);

        Library::create($validatedData);

        return redirect()->route('library.index')->with('success', 'Buku digital berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $slug)
    {
        $book = Library::where('slug', $slug)->first();
        return view('library.show', compact('book'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($slug)
    {
        $book = Library::where('slug', $slug)->first();
        return view('library.edit', compact('book'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $slug)
    {
        // Temukan buku berdasarkan slug
        $book = Library::where('slug', $slug)->firstOrFail();

        // Validasi input
        $validatedData = $request->validate([
            'judul' => 'required|string|max:255',
            'pengarang' => 'required|string|max:255',
            'tahun-publikasi' => 'required|numeric|digits:4|min:1900|max:' . date('Y'),
            'pdf-file' => 'nullable|mimes:pdf|max:20480', // Max size: 20MB, optional on update
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240', // Max size: 10MB, optional on update
        ], [
            'judul.required' => 'Judul buku wajib diisi.',
            'pengarang.required' => 'Pengarang buku wajib diisi.',
            'tahun-publikasi.required' => 'Tahun publikasi wajib diisi.',
            'pdf-file.mimes' => 'File buku harus berupa PDF.',
            'pdf-file.max' => 'Ukuran file PDF maksimal 20MB.',
            'thumbnail.image' => 'File thumbnail harus berupa gambar.',
            'thumbnail.mimes' => 'Format gambar harus jpeg, png, jpg, atau gif.',
            'thumbnail.max' => 'Ukuran gambar maksimal 10MB.',
        ]);

        // Update file PDF jika diunggah
        if ($request->hasFile('pdf-file')) {
            // Hapus file PDF lama jika ada
            if ($book->file_url) {
                Storage::disk('public')->delete($book->file_url);
            }

            // Simpan file PDF baru
            $pdfPath = $request->file('pdf-file')->store('books', 'public');
            $validatedData['file_url'] = $pdfPath;
        }

        // Update thumbnail jika diunggah
        if ($request->hasFile('thumbnail')) {
            // Hapus thumbnail lama jika ada
            if ($book->thumbnail) {
                Storage::disk('public')->delete($book->thumbnail);
            }

            // Simpan thumbnail baru
            $thumbnailPath = $request->file('thumbnail')->store('thumbnails', 'public');
            $validatedData['thumbnail'] = $thumbnailPath;
        }

        // Update data buku
        $validatedData['title'] = $request->judul;
        $validatedData['author'] = $request->pengarang;
        $validatedData['published_year'] = $request->input('tahun-publikasi');
        $validatedData['slug'] = Str::slug($request->judul);

        // Simpan perubahan pada database
        $book->update($validatedData);

        return redirect()->route('library.index')->with('success', 'Data buku berhasil diperbarui.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($slug)
    {
        $book = Library::where('slug', $slug)->firstOrFail();
        Storage::disk('public')->delete($book->thumbnail);
        $book->delete();

        return redirect()->route('library.index')->with('success', 'Buku berhasil dihapus.');
    }
}
