<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Agung Citra Sukses Abadi</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-light" style="font-family: 'Poppins', sans-serif;">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ url('/') }}">Agung Citra Sukses Abadi</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/product">Produk</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/about">Tentang</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/contact">Kontak</a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user-circle me-1"></i>{{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item active" href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li><a class="dropdown-item" href="{{ route('order.history') }}">Riwayat Pesanan</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                    @csrf
                                    <button type="submit" class="dropdown-item">Logout</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container py-4">
        <!-- Simple Header -->
        <div class="mb-4">
            <h2 class="fw-bold text-dark mb-1">Dashboard</h2>
            <p class="text-muted mb-0">Selamat datang, {{ Auth::user()->name }}</p>
        </div>

        <div class="row g-4">
            <!-- Sidebar -->
            <div class="col-lg-3">
                <div class="card border shadow-sm">
                    <div class="card-body p-0">
                        <div class="list-group list-group-flush">
                            <a href="{{ route('dashboard') }}" class="list-group-item list-group-item-action py-3 active">
                                <i class="fas fa-tachometer-alt me-2"></i>
                                Dashboard
                            </a>
                            <a href="{{ route('order.history') }}" class="list-group-item list-group-item-action py-3">
                                <i class="fas fa-history me-2"></i>
                                Riwayat Pesanan
                            </a>
                            <a href="{{ url('/') }}" class="list-group-item list-group-item-action py-3">
                                <i class="fas fa-home me-2"></i>
                                Beranda
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-lg-9">
                <!-- Summary Cards -->
                <div class="row g-3 mb-4">
                    <div class="col-md-4">
                        <div class="card border shadow-sm h-100">
                            <div class="card-body p-4 text-center">
                                <i class="fas fa-shopping-bag fa-2x text-muted mb-3"></i>
                                <h4 class="fw-bold text-dark mb-1">{{ $transactions->total() }}</h4>
                                <p class="text-muted mb-0 small">Total Pesanan</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card border shadow-sm h-100">
                            <div class="card-body p-4 text-center">
                                <i class="fas fa-cog fa-2x text-primary mb-3"></i>
                                <h4 class="fw-bold text-dark mb-1">{{ $transactions->whereIn('status_pembayaran', ['menunggu_pembayaran', 'menunggu_verifikasi', 'dibayar', 'diproses'])->count() }}</h4>
                                <p class="text-muted mb-0 small">Sedang Diproses</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card border shadow-sm h-100">
                            <div class="card-body p-4 text-center">
                                <i class="fas fa-check-circle fa-2x text-success mb-3"></i>
                                <h4 class="fw-bold text-dark mb-1">{{ $transactions->where('status_pembayaran', 'selesai')->count() }}</h4>
                                <p class="text-muted mb-0 small">Pesanan Selesai</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Orders -->
                <div class="card border shadow-sm">
                    <div class="card-header bg-white border-bottom py-3">
                        <h6 class="fw-bold mb-0">Pesanan Terbaru</h6>
                    </div>
                    <div class="card-body p-0">
                        @if($transactions->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="border-0 py-3">Invoice</th>
                                            <th class="border-0 py-3">Produk</th>
                                            <th class="border-0 py-3">Total</th>
                                            <th class="border-0 py-3">Status</th>
                                            <th class="border-0 py-3">Tanggal</th>
                                            <th class="border-0 py-3">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($transactions as $transaction)
                                        <tr>
                                            <td class="py-3">
                                                <code class="bg-light px-2 py-1 rounded text-dark">{{ $transaction->invoice_number }}</code>
                                            </td>
                                            <td class="py-3">{{ $transaction->plakat->nama ?? 'N/A' }}</td>
                                            <td class="py-3 fw-semibold">Rp {{ number_format($transaction->total_harga, 0, ',', '.') }}</td>
                                            <td class="py-3">
                                                @switch($transaction->status_pembayaran)
                                                    @case('menunggu_pembayaran')
                                                        <span class="badge bg-warning text-dark">
                                                            <i class="fas fa-clock me-1"></i>Menunggu Pembayaran
                                                        </span>
                                                        @break
                                                    @case('menunggu_verifikasi')
                                                        <span class="badge bg-info text-dark">
                                                            <i class="fas fa-search me-1"></i>Menunggu Verifikasi
                                                        </span>
                                                        @break
                                                    @case('dibayar')
                                                        <span class="badge bg-success">
                                                            <i class="fas fa-check-circle me-1"></i>Dibayar
                                                        </span>
                                                        @break
                                                    @case('diproses')
                                                        <span class="badge bg-primary">
                                                            <i class="fas fa-cog me-1"></i>Di Proses
                                                        </span>
                                                        @break
                                                    @case('selesai')
                                                        <span class="badge bg-success">
                                                            <i class="fas fa-check-badge me-1"></i>Selesai
                                                        </span>
                                                        @break
                                                    @case('ditolak')
                                                        <span class="badge bg-danger">
                                                            <i class="fas fa-times-circle me-1"></i>Ditolak
                                                        </span>
                                                        @break
                                                    @default
                                                        <span class="badge bg-secondary">{{ ucfirst($transaction->status_pembayaran) }}</span>
                                                @endswitch
                                            </td>
                                            <td class="py-3 text-muted">{{ $transaction->created_at->format('d/m/Y') }}</td>
                                            <td class="py-3">
                                                <a href="{{ route('invoice.show', $transaction->id) }}" class="btn btn-outline-dark btn-sm">
                                                    Lihat Invoice
                                                </a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @if($transactions->hasPages())
                            <div class="p-3 border-top">
                                {{ $transactions->links() }}
                            </div>
                            @endif
                        @else
                            <div class="text-center py-5">
                                <i class="fas fa-shopping-bag fa-4x text-muted mb-3"></i>
                                <h6 class="fw-bold mb-2">Belum Ada Pesanan</h6>
                                <p class="text-muted mb-3">Anda belum memiliki riwayat pesanan.</p>
                                <a href="{{ url('/') }}" class="btn btn-dark">
                                    Mulai Berbelanja
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <style>
        .card {
            transition: all 0.2s ease;
        }
        .card:hover {
            transform: translateY(-1px);
        }
        .list-group-item {
            transition: all 0.2s ease;
        }
        .list-group-item:hover {
            background-color: #f8f9fa;
        }
        .list-group-item.active {
            background-color: #212529;
            border-color: #212529;
        }
        .btn {
            transition: all 0.2s ease;
        }
        .btn:hover {
            transform: translateY(-1px);
        }
        .table-hover tbody tr:hover {
            background-color: #f8f9fa;
        }
        .badge {
            font-weight: 500;
        }
    </style>
</body>
</html>