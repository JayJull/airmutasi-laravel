<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = auth()->user()->profile->cabang->notifications;
        Notification::where('to', auth()->user()->profile->cabang->id)->update(['is_read' => true]);
        return view('notification.index', compact('notifications'));
    }
}
