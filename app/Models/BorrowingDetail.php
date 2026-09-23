<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BorrowingDetail extends Model
{
    protected $fillable = [
        'borrowing_id',
        'book_id',
        'qty',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'qty' => 'integer',
        ];
    }

    public function borrowing()
    {
        return $this->belongsTo(Borrowing::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function returnDetail()
    {
        return $this->hasOne(ReturnDetail::class);
    }

    /**
     * Check if this detail has been returned.
     */
    public function isReturned(): bool
    {
        return $this->status === 'returned';
    }
}
