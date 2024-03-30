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
        'member_id', //here member means we consider players
    ];

    public function player()
    {
        return $this->belongsTo(Player::class, 'member_id', 'id');
    }

    public function team()
    {
        return $this->belongsTo(Team::class, 'team_id', 'id');
    }
}
