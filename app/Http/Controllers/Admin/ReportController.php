<?php

namespace App\Http\Controllers\Admin;

use App\Models\RentalRequest;
use App\Models\GasOrder;
use App\Models\ManualReport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

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
        // Hitung total pendapatan per unit dari sistem
        $totalPenyewaan = RentalRequest::sum('price');
        $totalGas = GasOrder::selectRaw('SUM(price * quantity) as total')->value('total') ?? 0;
        
        // Hitung total dari manual reports
        $manualPenyewaan = ManualReport::where('category', 'penyewaan')->sum(\DB::raw('amount * quantity'));
        $manualGas = ManualReport::where('category', 'gas')->sum(\DB::raw('amount * quantity'));
        $manualLainnya = ManualReport::where('category', 'lainnya')->sum(\DB::raw('amount * quantity'));
        
        // Total keseluruhan
        $totalPenyewaan += $manualPenyewaan;
        $totalGas += $manualGas;
        $totalPendapatan = $totalPenyewaan + $totalGas + $manualLainnya;

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

        // Pendapatan dari sistem
        foreach (RentalRequest::selectRaw('SUM(price) as total, MONTH(created_at) as month')
            ->groupBy('month')
            ->pluck('total', 'month') as $month => $amount) {
            $monthlyIncome[getMonthName($month)] += $amount;
        }

        foreach (GasOrder::selectRaw('SUM(price * quantity) as total, MONTH(created_at) as month')
            ->groupBy('month')
            ->pluck('total', 'month') as $month => $amount) {
            $monthlyIncome[getMonthName($month)] += $amount;
        }
        
        // Pendapatan dari manual reports
        foreach (ManualReport::selectRaw('SUM(amount * quantity) as total, MONTH(transaction_date) as month')
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
        
        // Ambil manual reports
        $manualReports = ManualReport::with('creator')
            ->orderByDesc('transaction_date')
            ->get();

        // Hitung total transaksi untuk Donut Chart
        $rentalCount = \App\Models\RentalBooking::where('status', '!=', 'cancelled')->count();
        $gasCount = GasOrder::count();

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
            'gasCount'
        ));
    }

    public function logs()
    {
        // Ambil log aktivitas dari database (misalnya dari tabel `activity_log`)
        $logs = \DB::table('activity_log')->orderByDesc('created_at')->get();

        return view('admin.laporan.logs', compact('logs'));
    }
    
    /**
     * Store a new manual transaction
     */
    public function storeManualTransaction(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category' => 'required|in:penyewaan,gas,lainnya',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'amount' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:1',
            'payment_method' => 'required|in:tunai,transfer',
            'transaction_date' => 'required|date',
            'proof_image' => 'nullable|image|max:2048', // Max 2MB
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
     * Update an existing manual transaction
     */
    public function updateManualTransaction(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'category' => 'required|in:penyewaan,gas,lainnya',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'amount' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:1',
            'payment_method' => 'required|in:tunai,transfer',
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
                // Delete old image if exists
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
     * Delete a manual transaction
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