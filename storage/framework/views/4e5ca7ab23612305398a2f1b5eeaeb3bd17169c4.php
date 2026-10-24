<?php $__env->startSection('title', 'Tambah Produk Baru'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-3xl mx-auto">
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Tambah Produk Baru</h1>
            <p class="text-sm text-gray-500 mt-1">Resource Controller: <code>ProductController@store</code></p>
        </div>
        <a href="<?php echo e(route('products.index')); ?>" class="text-sm text-gray-600 hover:text-gray-900 font-medium">
            &larr; Kembali
        </a>
    </div>

    <?php if($errors->any()): ?>
        <div class="bg-rose-50 border-l-4 border-rose-500 text-rose-700 p-4 rounded mb-6 text-sm">
            <p class="font-bold mb-1">Terjadi kesalahan validasi:</p>
            <ul class="list-disc list-inside">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <form action="<?php echo e(route('products.store')); ?>" method="POST" class="space-y-5">
            <?php echo csrf_field(); ?>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <!-- SKU -->
                <div>
                    <label for="sku" class="block text-sm font-semibold text-gray-700 mb-1">Kode SKU <span class="text-rose-500">*</span></label>
                    <input type="text" name="sku" id="sku" required value="<?php echo e(old('sku')); ?>"
                        class="w-full px-4 py-2 border <?php $__errorArgs = ['sku'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-rose-500 <?php else: ?> border-gray-300 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> rounded-lg uppercase font-mono text-sm focus:ring-2 focus:ring-indigo-500"
                        placeholder="Contoh: PRD-ELC-001">
                    <?php $__errorArgs = ['sku'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="text-rose-600 text-xs mt-1"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <!-- Kategori -->
                <div class="sm:col-span-2">
                    <label for="category_id" class="block text-sm font-semibold text-gray-700 mb-1">Kategori Produk <span class="text-rose-500">*</span></label>
                    <select name="category_id" id="category_id" required
                        class="w-full px-4 py-2 border <?php $__errorArgs = ['category_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-rose-500 <?php else: ?> border-gray-300 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> rounded-lg text-sm focus:ring-2 focus:ring-indigo-500">
                        <option value="">-- Pilih Kategori --</option>
                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($cat->id); ?>" <?php echo e(old('category_id') == $cat->id ? 'selected' : ''); ?>>
                                <?php echo e($cat->name); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <?php $__errorArgs = ['category_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="text-rose-600 text-xs mt-1"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>

            <!-- Nama Produk -->
            <div>
                <label for="name" class="block text-sm font-semibold text-gray-700 mb-1">Nama Produk Lengkap <span class="text-rose-500">*</span></label>
                <input type="text" name="name" id="name" required value="<?php echo e(old('name')); ?>"
                    class="w-full px-4 py-2 border <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-rose-500 <?php else: ?> border-gray-300 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> rounded-lg text-sm focus:ring-2 focus:ring-indigo-500"
                    placeholder="Contoh: Logitech Wireless Keyboard K380">
                <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="text-rose-600 text-xs mt-1"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <!-- Harga, Stok Awal, Minimum Stok -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label for="price" class="block text-sm font-semibold text-gray-700 mb-1">Harga Jual (Rp) <span class="text-rose-500">*</span></label>
                    <input type="number" step="100" min="0" name="price" id="price" required value="<?php echo e(old('price')); ?>"
                        class="w-full px-4 py-2 border <?php $__errorArgs = ['price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-rose-500 <?php else: ?> border-gray-300 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> rounded-lg text-sm focus:ring-2 focus:ring-indigo-500"
                        placeholder="Contoh: 150000">
                    <?php $__errorArgs = ['price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="text-rose-600 text-xs mt-1"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div>
                    <label for="stock" class="block text-sm font-semibold text-gray-700 mb-1">Stok Awal <span class="text-rose-500">*</span></label>
                    <input type="number" min="0" name="stock" id="stock" required value="<?php echo e(old('stock', 0)); ?>"
                        class="w-full px-4 py-2 border <?php $__errorArgs = ['stock'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-rose-500 <?php else: ?> border-gray-300 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> rounded-lg text-sm focus:ring-2 focus:ring-indigo-500">
                    <span class="text-[11px] text-gray-400">Dicatat di mutasi IN awal</span>
                </div>

                <div>
                    <label for="minimum_stock" class="block text-sm font-semibold text-gray-700 mb-1">Batas Minimum Stok <span class="text-rose-500">*</span></label>
                    <input type="number" min="0" name="minimum_stock" id="minimum_stock" required value="<?php echo e(old('minimum_stock', 5)); ?>"
                        class="w-full px-4 py-2 border <?php $__errorArgs = ['minimum_stock'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-rose-500 <?php else: ?> border-gray-300 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> rounded-lg text-sm focus:ring-2 focus:ring-indigo-500">
                    <span class="text-[11px] text-gray-400">Untuk alert restock</span>
                </div>
            </div>

            <!-- Hubungkan Mitra Supplier (Many-to-Many) -->
            <div class="pt-4 border-t border-gray-100">
                <label class="block text-sm font-bold text-gray-800 mb-1">
                    <i class="fa-solid fa-truck-field mr-1 text-indigo-600"></i> Hubungkan dengan Mitra Supplier (Many-to-Many)
                </label>
                <p class="text-xs text-gray-500 mb-3">Pilih supplier penyedia produk ini serta harga pasokan (opsional).</p>

                <div class="space-y-2 max-h-48 overflow-y-auto p-3 border border-gray-200 rounded-lg bg-gray-50/50">
                    <?php $__empty_1 = true; $__currentLoopData = $suppliers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="flex items-center justify-between p-2 rounded bg-white border border-gray-200 text-xs">
                            <label class="flex items-center space-x-2 cursor-pointer flex-1">
                                <input type="checkbox" name="suppliers[]" value="<?php echo e($s->id); ?>" class="rounded text-indigo-600"
                                    <?php echo e(is_array(old('suppliers')) && in_array($s->id, old('suppliers')) ? 'checked' : ''); ?>>
                                <span class="font-medium text-gray-800"><?php echo e($s->name); ?></span>
                            </label>
                            <div class="flex items-center space-x-1">
                                <span class="text-gray-400">Harga Beli:</span>
                                <input type="number" step="100" min="0" name="supplier_prices[<?php echo e($s->id); ?>]"
                                    value="<?php echo e(old("supplier_prices.{$s->id}")); ?>" placeholder="Rp 0"
                                    class="w-28 px-2 py-1 text-xs border border-gray-300 rounded">
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <p class="text-xs text-gray-400">Belum ada master supplier.</p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Submit -->
            <div class="pt-4 border-t border-gray-100 flex items-center justify-end space-x-3">
                <a href="<?php echo e(route('products.index')); ?>" class="px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50">Batal</a>
                <button type="submit" class="px-5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-sm font-medium shadow-sm transition">
                    Simpan Produk
                </button>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\inventory-laravel\resources\views/products/create.blade.php ENDPATH**/ ?>