<?php

namespace App\Http\Controllers;

use App\Events\ChatUserEvent;
use App\Models\User;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function index()
    {
        return view('dashboard.chat.index');
    }
    public function chatInbox(User $user)
    {
        return view('dashboard.chat.index', compact('user'));
    }
    public function message(Request $request)
    {
        $message = $request->message;
        $user_id = $request->user_id;
        event(new ChatUserEvent($message, $user_id));
        return response()->json(['status', true]);
    }
}
