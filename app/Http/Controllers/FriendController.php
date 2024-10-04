<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\FriendRequestNotification;
use Illuminate\Support\Facades\DB;

class FriendController extends Controller
{
    // Display friends, pending requests, and suggested friends
    public function index()
    {
        $user = Auth::user();

        // Suggested friends
        $suggestedFriends = User::where('id', '!=', $user->id)
            ->whereDoesntHave('friends', function ($query) use ($user) {
                $query->where('friend_id', $user->id);
            })
            ->whereDoesntHave('friendRequestsSent', function ($query) use ($user) {
                $query->where('friend_id', $user->id);
            })
            ->get();

        // Pending requests and confirmed friends
        $pendingRequests = $user->friendRequestsReceived()->wherePivot('status', 'pending')->get();
        $friends = $user->friends; // Fetch confirmed friends using the relationship method

        // Return the view with data
        return view('friends', compact('suggestedFriends', 'pendingRequests', 'friends'));
    }

    // Send a friend request
    public function addFriend(Request $request, $friendId)
    {
        $user = Auth::user();

        // Check if the friend request already exists
        if ($user->friends()->where('friend_id', $friendId)->exists() || 
            $user->friendRequestsSent()->where('friend_id', $friendId)->exists()) {
            return redirect()->back()->with('message', 'Friend request already sent or user is already your friend.');
        }

        // Create a new friendship and set status to 'pending'
        $user->friendRequestsSent()->attach($friendId, ['status' => 'pending']);

        // Send a notification to the recipient of the friend request
        $friend = User::findOrFail($friendId);
        $friend->notify(new FriendRequestNotification($user));

        return redirect()->back()->with('message', 'Friend request sent!');
    }

    // Cancel a pending friend request
    public function cancelFriendRequest($friendId)
    {
        $user = Auth::user();

        // Remove the pending request
        if ($user->friendRequestsSent()->detach($friendId)) {
            return redirect()->back()->with('message', 'Friend request cancelled.');
        }

        return redirect()->back()->with('error', 'No pending friend request found.');
    }

    // Accept a pending friend request
    public function acceptFriend($friendId)
    {
        $user = Auth::user();

        $updated = DB::table('friend_user')
            ->where('friend_id', $user->id)
            ->where('user_id', $friendId)
            ->update(['status' => 'confirmed']);

        if ($updated) {
            return redirect()->back()->with('message', 'Friend request accepted.');
        }

        return redirect()->back()->with('error', 'Failed to accept friend request.');
    }

    // Reject a pending friend request
    public function rejectFriend($friendId)
    {
        $user = Auth::user();

        // Delete the pending friend request
        $deleted = DB::table('friend_user')
            ->where('friend_id', $user->id)
            ->where('user_id', $friendId)
            ->delete();

        if ($deleted) {
            return redirect()->back()->with('message', 'Friend request rejected.');
        }

        return redirect()->back()->with('error', 'Failed to reject friend request.');
    }

    // Unfriend a user
    public function unfriend($friendId)
    {
        $user = Auth::user();

        // Remove the friendship
        $deleted = $user->friends()->detach($friendId);

        if ($deleted) {
            return redirect()->back()->with('message', 'You have unfriended the user.');
        }

        return redirect()->back()->with('error', 'Failed to unfriend the user.');
    }
}
