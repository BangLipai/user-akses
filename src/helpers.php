<?php

use App\Models\User;

if (!function_exists('user')) {
    function user(string $guard = null): ?User
    {
        /** @var ?User $res */
        $res = Auth::guard($guard ?: config('auth.defaults.guard'))->user();
        return $res;
    }
}
