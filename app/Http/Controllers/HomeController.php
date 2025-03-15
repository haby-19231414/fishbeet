<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Auction;
use App\Models\Bid;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Show the home page
     */
    public function index()
    {
        // Ambil 5 lelang aktif terbaru
        $activeAuctions = Auction::where('status', 'active')
            ->orderBy('end_time', 'asc')
            ->take(5)
            ->get();
            
        // Ambil 5 lelang yang akan datang
        $upcomingAuctions = Auction::where('status', 'upcoming')
            ->orderBy('start_time', 'asc')
            ->take(5)
            ->get();
            
        return view('home', compact('activeAuctions', 'upcomingAuctions'));
    }
    
    /**
     * Show all auctions
     */
    public function auctions(Request $request)
    {
        $status = $request->input('status', 'active');
        
        $query = Auction::query();
        
        if ($status) {
            $query->where('status', $status);
        }
        
        // Filter berdasarkan jenis ikan jika ada
        if ($request->has('species')) {
            $query->whereHas('fish', function($q) use ($request) {
                $q->where('species', $request->species);
            });
        }
        
        // Urutkan berdasarkan parameter
        $sort = $request->input('sort', 'end_time');
        $direction = $request->input('direction', 'asc');
        
        $query->orderBy($sort, $direction);
        
        $auctions = $query->paginate(12);
        
        return view('auctions.index', compact('auctions', 'status'));
    }
    
    /**
     * Show auction details
     */
    public function showAuction(Auction $auction)
    {
        // Load relasi yang dibutuhkan
        $auction->load(['fish', 'user', 'bids' => function($query) {
            $query->orderBy('amount', 'desc');
        }]);
        
        return view('auctions.show', compact('auction'));
    }
    
    /**
     * Place a bid on an auction
     */
    public function placeBid(Request $request, Auction $auction)
    {
        // Validasi input
        $request->validate([
            'amount' => [
                'required',
                'numeric',
                'min:' . ($auction->current_price + $auction->min_bid)
            ],
        ]);
        
        // Cek apakah lelang masih aktif
        if ($auction->status !== 'active') {
            return back()->with('error', 'Lelang ini tidak aktif.');
        }
        
        // Cek apakah user adalah pemilik lelang
        if ($auction->user_id === Auth::id()) {
            return back()->with('error', 'Anda tidak dapat memasang bid pada lelang Anda sendiri.');
        }
        
        // Buat bid baru
        $bid = new Bid();
        $bid->auction_id = $auction->id;
        $bid->user_id = Auth::id();
        $bid->amount = $request->amount;
        $bid->save();
        
        // Update harga saat ini di lelang
        $auction->current_price = $request->amount;
        $auction->save();
        
        return back()->with('success', 'Bid berhasil dipasang!');
    }
} 