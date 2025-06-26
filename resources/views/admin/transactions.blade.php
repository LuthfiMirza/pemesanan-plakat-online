<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Transaksi - Admin Plakat Indonesia</title>
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
                        <a href="{{ route('admin.dashboard') }}" class="list-group-item list-group-item-action">
                            <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                        </a>
                        <a href="{{ route('admin.transactions') }}" class="list-group-item list-group-item-action active">
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
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Kelola Transaksi</h5>
                    </div>
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if($transactions->count() > 0)
                            <div class="table-responsive"<table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Invoice</th>
                                            <th>Pelanggan</th>
                                            <th>Produk & Detail</th>
                                            <th>Qty</th>
                                            <th>Harga Satuan</th>
                                            <th>Total</th>
                                            <th>Metode Pembayaran</th>
                                            <th>Status</th>
                                            <th>Tanggal</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($transactions as $transaction)
                                        <tr>
                                            <td>
                                                <strong>{{ $transaction->invoice_number }}</strong>
                                            </td>
                                            <td>
                                                <div>
                                                    <strong>{{ $transaction->nama_pembeli }}</strong>
                                                    <br><small class="text-muted">{{ $transaction->email }}</small>
                                                    <br><small class="text-muted"><i class="fas fa-phone"></i> {{ $transaction->no_telepon }}</small>
                                                </div>
                                            </td>
                                            <td>
                                                <div>
                                                    <strong>{{ $transaction->plakat->nama ?? 'N/A' }}</strong>
                                                    @if($transaction->catatan_design)
                                                        <br><small class="text-info"><i class="fas fa-comment"></i> Ada catatan design</small>
                                                    @endif
                                                    @if($transaction->design_file)
                                                        <br><small class="text-success"><i class="fas fa-file-image"></i> File design tersedia</small>
                                                    @endif
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge bg-primary">{{ $transaction->quantity ?? 1 }}</span>
                                            </td>
                                            <td>
                                                <small>Rp {{ number_format($transaction->unit_price ?? $transaction->total_harga, 0, ',', '.') }}</small>
                                            </td>
                                            <td>
                                                <strong>Rp {{ number_format($transaction->total_harga, 0, ',', '.') }}</strong>
                                            </td>
                                            <td>
                                                <div>
                                                    @switch($transaction->metode_pembayaran)
                                                        @case('transfer_bank')
                                                            <span class="badge bg-info">Transfer Bank</span>
                                                            @if($transaction->bank)
                                                                <br><small>{{ $transaction->bank }}</small>
                                                            @endif
                                                            @break
                                                        @case('e_wallet')
                                                            <span class="badge bg-success">E-Wallet</span>
                                                            @if($transaction->ewallet)
                                                                <br><small>{{ $transaction->ewallet }}</small>
                                                            @endif
                                                            @break
                                                        @case('cod')
                                                            <span class="badge bg-warning">COD</span>
                                                            @break
                                                    @endswitch
                                                </div>
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
                                                    <!-- View Details Button -->
                                                    <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#detailModal{{ $transaction->id }}">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                    
                                                    <!-- Status Update Buttons -->
                                                    @if($transaction->status_pembayaran === 'menunggu_verifikasi')
                                                        <form method="POST" action="{{ route('admin.transactions.status', $transaction->id) }}" class="d-inline">
                                                            @csrf
                                                            @method('PATCH')
                                                            <input type="hidden" name="status" value="confirmed">
                                                            <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Konfirmasi pembayaran ini?')">
                                                                <i class="fas fa-check"></i>
                                                            </button>
                                                        </form>
                                                        <form method="POST" action="{{ route('admin.transactions.status', $transaction->id) }}" class="d-inline">
                                                            @csrf
                                                            @method('PATCH')
                                                            <input type="hidden" name="status" value="rejected">
                                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Tolak pembayaran ini?')">
                                                                <i class="fas fa-times"></i>
                                                            </button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- Detail Modal -->
                                        <div class="modal fade" id="detailModal{{ $transaction->id }}" tabindex="-1">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Detail Transaksi - {{ $transaction->invoice_number }}</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <h6>Informasi Pelanggan:</h6>
                                                                <p><strong>Nama:</strong> {{ $transaction->nama_pembeli }}</p>
                                                                <p><strong>Email:</strong> {{ $transaction->email }}</p>
                                                                <p><strong>Telepon:</strong> {{ $transaction->no_telepon }}</p>
                                                                <p><strong>Alamat:</strong> {{ $transaction->alamat }}</p>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <h6>Informasi Pesanan:</h6>
                                                                <p><strong>Produk:</strong> {{ $transaction->plakat->nama ?? 'N/A' }}</p>
                                                                <p><strong>Total:</strong> Rp {{ number_format($transaction->total_harga, 0, ',', '.') }}</p>
                                                                <p><strong>Metode Pembayaran:</strong> 
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
                                                                </p>
                                                                <p><strong>Status:</strong> 
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
                                                                </p>
                                                            </div>
                                                        </div>
                                                        
                                                        @if($transaction->catatan_design)
                                                        <div class="mt-3">
                                                            <h6>Catatan Design:</h6>
                                                            <p>{{ $transaction->catatan_design }}</p>
                                                        </div>
                                                        @endif

                                                        @if($transaction->design_file)
                                                        <div class="mt-3">
                                                            <h6>File Design:</h6>
                                                            <a href="{{ $transaction->design_file_url }}" target="_blank" class="btn btn-outline-primary btn-sm">Lihat File Design</a>
                                                        </div>
                                                        @endif

                                                        @if($transaction->bukti_pembayaran)
                                                        <div class="mt-3">
                                                            <h6>Bukti Pembayaran:</h6>
                                                            <a href="{{ $transaction->bukti_pembayaran_url }}" target="_blank" class="btn btn-outline-success btn-sm">Lihat Bukti Pembayaran</a>
                                                        </div>
                                                        @endif
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            {{ $transactions->links() }}
                        @else
                            <div class="text-center">
                                <p class="text-muted">Belum ada transaksi.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>