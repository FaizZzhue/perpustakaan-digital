<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{

    public function dashboard()
    {
        $totalBooks = Book::count();
        $totalStock = Book::sum('stock');
        $totalCategory = Book::distinct('category')->count('category');
        return view('dashboard', compact(
            'totalBooks',
            'totalStock',
            'totalCategory'
        ));
    }
    public function index(Request $request)
    {
        $search = $request->search;
        $books = Book::when($search, function ($query) use ($search) {
            $query->where('title', 'like', "%{$search}%")->orWhere('author', 'like', "%{$search}%");
        })->get();
        return view('books.index', compact('books'));
    }

    public function create()
    {
        return view('books.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'author' => 'required',
            'category' => 'required',
            'stock' => 'required|integer',
        ]);
        Book::create($request->all());
        return redirect()->route('books.index')->with('success', 'Buku berhasil ditambahkan');
    }

    public function show(Book $book)
    {
        return view('books.show', compact('book'));
    }

    public function edit(Book $book)
    {
        return view('books.edit', compact('book'));
    }

    public function update(Request $request, Book $book)
    {
        $request->validate([
            'title' => 'required',
            'author' => 'required',
            'category' => 'required',
            'stock' => 'required|integer',
        ]);
        $book->update($request->all());
        return redirect()->route('books.index')->with('success', 'Buku berhasil diupdate');
    }

    public function destroy(Book $book)
    {
        $book->delete();
        return redirect()->route('books.index');
    }

}