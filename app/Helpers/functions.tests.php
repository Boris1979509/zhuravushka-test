<?php

use App\Models\User;

/**
 * Make user factory
 * @param array $data
 * @return User
 */
if (!function_exists('make_user')) {
    function make_user($data = [])
    {
        return factory(User::class)->make($data);
    }
}
/**
 * Create user factory
 * @param array $data
 * @return User
 */
if (!function_exists('create_user')) {
    function create_user($data = [])
    {
        return factory(User::class)->create($data);
    }
}
