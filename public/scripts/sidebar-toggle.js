const sidebar = document.getElementById('sidebar');
const sidebarToggle = document.getElementById('sidebar-toggle');
const mobileMenuButton = document.getElementById('mobile-menu-button');
const sidebarOverlay = document.getElementById('sidebar-overlay');
const profileButton = document.getElementById('profile-button');
const profileDropdown = document.getElementById('profile-dropdown');

// Toggle sidebar for desktop
if (sidebarToggle) {
    sidebarToggle.addEventListener('click', function () {
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

        localStorage.setItem('sidebar_collapsed', !isCollapsed);
    });
}

// Toggle mobile sidebar
if (mobileMenuButton) {
    mobileMenuButton.addEventListener('click', function () {
        sidebar.classList.toggle('-translate-x-full');
        sidebarOverlay.classList.toggle('hidden');
        document.body.style.overflow = sidebar.classList.contains('-translate-x-full') ? 'auto' : 'hidden';
    });
}

if (sidebarOverlay) {
    sidebarOverlay.addEventListener('click', function () {
        sidebar.classList.add('-translate-x-full');
        sidebarOverlay.classList.add('hidden');
        document.body.style.overflow = 'auto';
    });
}

if (profileButton && profileDropdown) {
    profileButton.addEventListener('click', function (e) {
        e.stopPropagation();
        profileDropdown.classList.toggle('hidden');
    });
}

document.addEventListener('click', function (e) {
    if (profileDropdown && !profileDropdown.contains(e.target) &&
        profileButton && !profileButton.contains(e.target)) {
        profileDropdown.classList.add('hidden');
    }
});

document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') {
        if (profileDropdown) profileDropdown.classList.add('hidden');
    }
});

// Toggle Surat Menu Function
function toggleSuratMenu() {
    const submenu = document.getElementById('surat-submenu');
    const arrow = document.getElementById('surat-arrow');

    if (submenu && arrow) {
        submenu.classList.toggle('hidden');
        if (arrow.classList.contains('fa-chevron-down')) {
            arrow.classList.remove('fa-chevron-down');
            arrow.classList.add('fa-chevron-up');
        } else {
            arrow.classList.remove('fa-chevron-up');
            arrow.classList.add('fa-chevron-down');
        }
    }
}

window.addEventListener('resize', function () {
    if (window.innerWidth >= 768) {
        // Desktop: show sidebar
        sidebar.classList.remove('-translate-x-full');
        sidebarOverlay.classList.add('hidden');
        document.body.style.overflow = 'auto';
    } else {
        // Mobile: hide sidebar by default
        if (!sidebar.classList.contains('-translate-x-full')) {
            sidebar.classList.add('-translate-x-full');
        }
    }
});

// Initialize on page load
document.addEventListener('DOMContentLoaded', function () {
    // Auto-hide submenu when sidebar collapsed
    const isCollapsed = sidebar.classList.contains('w-20');
    if (isCollapsed && document.getElementById('surat-submenu')) {
        document.getElementById('surat-submenu').classList.add('hidden');
    }

    // Auto-show submenu if on surat route
    if (window.location.pathname.includes('/surat/') && document.getElementById('surat-submenu')) {
        document.getElementById('surat-submenu').classList.remove('hidden');
        const arrow = document.getElementById('surat-arrow');
        if (arrow) {
            arrow.classList.remove('fa-chevron-down');
            arrow.classList.add('fa-chevron-up');
        }
    }
});