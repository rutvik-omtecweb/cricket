<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\File;

class Banner extends Model
{
    use HasFactory, HasUuids;
    protected $fillable = [
        'title',
        'description',
        'image',
        'is_active',
        'order'
    ];

    protected $casts = [
        'is_active' => 'integer',
    ];


    public function getImageAttribute($value)
    {
        if ($value) {
            if (File::exists(public_path('storage/banner/' . $value))) {
                return asset('storage/banner/' . $value);
            } else {
                return null;
            }
        } else {
            return null;
        }
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
