<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Pusher\Pusher;
use App\Models\User;

class ChatController extends Controller
{
    public function index($id)
    {
        try {
            return redirect()->route('chatify.chat', ['userId' => $id]);
        } catch (QueryException $e) {
            return back()->with('error', 'Failed to fetch request data. Please try again.');
        }
    }
}