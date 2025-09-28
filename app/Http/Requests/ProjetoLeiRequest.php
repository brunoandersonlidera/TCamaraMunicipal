<?php

namespace App\Http\Requests;

use App\Services\IniciativaPopularService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProjetoLeiRequest extends FormRequest
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
        $projetoLeiId = $this->route('projeto_lei') ? $this->route('projeto_lei')->id : null;
        
        $rules = [
            // Regras básicas
            'numero' => 'required|string|max:20|unique:projetos_lei,numero' . ($projetoLeiId ? ',' . $projetoLeiId : ''),
            'ano' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'tipo' => 'required|in:projeto_lei,projeto_lei_complementar,projeto_resolucao,projeto_decreto_legislativo,indicacao,mocao,requerimento',
            'titulo' => 'required|string|max:500',
            'ementa' => 'required|string',
            'justificativa' => 'nullable|string',
            'texto_integral' => 'nullable|string',
            'tipo_autoria' => 'required|in:vereador,prefeito,comissao,iniciativa_popular',
            'coautores' => 'nullable|array',
            'coautores.*' => 'exists:vereadores,id',
            'data_protocolo' => 'required|date',
            'data_publicacao' => 'nullable|date',
            'data_aprovacao' => 'nullable|date',
            'status' => 'required|in:tramitando,aprovado,rejeitado,retirado,arquivado',
            'urgente' => 'boolean',
            'arquivo_projeto' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'arquivo_lei' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'observacoes' => 'nullable|string',
            'tags' => 'nullable|string',
        ];

        // Validações condicionais baseadas no tipo de autoria
        switch ($this->input('tipo_autoria')) {
            case 'vereador':
                $rules['autor_id'] = 'required|exists:vereadores,id';
                break;
                
            case 'comissao':
                $rules['autor_nome'] = 'required|string|max:255';
                break;
                
            case 'iniciativa_popular':
                $rules['comite_nome'] = 'required|string|max:255';
                $rules['comite_email'] = 'nullable|email|max:255';
                $rules['comite_telefone'] = [
                    'nullable',
                    'string',
                    'max:20',
                    function ($attribute, $value, $fail) {
                        if ($value) {
                            $telefone = preg_replace('/[^0-9]/', '', $value);
                            if (strlen($telefone) < 10 || strlen($telefone) > 11) {
                                $fail('O telefone deve ter 10 ou 11 dígitos.');
                            }
                        }
                    },
                ];
                $rules['numero_assinaturas'] = [
                    'required',
                    'integer',
                    'min:1',
                    'max:' . config('projeto_lei.iniciativa_popular.maximo_assinaturas', 50000),
                    function ($attribute, $value, $fail) {
                        $minimoAssinaturas = $this->input('minimo_assinaturas');
                        if ($minimoAssinaturas && $value < $minimoAssinaturas) {
                            $fail("O número de assinaturas coletadas ({$value}) deve ser maior ou igual ao mínimo necessário ({$minimoAssinaturas}).");
                        }
                    },
                ];
                $rules['minimo_assinaturas'] = [
                    'required',
                    'integer',
                    'min:' . config('projeto_lei.iniciativa_popular.minimo_legal', 100),
                    'max:' . config('projeto_lei.iniciativa_popular.maximo_assinaturas', 50000),
                    function ($attribute, $value, $fail) {
                        $minimoLegal = config('projeto_lei.iniciativa_popular.minimo_legal', 100);
                        if ($value < $minimoLegal) {
                            $fail("O mínimo de assinaturas deve ser pelo menos {$minimoLegal} (conforme legislação municipal).");
                        }
                    },
                ];
                break;
        }

        return $rules;
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'numero.unique' => 'Já existe um projeto com este número no ano informado.',
            'tipo_autoria.required' => 'O tipo de autoria é obrigatório.',
            'tipo_autoria.in' => 'O tipo de autoria deve ser: Vereador, Prefeito, Comissão ou Iniciativa Popular.',
            'autor_id.required' => 'O autor é obrigatório quando o tipo de autoria for Vereador.',
            'autor_id.exists' => 'O vereador selecionado não existe.',
            'autor_nome.required' => 'O nome da comissão é obrigatório.',
            'comite_nome.required' => 'O nome do responsável/comitê é obrigatório para iniciativa popular.',
            'comite_email.email' => 'O email do comitê deve ser um endereço válido.',
            'numero_assinaturas.required' => 'O número de assinaturas coletadas é obrigatório.',
            'numero_assinaturas.min' => 'O número de assinaturas deve ser maior que zero.',
            'minimo_assinaturas.required' => 'O mínimo de assinaturas necessárias é obrigatório.',
            'minimo_assinaturas.min' => 'O mínimo de assinaturas deve ser pelo menos 100.',
            'minimo_assinaturas.max' => 'O mínimo de assinaturas não pode exceder 10.000.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'numero' => 'número',
            'ano' => 'ano',
            'tipo' => 'tipo de projeto',
            'titulo' => 'título',
            'ementa' => 'ementa',
            'tipo_autoria' => 'tipo de autoria',
            'autor_id' => 'autor',
            'autor_nome' => 'nome da comissão',
            'comite_nome' => 'nome do responsável/comitê',
            'comite_email' => 'email do comitê',
            'comite_telefone' => 'telefone do comitê',
            'numero_assinaturas' => 'número de assinaturas coletadas',
            'minimo_assinaturas' => 'mínimo de assinaturas necessárias',
            'data_protocolo' => 'data de protocolo',
            'data_publicacao' => 'data de publicação',
            'data_aprovacao' => 'data de aprovação',
            'status' => 'status',
            'arquivo_projeto' => 'arquivo do projeto',
            'arquivo_lei' => 'arquivo da lei',
        ];
    }
}
