@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1>Dashboard</h1>
            <p class="text-muted">Kelola aktivitas lelang Anda</p>
        </div>
        <div class="col-md-4 text-md-end">
            <a href="{{ route('user.dashboard') }}" class="btn btn-primary">
                <i class="fas fa-sync-alt me-1"></i> Refresh Data
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-4 mb-4 mb-md-0">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Total Bid</h6>
                            <h2 class="mb-0">{{ $stats['total_bids'] }}</h2>
                        </div>
                        <div class="rounded-circle bg-primary bg-opacity-10 p-3">
                            <i class="fas fa-hand-paper fa-2x text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 mb-4 mb-md-0">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Bid Aktif</h6>
                            <h2 class="mb-0">{{ $stats['active_bids'] }}</h2>
                        </div>
                        <div class="rounded-circle bg-success bg-opacity-10 p-3">
                            <i class="fas fa-gavel fa-2x text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Lelang Dimenangkan</h6>
                            <h2 class="mb-0">{{ $stats['won_auctions'] }}</h2>
                        </div>
                        <div class="rounded-circle bg-warning bg-opacity-10 p-3">
                            <i class="fas fa-trophy fa-2x text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Quick Actions -->
        <div class="col-12 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Aksi Cepat</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3 mb-md-0">
                            <a href="{{ route('auctions') }}" class="btn btn-outline-primary w-100 py-3">
                                <i class="fas fa-search mb-2 d-block fa-2x"></i>
                                Cari Lelang
                            </a>
                        </div>
                        <div class="col-md-4 mb-3 mb-md-0">
                            <a href="{{ route('user.bids') }}" class="btn btn-outline-success w-100 py-3">
                                <i class="fas fa-hand-paper mb-2 d-block fa-2x"></i>
                                Bid Saya
                            </a>
                        </div>
                        <div class="col-md-4">
                            <a href="{{ route('user.won-auctions') }}" class="btn btn-outline-warning w-100 py-3">
                                <i class="fas fa-trophy mb-2 d-block fa-2x"></i>
                                Lelang Dimenangkan
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Latest Bids -->
        <div class="col-md-6 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Bid Terbaru</h5>
                    <a href="{{ route('user.bids') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Ikan</th>
                                    <th>Jumlah Bid</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($latestBids as $bid)
                                    <tr>
                                        <td>
                                            <a href="{{ route('auctions.show', $bid->auction) }}">
                                                {{ $bid->auction->fish->name }}
                                            </a>
                                        </td>
                                        <td>Rp {{ number_format($bid->amount, 0, ',', '.') }}</td>
                                        <td>
                                            @if($bid->auction->status == 'active')
                                                @if($bid->auction->current_price == $bid->amount)
                                                    <span class="badge bg-success">Tertinggi</span>
                                                @else
                                                    <span class="badge bg-warning">Tersaingi</span>
                                                @endif
                                            @elseif($bid->auction->status == 'ended')
                                                @if($bid->auction->winner_id == Auth::id())
                                                    <span class="badge bg-success">Menang</span>
                                                @else
                                                    <span class="badge bg-secondary">Kalah</span>
                                                @endif
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('auctions.show', $bid->auction) }}" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-3">Belum ada bid</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Won Auctions -->
        <div class="col-md-6 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Lelang Dimenangkan</h5>
                    <a href="{{ route('user.won-auctions') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Ikan</th>
                                    <th>Harga Final</th>
                                    <th>Tanggal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($wonAuctions as $auction)
                                    <tr>
                                        <td>
                                            <a href="{{ route('auctions.show', $auction) }}">
                                                {{ $auction->fish->name }}
                                            </a>
                                        </td>
                                        <td>Rp {{ number_format($auction->current_price, 0, ',', '.') }}</td>
                                        <td>{{ $auction->end_time->format('d M Y') }}</td>
                                        <td>
                                            <a href="{{ route('auctions.show', $auction) }}" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-3">Belum ada lelang yang dimenangkan</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 