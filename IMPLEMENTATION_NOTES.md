# Dokumentasi Implementasi - Sistem Login, CRUD & Cart

## 📋 Fitur yang Sudah Diimplementasikan

### ✅ Authentication System
- **Login** - Users dapat login dengan email dan password
- **Register** - Users dapat membuat akun baru (default role: user)
- **Logout** - Users dapat logout
- **Role-based Access** - 3 tipe user:
  - **Admin** - Akses penuh ke semua fitur CRUD
  - **User** - Bisa berbelanja dan checkout
  - **Guest** - Hanya bisa melihat produk (tanpa login)

### ✅ CRUD Operations
Semua tabel memiliki CRUD lengkap (Create, Read, Update, Delete):
- **Products** - Dengan fitur upload image
- **Categories** - Kelola kategori produk
- **Services** - Kelola layanan
- **Users** - Kelola user accounts

### ✅ Shopping Cart
- **Add to Cart** - Users bisa tambah item ke keranjang
- **View Cart** - Lihat semua item di keranjang
- **Update Quantity** - Ubah jumlah item
- **Remove Item** - Hapus item dari keranjang
- **Clear Cart** - Kosongkan semua keranjang

### ✅ Image Upload
- **Product Images** - Upload gambar saat create/edit product
- **File Storage** - Disimpan di `public/assets/images/`
- **Automatic Cleanup** - Gambar lama otomatis dihapus saat update

---

## 🚀 Setup & Instalasi

### 1. **Copy .env dari .env.example** (jika belum ada)
```bash
cp .env.example .env
```

### 2. **Generate APP_KEY**
```bash
php artisan key:generate
```

### 3. **Jalankan Migrations** (untuk membuat/update tables)
```bash
php artisan migrate
```

### 4. **Siap Digunakan!**

---

## 📱 Fitur Login

### Halaman Login
- URL: `/login`
- Field: Email, Password, Remember me checkbox
- Button: Login

### Halaman Register
- URL: `/register`
- Field: Name, Email, Password, Password Confirmation
- Button: Register
- Default Role: `user`

### Logout
- Klik tombol Logout di navbar
- Route: `/logout` (POST)

---

## 👨‍💼 Admin Dashboard

### Akses Admin
- URL: `/admin/dashboard`
- **Hanya accessible oleh users dengan role `admin`**
- Redirect otomatis ke login jika bukan admin

### Menu Admin

#### 1. **Kelola Produk** (`/admin/products`)
- **List** - Lihat semua produk dengan pagination
- **Create** - Tambah produk baru
  - Fields: Kategori, Nama, Harga, Deskripsi Singkat, Deskripsi Lengkap, Image
  - Image auto-saved ke: `public/assets/images/`
- **Edit** - Edit produk (image bisa diubah atau dikosongkan)
- **Show** - Lihat detail produk
- **Delete** - Hapus produk (beserta gambarnya)

#### 2. **Kelola Kategori** (`/admin/categories`)
- **List** - Lihat semua kategori + jumlah produk
- **Create** - Tambah kategori baru
- **Edit** - Edit nama kategori
- **Show** - Lihat detail kategori
- **Delete** - Hapus kategori

#### 3. **Kelola Layanan** (`/admin/services`)
- **List** - Lihat semua layanan
- **Create** - Tambah layanan
  - Fields: Nama, Icon (Font Awesome class), Deskripsi
- **Edit** - Edit layanan
- **Show** - Lihat detail layanan
- **Delete** - Hapus layanan

#### 4. **Kelola User** (`/admin/users`)
- **List** - Lihat semua user dengan role badge
- **Create** - Tambah user baru dengan role tertentu
- **Edit** - Edit user (name, email, role, password optional)
- **Show** - Lihat detail user
- **Delete** - Hapus user

---

## 🛒 Shopping Cart & Checkout

### Untuk Users yang Sudah Login

#### 1. **Add to Cart**
- Klik tombol "Tambah ke Keranjang" di halaman produk
- Quantity bisa disesuaikan
- Auto-create cart jika belum ada

#### 2. **View Cart**
- URL: `/cart`
- Lihat semua item + total harga
- Bisa ubah quantity setiap item
- Bisa hapus item individual
- Bisa clear semua isi keranjang

#### 3. **Checkout**
- Button "Checkout" di halaman cart (ready untuk next phase)

#### Non-Login Users
- Diminta login dulu sebelum add to cart
- Dapat view produk tanpa login (guest access)

---

## 📁 Struktur File Baru

### Controllers
```
app/Http/Controllers/
├── AuthController.php                 # Login, Register, Logout
├── CartController.php                 # Cart operations
└── Admin/
    ├── ProductController.php          # CRUD Products
    ├── CategoryController.php         # CRUD Categories
    ├── ServiceController.php          # CRUD Services
    └── UserController.php             # CRUD Users
```

### Models
```
app/Models/
├── Cart.php                           # Cart model
└── CartItem.php                       # Cart items
```

### Middleware
```
app/Http/Middleware/
├── IsAdmin.php                        # Check admin role
└── IsUser.php                         # Check auth
```

### Views
```
resources/views/
├── auth/
│   ├── login.blade.php
│   └── register.blade.php
├── admin/
│   ├── dashboard.blade.php
│   ├── products/          # Create, Edit, Index, Show
│   ├── categories/        # Create, Edit, Index, Show
│   ├── services/          # Create, Edit, Index, Show
│   └── users/             # Create, Edit, Index, Show
└── cart/
    └── index.blade.php
```

### Migrations
```
database/migrations/
├── 2025_11_16_000000_add_role_to_users_table.php
├── 2025_11_16_000001_add_image_to_products_table.php
└── 2025_11_16_000002_create_carts_and_cart_items_tables.php
```

---

## 🔐 Database Schema

### Users Table (Updated)
```
- id
- name
- email
- password
- role (enum: 'admin', 'user')
- timestamps
```

### Products Table (Updated)
```
- id
- category_id
- name
- slug
- price
- image (NEW!)
- short_description
- long_description
- timestamps
```

### Carts Table (NEW!)
```
- id
- user_id (FK)
- total_price
- timestamps
```

### CartItems Table (NEW!)
```
- id
- cart_id (FK)
- product_id (FK)
- quantity
- price
- timestamps
```

---

## 🌐 Routes Overview

### Public Routes
```
GET  /                           Home
GET  /products                   Produk list
GET  /products/{id}              Detail produk
GET  /service                    Layanan
```

### Auth Routes
```
GET  /login                      Login form
POST /login                      Process login
GET  /register                   Register form
POST /register                   Process register
POST /logout                     Process logout
```

### User Routes (Protected)
```
GET  /cart                       View cart
POST /cart/add                   Add item
PUT  /cart-item/{id}             Update qty
DELETE /cart-item/{id}           Remove item
POST /cart/clear                 Clear cart
```

### Admin Routes (Protected + Admin Only)
```
GET  /admin/dashboard                      Dashboard
GET|POST    /admin/products                List, Create
GET|PUT|DELETE /admin/products/{product}   Show, Edit, Delete
GET|POST    /admin/categories              List, Create
GET|PUT|DELETE /admin/categories/{cat}     Show, Edit, Delete
GET|POST    /admin/services                List, Create
GET|PUT|DELETE /admin/services/{service}   Show, Edit, Delete
GET|POST    /admin/users                   List, Create
GET|PUT|DELETE /admin/users/{user}         Show, Edit, Delete
```

---

## 🎯 Testing

### Test Admin Login
1. Buka `/admin/dashboard`
2. Redirect ke `/login`
3. Login dengan email admin, password admin
4. Seharusnya bisa akses admin dashboard

### Test User Signup & Cart
1. Kunjungi `/register`
2. Daftar akun baru
3. Otomatis login dengan role `user`
4. Ke halaman produk
5. Klik "Tambah ke Keranjang"
6. Lihat di `/cart`

### Test Image Upload
1. Admin ke `/admin/products/create`
2. Upload gambar
3. Simpan
4. Gambar tersimpan di `public/assets/images/`
5. Tampil di list produk

---

## ⚠️ Catatan Penting

1. **Middleware Registered** ✅
   - `is_admin` - Check admin role
   - `is_user` - Check auth

2. **Password Hashing** ✅
   - Semua password auto di-hash dengan bcrypt

3. **CSRF Protection** ✅
   - Semua form sudah include `@csrf`

4. **Image Upload Directory** ✅
   - Sudah ada di `public/assets/images/`
   - Pastikan writable

5. **SESSION_DRIVER** ✅
   - Set ke `database` di `.env`
   - Tables: sessions, password_reset_tokens

---

## 🔄 Database Session (jika belum)

Jika ingin menggunakan database untuk session:

```bash
php artisan session:table
php artisan migrate
```

---

## 💡 Next Phase (Optional)

1. **Payment Integration** - Tambah payment gateway
2. **Order Management** - Track pesanan user
3. **Email Notifications** - Send email setelah order
4. **Product Reviews** - Rating & komentar produk
5. **Wishlist** - User bisa save favorit
6. **Search & Filter** - Cari produk lebih mudah

---

## 📞 Support

Semua fitur sudah terintegrasi dan ready to use!
Jika ada pertanyaan atau perlu modifikasi, silakan hubungi.

**Versi: 1.0**
**Last Updated: 16 Nov 2025**
