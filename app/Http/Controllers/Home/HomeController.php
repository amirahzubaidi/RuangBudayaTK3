<?php

namespace App\Http\Controllers\Home;

use App\Models\News;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index ()
    {
        $news = News::latest()->get();
        return view('welcome', compact('news'));
    }
}
