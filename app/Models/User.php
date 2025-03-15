<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Check if user is admin
     */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user is pedagang
     */
    public function isPedagang()
    {
        return $this->role === 'pedagang';
    }

    /**
     * Get the fish owned by the user
     */
    public function fish()
    {
        return $this->hasMany(Fish::class);
    }

    /**
     * Get the auctions created by the user
     */
    public function auctions()
    {
        return $this->hasMany(Auction::class);
    }

    /**
     * Get the bids made by the user
     */
    public function bids()
    {
        return $this->hasMany(Bid::class);
    }

    /**
     * Get the auctions won by the user
     */
    public function wonAuctions()
    {
        return $this->hasMany(Auction::class, 'winner_id');
    }
}
