<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Auction;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Show the user dashboard
     */
    public function index()
    {
        $user = Auth::user();
        
        // Statistik untuk dashboard user
        $stats = [
            'total_bids' => $user->bids()->count(),
            'active_bids' => $user->bids()->whereHas('auction', function($q) {
                $q->where('status', 'active');
            })->count(),
            'won_auctions' => $user->wonAuctions()->count(),
        ];
        
        // Bid terbaru yang dibuat user
        $latestBids = $user->bids()
            ->with(['auction', 'auction.fish'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
            
        // Lelang yang dimenangkan user
        $wonAuctions = $user->wonAuctions()
            ->with('fish')
            ->orderBy('end_time', 'desc')
            ->take(5)
            ->get();
            
        return view('user.dashboard', compact('stats', 'latestBids', 'wonAuctions'));
    }
    
    /**
     * Show all bids made by the user
     */
    public function myBids()
    {
        $bids = Auth::user()->bids()
            ->with(['auction', 'auction.fish'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('user.bids', compact('bids'));
    }
    
    /**
     * Show all auctions won by the user
     */
    public function wonAuctions()
    {
        $auctions = Auth::user()->wonAuctions()
            ->with('fish')
            ->orderBy('end_time', 'desc')
            ->paginate(10);
            
        return view('user.won-auctions', compact('auctions'));
    }
} 