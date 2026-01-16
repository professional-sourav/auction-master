<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Auction extends Model
{
    use HasFactory;

    protected $fillable = [
        'seller_id',
        'type',
        'status',
        'title',
        'description',
        'start_time',
        'end_time',
        'starting_price',
        'min_increment',
        'reserve_price',
        'buy_now_price',
        'current_bid_id',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'starting_price' => 'decimal:2',
        'min_increment' => 'decimal:2',
        'reserve_price' => 'decimal:2',
        'buy_now_price' => 'decimal:2',
    ];

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function items()
    {
        return $this->hasMany(AuctionItem::class);
    }

    public function bids()
    {
        return $this->hasMany(Bid::class);
    }

    public function autoBids()
    {
        return $this->hasMany(AutoBid::class);
    }

    public function currentBid()
    {
        return $this->belongsTo(Bid::class, 'current_bid_id');
    }

    public function transaction()
    {
        return $this->hasOne(Transaction::class);
    }
}
