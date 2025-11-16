# 🚀 CARA MENJALANKAN & LOGIN

## ✅ STATUS APLIKASI

Aplikasi Anda **sudah siap 100%**! 
Database sudah di-setup dengan seed data (admin & user).

---

## 📋 LANGKAH MENJALANKAN

### 1️⃣ BUKA TERMINAL/CMD

**Windows (PowerShell/CMD):**
```bash
# Navigasi ke folder project
cd c:\Users\ASUS\Downloads\afl2\afl2
```

**atau gunakan VS Code terminal yang sudah terbuka**

---

### 2️⃣ JALANKAN SERVER

Di terminal, jalankan:
```bash
php artisan serve
```

**Output yang akan Anda lihat:**
```
   INFO  Server running on [http://127.0.0.1:8000].

  Press Ctrl+C to quit
```

**Atau jika port 8000 sudah terpakai, coba:**
```bash
php artisan serve --port=3000
```

Kemudian server akan jalan di: `http://localhost:3000`

---

### 3️⃣ BUKA DI BROWSER

Buka URL berikut di browser Anda:
```
http://localhost:8000
```

Jika port berbeda:
```
http://localhost:3000
```

---

## 🔑 CARA LOGIN

### Pilihan 1: LOGIN SEBAGAI ADMIN ⭐

**URL:** `http://localhost:8000/login`

Gunakan akun ini:
```
Email:    admin@example.com
Password: password123
```

**Setelah login:**
- Akan redirect ke: `/admin/dashboard`
- Anda bisa melihat statistik
- Bisa akses menu CRUD lengkap:
  - ✅ Kelola Produk
  - ✅ Kelola Kategori
  - ✅ Kelola Layanan
  - ✅ Kelola User

---

### Pilihan 2: LOGIN SEBAGAI USER

**URL:** `http://localhost:8000/login`

Gunakan akun ini:
```
Email:    user@example.com
Password: password123
```

**Setelah login:**
- Akan redirect ke: Home `/`
- Anda bisa:
  - ✅ Lihat produk
  - ✅ Add to cart
  - ✅ View cart di `/cart`
  - ✅ Logout

---

### Pilihan 3: DAFTAR AKUN BARU (REGISTER)

**URL:** `http://localhost:8000/register`

**Form yang perlu diisi:**
```
Nama:                    [masukkan nama Anda]
Email:                   [email baru]
Password:                [minimal 6 karakter]
Confirm Password:        [ulangi password]
```

**Setelah register:**
- Akun dibuat dengan role = `user`
- Auto login
- Redirect ke home

---

## 🧪 TEST FEATURES

### Test 1: Admin CRUD Products

```
1. Login dengan admin@example.com
2. Klik "Kelola Produk"
3. Klik "Tambah Produk"
4. Isi form:
   - Kategori: (pilih dari dropdown)
   - Nama: Produk Test
   - Harga: 100000
   - Deskripsi: Test description
   - Upload Gambar: (pilih file .jpg/.png)
5. Klik "Simpan"
6. Produk muncul di list
7. Bisa klik Edit atau Delete
```

### Test 2: Shopping Cart

```
1. Login dengan user@example.com (atau register akun baru)
2. Go to: http://localhost:8000/products
3. Klik produk atau "Tambah ke Keranjang"
4. Masukkan quantity
5. Klik "Tambah"
6. Go to: http://localhost:8000/cart
7. Lihat item di cart
8. Bisa ubah quantity
9. Bisa hapus item
10. Bisa clear cart
```

### Test 3: Categories

```
1. Login as admin
2. Klik "Kelola Kategori"
3. Klik "Tambah Kategori"
4. Isi nama kategori
5. Klik "Simpan"
6. Lihat di list
```

---

## 📍 URL-URL PENTING

### Public Pages
```
http://localhost:8000/              Home
http://localhost:8000/products      Product List
http://localhost:8000/products/1    Product Detail (ganti 1 dengan ID)
http://localhost:8000/service       Services
```

### Authentication
```
http://localhost:8000/login         Login Form
http://localhost:8000/register      Register Form
```

### User Pages (Perlu Login)
```
http://localhost:8000/cart          Shopping Cart
```

### Admin Pages (Perlu Login sebagai Admin)
```
http://localhost:8000/admin/dashboard          Admin Dashboard
http://localhost:8000/admin/products           Manage Products
http://localhost:8000/admin/categories         Manage Categories
http://localhost:8000/admin/services           Manage Services
http://localhost:8000/admin/users              Manage Users
```

---

## ❌ JIKA TIDAK BISA LOGIN

### Error: "Email atau password salah"
**Solution:**
- Pastikan email + password benar
- Email: `admin@example.com` (bukan `admin.example.com`)
- Password: `password123` (case-sensitive)

### Error: "Page not found"
**Solution:**
- Pastikan server running
- Cek URL benar
- Reload page

### Error: "Database connection failed"
**Solution:**
```bash
# Stop server (Ctrl+C)
php artisan migrate
php artisan db:seed --class=AdminSeeder
php artisan serve
```

### Error: "Halaman blank / error"
**Solution:**
```bash
# Clear cache
php artisan cache:clear
php artisan config:clear
php artisan serve
```

---

## 🎯 QUICK START COMMAND

Copy-paste ini ke terminal Anda:

```bash
cd c:\Users\ASUS\Downloads\afl2\afl2 && php artisan serve
```

Kemudian buka: `http://localhost:8000/login`

---

## 📝 CHECKLIST SEBELUM MULAI

```
☑ Terminal dibuka
☑ Sudah di folder: c:\Users\ASUS\Downloads\afl2\afl2
☑ Database migrated (sudah dilakukan)
☑ Seed data created (sudah dilakukan)
☑ Server dijalankan: php artisan serve
☑ Browser siap di: http://localhost:8000
```

---

## 🎊 SIAP LOGIN!

**Akun yang tersedia:**
- **Admin:** admin@example.com / password123
- **User:** user@example.com / password123
- **Atau:** Daftar akun baru di `/register`

**Langkah:**
1. Jalankan: `php artisan serve`
2. Buka: `http://localhost:8000/login`
3. Masukkan email & password
4. Klik "Login"
5. Enjoy! 🚀

---

## 💡 TIPS

### Untuk development:
```bash
# Jalankan di background
php artisan serve

# Di terminal lain, bisa jalankan command:
php artisan tinker
php artisan migrate
npm run dev
```

### Untuk hot reload assets:
```bash
npm run dev
```

### Untuk lihat database via Tinker:
```bash
php artisan tinker
>>> User::all()
>>> Product::all()
```

---

## 🆘 BUTUH BANTUAN?

1. Baca file: `QUICK_START_GUIDE.md`
2. Baca file: `HERD_SETUP.md` (jika setup di Herd)
3. Baca file: `IMPLEMENTATION_NOTES.md` (detail fitur)

---

**SEKARANG MULAI SERVER DAN LOGIN!** 🎉

Jalankan:
```bash
php artisan serve
```

Kemudian: `http://localhost:8000/login`

Gunakan: `admin@example.com` / `password123`

---

**Last Updated: 17 November 2025**
**Status: ✅ READY TO RUN**
