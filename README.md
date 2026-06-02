# Product Catalog — Enterprise QR-Scan Website

Katalog produk premium dengan desain minimalis dan mewah, dioptimasi untuk akses cepat melalui scan QR Code oleh konsumen enterprise.

![Laravel](https://img.shields.io/badge/Laravel-13-FF2D20?style=flat-square&logo=laravel&logoColor=white)
![Filament](https://img.shields.io/badge/Filament-5-FDAE4B?style=flat-square)
![PHP](https://img.shields.io/badge/PHP-8.3+-777BB4?style=flat-square&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?style=flat-square&logo=mysql&logoColor=white)

---

## Features

- **Admin Dashboard** — Filament v5, CRUD produk & user, role management
- **Image Optimization** — Auto-compress & convert ke WebP saat upload
- **Multi-User** — Super Admin, Admin, dan User roles
- **Premium Frontend** — Clean grid, lightbox modal, micro-animations
- **QR-Ready** — Dioptimasi untuk loading instan via QR code scan
- **Responsive** — 2 kolom (mobile) → 3 kolom (tablet) → 4 kolom (desktop)

---

## Requirements

- **PHP** >= 8.3
- **Composer** >= 2.0
- **MySQL** >= 8.0
- **Node.js** >= 18 (untuk Vite, opsional)
- **GD** atau **Imagick** PHP extension (untuk image optimization)

---

## Installation

### 1. Clone & Install Dependencies

```bash
cd azure-shuttle
composer install
```

### 2. Environment Setup

```bash
cp .env.example .env
php artisan key:generate
```

Edit `.env` dan sesuaikan konfigurasi database:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=product_catalog
DB_USERNAME=root
DB_PASSWORD=your_password
```

### 3. Create Database

```sql
CREATE DATABASE product_catalog CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 4. Run Migrations & Seed

```bash
php artisan migrate
php artisan db:seed
php artisan storage:link
```

### 5. Filament Shield Setup

```bash
php artisan shield:install
php artisan shield:generate --all
```

### 6. Start Development Server

```bash
php artisan serve
```

---

## Access

| URL | Keterangan |
|-----|-----------|
| `http://localhost:8000` | **Frontend Catalog** — halaman publik |
| `http://localhost:8000/admin` | **Admin Dashboard** — panel admin |

### Default Users (from seeder)

| Email | Password | Role |
|-------|----------|------|
| `admin@admin.com` | `password` | Super Admin |
| `admin@catalog.com` | `password` | Admin |
| `user@catalog.com` | `password` | User |

---

## Project Structure

```
azure-shuttle/
├── app/
│   ├── Filament/Resources/
│   │   ├── ProductResource.php          # CRUD Produk
│   │   ├── ProductResource/Pages/       # List, Create, Edit pages
│   │   ├── UserResource.php             # CRUD Pengguna
│   │   └── UserResource/Pages/          # List, Create, Edit pages
│   ├── Http/Controllers/
│   │   └── CatalogController.php        # Frontend controller
│   ├── Models/
│   │   ├── Product.php                  # Model produk
│   │   └── User.php                     # Model user + roles
│   ├── Providers/Filament/
│   │   └── AdminPanelProvider.php       # Filament panel config
│   └── Services/
│       └── ImageOptimizer.php           # Auto image compression
├── database/
│   ├── migrations/                      # Schema migrations
│   └── seeders/
│       └── DatabaseSeeder.php           # Default roles & users
├── resources/views/
│   ├── layouts/app.blade.php            # Base layout + design system
│   └── catalog/index.blade.php          # Frontend catalog view
├── routes/web.php                       # Public routes
├── composer.json                        # PHP dependencies
├── .env.example                         # Environment template
└── README.md                            # This file
```

---

## Image Optimization

Saat foto produk di-upload via admin dashboard:

1. **Read** — Intervention Image membaca file original
2. **Resize** — Scale down ke max 1600px width (aspect ratio terjaga)
3. **Compress** — Encode ke WebP dengan quality 80%
4. **Save** — Simpan ke `storage/app/public/products/`
5. **Track** — Ukuran file (KB) dicatat di database

Hasil: File 25-35% lebih kecil dari JPEG, loading instan via QR scan.

---

## Roles & Permissions

| Role | Products | Users |
|------|----------|-------|
| **Super Admin** | Full CRUD | Full CRUD |
| **Admin** | Full CRUD | View only |
| **User** | View only | — |

---

## Design Philosophy

- **Apple/Rolex-inspired** — minimalis, premium whitespace
- **No clutter** — hanya foto, tanpa deskripsi/harga
- **Anti-gravity micro-interactions** — fade-in-up on scroll, smooth scale on hover
- **Immersive lightbox** — 92% opacity dark overlay, smooth transitions
- **Performance-first** — WebP images, lazy loading, minimal CSS/JS

---

## License

MIT License
