<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $userId = $this->route('user')?->id ?? $this->route('user');

        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users')
                    ->ignore($userId)
                    ->whereNull('deleted_at'),
            ],
            'phone' => ['required', 'string', 'max:255'],
            'user_type' => ['required', 'string'],
            'department' => ['required', 'string'],
            'permissions' => ['nullable', 'array'],
        ];
    }

    public function messages(): array
    {
        return [
            'email.unique' => 'Este e-mail já está em uso.',
            'name.required' => 'O nome é obrigatório.',
            'email.required' => 'O e-mail é obrigatório.',
            'email.unique' => 'Este e-mail já está em uso por outro usuário ativo.',
            'email.email' => 'O e-mail deve ser um endereço de e-mail válido.',
            'phone.max' => 'O telefone não pode ter mais de 20 caracteres.',
            'user_type.required' => 'O tipo de usuário é obrigatório.',
            'department.required' => 'O departamento é obrigatório.',
        ];
    }
}
