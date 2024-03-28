<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LiveScore extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'current_link',
        'past_link',
    ];
}
