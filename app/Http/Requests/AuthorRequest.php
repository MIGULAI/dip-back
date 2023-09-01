<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthorRequest extends FormRequest
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
            // 'degree' => ['required'],
            // 'department' => ['required'],
            // 'firstName' => ['required'],
            // 'firstNameEng' => ['required'],
            // 'orcid' => ['required'],
            // 'patronicName' => ['required'],
            // 'position' => ['required'],
            // 'rank' => ['required'],
            // 'serName' => ['required'],
            // 'serNameEng' => ['required'],
            // 'specialty' => ['required']
        ];
    }
}
