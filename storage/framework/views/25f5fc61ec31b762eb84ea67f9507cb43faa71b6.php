<?php $__env->startSection('title', 'Pengeluaran Barang Keluar (OUT)'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-2xl mx-auto">
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 tracking-tight flex items-center">
                <span class="w-8 h-8 rounded-lg bg-rose-100 text-rose-700 flex items-center justify-center mr-2 text-base">
                    <i class="fa-solid fa-arrow-up"></i>
                </span>
                Pengeluaran Barang Keluar (OUT)
            </h1>
            <p class="text-sm text-gray-500 mt-1">Validasi stok tersedia dan DB Transaction di <code>StockController@storeOut</code>.</p>
        </div>
        <a href="<?php echo e(route('dashboard')); ?>" class="text-sm text-gray-600 hover:text-gray-900 font-medium">
            &larr; Dashboard
        </a>
    </div>

    <?php if($errors->any()): ?>
        <div class="bg-rose-50 border-l-4 border-rose-500 text-rose-700 p-4 rounded mb-6 text-sm">
            <p class="font-bold mb-1">Gagal memproses pengeluaran barang:</p>
            <ul class="list-disc list-inside">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <form action="<?php echo e(route('stock.out.store')); ?>" method="POST" class="space-y-4">
            <?php echo csrf_field(); ?>

            <!-- Pilih Produk -->
            <div>
                <label for="product_id" class="block text-sm font-semibold text-gray-700 mb-1">Pilih Produk <span class="text-rose-500">*</span></label>
                <select name="product_id" id="product_id" required class="w-full px-4 py-2.5 border <?php $__errorArgs = ['product_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-rose-500 <?php else: ?> border-gray-300 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> rounded-lg text-sm focus:ring-2 focus:ring-rose-500">
                    <option value="">-- Pilih Produk yang Dikeluarkan --</option>
                    <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($p->id); ?>" <?php echo e(old('product_id', $selectedProductId) == $p->id ? 'selected' : ''); ?>>
                            [<?php echo e($p->sku); ?>] <?php echo e($p->name); ?> &mdash; Tersedia: <?php echo e($p->stock); ?> Unit
                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>

            <!-- Jumlah Keluar -->
            <div>
                <label for="quantity" class="block text-sm font-semibold text-gray-700 mb-1">Jumlah Keluar (Unit) <span class="text-rose-500">*</span></label>
                <input type="number" min="1" name="quantity" id="quantity" required value="<?php echo e(old('quantity')); ?>"
                    class="w-full px-4 py-2 border <?php $__errorArgs = ['quantity'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-rose-500 <?php else: ?> border-gray-300 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> rounded-lg text-sm focus:ring-2 focus:ring-rose-500"
                    placeholder="Contoh: 3">
                <span class="text-xs text-rose-600 font-medium">Aturan: Jumlah tidak boleh melebihi stok yang ada.</span>
            </div>

            <!-- Keterangan Transaksi -->
            <div>
                <label for="notes" class="block text-sm font-semibold text-gray-700 mb-1">Keterangan / Alasan Pengeluaran</label>
                <textarea name="notes" id="notes" rows="3"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-rose-500"
                    placeholder="Contoh: Penjualan pesanan invoice"><?php echo e(old('notes')); ?></textarea>
            </div>

            <div class="pt-4 border-t border-gray-100 flex items-center justify-end space-x-3">
                <a href="<?php echo e(route('products.index')); ?>" class="px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50">Batal</a>
                <button type="submit" class="px-5 py-2.5 bg-rose-600 hover:bg-rose-700 text-white rounded-lg text-sm font-semibold shadow-sm transition flex items-center">
                    <i class="fa-solid fa-arrow-up mr-2"></i> Konfirmasi Barang Keluar
                </button>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\inventory-laravel\resources\views/stock/out.blade.php ENDPATH**/ ?>