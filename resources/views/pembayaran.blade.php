<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran - Plakat Shop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .custom-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        .custom-header {
            background: #212529;
            color: white;
            border-radius: 15px 15px 0 0;
            padding: 20px;
        }
        .custom-input:focus {
            box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
            border-color: #0d6efd;
        }
        .custom-btn {
            background: #0d6efd;
            border: none;
            padding: 12px 30px;
            color: white;
            font-weight: bold;
        }
        .input-group-text {
            background: #212529;
            color: white;
            border: none;
        }
        <style>
            .custom-card {
                border: none;
                border-radius: 15px;
                box-shadow: 0 0 20px rgba(0,0,0,0.1);
            }
            .custom-header {
                background: #212529;
                color: white;
                border-radius: 15px 15px 0 0;
                padding: 20px;
            }
            .custom-input:focus {
                box-shadow: 0 0 0 0.2rem rgba(33, 37, 41, 0.25);
                border-color: #212529;
            }
            .custom-btn {
                background: #212529;
                border: none;
                padding: 12px 30px;
                transition: all 0.3s;
            }
            .custom-btn:hover {
                transform: translateY(-2px);
                box-shadow: 0 5px 15px rgba(33, 37, 41, 0.3);
            }
            .input-group-text {
                background: #212529;
                color: white;
                border: none;
            }
            .custom-card {
                border: none;
                border-radius: 15px;
                box-shadow: 0 0 20px rgba(0,0,0,0.1);
            }
            .custom-header {
                background: #212529;
                color: white;
                border-radius: 15px 15px 0 0;
                padding: 20px;
            }
            .custom-input:focus {
                box-shadow: 0 0 0 0.2rem rgba(33, 37, 41, 0.25);
                border-color: #212529;
            }
            .custom-btn {
                background: #212529;
                border: none;
                padding: 12px 30px;
                transition: all 0.3s;
            }
            .custom-btn:hover {
                transform: translateY(-2px);
                box-shadow: 0 5px 15px rgba(33, 37, 41, 0.3);
            }
            .input-group-text {
                background: #212529;
                color: white;
                border: none;
            }
            .custom-card {
                border: none;
                border-radius: 15px;
                box-shadow: 0 0 20px rgba(0,0,0,0.1);
            }
            .custom-header {
                background: #212529;
                color: white;
                border-radius: 15px 15px 0 0;
                padding: 20px;
            }
            .custom-input:focus {
                box-shadow: 0 0 0 0.2rem rgba(33, 37, 41, 0.25);
                border-color: #212529;
            }
            .custom-btn {
                background: #212529;
                border: none;
                padding: 12px 30px;
                transition: all 0.3s;
            }
            .custom-btn:hover {
                transform: translateY(-2px);
                box-shadow: 0 5px 15px rgba(33, 37, 41, 0.3);
            }
            .input-group-text {
                background: #212529;
                color: white;
                border: none;
            }
            .custom-card {
                border: none;
                border-radius: 15px;
                box-shadow: 0 0 20px rgba(0,0,0,0.1);
            }
            .custom-header {
                background: #212529;
                color: white;
                border-radius: 15px 15px 0 0;
                padding: 20px;
            }
            .custom-input:focus {
                box-shadow: 0 0 0 0.2rem rgba(33, 37, 41, 0.25);
                border-color: #212529;
            }
            .custom-btn {
                background: #212529;
                border: none;
                padding: 12px 30px;
                transition: all 0.3s;
            }
            .custom-btn:hover {
                transform: translateY(-2px);
                box-shadow: 0 5px 15px rgba(33, 37, 41, 0.3);
            }
            .input-group-text {
                background: #212529;
                color: white;
                border: none;
            }
            .custom-card {
                border: none;
                border-radius: 15px;
                box-shadow: 0 0 20px rgba(0,0,0,0.1);
            }
            .custom-header {
                background: #212529;
                color: white;
                border-radius: 15px 15px 0 0;
                padding: 20px;
            }
            .custom-input:focus {
                box-shadow: 0 0 0 0.2rem rgba(33, 37, 41, 0.25);
                border-color: #212529;
            }
            .custom-btn {
                background: #212529;
                border: none;
                padding: 12px 30px;
                transition: all 0.3s;
            }
            .custom-btn:hover {
                transform: translateY(-2px);
                box-shadow: 0 5px 15px rgba(33, 37, 41, 0.3);
            }
            .input-group-text {
                background: #212529;
                color: white;
                border: none;
            }
            .custom-card {
                border: none;
                border-radius: 15px;
                box-shadow: 0 0 20px rgba(0,0,0,0.1);
            }
            .custom-header {
                background: #212529;
                color: white;
                border-radius: 15px 15px 0 0;
                padding: 20px;
            }
            .custom-input:focus {
                box-shadow: 0 0 0 0.2rem rgba(33, 37, 41, 0.25);
                border-color: #212529;
            }
            .custom-btn {
                background: #212529;
                border: none;
                padding: 12px 30px;
                transition: all 0.3s;
            }
            .custom-btn:hover {
                transform: translateY(-2px);
                box-shadow: 0 5px 15px rgba(33, 37, 41, 0.3);
            }
            .input-group-text {
                background: #212529;
                color: white;
                border: none;
            }
            .custom-card {
                border: none;
                border-radius: 15px;
                box-shadow: 0 0 20px rgba(0,0,0,0.1);
            }
            .custom-header {
                background: #212529;
                color: white;
                border-radius: 15px 15px 0 0;
                padding: 20px;
            }
            .custom-input:focus {
                box-shadow: 0 0 0 0.2rem rgba(33, 37, 41, 0.25);
                border-color: #212529;
            }
            .custom-btn {
                background: #212529;
                border: none;
                padding: 12px 30px;
                transition: all 0.3s;
            }
            .custom-btn:hover {
                transform: translateY(-2px);
                box-shadow: 0 5px 15px rgba(33, 37, 41, 0.3);
            }
            .input-group-text {
                background: #212529;
                color: white;
                border: none;
            }
            .custom-card {
                border: none;
                border-radius: 15px;
                box-shadow: 0 0 20px rgba(0,0,0,0.1);
            }
            .custom-header {
                background: #212529;
                color: white;
                border-radius: 15px 15px 0 0;
                padding: 20px;
            }
            .custom-input:focus {
                box-shadow: 0 0 0 0.2rem rgba(33, 37, 41, 0.25);
                border-color: #212529;
            }
            .custom-btn {
                background: #212529;
                border: none;
                padding: 12px 30px;
                transition: all 0.3s;
            }
            .custom-btn:hover {
                transform: translateY(-2px);
                box-shadow: 0 5px 15px rgba(33, 37, 41, 0.3);
            }
            .input-group-text {
                background: #212529;
                color: white;
                border: none;
            }
            .custom-card {
                border: none;
                border-radius: 15px;
                box-shadow: 0 0 20px rgba(0,0,0,0.1);
            }
            .custom-header {
                background: #212529;
                color: white;
                border-radius: 15px 15px 0 0;
                padding: 20px;
            }
            .custom-input:focus {
                box-shadow: 0 0 0 0.2rem rgba(33, 37, 41, 0.25);
                border-color: #212529;
            }
            .custom-btn {
                background: #212529;
                border: none;
                padding: 12px 30px;
                transition: all 0.3s;
            }
            .custom-btn:hover {
                transform: translateY(-2px);
                box-shadow: 0 5px 15px rgba(33, 37, 41, 0.3);
            }
            .input-group-text {
                background: #212529;
                color: white;
                border: none;
            }
            .custom-card {
                border: none;
                border-radius: 15px;
                box-shadow: 0 0 20px rgba(0,0,0,0.1);
            }
            .custom-header {
                background: #212529;
                color: white;
                border-radius: 15px 15px 0 0;
                padding: 20px;
            }
            .custom-input:focus {
                box-shadow: 0 0 0 0.2rem rgba(33, 37, 41, 0.25);
                border-color: #212529;
            }
            .custom-btn {
                background: #212529;
                border: none;
                padding: 12px 30px;
                transition: all 0.3s;
            }
            .custom-btn:hover {
                transform: translateY(-2px);
                box-shadow: 0 5px 15px rgba(33, 37, 41, 0.3);
            }
            .input-group-text {
                background: #212529;
                color: white;
                border: none;
            }
            .custom-card {
                border: none;
                border-radius: 15px;
                box-shadow: 0 0 20px rgba(0,0,0,0.1);
            }
            .custom-header {
                background: #212529;
                color: white;
                border-radius: 15px 15px 0 0;
                padding: 20px;
            }
            .custom-input:focus {
                box-shadow: 0 0 0 0.2rem rgba(33, 37, 41, 0.25);
                border-color: #212529;
            }
            .custom-btn {
                background: #212529;
                border: none;
                padding: 12px 30px;
                transition: all 0.3s;
            }
            .custom-btn:hover {
                transform: translateY(-2px);
                box-shadow: 0 5px 15px rgba(33, 37, 41, 0.3);
            }
            .input-group-text {
                background: #212529;
                color: white;
                border: none;
            }
            .custom-card {
                border: none;
                border-radius: 15px;
                box-shadow: 0 0 20px rgba(0,0,0,0.1);
            }
            .custom-header {
                background: #212529;
                color: white;
                border-radius: 15px 15px 0 0;
                padding: 20px;
            }
            .custom-input:focus {
                box-shadow: 0 0 0 0.2rem rgba(33, 37, 41, 0.25);
                border-color: #212529;
            }
            .custom-btn {
                background: #212529;
                border: none;
                padding: 12px 30px;
                transition: all 0.3s;
            }
            .custom-btn:hover {
                transform: translateY(-2px);
                box-shadow: 0 5px 15px rgba(33, 37, 41, 0.3);
            }
            .input-group-text {
                background: #212529;
                color: white;
                border: none;
            }
            .custom-card {
                border: none;
                border-radius: 15px;
                box-shadow: 0 0 20px rgba(0,0,0,0.1);
            }
            .custom-header {
                background: #212529;
                color: white;
                border-radius: 15px 15px 0 0;
                padding: 20px;
            }
            .custom-input:focus {
                box-shadow: 0 0 0 0.2rem rgba(33, 37, 41, 0.25);
                border-color: #212529;
            }
            .custom-btn {
                background: #212529;
                border: none;
                padding: 12px 30px;
                transition: all 0.3s;
            }
            .custom-btn:hover {
                transform: translateY(-2px);
                box-shadow: 0 5px 15px rgba(33, 37, 41, 0.3);
            }
            .input-group-text {
                background: #212529;
                color: white;
                border: none;
            }
            .form-select {
                font-size: 1rem;
                color: #000;
            }
            .form-select option {
                font-size: 1rem;
                color: #000;
                padding: 10px;
            }
            #metode_pembayaran option,
            #bank option,
            #ewallet option {
                background-color: #fff;
                color: #000;
                padding: 8px 12px;
            }
            .custom-card {
                border: none;
                border-radius: 15px;
                box-shadow: 0 0 20px rgba(0,0,0,0.1);
            }
            .custom-header {
                background: #212529;
                color: white;
                border-radius: 15px 15px 0 0;
                padding: 20px;
            }
            .custom-input:focus {
                box-shadow: 0 0 0 0.2rem rgba(33, 37, 41, 0.25);
                border-color: #212529;
            }
            .custom-btn {
                background: #212529;
                border: none;
                padding: 12px 30px;
                transition: all 0.3s;
            }
            .custom-btn:hover {
                transform: translateY(-2px);
                box-shadow: 0 5px 15px rgba(33, 37, 41, 0.3);
            }
            .input-group-text{
                background: #212529;
                color: white;
                border: none;
            }
        </style>
    </style>
</head>

<body class="bg-light">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm sticky-top">
        <div class="container">
            <a class="navbar-brand " href="/">Agung Citra Sukses Abadi</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
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
            </div>
        </div>
    </nav>

    <div class="container my-5">
        <h1 class="text-center mb-5 fw-bold text-dark">Form Pemesanan</h1>
        
        <div class="row">
            <!-- Detail Produk (Kiri) -->
            <div class="col-md-5">
                <div class="custom-card mb-4">
                    <div class="custom-header">
                        <h5 class="mb-0 fw-bold">Detail Produk</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="product-image-container mb-4">
                            <img src="{{ asset('storage/' . $plakat->gambar) }}" class="img-fluid" alt="{{ $plakat->nama }}">
                        </div>
                        <h4 class="fw-bold text-dark">{{ $plakat->nama }}</h4>
                        <p class="text-muted mb-3">{{ $plakat->deskripsi }}</p>
                        <div class="d-flex align-items-center mb-2">
                            <span class="badge bg-light text-dark me-2">{{ $plakat->kategori }}</span>
                        </div>
                        <div class="price-tag d-inline-block">
                            Rp {{ number_format($plakat->harga, 0, ',', '.') }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Pemesanan (Kanan) -->
            <div class="col-md-7">
                <form id="payment-form" method="POST" action="{{ route('checkout') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="plakat_id" value="{{ $plakat_id }}">
                    <input type="hidden" name="status_pembayaran" value="menunggu_pembayaran">
                    <input type="hidden" name="total_harga" value="{{ $plakat->harga }}">
                    
                    <div class="custom-card">
                        <div class="custom-header">
                            <h5 class="mb-0 fw-bold">Data Pemesanan</h5>
                        </div>
                        <div class="card-body p-4">
                            <!-- Data Pembeli -->
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Nama Lengkap</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                                        <input type="text" class="form-control custom-input" name="nama_pembeli" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Email</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                        <input type="email" class="form-control custom-input" name="email" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-bold">No. Telepon</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                        <input type="text" class="form-control custom-input" name="no_telepon" required>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <label class="form-label fw-bold">Alamat Lengkap</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                        <textarea class="form-control custom-input" name="alamat" rows="3" required></textarea>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <label class="form-label fw-bold">Custom Design</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-image"></i></span>
                                        <input type="file" class="form-control custom-input" name="design_file" accept="image/*">
                                    </div>
                                    <small class="text-muted">Upload file design dalam format gambar (JPG, PNG)</small>
                                </div>

                                <div class="col-12">
                                    <label class="form-label fw-bold">Catatan Design</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                                        <textarea class="form-control custom-input" name="catatan_design" rows="3" placeholder="Tambahkan catatan khusus untuk design plakat Anda"></textarea>
                                    </div>
                                </div>

                                <!-- Metode Pembayaran -->
                                <div class="col-12">
                                    <label class="form-label fw-bold">Metode Pembayaran</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-wallet"></i></span>
                                        <select class="form-select custom-input" name="metode_pembayaran" id="metode_pembayaran" required>
                                            <option value="">Pilih metode pembayaran</option>
                                            <option value="transfer_bank">Transfer Bank</option>
                                            <option value="e_wallet">E-Wallet</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-12" id="bank-container" style="display: none;">
                                    <label class="form-label fw-bold">Pilih Bank</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-university"></i></span>
                                        <select class="form-select custom-input" name="bank" id="bank">
                                            <option value="">Pilih Bank</option>
                                            <option value="bca">BCA - 1234567890 (Nama Pemilik)</option>
                                            <option value="bni">BNI - 0987654321 (Nama Pemilik)</option>
                                            <option value="mandiri">Mandiri - 2468135790 (Nama Pemilik)</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-12" id="ewallet-container" style="display: none;">
                                    <label class="form-label fw-bold">Pilih E-Wallet</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-mobile-alt"></i></span>
                                        <select class="form-select custom-input" name="ewallet" id="ewallet">
                                            <option value="">Pilih E-Wallet</option>
                                            <option value="dana">DANA - 081234567890</option>
                                            <option value="ovo">OVO - 081234567890</option>
                                            <option value="gopay">GoPay - 081234567890</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-12" id="bukti-transfer-container" style="display: none;">
                                    <label class="form-label fw-bold">Bukti Transfer</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-receipt"></i></span>
                                        <input type="file" class="form-control custom-input" name="bukti_pembayaran" accept="image/*">
                                    </div>
                                    <small class="text-muted">Upload bukti transfer dalam format gambar (JPG, PNG)</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="text-center mt-4">
                        <button type="submit" class="btn custom-btn btn-lg px-5 rounded-pill">
                            Proses Pemesanan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('metode_pembayaran').addEventListener('change', function() {
            const bankContainer = document.getElementById('bank-container');
            const ewalletContainer = document.getElementById('ewallet-container');
            const buktiTransferContainer = document.getElementById('bukti-transfer-container');
            
            // Sembunyikan semua container terlebih dahulu
            bankContainer.style.display = 'none';
            ewalletContainer.style.display = 'none';
            buktiTransferContainer.style.display = 'none';
            
            // Reset required attribute
            bankContainer.querySelector('select').required = false;
            ewalletContainer.querySelector('select').required = false;
            buktiTransferContainer.querySelector('input').required = false;
            
            // Tampilkan container yang sesuai
            if (this.value === 'transfer_bank') {
                bankContainer.style.display = 'block';
                buktiTransferContainer.style.display = 'block';
                bankContainer.querySelector('select').required = true;
                buktiTransferContainer.querySelector('input').required = true;
            } else if (this.value === 'e_wallet') {
                ewalletContainer.style.display = 'block';
                buktiTransferContainer.style.display = 'block';
                ewalletContainer.querySelector('select').required = true;
                buktiTransferContainer.querySelector('input').required = true;
            }
        });
    </script>
    
    <script>
    document.getElementById('payment-form').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const form = this;
        const formData = new FormData(form);
        
        fetch('{{ route("checkout") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire({
                    title: 'Sukses!',
                    text: 'Pesanan Anda berhasil diproses',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = '/'; // Redirect ke halaman utama
                    }
                });
            } else {
                Swal.fire({
                    title: 'Error!',
                    text: data.message || 'Terjadi kesalahan',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        })
        .catch(error => {
            Swal.fire({
                title: 'Error!',
                text: 'Terjadi kesalahan pada server',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        });
    });
    </script>
</body>
</html>
