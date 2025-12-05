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
use App\Models\GasOrder;

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
            // item_name is already in GasOrder or we use generic name
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
    $gasCount = GasOrder::count(); // Gas orders don't have 'cancelled' status usually, but check if needed

    $totalPending = $rentalRequests->count() + $gasRequests->count();

    $data = [
        'totalUsers' => User::count(),
        'totalOrders' => $totalOrders,
        'newUsers' => User::whereDate('created_at', '>=', now()->subMonth())->count(),
        'completedOrders' => $completedOrders,
        'latestRequests' => $latestRequests,
        'totalPending' => $totalPending,
        'rentalCount' => $rentalCount,
        'gasCount' => $gasCount
    ];

    // Ambil jumlah item untuk setiap unit layanan
    $data['unitPenyewaan'] = Barang::count(); 
    $data['unitGas'] = Gas::count();

    // Kembalikan view dengan data tambahan
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