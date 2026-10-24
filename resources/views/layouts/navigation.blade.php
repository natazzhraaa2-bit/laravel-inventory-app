<header class="bg-indigo-900 text-white shadow-md sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <!-- Brand & Logo -->
            <div class="flex items-center space-x-3">
                <a href="{{ route('dashboard') }}" class="flex items-center space-x-2 font-bold text-xl tracking-tight text-white hover:text-indigo-200 transition">
                    <div class="w-9 h-9 bg-red-500 rounded-lg flex items-center justify-center text-white shadow">
                        <i class="fa-brands fa-laravel text-xl"></i>
                    </div>
                    <span>Inventory<span class="text-indigo-300">Laravel</span></span>
                </a>
                <span class="text-xs bg-indigo-800 text-indigo-200 px-2 py-0.5 rounded border border-indigo-700 hidden sm:inline-block">Pertemuan 5</span>
            </div>

            <!-- Navigation Links -->
            <nav class="hidden md:flex items-center space-x-1 text-sm font-medium">
                <a href="{{ route('dashboard') }}" class="px-3 py-2 rounded-md hover:bg-indigo-800 transition {{ request()->routeIs('dashboard') ? 'bg-indigo-800 text-white' : 'text-indigo-100' }}">
                    <i class="fa-solid fa-gauge mr-1.5"></i> Dashboard
                </a>
                <a href="{{ route('products.index') }}" class="px-3 py-2 rounded-md hover:bg-indigo-800 transition {{ request()->routeIs('products.*') ? 'bg-indigo-800 text-white' : 'text-indigo-100' }}">
                    <i class="fa-solid fa-box mr-1.5"></i> Produk
                </a>
                <a href="{{ route('categories.index') }}" class="px-3 py-2 rounded-md hover:bg-indigo-800 transition {{ request()->routeIs('categories.*') ? 'bg-indigo-800 text-white' : 'text-indigo-100' }}">
                    <i class="fa-solid fa-tags mr-1.5"></i> Kategori
                </a>
                <a href="{{ route('suppliers.index') }}" class="px-3 py-2 rounded-md hover:bg-indigo-800 transition {{ request()->routeIs('suppliers.*') ? 'bg-indigo-800 text-white' : 'text-indigo-100' }}">
                    <i class="fa-solid fa-truck-field mr-1.5"></i> Supplier
                </a>

                <!-- Dropdown Transaksi Mutasi Stok -->
                <div class="relative group">
                    <button class="px-3 py-2 rounded-md hover:bg-indigo-800 transition text-indigo-100 flex items-center space-x-1 {{ request()->routeIs('stock.*') ? 'bg-indigo-800 text-white' : '' }}">
                        <i class="fa-solid fa-right-left mr-1.5"></i>
                        <span>Mutasi Stok</span>
                        <i class="fa-solid fa-chevron-down text-xs ml-1"></i>
                    </button>
                    <div class="absolute left-0 mt-1 w-48 bg-white rounded-lg shadow-xl py-2 hidden group-hover:block text-gray-800 z-50 border border-gray-100">
                        <a href="{{ route('stock.in') }}" class="block px-4 py-2 hover:bg-emerald-50 text-emerald-700 text-sm font-medium">
                            <i class="fa-solid fa-arrow-down mr-2 text-emerald-500"></i> Barang Masuk (IN)
                        </a>
                        <a href="{{ route('stock.out') }}" class="block px-4 py-2 hover:bg-rose-50 text-rose-700 text-sm font-medium">
                            <i class="fa-solid fa-arrow-up mr-2 text-rose-500"></i> Barang Keluar (OUT)
                        </a>
                        <div class="border-t border-gray-100 my-1"></div>
                        <a href="{{ route('stock.history') }}" class="block px-4 py-2 hover:bg-gray-100 text-gray-700 text-sm font-medium">
                            <i class="fa-solid fa-clock-rotate-left mr-2 text-indigo-500"></i> Riwayat Mutasi
                        </a>
                    </div>
                </div>

                <a href="{{ route('reports.index') }}" class="px-3 py-2 rounded-md hover:bg-indigo-800 transition {{ request()->routeIs('reports.*') ? 'bg-indigo-800 text-white' : 'text-indigo-100' }}">
                    <i class="fa-solid fa-chart-pie mr-1.5"></i> Laporan
                </a>

                @if(Auth::check() && Auth::user()->isAdmin())
                <a href="{{ route('users.index') }}" class="px-3 py-2 rounded-md hover:bg-indigo-800 transition {{ request()->routeIs('users.*') ? 'bg-indigo-800 text-white' : 'text-indigo-100' }}">
                    <i class="fa-solid fa-users-gear mr-1.5"></i> Pengguna
                </a>
                @endif
            </nav>

            <!-- User Info & Logout -->
            <div class="flex items-center space-x-3">
                @auth
                    <div class="text-right hidden sm:block">
                        <div class="text-sm font-semibold leading-tight text-white">{{ Auth::user()->name }}</div>
                        <div class="text-xs">
                            <span class="inline-block px-1.5 py-0.2 rounded font-semibold {{ Auth::user()->isAdmin() ? 'bg-purple-600 text-white' : 'bg-blue-600 text-white' }}">
                                {{ strtoupper(Auth::user()->role) }}
                            </span>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" onclick="return confirm('Apakah Anda yakin ingin logout?');" class="bg-red-600 hover:bg-red-700 text-white p-2 sm:px-3 sm:py-1.5 rounded-lg text-sm font-medium transition flex items-center space-x-1" title="Logout">
                            <i class="fa-solid fa-right-from-bracket"></i>
                            <span class="hidden sm:inline">Logout</span>
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm font-medium">Login</a>
                @endauth
            </div>
        </div>
    </div>
</header>
