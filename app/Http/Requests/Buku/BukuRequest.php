<?php

namespace App\Http\Requests\Buku;

use UIIGateway\Castle\Http\FormRequest;

class BukuRequest extends FormRequest
{
    /**
     * Make sure that user authorize can access this class
     *
     * @return array
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Set rules for validate request form.
     * Format: 'paramName' => ['rule']
     * Example: 'uuid_organisasi' => ['required','string','max:128']
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'variable_name_1' => [ 'required' ],
            'variable_name_2' => [ 'required' ],
            'variable_name_3' => [ 'required' ],
        ];
    }

    /**
     * Get custom messages for validator errors.
     * You can custom message error for this class with format:
     * 'rule' => 'messages here'
     * Example: 'required' => 'Parameter :attribute wajib diisi'
     *
     * @return array
     */
    public function messages()
    {
        return [
            'required' => 'Parameter :attribute wajib diisi',
            'other_rule' => 'Other rule message'
        ];
    }
}
