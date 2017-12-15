<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class ModifyPasswordRequest extends Request
{
    public function rules()
    {
        if (Auth::user()->password == 'from_oauth') {
            return [
                'password' => 'required|min:6|confirmed',
                'password_confirmation' => 'required|min:6',
            ];
        } else {
            return [
                'old_password' => 'required|min:6',
                'password' => 'required|min:6|confirmed|different:old_password',
                'password_confirmation' => 'required|min:6',
            ];
        }
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $user = Auth::user();
            $old_password = request('old_password');
            if ($user->password != 'from_oauth' && !Hash::check($old_password, $user->password)) {
                $validator->errors()->add('old_password', '旧密码错误');
            }
        });
    }
}