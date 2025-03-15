@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1>Dashboard Pedagang</h1>
            <p class="text-muted">Kelola ikan dan lelang Anda</p>
        </div>
        <div class="col-md-4 text-md-end">
            <a href="{{ route('pedagang.dashboard') }}" class="btn btn-primary">
                <i class="fas fa-sync-alt me-1"></i> Refresh Data
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-3 mb-4 mb-md-0">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Total Ikan</h6>
                            <h2 class="mb-0">{{ $stats['total_fish'] }}</h2>
                        </div>
                        <div class="rounded-circle bg-primary bg-opacity-10 p-3">
                            <i class="fas fa-fish fa-2x text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 mb-4 mb-md-0">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Lelang Aktif</h6>
                            <h2 class="mb-0">{{ $stats['active_auctions'] }}</h2>
                        </div>
                        <div class="rounded-circle bg-success bg-opacity-10 p-3">
                            <i class="fas fa-gavel fa-2x text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 mb-4 mb-md-0">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Lelang Selesai</h6>
                            <h2 class="mb-0">{{ $stats['completed_auctions'] }}</h2>
                        </div>
                        <div class="rounded-circle bg-info bg-opacity-10 p-3">
                            <i class="fas fa-check-circle fa-2x text-info"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Total Bid</h6>
                            <h2 class="mb-0">{{ $stats['total_bids_received'] }}</h2>
                        </div>
                        <div class="rounded-circle bg-warning bg-opacity-10 p-3">
                            <i class="fas fa-hand-paper fa-2x text-warning"></i>
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
                            <a href="#" class="btn btn-outline-primary w-100 py-3">
                                <i class="fas fa-fish mb-2 d-block fa-2x"></i>
                                Tambah Ikan Baru
                            </a>
                        </div>
                        <div class="col-md-4 mb-3 mb-md-0">
                            <a href="#" class="btn btn-outline-success w-100 py-3">
                                <i class="fas fa-gavel mb-2 d-block fa-2x"></i>
                                Buat Lelang Baru
                            </a>
                        </div>
                        <div class="col-md-4">
                            <a href="#" class="btn btn-outline-info w-100 py-3">
                                <i class="fas fa-history mb-2 d-block fa-2x"></i>
                                Riwayat Lelang
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Active Auctions -->
        <div class="col-md-8 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Lelang Aktif</h5>
                    <a href="#" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Ikan</th>
                                    <th>Harga Saat Ini</th>
                                    <th>Bid</th>
                                    <th>Berakhir</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($activeAuctions as $auction)
                                    <tr>
                                        <td>
                                            <a href="{{ route('auctions.show', $auction) }}">
                                                {{ $auction->fish->name }}
                                            </a>
                                        </td>
                                        <td>Rp {{ number_format($auction->current_price, 0, ',', '.') }}</td>
                                        <td>{{ $auction->bids->count() }}</td>
                                        <td>{{ $auction->end_time->format('d M Y, H:i') }}</td>
                                        <td>
                                            <a href="{{ route('auctions.show', $auction) }}" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-3">Belum ada lelang aktif</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Latest Fish -->
        <div class="col-md-4 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Ikan Terbaru</h5>
                    <a href="#" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        @forelse($latestFish as $fish)
                            <div class="list-group-item">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1">{{ $fish->name }}</h6>
                                    <small class="text-muted">{{ $fish->created_at->format('d M Y') }}</small>
                                </div>
                                <p class="mb-1 text-muted">{{ Str::limit($fish->description, 50) }}</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <small>Rp {{ number_format($fish->base_price, 0, ',', '.') }}</small>
                                    <span class="badge bg-{{ $fish->status == 'available' ? 'success' : ($fish->status == 'auction' ? 'warning' : 'secondary') }}">
                                        {{ $fish->status == 'available' ? 'Tersedia' : ($fish->status == 'auction' ? 'Lelang' : 'Terjual') }}
                                    </span>
                                </div>
                            </div>
                        @empty
                            <div class="list-group-item text-center py-3">
                                Belum ada ikan
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 