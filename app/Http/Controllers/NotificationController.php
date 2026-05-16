<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NotificationController extends Controller
{
    public function index(Request $request): View
    {
        $notifications = $request->user()
            ->notifications()
            ->latest()
            ->paginate(20);

        return view('notifications.index', compact('notifications'));
    }

    public function markRead(Request $request, string $id): RedirectResponse
    {
        $notification = $request->user()->notifications()->whereKey($id)->firstOrFail();
        $notification->markAsRead();

        return back()->with('status', 'Alert resolved.');
    }

    public function markAllRead(Request $request): RedirectResponse
    {
        $request->user()->unreadNotifications->markAsRead();

        return back()->with('status', 'All alerts resolved.');
    }

    public function snooze(Request $request, string $id): RedirectResponse
    {
        $validated = $request->validate([
            'minutes' => ['required', 'integer', 'in:30,120,1440'],
        ]);

        $notification = $request->user()->notifications()->whereKey($id)->firstOrFail();
        $data = $notification->data;
        $data['snoozed_until'] = now()->addMinutes($validated['minutes'])->toDateTimeString();
        $notification->update(['data' => $data]);

        return back()->with('status', 'Alert snoozed.');
    }
}
