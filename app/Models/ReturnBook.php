<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;

class ReturnBook extends Model
{
    use SoftDeletes, LogsActivity;

    protected $table = 'returns';

    protected $fillable = [
        'return_code',
        'borrowing_id',
        'return_date',
        'late_days',
        'total_fine',
        'fine_status',
        'paid_amount',
        'user_id',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'return_date' => 'date',
            'late_days' => 'integer',
            'total_fine' => 'decimal:2',
            'paid_amount' => 'decimal:2',
        ];
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['return_code', 'fine_status', 'total_fine'])
            ->logOnlyDirty()
            ->useLogName('return');
    }

    public function borrowing()
    {
        return $this->belongsTo(Borrowing::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function details()
    {
        return $this->hasMany(ReturnDetail::class, 'return_id');
    }

    public function fine()
    {
        return $this->hasOne(Fine::class, 'return_id');
    }

    /**
     * Check if fine is fully paid.
     */
    public function isFinePaid(): bool
    {
        return $this->fine_status === 'paid' || $this->fine_status === 'no_fine';
    }

    /**
     * Get remaining fine amount.
     */
    public function getRemainingFineAttribute(): float
    {
        return max(0, $this->total_fine - $this->paid_amount);
    }

    /**
     * Generate a unique return code.
     */
    public static function generateCode(): string
    {
        $prefix = 'KBL';
        $date = now()->format('ymd');
        $last = static::withTrashed()
            ->where('return_code', 'like', "{$prefix}{$date}%")
            ->orderBy('return_code', 'desc')
            ->first();

        if ($last) {
            $lastNumber = (int) substr($last->return_code, -4);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        return $prefix . $date . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    }
}
