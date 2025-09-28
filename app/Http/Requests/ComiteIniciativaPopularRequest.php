<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ComiteIniciativaPopularRequest extends FormRequest
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
        $comiteId = $this->route('comites_iniciativa_popular') ? $this->route('comites_iniciativa_popular')->id : null;

        return [
            // Informações básicas do comitê
            'nome' => [
                'required',
                'string',
                'max:255',
                Rule::unique('comite_iniciativa_populars', 'nome')->ignore($comiteId)
            ],
            'cpf' => [
                'required',
                'string',
                'regex:/^\d{3}\.\d{3}\.\d{3}-\d{2}$/',
                Rule::unique('comite_iniciativa_populars', 'cpf')->ignore($comiteId)
            ],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('comite_iniciativa_populars', 'email')->ignore($comiteId)
            ],
            'telefone' => [
                'required',
                'string',
                'max:20',
                'regex:/^\(\d{2}\)\s\d{4,5}-\d{4}$/'
            ],
            'endereco' => 'nullable|string|max:500',

            // Campos de assinaturas
            'numero_assinaturas' => 'nullable|integer|min:0',
            'minimo_assinaturas' => 'required|integer|min:1',
            'data_inicio_coleta' => 'nullable|date',
            'data_fim_coleta' => 'nullable|date|after_or_equal:data_inicio_coleta',

            // Documentos (JSON)
            'documentos' => 'nullable|json',

            // Outros campos
            'observacoes' => 'nullable|string|max:2000',
            'status' => 'required|in:ativo,validado,rejeitado,arquivado',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'nome.required' => 'O nome do comitê é obrigatório.',
            'nome.unique' => 'Já existe um comitê com este nome.',
            'cpf.required' => 'O CPF é obrigatório.',
            'cpf.regex' => 'O CPF deve estar no formato XXX.XXX.XXX-XX.',
            'cpf.unique' => 'Este CPF já está sendo usado por outro comitê.',
            'email.required' => 'O email é obrigatório.',
            'email.email' => 'O email deve ter um formato válido.',
            'email.unique' => 'Este email já está sendo usado por outro comitê.',
            'telefone.required' => 'O telefone é obrigatório.',
            'telefone.regex' => 'O telefone deve estar no formato (XX) XXXXX-XXXX.',
            'numero_assinaturas.integer' => 'O número de assinaturas deve ser um número inteiro.',
            'numero_assinaturas.min' => 'O número de assinaturas não pode ser negativo.',
            'minimo_assinaturas.required' => 'O mínimo de assinaturas é obrigatório.',
            'minimo_assinaturas.integer' => 'O mínimo de assinaturas deve ser um número inteiro.',
            'minimo_assinaturas.min' => 'O mínimo de assinaturas deve ser pelo menos 1.',
            'data_inicio_coleta.date' => 'A data de início deve ser uma data válida.',
            'data_fim_coleta.date' => 'A data de fim deve ser uma data válida.',
            'data_fim_coleta.after_or_equal' => 'A data de fim deve ser igual ou posterior à data de início.',
            'documentos.json' => 'Os documentos devem estar em formato JSON válido.',
            'observacoes.max' => 'As observações não podem ter mais de 2000 caracteres.',
            'status.required' => 'O status é obrigatório.',
            'status.in' => 'O status deve ser: ativo, validado, rejeitado ou arquivado.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'nome' => 'nome do comitê',
            'cpf' => 'CPF',
            'email' => 'email',
            'telefone' => 'telefone',
            'endereco' => 'endereço',
            'numero_assinaturas' => 'número de assinaturas',
            'minimo_assinaturas' => 'mínimo de assinaturas',
            'data_inicio_coleta' => 'data de início da coleta',
            'data_fim_coleta' => 'data de fim da coleta',
            'documentos' => 'documentos',
            'observacoes' => 'observações',
            'status' => 'status',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Limpar formatação do CPF para validação
        if ($this->has('cpf')) {
            $this->merge([
                'cpf_clean' => preg_replace('/[^0-9]/', '', $this->cpf)
            ]);
        }
    }

    /**
     * Configure the validator instance.
     */
    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            // Validação customizada do CPF
            if ($this->has('cpf')) {
                $cpf = preg_replace('/[^0-9]/', '', $this->cpf);
                if (!$this->isValidCPF($cpf)) {
                    $validator->errors()->add('cpf', 'O CPF informado não é válido.');
                }
            }
        });
    }

    /**
     * Validate CPF number.
     */
    public function isValidCPF(string $cpf): bool
    {
        // Remove any non-numeric characters
        $cpf = preg_replace('/[^0-9]/', '', $cpf);

        // Check if CPF has 11 digits
        if (strlen($cpf) != 11) {
            return false;
        }

        // Check for known invalid CPFs
        if (preg_match('/(\d)\1{10}/', $cpf)) {
            return false;
        }

        // Calculate first verification digit
        $sum = 0;
        for ($i = 0; $i < 9; $i++) {
            $sum += $cpf[$i] * (10 - $i);
        }
        $remainder = $sum % 11;
        $digit1 = $remainder < 2 ? 0 : 11 - $remainder;

        // Calculate second verification digit
        $sum = 0;
        for ($i = 0; $i < 10; $i++) {
            $sum += $cpf[$i] * (11 - $i);
        }
        $remainder = $sum % 11;
        $digit2 = $remainder < 2 ? 0 : 11 - $remainder;

        // Check if calculated digits match the CPF
        return $cpf[9] == $digit1 && $cpf[10] == $digit2;
    }
}
