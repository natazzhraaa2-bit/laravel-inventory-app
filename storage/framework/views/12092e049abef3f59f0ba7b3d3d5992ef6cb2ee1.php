<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Inventory Laravel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gradient-to-br from-indigo-900 via-indigo-800 to-purple-900 min-h-screen flex items-center justify-center p-4">

    <div class="max-w-md w-full bg-white rounded-2xl shadow-2xl overflow-hidden">
        <!-- Header Card -->
        <div class="bg-indigo-600 px-8 py-6 text-center text-white relative">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-white text-red-500 mb-3 shadow">
                <i class="fa-brands fa-laravel text-3xl"></i>
            </div>
            <h1 class="text-2xl font-bold tracking-tight">Inventory Laravel</h1>
            <p class="text-indigo-200 text-sm mt-1">Pertemuan 5: Laravel Fundamental & MVC</p>
        </div>

        <div class="p-8">
            <h2 class="text-xl font-bold text-gray-800 mb-2">Masuk ke Akun</h2>
            <p class="text-gray-500 text-sm mb-6">Gunakan akun admin atau staff untuk mengakses sistem.</p>

            <?php if(session('info')): ?>
                <div class="bg-blue-50 border-l-4 border-blue-500 text-blue-700 p-3.5 rounded mb-5 text-sm flex items-center">
                    <i class="fa-solid fa-circle-info mr-2 text-base"></i>
                    <span><?php echo e(session('info')); ?></span>
                </div>
            <?php endif; ?>

            <form action="<?php echo e(route('login.attempt')); ?>" method="POST" class="space-y-4">
                <?php echo csrf_field(); ?>

                <div>
                    <label for="username" class="block text-sm font-semibold text-gray-700 mb-1">Username</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                            <i class="fa-solid fa-user"></i>
                        </span>
                        <input type="text" name="username" id="username" required autofocus
                            value="<?php echo e(old('username')); ?>"
                            class="w-full pl-10 pr-4 py-2.5 border <?php $__errorArgs = ['username'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-rose-500 <?php else: ?> border-gray-300 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> rounded-lg focus:ring-2 focus:ring-indigo-500 text-sm transition"
                            placeholder="Contoh: admin atau staff">
                    </div>
                    <?php $__errorArgs = ['username'];
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
                    <label for="password" class="block text-sm font-semibold text-gray-700 mb-1">Password</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                            <i class="fa-solid fa-lock"></i>
                        </span>
                        <input type="password" name="password" id="password" required
                            class="w-full pl-10 pr-4 py-2.5 border <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-rose-500 <?php else: ?> border-gray-300 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> rounded-lg focus:ring-2 focus:ring-indigo-500 text-sm transition"
                            placeholder="Masukkan password">
                    </div>
                    <?php $__errorArgs = ['password'];
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

                <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2.5 px-4 rounded-lg shadow-md hover:shadow transition duration-150 flex items-center justify-center space-x-2">
                    <i class="fa-solid fa-right-to-bracket"></i>
                    <span>Masuk (Login)</span>
                </button>
            </form>

            <!-- Quick Demo Credentials Box -->
            <div class="mt-6 pt-5 border-t border-gray-100 bg-gray-50 -mx-8 -mb-8 p-6 rounded-b-2xl">
                <p class="text-xs font-bold uppercase tracking-wider text-gray-500 mb-2">Akun Demo (Seed):</p>
                <div class="grid grid-cols-2 gap-2 text-xs">
                    <button type="button" onclick="fillCreds('admin', 'admin123')" class="p-2 bg-white rounded border border-gray-200 hover:border-indigo-400 text-left transition">
                        <span class="font-bold text-indigo-700 block"><i class="fa-solid fa-shield-halved mr-1"></i> Admin</span>
                        <span class="text-gray-500">U: admin / P: admin123</span>
                    </button>
                    <button type="button" onclick="fillCreds('staff', 'staff123')" class="p-2 bg-white rounded border border-gray-200 hover:border-blue-400 text-left transition">
                        <span class="font-bold text-blue-700 block"><i class="fa-solid fa-user-check mr-1"></i> Staff</span>
                        <span class="text-gray-500">U: staff / P: staff123</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function fillCreds(u, p) {
            document.getElementById('username').value = u;
            document.getElementById('password').value = p;
        }
    </script>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\inventory-laravel\resources\views/auth/login.blade.php ENDPATH**/ ?>