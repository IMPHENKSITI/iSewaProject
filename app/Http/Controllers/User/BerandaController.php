<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RentalBooking;
use App\Models\GasOrder;
use Illuminate\Support\Facades\DB;

class BerandaController extends Controller
{
    public function index()
    {
        $year = date('Y');
        
        // Get Kinerja BUMDes data (monthly revenue)
        $kinerjaData = $this->getKinerjaData($year);
        
        // Get Unit Populer data (rental vs gas comparison)
        $unitPopulerData = $this->getUnitPopulerData($year);
        
        return view('beranda.index', compact(
            'kinerjaData',
            'unitPopulerData',
            'year'
        ));
    }
    
    /**
     * Get Kinerja BUMDes data - Monthly revenue from both rental and gas
     */
    private function getKinerjaData($year)
    {
        $months = ['Januari', 'Februari', 'Maret', 'April', 'Mei'];
        $monthlyData = [];
        
        for ($month = 1; $month <= 5; $month++) {
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
            'categories' => $months,
            'data' => $monthlyData
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
}
