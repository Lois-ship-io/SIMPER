<?php

namespace App\Http\Controllers;

use App\Http\Requests\Publisher\StorePublisherRequest;
use App\Http\Requests\Publisher\UpdatePublisherRequest;
use App\Models\Publisher;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class PublisherController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request)
    {
        $query = Publisher::query();
        if ($request->filled('search')) {
            $query->where('name', 'like', "%{$request->search}%");
        }
        $publishers = $query->latest()->paginate(10)->withQueryString();
        
        return view('publishers.index', compact('publishers'));
    }

    public function create()
    {
        return view('publishers.create');
    }

    public function store(StorePublisherRequest $request)
    {
        Publisher::create($request->validated());
        return redirect()->route('publishers.index')->with('success', 'Penerbit berhasil ditambahkan.');
    }

    public function edit(Publisher $publisher)
    {
        return view('publishers.edit', compact('publisher'));
    }

    public function update(UpdatePublisherRequest $request, Publisher $publisher)
    {
        $publisher->update($request->validated());
        return redirect()->route('publishers.index')->with('success', 'Penerbit berhasil diperbarui.');
    }

    public function destroy(Publisher $publisher)
    {
        $publisher->delete();
        return redirect()->route('publishers.index')->with('success', 'Penerbit berhasil dihapus.');
    }
}
