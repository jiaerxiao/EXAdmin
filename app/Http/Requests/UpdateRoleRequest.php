<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRoleRequest extends FormRequest
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
            'name' => ['required', Rule::unique('roles')->ignore(request('id'))],
            'title' => ['required', Rule::unique('roles')->ignore(request('id'))],
        ];
    }

    public function attributes()
    {
        return ['title' => '角色名称', 'name' => '角色标识'];
    }
}
