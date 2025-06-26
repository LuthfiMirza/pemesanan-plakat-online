<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Bukti Pembayaran - Agung Citra Sukses Abadi</title>
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

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card shadow-lg border-0 rounded-4">
                    <div class="card-header bg-gradient text-white py-4" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-upload fa-2x me-3"></i>
                                <div>
                                    <h3 class="mb-1 fw-bold">Upload Bukti Pembayaran</h3>
                                    <p class="mb-0 opacity-75">Konfirmasi pembayaran Anda</p>
                                </div>
                            </div>
                            <div class="text-end">
                                <div class="badge bg-light text-dark px-3 py-2 rounded-pill">
                                    <i class="fas fa-receipt me-1"></i>
                                    {{ $transaction->invoice_number }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-5">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <!-- Order Summary -->
                        <div class="mb-5">
                            <h5 class="fw-bold mb-4 d-flex align-items-center">
                                <i class="fas fa-shopping-bag me-2" style="color: #FF5733;"></i>
                                Detail Pesanan
                            </h5>
                            <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
                                <div class="card-body p-4">
                                    <div class="row g-4">
                                        <div class="col-md-6">
                                            <div class="d-flex align-items-center mb-3">
                                                <i class="fas fa-box text-muted me-2"></i>
                                                <div>
                                                    <small class="text-muted d-block">Produk</small>
                                                    <strong>{{ $transaction->plakat->nama ?? 'N/A' }}</strong>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-money-bill-wave text-muted me-2"></i>
                                                <div>
                                                    <small class="text-muted d-block">Total Pembayaran</small>
                                                    <h5 class="fw-bold mb-0" style="color: #FF5733;">Rp {{ number_format($transaction->total_harga, 0, ',', '.') }}</h5>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="d-flex align-items-center mb-3">
                                                <i class="fas fa-credit-card text-muted me-2"></i>
                                                <div>
                                                    <small class="text-muted d-block">Metode Pembayaran</small>
                                                    <strong>
                                                        @switch($transaction->metode_pembayaran)
                                                            @case('transfer_bank')
                                                                Transfer Bank ({{ $transaction->bank }})
                                                                @break
                                                            @case('e_wallet')
                                                                E-Wallet ({{ $transaction->ewallet }})
                                                                @break
                                                        @endswitch
                                                    </strong>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-clock text-muted me-2"></i>
                                                <div>
                                                    <small class="text-muted d-block">Status</small>
                                                    <span class="badge bg-warning text-dark px-3 py-2 rounded-pill">
                                                        <i class="fas fa-hourglass-half me-1"></i>
                                                        Menunggu Pembayaran
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Payment Instructions -->
                        <div class="mb-5">
                            <h5 class="fw-bold mb-4 d-flex align-items-center">
                                <i class="fas fa-info-circle me-2" style="color: #FF5733;"></i>
                                Instruksi Pembayaran
                            </h5>
                            <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);">
                                <div class="card-body p-4">
                                    @if($transaction->metode_pembayaran === 'transfer_bank')
                                        <div class="d-flex align-items-start mb-3">
                                            <i class="fas fa-university fa-2x me-3 mt-1" style="color: #1976d2;"></i>
                                            <div>
                                                <h6 class="fw-bold mb-2">Transfer ke rekening berikut:</h6>
                                                @switch($transaction->bank)
                                                    @case('BCA')
                                                        <div class="bg-white rounded-3 p-3 border-start border-4" style="border-color: #1976d2 !important;">
                                                            <div class="row">
                                                                <div class="col-sm-4"><strong>Bank:</strong></div>
                                                                <div class="col-sm-8">BCA</div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-sm-4"><strong>No. Rekening:</strong></div>
                                                                <div class="col-sm-8"><code class="bg-light px-2 py-1 rounded">1234567890</code></div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-sm-4"><strong>Atas Nama:</strong></div>
                                                                <div class="col-sm-8">Agung Citra Sukses Abadi</div>
                                                            </div>
                                                        </div>
                                                        @break
                                                    @case('BNI')
                                                        <div class="bg-white rounded-3 p-3 border-start border-4" style="border-color: #1976d2 !important;">
                                                            <div class="row">
                                                                <div class="col-sm-4"><strong>Bank:</strong></div>
                                                                <div class="col-sm-8">BNI</div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-sm-4"><strong>No. Rekening:</strong></div>
                                                                <div class="col-sm-8"><code class="bg-light px-2 py-1 rounded">0987654321</code></div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-sm-4"><strong>Atas Nama:</strong></div>
                                                                <div class="col-sm-8">Agung Citra Sukses Abadi</div>
                                                            </div>
                                                        </div>
                                                        @break
                                                    @case('BRI')
                                                        <div class="bg-white rounded-3 p-3 border-start border-4" style="border-color: #1976d2 !important;">
                                                            <div class="row">
                                                                <div class="col-sm-4"><strong>Bank:</strong></div>
                                                                <div class="col-sm-8">BRI</div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-sm-4"><strong>No. Rekening:</strong></div>
                                                                <div class="col-sm-8"><code class="bg-light px-2 py-1 rounded">1122334455</code></div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-sm-4"><strong>Atas Nama:</strong></div>
                                                                <div class="col-sm-8">Agung Citra Sukses Abadi</div>
                                                            </div>
                                                        </div>
                                                        @break
                                                    @case('Mandiri')
                                                        <div class="bg-white rounded-3 p-3 border-start border-4" style="border-color: #1976d2 !important;">
                                                            <div class="row">
                                                                <div class="col-sm-4"><strong>Bank:</strong></div>
                                                                <div class="col-sm-8">Mandiri</div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-sm-4"><strong>No. Rekening:</strong></div>
                                                                <div class="col-sm-8"><code class="bg-light px-2 py-1 rounded">5544332211</code></div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-sm-4"><strong>Atas Nama:</strong></div>
                                                                <div class="col-sm-8">Agung Citra Sukses Abadi</div>
                                                            </div>
                                                        </div>
                                                        @break
                                                    @case('CIMB')
                                                        <div class="bg-white rounded-3 p-3 border-start border-4" style="border-color: #1976d2 !important;">
                                                            <div class="row">
                                                                <div class="col-sm-4"><strong>Bank:</strong></div>
                                                                <div class="col-sm-8">CIMB</div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-sm-4"><strong>No. Rekening:</strong></div>
                                                                <div class="col-sm-8"><code class="bg-light px-2 py-1 rounded">9988776655</code></div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-sm-4"><strong>Atas Nama:</strong></div>
                                                                <div class="col-sm-8">Agung Citra Sukses Abadi</div>
                                                            </div>
                                                        </div>
                                                        @break
                                                @endswitch
                                            </div>
                                        </div>
                                    @elseif($transaction->metode_pembayaran === 'e_wallet')
                                        <div class="d-flex align-items-start mb-3">
                                            <i class="fas fa-mobile-alt fa-2x me-3 mt-1" style="color: #28a745;"></i>
                                            <div>
                                                <h6 class="fw-bold mb-2">Transfer ke {{ $transaction->ewallet }}:</h6>
                                                @switch($transaction->ewallet)
                                                    @case('GoPay')
                                                        <div class="bg-white rounded-3 p-3 border-start border-4" style="border-color: #28a745 !important;">
                                                            <div class="row">
                                                                <div class="col-sm-4"><strong>Platform:</strong></div>
                                                                <div class="col-sm-8">GoPay</div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-sm-4"><strong>Nomor:</strong></div>
                                                                <div class="col-sm-8"><code class="bg-light px-2 py-1 rounded">081234567890</code></div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-sm-4"><strong>Atas Nama:</strong></div>
                                                                <div class="col-sm-8">Agung Citra Sukses Abadi</div>
                                                            </div>
                                                        </div>
                                                        @break
                                                    @case('OVO')
                                                        <div class="bg-white rounded-3 p-3 border-start border-4" style="border-color: #28a745 !important;">
                                                            <div class="row">
                                                                <div class="col-sm-4"><strong>Platform:</strong></div>
                                                                <div class="col-sm-8">OVO</div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-sm-4"><strong>Nomor:</strong></div>
                                                                <div class="col-sm-8"><code class="bg-light px-2 py-1 rounded">081234567890</code></div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-sm-4"><strong>Atas Nama:</strong></div>
                                                                <div class="col-sm-8">Agung Citra Sukses Abadi</div>
                                                            </div>
                                                        </div>
                                                        @break
                                                    @case('DANA')
                                                        <div class="bg-white rounded-3 p-3 border-start border-4" style="border-color: #28a745 !important;">
                                                            <div class="row">
                                                                <div class="col-sm-4"><strong>Platform:</strong></div>
                                                                <div class="col-sm-8">DANA</div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-sm-4"><strong>Nomor:</strong></div>
                                                                <div class="col-sm-8"><code class="bg-light px-2 py-1 rounded">081234567890</code></div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-sm-4"><strong>Atas Nama:</strong></div>
                                                                <div class="col-sm-8">Agung Citra Sukses Abadi</div>
                                                            </div>
                                                        </div>
                                                        @break
                                                    @case('ShopeePay')
                                                        <div class="bg-white rounded-3 p-3 border-start border-4" style="border-color: #28a745 !important;">
                                                            <div class="row">
                                                                <div class="col-sm-4"><strong>Platform:</strong></div>
                                                                <div class="col-sm-8">ShopeePay</div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-sm-4"><strong>Nomor:</strong></div>
                                                                <div class="col-sm-8"><code class="bg-light px-2 py-1 rounded">081234567890</code></div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-sm-4"><strong>Atas Nama:</strong></div>
                                                                <div class="col-sm-8">Agung Citra Sukses Abadi</div>
                                                            </div>
                                                        </div>
                                                        @break
                                                @endswitch
                                            </div>
                                        </div>
                                    @endif
                                    <div class="alert alert-warning border-0 mt-3 mb-0" style="background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%);">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-exclamation-triangle me-2" style="color: #856404;"></i>
                                            <strong style="color: #856404;">Jumlah yang harus dibayar: Rp {{ number_format($transaction->total_harga, 0, ',', '.') }}</strong>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Upload Form -->
                        <div class="mb-5">
                            <h5 class="fw-bold mb-4 d-flex align-items-center">
                                <i class="fas fa-cloud-upload-alt me-2" style="color: #FF5733;"></i>
                                Upload Bukti Pembayaran
                            </h5>
                            
                            <form method="POST" action="{{ route('payment.upload.post', $transaction->id) }}" enctype="multipart/form-data">
                                @csrf
                                <div class="card border-0 shadow-sm mb-4" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
                                    <div class="card-body p-4">
                                        <div class="upload-area border-2 border-dashed rounded-4 p-5 text-center" style="border-color: #dee2e6 !important; background-color: #ffffff; transition: all 0.3s ease;">
                                            <i class="fas fa-cloud-upload-alt fa-4x text-muted mb-4"></i>
                                            <h6 class="fw-bold mb-3">Pilih File Bukti Pembayaran</h6>
                                            <input type="file" class="form-control d-none" id="bukti_pembayaran" name="bukti_pembayaran" accept="image/*" required>
                                            <label for="bukti_pembayaran" class="btn btn-outline-primary btn-lg mb-3 cursor-pointer">
                                                <i class="fas fa-upload me-2"></i>Pilih File
                                            </label>
                                            <div class="text-muted">
                                                <small>Format: JPG, PNG, JPEG | Maksimal: 2MB</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card border-0 shadow-sm mb-4" style="background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%);">
                                    <div class="card-body p-4">
                                        <h6 class="fw-bold mb-3 d-flex align-items-center" style="color: #856404;">
                                            <i class="fas fa-exclamation-triangle me-2"></i>
                                            Penting - Pastikan Bukti Pembayaran:
                                        </h6>
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <div class="d-flex align-items-start">
                                                    <i class="fas fa-check-circle me-2 mt-1" style="color: #28a745;"></i>
                                                    <small>Jelas dan dapat dibaca dengan baik</small>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="d-flex align-items-start">
                                                    <i class="fas fa-check-circle me-2 mt-1" style="color: #28a745;"></i>
                                                    <small>Menampilkan tanggal dan waktu transaksi</small>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="d-flex align-items-start">
                                                    <i class="fas fa-check-circle me-2 mt-1" style="color: #28a745;"></i>
                                                    <small>Jumlah sesuai dengan total pesanan</small>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="d-flex align-items-start">
                                                    <i class="fas fa-clock me-2 mt-1" style="color: #ffc107;"></i>
                                                    <small>Verifikasi dalam 1x24 jam</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-grid gap-3">
                                    <button type="submit" class="btn btn-lg py-3 fw-bold text-white border-0 rounded-4" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);">
                                        <i class="fas fa-cloud-upload-alt me-2"></i>
                                        Upload Bukti Pembayaran
                                    </button>
                                    <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary btn-lg py-3 fw-semibold rounded-4">
                                        <i class="fas fa-arrow-left me-2"></i>
                                        Kembali ke Dashboard
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <style>
        .upload-area:hover {
            border-color: #FF5733 !important;
            background-color: #fff5f5 !important;
            transform: translateY(-2px);
        }
        .cursor-pointer {
            cursor: pointer;
        }
        .btn:hover {
            transform: translateY(-2px);
        }
        .card {
            transition: all 0.3s ease;
        }
        .form-control:focus {
            border-color: #FF5733;
            box-shadow: 0 0 0 0.2rem rgba(255, 87, 51, 0.25);
        }
        code {
            font-size: 0.9em;
            font-weight: 600;
        }
        .badge {
            font-size: 0.8em;
        }
    </style>

    <script>
        // File upload preview
        document.getElementById('bukti_pembayaran').addEventListener('change', function(e) {
            const file = e.target.files[0];
            const uploadArea = document.querySelector('.upload-area');
            
            if (file) {
                const fileName = file.name;
                const fileSize = (file.size / 1024 / 1024).toFixed(2);
                
                uploadArea.innerHTML = `
                    <i class="fas fa-file-image fa-4x text-success mb-4"></i>
                    <h6 class="fw-bold mb-2 text-success">File Terpilih</h6>
                    <p class="mb-2"><strong>${fileName}</strong></p>
                    <p class="text-muted mb-3">Ukuran: ${fileSize} MB</p>
                    <button type="button" class="btn btn-outline-secondary btn-sm" onclick="resetUpload()">
                        <i class="fas fa-times me-1"></i>Ganti File
                    </button>
                `;
                uploadArea.style.borderColor = '#28a745';
                uploadArea.style.backgroundColor = '#f8fff8';
            }
        });

        function resetUpload() {
            document.getElementById('bukti_pembayaran').value = '';
            const uploadArea = document.querySelector('.upload-area');
            uploadArea.innerHTML = `
                <i class="fas fa-cloud-upload-alt fa-4x text-muted mb-4"></i>
                <h6 class="fw-bold mb-3">Pilih File Bukti Pembayaran</h6>
                <input type="file" class="form-control d-none" id="bukti_pembayaran" name="bukti_pembayaran" accept="image/*" required>
                <label for="bukti_pembayaran" class="btn btn-outline-primary btn-lg mb-3 cursor-pointer">
                    <i class="fas fa-upload me-2"></i>Pilih File
                </label>
                <div class="text-muted">
                    <small>Format: JPG, PNG, JPEG | Maksimal: 2MB</small>
                </div>
            `;
            uploadArea.style.borderColor = '#dee2e6';
            uploadArea.style.backgroundColor = '#ffffff';
            
            // Re-attach event listener
            document.getElementById('bukti_pembayaran').addEventListener('change', arguments.callee.caller);
        }
    </script>
</body>
</html>