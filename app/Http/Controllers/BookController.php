<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Member;
use App\Models\Transaction;
use App\Models\Fine;
use Illuminate\Http\Request;

class BookController extends Controller
{

    public function dashboard()
    {
        $totalBooks = Book::count();
        $totalStock = Book::sum('stock');
        $totalCategory = Book::distinct('category')->count('category');
        $totalMembers = Member::count();
        $totalBorrows = Transaction::count();
        $totalFines = Fine::where('status', 'belum_lunas')->count();

        // Category stats for bar chart
        $categoryStats = Book::selectRaw('category, count(*) as total')
            ->groupBy('category')
            ->orderByDesc('total')
            ->get();

        // Build activity feed from real data (latest 10)
        $activities = collect();

        $latestBooks = Book::latest()->take(10)->get()->map(fn ($b) => [
            'label' => 'Buku baru ditambahkan',
            'description' => "\"{$b->title}\" oleh {$b->author}",
            'icon' => '📚',
            'color' => 'blue',
            'created_at' => $b->created_at,
        ]);
        $activities = $activities->merge($latestBooks);

        $latestMembers = Member::latest()->take(10)->get()->map(fn ($m) => [
            'label' => 'Anggota baru ditambahkan',
            'description' => "{$m->name} ({$m->member_code})",
            'icon' => '👤',
            'color' => 'green',
            'created_at' => $m->created_at,
        ]);
        $activities = $activities->merge($latestMembers);

        $latestTransactions = Transaction::with(['member', 'book'])->latest()->take(10)->get()->map(fn ($t) => [
            'label' => 'Peminjaman dibuat',
            'description' => ($t->member ? $t->member->name : 'Anggota') . ' meminjam "' . ($t->book ? $t->book->title : 'Buku') . '"',
            'icon' => '📖',
            'color' => 'yellow',
            'created_at' => $t->created_at,
        ]);
        $activities = $activities->merge($latestTransactions);

        $latestReturns = Transaction::with(['member', 'book'])
            ->where('status', 'dikembalikan')
            ->orderBy('updated_at', 'desc')
            ->take(10)
            ->get()
            ->map(fn ($t) => [
                'label' => 'Buku dikembalikan',
                'description' => ($t->member ? $t->member->name : 'Anggota') . ' mengembalikan "' . ($t->book ? $t->book->title : 'Buku') . '"',
                'icon' => '↩️',
                'color' => 'indigo',
                'created_at' => $t->updated_at,
            ]);
        $activities = $activities->merge($latestReturns);

        $latestFines = Fine::with(['transaction.member'])->latest()->take(10)->get()->map(fn ($f) => [
            'label' => 'Denda dibuat',
            'description' => "Denda Rp " . number_format($f->fine_amount, 0, ',', '.') . " untuk " . ($f->transaction && $f->transaction->member ? $f->transaction->member->name : 'Anggota'),
            'icon' => '💰',
            'color' => 'red',
            'created_at' => $f->created_at,
        ]);
        $activities = $activities->merge($latestFines);

        $activities = $activities->sortByDesc('created_at')->take(10)->values();

        return view('dashboard', compact(
            'totalBooks',
            'totalStock',
            'totalCategory',
            'totalMembers',
            'totalBorrows',
            'totalFines',
            'categoryStats',
            'activities'
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