<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
// Tambahkan model-model berikut
use App\Models\Barang; // Ganti dengan model yang sesuai jika berbeda
use App\Models\Gas; // Ganti dengan model yang sesuai jika berbeda
use App\Models\HasilPanen; // Ganti dengan model yang sesuai jika berbeda
use App\Models\Pinjaman; // Ganti dengan model yang sesuai jika berbeda

class DashboardController extends Controller
{
   /**
 * Display Dashboard
 */
public function index()
{
    // Contoh data statistik
    $data = [
        'totalUsers' => User::count(),
        'totalOrders' => 0, // Ganti dengan model Order nanti Order::count()
        'newUsers' => User::whereDate('created_at', '>=', now()->subMonth())->count(),
        'completedOrders' => 0, // Ganti dengan model Order nanti Order::where('status', 'completed')->count()
    ];

    // Ambil jumlah item untuk setiap unit layanan
    // Gunakan TRIM untuk menghilangkan spasi ekstra di awal/akhir
    $data['unitPenyewaan'] = Barang::count(); // Hitung SEMUA barang
    $data['unitGas'] = Barang::whereRaw('TRIM(kategori) = ?', ['Penjualan Gas'])->count();
    $data['unitPertanian'] = Barang::whereRaw('TRIM(kategori) = ?', ['Pertanian & Perkebunan'])->count();
    $data['unitSimpanPinjam'] = Barang::whereRaw('TRIM(kategori) = ?', ['Simpan Pinjam'])->count();

    // Kembalikan view dengan data tambahan
    return view('admin.dashboard.index', $data);
}

    // ... kode fungsi lainnya (profile, settings, dll) TIDAK BERUBAH ...
    // (Sisanya dari kode Anda tetap sama)
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

        return redirect()->route('admin.users.index')->with('success', 'User created successfully!');
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

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully!');
    }

    /**
     * Delete User
     */
    public function usersDestroy($id)
    {
        $user = User::findOrFail($id);

        // Prevent deleting own account
        if ($user->id === Auth::id()) {
            return redirect()->route('admin.users.index')->with('error', 'You cannot delete your own account!');
        }
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully!');
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