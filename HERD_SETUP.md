# 🎯 CARA MEMBUKA PROYEK DI HERD

## ❌ Problem yang Mungkin Terjadi

Proyek **afl2** tidak bisa dibuka di Herd karena:
1. **Path folder tidak benar** - Proyek ada di subfolder
2. **Missing .env** - File konfigurasi belum ada
3. **Missing APP_KEY** - Belum generate key
4. **Database belum siap** - Belum migrate

---

## ✅ SOLUSI LENGKAP

### OPSI 1: Ubah Herd Project Path (RECOMMENDED)

#### Langkah 1: Open Project Settings
```
1. Buka Herd
2. Klik nama project "afl2"
3. Pilih "Edit"
```

#### Langkah 2: Change Root Path
```
Dari: C:\Users\ASUS\Downloads\afl2
Ke:   C:\Users\ASUS\Downloads\afl2\afl2
```

#### Langkah 3: Save & Refresh
```
1. Klik "Save"
2. Herd akan auto-detect Laravel project
3. Refresh Herd
```

---

### OPSI 2: Buat Project Baru di Herd

#### Langkah 1: Delete Project Lama (opsional)
```
Klik nama project → "Remove" (pilih keep files)
```

#### Langkah 2: Add Project
```
1. Klik "+ Add Project"
2. Browse ke: C:\Users\ASUS\Downloads\afl2\afl2
3. Klik "Open Folder"
```

#### Langkah 3: Herd akan detect Laravel
```
Herd akan auto-detect:
✅ Laravel framework
✅ PHP version
✅ Database
✅ Port
```

---

### OPSI 3: Manual Setup (jika masih error)

#### Step 1: Create .env
```bash
cd C:\Users\ASUS\Downloads\afl2\afl2
copy .env.example .env
```

#### Step 2: Generate APP_KEY
```bash
php artisan key:generate
```

#### Step 3: Run Migrations
```bash
php artisan migrate
php artisan db:seed --class=AdminSeeder
```

#### Step 4: Setup Herd
```
1. Herd → Add Project
2. Path: C:\Users\ASUS\Downloads\afl2\afl2
3. Click "Open"
```

---

## 📋 CHECKLIST SEBELUM BUKA DI HERD

```
☑ File ada di: C:\Users\ASUS\Downloads\afl2\afl2
☑ artisan file ada
☑ composer.json ada
☑ Laravel 12 project
☑ .env sudah dibuat
☑ APP_KEY sudah di-generate
☑ php artisan migrate sudah dijalankan
☑ Database created
```

---

## ✨ SETELAH OPEN DI HERD

Herd akan:
```
✅ Detect Laravel project
✅ Auto-assign port (usually 8080 or auto)
✅ Create MySQL database
✅ Setup artisan commands
✅ Allow run php artisan commands from UI
✅ Show "serve" button
```

### Start Development
```
1. Klik "Serve" button
2. Herd akan start server
3. Buka browser ke: http://afl2.test atau http://localhost:port
4. Done! 🎉
```

---

## 🔍 VERIFY INSTALLATION

### Check di Herd Terminal
```bash
php artisan --version
# Should show: Laravel Framework 12.x.x

php -v
# Should show your PHP version

php artisan migrate:status
# Should show all migrations as "Ran"
```

### Test Routes
```
✅ GET http://afl2.test/                    (Home)
✅ GET http://afl2.test/login               (Login form)
✅ GET http://afl2.test/products            (Products)
✅ GET http://afl2.test/admin/dashboard     (Admin - akan redirect ke login)
```

---

## 🆘 TROUBLESHOOTING

### Error: "Not a Laravel project"
```
Solution:
1. Check path: C:\Users\ASUS\Downloads\afl2\afl2
2. Verify artisan file exists
3. Verify composer.json exists
4. Remove project, add again
```

### Error: "Database connection failed"
```
Solution:
1. php artisan migrate
2. Check .env DB_CONNECTION=sqlite
3. Ensure database/database.sqlite exists
4. Restart Herd
```

### Error: "Ports already in use"
```
Solution:
1. Change port in Herd settings
2. Or kill process: netstat -ano | findstr :8000
3. Restart Herd
```

### Error: "php artisan commands don't work"
```
Solution:
1. Ensure PHP path correct in Herd
2. Right-click project → "Refresh PHP"
3. Restart Herd
```

---

## 📚 USEFUL HERD COMMANDS

### Open Terminal
```
Click project → Terminal
```

### Common Commands
```bash
php artisan serve                 # Start server
php artisan migrate               # Run migrations
php artisan tinker                # PHP REPL
php artisan db:seed               # Run seeders
npm run dev                        # Build assets
php -S localhost:8000             # Quick server
```

---

## 🌐 URL STRUCTURE

### Local Development (Herd)
```
Base URL:
- http://afl2.test           (if Herd auto-assigns)
- http://localhost:8000       (fallback)

Routes:
- /                           Home
- /login                       Login form
- /register                    Register form
- /products                    Products list
- /admin/dashboard             Admin panel
- /cart                        Shopping cart
```

---

## ✅ FINAL CHECKLIST

```
☑ Project path: C:\Users\ASUS\Downloads\afl2\afl2
☑ .env file created
☑ APP_KEY generated
☑ Database migrated
☑ Admin user seeded
☑ Herd project added
☑ Can access home page
☑ Can login with admin@example.com
☑ Can add products to cart
```

---

## 🎉 SIAP!

Proyek sudah siap dibuka di Herd!
Tinggal ikuti langkah di atas dan semuanya akan lancar.

---

**Last Updated: 16 November 2025**

Jika masih ada masalah, pastikan:
1. ✅ Path folder benar
2. ✅ .env dan artisan ada
3. ✅ PHP version compatible
4. ✅ MySQL/SQLite ready
5. ✅ Herd restarted
