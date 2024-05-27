<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePaperRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:4', 'max:255', 'unique:papers,name,' . $this->paper->id],
            'description' => ['nullable', 'string', 'max:255',],
            'subject_id' => ['required', 'numeric'],
            'paper_time' => ['required', 'numeric'],
            'is_shuffle' => ['nullable', 'boolean'],
            'is_shuffle_option' => ['nullable', 'boolean'],

        ];
    }


    function prepareForValidation()
    {
       
        $this->merge(['is_shuffle'=>$this->get('is_shuffle')=='on'?1:0,
        'is_shuffle_option'=>$this->get('is_shuffle_option')=='on'?1:0]);
    }
}
