<?php

namespace App\Http\Requests\Member;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateMemberRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('members.edit');
    }

    public function rules(): array
    {
        return [
            'nis' => [
                'required', 
                'string', 
                'max:50', 
                Rule::unique('members')->ignore($this->member)
            ],
            'name' => ['required', 'string', 'max:255'],
            'gender' => ['required', 'in:L,P'],
            'class' => ['required', 'string', 'max:50'],
            'major' => ['nullable', 'string', 'max:100'],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string'],
            'status' => ['required', 'in:active,inactive'],
        ];
    }
}
