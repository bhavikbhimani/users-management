<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Pusher\Pusher;
use App\Models\User;

class ChatController extends Controller
{
    public function index(User $user)
    {
        try {
            return view('users.chat', compact('user'));
        } catch (QueryException $e) {
            return back()->with('error', 'Failed to fetch request data. Please try again.');
        }
    }

    public function sendMessage(Request $request)
    {
        $options = array(
            'cluster' => env('PUSHER_APP_CLUSTER'),
            'useTLS' => true
        );
        $pusher = new Pusher(
            env('PUSHER_APP_KEY'),
            env('PUSHER_APP_SECRET'),
            env('PUSHER_APP_ID'),
            $options
        );

        $data = [
            'message' => $request->message,
            'user' => auth()->user()->name // Assuming you have user authentication
        ];
        
        $pusher->trigger('chat-channel', 'chat-event', $data);

        return response()->json(['status' => 'Message sent']);
    }
}