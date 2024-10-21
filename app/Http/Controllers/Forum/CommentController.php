<?php

namespace App\Http\Controllers\Forum;

use App\Models\Forum;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CommentController extends Controller
{
    public function store($id, Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'comment' => 'required|string|max:1000',
        ], [
            'comment.required' => 'Komentar tidak boleh kosong.',
            'comment.string' => 'Komentar harus berupa teks.',
            'comment.max' => 'Komentar tidak boleh lebih dari 1000 karakter.',
        ]);

        // Temukan forum berdasarkan ID yang diterima
        $forum = Forum::findOrFail($id);

        // Simpan komentar ke dalam database
        Comment::create([
            'comment' => $validatedData['comment'],
            'forum_id' => $forum->id,
            'user_id' => Auth::id(), // Mengambil ID pengguna yang sedang login
        ]);

        // Redirect kembali ke halaman forum dengan pesan sukses
        return redirect()->route('forum.show', $forum->slug)->with('success', 'Komentar berhasil ditambahkan.');
    }
}
