@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1>Daftar Lelang</h1>
            <p class="text-muted">Temukan ikan segar berkualitas untuk Anda</p>
        </div>
        <div class="col-md-4">
            <div class="d-flex justify-content-md-end">
                <div class="btn-group">
                    <a href="{{ route('auctions', ['status' => 'active']) }}" class="btn btn-{{ $status == 'active' ? 'primary' : 'outline-primary' }}">Aktif</a>
                    <a href="{{ route('auctions', ['status' => 'upcoming']) }}" class="btn btn-{{ $status == 'upcoming' ? 'primary' : 'outline-primary' }}">Akan Datang</a>
                    <a href="{{ route('auctions', ['status' => 'ended']) }}" class="btn btn-{{ $status == 'ended' ? 'primary' : 'outline-primary' }}">Selesai</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <form action="{{ route('auctions') }}" method="GET" class="row g-3">
                <input type="hidden" name="status" value="{{ $status }}">
                
                <div class="col-md-4">
                    <label for="species" class="form-label">Jenis Ikan</label>
                    <select name="species" id="species" class="form-select">
                        <option value="">Semua Jenis</option>
                        <option value="Tuna" {{ request('species') == 'Tuna' ? 'selected' : '' }}>Tuna</option>
                        <option value="Salmon" {{ request('species') == 'Salmon' ? 'selected' : '' }}>Salmon</option>
                        <option value="Kerapu" {{ request('species') == 'Kerapu' ? 'selected' : '' }}>Kerapu</option>
                        <option value="Kakap" {{ request('species') == 'Kakap' ? 'selected' : '' }}>Kakap</option>
                        <option value="Tongkol" {{ request('species') == 'Tongkol' ? 'selected' : '' }}>Tongkol</option>
                    </select>
                </div>
                
                <div class="col-md-4">
                    <label for="sort" class="form-label">Urutkan</label>
                    <select name="sort" id="sort" class="form-select">
                        <option value="end_time" {{ request('sort') == 'end_time' ? 'selected' : '' }}>Waktu Berakhir</option>
                        <option value="start_time" {{ request('sort') == 'start_time' ? 'selected' : '' }}>Waktu Mulai</option>
                        <option value="current_price" {{ request('sort') == 'current_price' ? 'selected' : '' }}>Harga</option>
                    </select>
                </div>
                
                <div class="col-md-2">
                    <label for="direction" class="form-label">Arah</label>
                    <select name="direction" id="direction" class="form-select">
                        <option value="asc" {{ request('direction') == 'asc' ? 'selected' : '' }}>Naik</option>
                        <option value="desc" {{ request('direction') == 'desc' ? 'selected' : '' }}>Turun</option>
                    </select>
                </div>
                
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">Filter</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Auctions List -->
    <div class="row">
        @forelse($auctions as $auction)
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm auction-card">
                    <img src="{{ $auction->fish->image ? asset('storage/' . $auction->fish->image) : 'https://via.placeholder.com/300x200?text=No+Image' }}" 
                        alt="{{ $auction->fish->name }}" class="card-img-top fish-img">
                    <div class="card-body">
                        <h5 class="card-title">{{ $auction->fish->name }}</h5>
                        <p class="card-text text-muted">{{ Str::limit($auction->fish->description, 100) }}</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fw-bold text-primary">
                                @if($auction->status == 'upcoming')
                                    Mulai: Rp {{ number_format($auction->start_price, 0, ',', '.') }}
                                @else
                                    Rp {{ number_format($auction->current_price, 0, ',', '.') }}
                                @endif
                            </span>
                            @if($auction->status != 'upcoming')
                                <span class="badge bg-success">{{ $auction->bids->count() }} Bid</span>
                            @endif
                        </div>
                        <div class="mt-2">
                            <small class="text-muted">
                                @if($auction->status == 'upcoming')
                                    Dimulai: {{ $auction->start_time->format('d M Y, H:i') }}
                                @elseif($auction->status == 'active')
                                    Berakhir: {{ $auction->end_time->format('d M Y, H:i') }}
                                @else
                                    Selesai: {{ $auction->end_time->format('d M Y, H:i') }}
                                @endif
                            </small>
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
                    Tidak ada lelang {{ $status == 'active' ? 'aktif' : ($status == 'upcoming' ? 'yang akan datang' : 'yang sudah selesai') }} saat ini.
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-4">
        {{ $auctions->appends(request()->query())->links() }}
    </div>
</div>
@endsection 