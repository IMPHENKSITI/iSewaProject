<?php

namespace App\Http\Controllers\Admin;

use App\Models\RentalBooking;
use App\Models\GasOrder;
use App\Models\ManualReport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\ActivityLog;

class ReportController extends Controller
{
    public function transactions(Request $request)
    {
        $status = $request->get('status');
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');

        // Query Penyewaan
        $rentalQuery = RentalBooking::with('user')->orderByDesc('created_at');
        
        // Query Gas
        $gasQuery = GasOrder::with('user')->orderByDesc('created_at');

        // Terapkan Filter
        if ($status && $status !== 'all') {
            $rentalQuery->where('status', $status);
            $gasQuery->where('status', $status);
        }

        if ($startDate) {
            $rentalQuery->whereDate('created_at', '>=', $startDate);
            $gasQuery->whereDate('created_at', '>=', $startDate);
        }

        if ($endDate) {
            $rentalQuery->whereDate('created_at', '<=', $endDate);
            $gasQuery->whereDate('created_at', '<=', $endDate);
        }

        $rentalRequests = $rentalQuery->get();
        $gasOrders = $gasQuery->get();

        return view('admin.laporan.transactions', compact('rentalRequests', 'gasOrders', 'status', 'startDate', 'endDate'));
    }

    public function income(Request $request)
    {
        $year = $request->input('year', date('Y'));

        // Hitung total pendapatan per unit dari sistem (Filter Tahunan)
        $totalPenyewaan = RentalBooking::whereYear('created_at', $year)
            ->whereNotIn('status', ['pending', 'cancelled', 'rejected'])
            ->sum('total_amount');
            
        $totalGas = GasOrder::whereYear('created_at', $year)
            ->whereNotIn('status', ['pending', 'cancelled', 'rejected'])
            ->selectRaw('SUM(price * quantity) as total')
            ->value('total') ?? 0;
        
        // Hitung total dari laporan manual (Filter Tahunan)
        $manualPenyewaan = ManualReport::whereYear('transaction_date', $year)
            ->where('category', 'penyewaan')
            ->sum(\DB::raw('amount * quantity'));
            
        $manualGas = ManualReport::whereYear('transaction_date', $year)
            ->where('category', 'gas')
            ->sum(\DB::raw('amount * quantity'));
            
        $manualLainnya = ManualReport::whereYear('transaction_date', $year)
            ->where('category', 'lainnya')
            ->sum(\DB::raw('amount * quantity'));
        
        // Total keseluruhan
        $totalPenyewaan += $manualPenyewaan;
        $totalGas += $manualGas;
        $totalPendapatan = $totalPenyewaan + $totalGas + $manualLainnya;

        // Hitung pendapatan per bulan
        $months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        $monthlyIncome = array_fill_keys($months, 0);

        // Pendapatan dari sistem (RentalBooking)
        $rentalMonthly = RentalBooking::selectRaw('SUM(total_amount) as total, MONTH(created_at) as month')
            ->whereYear('created_at', $year)
            ->whereNotIn('status', ['pending', 'cancelled', 'rejected'])
            ->groupBy('month')
            ->pluck('total', 'month');

        foreach ($rentalMonthly as $month => $amount) {
            $monthlyIncome[getMonthName($month)] += $amount;
        }

        // Pendapatan dari sistem (GasOrder)
        $gasMonthly = GasOrder::selectRaw('SUM(price * quantity) as total, MONTH(created_at) as month')
            ->whereYear('created_at', $year)
            ->whereNotIn('status', ['pending', 'cancelled', 'rejected'])
            ->groupBy('month')
            ->pluck('total', 'month');

        foreach ($gasMonthly as $month => $amount) {
            $monthlyIncome[getMonthName($month)] += $amount;
        }
        
        // Pendapatan dari laporan manual
        $manualMonthly = ManualReport::selectRaw('SUM(amount * quantity) as total, MONTH(transaction_date) as month')
            ->whereYear('transaction_date', $year)
            ->groupBy('month')
            ->pluck('total', 'month');

        foreach ($manualMonthly as $month => $amount) {
            $monthlyIncome[getMonthName($month)] += $amount;
        }

        // Data untuk chart
        $dataPoints = [];
        foreach ($monthlyIncome as $month => $income) {
            $dataPoints[] = ['label' => $month, 'y' => $income];
        }

        // Ambil data untuk detail per unit (Difilter Berdasarkan Tahun)
        $rentalRequests = RentalBooking::whereYear('created_at', $year)->get(); // For count & stats
        $gasOrders = GasOrder::whereYear('created_at', $year)->get();
        
        // Ambil laporan manual (Difilter Berdasarkan Tahun)
        $manualReports = ManualReport::with('creator')
            ->whereYear('transaction_date', $year)
            ->orderByDesc('transaction_date')
            ->get();

        // Hitung total transaksi untuk Donut Chart (Filter Tahunan)
        $rentalCount = RentalBooking::whereYear('created_at', $year)
            ->whereNotIn('status', ['pending', 'cancelled', 'rejected'])
            ->count();
            
        $gasCount = GasOrder::whereYear('created_at', $year)
            ->whereNotIn('status', ['pending', 'cancelled', 'rejected'])
            ->count();
            
        // Ambil Bulan Terpilih (untuk Tampilan Detail & Perhitungan Pertumbuhan)
        $selectedMonth = $request->input('month', date('m'));
        $selectedYear = $year; // Use the selected year context

        // Ambil Data Bulan Saat Ini
        $currentMonthData = $this->getTotalPendapatanData($selectedMonth, $selectedYear);

        // Ambil Data Bulan Sebelumnya
        $prevMonth = $selectedMonth - 1;
        $prevYear = $selectedYear;
        if ($prevMonth == 0) {
            $prevMonth = 12;
            $prevYear--;
        }
        $prevMonthData = $this->getTotalPendapatanData($prevMonth, $prevYear);

        // Hitung Fungsi Pertumbuhan
        $calculateGrowth = function($current, $previous) {
            if ($previous == 0) {
                return $current > 0 ? 100 : 0;
            }
            return round((($current - $previous) / $previous) * 100, 1);
        };

        $growth = [
            'total' => $calculateGrowth($currentMonthData['total']['revenue'], $prevMonthData['total']['revenue']),
            'rental' => $calculateGrowth($currentMonthData['rental']['revenue'], $prevMonthData['rental']['revenue']),
            'gas' => $calculateGrowth($currentMonthData['gas']['revenue'], $prevMonthData['gas']['revenue']),
        ];

        // Teruskan Data Total Pendapatan (untuk Tampilan Detail) - sama seperti currentMonthData
        $totalPendapatanData = $currentMonthData;
        
        // Ambil data Unit Populer (perbandingan penyewaan vs gas)
        $unitPopulerData = $this->getUnitPopulerData($year);

        return view('admin.laporan.income', compact(
            'totalPenyewaan',
            'totalGas',
            'totalPendapatan',
            'monthlyIncome',
            'dataPoints',
            'rentalRequests',
            'gasOrders',
            'manualReports',
            'manualLainnya',
            'rentalCount',
            'gasCount',
            'year',
            'totalPendapatanData',
            'unitPopulerData',
            'growth'
        ));
    }
    
    /**
     * Ambil data Unit Populer - Perbandingan antara penyewaan dan penjualan gas
     */
    private function getUnitPopulerData($year)
    {
        $months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        $rentalData = [];
        $gasData = [];
        
        for ($month = 1; $month <= 12; $month++) {
            // Hitung pesanan penyewaan
            $rentalCount = RentalBooking::whereYear('created_at', $year)
                ->whereMonth('created_at', $month)
                ->whereNotIn('status', ['pending', 'cancelled', 'rejected'])
                ->count();
            
            // Hitung pesanan gas
            $gasCount = GasOrder::whereYear('created_at', $year)
                ->whereMonth('created_at', $month)
                ->whereNotIn('status', ['pending', 'cancelled', 'rejected'])
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
     * Ambil data Total Pendapatan - Rincian pendapatan berdasarkan unit
     */
    private function getTotalPendapatanData($month, $year)
    {   
        // Pendapatan Penyewaan Alat
        $rentalRevenue = RentalBooking::whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->whereNotIn('status', ['pending', 'cancelled', 'rejected'])
            ->sum('total_amount');
        
        $rentalTransactions = RentalBooking::whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->whereNotIn('status', ['pending', 'cancelled', 'rejected'])
            ->count();
        
        // Pendapatan Penjualan Gas
        $gasRevenue = GasOrder::whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->whereNotIn('status', ['pending', 'cancelled', 'rejected'])
            ->sum(\DB::raw('price * quantity'));
        
        $gasTransactions = GasOrder::whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->whereNotIn('status', ['pending', 'cancelled', 'rejected'])
            ->count();

        // Pendapatan Laporan Manual
        $manualRevenue = ManualReport::whereYear('transaction_date', $year)
            ->whereMonth('transaction_date', $month)
            ->sum(\DB::raw('amount * quantity'));
        
        $manualTransactions = ManualReport::whereYear('transaction_date', $year)
            ->whereMonth('transaction_date', $month)
            ->count();
        
        $totalRevenue = $rentalRevenue + $gasRevenue + $manualRevenue;
        $totalTransactions = $rentalTransactions + $gasTransactions + $manualTransactions;
        
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



    public function logs(Request $request)
    {
        $query = ActivityLog::with('user')->orderByDesc('created_at');

        // Cari (Deskripsi atau Nama Pengguna)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('description', 'like', "%{$search}%")
                  ->orWhere('action', 'like', "%{$search}%")
                  ->orWhereHas('user', function($u) use ($search) {
                      $u->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // Filter berdasarkan Aksi
        if ($request->filled('action')) {
            $query->where('action', 'like', "%{$request->action}%");
        }

        // Filter berdasarkan Tanggal
        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        $logs = $query->paginate(10)->withQueryString();

        return view('admin.laporan.logs', compact('logs'));
    }
    
    /**
     * Simpan transaksi manual baru
     */
    public function storeManualTransaction(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category' => 'required|in:penyewaan,gas,lainnya',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'amount' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:1',
            'payment_method' => 'required|in:tunai',
            'transaction_date' => 'required|date',
            'proof_image' => 'nullable|image|max:2048', // Maks 2MB
        ], [
            'category.required' => 'Kategori harus dipilih',
            'category.in' => 'Kategori tidak valid',
            'name.required' => 'Nama item harus diisi',
            'amount.required' => 'Harga harus diisi',
            'amount.numeric' => 'Harga harus berupa angka',
            'amount.min' => 'Harga tidak boleh negatif',
            'quantity.required' => 'Jumlah harus diisi',
            'quantity.integer' => 'Jumlah harus berupa angka bulat',
            'quantity.min' => 'Jumlah minimal 1',
            'payment_method.required' => 'Metode pembayaran harus dipilih',
            'payment_method.in' => 'Metode pembayaran tidak valid',
            'transaction_date.required' => 'Tanggal transaksi harus diisi',
            'transaction_date.date' => 'Format tanggal tidak valid',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $proofImagePath = null;
            if ($request->hasFile('proof_image')) {
                $file = $request->file('proof_image');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('manual-reports'), $filename);
                $proofImagePath = 'manual-reports/' . $filename;
            }

            $manualReport = ManualReport::create([
                'category' => $request->category,
                'name' => $request->name,
                'description' => $request->description,
                'amount' => $request->amount,
                'quantity' => $request->quantity,
                'payment_method' => $request->payment_method,
                'transaction_date' => $request->transaction_date,
                'created_by' => Auth::id(),
                'proof_image' => $proofImagePath,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Laporan transaksi berhasil ditambahkan',
                'data' => $manualReport
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Perbarui transaksi manual yang ada
     */
    public function updateManualTransaction(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'category' => 'required|in:penyewaan,gas,lainnya',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'amount' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:1',
            'payment_method' => 'required|in:tunai',
            'transaction_date' => 'required|date',
            'proof_image' => 'nullable|image|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $manualReport = ManualReport::findOrFail($id);
            
            $data = [
                'category' => $request->category,
                'name' => $request->name,
                'description' => $request->description,
                'amount' => $request->amount,
                'quantity' => $request->quantity,
                'payment_method' => $request->payment_method,
                'transaction_date' => $request->transaction_date,
            ];

            if ($request->hasFile('proof_image')) {
                // Hapus gambar lama jika ada
                if ($manualReport->proof_image && file_exists(public_path($manualReport->proof_image))) {
                    unlink(public_path($manualReport->proof_image));
                }

                $file = $request->file('proof_image');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('manual-reports'), $filename);
                $data['proof_image'] = 'manual-reports/' . $filename;
            }

            $manualReport->update($data);

            return response()->json([
                'success' => true,
                'message' => 'Laporan transaksi berhasil diperbarui',
                'data' => $manualReport
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Hapus transaksi manual
     */
    public function destroyManualTransaction($id)
    {
        try {
            $manualReport = ManualReport::findOrFail($id);
            
            if ($manualReport->proof_image && file_exists(public_path($manualReport->proof_image))) {
                unlink(public_path($manualReport->proof_image));
            }
            
            $manualReport->delete();

            return response()->json([
                'success' => true,
                'message' => 'Laporan transaksi berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
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