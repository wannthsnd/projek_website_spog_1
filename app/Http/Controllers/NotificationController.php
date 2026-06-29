<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Tampilkan daftar notifikasi user
     */
    public function index()
    {
        $notifications = Auth::user()->notifications()->latest()->paginate(10);
        return view('notifications.index', compact('notifications'));
    }

    /**
     * Tandai notifikasi sebagai sudah dibaca
     */
    public function markAsRead($id)
    {
        $notification = Auth::user()->notifications()->findOrFail($id);
        $notification->markAsRead();

        // Redirect ke action URL jika ada
        if (!empty($notification->data['action_url'])) {
            return redirect($notification->data['action_url']);
        }

        return back()->with('success', 'Notifikasi telah ditandai sebagai dibaca.');
    }

    /**
     * Tandai semua notifikasi sebagai sudah dibaca
     */
    public function markAllAsRead()
    {
        Auth::user()->unreadNotifications->markAsRead();
        return back()->with('success', 'Semua notifikasi telah ditandai sebagai dibaca.');
    }

    /**
     * Hapus notifikasi
     */
    public function destroy($id)
    {
        $notification = Auth::user()->notifications()->findOrFail($id);
        $notification->delete();

        return back()->with('success', 'Notifikasi telah dihapus.');
    }

    /**
     * Hapus semua notifikasi
     */
    public function destroyAll()
    {
        Auth::user()->notifications()->delete();
        return back()->with('success', 'Semua notifikasi telah dihapus.');
    }
}
