<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReturnBook\StoreReturnBookRequest;
use App\Models\Borrowing;
use App\Models\ReturnBook;
use App\Models\ReturnDetail;
use App\Models\Fine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ReturnBookController extends Controller
{
    public function index(Request $request)
    {
        $query = ReturnBook::with(['borrowing.member', 'user'])->latest();
        
        if ($request->filled('search')) {
            $query->where('return_code', 'like', "%{$request->search}%")
                  ->orWhereHas('borrowing.member', function($q) use ($request) {
                      $q->where('name', 'like', "%{$request->search}%");
                  });
        }

        $returns = $query->paginate(10)->withQueryString();
        
        return view('returns.index', compact('returns'));
    }

    public function create(Request $request)
    {
        // Accept borrowing_id from query string to easily return a specific borrowing
        $borrowing_id = $request->query('borrowing_id');
        $borrowing = null;
        
        if ($borrowing_id) {
            $borrowing = Borrowing::with(['member', 'details.book'])->where('status', 'borrowed')->find($borrowing_id);
        }

        $activeBorrowings = Borrowing::with('member')->where('status', 'borrowed')->get();
        
        return view('returns.create', compact('borrowing', 'activeBorrowings'));
    }

    public function store(StoreReturnBookRequest $request)
    {
        try {
            DB::beginTransaction();

            $borrowing = Borrowing::findOrFail($request->borrowing_id);
            $totalFine = 0;

            $returnBook = ReturnBook::create([
                'return_code' => ReturnBook::generateCode(),
                'borrowing_id' => $borrowing->id,
                'return_date' => $request->return_date,
                'user_id' => Auth::id(),
                'total_fine' => 0, // Will update later
                'notes' => $request->notes,
            ]);

            // Late fine calculation
            $lateDays = 0;
            $returnDate = \Carbon\Carbon::parse($request->return_date);
            if ($returnDate->greaterThan($borrowing->due_date)) {
                $lateDays = $returnDate->diffInDays($borrowing->due_date);
                // Assume 1000 per day fine
                $lateFineAmount = $lateDays * 1000;
                
                Fine::create([
                    'member_id' => $borrowing->member_id,
                    'return_book_id' => $returnBook->id,
                    'amount' => $lateFineAmount,
                    'fine_type' => 'late',
                    'status' => 'unpaid',
                    'notes' => "Terlambat {$lateDays} hari",
                ]);
                $totalFine += $lateFineAmount;
            }

            foreach ($request->books as $bookData) {
                $detail = $borrowing->details()->findOrFail($bookData['id']);
                
                ReturnDetail::create([
                    'return_book_id' => $returnBook->id,
                    'borrowing_detail_id' => $detail->id,
                    'qty_returned' => $bookData['qty_returned'],
                    'condition' => $bookData['condition'],
                    'fine_amount' => $bookData['fine_amount'] ?? 0,
                ]);

                if (!empty($bookData['fine_amount']) && $bookData['fine_amount'] > 0) {
                    Fine::create([
                        'member_id' => $borrowing->member_id,
                        'return_book_id' => $returnBook->id,
                        'amount' => $bookData['fine_amount'],
                        'fine_type' => $bookData['condition'] == 'lost' ? 'lost' : 'damaged',
                        'status' => 'unpaid',
                        'notes' => "Buku " . $detail->book->title . " " . ($bookData['condition'] == 'lost' ? 'hilang' : 'rusak'),
                    ]);
                    $totalFine += $bookData['fine_amount'];
                }

                // Update detail status
                if ($bookData['qty_returned'] >= $detail->qty) {
                    $detail->update(['status' => 'returned']);
                } else {
                    $detail->update(['status' => 'partial_returned']);
                }

                // Restore stock if returned in good or damaged (if damaged still can be fixed maybe? let's just restore if not lost)
                if ($bookData['condition'] !== 'lost') {
                    $detail->book->increaseStock($bookData['qty_returned']);
                }
            }

            $returnBook->update(['total_fine' => $totalFine]);

            // Check if all details are returned
            $allReturned = $borrowing->details()->where('status', 'borrowed')->count() === 0;
            if ($allReturned) {
                $borrowing->update(['status' => 'returned']);
            } else {
                $borrowing->update(['status' => 'partial_returned']);
            }

            DB::commit();

            return redirect()->route('returns.index')->with('success', 'Pengembalian buku berhasil diproses.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Gagal memproses pengembalian: ' . $e->getMessage());
        }
    }

    public function show(ReturnBook $return) // Note parameter name matches route variable which is likely `return`
    {
        $return->load(['borrowing.member', 'user', 'details.borrowingDetail.book', 'fines']);
        return view('returns.show', compact('return'));
    }
}
