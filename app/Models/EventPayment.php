<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventPayment extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'user_id',
        'event_id',
        'amount',
        'transaction_id',
        'status',
        'payment_type',
        'payment_for'
    ];

    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
