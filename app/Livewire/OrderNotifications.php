<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\DatabaseNotification; // For type hinting and creating mock notifications
use Illuminate\Support\Str; // For generating UUIDs
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Log;

class OrderNotifications extends Component
{

    public $notifications;
    public $unreadCount = 0;
    public $showDropdown = false;

    public function mount()
    {
        $this->loadNotifications();
    }

    // This method fetches notifications from the database
    public function loadNotifications()
    {
        if (Auth::check()) {
            $this->notifications = Auth::user()->notifications()->latest()->take(10)->get(); // Get latest 10 notifications
            $this->unreadCount = Auth::user()->unreadNotifications->count();
        } else {
            $this->notifications = collect(); // Empty collection if not logged in
            $this->unreadCount = 0;
        }
    }

    public function toggleDropdown()
    {
        $this->showDropdown = !$this->showDropdown;
        // Optionally, mark all notifications as read when the dropdown is opened
        // if ($this->showDropdown && $this->unreadCount > 0) {
        //     $this->markAllAsRead();
        // }
    }

    public function markAsRead(string $notificationId)
    {
        if (Auth::check()) {
            Auth::user()->notifications()->where('id', $notificationId)->first()->markAsRead();
            $this->loadNotifications(); // Reload to update counts and list
        }
    }

    public function markAllAsRead()
    {
        if (Auth::check()) {
            Auth::user()->unreadNotifications->markAsRead();
            $this->loadNotifications(); // Reload to update counts and list
        }
    }

    #[On('order-status-updated')]
    public function notifyNewStatus()
    {
        $this->loadNotifications();
    }

    public function render()
    {
        return view('livewire.order-notifications');
    }
}
