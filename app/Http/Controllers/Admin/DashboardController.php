<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Fish;
use App\Models\Auction;
use App\Models\Bid;

class DashboardController extends Controller
{
    /**
     * Show the admin dashboard
     */
    public function index()
    {
        // Statistik untuk dashboard admin
        $stats = [
            'total_users' => User::count(),
            'total_pedagang' => User::where('role', 'pedagang')->count(),
            'total_fish' => Fish::count(),
            'active_auctions' => Auction::where('status', 'active')->count(),
            'completed_auctions' => Auction::where('status', 'ended')->count(),
            'total_bids' => Bid::count(),
        ];
        
        // Lelang terbaru
        $latestAuctions = Auction::with(['fish', 'user'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
            
        // User terbaru
        $latestUsers = User::orderBy('created_at', 'desc')
            ->take(5)
            ->get();
            
        return view('admin.dashboard', compact('stats', 'latestAuctions', 'latestUsers'));
    }
} 