<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\DB;

class AuthCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (isset($_COOKIE['session'])) {
            if ($this->check_cookie())
                return $next($request);
            else
                $this->display_login($request);
        } else {
            $this->display_login($request);
        }
    }

    /**
     * @param  \Illuminate\Http\Request $request
     */
    public function display_login($request)
    {
        if ($request->getMethod() == 'POST') {
            res(401, 'Для продолжения авторизируйтесь!');
        } else {
            echo view('pages.login');
        }
        exit;
    }

    /**
     * @return bool
     */
    public function check_cookie()
    {
        $result = DB::table('users_session')
            ->where('session', '=', $_COOKIE['session'])
            ->first();

        if ($result != null) {
            $this->load_user($result);
            $_SESSION['is_auth'] = true;
            return true;
        } else {
            $_SESSION['is_auth'] = false;
            return false;
        }
    }

    /**
     * @param $result
     */
    public function load_user($result)
    {
        $user = DB::table('users')
            ->where('id', $result->user_id)
            ->first();

        if ($user->access != -1){
            $access = DB::table('users_access')->where('id', $user->access)->first();

            $user->access = get_array(json_decode($access->array));
        }

        $_SESSION['user'] = $user;
    }
}
