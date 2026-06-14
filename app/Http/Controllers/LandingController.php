<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $searchResults = null;
        if ($search) {
            $searchResults = Book::where('title', 'like', "%{$search}%")
                ->orWhere('author', 'like', "%{$search}%")
                ->orWhere('category', 'like', "%{$search}%")
                ->get();
        }

        $latestBooks = Book::latest('id')->take(5)->get();

        return view('landing', compact('latestBooks', 'searchResults', 'search'));
    }

    public function show(Book $book)
    {
        return view('public.books.show', compact('book'));
    }
}
