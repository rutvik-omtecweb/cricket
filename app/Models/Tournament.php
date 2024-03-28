<?php

namespace App\Models;

use Illuminate\Support\Facades\File;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tournament extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'title',
        'description',
        'image',
        'is_active',
        'type' //0 - past_tournament | 1 - photos
    ];

    public function getImageAttribute($value)
    {
        if ($value) {
            if (File::exists(public_path('storage/tournament/' . $value))) {
                return asset('storage/tournament/' . $value);
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

    protected $casts = [
        'is_active' => 'integer',
    ];

}
