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
    public $chats;
    /**
     * Create a new component instance.
     */
    public function __construct($user = null)
    {
        $this->user = $user;
        $this->users = User::whereNotIn('id', [auth()->user()->id])->orderBy('name')->get(['id', 'profile', 'name']);
        $authUserId = auth()->id();

        $this->chats = \App\Models\DirectMessage::where(function ($query) use ($authUserId) {
            $query->where('user_one_id', $authUserId)
                ->orWhere('user_two_id', $authUserId);
        })
            ->with(['userOne', 'userTwo', 'chats' => function ($q) {
                $q->latest();
            }])
            ->get()
            ->sortByDesc(function ($directMessage) {
                return $directMessage->chats->first()->created_at ?? now();
            });
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.chat.leftsidebar');
    }
}
