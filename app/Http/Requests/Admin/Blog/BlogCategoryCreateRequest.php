<?php

namespace App\Http\Requests\Admin\Blog;

use Illuminate\Foundation\Http\FormRequest;

class BlogCategoryCreateRequest extends FormRequest
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
            'title'       => 'required|string|min:5|max:200|unique:blog_categories,title',
            'slug'        => 'nullable|string|min:5|max:200',
            'description' => 'nullable|string|max:500|min:3',
            'parent_id'   => 'nullable|exists:blog_categories,id',
        ];
    }
    /**
     * @return array
     */
    public function attributes(): array
    {
        return [
            'title' => __('Title'),
            'slug'  => __('Slug'),
        ];
    }
}
