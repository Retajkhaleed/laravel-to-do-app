<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return True;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'project_id'  => ['nullable', 'exists:projects,id'],
            'title'       => ['required', 'min:2'],
            'description' => ['nullable', 'max:1000'],
            'status'      => ['nullable', 'in:todo,in_progress,done'],
            'assigned_to' => ['nullable', 'exists:users,id'],
        ];
    }

}
