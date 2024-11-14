<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        if (auth()->user()->profile && auth()->user()->profile->cabang) {
            $notifications =  auth()->user()->profile->cabang->notifications;
            Notification::where('to', auth()->user()->profile->cabang->id)->update(['is_read' => true]);
        } else if(auth()->user()->role->name == 'admin'){
            $notifications = Notification::where('to', null)->order->get();
            Notification::where('to', null)->update(['is_read' => true]);
        } else {
            $notifications = [];
        }
        return view('notification.index', compact('notifications'));
    }
}
