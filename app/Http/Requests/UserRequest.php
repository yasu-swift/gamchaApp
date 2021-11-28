<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        $route = $this->route()->getName();

        $rule = [
            'name' => 'required|string|max:50',
            'likeGame' => 'required|string|max:2000',
            'profile' => 'required|string|max:3000',
            // 'image' => 'required|file|image|mimes:jpeg,png',
        ];

        if (
            $route === 'users.store' ||
            ($route === 'users.update' && $this->file('avatar'))
        ) {
            $rule['avatar'] = 'required|file|image|mimes:jpeg,png';
        }

        return $rule;
    }
}
