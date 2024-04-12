<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\FriendRequest;

class UserController extends Controller
{
    public function index()
    {
        try {
            $users = User::where('id', '!=', auth()->id())->latest()->paginate(10);
            return view('users.index', compact('users'));
        } catch (QueryException $e) {
            return back()->with('error', 'Failed to fetch user data. Please try again.');
        }
    }

    public function sendFriendRequest(User $user)
    {
        try {
            FriendRequest::updateOrCreate([
                'sender_id' => auth()->id(),
                'recipient_id' => $user->id
            ],['status' => FriendRequest::STATUS_PENDING]);
            return back()->with('success', 'Friend request sent successfully!');
        } catch (QueryException $e) {
            return back()->with('error', 'Failed to send friend request. Please try again.');
        }
    }

    public function getReceivedRequestList()
    {
        try {
            $requests = FriendRequest::with('user')->where('recipient_id',auth()->id())->where('status',FriendRequest::STATUS_PENDING)->latest()->paginate(10);
            return view('users.received-request', compact('requests'));
        } catch (QueryException $e) {
            return back()->with('error', 'Failed to fetch request data. Please try again.');
        }
    }

    public function accept(FriendRequest $request)
    {
       try {
            $request->update(['status' => FriendRequest::STATUS_ACCEPTED]);
            return redirect()->back()->with('success', 'Friend request accepted!');
        } catch (QueryException $e) {
            return redirect()->back()->with('error', 'Failed to accept friend request: ' . $e->getMessage());
        } 
    }

    public function reject(FriendRequest $request)
    {
        try {
            $request->update(['status' => FriendRequest::STATUS_REJECTED]);
            return redirect()->back()->with('success', 'Friend request rejected!');
        } catch (QueryException $e) {
            return redirect()->back()->with('error', 'Failed to reject friend request: ' . $e->getMessage());
        } 
    }
}
