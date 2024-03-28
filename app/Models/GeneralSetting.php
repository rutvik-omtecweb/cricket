<?php

namespace App\Models;

use Illuminate\Support\Facades\File;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GeneralSetting extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'site_name', 'phone', 'logo', 'favicon', 'email',
        'copyright_text', 'address',
        'is_active'
    ];


    public function getLogoAttribute($value)
    {
        if ($value) {
            if (File::exists(public_path('storage/setting/' . $value))) {
                return asset('storage/setting/' . $value);
            } else {
                return null;
            }
        } else {
            return null;
        }
    }

    public function getFaviconAttribute($value)
    {
        if ($value) {
            if (File::exists(public_path('storage/setting/' . $value))) {
                return asset('storage/setting/' . $value);
            } else {
                return null;
            }
        } else {
            return null;
        }
    }
}
