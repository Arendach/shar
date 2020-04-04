<?php

/**
 * @param int $id
 * @return \App\Models\User|\App\Models\User[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|mixed|null
 */
function user(int $id = 0)
{
    if ($id == 0) {
        return $_SESSION['user'];
    } else {
        return \App\Models\User::find($id);
    }
}

/**
 * @return bool|mixed
 */
function is_auth()
{
    if (isset($_SESSION['is_auth'])) {
        return $_SESSION['is_auth'];
    }

    return false;
}

/**
 * @param $date
 * @return bool
 */
function is_online($date): bool
{
    return time() - $date < 300;
}

/**
 * @param int|string $key
 * @return bool
 */
function can($key = -1): bool
{
    if ($key == -1)
        if (user()->access == -1)
            return true;
        else
            return false;
    elseif (is_string($key))
        return is_array(user()->access) ? (boolean)in_array($key, user()->access) : true;
    else
        return false;
}

/**
 * @param string|int $key
 * @return bool
 */
function cannot($key): bool
{
    return !can($key);
}