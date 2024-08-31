<?php

namespace App\Http\Controllers;

use App\Events\ChatUserEvent;
use App\Models\User;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function index()
    {
        $users = User::whereNotIn('id', [auth()->user()->id])->get(['id', 'profile', 'name']);
        // dd($users);
        return view('dashboard.chat.index',['pageTitle'=> trans('chat.chat')], compact('users'));
    }
    public function message(Request $request)
    {
        $message = $request->message;
        $user_id = $request->user_id;
        event(new ChatUserEvent($message, $user_id));
        return response()->json(['status', true]);
    }
}
