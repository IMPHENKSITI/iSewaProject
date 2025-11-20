<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default"
    data-assets-path="{{ asset('Admin/') }}" data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>Dashboard - iSewa Admin</title>
    <meta name="description" content="" />
    <link rel="icon" type="image/x-icon" href="{{ asset('Admin/img/favicon/isewalogo.png') }}" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('Admin/vendor/fonts/boxicons.css') }}" />
    <link rel="stylesheet" href="{{ asset('Admin/vendor/css/core.css') }}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('Admin/vendor/css/theme-default.css') }}"
        class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ asset('Admin/css/demo.css') }}" />
    <link rel="stylesheet" href="{{ asset('Admin/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
    <link rel="stylesheet" href="{{ asset('Admin/vendor/libs/apex-charts/apex-charts.css') }}" />
    <!-- Custom CSS for Styling -->
    <style>
        .card {
            transition: box-shadow 0.3s ease;
        }

        .card:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        .unit-card {
            border-left: 4px solid #007bff;
            transition: all 0.3s ease;
        }

        .unit-card:hover {
            border-left-width: 6px;
            background-color: #f8f9fa;
        }

        .unit-card.warning {
            border-left-color: #ffc107;
        }

        .unit-card.danger {
            border-left-color: #dc3545;
        }

        .unit-card.success {
            border-left-color: #28a745;
        }

        .unit-card.info {
            border-left-color: #17a2b8;
        }

        .notification-item {
            transition: background-color 0.3s ease;
        }

        .notification-item:hover {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 8px;
        }

        .product-item {
            transition: transform 0.3s ease;
        }

        .product-item:hover {
            transform: scale(1.02);
            z-index: 1;
        }

        .partnership-card {
            transition: all 0.3s ease;
        }

        .partnership-card:hover {
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            transform: translateY(-3px);
        }

        .nav-link {
            transition: all 0.3s ease;
        }

        .nav-link:hover {
            color: #007bff !important;
            background-color: rgba(0, 123, 255, 0.1) !important;
        }

        .menu-item.active .menu-link {
            background-color: rgba(0, 123, 255, 0.1) !important;
            color: #007bff !important;
        }

        .avatar {
            transition: transform 0.3s ease;
        }

        .avatar:hover {
            transform: scale(1.1);
        }

        /* Smooth scroll animation */
        .animate-fade-in {
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.6s ease, transform 0.6s ease;
        }

        .animate-fade-in.visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* Chart container styling */
        .chart-container {
            height: 300px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .chart-wrapper {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
        }

        /* Notification badges */
        .notification-badge {
            position: relative;
        }

        .notification-count {
            position: absolute;
            top: -8px;
            right: -8px;
            background-color: #dc3545;
            color: white;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: bold;
        }

        /* Sidebar styling */
        .layout-menu {
            transition: all 0.3s ease;
        }

        .layout-menu-toggle {
            transition: all 0.3s ease;
        }

        .layout-menu-toggle:hover {
            transform: rotate(180deg);
        }

        /* Financial stats cards */
        .financial-stat-card {
            transition: all 0.3s ease;
        }

        .financial-stat-card:hover {
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }

        /* Product card styling */
        .product-card {
            transition: all 0.3s ease;
            border: 1px solid #e9ecef;
        }

        .product-card:hover {
            border-color: #007bff;
            box-shadow: 0 4px 12px rgba(0, 123, 255, 0.15);
        }

        /* Partnership card styling */
        .partnership-card {
            transition: all 0.3s ease;
            border: 1px solid #e9ecef;
        }

        .partnership-card:hover {
            border-color: #007bff;
            box-shadow: 0 4px 12px rgba(0, 123, 255, 0.15);
        }

        /* Card header styling */
        .card-header {
            border-bottom: 1px solid #e9ecef;
        }

        /* Button styling */
        .btn {
            transition: all 0.3s ease;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        /* New styling for the three-column layout */
        .dashboard-stats-row {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
        }

        .dashboard-stats-col {
            flex: 1;
            min-width: 0;
        }

        .dashboard-stats-col .card {
            height: 100%;
        }

        .dashboard-stats-col .card-body {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .dashboard-stats-col .card-title {
            margin-bottom: 1rem;
        }

        .dashboard-stats-col .stat-value {
            font-size: 1.5rem;
            font-weight: bold;
            margin-bottom: 0.5rem;
        }

        .dashboard-stats-col .stat-change {
            font-size: 0.875rem;
            color: #28a745;
        }

        .dashboard-stats-col .stat-change.negative {
            color: #dc3545;
        }

        .dashboard-stats-col .stat-label {
            font-size: 0.75rem;
            color: #6c757d;
        }

        .dashboard-stats-col .chart-placeholder {
            height: 150px;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f8f9fa;
            border-radius: 8px;
            margin-top: 1rem;
        }

        .dashboard-stats-col .chart-placeholder p {
            margin: 0;
            text-align: center;
            color: #6c757d;
        }

        /* Fix for dropdown z-index */
        .dropdown-menu {
            z-index: 10000 !important;
        }

        /* Remove product ranking badge */
        .product-rank {
            display: none;
        }

        /* Product image styling */
        .product-image {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 8px;
        }

        /* Partnership card styling */
        .partnership-card .avatar {
            width: 60px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            font-weight: bold;
        }

        /* Laporan BUMDes button styling */
        .laporan-bumdes-btn {
            margin-top: 1rem;
        }

        /* Gap between sections */
        .section-gap {
            margin-bottom: 2rem;
        }
    </style>
    <script src="{{ asset('Admin/vendor/js/helpers.js') }}"></script>
    <script src="{{ asset('Admin/js/config.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('Admin/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
    <!-- Custom CSS for Styling -->
    <style>
        /* ... (CSS Anda sebelumnya) ... */
    </style>

    <!-- Croppie CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.css" />

    <script src="{{ asset('Admin/vendor/js/helpers.js') }}"></script>
    <script src="{{ asset('Admin/js/config.js') }}"></script>
</head>

<body>
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Sidebar -->
            <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
                <div class="app-brand demo">
                    <a href="{{ route('admin.dashboard') }}" class="app-brand-link">
                        <span class="app-brand-logo demo">
                            <img src="{{ asset('Admin/img/illustrations/isewalogo.png') }}" alt="Logo"
                                width="130" height="130">
                        </span>
                    </a>
                    <a href="javascript:void(0);"
                        class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
                        <i class="bx bx-chevron-left bx-sm align-middle"></i>
                    </a>
                </div>
                <div class="menu-inner-shadow"></div>
                <ul class="menu-inner py-1">
                    <!-- Dashboard -->
                    <li class="menu-item ">
                        <a href="{{ route('admin.dashboard') }}" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-home-circle"></i>
                            <div data-i18n="Dashboard">Dashboard</div>
                        </a>
                    </li>

                    <!-- Unit Layanan -->
                    <li
                        class="menu-item {{ request()->is('admin/unit/penyewaan*') || request()->is('admin/unit/gas*') || request()->is('admin/unit/tanikebun*') || request()->is('admin/unit/simpanpinjam*') ? 'open active show' : '' }}">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon tf-icons bx bx-collection"></i>
                            <div data-i18n="Unit Layanan">Unit Layanan</div>
                        </a>
                        <ul class="menu-sub">
                            <li class="menu-item {{ request()->is('admin/unit/penyewaan*') ? 'active' : '' }}">
                                <a href="{{ route('admin.unit.penyewaan.index') }}" class="menu-link">
                                    <div data-i18n="Penyewaan Alat">Penyewaan Alat</div>
                                </a>
                            </li>
                            <li class="menu-item {{ request()->is('admin/unit/gas*') ? 'active' : '' }}">
                                <a href="{{ route('admin.unit.penjualan_gas.index') }}" class="menu-link">
                                    <div data-i18n="Penjualan Gas">Penjualan Gas</div>
                                </a>
                            </li>
                            <li class="menu-item {{ request()->is('admin/unit/tanikebun*') ? 'active' : '' }}">
                                <a href="{{ route('admin.unit.tanikebun.index') }}" class="menu-link">
                                    <div data-i18n="Pertanian & Perkebunan">Pertanian & Perkebunan</div>
                                </a>
                            </li>
                            <li class="menu-item {{ request()->is('admin/unit/simpanpinjam*') ? 'active' : '' }}">
                                <a href="{{ route('admin.unit.simpanpinjam.index') }}" class="menu-link">
                                    <div data-i18n="Simpan Pinjam">Simpan Pinjam</div>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <!-- Aktivitas -->
                    <li class="menu-item">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon tf-icons bx bx-time"></i>
                            <div data-i18n="Aktivitas">Aktivitas</div>
                        </a>
                        <ul class="menu-sub">
                            <li class="menu-item">
                                <a href="{{ route('admin.aktivitas.kajian.index') }}" class="menu-link">
                                    <div data-i18n="Permintaan & Pengajuan">Permintaan & Pengajuan</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="{{ route('admin.aktivitas.transaksi.index') }}" class="menu-link">
                                    <div data-i18n="Bukti Transaksi">Bukti Transaksi</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="{{ route('admin.aktivitas.kemitraan.index') }}" class="menu-link">
                                    <div data-i18n="Kemitraan">Kemitraan</div>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <!-- Data & Laporan -->
                    <li class="menu-item">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon tf-icons bx bx-bar-chart"></i>
                            <div data-i18n="Data & Laporan">Data & Laporan</div>
                        </a>
                        <ul class="menu-sub">
                            <li class="menu-item">
                                <a href="{{ route('admin.laporan.transaksi') }}" class="menu-link">
                                    <div data-i18n="Laporan Transaksi">Laporan Transaksi</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="{{ route('admin.laporan.panen') }}" class="menu-link">
                                    <div data-i18n="Laporan Hasil Panen">Laporan Hasil Panen</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="{{ route('admin.laporan.pendapatan') }}" class="menu-link">
                                    <div data-i18n="Laporan Pendapatan Total">Laporan Pendapatan</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="{{ route('admin.laporan.log') }}" class="menu-link">
                                    <div data-i18n="Log Aktivitas">Log Aktivitas</div>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <!-- Manajemen Pengguna -->
                    <li class="menu-item">
                        <a href="{{ route('admin.users.index') }}" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-user"></i>
                            <div data-i18n="Manajemen Pengguna">Manajemen Pengguna</div>
                        </a>
                    </li>
                    <!-- Notifikasi -->
                    <li class="menu-item">
                        <a href="{{ route('admin.notifications.index') }}" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-bell"></i>
                            <div data-i18n="Notifikasi">Notifikasi</div>
                        </a>
                    </li>
                    <!-- Profil iSewa -->
                    <li class="menu-item">
                        <a href="{{ route('admin.isewa.profile') }}" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-info-circle"></i>
                            <div data-i18n="Profil iSewa">Profil iSewa</div>
                        </a>
                    </li>
                    <!-- Profil BUMDes -->
                    <li class="menu-item">
                        <a href="{{ route('admin.bumdes.profile') }}" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-home-alt"></i>
                            <div data-i18n="Profil BUMDes">Profil BUMDes</div>
                        </a>
                    </li>
                    <!-- Pengaturan -->
                    <li class="menu-item">
                        <a href="#" class="menu-link" onclick="alert('Halaman Pengaturan belum tersedia'); return false;">
                            <i class="menu-icon tf-icons bx bx-cog"></i>
                            <div data-i18n="Pengaturan">Pengaturan</div>
                        </a>
                    </li>
                </ul>
            </aside>
            <!-- Layout page -->
            <div class="layout-page">
                <!-- Navbar -->
                <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
                    id="layout-navbar">
                    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
                        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                            <i class="bx bx-menu bx-sm"></i>
                        </a>
                    </div>
                    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
                        <div class="navbar-nav align-items-center">
                            <div class="nav-item d-flex align-items-center">
                                <i class="bx bx-search fs-4 lh-0"></i>
                                <input type="text" class="form-control border-0 shadow-none" placeholder="Cari..."
                                    aria-label="Search..." />
                            </div>
                        </div>
                        <ul class="navbar-nav flex-row align-items-center ms-auto">
                            <!-- Nama Admin -->
                            <li class="nav-item lh-1 me-3">
                                <span class="fw-semibold">Hamizul Fuad</span>
                            </li>
                            <!-- Profil Admin -->
                            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);"
                                    data-bs-toggle="dropdown">
                                    <img src="{{ asset('Admin/img/avatars/hamizulf.jpg') }}" alt
                                        class="w-px-40 h-auto rounded-circle" />
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('admin.profile') }}">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 me-3">
                                                    <div class="flex-grow-1">
                                                        <span class="fw-semibold d-block">Hamizul Fuad</span>
                                                        <small class="text-muted">Admin</small>
                                                    </div>
                                                </div>
                                        </a>
                                    </li>
                                    <li>
                                        <div class="dropdown-divider"></div>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('admin.profile') }}">
                                            <i class="bx bx-user me-2"></i>
                                            <span class="align-middle">My Profile</span>
                                        </a>
                                    </li>
                                    <!-- 🔧 DIPERBAIKI: Ganti link ke route('admin.settings') -->
                                    <li>
                                        <a class="dropdown-item" href="#" onclick="alert('Fitur pengaturan belum tersedia'); return false;">
                                            <i class="bx bx-cog me-2"></i>
                                            <span class="align-middle">Settings</span>
                                        </a>
                                    </li>
                                    <li>
                                        <div class="dropdown-divider"></div>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('admin.logout') }}"
                                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            <i class="bx bx-power-off me-2"></i>
                                            <span class="align-middle">Log Out</span>
                                        </a>
                                        <form id="logout-form" action="{{ route('admin.logout') }}" method="POST"
                                            class="d-none">
                                            @csrf
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </nav>

                <!-- Content wrapper -->
                @yield('content')
                <div class="layout-overlay layout-menu-toggle"></div>
            </div>
            <script src="{{ asset('Admin/vendor/libs/jquery/jquery.js') }}"></script>
            <script src="{{ asset('Admin/vendor/libs/popper/popper.js') }}"></script>
            <script src="{{ asset('Admin/vendor/js/bootstrap.js') }}"></script>
            <script src="{{ asset('Admin/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
            <script src="{{ asset('Admin/vendor/js/menu.js') }}"></script>
            <script src="{{ asset('Admin/vendor/libs/apex-charts/apexcharts.js') }}"></script>
            <script src="{{ asset('Admin/js/main.js') }}"></script>
            <script src="{{ asset('Admin/js/dashboards-analytics.js') }}"></script>
            <script async defer src="https://buttons.github.io/buttons.js"></script>
            <!-- Script for animations and functionality -->
            <script>
                // Function to show details of a request
                function showDetails(title, user, description) {
                    alert(`Detail Permintaan:\nJudul: ${title}\nUser: ${user}\nDeskripsi: ${description}`);
                }

                // Function to accept a request
                function acceptRequest(id) {
                    const notificationItem = document.getElementById(`notification${id}`);
                    if (notificationItem) {
                        notificationItem.classList.add('bg-success', 'text-white');
                        notificationItem.querySelectorAll('button').forEach(btn => btn.disabled = true);
                        // Show success notification
                        showToast('success', 'Permintaan telah diterima!');
                    }
                }

                // Function to reject a request
                function rejectRequest(id) {
                    const notificationItem = document.getElementById(`notification${id}`);
                    if (notificationItem) {
                        notificationItem.classList.add('bg-danger', 'text-white');
                        notificationItem.querySelectorAll('button').forEach(btn => btn.disabled = true);
                        // Show error notification
                        showToast('error', 'Permintaan telah ditolak! Silakan periksa alasan penolakan.');
                    }
                }

                // Function to generate report
                function generateReport() {
                    showToast('info',
                        'Laporan PDF sedang diproses. Fitur ini akan terhubung ke backend Laravel untuk menghasilkan file.');
                    // In a real application, this would trigger a server-side PDF generation
                    setTimeout(() => {
                        showToast('success', 'Laporan berhasil dibuat dan siap diunduh!');
                    }, 2000);
                }

                // Function to show toast notifications
                function showToast(type, message) {
                    // Create toast element
                    const toast = document.createElement('div');
                    toast.className = `toast align-items-center text-white bg-${type} border-0`;
                    toast.style.position = 'fixed';
                    toast.style.top = '20px';
                    toast.style.right = '20px';
                    toast.style.zIndex = '10000';
                    toast.innerHTML = `
                <div class="d-flex">
                    <div class="toast-body">${message}</div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            `;

                    // Add to body
                    document.body.appendChild(toast);

                    // Initialize bootstrap toast
                    const bsToast = new bootstrap.Toast(toast, {
                        delay: 3000,
                        autohide: true
                    });

                    // Show toast
                    bsToast.show();

                    // Remove toast after it's hidden
                    toast.addEventListener('hidden.bs.toast', () => {
                        toast.remove();
                    });
                }

                // Animation on scroll
                document.addEventListener('DOMContentLoaded', function() {
                    const animateElements = document.querySelectorAll('.animate-fade-in');

                    const observer = new IntersectionObserver((entries) => {
                        entries.forEach(entry => {
                            if (entry.isIntersecting) {
                                entry.target.classList.add('visible');
                            }
                        });
                    }, {
                        threshold: 0.1
                    });

                    animateElements.forEach(el => {
                        observer.observe(el);
                    });
                });

                // Add smooth scrolling to anchor links
                document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                    anchor.addEventListener('click', function(e) {
                        e.preventDefault();

                        document.querySelector(this.getAttribute('href')).scrollIntoView({
                            behavior: 'smooth'
                        });
                    });
                });
            </script>
</body>

</html>