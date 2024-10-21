<?php

namespace App\Http\Controllers\History;

use App\Models\History;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class HistoryController extends Controller
{
    public function index()
    {
        $histories = History::get();
        return view('history.index', compact('histories'));
    }

    public function create()
    {
        return view('history.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
            'content' => 'required|string',
        ], [
            'title.required' => 'Judul sejarah wajib diisi.',
            'thumbnail.image' => 'File harus berupa gambar.',
            'thumbnail.mimes' => 'Format gambar harus jpeg, png, jpg, atau gif.',
            'thumbnail.max' => 'Ukuran gambar maksimal 10MB.',
            'content.required' => 'Konten sejarah wajib diisi.',
        ]);

        if($request->hasFile('thumbnail')) {
            $thumbnailPath = $request->file('thumbnail')->store('thumbnails', 'public');
            $validatedData['thumbnail'] = $thumbnailPath;
        }

        $validatedData['author'] = Auth::user()->name;
        $validatedData['slug'] = Str::slug($request->title);

        $history = History::create($validatedData);

        return redirect()->route('history.index')->with('success', 'Sejarah berhasil ditambahkan.');
    }

    public function show($slug)
    {
        $article = History::where('slug', $slug)->first();
        return view('history.show', compact('article'));
    }

    public function edit($slug)
    {
        $article = History::where('slug', $slug)->firstOrFail();
        return view('history.edit', compact('article'));
    }

    public function update(Request $request, $slug)
    {
        // Temukan artikel sejarah berdasarkan slug
        $article = History::where('slug', $slug)->firstOrFail();

        // Validasi input
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240', // Optional on update
            'content' => 'required|string',
        ], [
            'title.required' => 'Judul sejarah wajib diisi.',
            'thumbnail.image' => 'File harus berupa gambar.',
            'thumbnail.mimes' => 'Format gambar harus jpeg, png, jpg, atau gif.',
            'thumbnail.max' => 'Ukuran gambar maksimal 10MB.',
            'content.required' => 'Konten sejarah wajib diisi.',
        ]);

        // Jika ada thumbnail baru, hapus thumbnail lama dan simpan yang baru
        if ($request->hasFile('thumbnail')) {
            // Hapus file thumbnail lama jika ada
            if ($article->thumbnail) {
                Storage::disk('public')->delete($article->thumbnail);
            }

            // Simpan file thumbnail baru
            $thumbnailPath = $request->file('thumbnail')->store('thumbnails', 'public');
            $validatedData['thumbnail'] = $thumbnailPath;
        }

        // Update data artikel sejarah
        $validatedData['author'] = Auth::user()->name;
        $validatedData['slug'] = Str::slug($request->title);

        // Simpan perubahan pada artikel sejarah
        $article->update($validatedData);

        return redirect()->route('history.index')->with('success', 'Sejarah berhasil diperbarui.');
    }

    public function destroy($slug)
    {
        $article = History::where('slug', $slug)->firstOrFail();
        Storage::disk('public')->delete($article->thumbnail);
        $article->delete();

        return redirect()->route('history.index')->with('success', 'Artikel Sejarah berhasil dihapus.');
    }
}
