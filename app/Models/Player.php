<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Player extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'user_id',
        'payment_type',
        'amount',
        'transaction_id',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function teamMember()
    {
        return $this->belongsToMany(TeamMember::class);
    }


}
