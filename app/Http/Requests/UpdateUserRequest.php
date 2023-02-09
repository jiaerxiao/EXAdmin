<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'number' => ['required',  Rule::unique('users')->ignore(request('id')),],
            'name' => ['required'],
            'real_name' => ['required'],
            'sex' => ['required', new Enum(SexStatus::class)],
            'email' => ['required', 'email',  Rule::unique('users')->ignore(request('id')),],
            'mobile' => ['required', Rule::unique('users')->ignore(request('id')),],
        ];
    }

    public function attributes()
    {
        return ['number' => '工号', 'name' => '昵称', 'real_name' => '姓名'];
    }
}
