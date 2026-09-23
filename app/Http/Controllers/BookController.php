<?php

namespace App\Http\Controllers;

use App\Http\Requests\Book\StoreBookRequest;
use App\Http\Requests\Book\UpdateBookRequest;
use App\Models\Book;
use App\Models\Category;
use App\Models\Publisher;
use App\Models\Rack;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('books.view');

        $query = Book::with(['category', 'publisher', 'rack']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('book_code', 'like', "%{$search}%")
                  ->orWhere('isbn', 'like', "%{$search}%")
                  ->orWhere('author', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        $books = $query->latest()->paginate(10)->withQueryString();
        $categories = Category::orderBy('name')->get();

        return view('books.index', compact('books', 'categories'));
    }

    public function create()
    {
        $this->authorize('books.create');

        $categories = Category::orderBy('name')->get();
        $publishers = Publisher::orderBy('name')->get();
        $racks = Rack::orderBy('name')->get();

        return view('books.create', compact('categories', 'publishers', 'racks'));
    }

    public function store(StoreBookRequest $request)
    {
        $validated = $request->validated();
        
        // Find or create Category
        $category = Category::firstOrCreate(['name' => $validated['category_name']]);
        $validated['category_id'] = $category->id;
        unset($validated['category_name']);

        // Find or create Publisher if provided
        if (!empty($validated['publisher_name'])) {
            $publisher = Publisher::firstOrCreate(['name' => $validated['publisher_name']]);
            $validated['publisher_id'] = $publisher->id;
        } else {
            $validated['publisher_id'] = null;
        }
        unset($validated['publisher_name']);
        
        $validated['book_code'] = Book::generateCode();
        $validated['available_qty'] = $validated['total_qty'];
        $validated['status'] = 'available';
        
        // No more QR Code generation

        if ($request->hasFile('cover')) {
            $file = $request->file('cover');
            $filename = time() . '_' . $file->hashName();
            $file->storeAs('covers', $filename, 'public');
            $validated['cover'] = $filename;
        }

        Book::create($validated);

        return redirect()->route('books.index')
            ->with('success', 'Buku berhasil ditambahkan.');
    }

    public function show(Book $book)
    {
        $this->authorize('books.view');
        
        $book->load(['category', 'publisher', 'rack']);
        
        return view('books.show', compact('book'));
    }

    public function edit(Book $book)
    {
        $this->authorize('books.edit');

        $categories = Category::orderBy('name')->get();
        $publishers = Publisher::orderBy('name')->get();
        $racks = Rack::orderBy('name')->get();

        return view('books.edit', compact('book', 'categories', 'publishers', 'racks'));
    }

    public function update(UpdateBookRequest $request, Book $book)
    {
        $validated = $request->validated();

        // Find or create Category
        $category = Category::firstOrCreate(['name' => $validated['category_name']]);
        $validated['category_id'] = $category->id;
        unset($validated['category_name']);

        // Find or create Publisher if provided
        if (!empty($validated['publisher_name'])) {
            $publisher = Publisher::firstOrCreate(['name' => $validated['publisher_name']]);
            $validated['publisher_id'] = $publisher->id;
        } else {
            $validated['publisher_id'] = null;
        }
        unset($validated['publisher_name']);

        // Recalculate available qty based on total qty change
        if ($validated['total_qty'] != $book->total_qty) {
            $diff = $validated['total_qty'] - $book->total_qty;
            $validated['available_qty'] = max(0, $book->available_qty + $diff);
            
            if ($validated['available_qty'] <= 0) {
                $validated['status'] = 'unavailable';
            }
        }

        if ($request->hasFile('cover')) {
            // Delete old cover
            if ($book->cover) {
                Storage::disk('public')->delete('covers/' . $book->cover);
            }

            $file = $request->file('cover');
            $filename = time() . '_' . $file->hashName();
            $file->storeAs('covers', $filename, 'public');
            $validated['cover'] = $filename;
        } elseif ($request->boolean('remove_cover')) {
            if ($book->cover) {
                Storage::disk('public')->delete('covers/' . $book->cover);
            }
            $validated['cover'] = null;
        }

        $book->update($validated);

        return redirect()->route('books.index')
            ->with('success', 'Buku berhasil diperbarui.');
    }

    public function destroy(Book $book)
    {
        $this->authorize('books.delete');

        $book->delete();

        return redirect()->route('books.index')
            ->with('success', 'Buku berhasil dihapus.');
    }
}
