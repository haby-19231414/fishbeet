<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Auction extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'fish_id',
        'user_id',
        'start_price',
        'current_price',
        'min_bid',
        'start_time',
        'end_time',
        'status',
        'winner_id',
    ];
    
    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];
    
    /**
     * Get the fish that is being auctioned
     */
    public function fish()
    {
        return $this->belongsTo(Fish::class);
    }
    
    /**
     * Get the user that created the auction (pedagang)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    /**
     * Get the winner of the auction
     */
    public function winner()
    {
        return $this->belongsTo(User::class, 'winner_id');
    }
    
    /**
     * Get the bids for the auction
     */
    public function bids()
    {
        return $this->hasMany(Bid::class);
    }
    
    /**
     * Get the highest bid for the auction
     */
    public function highestBid()
    {
        return $this->hasOne(Bid::class)->orderBy('amount', 'desc');
    }
}
