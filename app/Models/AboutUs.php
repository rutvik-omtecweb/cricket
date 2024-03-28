<?php

namespace App\Models;

use Illuminate\Support\Facades\File;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AboutUs extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'body',
        'image',
        'president',
        'vice_president',
        'treasurer',
        'general_secretary',
        'league_manager',
        'latitude',
        'longitude',
    ];

    public function getImageAttribute($value)
    {
        if ($value) {
            if (File::exists(public_path('storage/about_us/' . $value))) {
                return asset('storage/about_us/' . $value);
            } else {
                return null;
            }
        } else {
            return null;
        }
    }
}
