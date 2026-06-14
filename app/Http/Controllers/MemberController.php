<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class MemberController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;
        $members = Member::when($search, function ($query) use ($search) {
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('member_code', 'like', "%{$search}%")
                  ->orWhere('nik', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
        })->get();

        return view('members.index', compact('members'));
    }

    public function create()
    {
        return view('members.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'nik' => 'required|string|max:16|unique:members,nik',
            'address' => 'required|string',
            'phone' => 'required|string|max:15',
            'email' => 'required|email|max:255|unique:members,email',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Auto-generate member_code: MBR-XXXXX (e.g. MBR-00001)
        $latestMember = Member::withTrashed()->orderBy('id', 'desc')->first();
        $number = 1;
        if ($latestMember && preg_match('/MBR-(\d+)/', $latestMember->member_code, $matches)) {
            $number = intval($matches[1]) + 1;
        }
        $member_code = 'MBR-' . str_pad($number, 5, '0', STR_PAD_LEFT);

        // Auto-generate QR code PNG
        $qrPath = null;
        $qrUrl = "https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=" . urlencode($member_code);
        try {
            $qrResponse = Http::get($qrUrl);
            if ($qrResponse->successful()) {
                $qrPath = 'qrcodes/' . $member_code . '.png';
                Storage::disk('public')->put($qrPath, $qrResponse->body());
            }
        } catch (\Exception $e) {
            // Fallback if HTTP call fails
            $qrPath = null;
        }

        // Handle photo upload
        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('members', 'public');
        }

        Member::create([
            'member_code' => $member_code,
            'name' => $request->name,
            'nik' => $request->nik,
            'address' => $request->address,
            'phone' => $request->phone,
            'email' => $request->email,
            'photo' => $photoPath,
            'qr_code' => $qrPath,
            'status' => 'Aktif',
        ]);

        return redirect()->route('members.index')->with('success', 'Anggota berhasil ditambahkan');
    }

    public function show(Member $member)
    {
        $member->load(['transactions.book', 'transactions.fine']);

        $activeBorrows = $member->transactions
            ->whereIn('status', ['dipinjam', 'terlambat'])
            ->sortByDesc('id');

        $borrowHistory = $member->transactions
            ->where('status', 'dikembalikan')
            ->sortByDesc('id');

        $fines = $member->transactions
            ->filter(fn ($t) => $t->fine !== null)
            ->map(fn ($t) => $t->fine)
            ->sortByDesc('id');

        return view('members.show', compact('member', 'activeBorrows', 'borrowHistory', 'fines'));
    }

    public function edit(Member $member)
    {
        return view('members.edit', compact('member'));
    }

    public function update(Request $request, Member $member)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'nik' => 'required|string|max:16|unique:members,nik,' . $member->id,
            'address' => 'required|string',
            'phone' => 'required|string|max:15',
            'email' => 'required|email|max:255|unique:members,email,' . $member->id,
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:Aktif,Nonaktif',
        ]);

        // Handle photo upload if any
        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($member->photo) {
                Storage::disk('public')->delete($member->photo);
            }
            $photoPath = $request->file('photo')->store('members', 'public');
            $member->photo = $photoPath;
        }

        $member->update([
            'name' => $request->name,
            'nik' => $request->nik,
            'address' => $request->address,
            'phone' => $request->phone,
            'email' => $request->email,
            'status' => $request->status,
        ]);

        return redirect()->route('members.index')->with('success', 'Anggota berhasil diupdate');
    }

    public function destroy(Member $member)
    {
        $member->delete();
        return redirect()->route('members.index')->with('success', 'Anggota berhasil dihapus');
    }
}
