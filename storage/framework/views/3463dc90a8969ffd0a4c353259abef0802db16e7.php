<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag; ?>
<?php foreach($attributes->onlyProps(['type' => 'info']) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps(['type' => 'info']); ?>
<?php foreach (array_filter((['type' => 'info']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>

<?php
    $classes = [
        'success' => 'bg-emerald-50 border-emerald-400 text-emerald-800',
        'error'   => 'bg-rose-50 border-rose-400 text-rose-800',
        'warning' => 'bg-amber-50 border-amber-400 text-amber-800',
        'info'    => 'bg-blue-50 border-blue-400 text-blue-800',
    ][$type] ?? 'bg-gray-50 border-gray-400 text-gray-800';

    $icon = [
        'success' => 'fa-circle-check text-emerald-500',
        'error'   => 'fa-circle-xmark text-rose-500',
        'warning' => 'fa-triangle-exclamation text-amber-500',
        'info'    => 'fa-circle-info text-blue-500',
    ][$type] ?? 'fa-info-circle text-gray-500';
?>

<div <?php echo e($attributes->merge(['class' => "flex items-center p-4 border-l-4 rounded-r-lg shadow-sm mb-4 {$classes}"])); ?>>
    <i class="fa-solid <?php echo e($icon); ?> text-xl mr-3"></i>
    <div class="text-sm font-medium">
        <?php echo e($slot); ?>

    </div>
</div>
<?php /**PATH C:\xampp\htdocs\inventory-laravel\resources\views/components/alert.blade.php ENDPATH**/ ?>