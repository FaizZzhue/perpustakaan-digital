<?php

namespace App\Http\Controllers;

use App\Models\Ebook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EbookController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $ebooks = Ebook::when($search, function ($query) use ($search) {
            $query->where('title', 'like', "%{$search}%")
                  ->orWhere('author', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%");
        })->get();

        return view('ebooks.index', compact('ebooks'));
    }

    public function create()
    {
        return view('ebooks.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'description' => 'required|string',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'pdf_file' => 'required|file|mimes:pdf|max:10240',
        ]);

        $coverPath = null;
        if ($request->hasFile('cover_image')) {
            $coverPath = $request->file('cover_image')->store('covers', 'public');
        }

        $pdfPath = $request->file('pdf_file')->store('ebooks', 'public');

        Ebook::create([
            'title' => $request->title,
            'author' => $request->author,
            'category' => $request->category,
            'description' => $request->description,
            'cover_image' => $coverPath,
            'pdf_file' => $pdfPath,
        ]);

        return redirect()->route('ebooks.index')->with('success', 'Ebook berhasil ditambahkan');
    }

    public function show(Ebook $ebook)
    {
        return view('ebooks.show', compact('ebook'));
    }

    public function edit(Ebook $ebook)
    {
        return view('ebooks.edit', compact('ebook'));
    }

    public function update(Request $request, Ebook $ebook)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'description' => 'required|string',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'pdf_file' => 'nullable|file|mimes:pdf|max:10240',
        ]);

        if ($request->hasFile('cover_image')) {
            if ($ebook->cover_image) {
                Storage::disk('public')->delete($ebook->cover_image);
            }
            $ebook->cover_image = $request->file('cover_image')->store('covers', 'public');
        }

        if ($request->hasFile('pdf_file')) {
            if ($ebook->pdf_file) {
                Storage::disk('public')->delete($ebook->pdf_file);
            }
            $ebook->pdf_file = $request->file('pdf_file')->store('ebooks', 'public');
        }

        $ebook->update([
            'title' => $request->title,
            'author' => $request->author,
            'category' => $request->category,
            'description' => $request->description,
        ]);

        return redirect()->route('ebooks.index')->with('success', 'Ebook berhasil diupdate');
    }

    public function destroy(Ebook $ebook)
    {
        if ($ebook->cover_image) {
            Storage::disk('public')->delete($ebook->cover_image);
        }
        if ($ebook->pdf_file) {
            Storage::disk('public')->delete($ebook->pdf_file);
        }

        $ebook->delete();

        return redirect()->route('ebooks.index')->with('success', 'Ebook berhasil dihapus');
    }

    public function read(Ebook $ebook)
    {
        $path = Storage::disk('public')->path($ebook->pdf_file);
        if (!file_exists($path)) {
            abort(404, 'File PDF tidak ditemukan');
        }

        return response()->file($path, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . basename($path) . '"'
        ]);
    }

    public function download(Ebook $ebook)
    {
        $path = Storage::disk('public')->path($ebook->pdf_file);
        if (!file_exists($path)) {
            abort(404, 'File PDF tidak ditemukan');
        }

        return response()->download($path);
    }
}
