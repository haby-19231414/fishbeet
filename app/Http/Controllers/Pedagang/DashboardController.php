<?php

namespace App\Http\Controllers\Pedagang;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Fish;
use App\Models\Auction;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Show the pedagang dashboard
     */
    public function index()
    {
        $user = Auth::user();
        
        // Statistik untuk dashboard pedagang
        $stats = [
            'total_fish' => $user->fish()->count(),
            'active_auctions' => $user->auctions()->where('status', 'active')->count(),
            'completed_auctions' => $user->auctions()->where('status', 'ended')->count(),
            'total_bids_received' => $user->auctions()->withCount('bids')->get()->sum('bids_count'),
        ];
        
        // Ikan terbaru yang dimiliki pedagang
        $latestFish = $user->fish()
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
            
        // Lelang aktif yang dibuat pedagang
        $activeAuctions = $user->auctions()
            ->where('status', 'active')
            ->with('fish')
            ->orderBy('end_time', 'asc')
            ->get();
            
        return view('pedagang.dashboard', compact('stats', 'latestFish', 'activeAuctions'));
    }
} 