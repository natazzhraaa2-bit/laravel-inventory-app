<?php $__env->startSection('title', 'Daftar Supplier'); ?>

<?php $__env->startSection('content'); ?>
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Data Supplier</h1>
        <p class="text-sm text-gray-500 mt-1">Relasi Many-to-Many: <code>Product belongsToMany Supplier</code>.</p>
    </div>
    <div class="mt-4 sm:mt-0">
        <a href="<?php echo e(route('suppliers.create')); ?>" class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg shadow-sm transition">
            <i class="fa-solid fa-plus mr-2"></i> Tambah Supplier
        </a>
    </div>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-600">
            <thead class="bg-gray-50 text-xs uppercase font-semibold text-gray-500 border-b border-gray-100">
                <tr>
                    <th class="px-6 py-3 w-16 text-center">No</th>
                    <th class="px-6 py-3">Nama Perusahaan / Supplier</th>
                    <th class="px-6 py-3">Kontak & Telepon</th>
                    <th class="px-6 py-3">Email & Alamat</th>
                    <th class="px-6 py-3 text-center">Produk Disuplai</th>
                    <th class="px-6 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                <?php $__empty_1 = true; $__currentLoopData = $suppliers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $idx => $sup): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="hover:bg-gray-50/70 transition">
                        <td class="px-6 py-4 text-center font-semibold text-gray-400"><?php echo e($idx + 1); ?></td>
                        <td class="px-6 py-4 font-semibold text-gray-800"><?php echo e($sup->name); ?></td>
                        <td class="px-6 py-4 text-gray-600">
                            <div><i class="fa-solid fa-user-tie text-xs text-gray-400 mr-1.5"></i> <?php echo e($sup->contact_person ?? '-'); ?></div>
                            <div class="text-xs text-gray-400 mt-0.5"><i class="fa-solid fa-phone text-xs text-gray-400 mr-1.5"></i> <?php echo e($sup->phone ?? '-'); ?></div>
                        </td>
                        <td class="px-6 py-4 text-gray-600 max-w-xs truncate">
                            <div><i class="fa-solid fa-envelope text-xs text-gray-400 mr-1.5"></i> <?php echo e($sup->email ?? '-'); ?></div>
                            <div class="text-xs text-gray-400 mt-0.5 truncate"><i class="fa-solid fa-location-dot text-xs text-gray-400 mr-1.5"></i> <?php echo e($sup->address ?? '-'); ?></div>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800">
                                <?php echo e($sup->products_count); ?> Produk
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right space-x-2 whitespace-nowrap">
                            <a href="<?php echo e(route('suppliers.edit', $sup)); ?>" class="text-indigo-600 hover:text-indigo-800 font-medium text-xs bg-indigo-50 px-2.5 py-1.5 rounded transition">
                                <i class="fa-solid fa-pen-to-square mr-1"></i> Edit
                            </a>
                            <form action="<?php echo e(route('suppliers.destroy', $sup)); ?>" method="POST" class="inline" onsubmit="return confirm('Hapus supplier ini? Pasangan pada relasi many-to-many produk akan ikut terlepas.');">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="text-rose-600 hover:text-rose-800 font-medium text-xs bg-rose-50 px-2.5 py-1.5 rounded transition">
                                    <i class="fa-solid fa-trash mr-1"></i> Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-gray-400">Belum ada data supplier.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\inventory-laravel\resources\views/suppliers/index.blade.php ENDPATH**/ ?>