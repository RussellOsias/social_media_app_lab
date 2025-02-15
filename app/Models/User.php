<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * The confirmed friends of the user.
     */
    public function friends()
    {
        return $this->belongsToMany(User::class, 'friend_user', 'user_id', 'friend_id')
                    ->wherePivot('status', 'confirmed')
                    ->withTimestamps();
    }

    /**
     * The pending friend requests received by the user.
     */
    public function friendRequestsReceived()
    {
        return $this->belongsToMany(User::class, 'friend_user', 'friend_id', 'user_id')
                    ->wherePivot('status', 'pending')
                    ->withTimestamps();
    }

    /**
     * The pending friend requests sent by the user.
     */
    public function friendRequestsSent()
    {
        return $this->belongsToMany(User::class, 'friend_user', 'user_id', 'friend_id')
                    ->wherePivot('status', 'pending')
                    ->withTimestamps();
    }

    /**
     * The comments made by the user.
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Get the full name of the user.
     *
     * @return string
     */
    public function getFullName(): string
    {
        return $this->name; // Adjust this if you have a different structure for the full name
    }

    /**
     * Check if the user is friends with another user.
     *
     * @param User $user
     * @return bool
     */
    public function isFriendsWith(User $user): bool
    {
        return $this->friends()->where('friend_id', $user->id)->exists();
    }

    /**
     * Check if the user has a pending request sent to another user.
     *
     * @param User $user
     * @return bool
     */
    public function hasSentRequestTo(User $user): bool
    {
        return $this->friendRequestsSent()->where('friend_id', $user->id)->exists();
    }

    /**
     * Check if the user has a pending request received from another user.
     *
     * @param User $user
     * @return bool
     */
    public function hasReceivedRequestFrom(User $user): bool
    {
        return $this->friendRequestsReceived()->where('user_id', $user->id)->exists();
    }

    /**
     * Get all related users (friends and pending requests).
     *
     * @return array
     */
    public function getAllRelatedUsers(): array
    {
        return [
            'friends' => $this->friends,
            'pendingSent' => $this->friendRequestsSent,
            'pendingReceived' => $this->friendRequestsReceived,
        ];
    }
}
