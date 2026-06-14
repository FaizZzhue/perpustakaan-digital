<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Book;
use App\Models\Member;
use App\Models\Fine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BorrowController extends Controller
{
    /**
     * Display a listing of the borrowings.
     */
    public function index(Request $request)
    {
        // Automatically update active transactions that have passed the due date to 'terlambat'
        Transaction::where('status', 'dipinjam')
            ->where('due_date', '<', now()->toDateString())
            ->update(['status' => 'terlambat']);

        $search = $request->search;
        $status = $request->status;

        $borrows = Transaction::with(['member', 'book'])
            ->when($status, function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->whereHas('member', function ($qm) use ($search) {
                        $qm->where('name', 'like', "%{$search}%")
                           ->orWhere('member_code', 'like', "%{$search}%");
                    })
                    ->orWhereHas('book', function ($qb) use ($search) {
                        $qb->where('title', 'like', "%{$search}%");
                    });
                });
            })
            ->orderBy('id', 'desc')
            ->get();

        return view('borrows.index', compact('borrows', 'search', 'status'));
    }

    /**
     * Show the form for creating a new borrowing.
     */
    public function create()
    {
        $members = Member::where('status', 'Aktif')->get();
        $books = Book::where('stock', '>', 0)->get();

        return view('borrows.create', compact('members', 'books'));
    }

    /**
     * Store a newly created borrowing in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'member_id' => 'required|exists:members,id',
            'book_id' => 'required|exists:books,id',
            'borrow_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:borrow_date',
        ]);

        $member = Member::findOrFail($request->member_id);
        if ($member->status !== 'Aktif') {
            return redirect()->back()->withErrors(['member_id' => 'Anggota ini sedang tidak aktif.'])->withInput();
        }

        $book = Book::findOrFail($request->book_id);
        if ($book->stock <= 0) {
            return redirect()->back()->withErrors(['book_id' => 'Stok buku ini sudah habis.'])->withInput();
        }

        // Check if member already has an unreturned copy of this book
        $alreadyBorrowed = Transaction::where('member_id', $request->member_id)
            ->where('book_id', $request->book_id)
            ->whereIn('status', ['dipinjam', 'terlambat'])
            ->exists();

        if ($alreadyBorrowed) {
            return redirect()->back()->withErrors(['book_id' => 'Anggota ini sedang meminjam buku ini dan belum mengembalikannya.'])->withInput();
        }

        DB::transaction(function () use ($request, $book) {
            Transaction::create([
                'member_id' => $request->member_id,
                'book_id' => $request->book_id,
                'borrow_date' => $request->borrow_date,
                'due_date' => $request->due_date,
                'status' => 'dipinjam',
            ]);

            $book->decrement('stock');
        });

        return redirect()->route('borrows.index')->with('success', 'Peminjaman berhasil ditambahkan.');
    }

    /**
     * Display the specified borrowing.
     */
    public function show($id)
    {
        $borrow = Transaction::with(['member', 'book'])->findOrFail($id);

        return view('borrows.show', compact('borrow'));
    }

    /**
     * Process the return of a book.
     */
    public function returnBook($id)
    {
        $borrow = Transaction::findOrFail($id);

        if ($borrow->status === 'dikembalikan') {
            return redirect()->back()->with('error', 'Buku ini sudah dikembalikan.');
        }

        $dueDate = \Carbon\Carbon::parse($borrow->due_date)->startOfDay();
        $returnDate = \Carbon\Carbon::parse(now()->toDateString())->startOfDay();

        DB::transaction(function () use ($borrow, $dueDate, $returnDate) {
            $borrow->update([
                'status' => 'dikembalikan',
                'return_date' => now()->toDateString(),
            ]);

            $borrow->book()->increment('stock');

            // Hitung denda jika terlambat
            if ($returnDate->greaterThan($dueDate)) {
                $lateDays = abs($returnDate->diffInDays($dueDate));
                $fineAmount = $lateDays * 1000;

                Fine::create([
                    'transaction_id' => $borrow->id,
                    'late_days' => $lateDays,
                    'fine_amount' => $fineAmount,
                    'status' => 'belum_lunas',
                ]);
            }
        });

        return redirect()->route('borrows.index')->with('success', 'Buku berhasil dikembalikan.');
    }

    /**
     * Remove the specified borrowing from storage.
     */
    public function destroy($id)
    {
        $borrow = Transaction::findOrFail($id);

        DB::transaction(function () use ($borrow) {
            if (in_array($borrow->status, ['dipinjam', 'terlambat'])) {
                $borrow->book()->increment('stock');
            }
            $borrow->delete();
        });

        return redirect()->route('borrows.index')->with('success', 'Transaksi peminjaman berhasil dihapus.');
    }
}
