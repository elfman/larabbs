<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Overtrue\LaravelSocialite\Socialite;
use Illuminate\Routing\Controller;

class AuthController extends Controller
{
    public function redirectToProvider()
    {
        return Socialite::driver('github')->redirect();
    }

    public function handleProviderCallback(Request $request)
    {
        $user = Socialite::driver('github')->user();
        $email = $user->email;
        $id = $user->id;

        if (Auth::check()) { // 已登录，绑定账号
            if (Auth::user()->github_id == null) {
                $local_user = Auth::user();
                $local_user->github_id = $id;
                $local_user->save();
                return redirect()->route('users.edit', $local_user->id)->with('message', '绑定成功');
            } else {
                return redirect()->route('root');
            }
        } else {
            $local_user = User::where('github_id', $id)->first();
            if ($local_user) { // 已绑定，直接登录
                Auth::login($local_user);
                $request->session()->regenerate();
                return redirect()->route('root');

            } else {
                return redirect()->route('login')->with('danger', '此账号尚未绑定本网站账号！');
//                $local_user = User::find('email', $email);
//
//                if (!$local_user) { // 邮箱未注册，注册账号并登录
//                    User::create([
//                        'email' => $email,
//                        'password' =>
//                    ])
//                } else { // 邮箱已被注册，不能新建账号
//
//                }

            }
        }
    }

    public function unbind()
    {
        $user = Auth::user();
        if ($user->github_id) {
            $user->github_id = null;
            $user->save();
            return redirect()->route('users.edit', $user->id)->with('message', '解绑成功');
        }
        return redirect()->route('users.edit', $user->id);
    }
}
