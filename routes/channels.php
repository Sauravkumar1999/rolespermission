<?php

use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});
//presense channel
Broadcast::channel('chat-user-event', function ($user) {
    return $user;
});
// private channel
// Broadcast::channel('user-chat-event', function ($user) {
//     return !is_null($user);
// });
