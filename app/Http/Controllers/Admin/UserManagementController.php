<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserManagementController extends Controller
{
    public function index()
    {
        $users = User::orderBy('name', 'asc')->paginate(10);

        return view('admin.user_management.index', compact('users'));
    }

    public function show($id)
    {
        $user = User::with(['rentalTransactions', 'gasTransactions'])->findOrFail($id);

        return view('admin.user_management.show', compact('user'));
    }

    public function toggleStatus(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->status = $user->status === 'aktif' ? 'non_aktif' : 'aktif';
        $user->save();

        return redirect()->back()->with('success', 'Status akun pengguna berhasil diubah.');
    }
}