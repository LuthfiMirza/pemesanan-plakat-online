<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pembayaran - Agung Citra Sukses Abadi</title>
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
                        <div class="d-flex align-items-center">
                            <i class="fas fa-shopping-cart fa-2x me-3"></i>
                            <div>
                                <h3 class="mb-1 fw-bold">Form Pemesanan</h3>
                                <p class="mb-0 opacity-75">{{ $plakat->nama }}</p>
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

                        <!-- Product Info -->
                        <div class="row mb-5">
                            <div class="col-md-5">
                                @if($plakat->gambar)
                                    <div class="position-relative">
                                        <img src="{{ asset('storage/' . $plakat->gambar) }}" class="img-fluid rounded-4 shadow-sm" alt="{{ $plakat->nama }}" style="width: 100%; height: 300px; object-fit: cover;">
                                        <div class="position-absolute top-0 start-0 m-3">
                                            <span class="badge bg-success px-3 py-2 rounded-pill">
                                                <i class="fas fa-check me-1"></i>Tersedia
                                            </span>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-7 ps-md-4">
                                <div class="h-100 d-flex flex-column justify-content-center">
                                    <h4 class="fw-bold mb-3" style="color: #2c3e50;">{{ $plakat->nama }}</h4>
                                    <p class="text-muted mb-4 lh-lg">{{ $plakat->deskripsi }}</p>
                                    <div class="d-flex align-items-center mb-3">
                                        <span class="text-muted me-2">Harga:</span>
                                        <h3 class="fw-bold mb-0" style="color: #FF5733;" id="unit-price">Rp {{ number_format($plakat->harga, 0, ',', '.') }}</h3>
                                        <span class="text-muted ms-2">/ pcs</span>
                                    </div>
                                    
                                    <!-- Quantity Selector -->
                                    <div class="mb-4">
                                        <label for="quantity" class="form-label fw-semibold">Jumlah:</label>
                                        <div class="d-flex align-items-center">
                                            <button type="button" class="btn btn-outline-secondary" onclick="changeQuantity(-1)" id="btn-minus">
                                                <i class="fas fa-minus"></i>
                                            </button>
                                            <input type="number" class="form-control text-center mx-2" id="quantity" name="quantity" value="1" min="1" max="100" style="width: 80px;" onchange="updateTotal()">
                                            <button type="button" class="btn btn-outline-secondary" onclick="changeQuantity(1)" id="btn-plus">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                    
                                    <div class="d-flex align-items-center text-muted">
                                        <i class="fas fa-star text-warning me-1"></i>
                                        <i class="fas fa-star text-warning me-1"></i>
                                        <i class="fas fa-star text-warning me-1"></i>
                                        <i class="fas fa-star text-warning me-1"></i>
                                        <i class="fas fa-star text-warning me-2"></i>
                                        <small>Kualitas Premium</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <form method="POST" action="{{ route('payment.process') }}" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="plakat_id" value="{{ $plakat->id }}">
                            <input type="hidden" name="total_harga" value="{{ $plakat->harga }}" id="total_harga_input">
                            <input type="hidden" name="unit_price" value="{{ $plakat->harga }}" id="unit_price_input">
                            <input type="hidden" name="quantity" value="1" id="quantity_input">

                            <!-- Customer Information -->
                            <div class="mb-5">
                                <h5 class="fw-bold mb-4 d-flex align-items-center">
                                    <i class="fas fa-user-circle me-2" style="color: #FF5733;"></i>
                                    Informasi Pembeli
                                </h5>
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <label for="nama_pembeli" class="form-label fw-semibold">Nama Lengkap *</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0">
                                                <i class="fas fa-user text-muted"></i>
                                            </span>
                                            <input type="text" class="form-control border-start-0 ps-0" id="nama_pembeli" name="nama_pembeli" value="{{ old('nama_pembeli', Auth::user()->name ?? '') }}" required placeholder="Masukkan nama lengkap">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="email" class="form-label fw-semibold">Email *</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0">
                                                <i class="fas fa-envelope text-muted"></i>
                                            </span>
                                            <input type="email" class="form-control border-start-0 ps-0" id="email" name="email" value="{{ old('email', Auth::user()->email ?? '') }}" required placeholder="contoh@email.com">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="no_telepon" class="form-label fw-semibold">No. Telepon *</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0">
                                                <i class="fas fa-phone text-muted"></i>
                                            </span>
                                            <input type="text" class="form-control border-start-0 ps-0" id="no_telepon" name="no_telepon" value="{{ old('no_telepon') }}" required placeholder="08xxxxxxxxxx">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="alamat" class="form-label fw-semibold">Alamat Lengkap *</label>
                                        <div class="position-relative">
                                            <textarea class="form-control ps-5" id="alamat" name="alamat" rows="3" required placeholder="Masukkan alamat lengkap" style="resize: vertical;">{{ old('alamat') }}</textarea>
                                            <div class="position-absolute top-0 start-0 p-3 text-muted">
                                                <i class="fas fa-map-marker-alt"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Design Information -->
                            <div class="mb-5">
                                <h5 class="fw-bold mb-4 d-flex align-items-center">
                                    <i class="fas fa-palette me-2" style="color: #FF5733;"></i>
                                    Informasi Design
                                </h5>
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <label for="design_file" class="form-label fw-semibold">Upload File Design (Opsional)</label>
                                        <div class="upload-area border-2 border-dashed rounded-4 p-4 text-center" style="border-color: #dee2e6 !important; background-color: #f8f9fa;">
                                            <i class="fas fa-cloud-upload-alt fa-3x text-muted mb-3"></i>
                                            <input type="file" class="form-control d-none" id="design_file" name="design_file" accept="image/*">
                                            <label for="design_file" class="btn btn-outline-primary mb-2 cursor-pointer">
                                                <i class="fas fa-upload me-2"></i>Pilih File
                                            </label>
                                            <div class="small text-muted">Format: JPG, PNG, JPEG. Max: 2MB</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="catatan_design" class="form-label fw-semibold">Catatan Design (Opsional)</label>
                                        <div class="position-relative">
                                            <textarea class="form-control ps-5" id="catatan_design" name="catatan_design" rows="5" placeholder="Berikan catatan khusus untuk design plakat Anda..." style="resize: vertical;">{{ old('catatan_design') }}</textarea>
                                            <div class="position-absolute top-0 start-0 p-3 text-muted">
                                                <i class="fas fa-comment-alt"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Payment Method -->
                            <div class="mb-5">
                                <h5 class="fw-bold mb-4 d-flex align-items-center">
                                    <i class="fas fa-credit-card me-2" style="color: #FF5733;"></i>
                                    Metode Pembayaran
                                </h5>
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <div class="card payment-method border-2 h-100" onclick="selectPaymentMethod('transfer_bank')" style="cursor: pointer; transition: all 0.3s ease;">
                                            <div class="card-body text-center p-4">
                                                <input type="radio" name="metode_pembayaran" value="transfer_bank" id="transfer_bank" class="d-none" {{ old('metode_pembayaran') === 'transfer_bank' ? 'checked' : '' }}>
                                                <div class="payment-icon mb-3" style="color: #667eea;">
                                                    <i class="fas fa-university fa-3x"></i>
                                                </div>
                                                <h6 class="fw-bold mb-2">Transfer Bank</h6>
                                                <small class="text-muted">BCA, BNI, BRI, Mandiri</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card payment-method border-2 h-100" onclick="selectPaymentMethod('e_wallet')" style="cursor: pointer; transition: all 0.3s ease;">
                                            <div class="card-body text-center p-4">
                                                <input type="radio" name="metode_pembayaran" value="e_wallet" id="e_wallet" class="d-none" {{ old('metode_pembayaran') === 'e_wallet' ? 'checked' : '' }}>
                                                <div class="payment-icon mb-3" style="color: #28a745;">
                                                    <i class="fas fa-mobile-alt fa-3x"></i>
                                                </div>
                                                <h6 class="fw-bold mb-2">E-Wallet</h6>
                                                <small class="text-muted">GoPay, OVO, DANA</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card payment-method border-2 h-100" onclick="selectPaymentMethod('cod')" style="cursor: pointer; transition: all 0.3s ease;">
                                            <div class="card-body text-center p-4">
                                                <input type="radio" name="metode_pembayaran" value="cod" id="cod" class="d-none" {{ old('metode_pembayaran') === 'cod' ? 'checked' : '' }}>
                                                <div class="payment-icon mb-3" style="color: #ffc107;">
                                                    <i class="fas fa-hand-holding-usd fa-3x"></i>
                                                </div>
                                                <h6 class="fw-bold mb-2">Cash on Delivery</h6>
                                                <small class="text-muted">Bayar saat terima</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Bank Selection (shown when transfer_bank is selected) -->
                            <div id="bank_selection" class="mb-3" style="display: none;">
                                <label for="bank" class="form-label">Pilih Bank</label>
                                <select class="form-select" name="bank" id="bank">
                                    <option value="">Pilih Bank</option>
                                    <option value="BCA" {{ old('bank') === 'BCA' ? 'selected' : '' }}>BCA</option>
                                    <option value="BNI" {{ old('bank') === 'BNI' ? 'selected' : '' }}>BNI</option>
                                    <option value="BRI" {{ old('bank') === 'BRI' ? 'selected' : '' }}>BRI</option>
                                    <option value="Mandiri" {{ old('bank') === 'Mandiri' ? 'selected' : '' }}>Mandiri</option>
                                    <option value="CIMB" {{ old('bank') === 'CIMB' ? 'selected' : '' }}>CIMB</option>
                                </select>
                            </div>

                            <!-- E-Wallet Selection (shown when e_wallet is selected) -->
                            <div id="ewallet_selection" class="mb-3" style="display: none;">
                                <label for="ewallet" class="form-label">Pilih E-Wallet</label>
                                <select class="form-select" name="ewallet" id="ewallet">
                                    <option value="">Pilih E-Wallet</option>
                                    <option value="GoPay" {{ old('ewallet') === 'GoPay' ? 'selected' : '' }}>GoPay</option>
                                    <option value="OVO" {{ old('ewallet') === 'OVO' ? 'selected' : '' }}>OVO</option>
                                    <option value="DANA" {{ old('ewallet') === 'DANA' ? 'selected' : '' }}>DANA</option>
                                    <option value="ShopeePay" {{ old('ewallet') === 'ShopeePay' ? 'selected' : '' }}>ShopeePay</option>
                                </select>
                            </div>

                            <!-- Order Summary -->
                            <div class="card border-0 shadow-sm mb-5" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
                                <div class="card-body p-4">
                                    <h5 class="fw-bold mb-4 d-flex align-items-center">
                                        <i class="fas fa-receipt me-2" style="color: #FF5733;"></i>
                                        Ringkasan Pesanan
                                    </h5>
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <div>
                                            <h6 class="mb-1">{{ $plakat->nama }}</h6>
                                            <small class="text-muted">Qty: <span id="summary-quantity">1</span> x Rp {{ number_format($plakat->harga, 0, ',', '.') }}</small>
                                        </div>
                                        <span class="fw-semibold" id="summary-subtotal">Rp {{ number_format($plakat->harga, 0, ',', '.') }}</span>
                                    </div>
                                    <hr class="my-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h5 class="fw-bold mb-0">Total Pembayaran</h5>
                                        <h4 class="fw-bold mb-0" style="color: #FF5733;" id="summary-total">Rp {{ number_format($plakat->harga, 0, ',', '.') }}</h4>
                                    </div>
                                </div>
                            </div>

                            <div class="d-grid gap-3">
                                <button type="submit" class="btn btn-lg py-3 fw-bold text-white border-0 rounded-4" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);">
                                    <i class="fas fa-shopping-cart me-2"></i>
                                    Proses Pesanan Sekarang
                                </button>
                                <a href="{{ url('/') }}" class="btn btn-outline-secondary btn-lg py-3 fw-semibold rounded-4">
                                    <i class="fas fa-arrow-left me-2"></i>
                                    Kembali ke Beranda
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <style>
        .payment-method {
            cursor: pointer;
            transition: all 0.3s ease;
            border: 2px solid #dee2e6;
        }
        .payment-method:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
            border-color: #FF5733;
        }
        .payment-method.selected {
            border-color: #FF5733 !important;
            background: linear-gradient(135deg, #fff5f5 0%, #ffe8e8 100%);
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(255, 87, 51, 0.3);
        }
        .payment-method.selected .payment-icon {
            color: #FF5733 !important;
        }
        .upload-area:hover {
            border-color: #FF5733 !important;
            background-color: #fff5f5 !important;
        }
        .form-control:focus {
            border-color: #FF5733;
            box-shadow: 0 0 0 0.2rem rgba(255, 87, 51, 0.25);
        }
        .input-group-text {
            border-color: #dee2e6;
        }
        .form-control {
            border-color: #dee2e6;
        }
        .cursor-pointer {
            cursor: pointer;
        }
        .btn:hover {
            transform: translateY(-2px);
        }
        .position-relative textarea.form-control {
            padding-left: 3rem !important;
        }
        .position-relative .position-absolute {
            pointer-events: none;
            z-index: 5;
        }
        textarea.form-control:focus + .position-absolute i,
        .position-relative:focus-within .position-absolute i {
            color: #FF5733 !important;
        }
    </style>

    <script>
        // Price and quantity variables
        const unitPrice = {{ $plakat->harga }};
        
        function selectPaymentMethod(method) {
            // Clear all selections
            document.querySelectorAll('.payment-method').forEach(el => el.classList.remove('selected'));
            document.querySelectorAll('input[name="metode_pembayaran"]').forEach(el => el.checked = false);
            
            // Select the clicked method
            document.getElementById(method).checked = true;
            document.getElementById(method).closest('.payment-method').classList.add('selected');
            
            // Show/hide relevant fields
            document.getElementById('bank_selection').style.display = method === 'transfer_bank' ? 'block' : 'none';
            document.getElementById('ewallet_selection').style.display = method === 'e_wallet' ? 'block' : 'none';
        }

        function changeQuantity(change) {
            const quantityInput = document.getElementById('quantity');
            let currentQuantity = parseInt(quantityInput.value);
            let newQuantity = currentQuantity + change;
            
            // Ensure quantity stays within bounds
            if (newQuantity < 1) newQuantity = 1;
            if (newQuantity > 100) newQuantity = 100;
            
            quantityInput.value = newQuantity;
            updateTotal();
        }

        function updateTotal() {
            const quantity = parseInt(document.getElementById('quantity').value) || 1;
            const total = unitPrice * quantity;
            
            // Update hidden inputs
            document.getElementById('total_harga_input').value = total;
            document.getElementById('quantity_input').value = quantity;
            
            // Update summary displays
            document.getElementById('summary-quantity').textContent = quantity;
            document.getElementById('summary-subtotal').textContent = 'Rp ' + total.toLocaleString('id-ID');
            document.getElementById('summary-total').textContent = 'Rp ' + total.toLocaleString('id-ID');
            
            // Update button states
            const minusBtn = document.getElementById('btn-minus');
            const plusBtn = document.getElementById('btn-plus');
            
            minusBtn.disabled = quantity <= 1;
            plusBtn.disabled = quantity >= 100;
        }

        function formatRupiah(amount) {
            return 'Rp ' + amount.toLocaleString('id-ID');
        }

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            const selectedMethod = document.querySelector('input[name="metode_pembayaran"]:checked');
            if (selectedMethod) {
                selectPaymentMethod(selectedMethod.value);
            }
            
            // Initialize quantity controls
            updateTotal();
            
            // Add event listener for manual quantity input
            document.getElementById('quantity').addEventListener('input', function() {
                let value = parseInt(this.value);
                if (isNaN(value) || value < 1) {
                    this.value = 1;
                } else if (value > 100) {
                    this.value = 100;
                }
                updateTotal();
            });
        });
    </script>
</body>
</html>