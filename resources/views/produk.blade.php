<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plakat Shop - Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="/">Agung Citra Sukses Abadi</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="/product">Produk</a>
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
        <div class="text-center mb-5">
            <h1 class="display-4 fw-bold">Katalog Produk</h1>
            <p class="lead text-muted">Temukan plakat berkualitas dengan desain eksklusif</p>
        </div>

        <!-- Search form with improved styling -->
        <div class="row mb-5">
            <div class="col-md-8 mx-auto">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <form action="/product" method="GET" class="row g-3">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                                    <input type="text" name="search" class="form-control" placeholder="Cari produk..." value="{{ request('search') }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <select name="kategori" class="form-select">
                                    <option value="">Semua Kategori</option>
                                    @foreach($plakats->pluck('kategori')->unique() as $kategori)
                                        <option value="{{ $kategori }}" {{ request('kategori') == $kategori ? 'selected' : '' }}>{{ $kategori }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2 d-grid">
                                <button type="submit" class="btn btn-primary">Cari</button>
                            </div>
                            @if(request('search') || request('kategori'))
                                <div class="col-12 text-center mt-2">
                                    <a href="/product" class="btn btn-sm btn-outline-secondary">Reset Filter</a>
                                </div>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Product grid with improved styling -->
        <div class="row g-4">
            @forelse($plakats as $plakat)
                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                    <div class="card product-card h-100 rounded-4 overflow-hidden border-0">
                        <div class="position-relative">
                            <img src="{{ asset('storage/' . $plakat->gambar) }}" 
                                 class="card-img-top product-image" 
                                 alt="{{ $plakat->nama }}"
                                 style="height: 300px; object-fit: cover;">
                            <a href="{{ route('pembayaran', ['plakat_id' => $plakat->id]) }}" 
                               class="btn btn-detail position-absolute top-50 start-50 translate-middle">
                                Lihat Detail
                            </a>
                        </div>
                        <div class="card-body bg-white text-center">
                            <h5 class="card-title fw-bold mb-2">{{ $plakat->nama }}</h5>
                            <p class="price mb-0">Rp {{ number_format($plakat->harga, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center">
                    <div class="alert alert-info p-5">
                        <i class="fas fa-box-open fa-3x mb-3"></i>
                        <h4>Belum ada produk</h4>
                        <p class="mb-0">Produk akan segera tersedia.</p>
                    </div>
                </div>
            @endforelse
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