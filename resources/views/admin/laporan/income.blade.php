@extends('admin.layouts.admin')

@section('title', 'Laporan Pendapatan')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        <!-- Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="fw-bold py-3 mb-0">
                            <span class="text-muted fw-light">Laporan /</span> Pendapatan
                        </h4>
                        <p class="text-muted mb-0">Ringkasan pendapatan dan analisis keuangan BUMDes.</p>
                    </div>
                    <div class="d-flex gap-2">
                        <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="bx bx-calendar me-1"></i> 2025
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="javascript:void(0);">2025</a></li>
                            <li><a class="dropdown-item" href="javascript:void(0);">2024</a></li>
                            <li><a class="dropdown-item" href="javascript:void(0);">2023</a></li>
                        </ul>
                        <button class="btn btn-primary" onclick="window.print()">
                            <i class="bx bx-printer me-1"></i> Cetak Laporan
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Summary Cards -->
        <div class="row g-4 mb-4">
            <!-- Total Pendapatan -->
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm hover-lift">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="avatar avatar-md me-3">
                                <span class="avatar-initial rounded-circle bg-label-primary">
                                    <i class='bx bx-wallet fs-4'></i>
                                </span>
                            </div>
                            <div>
                                <span class="d-block text-muted text-uppercase fs-7 fw-bold">Total Pendapatan</span>
                                <h4 class="mb-0 fw-bold text-primary">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}
                                </h4>
                            </div>
                        </div>
                        <div class="d-flex align-items-center small">
                            <span class="badge bg-label-success me-2"><i class="bx bx-up-arrow-alt"></i> +12.5%</span>
                            <span class="text-muted">dari bulan lalu</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pendapatan Penyewaan -->
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm hover-lift">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="avatar avatar-md me-3">
                                <span class="avatar-initial rounded-circle bg-label-warning">
                                    <i class='bx bx-wrench fs-4'></i>
                                </span>
                            </div>
                            <div>
                                <span class="d-block text-muted text-uppercase fs-7 fw-bold">Unit Penyewaan</span>
                                <h4 class="mb-0 fw-bold text-warning">Rp {{ number_format($totalPenyewaan, 0, ',', '.') }}
                                </h4>
                            </div>
                        </div>
                        <div class="d-flex align-items-center small">
                            <span class="badge bg-label-success me-2"><i class="bx bx-up-arrow-alt"></i> +8.2%</span>
                            <span class="text-muted">dari bulan lalu</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pendapatan Gas -->
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm hover-lift">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="avatar avatar-md me-3">
                                <span class="avatar-initial rounded-circle bg-label-info">
                                    <i class='bx bx-cylinder fs-4'></i>
                                </span>
                            </div>
                            <div>
                                <span class="d-block text-muted text-uppercase fs-7 fw-bold">Unit Gas</span>
                                <h4 class="mb-0 fw-bold text-info">Rp {{ number_format($totalGas, 0, ',', '.') }}</h4>
                            </div>
                        </div>
                        <div class="d-flex align-items-center small">
                            <span class="badge bg-label-danger me-2"><i class="bx bx-down-arrow-alt"></i> -2.4%</span>
                            <span class="text-muted">dari bulan lalu</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters & Kinerja Chart -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold">Kinerja Keuangan BUMDes</h5>
                        <div class="d-flex gap-2">
                            <select class="form-select form-select-sm" style="width: 150px;">
                                <option value="all">Semua Metode</option>
                                <option value="tunai">Tunai</option>
                                <option value="transfer">Transfer</option>
                            </select>
                            <select class="form-select form-select-sm" style="width: 120px;">
                                <option>Bulanan</option>
                                <option>Mingguan</option>
                                <option>Harian</option>
                            </select>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="kinerjaChart" style="min-height: 350px;"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Dashboard Charts Row -->
        <div class="row mb-4">
            <!-- Pendapatan dan Pengeluaran -->
            <div class="col-md-4 mb-4 mb-md-0">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0 fs-6 fw-bold">Pendapatan & Pengeluaran</h5>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button"
                                data-bs-toggle="dropdown">
                                2025
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="javascript:void(0);">2024</a></li>
                                <li><a class="dropdown-item" href="javascript:void(0);">2023</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="totalRevenueChart" class="px-2"></div>
                    </div>
                </div>
            </div>

            <!-- Perbandingan Transaksi -->
            <div class="dashboard-stats-col">
                <div class="card animate-fade-in">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Perbandingan Transaksi</h5>
                    </div>
                    <div class="card-body d-flex flex-column justify-content-center align-items-center"
                        style="min-height: 400px; padding: 2rem;">
                        <h2 class="mb-2">500</h2>
                        <span class="text-muted mb-4">Total Transaksi</span>
                        <!-- Large donut chart will be rendered here by inline script -->
                        <div id="transactionDonutChart" style="width: 100%; max-width: 300px;"></div>
                    </div>
                </div>
            </div>

            <!-- Transaksi dan Pendapatan -->
            <div class="col-md-4">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-header bg-white">
                        <h5 class="card-title mb-0 fs-6 fw-bold">Transaksi & Pendapatan</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="avatar p-2 me-2 rounded bg-label-success">
                                <i class="bx bx-dollar fs-4"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Pendapatan</h6>
                                <small class="text-muted">+42.9% dari minggu lalu</small>
                            </div>
                        </div>
                        <div id="incomeChart"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Unit Populer Chart -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white border-bottom">
                        <h5 class="mb-0 fw-bold">Statistik Unit Populer</h5>
                    </div>
                    <div class="card-body">
                        <div id="unitChart" style="min-height: 350px;"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Detail Table -->
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm border-0 overflow-hidden">
                    <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center py-3">
                        <h5 class="mb-0 fw-bold">Detail Pendapatan Per Unit</h5>
                        <button class="btn btn-sm btn-outline-primary">
                            <i class="bx bx-download me-1"></i> Unduh Data
                        </button>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="py-3 ps-4 text-uppercase fs-7 fw-bold text-muted">Unit Layanan</th>
                                    <th class="py-3 text-uppercase fs-7 fw-bold text-muted">Total Pendapatan</th>
                                    <th class="py-3 text-uppercase fs-7 fw-bold text-muted">Jumlah Transaksi</th>
                                    <th class="py-3 text-uppercase fs-7 fw-bold text-muted">Rata-rata / Transaksi</th>
                                    <th class="py-3 text-uppercase fs-7 fw-bold text-muted">Status Target</th>
                                </tr>
                            </thead>
                            <tbody class="border-top-0">
                                <tr>
                                    <td class="ps-4 py-3">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avatar-md me-3">
                                                <span
                                                    class="avatar-initial rounded-circle bg-label-warning bg-opacity-10 text-warning">
                                                    <i class='bx bx-wrench fs-4'></i>
                                                </span>
                                            </div>
                                            <div>
                                                <span class="fw-bold text-dark d-block">Penyewaan Alat</span>
                                                <small class="text-muted">Layanan penyewaan peralatan</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-3">
                                        <span class="fw-bold text-primary">Rp
                                            {{ number_format($totalPenyewaan, 0, ',', '.') }}</span>
                                    </td>
                                    <td class="py-3">
                                        <span
                                            class="badge bg-label-secondary rounded-pill px-3">{{ $rentalRequests->count() }}
                                            Transaksi</span>
                                    </td>
                                    <td class="py-3">
                                        <span class="text-dark">Rp
                                            {{ number_format($totalPenyewaan / max(1, $rentalRequests->count()), 0, ',', '.') }}</span>
                                    </td>
                                    <td class="py-3">
                                        <span class="badge bg-success bg-opacity-75 px-3 py-2 rounded-pill">Tercapai</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="ps-4 py-3">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avatar-md me-3">
                                                <span
                                                    class="avatar-initial rounded-circle bg-label-info bg-opacity-10 text-info">
                                                    <i class='bx bx-cylinder fs-4'></i>
                                                </span>
                                            </div>
                                            <div>
                                                <span class="fw-bold text-dark d-block">Penjualan Gas</span>
                                                <small class="text-muted">Layanan distribusi gas LPG</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-3">
                                        <span class="fw-bold text-info">Rp
                                            {{ number_format($totalGas, 0, ',', '.') }}</span>
                                    </td>
                                    <td class="py-3">
                                        <span class="badge bg-label-secondary rounded-pill px-3">{{ $gasOrders->count() }}
                                            Transaksi</span>
                                    </td>
                                    <td class="py-3">
                                        <span class="text-dark">Rp
                                            {{ number_format($totalGas / max(1, $gasOrders->count()), 0, ',', '.') }}</span>
                                    </td>
                                    <td class="py-3">
                                        <span class="badge bg-warning bg-opacity-75 px-3 py-2 rounded-pill">Perlu
                                            Peningkatan</span>
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot class="bg-light border-top">
                                <tr>
                                    <td class="ps-4 py-3">
                                        <span class="fw-bold text-uppercase text-dark">Total Keseluruhan</span>
                                    </td>
                                    <td class="py-3">
                                        <span class="fw-bolder text-dark fs-6">Rp
                                            {{ number_format($totalPendapatan, 0, ',', '.') }}</span>
                                    </td>
                                    <td class="py-3">
                                        <span
                                            class="fw-bold text-dark">{{ $rentalRequests->count() + $gasOrders->count() }}
                                            Transaksi</span>
                                    </td>
                                    <td class="py-3">
                                        <span class="fw-bold text-dark">Rp
                                            {{ number_format($totalPendapatan / max(1, $rentalRequests->count() + $gasOrders->count()), 0, ',', '.') }}</span>
                                    </td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Styles for Hover Effects -->
    <style>
        .hover-lift {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .hover-lift:hover {
            transform: translateY(-5px);
            box-shadow: 0 .5rem 1rem rgba(0, 0, 0, .15) !important;
        }

        .avatar-initial {
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>

    <!-- Scripts for Charts -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // ========================================
            // GRAFIK KINERJA BUMDES (AREA CHART)
            // ========================================
            const kinerjaElement = document.querySelector("#kinerjaChart");
            if (kinerjaElement) {
                const kinerjaOptions = {
                    series: [{
                        name: 'Kinerja',
                        data: [25, 20.8, 17.6, 20.2, 19.8, 22.5]
                    }],
                    chart: {
                        type: 'area',
                        height: 350,
                        toolbar: {
                            show: false
                        },
                        zoom: {
                            enabled: false
                        }
                    },
                    colors: ['#f59e0b'],
                    stroke: {
                        curve: 'smooth',
                        width: 3
                    },
                    fill: {
                        type: 'gradient',
                        gradient: {
                            shadeIntensity: 1,
                            opacityFrom: 0.45,
                            opacityTo: 0.05,
                            stops: [0, 90, 100]
                        }
                    },
                    dataLabels: {
                        enabled: false
                    },
                    markers: {
                        size: 0,
                        hover: {
                            size: 5
                        }
                    },
                    xaxis: {
                        categories: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni'],
                        labels: {
                            style: {
                                colors: '#374151',
                                fontSize: '12px'
                            }
                        },
                        axisBorder: {
                            show: false
                        },
                        axisTicks: {
                            show: false
                        }
                    },
                    yaxis: {
                        labels: {
                            formatter: function(val) {
                                return val.toFixed(1);
                            },
                            style: {
                                colors: '#6b7280',
                                fontSize: '11px'
                            }
                        }
                    },
                    grid: {
                        borderColor: '#e5e7eb',
                        strokeDashArray: 3,
                        xaxis: {
                            lines: {
                                show: true
                            }
                        },
                        yaxis: {
                            lines: {
                                show: true
                            }
                        },
                        padding: {
                            top: 0,
                            right: 0,
                            bottom: 0,
                            left: 10
                        }
                    },
                    tooltip: {
                        y: {
                            formatter: function(val) {
                                return val.toFixed(1);
                            }
                        }
                    }
                };
                const kinerjaChart = new ApexCharts(kinerjaElement, kinerjaOptions);
                kinerjaChart.render();
            }

            // ========================================
            // GRAFIK UNIT POPULER (BAR CHART)
            // ========================================
            const unitElement = document.querySelector("#unitChart");
            if (unitElement) {
                const unitOptions = {
                    series: [{
                            name: 'Unit Penyewaan Alat',
                            data: [20, 15, 30, 22, 17]
                        },
                        {
                            name: 'Unit Penjualan Gas',
                            data: [16, 17, 18, 20, 10]
                        },
                        {
                            name: 'Unit Pertanian dan Perkebunan',
                            data: [18, 10, 16, 20, 19]
                        },
                        {
                            name: 'Unit Simpan Pinjam',
                            data: [30, 12, 15, 10, 5]
                        }
                    ],
                    chart: {
                        type: 'bar',
                        height: 350,
                        toolbar: {
                            show: false
                        },
                        stacked: false,
                        background: 'transparent'
                    },
                    colors: ['#f59e0b', '#3b82f6', '#10b981', '#d1d5db'],
                    plotOptions: {
                        bar: {
                            horizontal: false,
                            columnWidth: '55%',
                            borderRadius: 4,
                            dataLabels: {
                                position: 'top'
                            }
                        }
                    },
                    dataLabels: {
                        enabled: false
                    },
                    xaxis: {
                        categories: ['Januari', 'Februari', 'Maret', 'April', 'Mei'],
                        labels: {
                            style: {
                                colors: '#374151',
                                fontSize: '12px',
                                fontWeight: 500
                            }
                        },
                        axisBorder: {
                            show: false
                        },
                        axisTicks: {
                            show: false
                        }
                    },
                    yaxis: {
                        labels: {
                            style: {
                                colors: '#6b7280',
                                fontSize: '11px'
                            }
                        }
                    },
                    grid: {
                        borderColor: '#e5e7eb',
                        strokeDashArray: 3,
                        padding: {
                            top: 0,
                            right: 0,
                            bottom: 0,
                            left: 10
                        }
                    },
                    legend: {
                        position: 'bottom',
                        horizontalAlign: 'center',
                        offsetY: 5
                    },
                    tooltip: {
                        shared: true,
                        intersect: false
                    }
                };
                const unitChart = new ApexCharts(unitElement, unitOptions);
                unitChart.render();
            }
        });
    </script>
@endsection
