<?php

namespace App\Http\Controllers;

use App\Http\Requests\Borrowing\StoreBorrowingRequest;
use App\Models\Borrowing;
use App\Models\Book;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class BorrowingController extends Controller
{
    public function index(Request $request)
    {
        $query = Borrowing::with(['member', 'user'])->latest();
        
        if ($request->filled('search')) {
            $query->where('borrowing_code', 'like', "%{$request->search}%")
                  ->orWhereHas('member', function($q) use ($request) {
                      $q->where('name', 'like', "%{$request->search}%")
                        ->orWhere('member_code', 'like', "%{$request->search}%");
                  });
        }
        
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $borrowings = $query->paginate(10)->withQueryString();
        
        return view('borrowings.index', compact('borrowings'));
    }

    public function create()
    {
        $members = Member::where('status', 'active')->get();
        $books = Book::where('available_qty', '>', 0)->get();
        
        return view('borrowings.create', compact('members', 'books'));
    }

    public function store(StoreBorrowingRequest $request)
    {
        try {
            DB::beginTransaction();

            $borrowing = Borrowing::create([
                'borrowing_code' => Borrowing::generateCode(),
                'member_id' => $request->member_id,
                'borrow_date' => $request->borrow_date,
                'due_date' => $request->due_date,
                'user_id' => Auth::id(),
                'status' => 'borrowed',
                'notes' => $request->notes,
            ]);

            foreach ($request->books as $bookData) {
                $book = Book::findOrFail($bookData['id']);
                
                if ($book->available_qty < $bookData['qty']) {
                    throw new \Exception("Stok buku {$book->title} tidak mencukupi.");
                }

                $borrowing->details()->create([
                    'book_id' => $bookData['id'],
                    'qty' => $bookData['qty'],
                    'status' => 'borrowed'
                ]);

                // Reduce stock
                $book->decreaseStock($bookData['qty']);
            }

            DB::commit();

            return redirect()->route('borrowings.index')->with('success', 'Transaksi peminjaman berhasil disimpan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Gagal menyimpan transaksi: ' . $e->getMessage());
        }
    }

    public function show(Borrowing $borrowing)
    {
        $borrowing->load(['member', 'user', 'details.book']);
        return view('borrowings.show', compact('borrowing'));
    }

    public function destroy(Borrowing $borrowing)
    {
        // Only allow delete if returned or we should restore book stocks. 
        // For simplicity, let's restore stock if it's still borrowed.
        try {
            DB::beginTransaction();
            
            if ($borrowing->status === 'borrowed') {
                foreach ($borrowing->details as $detail) {
                    if ($detail->status === 'borrowed') {
                        $detail->book->increaseStock($detail->qty);
                    }
                }
            }
            
            $borrowing->details()->delete();
            $borrowing->delete();
            
            DB::commit();
            return redirect()->route('borrowings.index')->with('success', 'Data peminjaman berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }
}
