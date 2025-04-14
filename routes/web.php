<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FriendController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\MessageController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'loginPost'])->name('login.post'); // Use loginPost

Route::get('/registration', [AuthController::class, 'registration'])->name('registration');
Route::post('/registration', [AuthController::class, 'registrationPost'])->name('registration.post'); // Use registrationPost

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
Route::post('/posts', [PostController::class, 'store'])->name('posts.store');

Route::put('/posts/{post}', [PostController::class, 'update'])->name('posts.update');
Route::get('/', [PostController::class, 'index'])->name('home');

Route::delete('/posts/{post}',[PostController::class, 'destroy'])->name('posts.destroy');
Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
Route::get('/profile', [UserController::class, 'profile'])->name('profile');
Route::post('/profile/photo', [UserController::class, 'updateProfilePhoto'])->name('user.updateProfilePhoto');
Route::get('/profile/{id}', [UserController::class, 'showProfile'])->name('user.profile');
Route::get('/profileshow/{id}', [UserController::class, 'showProfile'])->name('user.profileshow');
Route::post('/friend-request/{user}', [FriendController::class, 'sendRequest'])->name('friend.request');
Route::get('/friend-list', [FriendController::class, 'friendList'])->name('friend.list');


Route::post('/friends/accept/{request}', [FriendController::class, 'acceptRequest'])->name('friends.accept');
Route::post('/friends/decline/{request}', [FriendController::class, 'declineRequest'])->name('friends.decline');
Route::post('/friends/cancel/{request}', [FriendController::class, 'cancelRequest'])->name('friends.cancel');

//
Route::post('/toggle-follow/{user}', [FriendController::class, 'toggleFollow'])->name('toggle.follow');
Route::get('/friends/list', [FriendController::class, 'listFollowRelationships'])->name('friends.list');
Route::post('/unfollow/{user}', [FriendController::class, 'unfollow'])->name('friends.unfollow');
Route::post('/remove-follower/{user}', [FriendController::class, 'removeFollower'])->name('friends.removeFollower');


//


// Chat Routes
Route::get('/chat/{user}', [ChatController::class, 'showChat'])->name('chat.show');
Route::post('/chat/{user}/send', [ChatController::class, 'sendMessage'])->name('chat.send');

// Message Routes
Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
Route::post('/messages/{user}', [MessageController::class, 'send'])->name('messages.send');