<?php

namespace App\Models;

use Illuminate\Support\Facades\File;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Team extends Model
{
    use HasFactory, HasUuids;
    protected $fillable = [
        'team_name',
        'description',
        'image',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'integer',
    ];

    public function getImageAttribute($value)
    {
        if ($value) {
            if (File::exists(public_path('storage/teams/' . $value))) {
                return asset('storage/teams/' . $value);
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


    public function team_member()
    {
        return $this->hasMany(TeamMember::class);
    }
}