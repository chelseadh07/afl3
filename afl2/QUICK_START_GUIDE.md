# 🚀 QUICK START GUIDE

## ✅ Sudah Siap Pakai!

Semua fitur sudah terinstall dan siap digunakan. Berikut cara memulai:

---

## 📋 Setup Awal (Jika Belum)

### 1. Buat `.env` file
```bash
cp .env.example .env
```

### 2. Generate APP_KEY
```bash
php artisan key:generate
```

### 3. Setup Database
```bash
php artisan migrate
php artisan db:seed --class=AdminSeeder
```

Ini akan membuat:
- ✅ Users table dengan role column
- ✅ Products table dengan image column  
- ✅ Carts & CartItems table
- ✅ Admin user: `admin@example.com` / `password123`
- ✅ Test user: `user@example.com` / `password123`

---

## 🎯 Test Fitur

### Test 1: Login Admin
1. Buka: `http://localhost:8000/login`
2. Email: `admin@example.com`
3. Password: `password123`
4. Akan redirect ke: `/admin/dashboard`

### Test 2: Admin CRUD Products
1. Di dashboard, klik "Kelola Produk"
2. Klik "Tambah Produk"
3. Isi form (termasuk upload image)
4. Simpan
5. Lihat di list produk
6. Bisa Edit/Delete

### Test 3: Register User Baru
1. Buka: `http://localhost:8000/register`
2. Isi form dengan data baru
3. Password minimal 6 karakter
4. Klik Register
5. Auto login dan redirect ke home

### Test 4: Add to Cart
1. Buka: `http://localhost:8000/products`
2. Klik produk, atau langsung "Tambah ke Keranjang"
3. Buka: `http://localhost:8000/cart`
4. Lihat keranjang Anda
5. Bisa ubah qty atau hapus item

---

## 📁 Struktur File BARU

File-file yang dibuat (TIDAK ada yang dihapus/diubah):

```
✅ Controllers Baru:
   - AuthController.php
   - CartController.php
   - Admin/ProductController.php
   - Admin/CategoryController.php
   - Admin/ServiceController.php
   - Admin/UserController.php

✅ Models Baru:
   - Cart.php
   - CartItem.php

✅ Middleware Baru:
   - IsAdmin.php
   - IsUser.php

✅ Views Baru:
   - auth/login.blade.php
   - auth/register.blade.php
   - admin/dashboard.blade.php
   - admin/products/* (4 files)
   - admin/categories/* (4 files)
   - admin/services/* (4 files)
   - admin/users/* (4 files)
   - cart/index.blade.php

✅ Migrations Baru:
   - 2025_11_16_000000_add_role_to_users_table.php
   - 2025_11_16_000002_create_carts_and_cart_items_tables.php

✅ Seeders:
   - AdminSeeder.php

✅ Files:
   - IMPLEMENTATION_NOTES.md (dokumentasi lengkap)
   - QUICK_START_GUIDE.md (file ini)
```

---

## 🔐 User Roles & Access

### 👑 Admin
- URL: `/admin/dashboard`
- Akses: CRUD semua tabel
- View: Admin pages dengan manajemen lengkap
- Password default: `password123`

### 👤 User
- URL: `/` (home normal)
- Akses: Lihat produk + add to cart
- View: User pages + cart
- Bisa register/login

### 👁️ Guest
- URL: `/products` (view only)
- Akses: Hanya lihat produk
- Tidak bisa add to cart (harus login)

---

## 🖼️ Image Upload

### Upload Path
```
public/assets/images/
```

### Supported Formats
- JPG, PNG, GIF
- Max size: 2MB

### Automatic Features
- ✅ Auto-rename file (prevent duplicates)
- ✅ Auto-delete old image saat update
- ✅ Auto-delete image saat delete product

---

## 🌐 URL Routing

### Public
```
/                    - Home
/products            - Produk list
/products/{id}       - Detail produk
/service             - Layanan
```

### Auth
```
/login               - Login form
/register            - Register form
/logout              - Logout
```

### User (Protected)
```
/cart                - View cart
/cart/add            - Add item
```

### Admin (Protected + Admin Only)
```
/admin/dashboard     - Dashboard
/admin/products      - CRUD products
/admin/categories    - CRUD categories
/admin/services      - CRUD services
/admin/users         - CRUD users
```

---

## ⚡ Troubleshooting

### Error: Table doesn't exist
```bash
php artisan migrate
```

### Error: Column already exists
- Database mungkin punya row lama
- Safe: `php artisan migrate:fresh` (HAPUS semua data!)
- Atau manual fix di database

### Image tidak upload
- Pastikan folder `public/assets/images/` writable
- Atau: `chmod -R 755 public/assets/images/`

### Logout tidak bekerja
- Pastikan `.env` `SESSION_DRIVER=database`
- Jalankan: `php artisan session:table && php artisan migrate`

---

## 📚 File Referensi

- **IMPLEMENTATION_NOTES.md** - Dokumentasi lengkap
- **routes/web.php** - Semua routing
- **app/Http/Controllers/** - Controllers
- **resources/views/** - Semua views

---

## ✨ Features Summary

✅ Login/Register System
✅ Role-based Access Control (Admin/User/Guest)
✅ Complete CRUD untuk semua tabel
✅ Shopping Cart dengan add/remove/update
✅ Image upload untuk products
✅ Dashboard admin dengan statistics
✅ Responsive design dengan Bootstrap
✅ Middleware protection
✅ Form validation
✅ Flash messages
✅ Pagination

---

## 🎓 Learning Path

Untuk understand kode:

1. **Routes** → `routes/web.php`
2. **Controllers** → `app/Http/Controllers/`
3. **Models** → `app/Models/`
4. **Views** → `resources/views/`
5. **Middleware** → `app/Http/Middleware/`
6. **Database** → `database/migrations/`

---

## 💬 Notes

- Semua file yang sudah ada TIDAK DIUBAH/DIHAPUS ✅
- Hanya fitur BARU yang ditambah
- Design view yang existing tetap sama
- All changes are backward compatible

---

**Siap digunakan! Happy coding! 🎉**

**Last Updated: 16 November 2025**
