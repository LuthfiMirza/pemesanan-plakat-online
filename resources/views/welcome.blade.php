<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plakat Shop - Beranda</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm sticky-top">
        <div class="container">
            <a class="navbar-brand" href="/">Agung Citra Sukses Abadi</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="/">Beranda</a>
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

    <div class="hero-section" style="background-image: url('{{ asset('images/background.jpg') }}'); background-size: cover; background-position: center; min-height: 500px; display: flex; align-items: center; position: relative;">
        <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.6);"></div>
        <div class="container position-relative">
            <h1 class="display-4 fw-bold text-white">Selamat Datang di AGUNG CITRA SUKSES ABADI</h1>
            <p class="lead mb-4 text-white">Solusi terbaik untuk plakat dan trophy berkualitas tinggi</p>
            <a href="/product" class="btn btn-primary btn-lg px-5 py-3">Lihat Produk</a>
        </div>
    </div>
    <div class="container py-5">
        <div class="row mb-5 g-4">
            <div class="col-12 col-sm-6 col-md-4">
                <div class="card h-100">
                    <div class="card-body text-center p-4">
                        <i class="fas fa-clock fa-3x mb-4" style="color: #FF5733;"></i>  <!-- Menggunakan kode warna hex -->
                        <h3 class="mb-3">Jam Operasional</h3>
                        <p class="mb-0">Buka Hari Senin - Sabtu</p>
                        <p class="mb-0">09:00 - 23:00 WIB</p>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-4">
                <div class="card h-100">
                    <div class="card-body text-center p-4">
                        <i class="fas fa-medal fa-3x mb-4" style="color: #FF5733;"></i>
                        <h3 class="mb-3">Kualitas Terbaik</h3>
                        <p class="mb-0">Menggunakan material berkualitas tinggi untuk hasil yang maksimal</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-body text-center p-4">
                        <i class="fas fa-shipping-fast fa-3x mb-4" style="color: #FF5733;"></i>
                        <h3 class="mb-3">Pengiriman Cepat</h3>
                        <p class="mb-0">Jaminan pengiriman tepat waktu ke seluruh Indonesia</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-body text-center p-4">
                        <i class="fas fa-hand-holding-usd fa-3x mb-4" style="color: #FF5733;"></i>
                        <h3 class="mb-3">Harga Bersaing</h3>
                        <p class="mb-0">Harga terbaik dengan kualitas terjamin</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="bg-dark text-white py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <h5 class="fw-bold mb-3">Agung Citra Sukses Abadi</h5>
                    <p>Solusi terbaik untuk plakat berkualitas dengan desain eksklusif dan material premium.</p>
                </div>
                <div class="col-md-4 mb-4">
                    <h5 class="fw-bold mb-3">Link Cepat</h5>
                    <ul class="list-unstyled">
                        <li><a href="/" class="text-white-50">Beranda</a></li>
                        <li><a href="/product" class="text-white-50">Produk</a></li>
                        <li><a href="/about" class="text-white-50">Tentang</a></li>
                        <li><a href="/contact" class="text-white-50">Kontak</a></li>
                    </ul>
                </div>
                <div class="col-md-4 mb-4">
                    <h5 class="fw-bold mb-3">Hubungi Kami</h5>
                    <p class="mb-2"><i class="fas fa-envelope me-2"></i> yuda99354@gmail.com</p>
                    <p class="mb-2"><i class="fas fa-phone me-2"></i> +62 812-8635-506</p>
                    <p class="mb-0"><i class="fas fa-map-marker-alt me-2"></i> Jakarta, Indonesia</p>
                </div>
            </div>
            <hr class="mt-4 mb-3">
            <div class="text-center text-white-50">
                <small>&copy; 2025 Agung Citra Sukses Abadi. All rights reserved.</small>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>