<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        // Ambil semua notifikasi untuk admin, diurutkan dari yang terbaru
        // Kita asumsikan semua notifikasi untuk admin ditampilkan di sini
        $notifications = Notification::with(['user', 'admin'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.notifications.index', compact('notifications'));
    }

    public function create()
    {
        // Ambil semua user untuk dituju notifikasi (jika mengirim ke user)
        $users = User::all();
        return view('admin.notifications.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'user_id' => 'nullable|exists:users,id', // Bisa kosong jika broadcast
        ]);

        $notification = Notification::create([
            'title' => $request->title,
            'message' => $request->message,
            'type' => 'pesan_admin', // Tipe untuk notifikasi dari admin
            'admin_id' => auth()->id(), // ID admin yang sedang login
            'user_id' => $request->user_id, // Jika ditujukan ke user tertentu
            'sent_at' => now(),
        ]);

        return redirect()->route('admin.notifications.index')->with('success', 'Notifikasi berhasil dikirim.');
    }

    public function markAsRead($id)
    {
        $notification = Notification::findOrFail($id);
        $notification->is_read = true;
        $notification->read_at = now();
        $notification->save();

        // Jika notifikasi terkait user, bisa redirect ke halaman user tertentu
        // Untuk sekarang, kembali ke index
        return redirect()->back()->with('success', 'Notifikasi ditandai sebagai sudah dibaca.');
    }

    public function markAllAsRead()
    {
        // Tandai semua notifikasi milik admin sebagai dibaca
        Notification::where('is_read', false)->update([
            'is_read' => true,
            'read_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Semua notifikasi ditandai sebagai sudah dibaca.');
    }
}