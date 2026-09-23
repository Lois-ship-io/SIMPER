<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;

class Member extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $fillable = [
        'member_code',
        'nis',
        'name',
        'gender',
        'class',
        'major',
        'phone',
        'address',
        'photo',
        'status',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name', 'nis', 'status'])
            ->logOnlyDirty()
            ->useLogName('member');
    }

    /**
     * Get the member's photo URL.
     */
    public function getPhotoUrlAttribute(): string
    {
        if ($this->photo) {
            return asset('storage/photos/' . $this->photo);
        }

        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&color=7F9CF5&background=EBF4FF';
    }

    /**
     * Get the gender label.
     */
    public function getGenderLabelAttribute(): string
    {
        return $this->gender === 'L' ? 'Laki-laki' : 'Perempuan';
    }

    public function borrowings()
    {
        return $this->hasMany(Borrowing::class);
    }

    public function visitors()
    {
        return $this->hasMany(Visitor::class);
    }

    public function fines()
    {
        return $this->hasMany(Fine::class);
    }

    /**
     * Check if member has any active (unreturned) borrowings.
     */
    public function hasActiveBorrowing(): bool
    {
        return $this->borrowings()->whereIn('status', ['borrowed', 'overdue'])->exists();
    }

    /**
     * Check if member has unpaid fines.
     */
    public function hasUnpaidFines(): bool
    {
        return $this->fines()->whereIn('status', ['unpaid', 'partial'])->exists();
    }
}
