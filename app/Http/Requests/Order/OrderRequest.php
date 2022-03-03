<?php

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class OrderRequest extends FormRequest
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
    public function rules(): array
    {
        return [
            'delivery_type'      => 'nullable',
            'delivery_date'      => 'string|nullable',
            'delivery_time'      => 'string|nullable',
            'payment_type'       => 'nullable',
            'city'               => 'nullable|string',
            'street'             => 'nullable|string',
            'house_number'       => 'nullable|numeric',
            'apartment'          => 'nullable|numeric',
            'last_name'          => 'required|string|max:255|nullable',
            'name'               => 'required|string|max:255',
            'middle_name'        => 'string|max:255|nullable',
            'email'              => 'required|string|email',
            'message'            => 'nullable|string',
        ];
    }
}
