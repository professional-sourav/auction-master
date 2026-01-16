<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuctionItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'auction_id',
        'name',
        'description',
        'images',
        'condition',
        'category_id',
    ];

    protected $casts = [
        'images' => 'array',
    ];

    public function auction()
    {
        return $this->belongsTo(Auction::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
