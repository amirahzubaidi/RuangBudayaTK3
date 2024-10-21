<?php

namespace App\Http\Controllers\Forum;

use App\Models\Forum;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ForumController extends Controller
{
    public function index() {
        $forums = Forum::with(['comments.user'])->latest()->get();
        return view('forum.index', compact('forums'));
    }    

    public function show(string $slug)
    {
        $thread = Forum::where('slug', $slug)->first();
        return view('forum.show', compact('thread'));
    }

    public function create()
    {
        return view('forum.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ], [
            'title.required' => 'Judul berita wajib diisi.',
            'content.required' => 'Konten berita wajib diisi.',
        ]);

        $validatedData['author'] = Auth::user()->name;
        $validatedData['slug'] = Str::slug($request->title);
        $validatedData['user_id'] = Str::slug($request->user_id);

        $news = Forum::create($validatedData);

        return redirect()->route('forum.index')->with('success', 'Berita berhasil ditambahkan.');
    }

    public function edit($slug)
    {
        $thread = Forum::where('slug', $slug)->firstOrFail();
        return view('forum.edit', compact('thread'));
    }

    public function update(Request $request, $slug)
    {
        // Cari thread berdasarkan slug
        $thread = Forum::where('slug', $slug)->firstOrFail();

        // Validasi input
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ], [
            'title.required' => 'Judul topik wajib diisi.',
            'title.max' => 'Judul topik tidak boleh lebih dari 255 karakter.',
            'content.required' => 'Konten topik wajib diisi.',
        ]);

        // Update data thread
        $thread->update([
            'title' => $validatedData['title'],
            'content' => $validatedData['content'],
            'slug' => Str::slug($validatedData['title']),
        ]);

        // Redirect kembali ke halaman detail thread dengan pesan sukses
        return redirect()->route('forum.index', $thread->slug)->with('success', 'Topik berhasil diperbarui.');
    }


    public function destroy($id)
    {
        $thread = Forum::findOrFail($id);
        $thread->delete();

        return redirect()->route('forum.index')->with('success', 'Forum berhasil dihapus.');
    }
}
