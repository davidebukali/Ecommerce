<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\User;

class UserProfileDropdown extends Component
{
    /**
     * The authenticated user instance.
     *
     * @var \App\Models\User
     */
    public User $user;

    /**
     * Create a new component instance.
     *
     * @param  \App\Models\User  $user The authenticated user.
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.user-profile-dropdown');
    }
}
