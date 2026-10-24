<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Inventory Management System') - Laravel P5</title>
    <!-- Tailwind CSS CDN & FontAwesome -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 flex flex-col min-h-screen">

    @include('layouts.navigation')

    <main class="flex-grow max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-6">

        <!-- Flash Messages (Slide 20, 23) -->
        @if (session('success'))
            <x-alert type="success">{{ session('success') }}</x-alert>
        @endif

        @if (session('error'))
            <x-alert type="error">{{ session('error') }}</x-alert>
        @endif

        @if (session('warning'))
            <x-alert type="warning">{{ session('warning') }}</x-alert>
        @endif

        @if (session('info'))
            <x-alert type="info">{{ session('info') }}</x-alert>
        @endif

        @yield('content')

    </main>

    <footer class="bg-white border-t border-gray-200 mt-auto py-6 text-center text-sm text-gray-500">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between">
            <div>
                &copy; {{ date('Y') }} <strong>Inventory Laravel</strong> &bull; Pertemuan 5 (MVC & Eloquent)
            </div>
            <div class="mt-2 sm:mt-0 text-xs text-gray-400">
                Route &rarr; Controller &rarr; Model &rarr; Database &rarr; Response
            </div>
        </div>
    </footer>

</body>
</html>
