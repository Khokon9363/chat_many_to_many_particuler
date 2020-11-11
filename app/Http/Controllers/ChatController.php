<?php

namespace App\Http\Controllers;

use App\Chat;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    
    public function getChat($id)
    {
        return response()->json([
                                Chat::where('sender_id',Auth::user()->id)
                                    ->where('receiver_id',$id)
                                    ->orWhere('sender_id',$id)
                                    ->get(),
                                    count(Chat::where('sender_id',Auth::user()->id)
                                    ->where('receiver_id',$id)
                                    ->orWhere('sender_id',$id)
                                    ->get()),
                                    User::find($id)
                                ],200);
    }

    public function sendChat(Request $request)
    {
        $chat = new Chat();
        $chat->sender_id = Auth::user()->id;
        $chat->receiver_id = $request->receiver_id;
        $chat->chat = $request->chat;
        $chat->save();
        return response()->json($chat,200);
    }
}
