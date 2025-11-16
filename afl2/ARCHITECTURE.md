# 🏗️ ARSITEKTUR SISTEM

## 📊 Database Schema Diagram

```
┌─────────────────────────────────────────────────────────────────┐
│                      DATABASE STRUCTURE                          │
└─────────────────────────────────────────────────────────────────┘

USERS TABLE (Updated)
┌──────────────────────────────────┐
│ id (PK)                          │
│ name                             │
│ email (UNIQUE)                   │
│ password                         │
│ role (ENUM: admin, user) ✨      │
│ remember_token                   │
│ email_verified_at                │
│ created_at, updated_at           │
└──────────────────────────────────┘
         ↓           ↓
      (1:1)       (1:N)
         ↓           ↓
    ┌────────────────────────┐
    │ CARTS (New)            │
    ├────────────────────────┤
    │ id (PK)                │
    │ user_id (FK) ✨        │
    │ total_price            │
    │ created_at, updated_at │
    └────────────────────────┘
              ↓ (1:N)
    ┌────────────────────────┐
    │ CART_ITEMS (New)       │
    ├────────────────────────┤
    │ id (PK)                │
    │ cart_id (FK)           │
    │ product_id (FK)        │
    │ quantity               │
    │ price                  │
    │ created_at, updated_at │
    └────────────────────────┘
              ↓ (N:1)
    ┌────────────────────────┐
    │ PRODUCTS (Updated)     │
    ├────────────────────────┤
    │ id (PK)                │
    │ category_id (FK)       │
    │ name                   │
    │ slug                   │
    │ image ✨               │
    │ price                  │
    │ short_description      │
    │ long_description       │
    │ created_at, updated_at │
    └────────────────────────┘
              ↓ (N:1)
    ┌────────────────────────┐
    │ CATEGORIES             │
    ├────────────────────────┤
    │ id (PK)                │
    │ name                   │
    │ slug                   │
    │ created_at, updated_at │
    └────────────────────────┘

SERVICES
┌────────────────────────┐
│ id (PK)                │
│ name                   │
│ icon                   │
│ description            │
│ created_at, updated_at │
└────────────────────────┘

✨ = New/Updated
```

---

## 🔄 User Flow Diagram

```
┌──────────────────────────────────────────────────────────────┐
│                    GUEST/VISITOR                             │
└──────────────────────────────────────────────────────────────┘
        ↓
        │ Buka Website
        ↓
┌──────────────────────────────────────────────────────────────┐
│                    PUBLIC PAGES                               │
├──────────────────────────────────────────────────────────────┤
│ ✅ Home                                                       │
│ ✅ Products List (View Only)                                 │
│ ✅ Product Detail                                            │
│ ✅ Services                                                  │
│ ❌ Add to Cart (Restricted - Redirect to Login)             │
└──────────────────────────────────────────────────────────────┘
        ↓
        │ Try Add to Cart / Want to Register
        ↓
┌──────────────────────────────────────────────────────────────┐
│                    AUTH PAGES                                 │
├──────────────────────────────────────────────────────────────┤
│ /login                                                       │
│ /register                                                    │
└──────────────────────────────────────────────────────────────┘
        ↓
        ├─── Register ───→ ┌─────────────────────┐
        │                  │ Create User Account │
        │                  │ role = 'user'       │
        │                  └─────────────────────┘
        │                          ↓
        ↓                       Auto Login
        │ Login
        ↓
┌──────────────────────────────────────────────────────────────┐
│                    USER DASHBOARD                             │
├──────────────────────────────────────────────────────────────┤
│ ✅ Home                                                       │
│ ✅ Products List                                              │
│ ✅ Add to Cart                                                │
│ ✅ View Cart                                                  │
│ ✅ Update Cart                                                │
│ ✅ Checkout (Future)                                          │
│ ✅ Logout                                                     │
│ ❌ Admin Panel (Restricted)                                  │
└──────────────────────────────────────────────────────────────┘
        ↓
        │ Shopping Cart
        ↓
┌──────────────────────────────────────────────────────────────┐
│                    CART OPERATIONS                            │
├──────────────────────────────────────────────────────────────┤
│ • Add Item                                                   │
│ • Update Quantity                                            │
│ • Remove Item                                                │
│ • Clear Cart                                                 │
│ • View Total Price                                           │
└──────────────────────────────────────────────────────────────┘

---

┌──────────────────────────────────────────────────────────────┐
│                    ADMIN LOGIN                                │
└──────────────────────────────────────────────────────────────┘
        ↓ admin@example.com / password123
        ↓
┌──────────────────────────────────────────────────────────────┐
│                    ADMIN DASHBOARD                            │
├──────────────────────────────────────────────────────────────┤
│ 📊 Statistics                                                 │
│    - Total Products                                          │
│    - Total Categories                                        │
│    - Total Services                                          │
│    - Total Users                                             │
│ 🔧 Management Menu                                           │
│    - Kelola Produk                                           │
│    - Kelola Kategori                                         │
│    - Kelola Layanan                                          │
│    - Kelola User                                             │
└──────────────────────────────────────────────────────────────┘
        ↓
        ├──→ Products Management
        │    ├─ Create with Image Upload ✨
        │    ├─ Edit & Replace Image ✨
        │    ├─ Delete (Auto cleanup) ✨
        │    └─ List with Pagination
        │
        ├──→ Categories Management
        │    ├─ Create
        │    ├─ Edit
        │    ├─ Delete
        │    └─ List with Product Count
        │
        ├──→ Services Management
        │    ├─ Create
        │    ├─ Edit
        │    ├─ Delete
        │    └─ List
        │
        └──→ Users Management
             ├─ Create with Role
             ├─ Edit (name, email, role, password)
             ├─ Delete
             └─ List with Role Badge
```

---

## 🎯 Request Flow Architecture

```
┌─────────────────────────────────────────────────────────────┐
│                    HTTP REQUEST                              │
└─────────────────────────────────────────────────────────────┘
                           ↓
┌─────────────────────────────────────────────────────────────┐
│                   routes/web.php                             │
│  (Route matching & middleware application)                  │
└─────────────────────────────────────────────────────────────┘
                           ↓
                ┌──────────┴──────────┐
                ↓                     ↓
        ┌───────────────┐    ┌───────────────┐
        │  Middleware   │    │  Middleware   │
        ├───────────────┤    ├───────────────┤
        │ • Auth        │    │ • IsAdmin     │
        │ • CSRF        │    │ • IsUser      │
        │ • Guest       │    │ • CORS etc    │
        └───────────────┘    └───────────────┘
                │                     │
                └──────────┬──────────┘
                           ↓
┌─────────────────────────────────────────────────────────────┐
│              CONTROLLER LAYER                                │
├─────────────────────────────────────────────────────────────┤
│ • AuthController                                            │
│ • CartController                                            │
│ • Admin/ProductController                                   │
│ • Admin/CategoryController                                  │
│ • Admin/ServiceController                                   │
│ • Admin/UserController                                      │
└─────────────────────────────────────────────────────────────┘
                           ↓
┌─────────────────────────────────────────────────────────────┐
│              MODEL LAYER (Eloquent ORM)                      │
├─────────────────────────────────────────────────────────────┤
│ • User (with role & cart relationship)                      │
│ • Product (with category & image)                           │
│ • Category (with products)                                  │
│ • Service                                                   │
│ • Cart (with items & user)                                  │
│ • CartItem (with product & cart)                            │
└─────────────────────────────────────────────────────────────┘
                           ↓
┌─────────────────────────────────────────────────────────────┐
│              DATABASE LAYER                                  │
├─────────────────────────────────────────────────────────────┤
│ • SQLite / MySQL                                            │
│ • Tables: users, products, categories, services, carts...   │
└─────────────────────────────────────────────────────────────┘
                           ↓
┌─────────────────────────────────────────────────────────────┐
│              VIEW LAYER (Blade Templates)                    │
├─────────────────────────────────────────────────────────────┤
│ • auth/*              (Login/Register)                       │
│ • admin/*             (Admin CRUD pages)                     │
│ • cart/*              (Shopping cart)                        │
│ • Original views      (Home, Products, Services)            │
└─────────────────────────────────────────────────────────────┘
                           ↓
┌─────────────────────────────────────────────────────────────┐
│              HTML RESPONSE TO CLIENT                         │
└─────────────────────────────────────────────────────────────┘
```

---

## 🔐 Security Flow

```
┌──────────────────────────────────────┐
│     HTTP REQUEST COMES IN            │
└──────────────────────────────────────┘
              ↓
        ┌─────────────┐
        │ CSRF Check  │ ← @csrf in forms
        │ (web.php)   │
        └─────────────┘
              ↓
        ┌─────────────┐
        │ Auth Check  │ ← middleware('auth')
        │ (IsUser)    │
        └─────────────┘
              ↓
        ┌─────────────┐
        │ Role Check  │ ← middleware('is_admin')
        │ (IsAdmin)   │
        └─────────────┘
              ↓
        ┌─────────────┐
        │ Validation  │ ← Controller validate()
        │ (Server)    │
        └─────────────┘
              ↓
        ┌─────────────┐
        │ DB Query    │ ← Eloquent ORM
        │ (Safe)      │   (SQL Injection Safe)
        └─────────────┘
              ↓
        ┌─────────────┐
        │ Response    │
        │ (HTML)      │
        └─────────────┘
```

---

## 📦 File Upload Process

```
┌──────────────────────────────┐
│   User Select Image File     │
└──────────────────────────────┘
              ↓
┌──────────────────────────────┐
│   Form Submitted with File   │
│   (multipart/form-data)      │
└──────────────────────────────┘
              ↓
┌──────────────────────────────┐
│   Validation Check           │
│   • File exists?             │
│   • Valid format? (jpg/png)  │
│   • Size check? (< 2MB)      │
└──────────────────────────────┘
              ↓ (Pass)
┌──────────────────────────────┐
│   Generate Filename          │
│   • Time: 1731820591         │
│   • Random: a9k3m2p1         │
│   • Format: .jpg             │
│   = 1731820591_a9k3m2p1.jpg  │
└──────────────────────────────┘
              ↓
┌──────────────────────────────┐
│   Move to Storage            │
│   public/assets/images/      │
└──────────────────────────────┘
              ↓
┌──────────────────────────────┐
│   Save Path to Database      │
│   products.image = path      │
└──────────────────────────────┘
              ↓
┌──────────────────────────────┐
│   Success Response           │
└──────────────────────────────┘
```

---

## 🎨 Frontend Architecture

```
┌─────────────────────────────────────────────────────────┐
│                  LAYOUT.APP                             │
│  (Base template with navbar, footer)                    │
└─────────────────────────────────────────────────────────┘
                         ↓
            ┌────────────┴────────────┐
            ↓                         ↓
┌─────────────────────────┐  ┌─────────────────────────┐
│   PUBLIC PAGES          │  │   AUTH PAGES            │
├─────────────────────────┤  ├─────────────────────────┤
│ • home.blade.php        │  │ • auth/login.blade.php  │
│ • products/index        │  │ • auth/register.blade   │
│ • products/show         │  │                         │
│ • service.blade.php     │  │ + Bootstrap UI          │
│                         │  │ + Form validation       │
│ + Bootstrap Design      │  │ + Flash messages        │
│ + Responsive Layout     │  └─────────────────────────┘
└─────────────────────────┘
            ↓
┌─────────────────────────────────────────────────────────┐
│                   ADMIN PAGES                           │
├─────────────────────────────────────────────────────────┤
│ admin/dashboard.blade.php                              │
│ admin/products/* (CRUD pages)                          │
│ admin/categories/* (CRUD pages)                        │
│ admin/services/* (CRUD pages)                          │
│ admin/users/* (CRUD pages)                             │
│                                                         │
│ Features:                                               │
│ • Table with pagination                                │
│ • Create form with validation                          │
│ • Edit form with image upload                          │
│ • Delete confirmation                                  │
│ • Status badges                                        │
│ • Responsive design                                    │
└─────────────────────────────────────────────────────────┘
            ↓
┌─────────────────────────────────────────────────────────┐
│                   CART PAGES                            │
├─────────────────────────────────────────────────────────┤
│ cart/index.blade.php                                   │
│                                                         │
│ Features:                                               │
│ • Product table with image preview                     │
│ • Qty input with auto-submit                           │
│ • Remove item button                                   │
│ • Summary sidebar                                      │
│ • Total price calculation                              │
│ • Checkout button (future)                             │
│ • Clear cart button                                    │
└─────────────────────────────────────────────────────────┘
```

---

## 🔌 API Endpoints Structure

```
AUTHENTICATION
└── POST /login              (Process login)
└── POST /register           (Process register)
└── POST /logout             (Process logout)

SHOPPING (User)
└── POST /cart/add           (Add item)
└── PUT  /cart-item/{id}     (Update quantity)
└── DELETE /cart-item/{id}   (Remove item)
└── POST /cart/clear         (Clear cart)

ADMIN - PRODUCTS
└── GET    /admin/products           (List)
└── POST   /admin/products           (Create)
└── GET    /admin/products/{id}      (Show)
└── GET    /admin/products/{id}/edit (Edit form)
└── PUT    /admin/products/{id}      (Update)
└── DELETE /admin/products/{id}      (Delete)

ADMIN - CATEGORIES
└── GET    /admin/categories         (List)
└── POST   /admin/categories         (Create)
└── GET    /admin/categories/{id}    (Show)
└── PUT    /admin/categories/{id}    (Update)
└── DELETE /admin/categories/{id}    (Delete)

ADMIN - SERVICES
└── GET    /admin/services           (List)
└── POST   /admin/services           (Create)
└── GET    /admin/services/{id}      (Show)
└── PUT    /admin/services/{id}      (Update)
└── DELETE /admin/services/{id}      (Delete)

ADMIN - USERS
└── GET    /admin/users              (List)
└── POST   /admin/users              (Create)
└── GET    /admin/users/{id}         (Show)
└── PUT    /admin/users/{id}         (Update)
└── DELETE /admin/users/{id}         (Delete)
```

---

**Versi: 1.0**
**Last Updated: 16 November 2025**
