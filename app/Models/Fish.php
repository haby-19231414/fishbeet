<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fish extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'name',
        'description',
        'species',
        'weight',
        'image',
        'base_price',
        'status',
    ];
    
    /**
     * Get the user that owns the fish
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    /**
     * Get the auctions for the fish
     */
    public function auctions()
    {
        return $this->hasMany(Auction::class);
    }
    
    /**
     * Get the active auction for the fish
     */
    public function activeAuction()
    {
        return $this->hasOne(Auction::class)->where('status', 'active');
    }
}
