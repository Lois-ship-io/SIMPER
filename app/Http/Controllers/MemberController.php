<?php

namespace App\Http\Controllers;

use App\Http\Requests\Member\StoreMemberRequest;
use App\Http\Requests\Member\UpdateMemberRequest;
use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('members.view');

        $query = Member::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('nis', 'like', "%{$search}%")
                  ->orWhere('member_code', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $members = $query->latest()->paginate(15)->withQueryString();

        return view('members.index', compact('members'));
    }

    public function create()
    {
        $this->authorize('members.create');
        
        return view('members.create');
    }

    public function store(StoreMemberRequest $request)
    {
        $validated = $request->validated();
        $validated['member_code'] = Member::generateCode();
        $validated['status'] = 'active';

        Member::create($validated);

        return redirect()->route('members.index')
            ->with('success', 'Anggota perpustakaan berhasil didaftarkan.');
    }

    public function show(Member $member)
    {
        $this->authorize('members.view');
        
        return view('members.show', compact('member'));
    }

    public function edit(Member $member)
    {
        $this->authorize('members.edit');
        
        return view('members.edit', compact('member'));
    }

    public function update(UpdateMemberRequest $request, Member $member)
    {
        $member->update($request->validated());

        return redirect()->route('members.index')
            ->with('success', 'Data anggota berhasil diperbarui.');
    }

    public function destroy(Member $member)
    {
        $this->authorize('members.delete');
        
        $member->delete();

        return redirect()->route('members.index')
            ->with('success', 'Data anggota berhasil dihapus.');
    }
}
