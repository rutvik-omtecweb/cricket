<?php

namespace App\Models;

use Illuminate\Support\Facades\File;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sponsors extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'title',
        'order',
        'image',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'integer',
    ];

    public function getImageAttribute($value)
    {
        if ($value) {
            if (File::exists(public_path('storage/sponsor/' . $value))) {
                return asset('storage/sponsor/' . $value);
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
