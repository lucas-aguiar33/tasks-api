<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:100',
            'description' => 'nullable|string',
            'status' => 'required|in:pending,in_progress,completed'
        ];
    }


    public function messages(): array 
    {
        return [
            'title.required' => 'Adicione um título a tarefa',
            'status.required' => 'Informe o status da tarefa',
            'status.in' => 'Informe um status válido',
        ];
    }
}
