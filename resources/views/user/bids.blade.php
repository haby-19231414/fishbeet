@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1>Bid Saya</h1>
            <p class="text-muted">Daftar semua bid yang telah Anda pasang</p>
        </div>
        <div class="col-md-4 text-md-end">
            <a href="{{ route('auctions') }}" class="btn btn-primary">
                <i class="fas fa-search me-1"></i> Cari Lelang
            </a>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Ikan</th>
                            <th>Jumlah Bid</th>
                            <th>Waktu Bid</th>
                            <th>Status Lelang</th>
                            <th>Status Bid</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bids as $bid)
                            <tr>
                                <td>
                                    <a href="{{ route('auctions.show', $bid->auction) }}">
                                        {{ $bid->auction->fish->name }}
                                    </a>
                                </td>
                                <td>Rp {{ number_format($bid->amount, 0, ',', '.') }}</td>
                                <td>{{ $bid->created_at->format('d M Y, H:i') }}</td>
                                <td>
                                    @if($bid->auction->status == 'upcoming')
                                        <span class="badge bg-info">Akan Datang</span>
                                    @elseif($bid->auction->status == 'active')
                                        <span class="badge bg-success">Aktif</span>
                                    @elseif($bid->auction->status == 'ended')
                                        <span class="badge bg-secondary">Selesai</span>
                                    @else
                                        <span class="badge bg-danger">Dibatalkan</span>
                                    @endif
                                </td>
                                <td>
                                    @if($bid->auction->status == 'active')
                                        @if($bid->auction->current_price == $bid->amount)
                                            <span class="badge bg-success">Tertinggi</span>
                                        @else
                                            <span class="badge bg-warning">Tersaingi</span>
                                        @endif
                                    @elseif($bid->auction->status == 'ended')
                                        @if($bid->auction->winner_id == Auth::id() && $bid->auction->current_price == $bid->amount)
                                            <span class="badge bg-success">Menang</span>
                                        @else
                                            <span class="badge bg-secondary">Kalah</span>
                                        @endif
                                    @else
                                        <span class="badge bg-secondary">-</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('auctions.show', $bid->auction) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye"></i> Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    <div class="my-3">
                                        <i class="fas fa-hand-paper fa-3x text-muted mb-3"></i>
                                        <p class="mb-1">Anda belum memasang bid pada lelang apapun.</p>
                                        <a href="{{ route('auctions') }}" class="btn btn-primary mt-2">Cari Lelang Sekarang</a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-4">
        {{ $bids->links() }}
    </div>
</div>
@endsection 