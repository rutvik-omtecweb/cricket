<?php

namespace App\Models;

use Illuminate\Support\Facades\File;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Event extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'title',
        'description',
        'image',
        'is_active',
        'start_date',
        'end_date',
        'number_of_team',
        'team_price',
        'participant_price',
        'limit_number_of_team',
        'email_notifications',
        'location'
    ];

    public function getImageAttribute($value)
    {
        if ($value) {
            if (File::exists(public_path('storage/event/' . $value))) {
                return asset('storage/event/' . $value);
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
