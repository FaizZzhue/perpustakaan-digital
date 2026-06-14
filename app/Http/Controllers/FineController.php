<?php

namespace App\Http\Controllers;

use App\Models\Fine;
use Illuminate\Http\Request;

class FineController extends Controller
{
    /**
     * Display a listing of the fines.
     */
    public function index(Request $request)
    {
        $search = $request->search;
        $status = $request->status; // belum_lunas, lunas

        $fines = Fine::with(['transaction.member', 'transaction.book'])
            ->when($status, function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->whereHas('transaction.member', function ($qm) use ($search) {
                        $qm->where('name', 'like', "%{$search}%")
                           ->orWhere('member_code', 'like', "%{$search}%");
                    })
                    ->orWhereHas('transaction.book', function ($qb) use ($search) {
                        $qb->where('title', 'like', "%{$search}%");
                    });
                });
            })
            ->orderBy('id', 'desc')
            ->get();

        return view('fines.index', compact('fines', 'search', 'status'));
    }

    /**
     * Display the specified fine.
     */
    public function show($id)
    {
        $fine = Fine::with(['transaction.member', 'transaction.book'])->findOrFail($id);

        return view('fines.show', compact('fine'));
    }

    /**
     * Process payment of the fine.
     */
    public function pay($id)
    {
        $fine = Fine::findOrFail($id);

        if ($fine->status === 'lunas') {
            return redirect()->back()->with('error', 'Denda ini sudah lunas.');
        }

        $fine->update([
            'status' => 'lunas',
            'paid_at' => now(),
        ]);

        return redirect()->route('fines.index')->with('success', 'Denda berhasil dibayar.');
    }
}
