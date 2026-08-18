<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreClienteRequest extends FormRequest {
    public function authorize(): bool {
        return true;
    }

    protected function prepareForValidation(): void {
        if ($this->filled('phone')) {
            $this->merge([
                'phone' => preg_replace('/\D+/', '', $this->phone),
            ]);
        }
    }

    public function rules(): array {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('clientes', 'email')],
            'phone' => ['nullable', 'digits_between:10,11'],
            'photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ];
    }

    public function messages(): array {
        return [
            'name.required' => 'O nome é obrigatório.',
            'name.max' => 'O nome deve ter no máximo :max caracteres.',
            'email.required' => 'O e-mail é obrigatório.',
            'email.email' => 'Informe um e-mail válido.',
            'email.unique' => 'Este e-mail já está cadastrado.',
            'phone.digits_between' => 'Informe um telefone válido (DDD + número, apenas dígitos).',
            'photo.image' => 'O arquivo enviado deve ser uma imagem.',
            'photo.mimes' => 'A imagem deve ser dos tipos: jpg, jpeg, png ou webp.',
            'photo.max' => 'A imagem deve ter no máximo 2MB.',
        ];
    }
}
