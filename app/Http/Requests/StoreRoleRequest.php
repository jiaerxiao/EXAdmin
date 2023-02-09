<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRoleRequest extends FormRequest
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
            'name' => ['required', 'unique:roles'],
            'title' => ['required', 'unique:roles'],
        ];
    }

    public function attributes()
    {
        return ['title' => '角色名称', 'name' => '角色标识'];
    }
}
