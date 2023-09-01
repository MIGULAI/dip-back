<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PublicationRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'lastPage' => ['required', 'integer', 'min:0'],
            'startPage' => ['required', 'integer', 'min:0'],
            'issue_numb' => ['required', 'string', 'min:1'],
            'type' => ['required', 'integer', 'min:1'],
            'UPP' => ['required'],
            'publisher' => ['required', 'integer', 'min:1'],
            'lang' => ['required', 'integer', 'min:1'],
            'url' => ['required', 'string'],
            'date' => ['required', 'date']
        ];
    }
}
