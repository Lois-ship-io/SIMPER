<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;

class Borrowing extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $fillable = [
        'borrowing_code',
        'member_id',
        'borrow_date',
        'due_date',
        'user_id',
        'status',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'borrow_date' => 'date',
            'due_date' => 'date',
        ];
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['borrowing_code', 'status'])
            ->logOnlyDirty()
            ->useLogName('borrowing');
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function details()
    {
        return $this->hasMany(BorrowingDetail::class);
    }

    public function returnBook()
    {
        return $this->hasOne(ReturnBook::class);
    }

    /**
     * Check if borrowing is overdue.
     */
    public function isOverdue(): bool
    {
        return $this->status === 'borrowed' && now()->greaterThan($this->due_date);
    }

    /**
     * Calculate late days from today.
     */
    public function calculateLateDays(): int
    {
        if (now()->lessThanOrEqualTo($this->due_date)) {
            return 0;
        }

        return (int) now()->diffInDays($this->due_date);
    }

    /**
     * Get total books in this borrowing.
     */
    public function getTotalBooksAttribute(): int
    {
        return $this->details->sum('qty');
    }

    /**
     * Generate a unique borrowing code.
     */
    public static function generateCode(): string
    {
        $prefix = 'PJM';
        $date = now()->format('ymd');
        $last = static::withTrashed()
            ->where('borrowing_code', 'like', "{$prefix}{$date}%")
            ->orderBy('borrowing_code', 'desc')
            ->first();

        if ($last) {
            $lastNumber = (int) substr($last->borrowing_code, -4);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        return $prefix . $date . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    }
}
