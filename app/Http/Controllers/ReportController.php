<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Borrowing;
use App\Models\ReturnBook;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function borrowings(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->endOfMonth()->format('Y-m-d'));
        $status = $request->input('status');

        $query = Borrowing::with(['member', 'user', 'details.book'])
            ->whereBetween('borrow_date', [$startDate, $endDate]);

        if ($status) {
            $query->where('status', $status);
        }

        $borrowings = $query->latest('borrow_date')->get();

        return view('reports.borrowings', compact('borrowings', 'startDate', 'endDate', 'status'));
    }

    public function returns(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->endOfMonth()->format('Y-m-d'));

        $query = ReturnBook::with(['borrowing.member', 'user', 'fines'])
            ->whereBetween('return_date', [$startDate, $endDate]);

        $returns = $query->latest('return_date')->get();

        // Calculate total fines for the period
        $totalFines = $returns->sum('total_fine');

        return view('reports.returns', compact('returns', 'startDate', 'endDate', 'totalFines'));
    }
}
