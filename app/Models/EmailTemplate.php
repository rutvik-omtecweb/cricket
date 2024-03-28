<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EmailTemplate extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'title',
        'content',
        'subject',
        'is_active',
        'created_by',
        'updated_by',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
