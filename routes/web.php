<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Home\HomeController;
use App\Http\Controllers\News\NewsController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Forum\CommentController;
use App\Http\Controllers\History\HistoryController;
use App\Http\Controllers\Library\LibraryController;
use App\Http\Controllers\Profile\ProfileController;
use App\Http\Controllers\Forum\ForumController;

// Auth
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.process');

    Route::get('/register', [RegisterController::class, 'index'])->name('register');
    Route::post('/register', [RegisterController::class, 'store'])->name('register.store');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/update-password', [ProfileController::class, 'updatePassword'])->name('profile.updatePassword');

    Route::post('/logout', [LogoutController::class, 'destroy'])->name('logout');
});

Route::get('/', [HomeController::class, 'index'])->name('home.index');

Route::get('/library', [LibraryController::class, 'index'])->name('library.index');
Route::get('/library/create', [LibraryController::class, 'create'])->name('library.create');
Route::post('/library', [LibraryController::class, 'store'])->name('library.store')->middleware('auth');
Route::get('/library/r/{slug}', [LibraryController::class, 'show'])->name('library.show');
Route::get('/library/e/{slug}', [LibraryController::class, 'edit'])->name('library.edit');
Route::put('/library/e/{slug}', [LibraryController::class, 'update'])->name('library.update');
Route::delete('/library/d/{slug}', [LibraryController::class, 'destroy'])->name('library.destroy');


Route::get('/history', [HistoryController::class, 'index'])->name('history.index');
Route::get('/history/r/{slug}', [HistoryController::class, 'show'])->name('history.show');
Route::get('/history/create', [HistoryController::class, 'create'])->name('history.create')->middleware('auth');
Route::post('/history', [HistoryController::class, 'store'])->name('history.store')->middleware('auth');
Route::get('/history/e/{slug}', [HistoryController::class, 'edit'])->name('history.edit');
Route::put('/history/e/{slug}', [HistoryController::class, 'update'])->name('history.update');
Route::delete('/history/d/{slug}', [HistoryController::class, 'destroy'])->name('history.destroy');

Route::get('/news', [NewsController::class, 'index'])->name('news.index');
Route::get('/news/r/{slug}', [NewsController::class, 'show'])->name('news.show');
Route::get('/news/create', [NewsController::class, 'create'])->name('news.create')->middleware('auth');
Route::post('/news', [NewsController::class, 'store'])->name('news.store')->middleware('auth');
Route::get('/news/e/{slug}', [NewsController::class, 'edit'])->name('news.edit')->middleware('auth');
Route::put('/news/e/{slug}', [NewsController::class, 'update'])->name('news.update')->middleware('auth');
Route::delete('/news/d/{slug}', [NewsController::class, 'destroy'])->name('news.destroy')->middleware('auth');



Route::get('/forum', [ForumController::class, 'index'])->name('forum.index');
Route::get('/forum/create', [ForumController::class, 'create'])->name('forum.create');
Route::post('/forum', [ForumController::class, 'store'])->name('forum.store');
Route::get('/forum/r/{slug}', [ForumController::class, 'show'])->name('forum.show');
Route::get('/forum/e/{slug}', [ForumController::class, 'edit'])->name('forum.edit');
Route::put('/forum/e/{slug}', [ForumController::class, 'update'])->name('forum.update');
Route::post('/forum/c/{id}', [CommentController::class, 'store'])->name('comments.store');
Route::delete('/forum/d/{id}', [ForumController::class, 'destroy'])->name('forum.destroy');


Route::fallback(function () {
    return view('error.404');
});