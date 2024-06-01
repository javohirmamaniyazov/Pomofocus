<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Resources\NotificationResource;
use App\Models\Notification;

class NotificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('verified');
    }
    public function index()
    {
        return Notification::all();
    }

    public function store(Request $request)
    {
        $notification = Notification::create($request->validate([
            'reminder_type' => 'required|in:last,every',
            'minute' => 'required|integer|min:1',
            'user_id' => 'required|exists:users,id',
        ]));

        return $notification;
    }

    public function show(Notification $notification)
    {
        return $notification;
    }

    public function update(Request $request, Notification $notification)
    {
        $notification->update($request->validate([
            'reminder_type' => 'required|in:last,every',
            'minute' => 'required|integer|min:1',
            'user_id' => 'required|exists:users,id',
        ]));

        return $notification;
    }

    public function destroy(Notification $notification)
    {
        $notification->delete();

        return response()->noContent();
    }
}
