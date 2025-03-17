<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;

class HomeController extends Controller
{
    //
    public function index()
    {

        $breakingNews = Post::published()
            ->latest() // sorteer op de nieuwst eerst
            ->take(6) // haal de laatste
            ->with(['author', 'photo', 'categories']) // laad de auteur,photo en categories op
            ->get();

        $categories = Category::whereHas('posts')->get();

        //
        return view('frontend.home', compact('breakingNews', 'categories'));
    }
}// //
