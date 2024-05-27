<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateQuestionRequest extends FormRequest
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
        //     dd($this->question);
        return [
            'question1' => ['required', 'string', 'min:4', 'max:255', 'unique:questions,question,' . $this->question->id],
            'question_type' => ['required', 'string', 'max:255',],
            'paper_id' => ['required', 'numeric', 'max:255'],
        ];
    }

    public function prepareForValidation()
    {

        // $this->merge(['question' => $this->get('question')]);
    }
}