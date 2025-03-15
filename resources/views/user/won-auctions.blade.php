@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1>Lelang Dimenangkan</h1>
            <p class="text-muted">Daftar lelang yang berhasil Anda menangkan</p>
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
                            <th>Penjual</th>
                            <th>Harga Final</th>
                            <th>Tanggal Menang</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($auctions as $auction)
                            <tr>
                                <td>
                                    <a href="{{ route('auctions.show', $auction) }}">
                                        {{ $auction->fish->name }}
                                    </a>
                                </td>
                                <td>{{ $auction->user->name }}</td>
                                <td>Rp {{ number_format($auction->current_price, 0, ',', '.') }}</td>
                                <td>{{ $auction->end_time->format('d M Y, H:i') }}</td>
                                <td>
                                    <a href="{{ route('auctions.show', $auction) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye"></i> Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4">
                                    <div class="my-3">
                                        <i class="fas fa-trophy fa-3x text-muted mb-3"></i>
                                        <p class="mb-1">Anda belum memenangkan lelang apapun.</p>
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
        {{ $auctions->links() }}
    </div>
</div>
@endsection 