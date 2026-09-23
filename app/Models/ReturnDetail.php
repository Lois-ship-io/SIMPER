<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReturnDetail extends Model
{
    protected $fillable = [
        'return_id',
        'borrowing_detail_id',
        'book_id',
        'qty',
        'condition',
        'late_days',
        'fine_amount',
    ];

    protected function casts(): array
    {
        return [
            'qty' => 'integer',
            'late_days' => 'integer',
            'fine_amount' => 'decimal:2',
        ];
    }

    public function returnBook()
    {
        return $this->belongsTo(ReturnBook::class, 'return_id');
    }

    public function borrowingDetail()
    {
        return $this->belongsTo(BorrowingDetail::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}
