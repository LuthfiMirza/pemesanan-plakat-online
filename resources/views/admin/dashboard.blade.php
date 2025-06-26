<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Plakat Indonesia</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ url('/') }}">Plakat Indonesia - Admin</a>
            <div class="navbar-nav ms-auto">
                <span class="navbar-text me-3">Admin: {{ Auth::user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-outline-light btn-sm">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-md-2">
                <div class="card">
                    <div class="card-header">Menu Admin</div>
                    <div class="list-group list-group-flush">
                        <a href="{{ route('admin.dashboard') }}" class="list-group-item list-group-item-action active">
                            <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                        </a>
                        <a href="{{ route('admin.transactions') }}" class="list-group-item list-group-item-action">
                            <i class="fas fa-shopping-cart me-2"></i>Transaksi
                        </a>
                        <a href="{{ route('admin.sales.report') }}" class="list-group-item list-group-item-action">
                            <i class="fas fa-chart-bar me-2"></i>Laporan Penjualan
                        </a>
                        <a href="/admin" class="list-group-item list-group-item-action">
                            <i class="fas fa-cogs me-2"></i>Filament Admin
                        </a>
                        <a href="{{ url('/') }}" class="list-group-item list-group-item-action">
                            <i class="fas fa-home me-2"></i>Beranda
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-10">
                <!-- Statistics Cards -->
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="card bg-primary text-white">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h4>{{ $totalTransactions }}</h4>
                                        <p class="mb-0">Total Transaksi</p>
                                    </div>
                                    <div class="align-self-center">
                                        <i class="fas fa-shopping-cart fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-success text-white">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h4>Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h4>
                                        <p class="mb-0">Total Pendapatan</p>
                                    </div>
                                    <div class="align-self-center">
                                        <i class="fas fa-money-bill-wave fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-warning text-white">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h4>{{ $pendingTransactions }}</h4>
                                        <p class="mb-0">Transaksi Pending</p>
                                    </div>
                                    <div class="align-self-center">
                                        <i class="fas fa-clock fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-info text-white">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h4>{{ $totalUsers }}</h4>
                                        <p class="mb-0">Total User</p>
                                    </div>
                                    <div class="align-self-center">
                                        <i class="fas fa-users fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Transactions -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Transaksi Terbaru</h5>
                    </div>
                    <div class="card-body">
                        @if($recentTransactions->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Invoice</th>
                                            <th>Pelanggan</th>
                                            <th>Produk</th>
                                            <th>Total</th>
                                            <th>Metode Pembayaran</th>
                                            <th>Status</th>
                                            <th>Tanggal</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($recentTransactions as $transaction)
                                        <tr>
                                            <td>{{ $transaction->invoice_number }}</td>
                                            <td>{{ $transaction->nama_pembeli }}</td>
                                            <td>{{ $transaction->plakat->nama ?? 'N/A' }}</td>
                                            <td>Rp {{ number_format($transaction->total_harga, 0, ',', '.') }}</td>
                                            <td>
                                                @switch($transaction->metode_pembayaran)
                                                    @case('transfer_bank')
                                                        Transfer Bank
                                                        @break
                                                    @case('e_wallet')
                                                        E-Wallet
                                                        @break
                                                    @case('cod')
                                                        COD
                                                        @break
                                                @endswitch
                                            </td>
                                            <td>
                                                @switch($transaction->status_pembayaran)
                                                    @case('pending')
                                                        <span class="badge bg-warning">Pending</span>
                                                        @break
                                                    @case('menunggu_pembayaran')
                                                        <span class="badge bg-info">Menunggu Pembayaran</span>
                                                        @break
                                                    @case('menunggu_verifikasi')
                                                        <span class="badge bg-warning">Menunggu Verifikasi</span>
                                                        @break
                                                    @case('confirmed')
                                                        <span class="badge bg-success">Dikonfirmasi</span>
                                                        @break
                                                    @case('rejected')
                                                        <span class="badge bg-danger">Ditolak</span>
                                                        @break
                                                @endswitch
                                            </td>
                                            <td>{{ $transaction->created_at->format('d/m/Y H:i') }}</td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    @if($transaction->status_pembayaran === 'menunggu_verifikasi')
                                                        <form method="POST" action="{{ route('admin.transactions.status', $transaction->id) }}" class="d-inline">
                                                            @csrf
                                                            @method('PATCH')
                                                            <input type="hidden" name="status" value="confirmed">
                                                            <button type="submit" class="btn btn-sm btn-success">Konfirmasi</button>
                                                        </form>
                                                        <form method="POST" action="{{ route('admin.transactions.status', $transaction->id) }}" class="d-inline">
                                                            @csrf
                                                            @method('PATCH')
                                                            <input type="hidden" name="status" value="rejected">
                                                            <button type="submit" class="btn btn-sm btn-danger">Tolak</button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="text-center">
                                <a href="{{ route('admin.transactions') }}" class="btn btn-primary">Lihat Semua Transaksi</a>
                            </div>
                        @else
                            <p class="text-muted">Belum ada transaksi.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>