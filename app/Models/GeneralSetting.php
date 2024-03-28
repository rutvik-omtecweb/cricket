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
        'site_name', 'phone', 'email', 'address',
        'is_active'
    ];

}
