@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1>Dashboard Admin</h1>
            <p class="text-muted">Kelola seluruh data pelelangan ikan</p>
        </div>
        <div class="col-md-4 text-md-end">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-primary">
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
                            <h6 class="text-muted mb-1">Total User</h6>
                            <h2 class="mb-0">{{ $stats['total_users'] }}</h2>
                        </div>
                        <div class="rounded-circle bg-primary bg-opacity-10 p-3">
                            <i class="fas fa-users fa-2x text-primary"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <span class="badge bg-info">{{ $stats['total_pedagang'] }} Pedagang</span>
                        <span class="badge bg-secondary">{{ $stats['total_users'] - $stats['total_pedagang'] - 1 }} Pembeli</span>
                        <span class="badge bg-danger">1 Admin</span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 mb-4 mb-md-0">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Total Ikan</h6>
                            <h2 class="mb-0">{{ $stats['total_fish'] }}</h2>
                        </div>
                        <div class="rounded-circle bg-success bg-opacity-10 p-3">
                            <i class="fas fa-fish fa-2x text-success"></i>
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
                            <h6 class="text-muted mb-1">Total Lelang</h6>
                            <h2 class="mb-0">{{ $stats['active_auctions'] + $stats['completed_auctions'] }}</h2>
                        </div>
                        <div class="rounded-circle bg-warning bg-opacity-10 p-3">
                            <i class="fas fa-gavel fa-2x text-warning"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <span class="badge bg-success">{{ $stats['active_auctions'] }} Aktif</span>
                        <span class="badge bg-secondary">{{ $stats['completed_auctions'] }} Selesai</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Latest Auctions -->
        <div class="col-md-6 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Lelang Terbaru</h5>
                    <a href="{{ route('auctions') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Ikan</th>
                                    <th>Penjual</th>
                                    <th>Harga</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($latestAuctions as $auction)
                                    <tr>
                                        <td>
                                            <a href="{{ route('auctions.show', $auction) }}">
                                                {{ $auction->fish->name }}
                                            </a>
                                        </td>
                                        <td>{{ $auction->user->name }}</td>
                                        <td>Rp {{ number_format($auction->current_price, 0, ',', '.') }}</td>
                                        <td>
                                            @if($auction->status == 'upcoming')
                                                <span class="badge bg-info">Akan Datang</span>
                                            @elseif($auction->status == 'active')
                                                <span class="badge bg-success">Aktif</span>
                                            @elseif($auction->status == 'ended')
                                                <span class="badge bg-secondary">Selesai</span>
                                            @else
                                                <span class="badge bg-danger">Dibatalkan</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-3">Belum ada lelang</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Latest Users -->
        <div class="col-md-6 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">User Terbaru</h5>
                    <a href="#" class="btn btn-sm btn-outline-primary">Kelola User</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Terdaftar</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($latestUsers as $user)
                                    <tr>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            @if($user->isAdmin())
                                                <span class="badge bg-danger">Admin</span>
                                            @elseif($user->isPedagang())
                                                <span class="badge bg-info">Pedagang</span>
                                            @else
                                                <span class="badge bg-secondary">User</span>
                                            @endif
                                        </td>
                                        <td>{{ $user->created_at->format('d M Y') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-3">Belum ada user</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Quick Actions -->
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Aksi Cepat</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-3 mb-md-0">
                            <a href="#" class="btn btn-outline-primary w-100 py-3">
                                <i class="fas fa-user-plus mb-2 d-block fa-2x"></i>
                                Tambah User
                            </a>
                        </div>
                        <div class="col-md-3 mb-3 mb-md-0">
                            <a href="#" class="btn btn-outline-success w-100 py-3">
                                <i class="fas fa-fish mb-2 d-block fa-2x"></i>
                                Tambah Ikan
                            </a>
                        </div>
                        <div class="col-md-3 mb-3 mb-md-0">
                            <a href="#" class="btn btn-outline-warning w-100 py-3">
                                <i class="fas fa-gavel mb-2 d-block fa-2x"></i>
                                Buat Lelang
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="#" class="btn btn-outline-info w-100 py-3">
                                <i class="fas fa-chart-line mb-2 d-block fa-2x"></i>
                                Lihat Laporan
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 