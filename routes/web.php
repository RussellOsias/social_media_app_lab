<?php

use App\Http\Controllers\NotificationController;
use App\Http\Controllers\FriendController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\MessagesController;
use App\Http\Controllers\HelpController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', function () {
    return view('welcome');
});

// Profile route
Route::get('/profile/{id}', [ProfileController::class, 'show'])->name('profile.show');

// Dashboard route with authentication
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Authenticated routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile/update-email', [ProfileController::class, 'updateEmail'])->name('profile.updateEmail');
    Route::patch('/profile/update-name', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Post routes
    Route::post('/posts', [PostController::class, 'store']);
    Route::get('/posts', [PostController::class, 'index']);
    Route::delete('/posts/{id}', [PostController::class, 'destroy']);
    Route::post('/posts/{post}/like', [PostController::class, 'likePost']);
    Route::post('/posts/{post}/comment', [PostController::class, 'addComment']);
    Route::patch('/posts/{id}', [PostController::class, 'edit']);
    

    // Edit comment route
    Route::patch('/posts/{postId}/comments/{commentId}', [PostController::class, 'editComment']);

    // Delete comment route
    Route::delete('/posts/{postId}/comments/{commentId}', [PostController::class, 'deleteComment']);
    Route::delete('/posts/{post}/comments/{comment}', [PostController::class, 'destroyComment']);

    // Notification routes
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications');
    Route::post('/notifications/mark-as-read/{notificationId}', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
    Route::post('/notifications/mark-all-as-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.markAllAsRead');
    Route::delete('/notifications/delete/{notificationId}', [NotificationController::class, 'destroy'])->name('notifications.delete');
    Route::delete('/notifications/delete-all-read', [NotificationController::class, 'deleteAllRead'])->name('notifications.deleteAllRead');

    // Friends routes
    Route::get('/friends', [FriendController::class, 'index'])->name('friends');
    Route::post('/friends/add/{friendId}', [FriendController::class, 'addFriend'])->name('friends.add');
    Route::post('/friends/cancel/{friendId}', [FriendController::class, 'cancelFriendRequest'])->name('friends.cancel');
    Route::delete('/friends/unfriend/{friendId}', [FriendController::class, 'unfriend'])->name('friends.unfriend');
    Route::post('/friends/accept/{id}', [FriendController::class, 'acceptFriend'])->name('friends.accept');
    Route::delete('/friends/reject/{id}', [FriendController::class, 'rejectFriend'])->name('friends.reject');

    
});

require __DIR__.'/auth.php';
