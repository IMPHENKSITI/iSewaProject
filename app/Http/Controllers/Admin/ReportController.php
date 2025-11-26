<?php

namespace App\Http\Controllers\Admin;

use App\Models\RentalRequest;
use App\Models\GasOrder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReportController extends Controller
{
    public function transactions()
    {
        $rentalRequests = RentalRequest::with('user')->orderByDesc('created_at')->get();
        $gasOrders = GasOrder::with('user')->orderByDesc('created_at')->get();

        return view('admin.laporan.transactions', compact('rentalRequests', 'gasOrders'));
    }

    public function income()
    {
        // Hitung total pendapatan per unit
        $totalPenyewaan = RentalRequest::sum('price');
        $totalGas = GasOrder::sum('price');
        $totalPendapatan = $totalPenyewaan + $totalGas;

        // Hitung pendapatan per bulan
        $monthlyIncome = [
            'Januari' => 0,
            'Februari' => 0,
            'Maret' => 0,
            'April' => 0,
            'Mei' => 0,
            'Juni' => 0,
            'Juli' => 0,
            'Agustus' => 0,
            'September' => 0,
            'Oktober' => 0,
            'November' => 0,
            'Desember' => 0,
        ];

        foreach (RentalRequest::selectRaw('SUM(price) as total, MONTH(created_at) as month')
            ->groupBy('month')
            ->pluck('total', 'month') as $month => $amount) {
            $monthlyIncome[getMonthName($month)] += $amount;
        }

        foreach (GasOrder::selectRaw('SUM(price) as total, MONTH(created_at) as month')
            ->groupBy('month')
            ->pluck('total', 'month') as $month => $amount) {
            $monthlyIncome[getMonthName($month)] += $amount;
        }

        // Data untuk chart
        $dataPoints = [];
        foreach ($monthlyIncome as $month => $income) {
            $dataPoints[] = ['label' => $month, 'y' => $income];
        }

        // Ambil data untuk detail per unit
        $rentalRequests = RentalRequest::all();
        $gasOrders = GasOrder::all();

        return view('admin.laporan.income', compact(
            'totalPenyewaan',
            'totalGas',
            'totalPendapatan',
            'monthlyIncome',
            'dataPoints',
            'rentalRequests',
            'gasOrders'
        ));
    }

    public function logs()
    {
        // Ambil log aktivitas dari database (misalnya dari tabel `activity_log`)
        $logs = \DB::table('activity_log')->orderByDesc('created_at')->get();

        return view('admin.laporan.logs', compact('logs'));
    }
}

function getMonthName($month)
{
    $months = [
        1 => 'Januari',
        2 => 'Februari',
        3 => 'Maret',
        4 => 'April',
        5 => 'Mei',
        6 => 'Juni',
        7 => 'Juli',
        8 => 'Agustus',
        9 => 'September',
        10 => 'Oktober',
        11 => 'November',
        12 => 'Desember',
    ];

    return $months[$month] ?? 'Unknown';
}