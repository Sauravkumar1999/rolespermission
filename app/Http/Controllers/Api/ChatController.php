<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\DirectMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ChatController extends Controller
{
    public function chatStore(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'direct_message_id' => 'required|exists:direct_messages,id', // Corrected table name
            'sender_id'         => 'required|exists:users,id',
            'message'           => 'required|string',
            'message_id'        => 'required|string',
        ]);
        if ($validated->fails()) response()->json(['success' => false, 'error' => $validated->errors()], 400);
        try {
            $directMessage = DirectMessage::findOrFail($validated->validated()['direct_message_id']);
            $directMessage->chats()->create($validated->validated());

            return response()->json(['success' => true], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }


    public function index($dmId, $sender_id)
    {
        try {
            $data = Chat::where('direct_message_id', $dmId)->limit(20)->get();
            Chat::where('direct_message_id', $dmId)
                // ->where('sender_id', '!=', $sender_id)
                ->where('status', '!=', 'seen')->get()->map(function ($a) use ($sender_id) {
                    if ($a->sender_id != $sender_id) {
                        $a->status = 'seen';
                        $a->save();
                    }
                });

            $updatedData = Chat::whereIn('id', $data->pluck('id'))->paginate(20);

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
