<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePermissionRequest extends FormRequest
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
            'name' => ['required', Rule::unique('permissions')->ignore(request('id'))],
            'title' => ['required', Rule::unique('permissions')->ignore(request('id'))],
        ];
    }

    public function attributes()
    {
        return ['title' => '权限名称', 'name' => '权限标识'];
    }
}
