<?php

namespace App\Http\Controllers;

use App\Models\Visitor;
use Illuminate\Http\Request;

class VisitorController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('visitors.view');

        $query = Visitor::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('pekerjaan', 'like', "%{$search}%")
                  ->orWhere('purpose', 'like', "%{$search}%");
            });
        }

        $visitors = $query->latest()->paginate(20)->withQueryString();

        return view('visitors.index', compact('visitors'));
    }

    public function store(Request $request)
    {
        $this->authorize('visitors.create');

        $validated = $request->validate([
            'name'       => 'required|string|max:255',
            'pekerjaan'  => 'required|string|max:255',
            'purpose'    => 'required|string|max:255',
            'visit_date' => 'required|date',
        ], [
            'name.required'       => 'Nama pengunjung harus diisi.',
            'pekerjaan.required'  => 'Pekerjaan harus diisi.',
            'purpose.required'    => 'Keperluan harus diisi.',
            'visit_date.required' => 'Tanggal harus diisi.',
        ]);

        Visitor::create($validated);

        return back()->with('success', 'Data pengunjung berhasil ditambahkan.');
    }

    public function update(Request $request, Visitor $visitor)
    {
        $this->authorize('visitors.edit');

        $validated = $request->validate([
            'name'       => 'required|string|max:255',
            'pekerjaan'  => 'required|string|max:255',
            'purpose'    => 'required|string|max:255',
            'visit_date' => 'required|date',
        ], [
            'name.required'       => 'Nama pengunjung harus diisi.',
            'pekerjaan.required'  => 'Pekerjaan harus diisi.',
            'purpose.required'    => 'Keperluan harus diisi.',
            'visit_date.required' => 'Tanggal harus diisi.',
        ]);

        $visitor->update($validated);

        return redirect()->route('visitors.index')->with('success', 'Data pengunjung berhasil diperbarui.');
    }

    public function destroy(Visitor $visitor)
    {
        $this->authorize('visitors.delete');
        $visitor->delete();
        return redirect()->route('visitors.index')->with('success', 'Data pengunjung berhasil dihapus.');
    }
}
