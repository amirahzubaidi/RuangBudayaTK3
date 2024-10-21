<?php

namespace App\Http\Controllers\News;

use App\Models\News;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{
    public function index ()
    {
        $news = News::all();
        return view('news.index', compact('news'));
    }
    
    public function create ()
    {
        if (Auth::user()->role == 'admin') {
            return view('news.create');
        } else {
            return redirect()->route('news.index');
        }
    }
    
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif|max:10240',
            'content' => 'required|string',
        ], [
            'title.required' => 'Judul berita wajib diisi.',
            'thumbnail.required' => 'Foto sampul wajib diunggah.',
            'thumbnail.image' => 'File harus berupa gambar.',
            'thumbnail.mimes' => 'Format gambar harus jpeg, png, jpg, atau gif.',
            'thumbnail.max' => 'Ukuran gambar maksimal 10MB.',
            'content.required' => 'Konten berita wajib diisi.',
        ]);

        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $request->file('thumbnail')->store('thumbnails', 'public');
            $validatedData['thumbnail'] = $thumbnailPath;
        }

        $validatedData['author'] = Auth::user()->name;
        $validatedData['slug'] = Str::slug($request->title);

        $news = News::create($validatedData);

        return redirect()->route('news.index')->with('success', 'Berita berhasil ditambahkan.');
    }

    public function edit ($slug)
    {
        $article = News::where('slug', $slug)->first();
        return view('news.edit', compact('article'));
    }

    public function update(Request $request, $slug)
    {
        // Temukan artikel berdasarkan slug
        $article = News::where('slug', $slug)->firstOrFail();

        // Validasi input
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
            'content' => 'required|string',
        ], [
            'title.required' => 'Judul berita wajib diisi.',
            'thumbnail.image' => 'File harus berupa gambar.',
            'thumbnail.mimes' => 'Format gambar harus jpeg, png, jpg, atau gif.',
            'thumbnail.max' => 'Ukuran gambar maksimal 10MB.',
            'content.required' => 'Konten berita wajib diisi.',
        ]);

        // Jika ada file thumbnail yang diupload, simpan file dan update path
        if ($request->hasFile('thumbnail')) {
            // Hapus file lama jika ada
            if ($article->thumbnail) {
                Storage::disk('public')->delete($article->thumbnail);
            }

            // Simpan file baru
            $thumbnailPath = $request->file('thumbnail')->store('thumbnails', 'public');
            $validatedData['thumbnail'] = $thumbnailPath;
        }

        // Update data lainnya
        $validatedData['slug'] = Str::slug($request->title);

        // Update artikel
        $article->update($validatedData);

        return redirect()->route('news.index')->with('success', 'Berita berhasil diperbarui.');
    }


    public function show ($slug)
    {
        $article = News::where('slug', $slug)->first();
        return view('news.show', compact('article'));
    }

    public function destroy($slug)
    {
        $article = News::where('slug', $slug)->firstOrFail();
        Storage::disk('public')->delete($article->thumbnail);
        $article->delete();

        return redirect()->route('news.index')->with('success', 'Berita berhasil dihapus.');
    }
}
