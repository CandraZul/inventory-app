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

// Inisialisasi awal untuk sidebar state
document.addEventListener('DOMContentLoaded', function () {
    // Set sidebar state dari localStorage
    const isCollapsed = localStorage.getItem('sidebar_collapsed') === 'true';
    const sidebar = document.getElementById('sidebar');
    const sidebarToggle = document.getElementById('sidebar-toggle');

    if (sidebar && sidebarToggle) {
        if (isCollapsed && !sidebar.classList.contains('w-20')) {
            sidebar.classList.remove('w-64');
            sidebar.classList.add('w-20');
            sidebarToggle.innerHTML = '<i class="fas fa-chevron-right text-sm"></i>';
        } else if (!isCollapsed && !sidebar.classList.contains('w-64')) {
            sidebar.classList.remove('w-20');
            sidebar.classList.add('w-64');
            sidebarToggle.innerHTML = '<i class="fas fa-chevron-left text-sm"></i>';
        }
    }
});