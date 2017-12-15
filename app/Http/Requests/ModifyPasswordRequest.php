<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ModifyPasswordRequest extends Request
{
    public function rules()
    {
        return [
            'old_password' => 'required|min:6',
            'password' => 'required|min:6|confirmed|different:old_password',
            'password_confirmation' => 'required|min:6',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $user = Auth::user();
            if (!Hash::check(request('old_password'), $user->password)) {
                $validator->errors()->add('old_password', '旧密码错误');
            }
        });
    }
}