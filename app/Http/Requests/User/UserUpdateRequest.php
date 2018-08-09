<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
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
        $user = $this->route('user');

        return [
            'email' => 'email|unique:users,email,'.$user->id,
            'password' => 'min:6|confirmed',
            'admin' => 'boolean',
        ];
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $hasFieldAdmin = $this->has('is_admin');
        $isVerified = $this->route('user')->verified;

        $validator->after(function ($validator) use ($hasFieldAdmin, $isVerified) {
            if ($hasFieldAdmin && !$isVerified) {
                $validator->errors()->add('notVerified', 'Unicamente los usuarios verificados pueden cambiar su valor de Administrador.');
            }
        });
    }
}
