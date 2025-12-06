<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RentalBooking;
use App\Models\GasOrder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BumdesLaporanController extends Controller
{
    public function index()
    {
        $year = request('year', date('Y'));
        
        // Get Kinerja BUMDes data (monthly revenue)
        $kinerjaData = $this->getKinerjaData($year);
        
        // Get Unit Populer data (rental vs gas comparison)
        $unitPopulerData = $this->getUnitPopulerData($year);
        
        // Get Total Pendapatan data
        $totalPendapatanData = $this->getTotalPendapatanData();
        
        return view('users.bumdes-laporan', compact(
            'kinerjaData',
            'unitPopulerData',
            'totalPendapatanData',
            'year'
        ));
    }
    
    /**
     * Get Kinerja BUMDes data - Monthly revenue from both rental and gas
     */
    private function getKinerjaData($year)
    {
        $months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        $monthlyData = [];
        
        for ($month = 1; $month <= 12; $month++) {
            // Get rental revenue for this month
            $rentalRevenue = RentalBooking::whereYear('created_at', $year)
                ->whereMonth('created_at', $month)
                ->whereIn('status', ['selesai', 'disetujui', 'sedang_berlangsung'])
                ->sum('total_amount');
            
            // Get gas revenue for this month
            $gasRevenue = GasOrder::whereYear('created_at', $year)
                ->whereMonth('created_at', $month)
                ->whereIn('status', ['selesai', 'disetujui', 'sedang_berlangsung'])
                ->sum(DB::raw('price * quantity'));
            
            // Total revenue in millions
            $totalRevenue = ($rentalRevenue + $gasRevenue) / 1000000;
            
            $monthlyData[] = round($totalRevenue, 1);
        }
        
        return [
            'categories' => array_slice($months, 0, 5), // Show first 5 months for now
            'data' => array_slice($monthlyData, 0, 5)
        ];
    }
    
    /**
     * Get Unit Populer data - Comparison between rental and gas sales
     */
    private function getUnitPopulerData($year)
    {
        $months = ['Januari', 'Februari', 'Maret', 'April', 'Mei'];
        $rentalData = [];
        $gasData = [];
        
        for ($month = 1; $month <= 5; $month++) {
            // Count rental orders
            $rentalCount = RentalBooking::whereYear('created_at', $year)
                ->whereMonth('created_at', $month)
                ->whereIn('status', ['selesai', 'disetujui', 'sedang_berlangsung'])
                ->count();
            
            // Count gas orders
            $gasCount = GasOrder::whereYear('created_at', $year)
                ->whereMonth('created_at', $month)
                ->whereIn('status', ['selesai', 'disetujui', 'sedang_berlangsung'])
                ->count();
            
            $rentalData[] = $rentalCount;
            $gasData[] = $gasCount;
        }
        
        return [
            'categories' => $months,
            'rental' => $rentalData,
            'gas' => $gasData
        ];
    }
    
    /**
     * Get Total Pendapatan data - Revenue breakdown by unit
     */
    private function getTotalPendapatanData()
    {
        // Get current month/year or from request
        $month = request('month', date('m'));
        $year = request('year', date('Y'));
        
        // Rental Equipment Revenue
        $rentalRevenue = RentalBooking::whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->whereIn('status', ['selesai', 'disetujui', 'sedang_berlangsung'])
            ->sum('total_amount');
        
        $rentalTransactions = RentalBooking::whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->whereIn('status', ['selesai', 'disetujui', 'sedang_berlangsung'])
            ->count();
        
        // Gas Sales Revenue
        $gasRevenue = GasOrder::whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->whereIn('status', ['selesai', 'disetujui', 'sedang_berlangsung'])
            ->sum(DB::raw('price * quantity'));
        
        $gasTransactions = GasOrder::whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->whereIn('status', ['selesai', 'disetujui', 'sedang_berlangsung'])
            ->count();
        
        $totalRevenue = $rentalRevenue + $gasRevenue;
        $totalTransactions = $rentalTransactions + $gasTransactions;
        
        return [
            'rental' => [
                'revenue' => $rentalRevenue,
                'transactions' => $rentalTransactions,
                'percentage' => $totalRevenue > 0 ? round(($rentalRevenue / $totalRevenue) * 100, 1) : 0
            ],
            'gas' => [
                'revenue' => $gasRevenue,
                'transactions' => $gasTransactions,
                'percentage' => $totalRevenue > 0 ? round(($gasRevenue / $totalRevenue) * 100, 1) : 0
            ],
            'total' => [
                'revenue' => $totalRevenue,
                'transactions' => $totalTransactions
            ],
            'month' => $month,
            'year' => $year
        ];
    }
}
