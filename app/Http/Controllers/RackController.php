<?php

namespace App\Http\Controllers;

use App\Http\Requests\Rack\StoreRackRequest;
use App\Http\Requests\Rack\UpdateRackRequest;
use App\Models\Rack;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class RackController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request)
    {
        $query = Rack::query();
        if ($request->filled('search')) {
            $query->where('name', 'like', "%{$request->search}%")
                  ->orWhere('code', 'like', "%{$request->search}%");
        }
        $racks = $query->latest()->paginate(10)->withQueryString();
        
        return view('racks.index', compact('racks'));
    }

    public function create()
    {
        return view('racks.create');
    }

    public function store(StoreRackRequest $request)
    {
        Rack::create($request->validated());
        return redirect()->route('racks.index')->with('success', 'Rak berhasil ditambahkan.');
    }

    public function edit(Rack $rack)
    {
        return view('racks.edit', compact('rack'));
    }

    public function update(UpdateRackRequest $request, Rack $rack)
    {
        $rack->update($request->validated());
        return redirect()->route('racks.index')->with('success', 'Rak berhasil diperbarui.');
    }

    public function destroy(Rack $rack)
    {
        $rack->delete();
        return redirect()->route('racks.index')->with('success', 'Rak berhasil dihapus.');
    }
}
