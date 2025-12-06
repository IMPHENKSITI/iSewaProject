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

class DashboardController extends Controller
{
   /**
 * Display Dashboard
 */
public function index()
{
    // Fetch pending rental bookings
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

    // Hitung statistik untuk Donut Chart (Total Transaksi per Kategori)
    $rentalCount = RentalBooking::where('status', '!=', 'cancelled')->count();
    $gasCount = GasOrder::count();

    $totalPending = $rentalRequests->count() + $gasRequests->count();

    // ========================================
    // REAL DATA CALCULATIONS FOR CHARTS
    // ========================================
    
    // Calculate monthly performance (total transactions per month)
    $monthlyPerformance = [];
    $currentYear = date('Y');
    
    for ($month = 1; $month <= 12; $month++) {
        $rentalMonthCount = RentalBooking::whereMonth('created_at', $month)
            ->whereYear('created_at', $currentYear)
            ->where('status', '!=', 'cancelled')
            ->count();
        
        $gasMonthCount = GasOrder::whereMonth('created_at', $month)
            ->whereYear('created_at', $currentYear)
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
    
    // Pendapatan dari sistem (RentalRequest)
    foreach (RentalRequest::selectRaw('SUM(price) as total, MONTH(created_at) as month')
        ->groupBy('month')
        ->pluck('total', 'month') as $month => $amount) {
        $monthlyIncome[getMonthName($month)] += $amount;
    }

    // Pendapatan dari gas orders
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

    return view('admin.dashboard.index', $data);
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