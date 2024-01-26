<?php

use App\Models\User;

if (!function_exists('user')) {
    function user(string $guard = null): User|null
    {
        /** @var User|null $res */
        $res = Auth::guard($guard ?: config('auth.defaults.guard'))->user();
        return $res;
    }
}