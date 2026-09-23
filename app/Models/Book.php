<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;

class Book extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $fillable = [
        'book_code',
        'isbn',
        'title',
        'category_id',
        'author',
        'publisher_id',
        'publish_year',
        'rack_id',
        'total_qty',
        'available_qty',
        'cover',
        'description',
        'status',
        'qr_code',
    ];

    protected function casts(): array
    {
        return [
            'total_qty' => 'integer',
            'available_qty' => 'integer',
        ];
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['title', 'isbn', 'total_qty', 'available_qty', 'status'])
            ->logOnlyDirty()
            ->useLogName('book');
    }

    /**
     * Get the cover URL.
     */
    public function getCoverUrlAttribute(): string
    {
        if ($this->cover) {
            return asset('storage/covers/' . $this->cover);
        }

        return asset('images/no-cover.png');
    }


    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function publisher()
    {
        return $this->belongsTo(Publisher::class);
    }

    public function rack()
    {
        return $this->belongsTo(Rack::class);
    }

    public function borrowingDetails()
    {
        return $this->hasMany(BorrowingDetail::class);
    }

    /**
     * Check if book is available for borrowing.
     */
    public function isAvailable(): bool
    {
        return $this->available_qty > 0 && $this->status === 'available';
    }

    /**
     * Decrease available stock.
     */
    public function decreaseStock(int $qty = 1): void
    {
        $this->decrement('available_qty', $qty);

        if ($this->available_qty <= 0) {
            $this->update(['status' => 'unavailable']);
        }
    }

    /**
     * Increase available stock.
     */
    public function increaseStock(int $qty = 1): void
    {
        $this->increment('available_qty', $qty);

        if ($this->available_qty > 0 && $this->status === 'unavailable') {
            $this->update(['status' => 'available']);
        }
    }

    /**
     * Generate a unique book code.
     */
    public static function generateCode(): string
    {
        $prefix = 'BK';
        $date = now()->format('ymd');
        $lastBook = static::withTrashed()
            ->where('book_code', 'like', "{$prefix}{$date}%")
            ->orderBy('book_code', 'desc')
            ->first();

        if ($lastBook) {
            $lastNumber = (int) substr($lastBook->book_code, -4);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        return $prefix . $date . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    }
}
