<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactsRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $contactId = $this->route('contact')?->id;

        return [
            'name' => ['required', 'string', 'min:3'],
            'email' => [
                'required',
                'email',
                $contactId 
                    ? 'unique:contacts,email,' . $contactId 
                    : 'unique:contacts,email'
            ],
            'phone' => ['required', 'string', 'min:10']
        ];
    }
}
