# Inventory Management System — Laravel Application
> **Pertemuan 5:** *Laravel Fundamental (Mengubah Inventory Management System P4 menjadi Laravel Application)*  
> **Tema:** Laravel dipahami melalui arsitektur MVC, bukan sekadar menghafal command.

---

## 🧭 Alur Arsitektur MVC (Slide 10 & 47)

Aplikasi mengimplementasikan alur request-response resmi Laravel secara menyeluruh:

$$\text{Request} \longrightarrow \text{Route} \longrightarrow \text{Controller} \longrightarrow \text{Model (Eloquent)} \longrightarrow \text{Database} \longrightarrow \text{Response (Blade)}$$

1. **Request**: Klien/browser mengirimkan HTTP Request (GET, POST, PUT, DELETE).
2. **Route (`routes/web.php`)**: Mengarahkan request ke Controller dan method yang sesuai menggunakan *Resource Route* dan *Named Route*.
3. **Controller (`app/Http/Controllers/`)**: Mengelola alur logika bisnis, memvalidasi input, dan berinteraksi dengan Model.
4. **Model (`app/Models/`)**: Mengakses dan memanipulasi data melalui Eloquent ORM beserta relasinya.
5. **Database**: MySQL/MariaDB menyimpan struktur data relasional yang dikelola via *Migration*.
6. **Response**: Controller mengembalikan tampilan Blade view yang di-render dengan layout dan komponen yang aman dari XSS.

---

## 🗄️ Database & Relasi Eloquent (Slide 33–34)

| Model | Relasi | Tabel Terkait | Keterangan |
|---|---|---|---|
| **Category** | `hasMany(Product::class)` | `products` | 1 Kategori memiliki banyak Produk (*One-to-Many*). |
| **Product** | `belongsTo(Category::class)` | `categories` | Setiap Produk merujuk ke 1 Kategori. |
| **Product** | `belongsToMany(Supplier::class, 'product_suppliers')` | `suppliers` | Relasi *Many-to-Many* dengan kolom pivot `supplier_price`. |
| **Supplier** | `belongsToMany(Product::class, 'product_suppliers')` | `products` | Supplier memasok banyak Produk. |
| **StockMovement** | `belongsTo(Product::class)`, `belongsTo(User::class)` | `products`, `users` | Histori mutasi barang masuk (IN) dan barang keluar (OUT). |

---

## 🚀 Panduan Instalasi & Menjalankan (Slide 7, 27, 48)

Jika memindahkan project ini ke komputer lain atau saat diuji oleh dosen:

```bash
# 1. Masuk ke direktori project
cd inventory-laravel

# 2. Salin file environment & konfigurasi
cp .env.example .env

# 3. Generate Application Key
php artisan key:generate

# 4. Jalankan Migration dan Seeder (Database Otomatis Terisi)
php artisan migrate:fresh --seed

# 5. Jalankan Local Server
php artisan serve
```

Aplikasi dapat langsung diakses melalui browser pada:
- **`http://127.0.0.1:8000`** (atau `http://localhost/inventory-laravel/public/`)

---

## 🔑 Akun Uji Coba (Seed Data Aktif)

| Role | Username | Password | Keterangan |
|---|---|---|---|
| **Admin** | `admin` | `admin123` | Akses penuh seluruh modul termasuk **Manajemen User**. |
| **Staff** | `staff` | `staff123` | Akses operasional katalog & transaksi stok. Dilarang mengelola user (HTTP 403). |

---

## 🧪 Demonstrasi Alur Lengkap (Slide 48)

Sesuai instruksi deliverable: *"Demonstrasikan satu alur lengkap: membuka form → validasi → simpan → redirect → tampilkan data"*:

1. **Buka Form Tambah Produk**:
   - Klik tombol **Tambah Produk Baru** (`/products/create`).
   - Alur: `Route::get('/products/create')` $\rightarrow$ `ProductController@create` $\rightarrow$ `view('products.create')`.
2. **Validasi Error (Syntactic & Semantic)**:
   - Kosongkan kolom nama, masukkan harga negatif `-5000`, lalu klik Simpan.
   - Alur: `$request->validate()` gagal $\rightarrow$ redirect kembali dengan error message `@error`.
3. **Simpan Data Valid**:
   - Isi SKU unik `PRD-TES-999`, nama `"Keyboard Wireless Mini"`, kategori, harga `120000`, stok awal `10`.
   - Alur: `DB::transaction()` $\rightarrow$ `Product::create()` $\rightarrow$ `StockMovement::create(type='IN')`.
4. **Redirect & Tampilkan Data**:
   - Controller melakukan `redirect()->route('products.index')->with('success', ...)`
   - Produk langsung muncul di tabel katalog produk dengan pagination dan flash alert.
