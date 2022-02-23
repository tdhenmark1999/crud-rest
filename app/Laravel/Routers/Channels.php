<?php

// use App\Laravel\Models\Wishlist;

Broadcast::channel('user.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

// Broadcast::channel('notification.{id}', function ($user, $id) {
//     return random(1,20);
// });