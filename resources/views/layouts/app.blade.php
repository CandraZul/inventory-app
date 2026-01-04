<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - Inventory TIK</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{asset('styles/sidebar.css')}}">

    @stack('styles')
</head>
<body class="font-sans bg-gray-50 ">
<!-- Sidebar & Navbar untuk user terautentikasi -->
@auth
    @php
        $isAdmin = auth()->user()->hasRole('admin');
        $isUser = auth()->user()->hasRole('mahasiswa');
        $dashboardRoute = $isAdmin ? route('dashboard') : route('borrowing.dashboard');
        $dashboardName = $isAdmin ? 'Dashboard' : 'Dashboard User';
    @endphp

    <div class="flex h-screen">
        <!-- Sidebar Overlay untuk Mobile -->
        <div id="sidebar-overlay" class="fixed inset-0 bg-gray-900 bg-opacity-50 z-40 md:hidden hidden"></div>

        <!-- Sidebar -->
        <aside id="sidebar" class="fixed md:relative flex flex-col shrink-0 sidebar-transition z-50
            {{ session('sidebar_collapsed') ? 'w-20' : 'w-64' }}
            h-full bg-white border-r border-gray-200 md:translate-x-0 -translate-x-full">

            <!-- Logo -->
            <div class="flex items-center justify-between h-16 px-4 border-b border-gray-200">
                <div class="flex items-center space-x-3 overflow-hidden">
                    <div class="logo-icon shrink-0 bg-accent-500 rounded-lg flex items-center justify-center
                                transition-all duration-300
                                w-8 h-8">
                        <i class="fas fa-laptop-code text-white transition-all duration-300 text-sm"></i>
                    </div>
                    <div class="sidebar-text flex flex-col">
                        <span class="text-lg font-semibold text-gray-800 whitespace-nowrap">Inventory TIK</span>
                        <span class="text-xs px-2 py-1 rounded {{ $isAdmin ? 'bg-purple-100 text-purple-700' : 'bg-blue-100 text-blue-700' }}">
                            {{ $isAdmin ? 'Admin' : 'User' }}
                        </span>
                    </div>
                </div>

                <!-- Toggle Button untuk Desktop -->
                <button id="sidebar-toggle" class="hidden md:flex p-1.5 rounded-lg hover:bg-gray-100 text-gray-500">
                    <i id="sidebar-toggle-icon"
                       class="fas {{ session('sidebar_collapsed') ? 'fa-chevron-right' : 'fa-chevron-left' }} text-sm">
                    </i>

                </button>
            </div>

            <!-- Navigation -->
            <div class="flex flex-col flex-1 px-3 py-6 overflow-y-auto sidebar-scrollbar">
                <nav class="space-y-1">

                    <!-- ========== MENU SUPER ADMIN & ADMIN (APPROVAL) ========== -->
                    @hasanyrole('admin|super admin')
                    <!-- Dashboard -->
                    <a href="{{ route('dashboard') }}"
                       class="sidebar-item flex items-center px-3 py-2.5 rounded-lg
              {{ request()->routeIs('dashboard') ? 'active-sidebar-item text-accent-600' : 'text-gray-700 hover:text-gray-900' }}">
                        <i class="fas fa-tachometer-alt w-5 text-center
                 {{ request()->routeIs('dashboard') ? 'text-accent-600' : 'text-gray-500' }}"></i>
                            <span class="sidebar-text ml-3 font-medium">Dashboard</span>
                    </a>

                    <!-- Inventori -->
                    <a href="{{ route('inventory.index') }}"
                       class="sidebar-item flex items-center px-3 py-2.5 rounded-lg
              {{ request()->routeIs('inventory.*') ? 'active-sidebar-item text-accent-600' : 'text-gray-700 hover:text-gray-900' }}">
                        <i class="fas fa-boxes w-5 text-center
                 {{ request()->routeIs('inventory.*') ? 'text-accent-600' : 'text-gray-500' }}"></i>
                            <span class="sidebar-text ml-3 font-medium">Inventori</span>
                    </a>

                    <!-- Manajemen User -->
                    <a href="{{ route('users.index') }}"
                       class="sidebar-item flex items-center px-3 py-2.5 rounded-lg
              {{ request()->routeIs('users.*') ? 'active-sidebar-item text-accent-600' : 'text-gray-700 hover:text-gray-900' }}">
                        <i class="fas fa-users w-5 text-center
                 {{ request()->routeIs('users.*') ? 'text-accent-600' : 'text-gray-500' }}"></i>
                            <span class="sidebar-text ml-3 font-medium">Pengguna</span>
                    </a>

                    <!-- Approval Pengajuan Peminjaman -->
                    <a href="{{ route('approval.peminjaman.index') }}"
                       class="sidebar-item flex items-center px-3 py-2.5 rounded-lg
              {{ request()->routeIs('approval.peminjaman.*') ? 'active-sidebar-item text-accent-600 bg-accent-50' : 'text-gray-700 hover:text-gray-900' }}">
                        <i class="fas fa-clipboard-check w-5 text-center
                 {{ request()->routeIs('approval.peminjaman.*') ? 'text-accent-600' : 'text-gray-500' }}"></i>
                            <span class="sidebar-text ml-3 font-medium">Approval Peminjaman</span>
                    </a>
                    <!-- Riwayat Peminjaman (Admin & Super Admin) -->
                    <a href="{{ route('admin.riwayat.index') }}"
                       class="sidebar-item flex items-center px-3 py-2.5 rounded-lg
       {{ request()->routeIs('admin.riwayat.*') ? 'active-sidebar-item text-accent-600 bg-accent-50' : 'text-gray-700 hover:text-gray-900' }}">
                        <i class="fas fa-history w-5 text-center
        {{ request()->routeIs('admin.riwayat.*') ? 'text-accent-600' : 'text-gray-500' }}"></i>
                            <span class="sidebar-text ml-3 font-medium">Riwayat Peminjaman</span>
                    </a>
                    <!-- Surat Peminjaman Admin Area -->
                    <a href="{{ route('admin.surat.index') }}"
                        class="sidebar-item flex items-center px-3 py-2.5 rounded-lg {{ request()->routeIs('admin.surat.*') ? 'active-sidebar-item text-accent-600 bg-accent-50' : 'text-gray-700 hover:text-gray-900' }}">
                        <i class="fas fa-file-alt w-5 text-center {{ request()->routeIs('admin.surat.*') ? 'text-accent-600' : 'text-gray-500' }}"></i>
                        <span class="sidebar-text ml-3 font-medium">Surat Peminjaman</span>
                    </a>
        

                    @endhasanyrole

                    <!-- ========== MENU DOSEN & MAHASISWA (UI SAMA) ========== -->
                    @hasanyrole('dosen|mahasiswa')
                    <a href="{{ route('borrowing.dashboard') }}"
                       class="sidebar-item flex items-center px-3 py-2.5 rounded-lg {{ request()->routeIs('borrowing.dashboard') ? 'active-sidebar-item text-accent-600' : 'text-gray-700 hover:text-gray-900' }}">
                        <i class="fas fa-home w-5 text-center {{ request()->routeIs('borrowing.dashboard') ? 'text-accent-600' : 'text-gray-500' }}"></i>
                            <span class="sidebar-text ml-3 font-medium">Beranda</span>
                    </a>

                    <a href="{{ route('borrowing.pinjam') }}"
                       class="sidebar-item flex items-center px-3 py-2.5 rounded-lg {{ request()->routeIs('borrowing.pinjam') ? 'active-sidebar-item text-accent-600' : 'text-gray-700 hover:text-gray-900' }}">
                        <i class="fas fa-cart-plus w-5 text-center {{ request()->routeIs('borrowing.pinjam') ? 'text-accent-600' : 'text-gray-500' }}"></i>
                            <span class="sidebar-text ml-3 font-medium">Pinjam Barang</span>
                    </a>

                    <a href="{{ route('borrowing.cart') }}"
                       class="sidebar-item flex items-center px-3 py-2.5 rounded-lg {{ request()->routeIs('borrowing.cart') ? 'active-sidebar-item text-accent-600' : 'text-gray-700 hover:text-gray-900' }}">
                        <i class="fas fa-shopping-cart w-5 text-center {{ request()->routeIs('borrowing.cart') ? 'text-accent-600' : 'text-gray-500' }}"></i>
                            <span class="sidebar-text ml-3 font-medium">Keranjang Saya</span>
                    </a>

                    <a href="{{ route('borrowing.riwayat') }}"
                       class="sidebar-item flex items-center px-3 py-2.5 rounded-lg {{ request()->routeIs('borrowing.riwayat') ? 'active-sidebar-item text-accent-600' : 'text-gray-700 hover:text-gray-900' }}">
                        <i class="fas fa-history w-5 text-center {{ request()->routeIs('borrowing.riwayat') ? 'text-accent-600' : 'text-gray-500' }}"></i>
                            <span class="sidebar-text ml-3 font-medium">Riwayat Saya</span>
                    </a>

                    <!-- Surat Saya -->
                    <div class="space-y-1">
                        <button type="button" onclick="toggleSuratMenu()"
                                class="sidebar-item w-full flex items-center justify-between px-3 py-2.5 rounded-lg {{ request()->routeIs('borrowing.surat.*') ? 'active-sidebar-item text-accent-600' : 'text-gray-700 hover:text-gray-900' }}">
                            <div class="flex items-center">
                                <i class="fas fa-file-alt w-5 text-center {{ request()->routeIs('borrowing.surat.*') ? 'text-accent-600' : 'text-gray-500' }}"></i>
                                    <span class="sidebar-text ml-3 font-medium">Surat Saya</span>
                            </div>
                                <i id="surat-arrow"
                                   class="fas fa-chevron-down text-xs text-gray-400 transition-transform duration-200"></i>
                        </button>
                            <div id="surat-submenu"
                                 class="ml-10 space-y-1 mt-1 {{ request()->routeIs('borrowing.surat.*') ? '' : 'hidden' }}">
                                <a href="{{ route('borrowing.surat.upload') }}"
                                   class="sidebar-item flex items-center px-3 py-2 rounded-lg text-sm {{ request()->routeIs('borrowing.surat.upload') ? 'text-accent-600 bg-accent-50' : 'text-gray-600 hover:text-gray-900' }}">
                                    <i class="fas fa-upload w-4 text-center mr-2"></i> Upload Surat
                                </a>
                                <a href="{{ route('borrowing.surat.list') }}"
                                   class="sidebar-item flex items-center px-3 py-2 rounded-lg text-sm {{ request()->routeIs('borrowing.surat.list') ? 'text-accent-600 bg-accent-50' : 'text-gray-600 hover:text-gray-900' }}">
                                    <i class="fas fa-list w-4 text-center mr-2"></i> Daftar Surat
                                </a>
                            </div>
                    </div>
                    @endhasanyrole

                    <!-- Separator tetap dipertahankan -->
                    <div class="pt-4">
                        <div class="{{ !session('sidebar_collapsed') ? 'px-3' : '' }}">
                            <div class="border-t border-gray-200"></div>
                        </div>
                    </div>

                    <!-- Profil (tidak dibatasi role, tetap muncul semua user login) -->
                    <a href="{{ route('profile') }}"
                       class="sidebar-item flex items-center px-3 py-2.5 rounded-lg {{ request()->routeIs('profile') ? 'active-sidebar-item text-accent-600' : 'text-gray-700 hover:text-gray-900' }}">
                        <i class="fas fa-user w-5 text-center {{ request()->routeIs('profile') ? 'text-accent-600' : 'text-gray-500' }}"></i>
                            <span class="sidebar-text ml-3 font-medium">Profil Saya</span>
                    </a>

                    <!-- Logout (tidak diubah, tetap dipertahankan) -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                                class="sidebar-item flex items-center w-full px-3 py-2.5 rounded-lg text-gray-700 hover:text-gray-900 hover:bg-gray-50">
                            <i class="fas fa-sign-out-alt w-5 text-center text-gray-500"></i>
                                <span class="sidebar-text ml-3 font-medium">Keluar</span>
                        </button>
                    </form>

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
                                    <a href="{{ $dashboardRoute }}"
                                       class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-gray-700">
                                        <i class="fas fa-home mr-2"></i>
                                        {{ $dashboardName }}
                                    </a>
                                </li>
                                @if($isUser)
                                    @if(request()->routeIs('borrowing.pinjam'))
                                        <li>
                                            <div class="flex items-center">
                                                <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                                                <span class="ml-1 text-sm font-medium text-gray-700">
                                                    Pinjam Barang
                                                </span>
                                            </div>
                                        </li>
                                    @elseif(request()->routeIs('borrowing.cart'))
                                        <li>
                                            <div class="flex items-center">
                                                <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                                                <span class="ml-1 text-sm font-medium text-gray-700">
                                                    Keranjang Saya
                                                </span>
                                            </div>
                                        </li>
                                    @elseif(request()->routeIs('borrowing.riwayat'))
                                        <li>
                                            <div class="flex items-center">
                                                <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                                                <span class="ml-1 text-sm font-medium text-gray-700">
                                                    Riwayat Peminjaman
                                                </span>
                                            </div>
                                        </li>
                                    @elseif(request()->routeIs('borrowing.surat.*'))
                                        <li>
                                            <div class="flex items-center">
                                                <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                                                <span class="ml-1 text-sm font-medium text-gray-700">
                                                    Surat Saya
                                                </span>
                                            </div>
                                        </li>
                                    @endif
                                @endif
                            </ol>
                        </nav>
                    </div>
                </div>

                <!-- Right: Notifications & Profile -->
                <div class="flex items-center space-x-4">
                    @if($isUser)
                        <!-- Cart Indicator for User -->
                        @php
                            $cartCount = count(session()->get('borrowing_cart', []));
                        @endphp
                        <div class="relative">
                            <a href="{{ route('borrowing.cart') }}"
                               class="p-2 rounded-lg hover:bg-gray-100 text-gray-600 relative">
                                <i class="fas fa-shopping-cart text-lg"></i>
                                @if($cartCount > 0)
                                    <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs w-5 h-5 rounded-full flex items-center justify-center">
                                    {{ $cartCount }}
                                </span>
                                @endif
                            </a>
                        </div>
                    @endif

                    <!-- Profile Dropdown -->
                    <div class="relative">
                        <button id="profile-button"
                                class="flex items-center space-x-3 p-1.5 rounded-lg hover:bg-gray-100">
                            <div class="w-8 h-8 rounded-full bg-accent-100 flex items-center justify-center text-accent-600 font-semibold">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                            <div class="hidden md:block text-left">
                                <p class="text-sm font-medium text-gray-800">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-gray-500 {{ $isAdmin ? 'text-purple-600' : 'text-blue-600' }}">
                                    {{ ucfirst(Auth::user()->role) }}
                                </p>
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
                            <div class="shrink-0">
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
                            <div class="shrink-0">
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
                            <div class="shrink-0">
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


    <script src="{{asset("scripts/sidebar-toggle.js")}}"></script>
    <script src="{{asset('scripts/tailwind-config.js')}}"></script>

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
