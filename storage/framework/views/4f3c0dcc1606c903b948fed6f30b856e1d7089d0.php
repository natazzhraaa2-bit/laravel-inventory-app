<?php $__env->startSection('title', 'Riwayat Mutasi Stok'); ?>

<?php $__env->startSection('content'); ?>
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Riwayat Mutasi Stok</h1>
        <p class="text-sm text-gray-500 mt-1">Audit log seluruh transaksi barang masuk dan keluar.</p>
    </div>
    <div class="mt-4 sm:mt-0 flex gap-2">
        <a href="<?php echo e(route('stock.in')); ?>" class="inline-flex items-center px-3.5 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-medium rounded-lg shadow-sm transition">
            <i class="fa-solid fa-plus mr-1.5"></i> Barang Masuk
        </a>
        <a href="<?php echo e(route('stock.out')); ?>" class="inline-flex items-center px-3.5 py-2 bg-rose-600 hover:bg-rose-700 text-white text-sm font-medium rounded-lg shadow-sm transition">
            <i class="fa-solid fa-minus mr-1.5"></i> Barang Keluar
        </a>
    </div>
</div>

<!-- Filter Box -->
<div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 mb-6">
    <form method="GET" action="<?php echo e(route('stock.history')); ?>" class="grid grid-cols-1 sm:grid-cols-3 gap-3 items-end">
        <div>
            <label class="block text-xs font-semibold text-gray-600 mb-1">Tipe Mutasi</label>
            <select name="type" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500">
                <option value="">-- Semua Tipe (IN & OUT) --</option>
                <option value="IN" <?php echo e(request('type') == 'IN' ? 'selected' : ''); ?>>Barang Masuk (IN)</option>
                <option value="OUT" <?php echo e(request('type') == 'OUT' ? 'selected' : ''); ?>>Barang Keluar (OUT)</option>
            </select>
        </div>

        <div>
            <label class="block text-xs font-semibold text-gray-600 mb-1">Pilih Produk</label>
            <select name="product_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500">
                <option value="">-- Semua Produk --</option>
                <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pl): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($pl->id); ?>" <?php echo e(request('product_id') == $pl->id ? 'selected' : ''); ?>>
                        [<?php echo e($pl->sku); ?>] <?php echo e($pl->name); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>

        <div class="flex items-center space-x-2">
            <button type="submit" class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-3 rounded-lg text-sm shadow-sm transition">
                <i class="fa-solid fa-filter mr-1"></i> Terapkan Filter
            </button>
            <a href="<?php echo e(route('stock.history')); ?>" class="bg-gray-100 hover:bg-gray-200 text-gray-700 py-2 px-3 rounded-lg text-sm font-medium transition" title="Reset">
                <i class="fa-solid fa-rotate-left"></i>
            </a>
        </div>
    </form>
</div>

<!-- Tabel Histori Mutasi -->
<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-6">
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-600">
            <thead class="bg-gray-50 text-xs uppercase font-semibold text-gray-500 border-b border-gray-100">
                <tr>
                    <th class="px-5 py-3">Waktu Transaksi</th>
                    <th class="px-5 py-3">Produk</th>
                    <th class="px-5 py-3">Tipe</th>
                    <th class="px-5 py-3 text-right">Kuantitas</th>
                    <th class="px-5 py-3">Petugas (User)</th>
                    <th class="px-5 py-3">Keterangan</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                <?php $__empty_1 = true; $__currentLoopData = $movements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="hover:bg-gray-50/70 transition">
                        <td class="px-5 py-3.5 whitespace-nowrap text-xs text-gray-500">
                            <i class="fa-regular fa-clock mr-1 text-gray-400"></i> <?php echo e($m->created_at->format('d/m/Y H:i')); ?>

                        </td>
                        <td class="px-5 py-3.5 font-medium text-gray-900">
                            <?php echo e($m->product->name); ?>

                            <span class="block text-xs font-mono text-gray-400"><?php echo e($m->product->sku); ?></span>
                        </td>
                        <td class="px-5 py-3.5 whitespace-nowrap">
                            <?php if($m->type === 'IN'): ?>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800">
                                    <i class="fa-solid fa-arrow-down mr-1"></i> MASUK (IN)
                                </span>
                            <?php else: ?>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-rose-100 text-rose-800">
                                    <i class="fa-solid fa-arrow-up mr-1"></i> KELUAR (OUT)
                                </span>
                            <?php endif; ?>
                        </td>
                        <td class="px-5 py-3.5 text-right font-bold text-base whitespace-nowrap <?php echo e($m->type === 'IN' ? 'text-emerald-600' : 'text-rose-600'); ?>">
                            <?php echo e($m->type === 'IN' ? '+' : '-'); ?><?php echo e(number_format($m->quantity)); ?>

                        </td>
                        <td class="px-5 py-3.5 whitespace-nowrap text-xs text-gray-700">
                            <i class="fa-solid fa-user-check text-indigo-500 mr-1"></i>
                            <?php echo e($m->user->name ?? '-'); ?>

                        </td>
                        <td class="px-5 py-3.5 text-xs text-gray-500 max-w-sm">
                            <?php echo e($m->notes ?? '-'); ?>

                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="6" class="px-5 py-8 text-center text-gray-400">
                            Belum ada riwayat transaksi mutasi yang cocok.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php if($movements->hasPages()): ?>
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
            <?php echo e($movements->links()); ?>

        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\inventory-laravel\resources\views/stock/history.blade.php ENDPATH**/ ?>