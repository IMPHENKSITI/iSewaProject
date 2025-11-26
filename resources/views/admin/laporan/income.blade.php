@extends('admin.layouts.admin')

@section('title', 'Laporan Pendapatan')

@section('content')
    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-10">
                <!-- HEADER -->
                <h2 class="text-primary fw-bold mb-4">Laporan Pendapatan</h2>
                <p class="text-muted mb-4">Total pendapatan dari penyewaan alat dan pembelian gas.</p>

                <!-- TOTAL PENDAPATAN -->
                <div class="row g-4 mb-4">
                    <div class="col-md-4">
                        <div class="card shadow-sm border-0 rounded-4 p-3">
                            <div class="d-flex align-items-center">
                                <div class="avatar flex-shrink-0 me-3">
                                    <span class="avatar-initial rounded bg-label-primary">P</span>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="fw-bold mb-1">Total Pendapatan</h6>
                                    <h4 class="mb-0">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card shadow-sm border-0 rounded-4 p-3">
                            <div class="d-flex align-items-center">
                                <div class="avatar flex-shrink-0 me-3">
                                    <span class="avatar-initial rounded bg-label-success">A</span>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="fw-bold mb-1">Pendapatan Penyewaan</h6>
                                    <h4 class="mb-0">Rp {{ number_format($totalPenyewaan, 0, ',', '.') }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card shadow-sm border-0 rounded-4 p-3">
                            <div class="d-flex align-items-center">
                                <div class="avatar flex-shrink-0 me-3">
                                    <span class="avatar-initial rounded bg-label-info">G</span>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="fw-bold mb-1">Pendapatan Gas</h6>
                                    <h4 class="mb-0">Rp {{ number_format($totalGas, 0, ',', '.') }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- CHARTS -->
                <div class="row g-4 mb-4">
                    <div class="col-md-6">
                        <div class="card shadow-sm border-0 rounded-4">
                            <div class="card-header bg-white border-bottom">
                                <h5 class="mb-0">Pendapatan Per Bulan</h5>
                            </div>
                            <div class="card-body p-3">
                                <div id="monthlyIncomeChart" style="height: 300px;"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card shadow-sm border-0 rounded-4">
                            <div class="card-header bg-white border-bottom">
                                <h5 class="mb-0">Perbandingan Pendapatan</h5>
                            </div>
                            <div class="card-body p-3">

                                <head>
                                    <script>
                                        window.onload = function() {

                                            var totalVisitors = 883000;
                                            var visitorsData = {
                                                "New vs Returning Visitors": [{
                                                    click: visitorsChartDrilldownHandler,
                                                    cursor: "pointer",
                                                    explodeOnClick: false,
                                                    innerRadius: "75%",
                                                    legendMarkerType: "square",
                                                    name: "New vs Returning Visitors",
                                                    radius: "100%",
                                                    showInLegend: true,
                                                    startAngle: 90,
                                                    type: "doughnut",
                                                    dataPoints: [{
                                                            y: 519960,
                                                            name: "New Visitors",
                                                            color: "#E7823A"
                                                        },
                                                        {
                                                            y: 363040,
                                                            name: "Returning Visitors",
                                                            color: "#546BC1"
                                                        }
                                                    ]
                                                }],
                                                "New Visitors": [{
                                                    color: "#E7823A",
                                                    name: "New Visitors",
                                                    type: "column",
                                                    dataPoints: [{
                                                            x: new Date("1 Jan 2015"),
                                                            y: 33000
                                                        },
                                                        {
                                                            x: new Date("1 Feb 2015"),
                                                            y: 35960
                                                        },
                                                        {
                                                            x: new Date("1 Mar 2015"),
                                                            y: 42160
                                                        },
                                                        {
                                                            x: new Date("1 Apr 2015"),
                                                            y: 42240
                                                        },
                                                        {
                                                            x: new Date("1 May 2015"),
                                                            y: 43200
                                                        },
                                                        {
                                                            x: new Date("1 Jun 2015"),
                                                            y: 40600
                                                        },
                                                        {
                                                            x: new Date("1 Jul 2015"),
                                                            y: 42560
                                                        },
                                                        {
                                                            x: new Date("1 Aug 2015"),
                                                            y: 44280
                                                        },
                                                        {
                                                            x: new Date("1 Sep 2015"),
                                                            y: 44800
                                                        },
                                                        {
                                                            x: new Date("1 Oct 2015"),
                                                            y: 48720
                                                        },
                                                        {
                                                            x: new Date("1 Nov 2015"),
                                                            y: 50840
                                                        },
                                                        {
                                                            x: new Date("1 Dec 2015"),
                                                            y: 51600
                                                        }
                                                    ]
                                                }],
                                                "Returning Visitors": [{
                                                    color: "#546BC1",
                                                    name: "Returning Visitors",
                                                    type: "column",
                                                    dataPoints: [{
                                                            x: new Date("1 Jan 2015"),
                                                            y: 22000
                                                        },
                                                        {
                                                            x: new Date("1 Feb 2015"),
                                                            y: 26040
                                                        },
                                                        {
                                                            x: new Date("1 Mar 2015"),
                                                            y: 25840
                                                        },
                                                        {
                                                            x: new Date("1 Apr 2015"),
                                                            y: 23760
                                                        },
                                                        {
                                                            x: new Date("1 May 2015"),
                                                            y: 28800
                                                        },
                                                        {
                                                            x: new Date("1 Jun 2015"),
                                                            y: 29400
                                                        },
                                                        {
                                                            x: new Date("1 Jul 2015"),
                                                            y: 33440
                                                        },
                                                        {
                                                            x: new Date("1 Aug 2015"),
                                                            y: 37720
                                                        },
                                                        {
                                                            x: new Date("1 Sep 2015"),
                                                            y: 35200
                                                        },
                                                        {
                                                            x: new Date("1 Oct 2015"),
                                                            y: 35280
                                                        },
                                                        {
                                                            x: new Date("1 Nov 2015"),
                                                            y: 31160
                                                        },
                                                        {
                                                            x: new Date("1 Dec 2015"),
                                                            y: 34400
                                                        }
                                                    ]
                                                }]
                                            };

                                            var newVSReturningVisitorsOptions = {
                                                animationEnabled: true,
                                                theme: "light2",
                                                title: {
                                                    text: "New VS Returning Visitors"
                                                },
                                                subtitles: [{
                                                    text: "Click on Any Segment to Drilldown",
                                                    backgroundColor: "#2eacd1",
                                                    fontSize: 16,
                                                    fontColor: "white",
                                                    padding: 5
                                                }],
                                                legend: {
                                                    fontFamily: "calibri",
                                                    fontSize: 14,
                                                    itemTextFormatter: function(e) {
                                                        return e.dataPoint.name + ": " + Math.round(e.dataPoint.y / totalVisitors * 100) + "%";
                                                    }
                                                },
                                                data: []
                                            };

                                            var visitorsDrilldownedChartOptions = {
                                                animationEnabled: true,
                                                theme: "light2",
                                                axisX: {
                                                    labelFontColor: "#717171",
                                                    lineColor: "#a2a2a2",
                                                    tickColor: "#a2a2a2"
                                                },
                                                axisY: {
                                                    gridThickness: 0,
                                                    includeZero: false,
                                                    labelFontColor: "#717171",
                                                    lineColor: "#a2a2a2",
                                                    tickColor: "#a2a2a2",
                                                    lineThickness: 1
                                                },
                                                data: []
                                            };

                                            var chart = new CanvasJS.Chart("chartContainer", );
                                            chart.options.data = visitorsData["New vs Returning Visitors"];
                                            chart.render();

                                            function visitorsChartDrilldownHandler(e) {
                                                chart = new CanvasJS.Chart("chartContainer", visitorsDrilldownedChartOptions);
                                                chart.options.data = visitorsData[e.dataPoint.name];
                                                chart.options.title = {
                                                    text: e.dataPoint.name
                                                }
                                                chart.render();
                                                $("#backButton").toggleClass("invisible");
                                            }

                                            $("#backButton").click(function() {
                                                $(this).toggleClass("invisible");
                                                chart = new CanvasJS.Chart("chartContainer", newVSReturningVisitorsOptions);
                                                chart.options.data = visitorsData["New vs Returning Visitors"];
                                                chart.render();
                                            });

                                        }
                                    </script>
                                    <style>
                                        #backButton {
                                            border-radius: 4px;
                                            padding: 8px;
                                            border: none;
                                            font-size: 16px;
                                            background-color: #2eacd1;
                                            color: white;
                                            position: absolute;
                                            top: 10px;
                                            right: 10px;
                                            cursor: pointer;
                                        }

                                        .invisible {
                                            display: none;
                                        }
                                    </style>
                                </head>

                                <body>

                                    <div id="chartContainer" style="height: 370px; width: 100%;"></div>
                                    <button class="btn invisible" id="backButton">
                                        < Back</button>
                                            <script src="https://canvasjs.com/assets/script/jquery-1.11.1.min.js"></script>
                                            <script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- PENDAPATAN PER UNIT -->
                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-header bg-white border-bottom">
                        <h5 class="mb-0">Detail Pendapatan Per Unit</h5>
                    </div>
                    <div class="card-body p-3">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Unit</th>
                                        <th>Total Pendapatan</th>
                                        <th>Jumlah Transaksi</th>
                                        <th>Rata-rata Per Transaksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Penyewaan Alat</td>
                                        <td>Rp {{ number_format($totalPenyewaan, 0, ',', '.') }}</td>
                                        <td>{{ $rentalRequests->count() }}</td>
                                        <td>Rp
                                            {{ number_format($totalPenyewaan / max(1, $rentalRequests->count()), 0, ',', '.') }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Pembelian Gas</td>
                                        <td>Rp {{ number_format($totalGas, 0, ',', '.') }}</td>
                                        <td>{{ $gasOrders->count() }}</td>
                                        <td>Rp {{ number_format($totalGas / max(1, $gasOrders->count()), 0, ',', '.') }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Total</strong></td>
                                        <td><strong>Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</strong></td>
                                        <td><strong>{{ $rentalRequests->count() + $gasOrders->count() }}</strong></td>
                                        <td><strong>Rp
                                                {{ number_format($totalPendapatan / max(1, $rentalRequests->count() + $gasOrders->count()), 0, ',', '.') }}</strong>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Export Button -->
    <div class="mt-4 text-center">
        <a href="#" class="btn btn-outline-primary" onclick="exportExcel()">
            <i class="bx bx-download"></i> Export Excel
        </a>
        <a href="#" class="btn btn-outline-secondary" onclick="exportPDF()">
            <i class="bx bx-file"></i> Export PDF
        </a>
    </div>

@endsection

@section('scripts')
    <script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
    <script>
        // Monthly Income Chart
        var monthlyIncomeChart = new CanvasJS.Chart("monthlyIncomeChart", {
            animationEnabled: true,
            theme: "light2",
            title: {
                text: "Pendapatan Per Bulan"
            },
            axisX: {
                title: "Bulan"
            },
            axisY: {
                title: "Pendapatan (Rp)",
                valueFormatString: "Rp #,##0"
            },
            data: [{
                type: "line",
                dataPoints: @json($dataPoints)
            }]
        });
        monthlyIncomeChart.render();

        // Income Comparison Chart
        var incomeComparisonChart = new CanvasJS.Chart("incomeComparisonChart", {
            animationEnabled: true,
            theme: "light2",
            title: {
                text: "Perbandingan Pendapatan"
            },
            data: [{
                type: "pie",
                startAngle: 25,
                toolTipContent: "<b>{label}</b>: {y}%",
                showInLegend: "true",
                legendText: "{label}",
                indexLabelFontSize: 16,
                indexLabel: "{label} - {y}%",
                dataPoints: [{
                        y: {{ $totalPenyewaan }},
                        label: "Penyewaan Alat"
                    },
                    {
                        y: {{ $totalGas }},
                        label: "Pembelian Gas"
                    }
                ]
            }]
        });
        incomeComparisonChart.render();

        function exportExcel() {
            alert('Fitur export Excel belum tersedia. Silakan hubungi developer.');
        }

        function exportPDF() {
            alert('Fitur export PDF belum tersedia. Silakan hubungi developer.');
        }
    </script>
@endsection
