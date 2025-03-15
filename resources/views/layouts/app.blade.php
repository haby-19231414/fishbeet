<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FishBid - Pelelangan Ikan Online</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Custom CSS -->
    <style>
        :root {
            --primary-color: #0d6efd;
            --secondary-color: #0dcaf0;
            --dark-color: #0a2351;
        }
        
        body {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            background-color: #f8f9fa;
        }
        
        .navbar-brand {
            font-weight: bold;
            font-size: 1.5rem;
        }
        
        .navbar-brand i {
            color: var(--secondary-color);
        }
        
        .navbar {
            background-color: var(--dark-color) !important;
        }
        
        .footer {
            background-color: var(--dark-color);
            color: white;
            margin-top: auto;
            padding: 1.5rem 0;
        }
        
        .card {
            border-radius: 0.5rem;
            overflow: hidden;
            transition: transform 0.3s;
        }
        
        .card:hover {
            transform: translateY(-5px);
        }
        
        .btn-primary {
            background-color: var(--primary-color);
        }
        
        .auction-card .fish-img {
            height: 200px;
            object-fit: cover;
        }
        
        .auction-timer {
            font-weight: bold;
            color: var(--primary-color);
        }
    </style>
    @yield('styles')
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary sticky-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <i class="fas fa-fish me-2"></i>FishBid
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('auctions*') ? 'active' : '' }}" href="{{ route('auctions') }}">Lelang</a>
                    </li>
                </ul>
                
                <ul class="navbar-nav">
                    @guest
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('login') ? 'active' : '' }}" href="{{ route('login') }}">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('register') ? 'active' : '' }}" href="{{ route('register') }}">Daftar</a>
                        </li>
                    @else
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-user-circle me-1"></i> {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                @if(Auth::user()->isAdmin())
                                    <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">Dashboard Admin</a></li>
                                @elseif(Auth::user()->isPedagang())
                                    <li><a class="dropdown-item" href="{{ route('pedagang.dashboard') }}">Dashboard Pedagang</a></li>
                                @else
                                    <li><a class="dropdown-item" href="{{ route('user.dashboard') }}">Dashboard</a></li>
                                    <li><a class="dropdown-item" href="{{ route('user.bids') }}">Bid Saya</a></li>
                                    <li><a class="dropdown-item" href="{{ route('user.won-auctions') }}">Lelang Dimenangkan</a></li>
                                @endif
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item">Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <!-- Flash Messages -->
    @if(session('success'))
        <div class="container mt-3">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="container mt-3">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    @endif

    <!-- Main Content -->
    <main class="flex-grow-1">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4 mb-md-0">
                    <h5 class="mb-3">FishBid</h5>
                    <p>Platform pelelangan ikan online terpercaya di Indonesia. Temukan ikan segar berkualitas atau jual hasil tangkapan Anda dengan mudah.</p>
                </div>
                <div class="col-md-4 mb-4 mb-md-0">
                    <h5 class="mb-3">Link Cepat</h5>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('home') }}" class="text-white">Beranda</a></li>
                        <li><a href="{{ route('auctions') }}" class="text-white">Lelang</a></li>
                        <li><a href="{{ route('register') }}" class="text-white">Daftar</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h5 class="mb-3">Kontak</h5>
                    <ul class="list-unstyled">
                        <li><i class="fas fa-map-marker-alt me-2"></i> Jl. Laut Biru No. 123, Jakarta</li>
                        <li><i class="fas fa-phone me-2"></i> (021) 1234-5678</li>
                        <li><i class="fas fa-envelope me-2"></i> info@fishbid.com</li>
                    </ul>
                </div>
            </div>
            <hr class="mt-4 mb-4 bg-light">
            <div class="text-center">
                <p class="mb-0">&copy; {{ date('Y') }} FishBid. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html> 