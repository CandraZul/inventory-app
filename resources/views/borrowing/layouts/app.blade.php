<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Peminjaman Lab')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background-color: #f5f7fa;
        }
        
        /* SIDEBAR CONTAINER */
        .sidebar-container {
            position: fixed;
            left: 0;
            top: 0;
            height: 100vh;
            z-index: 1000;
            display: flex;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        /* SIDEBAR - Warna putih sesuai desain */
        .sidebar {
            width: 256px;
            background: white;
            color: #374151;
            padding: 0;
            height: 100vh;
            border-right: 1px solid #e5e7eb;
            overflow-y: auto;
            overflow-x: hidden;
            position: relative;
            display: flex;
            flex-direction: column;
        }
        
        /* Sidebar collapsed */
        .sidebar-collapsed {
            width: 80px !important;
        }
        
        .sidebar-collapsed .brand-text,
        .sidebar-collapsed .menu-item span,
        .sidebar-collapsed .user-name,
        .sidebar-collapsed .user-email {
            display: none !important;
        }
        
        .sidebar-collapsed .menu-item {
            justify-content: center;
            padding: 12px 0 !important;
            border-radius: 8px;
            margin: 8px 10px !important;
        }
        
        .sidebar-collapsed .menu-item i {
            margin-right: 0 !important;
            font-size: 18px !important;
        }
        
        /* HEADER SIDEBAR */
        .sidebar-header {
            height: 64px;
            padding: 0 16px;
            border-bottom: 1px solid #e5e7eb;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        
        .logo-container {
            display: flex;
            align-items: center;
            gap: 12px;
            overflow: hidden;
        }
        
        .logo-icon {
            width: 32px;
            height: 32px;
            background: #3b82f6;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        
        .logo-icon i {
            color: white;
            font-size: 14px;
        }
        
        .logo-text {
            font-size: 18px;
            font-weight: 600;
            color: #1f2937;
            white-space: nowrap;
        }
        
        /* TOGGLE BUTTON */
        .sidebar-toggle-container {
            position: relative;
            width: 0;
        }
        
        .sidebar-toggle {
            position: absolute;
            top: 20px;
            left: -15px;
            background: #3b82f6;
            color: white;
            border: 3px solid white;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            z-index: 1001;
            box-shadow: 0 3px 10px rgba(0,0,0,0.2);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            font-size: 14px;
        }

        /* Hover effect */
        .sidebar-toggle:hover {
            background: #2563eb;
            transform: scale(1.1);
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
        }

        /* Menu Container */
        .sidebar-menu {
            padding: 16px;
            flex: 1;
            overflow-y: auto;
        }
        
        /* Menu Items */
        .menu-item {
            color: #4b5563;
            text-decoration: none;
            display: flex;
            align-items: center;
            padding: 12px 16px;
            margin: 8px 0;
            border-radius: 8px;
            transition: all 0.2s;
            white-space: nowrap;
            position: relative;
            background: transparent;
        }
        
        .menu-item:hover {
            background: #f3f4f6;
            color: #1f2937;
        }
        
        .menu-item.active {
            background: #3b82f6;
            color: white;
            font-weight: 500;
        }
        
        .menu-item.active:hover {
            background: #2563eb;
        }
        
        .menu-item i {
            margin-right: 12px;
            width: 20px;
            text-align: center;
            font-size: 16px;
            flex-shrink: 0;
        }
        
        .menu-item.active i {
            color: white;
        }
        
        /* Tooltip untuk menu collapsed */
        .menu-tooltip {
            position: absolute;
            left: 100%;
            top: 50%;
            transform: translateY(-50%);
            background: #1f2937;
            color: white;
            padding: 6px 10px;
            border-radius: 6px;
            font-size: 13px;
            white-space: nowrap;
            opacity: 0;
            visibility: hidden;
            transition: all 0.2s;
            pointer-events: none;
            z-index: 1000;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
            margin-left: 10px;
        }
        
        .menu-tooltip::before {
            content: '';
            position: absolute;
            left: -5px;
            top: 50%;
            transform: translateY(-50%);
            border-top: 5px solid transparent;
            border-bottom: 5px solid transparent;
            border-right: 5px solid #1f2937;
        }
        
        .sidebar-collapsed .menu-item:hover .menu-tooltip {
            opacity: 1;
            visibility: visible;
        }
        
        /* User Info di Bawah Sidebar */
        .sidebar-user-info {
            padding: 16px;
            border-top: 1px solid #e5e7eb;
            margin-top: auto;
        }
        
        .sidebar-user-container {
            display: flex;
            align-items: center;
            gap: 10px;
            overflow: hidden;
        }
        
        .sidebar-collapsed .sidebar-user-container {
            justify-content: center;
        }
        
        .user-avatar {
            width: 36px;
            height: 36px;
            background: #3b82f6;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 14px;
            flex-shrink: 0;
        }
        
        .user-details {
            overflow: hidden;
            transition: opacity 0.3s;
        }
        
        .user-name {
            color: #1f2937;
            font-weight: 500;
            font-size: 14px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        
        .user-email {
            color: #6b7280;
            font-size: 12px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        
        /* MAIN CONTENT */
        .main-content {
            flex: 1;
            margin-left: 256px;
            width: calc(100% - 256px);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            min-height: 100vh;
        }
        
        .main-content-collapsed {
            margin-left: 80px !important;
            width: calc(100% - 80px) !important;
        }
        
        /* HEADER */
        .header {
            background: white;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #e5e7eb;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            position: sticky;
            top: 0;
            z-index: 100;
        }
        
        .header-left h1 {
            font-size: 1.5rem;
            color: #1e293b;
            font-weight: 600;
        }
        
        .header-right {
            display: flex;
            align-items: center;
            gap: 20px;
            position: relative;
        }
        
        /* USER DROPDOWN */
        .user-dropdown {
            position: relative;
        }
        
        .user-profile {
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
            padding: 8px 12px;
            border-radius: 8px;
            transition: background-color 0.2s;
        }
        
        .user-profile:hover {
            background: #f3f4f6;
        }
        
        .header-user-avatar {
            width: 40px;
            height: 40px;
            background: #3b82f6;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            flex-shrink: 0;
        }
        
        .user-info h4 {
            font-size: 0.9rem;
            color: #1e293b;
            white-space: nowrap;
        }
        
        .user-info p {
            font-size: 0.8rem;
            color: #64748b;
            white-space: nowrap;
        }
        
        /* Dropdown arrow */
        .user-profile::after {
            content: '\f078';
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            font-size: 12px;
            color: #6b7280;
            margin-left: 5px;
            transition: transform 0.3s;
        }
        
        .user-dropdown.open .user-profile::after {
            transform: rotate(180deg);
        }
        
        /* Dropdown menu */
        .dropdown-menu {
            position: absolute;
            top: calc(100% + 10px);
            right: 0;
            width: 200px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            border: 1px solid #e5e7eb;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: all 0.3s ease;
            z-index: 1000;
            overflow: hidden;
        }
        
        .user-dropdown.open .dropdown-menu {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }
        
        .dropdown-header {
            padding: 15px;
            border-bottom: 1px solid #e5e7eb;
            background: #f9fafb;
        }
        
        .dropdown-header h4 {
            font-size: 0.95rem;
            color: #1f2937;
            margin-bottom: 4px;
        }
        
        .dropdown-header p {
            font-size: 0.8rem;
            color: #6b7280;
        }
        
        .dropdown-item {
            display: flex;
            align-items: center;
            padding: 12px 15px;
            color: #4b5563;
            text-decoration: none;
            transition: all 0.2s;
            border-left: 3px solid transparent;
        }
        
        .dropdown-item:hover {
            background: #f3f4f6;
            color: #1f2937;
            border-left-color: #3b82f6;
        }
        
        .dropdown-item i {
            width: 20px;
            margin-right: 12px;
            font-size: 16px;
            color: #6b7280;
        }
        
        .dropdown-item:hover i {
            color: #3b82f6;
        }
        
        .dropdown-divider {
            height: 1px;
            background: #e5e7eb;
            margin: 5px 0;
        }
        
        .dropdown-item.logout {
            color: #ef4444;
        }
        
        .dropdown-item.logout:hover {
            background: #fef2f2;
            color: #dc2626;
        }
        
        .dropdown-item.logout i {
            color: #ef4444;
        }
        
        /* CONTENT WRAPPER */
        .content-wrapper {
            padding: 30px;
            max-width: 1200px;
            margin: 0 auto;
        }
        
        /* Card Styles */
        .card {
            background: white;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
            margin-bottom: 25px;
        }
        
        /* Button Styles */
        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 500;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s;
        }
        
        .btn-primary {
            background: #3b82f6;
            color: white;
        }
        
        .btn-primary:hover {
            background: #2563eb;
        }
        
        .btn-success {
            background: #10b981;
            color: white;
        }
        
        .btn-success:hover {
            background: #059669;
        }
        
        .btn-secondary {
            background: #6b7280;
            color: white;
        }
        
        .btn-secondary:hover {
            background: #4b5563;
        }
        
        /* Alert Styles */
        .alert {
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        
        .alert-success {
            background: #d1fae5;
            color: #065f46;
            border-left: 4px solid #10b981;
        }
        
        .alert-error {
            background: #fee2e2;
            color: #991b1b;
            border-left: 4px solid #ef4444;
        }
        
        /* MOBILE STYLES */
        @media (max-width: 768px) {
            .sidebar-container {
                transform: translateX(-100%);
            }
            
            .sidebar {
                width: 256px;
            }
            
            .sidebar-mobile-visible {
                transform: translateX(0) !important;
            }
            
            .sidebar-collapsed {
                transform: translateX(-100%) !important;
            }
            
            .sidebar-toggle {
                display: none !important;
            }
            
            .main-content,
            .main-content-collapsed {
                margin-left: 0 !important;
                width: 100% !important;
            }
            
            .mobile-toggle-btn {
                display: flex !important;
            }
            
            .content-wrapper {
                padding: 20px;
            }
            
            .header {
                padding: 15px 20px;
            }
            
            .user-info {
                display: none;
            }
            
            .user-profile::after {
                display: none;
            }
            
            .dropdown-menu {
                width: 180px;
                right: -10px;
            }
        }
        
        /* Mobile Toggle Button */
        .mobile-toggle-btn {
            position: fixed;
            top: 20px;
            left: 20px;
            background: #3b82f6;
            color: white;
            border: none;
            width: 40px;
            height: 40px;
            border-radius: 8px;
            display: none;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            z-index: 2000;
            box-shadow: 0 2px 10px rgba(0,0,0,0.2);
        }
        
        .mobile-toggle-btn:hover {
            background: #2563eb;
        }
        
        /* Animasi untuk toggle button */
        @keyframes bounce {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
        
        .sidebar-toggle:active {
            animation: bounce 0.3s ease;
        }
        
        /* Scrollbar styling */
        .sidebar::-webkit-scrollbar {
            width: 6px;
        }
        
        .sidebar::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        
        .sidebar::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 3px;
        }
        
        .sidebar::-webkit-scrollbar-thumb:hover {
            background: #a1a1a1;
        }
    </style>
</head>
<body>

<!-- Mobile Toggle Button -->
<button class="mobile-toggle-btn" id="mobileToggleBtn">
    <i class="fas fa-bars"></i>
</button>

<!-- Sidebar Container -->
<div class="sidebar-container" id="sidebarContainer">
    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <!-- Sidebar Header dengan Logo -->
        <div class="sidebar-header">
            <div class="logo-container">
                <div class="logo-icon">
                    <i class="fas fa-laptop-code"></i>
                </div>
                <div class="logo-text" id="logoText">
                    Inventory TIK
                </div>
            </div>
        </div>
        
        <!-- Menu Items -->
        <div class="sidebar-menu">
            <a href="{{ route('borrowing.dashboard') }}" 
               class="menu-item {{ request()->routeIs('borrowing.dashboard') ? 'active' : '' }}">
                <i class="fas fa-tachometer-alt"></i>
                <span>Dashboard</span>
                <div class="menu-tooltip">Dashboard</div>
            </a>
            
            <a href="{{ route('borrowing.pinjam') }}" 
               class="menu-item {{ request()->routeIs('borrowing.pinjam') ? 'active' : '' }}">
                <i class="fas fa-boxes"></i>
                <span>Pinjam Barang</span>
                <div class="menu-tooltip">Pinjam Barang</div>
            </a>
            
            <a href="{{ route('borrowing.surat.list') }}" 
               class="menu-item {{ request()->routeIs('borrowing.surat.list') ? 'active' : '' }}">
                <i class="fas fa-file-alt"></i>
                <span>Surat Saya</span>
                <div class="menu-tooltip">Surat Saya</div>
            </a>
            
            <a href="{{ route('borrowing.riwayat') }}" 
               class="menu-item {{ request()->routeIs('borrowing.riwayat') ? 'active' : '' }}">
                <i class="fas fa-history"></i>
                <span>Riwayat</span>
                <div class="menu-tooltip">Riwayat</div>
            </a>
        </div>
        
        <!-- User Info di Bawah Sidebar -->
        <div class="sidebar-user-info">
            <div class="sidebar-user-container">
                <div class="user-avatar">
                    {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                </div>
                <div class="user-details">
                    <div class="user-name">
                        {{ auth()->user()->name }}
                    </div>
                    <div class="user-email">
                        {{ auth()->user()->email }}
                    </div>
                </div>
            </div>
        </div>
    </aside>
    
    <!-- Toggle Container -->
    <div class="sidebar-toggle-container">
        <button class="sidebar-toggle" id="sidebarToggle" title="Hide Sidebar">
            <i class="fas fa-chevron-right" id="toggleIcon"></i>
        </button>
    </div>
</div>

<!-- Main Content -->
<div class="main-content" id="mainContent">
    <!-- Header -->
    <header class="header">
        <div class="header-left">
            <h1>@yield('page-title', 'Dashboard')</h1>
        </div>
        
        <div class="header-right">
            <!-- User Dropdown -->
            <div class="user-dropdown" id="userDropdown">
                <div class="user-profile">
                    <div class="header-user-avatar">
                        {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                    </div>
                    <div class="user-info">
                        <h4>{{ auth()->user()->name }}</h4>
                        <p>{{ auth()->user()->role ?? 'User' }}</p>
                    </div>
                </div>
                
                <!-- Dropdown Menu -->
                <div class="dropdown-menu">
                    <div class="dropdown-header">
                        <h4>{{ auth()->user()->name }}</h4>
                        <p>{{ auth()->user()->email }}</p>
                    </div>
                    
                    <div class="dropdown-divider"></div>
                    
                    <!-- Logout Button -->
                    <form id="logoutForm" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                    <a href="#" class="dropdown-item logout" onclick="event.preventDefault(); document.getElementById('logoutForm').submit();">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Keluar</span>
                    </a>
                </div>
            </div>
        </div>
    </header>
    
    <!-- Content -->
    <div class="content-wrapper">
        <!-- Alert Messages -->
        @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif
        
        @if(session('error'))
            <div class="alert alert-error">
                <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
            </div>
        @endif
        
        @yield('content')
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.getElementById('sidebar');
    const sidebarContainer = document.getElementById('sidebarContainer');
    const sidebarToggle = document.getElementById('sidebarToggle');
    const toggleIcon = document.getElementById('toggleIcon');
    const mobileToggleBtn = document.getElementById('mobileToggleBtn');
    const mainContent = document.getElementById('mainContent');
    const userDropdown = document.getElementById('userDropdown');
    const isMobile = window.innerWidth <= 768;
    
    // State sidebar dari localStorage
    let isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
    
    // Inisialisasi
    initSidebar();
    
    function initSidebar() {
        if (isMobile) {
            // Mobile: sidebar selalu hidden default
            sidebar.classList.remove('sidebar-collapsed');
            mainContent.classList.remove('main-content-collapsed');
            mobileToggleBtn.style.display = 'flex';
        } else {
            // Desktop: load state dari localStorage
            mobileToggleBtn.style.display = 'none';
            
            if (isCollapsed) {
                collapseSidebar();
            } else {
                expandSidebar();
            }
        }
    }
    
    function toggleSidebar() {
        if (isMobile) return;
        
        if (isCollapsed) {
            expandSidebar();
        } else {
            collapseSidebar();
        }
        
        isCollapsed = !isCollapsed;
        localStorage.setItem('sidebarCollapsed', isCollapsed);
        
        // Animasi klik
        sidebarToggle.style.transform = 'scale(0.9)';
        setTimeout(() => {
            sidebarToggle.style.transform = 'scale(1)';
        }, 150);
    }
    
    function collapseSidebar() {
        sidebar.classList.add('sidebar-collapsed');
        mainContent.classList.add('main-content-collapsed');
        toggleIcon.classList.remove('fa-chevron-right');
        toggleIcon.classList.add('fa-chevron-left');
        sidebarToggle.title = "Show Sidebar";
        
        // Update container width
        sidebarContainer.style.width = '80px';
    }
    
    function expandSidebar() {
        sidebar.classList.remove('sidebar-collapsed');
        mainContent.classList.remove('main-content-collapsed');
        toggleIcon.classList.remove('fa-chevron-left');
        toggleIcon.classList.add('fa-chevron-right');
        sidebarToggle.title = "Hide Sidebar";
        
        // Update container width
        sidebarContainer.style.width = '256px';
    }
    
    // Toggle User Dropdown
    function toggleUserDropdown() {
        userDropdown.classList.toggle('open');
    }
    
    // Close dropdown when clicking outside
    function closeDropdown(event) {
        if (!userDropdown.contains(event.target)) {
            userDropdown.classList.remove('open');
        }
    }
    
    // Event Listeners
    sidebarToggle.addEventListener('click', toggleSidebar);
    
    // User dropdown toggle
    const userProfile = userDropdown.querySelector('.user-profile');
    userProfile.addEventListener('click', function(e) {
        e.stopPropagation();
        toggleUserDropdown();
    });
    
    // Close dropdown when clicking anywhere
    document.addEventListener('click', closeDropdown);
    
    // Mobile toggle
    mobileToggleBtn.addEventListener('click', function() {
        sidebarContainer.classList.toggle('sidebar-mobile-visible');
        mobileToggleBtn.innerHTML = sidebarContainer.classList.contains('sidebar-mobile-visible') ? 
            '<i class="fas fa-times"></i>' : 
            '<i class="fas fa-bars"></i>';
        
        // Efek klik
        mobileToggleBtn.style.transform = 'scale(0.9)';
        setTimeout(() => {
            mobileToggleBtn.style.transform = 'scale(1)';
        }, 150);
    });
    
    // Close sidebar mobile ketika klik di luar
    document.addEventListener('click', function(event) {
        if (isMobile && 
            !sidebarContainer.contains(event.target) && 
            !mobileToggleBtn.contains(event.target) &&
            sidebarContainer.classList.contains('sidebar-mobile-visible')) {
            sidebarContainer.classList.remove('sidebar-mobile-visible');
            mobileToggleBtn.innerHTML = '<i class="fas fa-bars"></i>';
        }
    });
    
    // Handle window resize
    window.addEventListener('resize', function() {
        const newIsMobile = window.innerWidth <= 768;
        
        if (isMobile !== newIsMobile) {
            location.reload();
        }
    });
    
    // Hover effect untuk desktop toggle
    if (!isMobile) {
        sidebarToggle.addEventListener('mouseenter', function() {
            this.style.transform = 'scale(1.1)';
            this.style.boxShadow = '0 6px 20px rgba(0,0,0,0.3)';
        });
        
        sidebarToggle.addEventListener('mouseleave', function() {
            this.style.transform = 'scale(1)';
            this.style.boxShadow = '0 3px 10px rgba(0,0,0,0.2)';
        });
    }
    
    // Rotasi ikon dengan animasi smooth
    toggleIcon.style.transition = 'transform 0.3s ease';
});
</script>

</body>
</html>