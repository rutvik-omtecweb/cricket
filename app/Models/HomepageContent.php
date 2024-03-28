<?php

namespace App\Models;

use Illuminate\Support\Facades\File;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HomepageContent extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'description',
        'image',
        'is_active',
    ];

    public function getImageAttribute($value)
    {
        if ($value) {
            if (File::exists(public_path('storage/home_content/' . $value))) {
                return asset('storage/home_content/' . $value);
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
