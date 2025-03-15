@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<div class="bg-primary text-white py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6 mb-4 mb-md-0">
                <h1 class="display-4 fw-bold">FishBid</h1>
                <p class="lead">Platform pelelangan ikan online terpercaya di Indonesia. Temukan ikan segar berkualitas atau jual hasil tangkapan Anda dengan mudah.</p>
                <div class="d-flex gap-2 mt-4">
                    <a href="{{ route('auctions') }}" class="btn btn-light btn-lg">Lihat Lelang</a>
                    @guest
                        <a href="{{ route('register') }}" class="btn btn-outline-light btn-lg">Daftar Sekarang</a>
                    @endguest
                </div>
            </div>
            <div class="col-md-6">
                <img src="https://images.unsplash.com/photo-1534043464124-3be32fe000c9?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1170&q=80" alt="Fish Market" class="img-fluid rounded shadow">
            </div>
        </div>
    </div>
</div>

<!-- Lelang Aktif Section -->
<div class="py-5 bg-light">
    <div class="container">
        <div class="row mb-4">
            <div class="col-md-8">
                <h2 class="mb-0">Lelang Aktif</h2>
                <p class="text-muted">Lelang yang sedang berlangsung saat ini</p>
            </div>
            <div class="col-md-4 text-md-end">
                <a href="{{ route('auctions', ['status' => 'active']) }}" class="btn btn-primary">Lihat Semua</a>
            </div>
        </div>
        
        <div class="row">
            @forelse($activeAuctions as $auction)
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm auction-card">
                        <img src="{{ $auction->fish->image ? asset('storage/' . $auction->fish->image) : 'https://via.placeholder.com/300x200?text=No+Image' }}" 
                            alt="{{ $auction->fish->name }}" class="card-img-top fish-img">
                        <div class="card-body">
                            <h5 class="card-title">{{ $auction->fish->name }}</h5>
                            <p class="card-text text-muted">{{ Str::limit($auction->fish->description, 100) }}</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="fw-bold text-primary">Rp {{ number_format($auction->current_price, 0, ',', '.') }}</span>
                                <span class="badge bg-success">{{ $auction->bids->count() }} Bid</span>
                            </div>
                            <div class="mt-2">
                                <small class="text-muted">Berakhir: {{ $auction->end_time->format('d M Y, H:i') }}</small>
                            </div>
                        </div>
                        <div class="card-footer bg-white border-top-0">
                            <a href="{{ route('auctions.show', $auction) }}" class="btn btn-primary w-100">Detail Lelang</a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info">
                        Tidak ada lelang aktif saat ini.
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</div>

<!-- Lelang Mendatang Section -->
<div class="py-5">
    <div class="container">
        <div class="row mb-4">
            <div class="col-md-8">
                <h2 class="mb-0">Lelang Mendatang</h2>
                <p class="text-muted">Lelang yang akan datang</p>
            </div>
            <div class="col-md-4 text-md-end">
                <a href="{{ route('auctions', ['status' => 'upcoming']) }}" class="btn btn-primary">Lihat Semua</a>
            </div>
        </div>
        
        <div class="row">
            @forelse($upcomingAuctions as $auction)
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm auction-card">
                        <img src="{{ $auction->fish->image ? asset('storage/' . $auction->fish->image) : 'https://via.placeholder.com/300x200?text=No+Image' }}" 
                            alt="{{ $auction->fish->name }}" class="card-img-top fish-img">
                        <div class="card-body">
                            <h5 class="card-title">{{ $auction->fish->name }}</h5>
                            <p class="card-text text-muted">{{ Str::limit($auction->fish->description, 100) }}</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="fw-bold text-primary">Mulai: Rp {{ number_format($auction->start_price, 0, ',', '.') }}</span>
                            </div>
                            <div class="mt-2">
                                <small class="text-muted">Dimulai: {{ $auction->start_time->format('d M Y, H:i') }}</small>
                            </div>
                        </div>
                        <div class="card-footer bg-white border-top-0">
                            <a href="{{ route('auctions.show', $auction) }}" class="btn btn-outline-primary w-100">Detail Lelang</a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info">
                        Tidak ada lelang yang akan datang saat ini.
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</div>

<!-- Cara Kerja Section -->
<div class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2>Cara Kerja FishBid</h2>
            <p class="text-muted">Ikuti langkah-langkah berikut untuk mulai melelang atau membeli ikan</p>
        </div>
        
        <div class="row">
            <div class="col-md-3 mb-4 mb-md-0">
                <div class="card h-100 border-0 shadow-sm text-center p-4">
                    <div class="card-body">
                        <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center mx-auto mb-4" style="width: 80px; height: 80px;">
                            <i class="fas fa-user-plus fa-2x"></i>
                        </div>
                        <h5>Daftar Akun</h5>
                        <p class="text-muted">Buat akun sebagai pembeli atau pedagang ikan</p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3 mb-4 mb-md-0">
                <div class="card h-100 border-0 shadow-sm text-center p-4">
                    <div class="card-body">
                        <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center mx-auto mb-4" style="width: 80px; height: 80px;">
                            <i class="fas fa-fish fa-2x"></i>
                        </div>
                        <h5>Pilih Ikan</h5>
                        <p class="text-muted">Cari ikan yang ingin Anda beli atau jual</p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3 mb-4 mb-md-0">
                <div class="card h-100 border-0 shadow-sm text-center p-4">
                    <div class="card-body">
                        <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center mx-auto mb-4" style="width: 80px; height: 80px;">
                            <i class="fas fa-gavel fa-2x"></i>
                        </div>
                        <h5>Ikut Lelang</h5>
                        <p class="text-muted">Pasang bid atau buat lelang baru</p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3">
                <div class="card h-100 border-0 shadow-sm text-center p-4">
                    <div class="card-body">
                        <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center mx-auto mb-4" style="width: 80px; height: 80px;">
                            <i class="fas fa-handshake fa-2x"></i>
                        </div>
                        <h5>Transaksi</h5>
                        <p class="text-muted">Selesaikan transaksi dengan aman</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Script untuk countdown timer jika diperlukan
</script>
@endsection 