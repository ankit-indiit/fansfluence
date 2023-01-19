<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\NotificationService;
use App\Models\User;
use Auth;

class NotificationController extends Controller
{
    public function index()
    {
    	Auth::user()->unreadNotifications()->update(['read_at' => now()]);
    	$notifications = Auth::user()->notifications()->paginate(10);
        return view('module.notification', compact('notifications'));
    }

    public function preference(Request $request, NotificationService $notificationService)
    {
        $data = $notificationService->show();
        return view('module.user.account-notification', compact('data'));
    }

    public function manageNotification(Request $request, NotificationService $notificationService)
    {       
        $notificationService->create($request); 
        return response()->json([
            'status' => true,
            'message' => 'Notification setting has been updated!',
        ]);
    }
}
