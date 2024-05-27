<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreQuestionRequest extends FormRequest
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
            'question' => ['required', 'string', 'min:4', 'max:255'],
            'question_type' => ['required', 'string', 'max:255',],
            'paper_id' => ['required', 'numeric', 'max:255'],
            'correct_answer' => ['required', 'string']
        ];
    }
    // public function prepareForValidation()
    // {

    //     $this->merge(['paper_id' => decrypt($this->get('paper_id'))]);
    // }
}