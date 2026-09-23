<?php

namespace App\Http\Requests\Book;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('books.create');
    }

    public function rules(): array
    {
        return [
            'isbn' => ['nullable', 'string', 'max:20', 'unique:books,isbn'],
            'title' => ['required', 'string', 'max:255'],
            'category_name' => ['required', 'string', 'max:255'],
            'author' => ['required', 'string', 'max:255'],
            'publisher_name' => ['nullable', 'string', 'max:255'],
            'publish_year' => ['nullable', 'integer', 'min:1900', 'max:' . (date('Y') + 1)],
            'rack_id' => ['nullable', 'exists:racks,id'],
            'total_qty' => ['required', 'integer', 'min:1'],
            'cover' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'description' => ['nullable', 'string'],
        ];
    }
}
