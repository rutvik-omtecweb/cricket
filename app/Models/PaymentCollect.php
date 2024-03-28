<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentCollect extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'user_id',
        'payment_type',
        'amount',
        'transaction_id',
        'status',
        'expired_date',
    ];
}
