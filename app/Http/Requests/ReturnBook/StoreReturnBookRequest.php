<?php

namespace App\Http\Requests\ReturnBook;

use Illuminate\Foundation\Http\FormRequest;

class StoreReturnBookRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'borrowing_id' => ['required', 'exists:borrowings,id'],
            'return_date' => ['required', 'date'],
            'notes' => ['nullable', 'string'],
            'books' => ['required', 'array', 'min:1'],
            'books.*.id' => ['required', 'exists:borrowing_details,id'],
            'books.*.qty_returned' => ['required', 'integer', 'min:1'],
            'books.*.condition' => ['required', 'in:good,damaged,lost'],
            'books.*.fine_amount' => ['nullable', 'numeric', 'min:0'],
        ];
    }
}
