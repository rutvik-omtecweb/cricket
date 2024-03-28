<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TeamMember extends Model
{
    use HasFactory, HasUuids;
    protected $fillable = [
        'team_id',
        'member_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'member_id', 'id');
    }
}
