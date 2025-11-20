# 📚 PRESENTATION FAQ - Materi & Jawaban

## **1. ELOQUENT ORM - ROUTE MODEL BINDING**

### 📍 Link Code
- **Route:** `routes/web.php` (Line 17)
- **Controller:** `app/Http/Controllers/ProductController.php` (Line 24-27)

### 🔗 File Lengkap
```php
// routes/web.php (Line 17)
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');

// ProductController.php
public function show($id)
{
    $product = Product::findOrFail($id);
    return view('products.show', compact('product'));
}
```

### ❓ Kemungkinan Pertanyaan

**Q1: "Apa itu Route Model Binding?"**
```
A: Route Model Binding adalah fitur Laravel yang otomatis mengubah parameter route 
   menjadi instance model. Jadi kita tidak perlu manual query database.
   
Contoh:
- User akses: /products/5
- Laravel otomatis query: Product::find(5)
- Langsung dapat object Product, tidak perlu manual findOrFail
```

**Q2: "Apa bedanya code di atas dengan implicit binding?"**
```
A: Code di atas masih menggunakan manual {id} dengan findOrFail.
   Implicit binding akan lebih sederhana:
   
   // Dengan implicit binding:
   Route::get('/products/{product}', [ProductController::class, 'show']);
   
   public function show(Product $product)
   {
       // $product sudah di-resolve otomatis
       return view('products.show', compact('product'));
   }
   
   Laravel otomatis inject object Product berdasarkan ID.
```

**Q3: "Apa keuntungan Route Model Binding?"**
```
A: - Kode lebih clean & readable
   - Otomatis handle 404 jika ID tidak ada
   - Mengurangi duplikasi query logic
   - Lebih aman dari SQL injection (menggunakan ORM)
```

**Q4: "Bagaimana jika ID tidak ditemukan?"**
```
A: Menggunakan findOrFail(), otomatis throw 404 exception.
   
   Code di ProductController:
   $product = Product::findOrFail($id);
   
   Jika $id tidak ada di database, Laravel lempar 404 Not Found.
   Tidak perlu manual check/throw.
```

---

## **2. ELOQUENT ORM - RELATIONSHIP**

### 📍 Link Code
- **Product Model:** `app/Models/Product.php`
- **Category Model:** `app/Models/Category.php`
- **Cart Model:** `app/Models/Cart.php`
- **CartItem Model:** `app/Models/CartItem.php`
- **Usage:** `app/Http/Controllers/Admin/ProductController.php` (Line 14)

### 🔗 File Lengkap

**Product Model:**
```php
// app/Models/Product.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['category_id', 'name', 'price', 'image', 'slug', 'short_description', 'long_description'];

    // Many-to-One relationship
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // One-to-Many relationship (untuk CartItem)
    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }
}
```

**Category Model:**
```php
// app/Models/Category.php
class Category extends Model
{
    // One-to-Many relationship
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
```

**Cart Model:**
```php
// app/Models/Cart.php
class Cart extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(CartItem::class);
    }
}
```

**CartItem Model:**
```php
// app/Models/CartItem.php
class CartItem extends Model
{
    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
```

**Usage di Controller:**
```php
// app/Http/Controllers/Admin/ProductController.php (Line 14)
public function index()
{
    // Eager load category untuk setiap product
    $products = Product::with('category')->paginate(10);
    return view('admin.products.index', compact('products'));
}
```

### ❓ Kemungkinan Pertanyaan

**Q1: "Apa itu Eloquent Relationship?"**
```
A: Relationship adalah cara untuk define hubungan antar table di database 
   menggunakan Eloquent ORM.
   
Contoh dalam project:
- Product BELONGS TO Category (Many-to-One)
- Category HAS MANY Products (One-to-Many)
- Cart HAS MANY CartItems
- CartItem BELONGS TO Product

Ini memudahkan kita akses data related tanpa manual join query.
```

**Q2: "Bagaimana cara akses data dari relationship?"**
```
A: Menggunakan dot notation atau property accessor.

Contoh:
$product = Product::find(1);

// Akses category product
echo $product->category->name;

// Atau dalam loop
foreach ($products as $product) {
    echo $product->category->name;  // Output: Furniture, Lighting, dll
}
```

**Q3: "Apa itu eager loading dan lazy loading?"**
```
A: Lazy Loading (default):
   - Query product: SELECT * FROM products (1 query)
   - Loop dan akses category: SELECT * FROM categories WHERE id = X (10 query)
   - Total: 11 query (N+1 problem)

   Eager Loading (recommended):
   - Query: Product::with('category')->paginate(10)
   - Laravel otomatis query categories sekali
   - Total: 2 query (jauh lebih efficient)

Di project kami menggunakan eager loading:
$products = Product::with('category')->paginate(10);
```

**Q4: "Bagaimana dengan Cart dan CartItem?"**
```
A: Relasi:
- User HasMany Cart (satu user bisa punya banyak cart / history)
- Cart HasMany CartItem (satu cart punya banyak item)
- CartItem BelongsTo Product (satu cartitem refer ke satu product)

Contoh akses:
$cart = Cart::find(1);
$items = $cart->items;  // Semua items di cart ini

foreach ($items as $item) {
    echo $item->product->name;  // Nama product di cart
    echo $item->quantity;       // Quantity item
}
```

---

## **3. SEARCHING AND PAGINATION**

### 📍 Link Code
- **Controller:** `app/Http/Controllers/ProductController.php` (Line 7-21)
- **View:** `resources/views/products/index.blade.php`

### 🔗 File Lengkap

**Controller - Search & Pagination:**
```php
// app/Http/Controllers/ProductController.php
public function index()
{
    $search = request('search');  // Ambil query string 'search'
    
    $query = Product::query();

    // Filter berdasarkan search - case insensitive
    if ($search) {
        $query->where('name', 'LIKE', $search . '%')
              ->orWhere('description', 'LIKE', '%' . $search . '%');
    }

    $products = $query->paginate(12);  // 12 produk per halaman
    
    return view('products.index', compact('products', 'search'));
}
```

**View - Tampilkan Pagination:**
```blade
<!-- resources/views/products/index.blade.php -->

<!-- Tampilkan products -->
@foreach ($products as $product)
    <div class="card">
        <h5>{{ $product->name }}</h5>
        <p>${{ $product->price }}</p>
    </div>
@endforeach

<!-- Pagination links -->
<div class="mt-4">
    {{ $products->links() }}
</div>
```

### ❓ Kemungkinan Pertanyaan

**Q1: "Bagaimana cara search bekerja?"**
```
A: Menggunakan query builder dengan WHERE clause:

$search = request('search');  // Ambil value dari input
$query->where('name', 'LIKE', $search . '%')
      ->orWhere('description', 'LIKE', '%' . $search . '%');

- 'LIKE' = pattern matching (SQL LIKE)
- $search . '%' = dimulai dengan keyword (prefix search)
- '%' . $search . '%' = keyword di tengah-tengah

Contoh:
- Search "lum" → "Lumspace Chair", "Luxury Lamp" (cocok)
- Search "chair" → "Comfortable Chair" (cocok)
```

**Q2: "Bagaimana pagination bekerja?"**
```
A: Menggunakan paginate() method dari Eloquent:

$products = $query->paginate(12);  // 12 item per halaman

- Halaman 1: item 1-12
- Halaman 2: item 13-24
- Halaman 3: item 25-36
- dll

Laravel otomatis generate pagination links dengan button Previous/Next/Page Numbers.
Bisa diakses di view dengan: {{ $products->links() }}
```

**Q3: "Bagaimana jika search dan paginate digunakan bersamaan?"**
```
A: Query tetap di-paginate dengan hasil search:

URL: /products?search=chair&page=2

- Halaman 1: Chair hasil search (12 produk)
- Halaman 2: Chair hasil search page 2 (12 produk)
- Searchnya tetap aktif di setiap halaman

View otomatis preserve search parameter:
{{ $products->links() }}  // Link halaman sudah include ?search=chair
```

**Q4: "Bagaimana orde hasil search?"**
```
A: Default orde berdasarkan ID (dari query builder).
   Bisa di-modify dengan orderBy():

// Sort by nama ascending
$query->orderBy('name', 'asc');

// Sort by price descending
$query->orderBy('price', 'desc');

// Sort by relevance (nama match terlebih dahulu)
$query->orderByRaw('name LIKE ? DESC', [$search . '%'])
      ->orderByRaw('description LIKE ? DESC', ['%' . $search . '%']);
```

---

## **4. MIDDLEWARE & AUTHENTICATION**

### 📍 Link Code
- **Routes:** `routes/web.php` (Line 16-50)
- **Middleware:** `app/Http/Middleware/IsAdmin.php`
- **AuthController:** `app/Http/Controllers/AuthController.php`

### 🔗 File Lengkap

**Routes dengan Middleware:**
```php
// routes/web.php

// Public routes (no middleware)
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/products', [ProductController::class, 'index'])->name('products');

// Guest middleware - hanya user yang BELUM login
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('auth.login');
    Route::post('/login', [AuthController::class, 'login'])->name('auth.login.post');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('auth.register');
    Route::post('/register', [AuthController::class, 'register'])->name('auth.register.post');
});

// Auth middleware - hanya user yang SUDAH login
Route::middleware(['auth'])->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
});

// Admin middleware - hanya ADMIN users
Route::middleware(['auth', 'is_admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');
    
    Route::resource('products', AdminProductController::class);
    Route::resource('categories', AdminCategoryController::class);
});
```

**Custom IsAdmin Middleware:**
```php
// app/Http/Middleware/IsAdmin.php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsAdmin
{
    public function handle(Request $request, Closure $next)
    {
        // Cek apakah user sudah login dan role = admin
        if (auth()->check() && auth()->user()->role === 'admin') {
            return $next($request);
        }

        // Jika bukan admin, redirect ke home
        return redirect('/')->with('error', 'Unauthorized access');
    }
}
```

**AuthController - Login Implementation:**
```php
// app/Http/Controllers/AuthController.php
public function login(Request $request)
{
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required|min:6',
    ]);

    // Cek credentials
    if (Auth::attempt($credentials, $request->boolean('remember'))) {
        $request->session()->regenerate();
        
        // Redirect berdasarkan role
        if (Auth::user()->role === 'admin') {
            return redirect()->intended('/admin/dashboard');
        }
        
        return redirect()->intended('/');
    }

    // Login gagal
    return back()->withErrors([
        'email' => 'Email atau password salah.',
    ])->onlyInput('email');
}
```

### ❓ Kemungkinan Pertanyaan

**Q1: "Apa itu middleware?"**
```
A: Middleware adalah "filter" untuk route. Middleware akan check kondisi 
   sebelum request masuk ke controller.

Analogi: Seperti security guard di gedung.
- Guest middleware = hanya orang yang belum punya akses
- Auth middleware = hanya orang yang punya akses/login
- IsAdmin middleware = hanya orang dengan role admin
```

**Q2: "Bagaimana cara auth()->check() bekerja?"**
```
A: auth()->check() mengecek apakah user sudah login dengan melihat session/token.

Contoh:
if (auth()->check()) {
    echo "User sudah login";
    echo auth()->user()->name;  // Get current user
} else {
    echo "User belum login";
}

Di project kami digunakan di AuthController untuk cek login berhasil atau tidak.
```

**Q3: "Bagaimana jika user tidak login tapi akses /cart?"**
```
A: Laravel akan redirect ke login page otomatis.

Karena route /cart punya middleware 'auth':
Route::middleware(['auth'])->group(function () {
    Route::get('/cart', ...);
});

User belum login → tidak pass auth middleware → redirect ke /login
```

**Q4: "Bagaimana guest middleware bekerja?"**
```
A: Guest middleware hanya allow request jika user BELUM login.

Contoh: User sudah login, tapi akses /login
- Middleware guest akan intercept
- Redirect ke home (redirect()->intended('/'))
- User tidak bisa kembali ke login page saat sudah login

Kode di Kernel:
protected $routeMiddleware = [
    'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
];
```

---

## **5. AUTHENTICATION / VALIDATION, FORM UPDATE & DELETE**

### 📍 Link Code
- **Login Validation:** `app/Http/Controllers/AuthController.php` (Line 25-45)
- **Register Validation:** `app/Http/Controllers/AuthController.php` (Line 53-78)
- **Product Store/Update:** `app/Http/Controllers/Admin/ProductController.php` (Line 29-55, 81-113)
- **Product Delete:** `app/Http/Controllers/Admin/ProductController.php` (Line 125-134)

### 🔗 File Lengkap

**Login Validation:**
```php
// app/Http/Controllers/AuthController.php
public function login(Request $request)
{
    // Validate input sebelum proses
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required|min:6',
    ]);

    // Attempt login
    if (Auth::attempt($credentials, $request->boolean('remember'))) {
        // Success logic
        return redirect()->intended('/admin/dashboard');
    }

    // Failed - return error
    return back()->withErrors([
        'email' => 'Email atau password salah.',
    ])->onlyInput('email');
}
```

**Register Validation:**
```php
// app/Http/Controllers/AuthController.php
public function register(Request $request)
{
    // Validate input
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',  // unique = tidak boleh duplikat
        'password' => ['required', 'confirmed', Password::min(6)],
        // 'confirmed' = password & password_confirmation harus sama
    ]);

    // Create user
    $user = User::create([
        'name' => $validated['name'],
        'email' => $validated['email'],
        'password' => Hash::make($validated['password']),  // Hash password
        'role' => 'user',
    ]);

    // Redirect to login
    return redirect()->route('auth.login')->with('success', 'Registrasi berhasil!');
}
```

**Product Create Validation & Store:**
```php
// app/Http/Controllers/Admin/ProductController.php
public function store(Request $request)
{
    // Validate input
    $validated = $request->validate([
        'category_id' => 'required|exists:categories,id',  // foreign key validation
        'name' => 'required|string|max:255',
        'price' => 'required|numeric|min:0',
        'short_description' => 'nullable|string|max:255',
        'long_description' => 'nullable|string',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    // Handle image upload
    if ($request->hasFile('image')) {
        $imageName = time() . '_' . Str::random(10) . '.' . $request->image->extension();
        $request->image->move(public_path('assets/images'), $imageName);
        $validated['image'] = 'assets/images/' . $imageName;
    }

    $validated['slug'] = Str::slug($validated['name']);

    // Create product
    Product::create($validated);

    return redirect()->route('admin.products.index')->with('success', 'Produk berhasil ditambahkan');
}
```

**Product Update:**
```php
// app/Http/Controllers/Admin/ProductController.php
public function update(Request $request, Product $product)
{
    // Validate input
    $validated = $request->validate([
        'category_id' => 'required|exists:categories,id',
        'name' => 'required|string|max:255',
        'price' => 'required|numeric|min:0',
        'short_description' => 'nullable|string|max:255',
        'long_description' => 'nullable|string',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    // Handle image upload
    if ($request->hasFile('image')) {
        // Delete old image
        if ($product->image && file_exists(public_path($product->image))) {
            unlink(public_path($product->image));
        }

        // Upload new image
        $imageName = time() . '_' . Str::random(10) . '.' . $request->image->extension();
        $request->image->move(public_path('assets/images'), $imageName);
        $validated['image'] = 'assets/images/' . $imageName;
    }

    $validated['slug'] = Str::slug($validated['name']);

    // Update product
    $product->update($validated);

    return redirect()->route('admin.products.index')->with('success', 'Produk berhasil diperbarui');
}
```

**Product Delete:**
```php
// app/Http/Controllers/Admin/ProductController.php
public function destroy(Product $product)
{
    // Delete image dari filesystem
    if ($product->image && file_exists(public_path($product->image))) {
        unlink(public_path($product->image));
    }

    // Delete dari database
    $product->delete();

    return redirect()->route('admin.products.index')->with('success', 'Produk berhasil dihapus');
}
```

### ❓ Kemungkinan Pertanyaan

**Q1: "Bagaimana cara validate input?"**
```
A: Menggunakan $request->validate() di controller.

Contoh:
$validated = $request->validate([
    'email' => 'required|email',
    'password' => 'required|min:6',
]);

Rules yang digunakan:
- required = field harus ada
- email = format email valid
- min:6 = minimum 6 karakter
- max:255 = maximum 255 karakter
- numeric = harus angka
- unique:users = tidak boleh duplikat di table users
- exists:categories,id = foreign key harus ada di categories table
- image = file harus image
- mimes:jpeg,png = format image harus jpeg atau png
```

**Q2: "Apa yang terjadi jika validation gagal?"**
```
A: Laravel otomatis:
1. Redirect kembali ke form sebelumnya (back())
2. Tampilkan error message di view
3. Preserve input yang user masukkan (onlyInput())

Contoh error ditampilkan di view:
@if ($errors->any())
    @foreach ($errors->all() as $error)
        <div class="alert alert-danger">{{ $error }}</div>
    @endforeach
@endif
```

**Q3: "Bagaimana cara hash password?"**
```
A: Menggunakan Hash::make() dari Laravel:

$password = 'password123';
$hashed = Hash::make($password);

Hash::make() menggunakan bcrypt algorithm (one-way encryption):
- Input: password123 → bcrypt → Output: $2y$10$...
- Tidak bisa di-decrypt balik
- Saat login, compare hash: Hash::check($input, $hashed)

Di project kami:
User::create([
    'password' => Hash::make($validated['password']),
]);
```

**Q4: "Bagaimana proses update product?"**
```
A: 
1. Validate input
2. Jika ada image baru:
   - Delete old image dari disk
   - Upload new image
3. Update data di database
4. Redirect dengan success message

Contoh:
// Check old image
if ($product->image && file_exists(public_path($product->image))) {
    unlink(public_path($product->image));  // Delete old file
}

// Upload new
if ($request->hasFile('image')) {
    $image = $request->image->move(public_path('assets/images'), $imageName);
}

// Update
$product->update($validated);
```

**Q5: "Bagaimana delete produk beserta gambarnya?"**
```
A: Delete dilakukan 2 tempat:
1. Delete file image dari filesystem (public/assets/images/)
2. Delete record dari database

Code:
if ($product->image && file_exists(public_path($product->image))) {
    unlink(public_path($product->image));  // Delete file
}

$product->delete();  // Delete dari database

Urutan penting! Jika delete DB dulu, path image bisa hilang sehingga 
file di disk tidak bisa dihapus.
```

---

## **6. IMAGE - INSERT, UPDATE, DELETE**

### 📍 Link Code
- **Insert:** `app/Http/Controllers/Admin/ProductController.php` (Line 37-42)
- **Update:** `app/Http/Controllers/Admin/ProductController.php` (Line 86-93)
- **Delete:** `app/Http/Controllers/Admin/ProductController.php` (Line 125-130)
- **Image Storage:** `public/assets/images/`

### 🔗 File Lengkap

**Insert Image:**
```php
// app/Http/Controllers/Admin/ProductController.php - store() method
if ($request->hasFile('image')) {
    // Generate unique filename
    $imageName = time() . '_' . Str::random(10) . '.' . $request->image->extension();
    
    // Move uploaded file ke public/assets/images/
    $request->image->move(public_path('assets/images'), $imageName);
    
    // Save path ke database
    $validated['image'] = 'assets/images/' . $imageName;
}

Product::create($validated);  // Image path disimpan di column 'image'
```

**Update Image:**
```php
// app/Http/Controllers/Admin/ProductController.php - update() method
if ($request->hasFile('image')) {
    // Delete old image jika ada
    if ($product->image && file_exists(public_path($product->image))) {
        unlink(public_path($product->image));
    }

    // Upload new image
    $imageName = time() . '_' . Str::random(10) . '.' . $request->image->extension();
    $request->image->move(public_path('assets/images'), $imageName);
    $validated['image'] = 'assets/images/' . $imageName;
}

$product->update($validated);  // Update product dengan image baru
```

**Delete Image:**
```php
// app/Http/Controllers/Admin/ProductController.php - destroy() method
public function destroy(Product $product)
{
    // Delete image file dari filesystem
    if ($product->image && file_exists(public_path($product->image))) {
        unlink(public_path($product->image));  // unlink() = delete file
    }

    // Delete product record dari database
    $product->delete();

    return redirect()->route('admin.products.index')->with('success', 'Produk berhasil dihapus');
}
```

### ❓ Kemungkinan Pertanyaan

**Q1: "Bagaimana cara upload image?"**
```
A: Menggunakan form dengan enctype="multipart/form-data":

HTML Form:
<form action="/admin/products" method="POST" enctype="multipart/form-data">
    <input type="file" name="image" accept="image/*">
    <button type="submit">Upload</button>
</form>

Di controller:
if ($request->hasFile('image')) {
    $imageName = time() . '_' . Str::random(10) . '.' . $request->image->extension();
    $request->image->move(public_path('assets/images'), $imageName);
    $validated['image'] = 'assets/images/' . $imageName;
}

File disimpan ke: public/assets/images/[nama file]
Path disimpan ke database: assets/images/[nama file]
```

**Q2: "Kenapa menggunakan time() dan Str::random()?"**
```
A: Untuk membuat filename unik dan menghindari duplikasi:

time() = timestamp saat upload (contoh: 1700475234)
Str::random(10) = random string 10 karakter (contoh: aBcDeF1234)

Filename: 1700475234_aBcDeF1234.jpg

Alasan:
- Jika user upload 2 file dengan nama sama, tidak akan overwrite
- Filename jadi unik dan predictable
- Avoid conflict & ensure file tersimpan dengan aman
```

**Q3: "Bagaimana tampilkan image di view?"**
```
A: Menggunakan tag img dengan src path yang disimpan:

View:
<img src="{{ asset($product->image) }}" alt="{{ $product->name }}">

asset() = helper Laravel yang menambahkan base URL
Output HTML: <img src="http://localhost:8000/assets/images/1700475234_abc.jpg">
```

**Q4: "Bagaimana validate file image?"**
```
A: Menggunakan validation rules 'image' dan 'mimes':

$request->validate([
    'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
]);

Rules:
- nullable = tidak wajib (optional)
- image = file harus image (checking MIME type)
- mimes:jpeg,png,jpg,gif = hanya format ini yang diterima
- max:2048 = ukuran max 2MB (2048 KB)

Jika validation gagal, Laravel return error automatically.
```

**Q5: "Bagaimana jika delete product tapi image masih ada di disk?"**
```
A: Bisa menyebabkan storage penuh.

Solusi: Always delete image sebelum delete product record.

Code order penting:
1. Check image exist
2. Delete file (unlink)
3. Delete database record

JANGAN:
$product->delete();  // Delete DB dulu
if ($product->image) {
    unlink(...);  // Sudah tidak bisa akses $product->image
}

HARUS:
if ($product->image) {
    unlink(...);  // Delete file dulu
}
$product->delete();  // Baru delete DB
```

---

## **📊 SUMMARY TABLE**

| Topik | File | Method | Line |
|-------|------|--------|------|
| Route Model Binding | ProductController | show() | 24-27 |
| Relationship | Product Model | category() | - |
| Search & Pagination | ProductController | index() | 7-21 |
| Middleware | routes/web.php | middleware() | 16-50 |
| Authentication | AuthController | login() | 25-45 |
| Validation | AuthController, ProductController | validate() | 30, 56, 31 |
| Form Update | ProductController | update() | 81-113 |
| Form Delete | ProductController | destroy() | 125-134 |
| Image Insert | ProductController | store() | 37-42 |
| Image Update | ProductController | update() | 86-93 |
| Image Delete | ProductController | destroy() | 125-130 |

---

## **🎯 Tips Presentasi**

### Saat Ditanya:
1. **Tunjukkan file & code langsung** - buka di editor
2. **Jelaskan line-by-line** - jangan semuanya sekaligus
3. **Beri contoh konkret** - bagaimana digunakan di project
4. **Hubungkan dengan demo** - "Nanti kita lihat saat demo..."
5. **Jujur jika tidak tahu** - "Interesting question, belum saya explore itu"

### Hal yang Jangan Lupa:
- ✅ Tunjukkan database relationship diagram
- ✅ Demo login/register flow
- ✅ Demo create/edit/delete product
- ✅ Tunjukkan search & pagination berjalan
- ✅ Tunjukkan admin routes middleware protect

---

**Good Luck dengan Presentasi! 🚀**
