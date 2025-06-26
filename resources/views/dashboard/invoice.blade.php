<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice {{ $transaction->invoice_number }} - Agung Citra Sukses Abadi</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { font-family: 'Poppins', sans-serif; }
        @media print {
            .no-print { display: none !important; }
            body { font-size: 12px; }
            .card { border: none !important; box-shadow: none !important; }
        }
    </style>
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm sticky-top no-print">
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
                            <li><a class="dropdown-item" href="{{ route('dashboard') }}">Dashboard</a></li>
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
        <!-- Action Buttons -->
        <div class="row no-print mb-4">
            <div class="col-12">
                <div class="d-flex gap-2">
                    <a href="{{ route('order.history') }}" class="btn btn-outline-dark">
                        <i class="fas fa-arrow-left me-1"></i>Kembali
                    </a>
                    <button onclick="window.print()" class="btn btn-dark">
                        <i class="fas fa-print me-1"></i>Cetak Invoice
                    </button>
                </div>
            </div>
        </div>

        <!-- Invoice Card -->
        <div class="card border shadow-sm">
            <div class="card-body p-5">
                <!-- Header Invoice -->
                <div class="row mb-5">
                    <div class="col-md-6">
                        <h2 class="fw-bold text-dark mb-3">AGUNG CITRA SUKSES ABADI</h2>
                        <div class="text-muted">
                            <p class="mb-1">Jl. Contoh No. 123</p>
                            <p class="mb-1">Jakarta, Indonesia</p>
                            <p class="mb-1">Telp: (021) 123-4567</p>
                            <p class="mb-0">Email: yuda99354@gmail.com</p>
                        </div>
                    </div>
                    <div class="col-md-6 text-end">
                        <h3 class="fw-bold text-dark mb-3">INVOICE</h3>
                        <div class="text-muted">
                            <p class="mb-1"><strong>No. Invoice:</strong> <code class="bg-light px-2 py-1 rounded text-dark">{{ $transaction->invoice_number }}</code></p>
                            <p class="mb-1"><strong>Tanggal:</strong> {{ $transaction->created_at->format('d/m/Y') }}</p>
                            <p class="mb-1"><strong>Status:</strong> 
                                @switch($transaction->status_pembayaran)
                                    @case('pending')
                                        <span class="badge bg-secondary">Pending</span>
                                        @break
                                    @case('menunggu_pembayaran')
                                        <span class="badge bg-secondary">Menunggu Pembayaran</span>
                                        @break
                                    @case('menunggu_verifikasi')
                                        <span class="badge bg-secondary">Menunggu Verifikasi</span>
                                        @break
                                    @case('confirmed')
                                        <span class="badge bg-dark">Dikonfirmasi</span>
                                        @break
                                    @case('rejected')
                                        <span class="badge bg-secondary">Ditolak</span>
                                        @break
                                @endswitch
                            </p>
                        </div>
                    </div>
                </div>

                <hr class="my-4">

                <!-- Detail Pelanggan -->
                <div class="row mb-5">
                    <div class="col-md-6">
                        <h6 class="fw-bold text-dark mb-3">Detail Pelanggan</h6>
                        <div class="text-muted">
                            <p class="mb-2"><strong>Nama:</strong> {{ $transaction->nama_pembeli }}</p>
                            <p class="mb-2"><strong>Email:</strong> {{ $transaction->email }}</p>
                            <p class="mb-2"><strong>Telepon:</strong> {{ $transaction->no_telepon }}</p>
                            <p class="mb-0"><strong>Alamat:</strong> {{ $transaction->alamat }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h6 class="fw-bold text-dark mb-3">Detail Pembayaran</h6>
                        <div class="text-muted">
                            <p class="mb-0"><strong>Metode:</strong> 
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
                        </div>
                    </div>
                </div>

                <!-- Detail Produk -->
                <div class="mb-5">
                    <h6 class="fw-bold text-dark mb-3">Detail Produk</h6>
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th class="border-0" style="width: 20%;">Produk</th>
                                <th class="border-0" style="width: 40%;">Deskripsi</th>
                                <th class="border-0" style="width: 10%;">Qty</th>
                                <th class="border-0 text-end" style="width: 15%;">Harga</th>
                                <th class="border-0 text-end" style="width: 15%;">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="fw-semibold">{{ $transaction->plakat->nama ?? 'Plakat Custom' }}</td>
                                <td>
                                    <div>
                                        @if($transaction->plakat)
                                            {{ $transaction->plakat->deskripsi ?? 'Plakat custom sesuai pesanan' }}
                                        @else
                                            Plakat custom sesuai pesanan
                                        @endif
                                    </div>
                                    @if($transaction->catatan_design)
                                        <small class="text-muted d-block mt-1">Catatan: {{ $transaction->catatan_design }}</small>
                                    @endif
                                </td>
                                <td>{{ $transaction->quantity ?? 1 }}</td>
                                <td class="text-end">Rp {{ number_format($transaction->unit_price ?? $transaction->total_harga, 0, ',', '.') }}</td>
                                <td class="text-end fw-semibold">Rp {{ number_format($transaction->total_harga, 0, ',', '.') }}</td>
                            </tr>
                        </tbody>
                    </table>
                    
                    <!-- Total Section -->
                    <div class="border-top pt-3">
                        <div class="row">
                            <div class="col-md-8"></div>
                            <div class="col-md-4">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="fw-bold text-dark mb-0">Total Pembayaran:</h6>
                                    <h5 class="fw-bold text-dark mb-0">Rp {{ number_format($transaction->total_harga, 0, ',', '.') }}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- File Attachments -->
                @if($transaction->design_file || $transaction->bukti_pembayaran)
                <div class="mb-5">
                    <h6 class="fw-bold text-dark mb-3">File Lampiran</h6>
                    <div class="row g-3">
                        @if($transaction->design_file)
                        <div class="col-md-6">
                            <div class="border rounded p-3">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-file-image fa-2x text-muted me-3"></i>
                                    <div>
                                        <h6 class="mb-1">File Design</h6>
                                        <a href="{{ $transaction->design_file_url }}" target="_blank" class="btn btn-outline-dark btn-sm">
                                            <i class="fas fa-eye me-1"></i>Lihat File
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif

                        @if($transaction->bukti_pembayaran)
                        <div class="col-md-6">
                            <div class="border rounded p-3">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-receipt fa-2x text-muted me-3"></i>
                                    <div>
                                        <h6 class="mb-1">Bukti Pembayaran</h6>
                                        <a href="{{ $transaction->bukti_pembayaran_url }}" target="_blank" class="btn btn-outline-dark btn-sm">
                                            <i class="fas fa-eye me-1"></i>Lihat Bukti
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                @endif

                <!-- Footer -->
                <div class="text-center mt-5 pt-4 border-top">
                    <div class="text-muted">
                        <p class="mb-2">Terima kasih atas kepercayaan Anda kepada <strong>Agung Citra Sukses Abadi</strong></p>
                        <p class="mb-0">Untuk pertanyaan, hubungi kami di <strong>yuda99354@gmail.com</strong> atau <strong>(021) 123-4567</strong></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <style>
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
        code {
            font-weight: 600;
        }
        @media print {
            .btn:hover {
                transform: none;
            }
        }
    </style>
</body>
</html>