<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class TeamPayment extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'team_id',
        'payment_type',
        'amount',
        'transaction_id',
        'status',
        'expired_date',
    ];
    
}
