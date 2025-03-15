<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bid extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'auction_id',
        'user_id',
        'amount',
        'is_winner',
    ];
    
    /**
     * Get the auction that the bid belongs to
     */
    public function auction()
    {
        return $this->belongsTo(Auction::class);
    }
    
    /**
     * Get the user that made the bid
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
