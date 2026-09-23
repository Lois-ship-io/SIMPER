<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Visitor extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'pekerjaan',
        'purpose',
        'visit_date',
    ];

    protected function casts(): array
    {
        return [
            'visit_date' => 'date',
        ];
    }
}
