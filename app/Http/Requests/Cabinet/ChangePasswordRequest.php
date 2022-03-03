<?php

namespace App\Http\Requests\Cabinet;

use App\Rules\MatchOldPassword;
use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
{
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
            'old_password'          => ['required', new MatchOldPassword()],
            'new_password'          => 'required|min:8',
            'password_confirmation' => 'same:new_password',
        ];
    }
}
