<?php

namespace App\View\Components\chat;

use App\Models\DirectMessage;
use App\Models\User;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class LeftSidebar extends Component
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

        if ($user) {
            $this->ensureChatExists($authUserId, $user->id);
        }

        $this->chats = DirectMessage::where(function ($query) use ($authUserId) {
            $query->where('user_one_id', $authUserId)
                ->orWhere('user_two_id', $authUserId);
        })
            ->with([
                'userOne' => fn($query) => $query->select('id', 'name', 'profile'),
                'userTwo' => fn($query) => $query->select('id', 'name', 'profile'),
            ])
            ->get()
            ->map(function ($chat) use ($authUserId, $user) {
                $otherUser = $chat->user_one_id === $authUserId ? $chat->userTwo : $chat->userOne;
                $otherUser->last_message = $chat->chats->first()->created_at ?? null;
                $otherUser->inbox_user = $user && $user->id === $otherUser->id;
                $otherUser->dm = $chat->id;

                return $otherUser;
            })
            ->unique('id')
            ->sortByDesc('last_message');
    }

    /**
     * Ensure a chat exists between authenticated user and selected user.
     */
    protected function ensureChatExists($authUserId, $otherUserId)
    {
        $chatExists = DirectMessage::where(function ($query) use ($authUserId, $otherUserId) {
            $query->where('user_one_id', $authUserId)
                ->where('user_two_id', $otherUserId);
        })->orWhere(function ($query) use ($authUserId, $otherUserId) {
            $query->where('user_one_id', $otherUserId)
                ->where('user_two_id', $authUserId);
        })->exists();

        if (!$chatExists) {
            DirectMessage::insert([
                'user_one_id' => $authUserId,
                'user_two_id' => $otherUserId,
            ]);
        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.chat.leftsidebar');
    }
}
