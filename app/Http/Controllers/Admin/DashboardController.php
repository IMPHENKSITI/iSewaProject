<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Barang;
use App\Models\Gas;
use App\Models\RentalBooking;
use App\Models\RentalRequest;
use App\Models\GasOrder;
use App\Models\ManualReport;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
   /**
 * Display Dashboard
 */
public function index()
{
    // Fetch pending rental bookings
    $currentYear = date('Y');
    $rentalRequests = RentalBooking::with(['user', 'barang'])
        ->where('status', 'pending')
        ->get()
        ->map(function ($item) {
            $item->type = 'rental';
            $item->item_name = $item->barang->nama_barang ?? 'Unknown Item';
            return $item;
        });

    // Fetch pending gas orders
    $gasRequests = GasOrder::with('user')
        ->where('status', 'pending')
        ->get()
        ->map(function ($item) {
            $item->type = 'gas';
            $item->item_name = $item->item_name ?? 'Gas Order'; 
            return $item;
        });

    // Merge and sort by created_at desc
    $latestRequests = $rentalRequests->concat($gasRequests)->sortByDesc('created_at')->take(5);

    // Calculate real stats
    $totalOrders = RentalBooking::count() + GasOrder::count();
    
    // Hitung total order selesai/sukses
    $completedRentals = RentalBooking::where('status', 'resolved')->count();
    $completedGas = GasOrder::where('status', 'completed')->count();
    $completedOrders = $completedRentals + $completedGas;

    // Hitung statistik untuk Donut Chart (Total Transaksi per Kategori) - Filter Tahun Ini & Tidak Cancel
    // Hitung statistik untuk Donut Chart (Total Transaksi per Kategori)
    $rentalCount = RentalBooking::whereYear('created_at', $currentYear)
        ->whereNotIn('status', ['pending', 'cancelled', 'rejected'])
        ->count();

    $gasCount = GasOrder::whereYear('created_at', $currentYear)
        ->whereNotIn('status', ['pending', 'cancelled', 'rejected'])
        ->count();

    $totalPending = $rentalRequests->count() + $gasRequests->count();

    // ========================================
    // REAL DATA CALCULATIONS FOR CHARTS
    // ========================================
    
    // Calculate monthly performance (total transactions per month)
    $monthlyPerformance = [];
    
    for ($month = 1; $month <= 12; $month++) {
        $rentalMonthCount = RentalBooking::whereMonth('created_at', $month)
            ->whereYear('created_at', $currentYear)
            ->whereNotIn('status', ['pending', 'cancelled', 'rejected'])
            ->count();
        
        $gasMonthCount = GasOrder::whereMonth('created_at', $month)
            ->whereYear('created_at', $currentYear)
            ->whereNotIn('status', ['pending', 'cancelled', 'rejected'])
            ->count();
        
        $monthlyPerformance[] = $rentalMonthCount + $gasMonthCount;
    }
    
    // Calculate monthly income and expenses (SAME AS ReportController)
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
    
    // Pendapatan dari sistem (RentalBooking)
    foreach (RentalBooking::selectRaw('SUM(total_amount) as total, MONTH(created_at) as month')
        ->whereYear('created_at', $currentYear)
        ->whereNotIn('status', ['pending', 'cancelled', 'rejected'])
        ->groupBy('month')
        ->pluck('total', 'month') as $month => $amount) {
        $monthlyIncome[getMonthName($month)] += $amount;
    }

    // Pendapatan dari gas orders
    foreach (GasOrder::selectRaw('SUM(price * quantity) as total, MONTH(created_at) as month')
        ->whereYear('created_at', $currentYear)
        ->whereNotIn('status', ['pending', 'cancelled', 'rejected'])
        ->groupBy('month')
        ->pluck('total', 'month') as $month => $amount) {
        $monthlyIncome[getMonthName($month)] += $amount;
    }
    
    // Pendapatan dari manual reports
    foreach (ManualReport::selectRaw('SUM(amount * quantity) as total, MONTH(transaction_date) as month')
        ->whereYear('transaction_date', $currentYear)
        ->groupBy('month')
        ->pluck('total', 'month') as $month => $amount) {
        $monthlyIncome[getMonthName($month)] += $amount;
    }
    
    // Expenses - set to 0 for now
    $monthlyExpenses = array_fill(0, 12, 0);
    
    // Calculate popular items statistics (real data from database)
    $popularItems = [
        'gas_lpg_3kg' => GasOrder::where('item_name', 'LIKE', '%3%')->count(),
        'sound_system' => RentalBooking::whereHas('barang', function($q) {
                $q->where('nama_barang', 'LIKE', '%Sound%');
            })->count(),
        'tenda_komplit' => RentalBooking::whereHas('barang', function($q) {
                $q->where('nama_barang', 'LIKE', '%Tenda%');
            })->count(),
        'meja_kursi' => RentalBooking::whereHas('barang', function($q) {
                $q->where('nama_barang', 'LIKE', '%Meja%')
                  ->orWhere('nama_barang', 'LIKE', '%Kursi%');
            })->count(),
    ];

    $data = [
        'totalUsers' => User::count(),
        'totalOrders' => $totalOrders,
        'newUsers' => User::whereDate('created_at', '>=', now()->subMonth())->count(),
        'completedOrders' => $completedOrders,
        'latestRequests' => $latestRequests,
        'totalPending' => $totalPending,
        'rentalCount' => $rentalCount,
        'gasCount' => $gasCount,
        // Real data for charts
        'monthlyPerformance' => $monthlyPerformance,
        'monthlyIncome' => $monthlyIncome,
        'monthlyExpenses' => $monthlyExpenses,
        'popularItems' => $popularItems,
    ];

    // Ambil jumlah item untuk setiap unit layanan
    $data['unitPenyewaan'] = Barang::count(); 
    $data['unitGas'] = Gas::count();

    // Get Total Pendapatan data for the new chart
    $data['totalPendapatanData'] = $this->getTotalPendapatanData();
    
    // Get Popular Products
    $data['popularProducts'] = $this->getPopularProducts();

    return view('admin.dashboard.index', $data);
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
        ->whereNotIn('status', ['pending', 'cancelled', 'rejected'])
        ->sum('total_amount');
    
    $rentalTransactions = RentalBooking::whereYear('created_at', $year)
        ->whereMonth('created_at', $month)
        ->whereNotIn('status', ['pending', 'cancelled', 'rejected'])
        ->count();
    
    // Gas Sales Revenue
    $gasRevenue = GasOrder::whereYear('created_at', $year)
        ->whereMonth('created_at', $month)
        ->whereNotIn('status', ['pending', 'cancelled', 'rejected'])
        ->sum(\DB::raw('price * quantity'));
    
    $gasTransactions = GasOrder::whereYear('created_at', $year)
        ->whereMonth('created_at', $month)
        ->whereNotIn('status', ['pending', 'cancelled', 'rejected'])
        ->count();

    // Manual Reports Revenue
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

    /**
     * Global Search - Search across all tables
     */
    public function globalSearch(Request $request)
    {
        $search = $request->get('search');
        
        if (!$search) {
            return redirect()->route('admin.dashboard');
        }
        
        // Search in Rental Products (Barang)
        $rentalProducts = Barang::where('nama_barang', 'LIKE', "%{$search}%")
            ->orWhere('kategori', 'LIKE', "%{$search}%")
            ->get()
            ->map(function($item) {
                return [
                    'type' => 'rental_product',
                    'title' => $item->nama_barang,
                    'subtitle' => 'Kategori: ' . $item->kategori,
                    'description' => $item->deskripsi,
                    'image' => $item->foto,
                    'link' => route('admin.unit.penyewaan.index'),
                    'badge' => 'Penyewaan Alat',
                    'badge_color' => 'primary'
                ];
            });
        
        // Search in Gas Products
        $gasProducts = Gas::where('jenis_gas', 'LIKE', "%{$search}%")
            ->orWhere('kategori', 'LIKE', "%{$search}%")
            ->get()
            ->map(function($item) {
                return [
                    'type' => 'gas_product',
                    'title' => $item->jenis_gas,
                    'subtitle' => 'Kategori: ' . $item->kategori,
                    'description' => $item->deskripsi,
                    'image' => $item->foto,
                    'link' => route('admin.unit.penjualan_gas.index'),
                    'badge' => 'Penjualan Gas',
                    'badge_color' => 'warning'
                ];
            });
        
        // Search in Users
        $users = User::where('name', 'LIKE', "%{$search}%")
            ->orWhere('email', 'LIKE', "%{$search}%")
            ->get()
            ->map(function($item) {
                return [
                    'type' => 'user',
                    'title' => $item->name,
                    'subtitle' => $item->email,
                    'description' => 'Bergabung: ' . $item->created_at->format('d M Y'),
                    'image' => $item->avatar,
                    'link' => route('admin.manajemen-pengguna.index'),
                    'badge' => 'Pengguna',
                    'badge_color' => 'success'
                ];
            });
        
        // Search in BUMDes Members
        $bumdesMembers = \App\Models\BumdesMember::where('name', 'LIKE', "%{$search}%")
            ->orWhere('position', 'LIKE', "%{$search}%")
            ->get()
            ->map(function($item) {
                return [
                    'type' => 'bumdes_member',
                    'title' => $item->name,
                    'subtitle' => $item->position,
                    'description' => 'Anggota Struktur BUMDes',
                    'image' => $item->photo,
                    'link' => route('admin.isewa.bumdes.index'),
                    'badge' => 'Profil BUMDes',
                    'badge_color' => 'info'
                ];
            });
        
        // Search in Transactions (Rental)
        $rentalTransactions = RentalBooking::with('user')
            ->where('status', 'LIKE', "%{$search}%")
            ->orWhereHas('user', function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%");
            })
            ->get()
            ->map(function($item) {
                return [
                    'type' => 'rental_transaction',
                    'title' => 'Transaksi Penyewaan #' . $item->id,
                    'subtitle' => 'User: ' . ($item->user->name ?? 'N/A'),
                    'description' => 'Status: ' . ucfirst($item->status) . ' | Tanggal: ' . $item->created_at->format('d M Y'),
                    'image' => null,
                    'link' => route('admin.aktivitas.permintaan-pengajuan.index'),
                    'badge' => 'Transaksi',
                    'badge_color' => 'secondary'
                ];
            });
        
        
        // Search in Transactions (Gas)
        $gasTransactions = GasOrder::with('user')
            ->where('status', 'LIKE', "%{$search}%")
            ->orWhereHas('user', function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%");
            })
            ->get()
            ->map(function($item) {
                return [
                    'type' => 'gas_transaction',
                    'title' => 'Transaksi Gas #' . $item->id,
                    'subtitle' => 'User: ' . ($item->user->name ?? 'N/A'),
                    'description' => 'Status: ' . ucfirst($item->status) . ' | Rp ' . number_format($item->price * $item->quantity, 0, ',', '.'),
                    'image' => null,
                    'link' => route('admin.aktivitas.permintaan-pengajuan.index'),
                    'badge' => 'Transaksi',
                    'badge_color' => 'secondary'
                ];
            });
        
        // Merge all results
        $results = collect()
            ->concat($rentalProducts)
            ->concat($gasProducts)
            ->concat($users)
            ->concat($bumdesMembers)
            ->concat($rentalTransactions)
            ->concat($gasTransactions);
        
        $totalResults = $results->count();
        
        return view('admin.dashboard.search-results', compact('results', 'search', 'totalResults'));
    }


    /**
     * Display Profile Page
     */
    public function profile()
    {
        $user = Auth::user();
        return view('admin.profile.MyProfile', compact('user'));
    }

    /**
     * Update Profile
     */
    public function profileUpdate(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'email' => 'required|email|unique:users,email,' . $user->id,
        ], [
            'name.required' => 'Name is required',
            'username.required' => 'Username is required',
            'username.unique' => 'Username already exists',
            'email.required' => 'Email is required',
            'email.email' => 'Email must be a valid email address',
            'email.unique' => 'Email already exists',
        ]);

        $user->update($validated);

        return back()->with('success', 'Profile updated successfully!');
    }

    /**
     * Display Settings Page
     */
    public function settings()
    {
        $user = Auth::user();
        return view('admin.settings.MySettings', compact('user'));
    }

    /**
     * Update Settings (Password Change)
     */
    public function settingsUpdate(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ], [
            'current_password.required' => 'Current password is required',
            'password.required' => 'New password is required',
            'password.min' => 'Password must be at least 8 characters',
            'password.confirmed' => 'Password confirmation does not match',
        ]);

        // Check if current password is correct
        if (!Hash::check($validated['current_password'], $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect']);
        }

        // Update password
        $user->update([
            'password' => Hash::make($validated['password'])
        ]);

        return back()->with('success', 'Password changed successfully!');
    }

    /**
     * Display Users List
     */
    public function usersList()
    {
        $users = User::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show Create User Form
     */
    public function usersCreate()
    {
        return view('admin.users.create');
    }

    /**
     * Store New User
     */
    public function usersStore(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string|max:255|unique:users',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
        ], [
            'username.required' => 'Username is required',
            'username.unique' => 'Username already exists',
            'name.required' => 'Name is required',
            'email.required' => 'Email is required',
            'email.email' => 'Email must be a valid email address',
            'email.unique' => 'Email already exists',
            'password.required' => 'Password is required',
            'password.min' => 'Password must be at least 8 characters',
            'password.confirmed' => 'Password confirmation does not match',
        ]);

        User::create([
            'username' => $validated['username'],
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('admin.manajemen-pengguna.index')->with('success', 'User created successfully!');
    }

    /**
     * Show Edit User Form
     */
    public function usersEdit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update User
     */
    public function usersUpdate(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'username' => 'required|string|max:255|unique:users,username,' . $id,
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
        ], [
            'username.required' => 'Username is required',
            'username.unique' => 'Username already exists',
            'name.required' => 'Name is required',
            'email.required' => 'Email is required',
            'email.email' => 'Email must be a valid email address',
            'email.unique' => 'Email already exists',
        ]);

        // Update password if provided
        if ($request->filled('password')) {
            $request->validate([
                'password' => 'required|min:8|confirmed',
            ], [
                'password.min' => 'Password must be at least 8 characters',
                'password.confirmed' => 'Password confirmation does not match',
            ]);

            $validated['password'] = Hash::make($request->password);
        }

        $user->update($validated);

        return redirect()->route('admin.manajemen-pengguna.index')->with('success', 'User updated successfully!');
    }

    /**
     * Delete User
     */
    public function usersDestroy($id)
    {
        $user = User::findOrFail($id);

        // Prevent deleting own account
        if ($user->id === Auth::id()) {
            return redirect()->route('admin.manajemen-pengguna.index')->with('error', 'You cannot delete your own account!');
        }
        $user->delete();

        return redirect()->route('admin.manajemen-pengguna.index')->with('success', 'User deleted successfully!');
    }
    /**
     * Display Connections Page
     */
    public function connections()
    {
        $user = Auth::user();
        return view('admin.settings.connections', compact('user'));
    }
    /**
     * Display Notifications Page
     */
    public function notifications()
    {
        $user = Auth::user();
        return view('admin.settings.notifications', compact('user'));
    }
    /**
     * Update Notifications Settings
     */
    public function notificationsUpdate(Request $request)
    {
        // Handle notification preferences update
        // You can save these preferences to database if needed

        return back()->with('success', 'Notification preferences updated successfully!');
    }
    /**
     * Display Maintenance Page
     */
    public function maintenance()
    {
        return view('maintenance');
    }

    /**
     * Get Popular Products (Top 4 most rented/sold items)
     */
    private function getPopularProducts()
    {
        // 1. Get Rental Scores
        $rentalPopularity = RentalBooking::select('barang_id', DB::raw('SUM(quantity) as total_sold'))
            ->whereNotIn('status', ['pending', 'cancelled', 'rejected'])
            ->whereNotNull('barang_id')
            ->groupBy('barang_id')
            ->with('barang')
            ->get();

        // 2. Map Rental to common format
        $products = $rentalPopularity->map(function ($item) {
            if (!$item->barang) return null;
            return (object) [
                'id' => $item->barang->id,
                'name' => $item->barang->nama_barang,
                'image' => $item->barang->foto,
                'price' => $item->barang->harga_sewa,
                'price_formatted' => 'Rp ' . number_format($item->barang->harga_sewa, 0, ',', '.'),
                'stock' => $item->barang->stok,
                'sold' => $item->total_sold,
                'type' => 'rental',
                'category' => 'Unit Penyewaan Alat',
                'unit' => $item->barang->satuan ?? 'unit',
                'link' => route('admin.unit.penyewaan.show', $item->barang->id)
            ];
        })->filter();

        // 3. Get Gas Scores
        $gasPopularity = GasOrder::select('gas_id', DB::raw('SUM(quantity) as total_sold'))
            ->whereNotIn('status', ['pending', 'cancelled', 'rejected'])
            ->whereNotNull('gas_id')
            ->groupBy('gas_id')
            ->with('gas')
            ->get();

        // 4. Map Gas to common format
        $gasProducts = $gasPopularity->map(function ($item) {
            if (!$item->gas) return null;
            return (object) [
                'id' => $item->gas->id,
                'name' => $item->gas->jenis_gas,
                'image' => $item->gas->foto,
                'price' => $item->gas->harga_satuan,
                'price_formatted' => 'Rp ' . number_format($item->gas->harga_satuan, 0, ',', '.'),
                'stock' => $item->gas->stok,
                'sold' => $item->total_sold,
                'type' => 'gas',
                'category' => 'Unit Penjualan Gas',
                'unit' => 'tabung',
                'link' => route('admin.unit.penjualan_gas.show', $item->gas->id)
            ];
        })->filter();

        // 5. Merge, Sort, Take 4
        return $products->concat($gasProducts)->sortByDesc('sold')->take(4);
    }
}

// Helper function for month names (same as in ReportController)
if (!function_exists('getMonthName')) {
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
}