<?php

namespace App\Http\Requests\Admin\Users;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
{
    /**
     * @property User $user
     */
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name'         => 'required|string|max:255',
            'last_name'    => 'required|string|max:255',
            'middle_name'  => 'required|string|max:255',
            'email'        => 'required|string|email|max:255|unique:users,id,' . $this->user->id,
            'phone'        => 'required|string|regex:/^\+7 \([0-9]{3}\) [0-9]{3}-[0-9]{2}-[0-9]{2}$/',
            'role'         => ['required', 'string', Rule::in(array_keys(User::rolesList()))]
        ];
    }
}
