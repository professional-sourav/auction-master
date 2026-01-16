<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'auction_id',
        'buyer_id',
        'amount',
        'status',
        'payment_meta',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'payment_meta' => 'array',
    ];

    public function auction()
    {
        return $this->belongsTo(Auction::class);
    }

    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }
}
