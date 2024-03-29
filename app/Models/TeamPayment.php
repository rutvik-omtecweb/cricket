<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class TeamPayment extends Model
{
    use HasFactory, HasUuids;
    protected $fillable = [
        'user_id',
        'team_id',
        'payment_type',
        'amount',
        'transaction_id',
        'status',
    ];

    public function team()
    {
        return $this->belongsTo(Team::class, 'team_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    
}
