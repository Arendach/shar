<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

/**
 * App\Models\User
 *
 * @property int $id
 * @property string $login
 * @property string $password
 * @property int $access
 * @property string $name
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereAccess($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereLogin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User wherePassword($value)
 * @mixin \Eloquent
 */
class User extends Model
{

    public $timestamps = false;

    public static function check_login($request)
    {
        $result = DB::table('users')
            ->where('login', '=', $request->login)
            ->where('password', '=', my_crypt($request->password))
            ->first();

        if ($result == null)
            return false;

        $session = my_crypt($request->login . $request->password);

        setcookie('session', $session, time() + 3600);

        DB::table('users_session')
            ->where('session', $session)
            ->delete();

        DB::table('users_session')->insert([
            'session' => $session,
            'user_id' => $result->id,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        return true;
    }

    public static function sessionDestroy($session)
    {
        DB::table('users_session')->where('session', $session)->delete();
    }

    public static function get_access_all()
    {
        $result = DB::table('users_access')->get();

        $temp = [];
        foreach ($result as $item) {
            $temp[$item->id] = $item;
        }

        return $temp;
    }

    public static function register($post)
    {
        DB::table('users')->insert([
            'login' => $post->login,
            'password' => my_crypt($post->password),
            'access' => $post->access,
            'name' => $post->name
        ]);
    }
}
