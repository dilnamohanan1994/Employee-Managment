<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $id = $this->route('employees');
        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255', 
            'email' => 'required|email|unique:companies,email,' . $id,
            'company_id' => 'required|exists:companies,id',
            'phone' => 'required','numeric','digits:10',
        ];
    }
}
