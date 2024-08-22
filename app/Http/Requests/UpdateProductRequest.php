<?php

namespace App\Http\Requests;

use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
        $id = $this->route('product')->id;
        return [
            'category_id' => 'required',
            'name' => 'required|unique:products,name,' . $id,
            'price' => 'required',
            'description' => 'nullable',
            'image_path' => 'nullable|image',
            'tags' => 'required|array',
            'tags.*' => 'required|integer',
            'galleries' => 'nullable|array',
            'galleries.*' => 'nullable|image',
        ];
    }
}