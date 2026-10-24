<?php $__env->startSection('title', 'Katalog Produk'); ?>

<?php $__env->startSection('content'); ?>
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Katalog Produk</h1>
        <p class="text-sm text-gray-500 mt-1">Dikelola via Resource Controller: <code>ProductController@index</code>.</p>
    </div>
    <div class="mt-4 sm:mt-0 flex gap-2">
        <a href="<?php echo e(route('products.create')); ?>" class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg shadow-sm transition">
            <i class="fa-solid fa-plus mr-2"></i> Tambah Produk Baru
        </a>
    </div>
</div>

<!-- Form Search, Filter, dan Sorting (Slide 16, 32) -->
<div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 mb-6">
    <form method="GET" action="<?php echo e(route('products.index')); ?>" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3 items-end">
        <!-- Pencarian -->
        <div class="lg:col-span-2">
            <label class="block text-xs font-semibold text-gray-600 mb-1">Cari Produk (Nama / SKU)</label>
            <div class="relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                    <i class="fa-solid fa-magnifying-glass text-xs"></i>
                </span>
                <input type="text" name="search" value="<?php echo e(request('search')); ?>" placeholder="Ketik nama produk atau SKU..."
                    class="w-full pl-9 pr-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500">
            </div>
        </div>

        <!-- Filter Kategori -->
        <div>
            <label class="block text-xs font-semibold text-gray-600 mb-1">Kategori</label>
            <select name="category_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500">
                <option value="">-- Semua Kategori --</option>
                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($c->id); ?>" <?php echo e(request('category_id') == $c->id ? 'selected' : ''); ?>>
                        <?php echo e($c->name); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>

        <!-- Sorting Allowlist -->
        <div>
            <label class="block text-xs font-semibold text-gray-600 mb-1">Urutan</label>
            <div class="flex space-x-1">
                <select name="sort" class="w-2/3 px-2 py-2 border border-gray-300 rounded-lg text-xs focus:ring-2 focus:ring-indigo-500">
                    <option value="name" <?php echo e(request('sort') == 'name' ? 'selected' : ''); ?>>Nama</option>
                    <option value="price" <?php echo e(request('sort') == 'price' ? 'selected' : ''); ?>>Harga</option>
                    <option value="stock" <?php echo e(request('sort') == 'stock' ? 'selected' : ''); ?>>Stok</option>
                    <option value="sku" <?php echo e(request('sort') == 'sku' ? 'selected' : ''); ?>>SKU</option>
                    <option value="date" <?php echo e(request('sort') == 'date' ? 'selected' : ''); ?>>Tanggal</option>
                </select>
                <select name="direction" class="w-1/3 px-1 py-2 border border-gray-300 rounded-lg text-xs focus:ring-2 focus:ring-indigo-500">
                    <option value="asc" <?php echo e(request('direction') == 'asc' ? 'selected' : ''); ?>>A-Z</option>
                    <option value="desc" <?php echo e(request('direction') == 'desc' ? 'selected' : ''); ?>>Z-A</option>
                </select>
            </div>
        </div>

        <!-- Tombol Filter -->
        <div class="flex items-center space-x-2">
            <button type="submit" class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-3 rounded-lg text-sm shadow-sm transition">
                <i class="fa-solid fa-filter mr-1"></i> Filter
            </button>
            <a href="<?php echo e(route('products.index')); ?>" class="bg-gray-100 hover:bg-gray-200 text-gray-700 py-2 px-3 rounded-lg text-sm font-medium transition" title="Reset">
                <i class="fa-solid fa-rotate-left"></i>
            </a>
        </div>
    </form>

    <!-- Quick Filter -->
    <div class="mt-3 pt-3 border-t border-gray-100 flex items-center space-x-2 text-xs">
        <span class="text-gray-500 font-medium">Filter Cepat:</span>
        <a href="<?php echo e(route('products.index', ['low_stock' => 1])); ?>" class="px-2.5 py-1 rounded-full border <?php echo e(request('low_stock') ? 'bg-rose-100 border-rose-300 text-rose-800 font-bold' : 'bg-gray-50 border-gray-200 text-gray-600 hover:bg-rose-50'); ?>">
            <i class="fa-solid fa-triangle-exclamation mr-1 text-rose-500"></i> Hanya Stok Rendah (&le; Min)
        </a>
    </div>
</div>

<!-- Tabel Produk -->
<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-6">
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-600">
            <thead class="bg-gray-50 text-xs uppercase font-semibold text-gray-500 border-b border-gray-100">
                <tr>
                    <th class="px-4 py-3">SKU</th>
                    <th class="px-4 py-3">Nama Produk</th>
                    <th class="px-4 py-3">Kategori</th>
                    <th class="px-4 py-3 text-right">Harga</th>
                    <th class="px-4 py-3 text-center">Stok / Min</th>
                    <th class="px-4 py-3 text-center">Supplier</th>
                    <th class="px-4 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <?php $isLow = $p->isLowStock(); ?>
                    <tr class="hover:bg-gray-50/70 transition <?php echo e($isLow ? 'bg-rose-50/30' : ''); ?>">
                        <td class="px-4 py-3.5 font-mono text-xs font-bold text-indigo-700 whitespace-nowrap">
                            <?php echo e($p->sku); ?>

                        </td>
                        <td class="px-4 py-3.5 font-medium text-gray-900">
                            <a href="<?php echo e(route('products.show', $p)); ?>" class="hover:text-indigo-600 transition">
                                <?php echo e($p->name); ?>

                            </a>
                        </td>
                        <td class="px-4 py-3.5 text-gray-600 whitespace-nowrap">
                            <span class="bg-gray-100 text-gray-700 text-xs px-2 py-0.5 rounded">
                                <?php echo e($p->category->name); ?>

                            </span>
                        </td>
                        <td class="px-4 py-3.5 text-right font-semibold text-gray-800 whitespace-nowrap">
                            Rp <?php echo e(number_format($p->price, 0, ',', '.')); ?>

                        </td>
                        <td class="px-4 py-3.5 text-center whitespace-nowrap">
                            <div class="inline-flex items-center space-x-1.5">
                                <span class="font-bold text-sm <?php echo e($isLow ? 'text-rose-600' : 'text-emerald-600'); ?>">
                                    <?php echo e($p->stock); ?>

                                </span>
                                <span class="text-xs text-gray-400">/ Min: <?php echo e($p->minimum_stock); ?></span>
                                <?php if($isLow): ?>
                                    <span class="px-1.5 py-0.2 rounded text-[10px] font-bold bg-rose-100 text-rose-700">
                                        LOW
                                    </span>
                                <?php endif; ?>
                            </div>
                        </td>
                        <td class="px-4 py-3.5 text-center whitespace-nowrap">
                            <a href="<?php echo e(route('products.show', $p)); ?>" class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-indigo-50 text-indigo-700 hover:bg-indigo-100">
                                <i class="fa-solid fa-truck-field mr-1 text-xs"></i>
                                <span><?php echo e($p->suppliers->count()); ?> Mitra</span>
                            </a>
                        </td>
                        <td class="px-4 py-3.5 text-right space-x-1.5 whitespace-nowrap">
                            <a href="<?php echo e(route('stock.in', ['product_id' => $p->id])); ?>" class="text-emerald-600 hover:text-emerald-800 text-xs bg-emerald-50 px-2 py-1 rounded font-medium" title="Tambah Stok (+IN)">
                                + IN
                            </a>
                            <a href="<?php echo e(route('stock.out', ['product_id' => $p->id])); ?>" class="text-rose-600 hover:text-rose-800 text-xs bg-rose-50 px-2 py-1 rounded font-medium" title="Keluarkan Stok (-OUT)">
                                - OUT
                            </a>
                            <a href="<?php echo e(route('products.edit', $p)); ?>" class="text-indigo-600 hover:text-indigo-800 text-xs bg-indigo-50 px-2 py-1 rounded font-medium" title="Edit">
                                <i class="fa-solid fa-pen"></i>
                            </a>
                            <form action="<?php echo e(route('products.destroy', $p)); ?>" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?');">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="text-rose-600 hover:text-rose-800 text-xs bg-rose-50 px-2 py-1 rounded font-medium" title="Hapus">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="7" class="px-6 py-10 text-center text-gray-400">
                            <i class="fa-solid fa-box-open text-4xl mb-2 text-gray-300 block"></i>
                            Tidak ada produk yang sesuai kriteria.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Pagination (Slide 24, 39) -->
    <?php if($products->hasPages()): ?>
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
            <?php echo e($products->links()); ?>

        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\inventory-laravel\resources\views/products/index.blade.php ENDPATH**/ ?>