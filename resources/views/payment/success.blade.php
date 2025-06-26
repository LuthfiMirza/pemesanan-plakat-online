<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran Berhasil - Plakat Indonesia</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">Plakat Indonesia</a>
            <div class="navbar-nav ms-auto">
                @auth
                    <span class="navbar-text me-3">Halo, {{ Auth::user()->name }}</span>
                    <a href="{{ route('dashboard') }}" class="btn btn-outline-light btn-sm me-2">Dashboard</a>
                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-outline-light btn-sm">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline-light btn-sm me-2">Login</a>
                    <a href="{{ route('register') }}" class="btn btn-outline-light btn-sm">Daftar</a>
                @endauth
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <div class="card">
                    <div class="card-body text-center">
                        <div class="mb-4">
                            <i class="fas fa-check-circle text-success" style="font-size: 4rem;"></i>
                        </div>
                        
                        <h2 class="text-success mb-3">Pesanan Berhasil!</h2>
                        <p class="lead">Terima kasih atas pesanan Anda</p>
                        
                        <div class="card bg-light mb-4">
                            <div class="card-body">
                                <h5>Detail Pesanan</h5>
                                <div class="row text-start">
                                    <div class="col-md-6">
                                        <p><strong>Invoice:</strong> {{ $transaction->invoice_number }}</p>
                                        <p><strong>Produk:</strong> {{ $transaction->plakat->nama ?? 'N/A' }}</p>
                                        <p><strong>Total:</strong> Rp {{ number_format($transaction->total_harga, 0, ',', '.') }}</p>
                                    </div>
                                    <div class="col-md-6">
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
                                            @endswitch
                                        </p>
                                        <p><strong>Tanggal:</strong> {{ $transaction->created_at->format('d/m/Y H:i') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if($transaction->status_pembayaran === 'menunggu_pembayaran')
                            <div class="alert alert-info">
                                <h6><i class="fas fa-info-circle"></i> Langkah Selanjutnya:</h6>
                                <p class="mb-0">Silakan lakukan pembayaran sesuai metode yang dipilih, kemudian upload bukti pembayaran untuk verifikasi.</p>
                            </div>
                        @elseif($transaction->status_pembayaran === 'menunggu_verifikasi')
                            <div class="alert alert-warning">
                                <h6><i class="fas fa-clock"></i> Sedang Diverifikasi:</h6>
                                <p class="mb-0">Bukti pembayaran Anda sedang diverifikasi. Kami akan menghubungi Anda dalam 1x24 jam.</p>
                            </div>
                        @elseif($transaction->status_pembayaran === 'pending')
                            <div class="alert alert-info">
                                <h6><i class="fas fa-info-circle"></i> Cash on Delivery:</h6>
                                <p class="mb-0">Pesanan Anda akan diproses. Pembayaran dilakukan saat barang diterima.</p>
                            </div>
                        @endif

                        <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                            @auth
                                <a href="{{ route('invoice.show', $transaction->id) }}" class="btn btn-primary">Lihat Invoice</a>
                                <a href="{{ route('dashboard') }}" class="btn btn-outline-primary">Dashboard</a>
                            @else
                                <a href="{{ route('login') }}" class="btn btn-primary">Login untuk Melihat Status</a>
                            @endauth
                            <a href="{{ url('/') }}" class="btn btn-secondary">Kembali ke Beranda</a>
                        </div>

                        @if($transaction->status_pembayaran === 'menunggu_pembayaran')
                            <div class="mt-3">
                                <a href="{{ route('payment.upload', $transaction->id) }}" class="btn btn-warning btn-lg">Upload Bukti Pembayaran</a>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Contact Information -->
                <div class="card mt-4">
                    <div class="card-body text-center">
                        <h6>Butuh Bantuan?</h6>
                        <p class="mb-0">Hubungi kami di:</p>
                        <p>
                            <i class="fas fa-phone"></i> (021) 123-4567 | 
                            <i class="fas fa-envelope"></i> info@plakatindonesia.com |
                            <i class="fab fa-whatsapp"></i> 081234567890
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>