<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\StockMovement;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // 1. Akun Pengguna (Admin & Staff)
        $admin = User::updateOrCreate(
            ['username' => 'admin'],
            [
                'name'     => 'Administrator Utama',
                'email'    => 'admin@inventory.local',
                'password' => Hash::make('admin123'),
                'role'     => 'admin',
                'phone'    => '081234567890',
            ]
        );

        $staff = User::updateOrCreate(
            ['username' => 'staff'],
            [
                'name'     => 'Staff Inventaris Gudang',
                'email'    => 'staff@inventory.local',
                'password' => Hash::make('staff123'),
                'role'     => 'staff',
                'phone'    => '089876543210',
            ]
        );

        // 2. Kategori Produk
        $catElektronik = Category::updateOrCreate(['name' => 'Elektronik & Gadget'], ['description' => 'Perangkat komputer, ponsel, dan periferal']);
        $catAksesoris  = Category::updateOrCreate(['name' => 'Aksesoris Komputer'], ['description' => 'Kabel, mouse, keyboard, dan perangkat input']);
        $catATK        = Category::updateOrCreate(['name' => 'Alat Tulis Kantor'], ['description' => 'Kebutuhan kertas, pena, dan perlengkapan kantor']);

        // 3. Supplier
        $sup1 = Supplier::updateOrCreate(
            ['name' => 'PT Sinar Mandiri Jaya'],
            [
                'contact_person' => 'Budi Santoso',
                'phone'          => '08111222333',
                'email'          => 'budi@sinarmandiri.co.id',
                'address'        => 'Jl. Sudirman No. 45, Jakarta',
            ]
        );

        $sup2 = Supplier::updateOrCreate(
            ['name' => 'CV Maju Bersama Tech'],
            [
                'contact_person' => 'Siti Rahma',
                'phone'          => '08222333444',
                'email'          => 'sales@majubersama.com',
                'address'        => 'Jl. Merdeka No. 12, Bandung',
            ]
        );

        $sup3 = Supplier::updateOrCreate(
            ['name' => 'Toko Abadi Perkasa'],
            [
                'contact_person' => 'Hendra Gunawan',
                'phone'          => '08333444555',
                'email'          => 'abadiperkasa@gmail.com',
                'address'        => 'Jl. Gajah Mada No. 88, Surabaya',
            ]
        );

        // 4. Produk
        $p1 = Product::updateOrCreate(
            ['sku' => 'PRD-MOU-001'],
            [
                'category_id'   => $catAksesoris->id,
                'name'          => 'Logitech Wireless Mouse M185',
                'price'         => 165000,
                'stock'         => 25,
                'minimum_stock' => 5,
            ]
        );

        $p2 = Product::updateOrCreate(
            ['sku' => 'PRD-KEY-002'],
            [
                'category_id'   => $catAksesoris->id,
                'name'          => 'Mechanical Keyboard RGB TKL',
                'price'         => 450000,
                'stock'         => 12,
                'minimum_stock' => 5,
            ]
        );

        $p3 = Product::updateOrCreate(
            ['sku' => 'PRD-MON-003'],
            [
                'category_id'   => $catElektronik->id,
                'name'          => 'Monitor LED 24 Inch Full HD',
                'price'         => 1450000,
                'stock'         => 4,
                'minimum_stock' => 5,
            ]
        );

        $p4 = Product::updateOrCreate(
            ['sku' => 'PRD-PPR-004'],
            [
                'category_id'   => $catATK->id,
                'name'          => 'Kertas HVS A4 80gr 1 Rim',
                'price'         => 55000,
                'stock'         => 40,
                'minimum_stock' => 10,
            ]
        );

        $p5 = Product::updateOrCreate(
            ['sku' => 'PRD-SSD-005'],
            [
                'category_id'   => $catElektronik->id,
                'name'          => 'SSD NVMe 512GB High Speed',
                'price'         => 620000,
                'stock'         => 2,
                'minimum_stock' => 5,
            ]
        );

        // 5. Relasi Many-to-Many Produk & Supplier
        $p1->suppliers()->syncWithoutDetaching([
            $sup1->id => ['supplier_price' => 140000],
            $sup2->id => ['supplier_price' => 142000],
        ]);
        $p2->suppliers()->syncWithoutDetaching([
            $sup2->id => ['supplier_price' => 380000],
        ]);
        $p3->suppliers()->syncWithoutDetaching([
            $sup1->id => ['supplier_price' => 1250000],
        ]);
        $p4->suppliers()->syncWithoutDetaching([
            $sup3->id => ['supplier_price' => 45000],
        ]);
        $p5->suppliers()->syncWithoutDetaching([
            $sup1->id => ['supplier_price' => 520000],
            $sup2->id => ['supplier_price' => 530000],
        ]);

        // 6. Transaksi Mutasi Stok (IN & OUT)
        $movements = [
            ['product_id' => $p1->id, 'user_id' => $admin->id, 'type' => 'IN',  'quantity' => 30, 'notes' => 'Penerimaan stok awal dari vendor'],
            ['product_id' => $p1->id, 'user_id' => $staff->id, 'type' => 'OUT', 'quantity' => 5,  'notes' => 'Penjualan ke pelanggan offline'],
            ['product_id' => $p2->id, 'user_id' => $admin->id, 'type' => 'IN',  'quantity' => 15, 'notes' => 'Penerimaan stok awal'],
            ['product_id' => $p2->id, 'user_id' => $staff->id, 'type' => 'OUT', 'quantity' => 3,  'notes' => 'Pesanan marketplace'],
            ['product_id' => $p3->id, 'user_id' => $admin->id, 'type' => 'IN',  'quantity' => 5,  'notes' => 'Stok awal monitor'],
            ['product_id' => $p3->id, 'user_id' => $staff->id, 'type' => 'OUT', 'quantity' => 1,  'notes' => 'Display sampel'],
            ['product_id' => $p4->id, 'user_id' => $admin->id, 'type' => 'IN',  'quantity' => 40, 'notes' => 'Stok awal kertas ATK'],
            ['product_id' => $p5->id, 'user_id' => $admin->id, 'type' => 'IN',  'quantity' => 5,  'notes' => 'Stok awal SSD'],
            ['product_id' => $p5->id, 'user_id' => $staff->id, 'type' => 'OUT', 'quantity' => 3,  'notes' => 'Penjualan rakit PC kantor'],
        ];

        foreach ($movements as $m) {
            StockMovement::create($m);
        }
    }
}
