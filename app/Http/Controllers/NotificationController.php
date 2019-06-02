<?php

namespace App\Http\Controllers;

use App\Http\Resources\NotificationResource;
use Illuminate\Notifications\DatabaseNotification;

class NotificationController extends Controller
{
    /**
     * @return array
     */
    public function index()
    {
        return [
            'read' => NotificationResource::collection(auth()->user()->readNotifications),
            'unread' => NotificationResource::collection(auth()->user()->unreadNotifications),
        ];
    }

    public function markAsRead(DatabaseNotification $notification)
    {
        $notification->markAsRead();
    }
}
