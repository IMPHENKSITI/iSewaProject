@extends('layouts.admin')
@section('content')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <!-- Welcome Card & Unit Cards -->
            <div class="row mb-2">
                <div class="col-lg-8">
                    <div class="card animate-fade-in">
                        <div class="d-flex align-items-end row">
                            <div class="col-sm-7">
                                <div class="card-body p-3">
                                    <h5 class="card-title text-primary fw-bold">Selamat Datang di iSewa 🏛️</h5>
                                    <p class="mb-2">Sistem Penyewaan Alat dan Promosi Usaha BUMDes berbasis Digital <span
                                            class="fw-bold">Desa Pematang Duku Timur</span></p>
                                    <a href="{{ route('admin.bumdes.profile') }}"
                                        class="btn btn-sm btn-outline-primary">Profil BUMDes</a>
                                </div>
                            </div>
                            <div class="col-sm-5 text-center text-sm-left">
                                <div class="card-body pb-0 px-0 px-md-3">
                                    <img src="{{ asset('Admin/img/illustrations/bermasab.png') }}" height="150"
                                        alt="View Badge User" data-app-dark-img="illustrations/man-with-laptop-dark.png"
                                        data-app-light-img="illustrations/man-with-laptop-light.png" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="row g-2">
                        <div class="col-12">
                            <div class="card animate-fade-in">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between flex-sm-row flex-column gap-3">
                                        <div
                                            class="d-flex flex-sm-column flex-row align-items-start justify-content-between">
                                            <div class="card-title">
                                                <h5 class="text-nowrap mb-2">Total Pendapatan</h5>
                                                <span class="badge bg-label-warning rounded-pill">Tahun 2025</span>
                                            </div>
                                            <div class="mt-sm-auto">
                                                <small class="text-success text-nowrap fw-semibold"><i
                                                        class="bx bx-chevron-up"></i> 68.2%</small>
                                                <h3 class="mb-0">Rp.50.000.000</h3>
                                            </div>
                                        </div>
                                        <div id="profileReportChart"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <ul></ul>
            <div></div>

            <!-- Unit Cards - SATU PER BARIS -->
            <div class="row mb-4">
                <div class="col-12 mb-3">
                    <div class="card unit-card warning animate-fade-in"
                        onclick="window.location='{{ route('admin.unit.penyewaan.index') }}'">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="avatar flex-shrink-0 me-3" style="width: 60px; height: 60px;">
                                    <img src="{{ asset('Admin/img/5.png') }}" alt="" class="rounded w-100" />
                                </div>
                                <div class="flex-grow-1">
                                    <span class="fw-semibold d-block mb-1 text-muted">Unit Penyewaan Alat</span>
                                    <h4 class="card-title mb-0">{{ $unitPenyewaan ?? 45 }} Item</h4>
                                </div>
                                <div class="text-end">
                                    <h5 class="text-success mb-0"><i class="bx bx-up-arrow-alt"></i> +72.80%</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 mb-3">
                    <div class="card unit-card danger animate-fade-in"
                        onclick="window.location='{{ route('admin.unit.gas.index') }}'">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="avatar flex-shrink-0 me-3" style="width: 60px; height: 60px;">
                                    <img src="{{ asset('Admin/img/icons/unicons/6.png') }}" alt=""
                                        class="rounded w-100" />
                                </div>
                                <div class="flex-grow-1">
                                    <span class="fw-semibold d-block mb-1 text-muted">Unit Penjualan Gas</span>
                                    <h4 class="card-title mb-0">{{ $unitGas ?? 320 }} Tabung</h4>
                                </div>
                                <div class="text-end">
                                    <h5 class="text-success mb-0"><i class="bx bx-up-arrow-alt"></i> +28.42%</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 mb-3">
                    <div class="card unit-card success animate-fade-in"
                        onclick="window.location='{{ route('admin.unit.tanikebun.index') }}'">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="avatar flex-shrink-0 me-3" style="width: 60px; height: 60px;">
                                    <img src="{{ asset('Admin/img/icons/unicons/4.png') }}" alt=""
                                        class="rounded w-100" />
                                </div>
                                <div class="flex-grow-1">
                                    <span class="fw-semibold d-block mb-1 text-muted">Unit Pertanian dan Perkebunan</span>
                                    <h4 class="card-title mb-0">{{ $unitPertanian ?? 28 }} Produk</h4>
                                </div>
                                <div class="text-end">
                                    <h5 class="text-danger mb-0"><i class="bx bx-down-arrow-alt"></i> -14.82%</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 mb-3">
                    <div class="card unit-card info animate-fade-in"
                        onclick="window.location='{{ route('admin.unit.simpanpinjam.index') }}'">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="avatar flex-shrink-0 me-3" style="width: 60px; height: 60px;">
                                    <img src="{{ asset('Admin/img/icons/unicons/isewa.png') }}" alt=""
                                        class="rounded w-100" />
                                </div>
                                <div class="flex-grow-1">
                                    <span class="fw-semibold d-block mb-1 text-muted">Unit Simpan Pinjam</span>
                                    <h4 class="card-title mb-0">{{ $unitSimpanPinjam ?? 156 }} Anggota</h4>
                                </div>
                                <div class="text-end">
                                    <h5 class="text-success mb-0"><i class="bx bx-up-arrow-alt"></i> +26.14%</h5>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Notifications Section -->
                <div class="row mb-2">
                    <div class="col-12">
                        <div class="card animate-fade-in">
                            <div class="card-header p-3">
                                <div class="card-title mb-0">
                                    <h5 class="m-0 me-2"><i class="bx bx-bell text-primary"></i> Notifikasi Permintaan
                                    </h5>
                                    <small class="text-muted">Permintaan aktivitas dari pengguna</small>
                                </div>
                            </div>
                            <div class="card-body p-3">
                                <div class="list-group list-group-flush">
                                    <div class="list-group-item d-flex align-items-center p-2 notification-item"
                                        id="notification1">
                                        <div class="avatar flex-shrink-0 me-2">
                                            <span class="avatar-initial rounded bg-label-secondary">P</span>
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="mb-2">
                                                <span class="badge bg-warning me-2">Penyewaan Alat</span>
                                                <small class="text-muted">2 jam yang lalu</small>
                                            </div>
                                            <h6 class="mb-1">User A mengajukan penyewaan Tenda Komplit</h6>
                                            <p class="text-muted mb-0 small">Untuk acara pernikahan tanggal 15 November
                                                2025</p>
                                        </div>
                                        <div class="d-flex gap-2 ms-3">
                                            <button class="btn btn-sm btn-outline-primary"
                                                onclick="showDetails('Penyewaan Tenda Komplit', 'User A', 'Untuk acara pernikahan tanggal 15 November 2025')">
                                                <i class="bx bx-show"></i> Detail
                                            </button>
                                            <button class="btn btn-sm btn-success" onclick="acceptRequest(1)">
                                                <i class="bx bx-check"></i> Terima
                                            </button>
                                            <button class="btn btn-sm btn-danger" onclick="rejectRequest(1)">
                                                <i class="bx bx-x"></i> Tolak
                                            </button>
                                        </div>
                                    </div>
                                    <div class="list-group-item d-flex align-items-center p-2 notification-item"
                                        id="notification2">
                                        <div class="avatar flex-shrink-0 me-2">
                                            <span class="avatar-initial rounded bg-label-success">S</span>
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="mb-2">
                                                <span class="badge bg-info me-2">Simpan Pinjam</span>
                                                <small class="text-muted">5 jam yang lalu</small>
                                            </div>
                                            <h6 class="mb-1">User B mengajukan pinjaman sebesar Rp 5.000.000</h6>
                                            <p class="text-muted mb-0 small">Untuk modal usaha toko kelontong</p>
                                        </div>
                                        <div class="d-flex gap-2 ms-3">
                                            <button class="btn btn-sm btn-outline-primary"
                                                onclick="showDetails('Pinjaman Modal Usaha', 'User B', 'Untuk modal usaha toko kelontong')">
                                                <i class="bx bx-show"></i> Detail
                                            </button>
                                            <button class="btn btn-sm btn-success" onclick="acceptRequest(2)">
                                                <i class="bx bx-check"></i> Terima
                                            </button>
                                            <button class="btn btn-sm btn-danger" onclick="rejectRequest(2)">
                                                <i class="bx bx-x"></i> Tolak
                                            </button>
                                        </div>
                                    </div>
                                    <div class="list-group-item d-flex align-items-center p-2 notification-item"
                                        id="notification3">
                                        <div class="avatar flex-shrink-0 me-2">
                                            <span class="avatar-initial rounded bg-label-warning">K</span>
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="mb-2">
                                                <span class="badge bg-success me-2">Kemitraan</span>
                                                <small class="text-muted">1 hari yang lalu</small>
                                            </div>
                                            <h6 class="mb-1">User C mengajukan pendaftaran gabung kemitraan</h6>
                                            <p class="text-muted mb-0 small">Bidang pertanian dan perkebunan sawit</p>
                                        </div>
                                        <div class="d-flex gap-2 ms-3">
                                            <button class="btn btn-sm btn-outline-primary"
                                                onclick="showDetails('Pendaftaran Kemitraan', 'User C', 'Bidang pertanian dan perkebunan sawit')">
                                                <i class="bx bx-show"></i> Detail
                                            </button>
                                            <button class="btn btn-sm btn-success" onclick="acceptRequest(3)">
                                                <i class="bx bx-check"></i> Terima
                                            </button>
                                            <button class="btn btn-sm btn-danger" onclick="rejectRequest(3)">
                                                <i class="bx bx-x"></i> Tolak
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <ul></ul>
                <div></div>

                <!-- Three Column Layout for Financial Stats -->
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="dashboard-stats-row">
                            <!-- Left Column: Pendapatan dan Pengeluaran -->
                            <div class="dashboard-stats-col">
                                <div class="card animate-fade-in">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">Pendapatan dan Pengeluaran</h5>
                                    </div>
                                    <div class="body">
                                        <div class="chart-wrapper">
                                            <div id="totalRevenueChart" class="px-2"></div>
                                        </div>
                                        <div class="text-center mt-3">
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-outline-primary dropdown-toggle"
                                                    type="button" id="growthReportId" data-bs-toggle="dropdown"
                                                    aria-haspopup="true" aria-expanded="false">
                                                    2025
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-end"
                                                    aria-labelledby="growthReportId">
                                                    <a class="dropdown-item" href="javascript:void(0);">2024</a>
                                                    <a class="dropdown-item" href="javascript:void(0);">2023</a>
                                                    <a class="dropdown-item" href="javascript:void(0);">2022</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Middle Column: Grafik Transaksi (Persentase) -->
                            <div class="dashboard-stats-col">
                                <div class="card animate-fade-in">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">Perbandingan Transaksi</h5>
                                    </div>
                                    <ul></ul>
                                    <div></div>
                                    <div class="card-body d-flex flex-column justify-content-center align-items-center"
                                        style="height: 320px;">
                                        <h2 class="mb-1">500</h2>
                                        <span class="text-muted mb-2">Total Transaksi</span>
                                        <!-- Chart di tengah dan besar -->
                                        <ul></ul>
                                        <div></div>
                                        <ul></ul>
                                        <div></div>
                                        <div id="orderStatisticsChart" style="width: 130px; height: 280px;"></div>
                                    </div>
                                </div>
                            </div>

                            <!-- Script ApexCharts untuk Transaksi -->
                            <script>
                                var optionsOrder = {
                                    series: [58, 82],
                                    chart: {
                                        type: "donut",
                                        width: 800, // ✅ ukuran besar
                                        height: 800, // ✅ proporsional dengan card
                                    },
                                    labels: ["Weekly", "Others"],
                                    colors: ["#28C76F", "#00CFE8"],
                                    legend: {
                                        show: false
                                    },
                                    dataLabels: {
                                        enabled: false
                                    },
                                    plotOptions: {
                                        pie: {
                                            donut: {
                                                size: "100%", // ✅ besar dan tebal
                                                labels: {
                                                    show: true,
                                                    name: {
                                                        show: true,
                                                        fontSize: "16px",
                                                        color: "#6e6b7b",
                                                        offsetY: 20,
                                                    },
                                                    value: {
                                                        show: true,
                                                        fontSize: "30px",
                                                        fontWeight: 600,
                                                        color: "#5e5873",
                                                        offsetY: -10,
                                                        formatter: function() {
                                                            return "38%";
                                                        },
                                                    },
                                                    total: {
                                                        show: true,
                                                        label: "2025",
                                                        fontSize: "16px",
                                                        color: "#6e6b7b",
                                                    },
                                                },
                                            },
                                        },
                                    },
                                };

                                var chartOrder = new ApexCharts(
                                    document.querySelector("#orderStatisticsChart"),
                                    optionsOrder
                                );
                                chartOrder.render();
                            </script>


                            <!-- Right Column: Anggota Mitra Aktif & Total Transaksi -->
                            <div class="dashboard-stats-col">
                                <div class="card animate-fade-in">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">Transaksi dan Pendapatan</h5>
                                        <div class="card-body">
                                            <div class="tab-content p-0">
                                                <div class="tab-pane fade show active" id="navs-tabs-line-card-income"
                                                    role="tabpanel">

                                                </div>
                                                <div>
                                                    <small class="text-muted d-block">Pendapatan</small>
                                                    <div class="d-flex align-items-center">
                                                        <h6 class="mb-0 me-1">$459.10</h6>
                                                        <small class="text-success fw-semibold">
                                                            <i class="bx bx-chevron-up"></i>
                                                            42.9%
                                                        </small>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="incomeChart"></div>
                                            <div class="d-flex justify-content-center pt-4 gap-2">
                                                <div class="flex-shrink-0">
                                                    <div id="expensesOfWeek"></div>
                                                </div>
                                                <div>
                                                    <p class="mb-n1 mt-1">Minggu ini</p>
                                                    <small class="text-muted">Transaksi dan Pendapatan</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="chart-wrapper">
                                        <div id="transactionChart" class="px-2"></div>



                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Popular Products -->
                    <div class="row mb-2 section-gap">
                        <div class="col-12">
                            <div class="card animate-fade-in">
                                <div class="card-header p-3">
                                    <h5 class="card-title mb-0">Produk Populer</h5>
                                </div>
                                <div class="card-body p-3">
                                    <div class="row g-3">
                                        <div class="col-md-4 product-item">
                                            <div class="card h-100 product-card">
                                                <div class="card-body p-2">
                                                    <div class="d-flex align-items-center mb-2">
                                                        <div class="avatar flex-shrink-0 me-3">
                                                            <img src="{{ asset('Admin/img/icons/unicons/gas.png') }}"
                                                                alt="" class="product-image" />
                                                        </div>
                                                        <div class="flex-grow-1">
                                                            <h6 class="mb-0">Gas LPG 3 Kg</h6>
                                                            <small class="text-muted">Unit Penjualan Gas</small>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex justify-content-between">
                                                        <div></div>
                                                        <div class="user-progress">

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 product-item">
                                            <div class="card h-100 product-card">
                                                <div class="card-body p-2">
                                                    <div class="d-flex align-items-center mb-2">
                                                        <div class="avatar flex-shrink-0 me-3">
                                                            <img src="{{ asset('Admin/img/icons/unicons/sound system.png') }}"
                                                                alt="" class="product-image" />
                                                        </div>
                                                        <div class="flex-grow-1">
                                                            <h6 class="mb-0">Sound System</h6>
                                                            <small class="text-muted">Unit Penyewaan Alat</small>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex justify-content-between">
                                                        <div></div>
                                                        <div class="user-progress">

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 product-item">
                                            <div class="card h-100 product-card">
                                                <div class="card-body p-2">
                                                    <div class="d-flex align-items-center mb-2">
                                                        <div class="avatar flex-shrink-0 me-3">
                                                            <img src="{{ asset('Admin/img/icons/unicons/tendakom.jpg') }}"
                                                                alt="" class="product-image" />
                                                        </div>
                                                        <div class="flex-grow-1">
                                                            <h6 class="mb-0">Tenda Komplit</h6>
                                                            <small class="text-muted">Unit Penyewaan Alat</small>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex justify-content-between">
                                                        <div></div>
                                                        <div class="user-progress">

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 product-item">
                                            <div class="card h-100 product-card">
                                                <div class="card-body p-2">
                                                    <div class="d-flex align-items-center mb-2">
                                                        <div class="avatar flex-shrink-0 me-3">
                                                            <img src="{{ asset('Admin/img/icons/unicons/tendakursi.jpg') }}"
                                                                alt="" class="product-image" />
                                                        </div>
                                                        <div class="flex-grow-1">
                                                            <h6 class="mb-0">Meja dan Kursi</h6>
                                                            <small class="text-muted">Unit Penyewaan Alat</small>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex justify-content-between">
                                                        <div></div>
                                                        <div class="user-progress">

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 product-item">
                                            <div class="card h-100 product-card">
                                                <div class="card-body p-2">
                                                    <div class="d-flex align-items-center mb-2">
                                                        <div class="avatar flex-shrink-0 me-3">
                                                            <img src="{{ asset('Admin/img/icons/unicons/mitra.png') }}"
                                                                alt="" class="product-image" />
                                                        </div>
                                                        <div class="flex-grow-1">
                                                            <h6 class="mb-0">Bermitra</h6>
                                                            <small class="text-muted">Unit Pertanian</small>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex justify-content-between">
                                                        <div></div>
                                                        <div class="user-progress">

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 product-item">
                                            <div class="card h-100 product-card">
                                                <div class="card-body p-2">
                                                    <div class="d-flex align-items-center mb-2">
                                                        <div class="avatar flex-shrink-0 me-3">
                                                            <img src="{{ asset('Admin/img/icons/unicons/sp.png') }}"
                                                                alt="" class="product-image" />
                                                        </div>
                                                        <div class="flex-grow-1">
                                                            <h6 class="mb-0">Pengajuan Pinjaman</h6>
                                                            <small class="text-muted">Unit Simpan Pinjam</small>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex justify-content-between">
                                                        <div></div>
                                                        <div class="user-progress">

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Partnership Section -->
                    <div class="row mb-2 section-gap">
                        <div class="col-12">
                            <div class="card animate-fade-in">
                                <div class="card-header p-3">
                                    <h5 class="card-title mb-0">Kemitraan</h5>
                                </div>
                                <div class="card-body p-3">
                                    <div class="row g-3">
                                        <div class="col-md-4">
                                            <div class="card h-100 partnership-card">
                                                <div class="card-body p-3">
                                                    <div class="d-flex align-items-center mb-3">
                                                        <div class="avatar flex-shrink-0 me-3 bg-success text-white">
                                                            H
                                                        </div>
                                                        <div class="flex-grow-1">
                                                            <h6 class="card-title mb-0">Heri</h6>
                                                            <small class="text-muted">Petani</small>
                                                        </div>
                                                    </div>
                                                    <div class="mt-2">
                                                        <p class="mb-1"><strong>Jenis Hasil Panen:</strong> Ubi</p>
                                                        <p class="mb-1"><strong>Jumlah:</strong> 5 Ton</p>
                                                        <p class="mb-1"><strong>Harga Jual:</strong> Rp 5.000.000</p>
                                                        <p class="mb-0"><strong>Lokasi Lahan:</strong> RW 03 Desa
                                                            Pematang Duku Timur</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="card h-100 partnership-card">
                                                <div class="card-body p-3">
                                                    <div class="d-flex align-items-center mb-3">
                                                        <div class="avatar flex-shrink-0 me-3 bg-info text-white">
                                                            S
                                                        </div>
                                                        <div class="flex-grow-1">
                                                            <h6 class="card-title mb-0">Siti</h6>
                                                            <small class="text-muted">Petani</small>
                                                        </div>
                                                    </div>
                                                    <div class="mt-2">
                                                        <p class="mb-1"><strong>Jenis Hasil Panen:</strong> Sayur-sayuran
                                                        </p>
                                                        <p class="mb-1"><strong>Jumlah:</strong> 10 Ton</p>
                                                        <p class="mb-1"><strong>Harga Jual:</strong> Rp 15.000.000</p>
                                                        <p class="mb-0"><strong>Lokasi Lahan:</strong> RW 05 Desa
                                                            Pematang Duku Timur</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="card h-100 partnership-card">
                                                <div class="card-body p-3">
                                                    <div class="d-flex align-items-center mb-3">
                                                        <div class="avatar flex-shrink-0 me-3 bg-warning text-white">
                                                            B
                                                        </div>
                                                        <div class="flex-grow-1">
                                                            <h6 class="card-title mb-0">Budi</h6>
                                                            <small class="text-muted">Petani</small>
                                                        </div>
                                                    </div>
                                                    <div class="mt-2">
                                                        <p class="mb-1"><strong>Jenis Hasil Panen:</strong> Padi</p>
                                                        <p class="mb-1"><strong>Jumlah:</strong> 2 Ton</p>
                                                        <p class="mb-1"><strong>Harga Jual:</strong> Rp 3.000.000</p>
                                                        <p class="mb-0"><strong>Lokasi Lahan:</strong> RW 02 Desa
                                                            Pematang Duku Timur</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Generate Report Button -->
                    <div class="row mb-2">
                        <div class="col-12">
                            <div class="card animate-fade-in">
                                <div class="card-body p-3 text-center">
                                    <h5 class="card-title mb-0">Laporan BUMDes</h5>
                                    <p class="mb-2">Generate laporan lengkap untuk diserahkan ke pemerintah desa.</p>
                                    <button class="btn btn-primary btn-sm laporan-bumdes-btn" onclick="generateReport()">
                                        <i class="bx bx-file"></i> Generate Laporan PDF
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Footer -->
                <footer class="content-footer footer bg-footer-theme">
                    <div class="container-xxl d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
                        <div class="mb-2 mb-md-0">
                            ©
                            <script>
                                document.write(new Date().getFullYear());
                            </script>
                            , made with by
                            <a href="https://themeselection.com" target="_blank" class="footer-link fw-bolder">iSewa
                                Project Team 😎</a>
                        </div>
                        <div>
                        </div>
                    </div>
                </footer>
                <div class="content-backdrop fade"></div>
            </div>
        </div>
    </div>
@endsection
