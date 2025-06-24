<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plakat Shop - Kontak</title>
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
                        <a class="nav-link" href="/product">Produk</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/about">Tentang</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="/contact">Kontak</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h1 class="text-center mb-5">Hubungi Kami</h1>

                <!-- Info kontak - tambahkan breakpoint untuk tablet -->
                <div class="row mb-4">
                    <div class="col-12 col-sm-6 col-md-4 text-center mb-3">
                        <i class="fas fa-map-marker-alt fa-2x mb-2 text-primary"></i>
                        <h5>Alamat</h5>
                        <p class="mb-0">Jl. Galur Raya No.2 13,RT.13/RW.4...</p>
                    </div>
                    <div class="col-12 col-sm-6 col-md-4 text-center mb-3">
                        <i class="fas fa-phone fa-2x mb-2 text-primary"></i>
                        <h5>Telepon</h5>
                        <p>+62 812-8635-506</p>
                    </div>
                    <div class="col-12 col-sm-6 col-md-4 text-center mb-3">
                        <i class="fas fa-envelope fa-2x mb-2 text-primary"></i>
                        <h5>Email</h5>
                        <p>yuda99354@gmail.com</p>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title mb-4">Kirim Pesan</h3>
                        
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                
                        <form action="{{ route('contact.store') }}" method="POST" class="contact-form">
                            @csrf
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control @error('nama') is-invalid @enderror" 
                                       id="nama" name="nama" value="{{ old('nama') }}" required>
                                @error('nama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                       id="email" name="email" value="{{ old('email') }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="telepon" class="form-label">Nomor Telepon</label>
                                <input type="tel" class="form-control @error('telepon') is-invalid @enderror" 
                                       id="telepon" name="telepon" value="{{ old('telepon') }}" required>
                                @error('telepon')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="pesan" class="form-label">Pesan</label>
                                <textarea class="form-control @error('pesan') is-invalid @enderror" 
                                          id="pesan" name="pesan" rows="5" required>{{ old('pesan') }}</textarea>
                                @error('pesan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary btn-lg px-5">
                                    <i class="fas fa-paper-plane me-2"></i>Kirim Pesan
                                </button>
                            </div>
                        </form>
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