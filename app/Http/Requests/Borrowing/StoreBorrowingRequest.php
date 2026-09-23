<?php

namespace App\Http\Requests\Borrowing;

use Illuminate\Foundation\Http\FormRequest;

class StoreBorrowingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'member_id' => ['required', 'exists:members,id'],
            'borrow_date' => ['required', 'date'],
            'due_date' => ['required', 'date', 'after_or_equal:borrow_date'],
            'notes' => ['nullable', 'string'],
            'books' => ['required', 'array', 'min:1'],
            'books.*.id' => ['required', 'exists:books,id'],
            'books.*.qty' => ['required', 'integer', 'min:1'],
        ];
    }
}
