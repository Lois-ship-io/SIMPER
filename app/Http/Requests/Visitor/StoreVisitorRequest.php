<?php

namespace App\Http\Requests\Visitor;

use Illuminate\Foundation\Http\FormRequest;

class StoreVisitorRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Buku tamu bisa diisi oleh siapa saja (terbuka), atau minimal pustakawan
        // Dalam konteks ini, mungkin form-nya public atau diakses oleh petugas.
        return true; 
    }

    public function rules(): array
    {
        return [
            'type' => ['required', 'in:member,non_member'],
            'member_id' => ['required_if:type,member', 'nullable', 'exists:members,id'],
            'name' => ['required_if:type,non_member', 'nullable', 'string', 'max:255'],
            'gender' => ['nullable', 'in:L,P'],
            'address' => ['nullable', 'string'],
            'phone' => ['nullable', 'string', 'max:20'],
            'purpose' => ['required', 'string', 'max:255'],
        ];
    }

    public function messages()
    {
        return [
            'member_id.required_if' => 'Anggota perpustakaan harus dipilih.',
            'name.required_if' => 'Nama pengunjung harus diisi.',
            'purpose.required' => 'Tujuan kunjungan harus diisi.',
        ];
    }
}
