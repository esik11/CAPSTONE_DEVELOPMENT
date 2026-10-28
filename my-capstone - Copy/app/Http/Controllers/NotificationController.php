<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function latest()
    {
        $user = Auth::user();
        
        $unreadNotifications = $user->unreadNotifications;
        $count = $unreadNotifications->count();
        
        // Format notifications for the frontend
        $notifications = $unreadNotifications->take(5)->map(function ($notification) {
            return [
                'id' => $notification->id,
                'data' => $notification->data,
                'created_at_human' => $notification->created_at->diffForHumans(),
            ];
        });

        return response()->json([
            'count' => $count,
            'notifications' => $notifications
        ]);
    }

    public function markAsRead(Request $request)
    {
        Auth::user()->unreadNotifications->markAsRead();
        return response()->json(['success' => true]);
    }

    public function clearAll(Request $request)
    {
        Auth::user()->notifications()->delete();
        return response()->json(['success' => true]);
    }
}
