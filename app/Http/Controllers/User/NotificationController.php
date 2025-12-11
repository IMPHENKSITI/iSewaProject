<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        // Ambil semua notifikasi untuk pengguna yang diautentikasi, diurutkan dari yang terbaru
        $notifications = Notification::where('user_id', auth()->id())
            ->orWhereNull('user_id') // Sertakan notifikasi siaran
            ->with(['admin', 'user'])
            ->orderByDesc('created_at')
            ->get();

        // Hitung notifikasi yang belum dibaca
        $unreadCount = $notifications->where('is_read', false)->count();

        return view('users.notifications', compact('notifications', 'unreadCount'));
    }

    public function markAsRead($id)
    {
        $notification = Notification::where('id', $id)
            ->where(function($query) {
                $query->where('user_id', auth()->id())
                      ->orWhereNull('user_id');
            })
            ->firstOrFail();

        $notification->update([
            'is_read' => true,
            'read_at' => now()
        ]);

        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Notifikasi ditandai sebagai sudah dibaca'
            ]);
        }

        return redirect()->back()->with('success', 'Notifikasi ditandai sebagai sudah dibaca');
    }

    public function markAllAsRead()
    {
        Notification::where('user_id', auth()->id())
            ->orWhereNull('user_id')
            ->where('is_read', false)
            ->update([
                'is_read' => true,
                'read_at' => now()
            ]);

        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Semua notifikasi ditandai sebagai sudah dibaca'
            ]);
        }

        return redirect()->back()->with('success', 'Semua notifikasi ditandai sebagai sudah dibaca');
    }
}
