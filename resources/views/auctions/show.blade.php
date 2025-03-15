@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row">
        <!-- Breadcrumb -->
        <div class="col-12 mb-4">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('auctions') }}">Lelang</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $auction->fish->name }}</li>
                </ol>
            </nav>
        </div>
        
        <!-- Fish Image -->
        <div class="col-md-6 mb-4 mb-md-0">
            <div class="card border-0 shadow-sm">
                <img src="{{ $auction->fish->image ? asset('storage/' . $auction->fish->image) : 'https://via.placeholder.com/600x400?text=No+Image' }}" 
                    alt="{{ $auction->fish->name }}" class="card-img-top img-fluid">
                <div class="card-body">
                    <h5 class="card-title">Informasi Ikan</h5>
                    <div class="row">
                        <div class="col-6">
                            <p class="mb-1"><strong>Jenis:</strong> {{ $auction->fish->species }}</p>
                            <p class="mb-1"><strong>Berat:</strong> {{ $auction->fish->weight }} kg</p>
                        </div>
                        <div class="col-6">
                            <p class="mb-1"><strong>Penjual:</strong> {{ $auction->user->name }}</p>
                            <p class="mb-1"><strong>Status:</strong> 
                                @if($auction->status == 'upcoming')
                                    <span class="badge bg-info">Akan Datang</span>
                                @elseif($auction->status == 'active')
                                    <span class="badge bg-success">Aktif</span>
                                @elseif($auction->status == 'ended')
                                    <span class="badge bg-secondary">Selesai</span>
                                @else
                                    <span class="badge bg-danger">Dibatalkan</span>
                                @endif
                            </p>
                        </div>
                    </div>
                    <hr>
                    <h6>Deskripsi:</h6>
                    <p>{{ $auction->fish->description }}</p>
                </div>
            </div>
        </div>
        
        <!-- Auction Details -->
        <div class="col-md-6">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <h2 class="card-title">{{ $auction->fish->name }}</h2>
                    
                    @if($auction->status == 'active')
                        <div class="alert alert-info">
                            <div class="d-flex justify-content-between align-items-center">
                                <span>Lelang berakhir dalam:</span>
                                <span class="auction-timer fw-bold" data-end="{{ $auction->end_time }}">
                                    {{ $auction->end_time->diffForHumans() }}
                                </span>
                            </div>
                        </div>
                    @elseif($auction->status == 'upcoming')
                        <div class="alert alert-warning">
                            <div class="d-flex justify-content-between align-items-center">
                                <span>Lelang dimulai dalam:</span>
                                <span class="auction-timer fw-bold" data-start="{{ $auction->start_time }}">
                                    {{ $auction->start_time->diffForHumans() }}
                                </span>
                            </div>
                        </div>
                    @elseif($auction->status == 'ended' && $auction->winner_id)
                        <div class="alert alert-success">
                            <div class="d-flex justify-content-between align-items-center">
                                <span>Lelang telah selesai</span>
                                <span class="fw-bold">Pemenang: {{ $auction->winner->name }}</span>
                            </div>
                        </div>
                    @endif
                    
                    <div class="d-flex justify-content-between align-items-center my-4">
                        <div>
                            <p class="text-muted mb-0">Harga Saat Ini</p>
                            <h3 class="text-primary mb-0">Rp {{ number_format($auction->current_price, 0, ',', '.') }}</h3>
                        </div>
                        <div class="text-end">
                            <p class="text-muted mb-0">Harga Awal</p>
                            <h5 class="mb-0">Rp {{ number_format($auction->start_price, 0, ',', '.') }}</h5>
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-between text-muted mb-4">
                        <span>Minimal Kenaikan Bid: Rp {{ number_format($auction->min_bid, 0, ',', '.') }}</span>
                        <span>Total Bid: {{ $auction->bids->count() }}</span>
                    </div>
                    
                    @if($auction->status == 'active' && Auth::check() && Auth::id() != $auction->user_id)
                        <form action="{{ route('auctions.bid', $auction) }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="amount" class="form-label">Jumlah Bid (Rp)</label>
                                <input type="number" class="form-control form-control-lg @error('amount') is-invalid @enderror" 
                                    id="amount" name="amount" min="{{ $auction->current_price + $auction->min_bid }}" 
                                    value="{{ old('amount', $auction->current_price + $auction->min_bid) }}" required>
                                @error('amount')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">
                                    Minimal bid: Rp {{ number_format($auction->current_price + $auction->min_bid, 0, ',', '.') }}
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary btn-lg w-100">Pasang Bid</button>
                        </form>
                    @elseif($auction->status == 'active' && Auth::check() && Auth::id() == $auction->user_id)
                        <div class="alert alert-warning">
                            Anda tidak dapat memasang bid pada lelang Anda sendiri.
                        </div>
                    @elseif($auction->status == 'active' && !Auth::check())
                        <div class="alert alert-info">
                            Silakan <a href="{{ route('login') }}">login</a> untuk memasang bid.
                        </div>
                    @elseif($auction->status == 'upcoming')
                        <div class="alert alert-info">
                            Lelang belum dimulai. Silakan kembali pada {{ $auction->start_time->format('d M Y, H:i') }}.
                        </div>
                    @else
                        <div class="alert alert-secondary">
                            Lelang telah berakhir.
                        </div>
                    @endif
                </div>
            </div>
            
            <!-- Bid History -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Riwayat Bid</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Pembeli</th>
                                    <th>Jumlah</th>
                                    <th>Waktu</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($auction->bids->sortByDesc('amount') as $bid)
                                    <tr>
                                        <td>{{ $bid->user->name }}</td>
                                        <td>Rp {{ number_format($bid->amount, 0, ',', '.') }}</td>
                                        <td>{{ $bid->created_at->format('d M Y, H:i') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center py-3">Belum ada bid</td>
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

@section('scripts')
<script>
    // Script untuk countdown timer
    document.addEventListener('DOMContentLoaded', function() {
        const timerElements = document.querySelectorAll('.auction-timer');
        
        timerElements.forEach(function(element) {
            const endTime = element.dataset.end;
            const startTime = element.dataset.start;
            
            if (endTime || startTime) {
                const targetTime = new Date(endTime || startTime);
                
                const updateTimer = function() {
                    const now = new Date();
                    const diff = targetTime - now;
                    
                    if (diff <= 0) {
                        element.textContent = 'Selesai';
                        if (endTime) {
                            window.location.reload();
                        }
                        return;
                    }
                    
                    const days = Math.floor(diff / (1000 * 60 * 60 * 24));
                    const hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
                    const seconds = Math.floor((diff % (1000 * 60)) / 1000);
                    
                    let timeString = '';
                    if (days > 0) timeString += `${days}h `;
                    timeString += `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
                    
                    element.textContent = timeString;
                };
                
                updateTimer();
                setInterval(updateTimer, 1000);
            }
        });
    });
</script>
@endsection 