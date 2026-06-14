<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MemberDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Find the member record by email
        $member = Member::where('email', $user->email)->first();

        if (!$member) {
            return view('member.dashboard', [
                'member' => null,
                'user' => $user,
                'activeBorrows' => collect(),
                'activeBorrowCount' => 0,
                'totalBorrowCount' => 0,
                'lateBorrowCount' => 0,
                'fines' => collect(),
                'totalFines' => 0,
                'unpaidFines' => 0,
                'paidFines' => 0,
                'borrowHistory' => collect()
            ]);
        }

        // Automatically update active transactions that have passed the due date to 'terlambat'
        Transaction::where('member_id', $member->id)
            ->where('status', 'dipinjam')
            ->where('due_date', '<', now()->toDateString())
            ->update(['status' => 'terlambat']);

        // Refresh and load relations
        $member->load(['transactions.book', 'transactions.fine']);

        // Borrowing Statistics
        $activeBorrows = $member->transactions
            ->whereIn('status', ['dipinjam', 'terlambat'])
            ->sortByDesc('id');
        $activeBorrowCount = $activeBorrows->count();

        $totalBorrowCount = $member->transactions->count();

        $lateBorrowCount = $member->transactions
            ->where('status', 'terlambat')
            ->count();

        // Fine Statistics
        $fines = $member->transactions
            ->filter(fn ($t) => $t->fine !== null)
            ->map(fn ($t) => $t->fine)
            ->sortByDesc('id');

        $totalFines = $fines->sum('fine_amount');
        $unpaidFines = $fines->where('status', 'belum_lunas')->sum('fine_amount');
        $paidFines = $fines->where('status', 'lunas')->sum('fine_amount');

        // Borrowing History (status = dikembalikan)
        $borrowHistory = $member->transactions
            ->where('status', 'dikembalikan')
            ->sortByDesc('id');

        return view('member.dashboard', compact(
            'member',
            'user',
            'activeBorrows',
            'activeBorrowCount',
            'totalBorrowCount',
            'lateBorrowCount',
            'fines',
            'totalFines',
            'unpaidFines',
            'paidFines',
            'borrowHistory'
        ));
    }
}
