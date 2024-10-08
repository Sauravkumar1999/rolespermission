<?php

namespace App\View\Components\chat;

use App\Models\User;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class leftsidebar extends Component
{
    public $users;
    public $user;
    /**
     * Create a new component instance.
     */
    public function __construct($user = null)
    {
        $this->user= $user;
        $this->users= User::whereNotIn('id', [auth()->user()->id])->get(['id', 'profile', 'name']);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.chat.leftsidebar');
    }
}
