<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title') - Inventory TIK</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#f8fafc',
                            100: '#f1f5f9',
                            200: '#e2e8f0',
                            300: '#cbd5e1',
                            400: '#94a3b8',
                            500: '#64748b',
                            600: '#475569',
                            700: '#334155',
                            800: '#1e293b',
                            900: '#0f172a',
                        },
                        accent: {
                            500: '#3b82f6',
                            600: '#2563eb',
                        }
                    },
                    fontFamily: {
                        'sans': ['Inter', 'sans-serif']
                    },
                    transitionProperty: {
                        'width': 'width',
                        'spacing': 'margin, padding',
                    }
                }
            }
        }
    </script>

    <style>
        .sidebar-transition {
            transition: all 0.3s ease-in-out;
        }

        .sidebar-item {
            transition: all 0.2s ease;
        }

        .sidebar-item:hover {
            background-color: rgba(100, 116, 139, 0.08);
            transform: translateX(2px);
        }

        .active-sidebar-item {
            background-color: rgba(59, 130, 246, 0.1);
            border-left: 3px solid #3b82f6;
        }

        /* Scrollbar styling */
        .sidebar-scrollbar::-webkit-scrollbar {
            width: 4px;
        }

        .sidebar-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }

        .sidebar-scrollbar::-webkit-scrollbar-thumb {
            background: rgba(100, 116, 139, 0.2);
            border-radius: 2px;
        }

        .sidebar-scrollbar::-webkit-scrollbar-thumb:hover {
            background: rgba(100, 116, 139, 0.3);
        }
    </style>

    @stack('styles')
</head>
<body class="font-sans bg-gray-50">
<!-- Sidebar & Navbar untuk user terautentikasi -->
@auth
    <div class="flex h-screen">
        <!-- Sidebar Overlay untuk Mobile -->
        <div id="sidebar-overlay" class="fixed inset-0 bg-gray-900 bg-opacity-50 z-40 md:hidden hidden"></div>

        <!-- Sidebar -->
        <aside id="sidebar" class="fixed md:relative flex flex-col flex-shrink-0 sidebar-transition z-50
            {{ session('sidebar_collapsed') ? 'w-20' : 'w-64' }}
            h-full bg-white border-r border-gray-200">

            <!-- Logo -->
            <div class="flex items-center justify-between h-16 px-4 border-b border-gray-200">
                <div class="flex items-center space-x-3 overflow-hidden">
                    <div class="flex-shrink-0 w-8 h-8 bg-accent-500 rounded-lg flex items-center justify-center">
                        <i class="fas fa-laptop-code text-white text-sm"></i>
                    </div>
                    @if(!session('sidebar_collapsed'))
                        <span class="text-lg font-semibold text-gray-800 whitespace-nowrap">Inventory TIK</span>
                    @endif
                </div>

                <!-- Toggle Button untuk Desktop -->
                @if(!request()->isMobile())
                    <button id="sidebar-toggle" class="hidden md:flex p-1.5 rounded-lg hover:bg-gray-100 text-gray-500">
                        <i class="fas {{ session('sidebar_collapsed') ? 'fa-chevron-right' : 'fa-chevron-left' }} text-sm"></i>
                    </button>
                @endif
            </div>

            <!-- Navigation -->
            <div class="flex flex-col flex-1 px-3 py-6 overflow-y-auto sidebar-scrollbar">
                <nav class="space-y-1">
                    <!-- Dashboard -->
                    <a href="{{ route('dashboard') }}"
                       class="sidebar-item flex items-center px-3 py-2.5 rounded-lg {{ request()->routeIs('dashboard') ? 'active-sidebar-item text-accent-600' : 'text-gray-700 hover:text-gray-900' }}">
                        <i class="fas fa-tachometer-alt w-5 text-center {{ request()->routeIs('dashboard') ? 'text-accent-600' : 'text-gray-500' }}"></i>
                        @if(!session('sidebar_collapsed'))
                            <span class="ml-3 font-medium">Dashboard</span>
                        @endif
                    </a>

                    <!-- Inventori -->
                    @can('view inventory')
                        <a href="{{ route('inventory.index') }}"
                           class="sidebar-item flex items-center px-3 py-2.5 rounded-lg {{ request()->routeIs('inventory.*') ? 'active-sidebar-item text-accent-600' : 'text-gray-700 hover:text-gray-900' }}">
                            <i class="fas fa-boxes w-5 text-center {{ request()->routeIs('inventory.*') ? 'text-accent-600' : 'text-gray-500' }}"></i>
                            @if(!session('sidebar_collapsed'))
                                <span class="ml-3 font-medium">Inventori</span>
                            @endif
                        </a>
                    @endcan

                    <!-- Peminjaman -->
                    @can('view borrowings')
                        <a href="#"
                           class="sidebar-item flex items-center px-3 py-2.5 rounded-lg {{ request()->routeIs('borrowing.*') ? 'active-sidebar-item text-accent-600' : 'text-gray-700 hover:text-gray-900' }}">
                            <i class="fas fa-handshake w-5 text-center {{ request()->routeIs('borrowing.*') ? 'text-accent-600' : 'text-gray-500' }}"></i>
                            @if(!session('sidebar_collapsed'))
                                <span class="ml-3 font-medium">Peminjaman</span>
                            @endif
                        </a>
                    @endcan

                    <!-- Pengembalian -->
                    @can('view returns')
                        <a href="#"
                           class="sidebar-item flex items-center px-3 py-2.5 rounded-lg {{ request()->routeIs('return.*') ? 'active-sidebar-item text-accent-600' : 'text-gray-700 hover:text-gray-900' }}">
                            <i class="fas fa-undo-alt w-5 text-center {{ request()->routeIs('return.*') ? 'text-accent-600' : 'text-gray-500' }}"></i>
                            @if(!session('sidebar_collapsed'))
                                <span class="ml-3 font-medium">Pengembalian</span>
                            @endif
                        </a>
                    @endcan

                    <!-- Laporan -->
                    @can('view reports')
                        <a href="#"
                           class="sidebar-item flex items-center px-3 py-2.5 rounded-lg {{ request()->routeIs('reports.*') ? 'active-sidebar-item text-accent-600' : 'text-gray-700 hover:text-gray-900' }}">
                            <i class="fas fa-chart-bar w-5 text-center {{ request()->routeIs('reports.*') ? 'text-accent-600' : 'text-gray-500' }}"></i>
                            @if(!session('sidebar_collapsed'))
                                <span class="ml-3 font-medium">Laporan</span>
                            @endif
                        </a>
                    @endcan

                    <!-- Manajemen User -->
                    @can('view users')
                        <a href="{{ route('users.index') }}"
                           class="sidebar-item flex items-center px-3 py-2.5 rounded-lg {{ request()->routeIs('users.*') ? 'active-sidebar-item text-accent-600' : 'text-gray-700 hover:text-gray-900' }}">
                            <i class="fas fa-users w-5 text-center {{ request()->routeIs('users.*') ? 'text-accent-600' : 'text-gray-500' }}"></i>
                            @if(!session('sidebar_collapsed'))
                                <span class="ml-3 font-medium">Pengguna</span>
                            @endif
                        </a>
                    @endcan

                    <!-- Pengaturan -->
                    @can('view settings')
                        <a href="#"
                           class="sidebar-item flex items-center px-3 py-2.5 rounded-lg {{ request()->routeIs('settings.*') ? 'active-sidebar-item text-accent-600' : 'text-gray-700 hover:text-gray-900' }}">
                            <i class="fas fa-cog w-5 text-center {{ request()->routeIs('settings.*') ? 'text-accent-600' : 'text-gray-500' }}"></i>
                            @if(!session('sidebar_collapsed'))
                                <span class="ml-3 font-medium">Pengaturan</span>
                            @endif
                        </a>
                    @endcan
                </nav>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex flex-col flex-1 overflow-hidden">
            <!-- Topbar -->
            <header class="flex items-center justify-between h-16 bg-white border-b border-gray-200 px-4 md:px-6">
                <!-- Left: Mobile menu button -->
                <div class="flex items-center">
                    <button id="mobile-menu-button" class="md:hidden p-2 rounded-lg hover:bg-gray-100 text-gray-600">
                        <i class="fas fa-bars text-lg"></i>
                    </button>

                    <!-- Breadcrumb -->
                    <div class="hidden md:flex items-center ml-4">
                        <nav class="flex" aria-label="Breadcrumb">
                            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                                <li class="inline-flex items-center">
                                    <a href="{{ route('dashboard') }}" class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-gray-700">
                                        <i class="fas fa-home mr-2"></i>
                                        Dashboard
                                    </a>
                                </li>
                                @if(isset($breadcrumbs))
                                    @foreach($breadcrumbs as $breadcrumb)
                                        <li>
                                            <div class="flex items-center">
                                                <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                                                <a href="{{ $breadcrumb['url'] ?? '#' }}"
                                                   class="ml-1 text-sm font-medium text-gray-700 hover:text-accent-600">
                                                    {{ $breadcrumb['name'] }}
                                                </a>
                                            </div>
                                        </li>
                                    @endforeach
                                @endif
                            </ol>
                        </nav>
                    </div>
                </div>

                <!-- Right: Notifications & Profile -->
                <div class="flex items-center space-x-4">
                    <!-- Notifications -->
                    <div class="relative">
                        <button id="notification-button" class="p-2 rounded-lg hover:bg-gray-100 text-gray-600 relative">
                            <i class="fas fa-bell text-lg"></i>
                            <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                        </button>

                        <!-- Notification Dropdown -->
                        <div id="notification-dropdown"
                             class="absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-lg border border-gray-200 hidden z-50">
                            <div class="p-4 border-b border-gray-200">
                                <h3 class="font-semibold text-gray-800">Notifikasi</h3>
                            </div>
                            <div class="max-h-96 overflow-y-auto">
                                <!-- Notification items would go here -->
                                <div class="p-4 border-b border-gray-100 hover:bg-gray-50">
                                    <p class="text-sm text-gray-700">Item "Laptop Dell" harus dikembalikan hari ini</p>
                                    <p class="text-xs text-gray-500 mt-1">2 jam yang lalu</p>
                                </div>
                            </div>
                            <div class="p-3 border-t border-gray-200">
                                <a href="#" class="text-sm text-accent-600 hover:text-accent-700 font-medium">
                                    Lihat semua notifikasi
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Profile Dropdown -->
                    <div class="relative">
                        <button id="profile-button" class="flex items-center space-x-3 p-1.5 rounded-lg hover:bg-gray-100">
                            <div class="w-8 h-8 rounded-full bg-accent-100 flex items-center justify-center text-accent-600 font-semibold">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                            <div class="hidden md:block text-left">
                                <p class="text-sm font-medium text-gray-800">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-gray-500">{{ ucfirst(Auth::user()->role) }}</p>
                            </div>
                            <i class="fas fa-chevron-down text-gray-500 text-sm hidden md:block"></i>
                        </button>

                        <!-- Profile Dropdown Menu -->
                        <div id="profile-dropdown"
                             class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 hidden z-50">
                            <div class="py-2">
                                <a href="{{ route('profile') }}"
                                   class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-user mr-3 text-gray-500"></i>
                                    Profil Saya
                                </a>
                                <a href="#"
                                   class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-cog mr-3 text-gray-500"></i>
                                    Pengaturan
                                </a>
                                <div class="border-t border-gray-200 my-1"></div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                            class="w-full text-left flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-sign-out-alt mr-3 text-gray-500"></i>
                                        Keluar
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Content Area -->
            <main class="flex-1 overflow-y-auto bg-gray-50 p-4 md:p-6">
                <!-- Page Header -->
                <div class="mb-6">
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-800">@yield('title')</h1>
                    @hasSection('subtitle')
                        <p class="text-gray-600 mt-2">@yield('subtitle')</p>
                    @endif
                </div>

                <!-- Notifikasi -->
                @if(session('success'))
                    <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg" role="alert">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <i class="fas fa-check-circle text-green-500 text-lg"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg" role="alert">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <i class="fas fa-exclamation-circle text-red-500 text-lg"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                @if(session('info'))
                    <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg" role="alert">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <i class="fas fa-info-circle text-blue-500 text-lg"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-blue-800">{{ session('info') }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Page Content -->
                @yield('content')
            </main>
        </div>
    </div>

    <script>
        // Sidebar state
        const sidebar = document.getElementById('sidebar');
        const sidebarToggle = document.getElementById('sidebar-toggle');
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const sidebarOverlay = document.getElementById('sidebar-overlay');
        const notificationButton = document.getElementById('notification-button');
        const notificationDropdown = document.getElementById('notification-dropdown');
        const profileButton = document.getElementById('profile-button');
        const profileDropdown = document.getElementById('profile-dropdown');

        // Toggle sidebar for desktop
        if (sidebarToggle) {
            sidebarToggle.addEventListener('click', function() {
                const isCollapsed = sidebar.classList.contains('w-20');

                if (isCollapsed) {
                    sidebar.classList.remove('w-20');
                    sidebar.classList.add('w-64');
                    sidebarToggle.innerHTML = '<i class="fas fa-chevron-left text-sm"></i>';
                } else {
                    sidebar.classList.remove('w-64');
                    sidebar.classList.add('w-20');
                    sidebarToggle.innerHTML = '<i class="fas fa-chevron-right text-sm"></i>';
                }

                // Save state to session
                fetch('{{ route("toggle-sidebar") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ collapsed: !isCollapsed })
                });
            });
        }

        // Toggle mobile sidebar
        if (mobileMenuButton) {
            mobileMenuButton.addEventListener('click', function() {
                sidebar.classList.toggle('-translate-x-full');
                sidebarOverlay.classList.toggle('hidden');
            });
        }

        // Close mobile sidebar when clicking overlay
        if (sidebarOverlay) {
            sidebarOverlay.addEventListener('click', function() {
                sidebar.classList.add('-translate-x-full');
                sidebarOverlay.classList.add('hidden');
            });
        }

        // Toggle notifications dropdown
        if (notificationButton && notificationDropdown) {
            notificationButton.addEventListener('click', function(e) {
                e.stopPropagation();
                notificationDropdown.classList.toggle('hidden');
                profileDropdown.classList.add('hidden');
            });
        }

        // Toggle profile dropdown
        if (profileButton && profileDropdown) {
            profileButton.addEventListener('click', function(e) {
                e.stopPropagation();
                profileDropdown.classList.toggle('hidden');
                notificationDropdown.classList.add('hidden');
            });
        }

        // Close dropdowns when clicking outside
        document.addEventListener('click', function(e) {
            if (notificationDropdown && !notificationDropdown.contains(e.target) &&
                notificationButton && !notificationButton.contains(e.target)) {
                notificationDropdown.classList.add('hidden');
            }

            if (profileDropdown && !profileDropdown.contains(e.target) &&
                profileButton && !profileButton.contains(e.target)) {
                profileDropdown.classList.add('hidden');
            }
        });

        // Close dropdowns on escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                if (notificationDropdown) notificationDropdown.classList.add('hidden');
                if (profileDropdown) profileDropdown.classList.add('hidden');
            }
        });

        // Initialize sidebar state from session
        document.addEventListener('DOMContentLoaded', function() {
            const isCollapsed = {{ session('sidebar_collapsed') ? 'true' : 'false' }};

            if (isCollapsed) {
                sidebar.classList.remove('w-64');
                sidebar.classList.add('w-20');
                if (sidebarToggle) {
                    sidebarToggle.innerHTML = '<i class="fas fa-chevron-right text-sm"></i>';
                }
            }
        });
    </script>
@endauth

<!-- Konten untuk guest (login/register) -->
@guest
    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 flex flex-col justify-center py-12 sm:px-6 lg:px-8">
        @yield('content')
    </div>
@endguest

@stack('scripts')
</body>
</html>
