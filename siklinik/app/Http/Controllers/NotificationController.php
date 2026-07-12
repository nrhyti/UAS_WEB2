<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $notifications = $request->user()->notifications()->paginate(10);

        // Tandai semua sudah dibaca begitu halaman ini dibuka.
        $request->user()->unreadNotifications->markAsRead();

        return view('notifications.index', compact('notifications'));
    }
}
