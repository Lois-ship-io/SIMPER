<?php

namespace App\Http\Requests\Rack;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRackRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'code' => ['required', 'string', 'max:50', 'unique:racks,code,' . $this->rack->id],
            'name' => ['required', 'string', 'max:255'],
            'location' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ];
    }
}
