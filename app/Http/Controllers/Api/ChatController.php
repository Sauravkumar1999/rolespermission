<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ChatController extends Controller
{
    public function chatStore(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'sender_id'    => 'required|exists:users,id',
            'recipient_id' => 'required|exists:users,id',
            'message'      => 'required|string',
            'message_id'   => 'required|string',
        ]);
        if ($validated->fails()) {
            return response()->json(['success' => false, 'error' => $validated->errors()], 400);
        }
        try {
            Chat::create($validated->validated());
            return response()->json(['success' => true], 200);
        } catch (\Throwable $th) {
            return response()->json(['success' => false, 'error' => $th->getMessage()], 400);
        }
    }

    public function index($sender_id, $recipientId)
    {
        try {
            $data = Chat::where(function ($query) use ($sender_id, $recipientId) {
                $query->where('sender_id', $sender_id)
                    ->where('recipient_id', $recipientId);
            })->orWhere(function ($query) use ($sender_id, $recipientId) {
                $query->where('sender_id', $recipientId)
                    ->where('recipient_id', $sender_id);
            })->latest()->limit(20)->get();

            Chat::whereIn('id', $data->where('sender_id', $sender_id)->pluck('id'))
                ->where('status', '!=', 'seen')
                ->update(['status' => 'seen']);

            $updatedData = Chat::whereIn('id', $data->pluck('id'))->latest()->paginate(20);

            return response()->json(['success' => true, 'data' => $updatedData], 200);
        } catch (\Throwable $th) {
            return response()->json(['success' => false, 'error' => $th->getMessage()], 400);
        }
    }

    public function markAsSeen($message_id)
    {
        try {
            $updatedData = Chat::where('message_id', $message_id)->update(['status' => 'seen']);

            if ($updatedData) {
                return response()->json(['success' => true, 'message' => 'Status updated to seen.'], 200);
            } else {
                return response()->json(['success' => false, 'message' => 'Message not found or already seen.'], 404);
            }
        } catch (\Throwable $th) {
            return response()->json(['success' => false, 'error' => $th->getMessage()], 400);
        }
    }
}
