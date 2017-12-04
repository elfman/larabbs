<?php

namespace App\Http\Requests;

class ReplyRequest extends Request
{
    public function rules()
    {
        return [
            'body' => 'required|min:4',
        ];
    }

    public function messages()
    {
        return [
            // Validation messages
        ];
    }
}
