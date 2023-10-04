<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BlogRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
        'title' => 'required|string|max:255',
        'description' => 'nullable|string|max:255',
        'user_id' => 'required|exists:users,id',
        'status' => 'in:publish,unpublish',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'date_to_publish' => 'required|date|after_or_equal:' . now()->format('Y-m-d'),
        ];
    }
}
