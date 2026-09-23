<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrowing;
use App\Models\Member;
use App\Models\ReturnBook;
use App\Models\Visitor;
use App\Models\Fine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\Models\Activity;

class DashboardController extends Controller
{
    public function index()
    {
        $today = now()->toDateString();
        $thisMonth = now()->format('Y-m');

        // Statistics
        $stats = [
            'total_books' => Book::sum('total_qty'),
            'available_books' => Book::sum('available_qty'),
            'borrowed_books' => Book::sum('total_qty') - Book::sum('available_qty'),
            'total_members' => Member::count(),
            'visitors_today' => Visitor::whereDate('visit_date', $today)->count(),
            'borrowings_today' => Borrowing::whereDate('borrow_date', $today)->count(),
            'returns_today' => ReturnBook::whereDate('return_date', $today)->count(),
            'fines_today' => Fine::whereDate('created_at', $today)->sum('amount'),
            'total_fine_income' => Fine::sum('paid_amount'),
        ];

        // Monthly Chart Data (Last 6 months)
        $months = [];
        $borrowingData = [];
        $returnData = [];
        
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $months[] = $month->translatedFormat('M Y');
            
            $borrowingData[] = Borrowing::whereYear('borrow_date', $month->year)
                ->whereMonth('borrow_date', $month->month)
                ->count();
                
            $returnData[] = ReturnBook::whereYear('return_date', $month->year)
                ->whereMonth('return_date', $month->month)
                ->count();
        }

        $chartData = [
            'labels' => $months,
            'borrowings' => $borrowingData,
            'returns' => $returnData,
        ];

        // Popular Books (Most borrowed)
        $popularBooks = DB::table('borrowing_details')
            ->select('books.title', 'books.cover', DB::raw('count(borrowing_details.book_id) as total_borrowed'))
            ->join('books', 'books.id', '=', 'borrowing_details.book_id')
            ->groupBy('books.id', 'books.title', 'books.cover')
            ->orderByDesc('total_borrowed')
            ->limit(5)
            ->get();

        // Recent Activities
        $recentActivities = Activity::with('causer')
            ->latest()
            ->limit(5)
            ->get();

        return view('dashboard.index', compact('stats', 'chartData', 'popularBooks', 'recentActivities'));
    }
}
