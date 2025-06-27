<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran Berhasil - Agung Citra Sukses Abadi</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    @if($transaction->status_pembayaran === 'menunggu_verifikasi')
    <meta http-equiv="refresh" content="30">
    @endif
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm sticky-top">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">Agung Citra Sukses Abadi</a>
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
                    @auth
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                                {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu">
                                @if(Auth::user()->isAdmin())
                                    <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">Admin Dashboard</a></li>
                                @else
                                    <li><a class="dropdown-item" href="{{ route('dashboard') }}">Dashboard</a></li>
                                    <li><a class="dropdown-item" href="{{ route('order.history') }}">Riwayat Pesanan</a></li>
                                @endif
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                        @csrf
                                        <button type="submit" class="dropdown-item">Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">Daftar</a>
                        </li>
                    @endauth
                </ul>
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
                                            <span id="payment-status">
                                                @switch($transaction->status_pembayaran)
                                                    @case('pending')
                                                        <span class="badge bg-warning">Pending</span>
                                                        @break
                                                    @case('menunggu_pembayaran')
                                                        <span class="badge bg-info">Menunggu Pembayaran</span>
                                                        @break
                                                    @case('menunggu_verifikasi')
                                                        <span class="badge bg-warning">
                                                            <i class="fas fa-spinner fa-spin me-1"></i>Menunggu Verifikasi
                                                        </span>
                                                        @break
                                                    @case('confirmed')
                                                        <span class="badge bg-success">
                                                            <i class="fas fa-check me-1"></i>Dikonfirmasi
                                                        </span>
                                                        @break
                                                @endswitch
                                            </span>
                                            @if($transaction->status_pembayaran === 'menunggu_verifikasi')
                                                <small class="text-muted d-block mt-1">
                                                    <i class="fas fa-clock me-1"></i>
                                                    <span id="refresh-timer">Memeriksa status dalam 10 detik...</span>
                                                </small>
                                            @endif
                                        </p>
                                        <p><strong>Tanggal:</strong> {{ $transaction->created_at->format('d/m/Y H:i') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="status-alert">
                            @if($transaction->status_pembayaran === 'menunggu_pembayaran')
                                <div class="alert alert-info">
                                    <h6><i class="fas fa-info-circle"></i> Langkah Selanjutnya:</h6>
                                    <p class="mb-0">Silakan lakukan pembayaran sesuai metode yang dipilih, kemudian upload bukti pembayaran untuk verifikasi.</p>
                                </div>
                            @elseif($transaction->status_pembayaran === 'menunggu_verifikasi')
                                <div class="alert alert-warning">
                                    <h6><i class="fas fa-clock"></i> Sedang Diverifikasi:</h6>
                                    <p class="mb-0">Bukti pembayaran Anda sedang diverifikasi. Kami akan menghubungi Anda dalam 1x24 jam.</p>
                                    <div class="mt-2">
                                        <small class="text-muted">
                                            <i class="fas fa-sync-alt fa-spin me-1"></i>
                                            Status akan diperbarui otomatis setiap 10 detik
                                        </small>
                                    </div>
                                </div>
                            @elseif($transaction->status_pembayaran === 'confirmed')
                                <div class="alert alert-success">
                                    <h6><i class="fas fa-check-circle"></i> Pembayaran Dikonfirmasi:</h6>
                                    <p class="mb-0">Pembayaran Anda telah dikonfirmasi. Pesanan sedang diproses dan akan segera dikirim.</p>
                                </div>
                            @elseif($transaction->status_pembayaran === 'pending')
                                <div class="alert alert-info">
                                    <h6><i class="fas fa-info-circle"></i> Cash on Delivery:</h6>
                                    <p class="mb-0">Pesanan Anda akan diproses. Pembayaran dilakukan saat barang diterima.</p>
                                </div>
                            @endif
                        </div>

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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    @if($transaction->status_pembayaran === 'menunggu_verifikasi')
    <script>
        let countdownTimer;
        let refreshInterval;
        let countdown = 10;
        
        function updateCountdown() {
            const timerElement = document.getElementById('refresh-timer');
            if (timerElement) {
                timerElement.textContent = `Memeriksa status dalam ${countdown} detik...`;
                countdown--;
                
                if (countdown < 0) {
                    countdown = 10;
                    checkPaymentStatus();
                }
            }
        }
        
        function checkPaymentStatus() {
            fetch(`/api/payment/status/{{ $transaction->id }}`)
                .then(response => response.json())
                .then(data => {
                    console.log('Status check:', data);
                    
                    // Jika status berubah dari menunggu_verifikasi, refresh halaman
                    if (data.status !== 'menunggu_verifikasi') {
                        // Tampilkan notifikasi bahwa status telah berubah
                        const alertDiv = document.createElement('div');
                        alertDiv.className = 'alert alert-success alert-dismissible fade show position-fixed';
                        alertDiv.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
                        alertDiv.innerHTML = `
                            <i class="fas fa-check-circle me-2"></i>
                            <strong>Status Diperbarui!</strong> Halaman akan dimuat ulang...
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        `;
                        document.body.appendChild(alertDiv);
                        
                        // Refresh halaman setelah 2 detik
                        setTimeout(() => {
                            window.location.reload();
                        }, 2000);
                        
                        // Hentikan timer
                        clearInterval(countdownTimer);
                        clearInterval(refreshInterval);
                    }
                })
                .catch(error => {
                    console.error('Error checking payment status:', error);
                });
        }
        
        // Mulai countdown dan auto-refresh
        document.addEventListener('DOMContentLoaded', function() {
            // Update countdown setiap detik
            countdownTimer = setInterval(updateCountdown, 1000);
            
            // Check status setiap 10 detik
            refreshInterval = setInterval(checkPaymentStatus, 10000);
            
            // Check status pertama kali setelah 10 detik
            setTimeout(checkPaymentStatus, 10000);
        });
        
        // Cleanup saat halaman ditutup
        window.addEventListener('beforeunload', function() {
            if (countdownTimer) clearInterval(countdownTimer);
            if (refreshInterval) clearInterval(refreshInterval);
        });
    </script>
    @endif
</body>
</html>