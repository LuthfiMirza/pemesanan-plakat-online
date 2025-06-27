# 🏆 Sistem Pemesanan Plakat Online - Agung Citra Sukses Abadi

Sistem pemesanan plakat online yang dibangun dengan Laravel 11 dan Filament 3. Aplikasi ini memungkinkan pelanggan untuk memesan plakat secara online dan admin untuk mengelola pesanan dengan mudah.

## 📋 Daftar Isi

- [Update Terbaru](#-update-terbaru)
- [Fitur Utama](#-fitur-utama)
- [Teknologi yang Digunakan](#-teknologi-yang-digunakan)
- [Persyaratan Sistem](#-persyaratan-sistem)
- [Instalasi](#-instalasi)
- [Konfigurasi](#-konfigurasi)
- [Penggunaan](#-penggunaan)
- [Struktur Database](#-struktur-database)
- [API Endpoints](#-api-endpoints)
- [Admin Panel](#-admin-panel)
- [Deployment](#-deployment)
- [Kontribusi](#-kontribusi)
- [Lisensi](#-lisensi)

## 🆕 Update Terbaru

### Version 2.1.0 - Enhanced Admin Experience & Real-time Features

#### 🚀 Fitur Baru Admin Panel
- **Real-time Transaction Monitoring**: Auto-refresh setiap 5 detik untuk monitoring pesanan real-time
- **Enhanced Payment Verification**: Modal interaktif untuk approve/reject pembayaran dengan alasan
- **Payment Proof Viewer**: Modal khusus untuk melihat bukti pembayaran dalam ukuran penuh
- **Smart Navigation Badges**: Badge notifikasi dengan tooltip informatif untuk pesanan pending
- **Admin Notes System**: Sistem catatan otomatis untuk tracking semua aksi admin
- **Improved Tab System**: Tab dengan badge dinamis dan ikon yang informatif

#### 💡 Peningkatan User Experience
- **Auto-refresh Payment Status**: Halaman sukses pembayaran auto-refresh setiap 10 detik
- **Enhanced File Upload**: Validasi file yang lebih ketat dengan feedback yang jelas
- **Real-time Status Updates**: Status pesanan diperbarui secara real-time
- **Better Error Handling**: Pesan error yang lebih informatif dan user-friendly
- **Improved UI/UX**: Interface yang lebih modern dan responsif

#### 🔧 Technical Improvements
- **API Endpoint**: `/api/payment/status/{id}` untuk checking status pembayaran
- **Enhanced Logging**: Logging yang lebih detail untuk debugging
- **Better File Validation**: Validasi file upload yang lebih robust
- **Performance Optimization**: Caching untuk badge counts dan polling optimization
- **Security Enhancements**: Validasi yang lebih ketat untuk file upload

#### 🎨 UI/UX Enhancements
- **Modern Modal Design**: Modal dengan design yang lebih modern dan user-friendly
- **Loading States**: Loading indicators untuk semua aksi async
- **Toast Notifications**: Notifikasi yang lebih elegant dengan Filament notifications
- **Responsive Design**: Optimasi untuk semua ukuran layar
- **Icon Improvements**: Penggunaan ikon yang lebih konsisten dan informatif

## 🚀 Fitur Utama

### 👥 Untuk Pelanggan
- **Katalog Produk**: Melihat berbagai jenis plakat dengan filter dan pencarian
- **Pemesanan Online**: Proses pemesanan yang mudah dan intuitif
- **Upload Design**: Upload file design custom untuk plakat
- **Multiple Payment**: Mendukung transfer bank, e-wallet, dan COD
- **Upload Bukti Pembayaran**: Upload bukti transfer untuk verifikasi dengan validasi
- **Real-time Status Updates**: Status pesanan diperbarui otomatis setiap 10 detik
- **Auto-refresh Payment Status**: Halaman sukses pembayaran auto-refresh untuk status terbaru
- **Enhanced File Upload**: Validasi file yang lebih ketat dan user-friendly
- **Tracking Pesanan**: Melihat status pesanan real-time
- **Invoice Digital**: Generate invoice otomatis dengan nomor invoice unik
- **Riwayat Pesanan**: Melihat semua pesanan yang pernah dibuat

### 🔧 Untuk Admin
- **Dashboard Analytics**: Statistik penjualan dan pesanan
- **Manajemen Produk**: CRUD plakat dengan upload gambar
- **Manajemen Pesanan**: Kelola status pesanan dengan filter tabs
- **Manajemen User**: Kelola pengguna dan role
- **Verifikasi Pembayaran**: Approve/reject bukti pembayaran dengan modal
- **Real-time Updates**: Auto-refresh setiap 5 detik untuk monitoring pesanan
- **Payment Proof Viewer**: Modal untuk melihat bukti pembayaran
- **Admin Notes**: Catatan admin untuk setiap transaksi
- **Navigation Badges**: Badge notifikasi untuk pesanan pending
- **Laporan Penjualan**: Export laporan dalam berbagai format
- **Notifikasi Real-time**: Alert untuk pesanan baru

## 🛠 Teknologi yang Digunakan

### Backend
- **Laravel 11** - PHP Framework
- **Filament 3** - Admin Panel
- **MySQL** - Database
- **Laravel Sanctum** - Authentication

### Frontend
- **Bootstrap 5** - CSS Framework
- **JavaScript** - Interaktivitas
- **Font Awesome** - Icons
- **Google Fonts** - Typography

### Tools & Libraries
- **Composer** - PHP Package Manager
- **NPM** - Node Package Manager
- **Laravel Mix** - Asset Compilation
- **Carbon** - Date Manipulation

## 📋 Persyaratan Sistem

- PHP >= 8.2
- Composer
- Node.js & NPM
- MySQL >= 8.0
- Apache/Nginx Web Server
- Git

## 🔧 Instalasi

### 1. Clone Repository

```bash
git clone https://github.com/LuthfiMirza/pemesanan-plakat-online.git
cd pemesanan-plakat-online
```

### 2. Install Dependencies

```bash
# Install PHP dependencies
composer install

# Install Node dependencies
npm install
```

### 3. Environment Setup

```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 4. Database Setup

```bash
# Create database (MySQL)
mysql -u root -p
CREATE DATABASE plakat_db;
exit

# Run migrations
php artisan migrate

# Run seeders
php artisan db:seed
```

### 5. Storage Setup

```bash
# Create storage link
php artisan storage:link

# Set permissions (Linux/Mac)
chmod -R 775 storage
chmod -R 775 bootstrap/cache
```

### 6. Build Assets

```bash
# Compile assets
npm run build
```

### 7. Start Development Server

```bash
php artisan serve
```

Aplikasi akan berjalan di `http://localhost:8000`

## ⚙️ Konfigurasi

### Database Configuration (.env)

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=plakat_db
DB_USERNAME=root
DB_PASSWORD=
```

### Mail Configuration (.env)

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-email@gmail.com
MAIL_FROM_NAME="${APP_NAME}"
```

### File Storage Configuration

```env
FILESYSTEM_DISK=public
```

## 📖 Penggunaan

### Akses Admin Panel

1. Buka `http://localhost:8000/admin`
2. Login dengan kredensial admin:
   - **Email**: admin@example.com
   - **Password**: password

### Akses Website Publik

1. Buka `http://localhost:8000`
2. Registrasi akun baru atau login
3. Browse produk dan buat pesanan

### User Roles

- **Admin**: Akses penuh ke admin panel
- **User**: Akses ke website publik dan dashboard user

## 🗄️ Struktur Database

### Tabel Utama

#### users
- id, name, email, password, role, email_verified_at

#### plakats
- id, nama, deskripsi, harga, gambar, kategori, status

#### transactions
- id, plakat_id, nama_pembeli, email, no_telepon, alamat
- design_file, catatan_design, quantity, unit_price, total_harga
- metode_pembayaran, bank, ewallet, bukti_pembayaran
- status_pembayaran, invoice_number, admin_notes

### Relasi Database

```
users (1) -----> (n) transactions
plakats (1) -----> (n) transactions
```

## 🌐 API Endpoints

### Public Routes
```
GET  /                     # Homepage
GET  /product              # Product catalog
GET  /about                # About page
GET  /contact              # Contact page
POST /contact              # Contact form submission
```

### Authentication Routes
```
GET  /login                # Login form
POST /login                # Login process
GET  /register             # Register form
POST /register             # Register process
POST /logout               # Logout
```

### Payment Routes
```
GET  /pembayaran/{id}           # Payment form
POST /payment/process           # Process payment
GET  /payment/upload/{id}       # Upload proof form
POST /payment/upload/{id}       # Upload proof process
GET  /payment/success/{id}      # Payment success page
GET  /api/payment/status/{id}   # Get payment status (AJAX)
```

### User Dashboard Routes (Auth Required)
```
GET  /dashboard            # User dashboard
GET  /order-history        # Order history
GET  /invoice/{id}         # View invoice
```

### Admin Routes (Admin Role Required)
```
GET  /admin                # Admin panel
GET  /admin/plakats        # Manage products
GET  /admin/transactions   # Manage orders
GET  /admin/users          # Manage users
```

## 🔐 Admin Panel

### Dashboard Features

#### 📊 Analytics Dashboard
- Total pesanan hari ini
- Total revenue
- Pesanan pending
- Grafik penjualan bulanan

#### 🏷️ Manajemen Produk (Plakat)
- **Create**: Tambah produk baru dengan upload gambar
- **Read**: Lihat daftar semua produk
- **Update**: Edit informasi produk
- **Delete**: Hapus produk
- **Filter**: Filter berdasarkan kategori dan status

#### 📦 Manajemen Transaksi
- **Real-time Polling**: Auto-refresh setiap 5 detik untuk monitoring real-time
- **Filter Tabs dengan Badge**: 
  - Semua Transaksi (dengan total count)
  - Menunggu Pembayaran (dengan warning badge)
  - Dibayar (dengan success badge)
- **Advanced Filters**:
  - Status pembayaran
  - Metode pembayaran
  - Produk plakat
  - Range harga
  - Range tanggal
  - Status bukti pembayaran
- **Enhanced Actions**:
  - **View Detail**: Modal detail pesanan lengkap
  - **View Payment Proof**: Modal untuk melihat bukti pembayaran
  - **Approve Payment**: Terima pembayaran dengan konfirmasi
  - **Reject Payment**: Tolak pembayaran dengan alasan
  - **Edit**: Edit detail pesanan
  - **Admin Notes**: Catatan otomatis untuk setiap aksi admin
- **Navigation Badge**: Badge notifikasi untuk pesanan pending dengan tooltip

#### 👥 Manajemen User
- **Filter Tabs**:
  - Semua Pengguna
  - User
  - Admin
  - Terverifikasi
  - Belum Terverifikasi
- **User Management**:
  - Create/Edit/Delete users
  - Change user roles
  - Email verification status

### Admin Credentials

Default admin account:
- **Email**: admin@example.com
- **Password**: password

## 🚀 Deployment

### Production Setup

1. **Server Requirements**
   - PHP 8.2+
   - MySQL 8.0+
   - Nginx/Apache
   - SSL Certificate

2. **Environment Configuration**
   ```env
   APP_ENV=production
   APP_DEBUG=false
   APP_URL=https://yourdomain.com
   ```

3. **Optimization Commands**
   ```bash
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   php artisan optimize
   ```

4. **File Permissions**
   ```bash
   chmod -R 755 /path/to/your/project
   chmod -R 775 storage bootstrap/cache
   chown -R www-data:www-data /path/to/your/project
   ```

### Nginx Configuration

```nginx
server {
    listen 80;
    server_name yourdomain.com;
    root /path/to/your/project/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

## 🔄 Workflow Pemesanan

### 1. Customer Journey
```
Browse Products → Select Product → Fill Order Form → 
Upload Design → Choose Payment → Upload Proof → 
Wait Verification → Order Confirmed → Receive Product
```

### 2. Admin Workflow
```
New Order Alert → Review Order → Verify Payment → 
Update Status → Process Production → Ship Product → 
Mark as Completed
```

### 3. Status Pesanan
- **menunggu_pembayaran**: Pesanan dibuat, menunggu pembayaran
- **menunggu_verifikasi**: Bukti pembayaran diupload, menunggu verifikasi admin
- **dibayar**: Pembayaran terverifikasi, pesanan diproses
- **ditolak**: Pembayaran ditolak

## 📱 Responsive Design

Website ini fully responsive dan mendukung:
- **Desktop**: 1200px+
- **Tablet**: 768px - 1199px
- **Mobile**: 320px - 767px

## 🔒 Security Features

- **CSRF Protection**: Laravel CSRF tokens
- **SQL Injection Prevention**: Eloquent ORM
- **XSS Protection**: Blade templating
- **Authentication**: Laravel Sanctum
- **File Upload Validation**: Image type & size validation
- **Role-based Access Control**: Admin/User roles

## 🧪 Testing

```bash
# Run all tests
php artisan test

# Run specific test
php artisan test --filter=ProductTest

# Generate coverage report
php artisan test --coverage
```

## 📝 Logging

Logs tersimpan di `storage/logs/laravel.log`

```bash
# View logs
tail -f storage/logs/laravel.log

# Clear logs
> storage/logs/laravel.log
```

## 🔧 Troubleshooting

### Common Issues

1. **Storage Link Error**
   ```bash
   php artisan storage:link
   ```

2. **Permission Denied**
   ```bash
   chmod -R 775 storage bootstrap/cache
   ```

3. **Database Connection Error**
   - Check `.env` database configuration
   - Ensure MySQL service is running

4. **Images Not Showing**
   - Verify storage link exists
   - Check file permissions
   - Ensure images are in correct directory

## 📞 Support

Untuk bantuan dan pertanyaan:
- **Email**: yuda99354@gmail.com
- **Phone**: +62 812-8635-506
- **GitHub Issues**: [Create Issue](https://github.com/LuthfiMirza/pemesanan-plakat-online/issues)

## 🤝 Kontribusi

1. Fork repository
2. Create feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to branch (`git push origin feature/AmazingFeature`)
5. Open Pull Request

## 📄 Lisensi

Distributed under the MIT License. See `LICENSE` for more information.

## 🙏 Acknowledgments

- [Laravel](https://laravel.com) - PHP Framework
- [Filament](https://filamentphp.com) - Admin Panel
- [Bootstrap](https://getbootstrap.com) - CSS Framework
- [Font Awesome](https://fontawesome.com) - Icons

---

**© 2025 Agung Citra Sukses Abadi. All rights reserved.**

---

## 📊 Project Statistics

- **Lines of Code**: ~15,000+
- **Files**: ~200+
- **Database Tables**: 3 main tables
- **Features**: 25+ features
- **Admin Panel Pages**: 10+ pages
- **Public Pages**: 8+ pages

---

*Dibuat dengan ❤️ menggunakan Laravel & Filament*