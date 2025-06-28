<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pesanan - Agung Citra Sukses Abadi</title>
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
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li><a class="dropdown-item active" href="{{ route('order.history') }}">Riwayat Pesanan</a></li>
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
            <h2 class="fw-bold text-dark mb-1">Riwayat Pesanan</h2>
            <p class="text-muted mb-0">Kelola dan pantau semua pesanan Anda</p>
        </div>

        <div class="row g-4">
            <!-- Sidebar -->
            <div class="col-lg-3">
                <div class="card border shadow-sm">
                    <div class="card-body p-0">
                        <div class="list-group list-group-flush">
                            <a href="{{ route('dashboard') }}" class="list-group-item list-group-item-action py-3">
                                <i class="fas fa-tachometer-alt me-2"></i>
                                Dashboard
                            </a>
                            <a href="{{ route('order.history') }}" class="list-group-item list-group-item-action py-3 active">
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
                <div class="card border shadow-sm">
                    <div class="card-header bg-white border-bottom py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="fw-bold mb-0">Daftar Pesanan</h6>
                            <span class="badge bg-dark">{{ $transactions->total() }} Pesanan</span>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        @if($transactions->count() > 0)
                            <!-- Mobile Card Layout -->
                            <div class="d-lg-none">
                                @foreach($transactions as $transaction)
                                <div class="border-bottom p-3">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <div>
                                            <code class="bg-light px-2 py-1 rounded text-dark small">{{ $transaction->invoice_number }}</code>
                                            <div class="small text-muted mt-1">{{ $transaction->created_at->format('d/m/Y H:i') }}</div>
                                        </div>
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
                                    </div>
                                    
                                    <div class="mb-2">
                                        <div class="fw-semibold">{{ $transaction->plakat->nama ?? 'N/A' }}</div>
                                        <div class="fw-bold">Rp {{ number_format($transaction->total_harga, 0, ',', '.') }}</div>
                                    </div>
                                    
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('invoice.show', $transaction->id) }}" class="btn btn-outline-dark btn-sm">
                                            Invoice
                                        </a>
                                        @if($transaction->status_pembayaran === 'menunggu_pembayaran')
                                            <a href="{{ route('payment.upload', $transaction->id) }}" class="btn btn-dark btn-sm">
                                                Upload Bukti
                                            </a>
                                        @endif
                                    </div>
                                </div>
                                @endforeach
                            </div>

                            <!-- Desktop Table Layout -->
                            <div class="d-none d-lg-block">
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th class="border-0 py-3">Invoice</th>
                                                <th class="border-0 py-3">Produk</th>
                                                <th class="border-0 py-3">Total</th>
                                                <th class="border-0 py-3">Pembayaran</th>
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
                                                    @switch($transaction->metode_pembayaran)
                                                        @case('transfer_bank')
                                                            Transfer Bank ({{ $transaction->bank }})
                                                            @break
                                                        @case('e_wallet')
                                                            E-Wallet ({{ $transaction->ewallet }})
                                                            @break
                                                        @case('cod')
                                                            Cash on Delivery
                                                            @break
                                                    @endswitch
                                                </td>
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
                                                    <div class="d-flex gap-2">
                                                        <a href="{{ route('invoice.show', $transaction->id) }}" class="btn btn-outline-dark btn-sm">
                                                            Invoice
                                                        </a>
                                                        @if($transaction->status_pembayaran === 'menunggu_pembayaran')
                                                            <a href="{{ route('payment.upload', $transaction->id) }}" class="btn btn-dark btn-sm">
                                                                Upload
                                                            </a>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
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
        .btn {
            transition: all 0.2s ease;
        }
        .btn:hover {
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
        .table-hover tbody tr:hover {
            background-color: #f8f9fa;
        }
        .badge {
            font-weight: 500;
        }
        code {
            font-weight: 600;
        }
    </style>
</body>
</html>