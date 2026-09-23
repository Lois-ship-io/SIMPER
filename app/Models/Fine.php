<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Fine extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'return_id',
        'member_id',
        'amount',
        'paid_amount',
        'status',
        'paid_date',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'paid_amount' => 'decimal:2',
            'paid_date' => 'date',
        ];
    }

    public function returnBook()
    {
        return $this->belongsTo(ReturnBook::class, 'return_id');
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    /**
     * Get remaining amount to pay.
     */
    public function getRemainingAttribute(): float
    {
        return max(0, $this->amount - $this->paid_amount);
    }

    /**
     * Mark as paid.
     */
    public function markAsPaid(float $amount = null): void
    {
        $payAmount = $amount ?? $this->remaining;
        $this->paid_amount += $payAmount;

        if ($this->paid_amount >= $this->amount) {
            $this->status = 'paid';
            $this->paid_date = now();
        } else {
            $this->status = 'partial';
        }

        $this->save();
    }
}
