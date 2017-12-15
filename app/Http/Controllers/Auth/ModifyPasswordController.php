<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\ModifyPasswordRequest;
use Illuminate\Support\Facades\Auth;

class ModifyPasswordController extends Controller
{
    public function updatePassword()
    {
        return view('auth.passwords.update');
    }

    public function modifyPassword(ModifyPasswordRequest $request)
    {
        $user = Auth::user();
        $user->password = bcrypt($request->password);
        $user->save();
        return redirect()->route('users.edit', $user->id)->with('success', '成功修改密码！');
    }
}