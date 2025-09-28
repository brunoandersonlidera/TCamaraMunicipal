<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Validation\ValidationException;

class ValidateAutoriaType
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Aplicar validações apenas em rotas de criação/edição de projetos
        if ($request->isMethod('POST') || $request->isMethod('PUT') || $request->isMethod('PATCH')) {
            $this->validateAutoriaType($request);
        }

        return $next($request);
    }

    /**
     * Validar tipo de autoria e campos relacionados
     */
    private function validateAutoriaType(Request $request)
    {
        $tipoAutoria = $request->input('tipo_autoria');

        if (!$tipoAutoria) {
            return; // Deixar a validação padrão do Request lidar com isso
        }

        switch ($tipoAutoria) {
            case 'vereador':
                $this->validateVereadorAutoria($request);
                break;
                
            case 'prefeito':
                $this->validatePrefeitoAutoria($request);
                break;
                
            case 'comissao':
                $this->validateComissaoAutoria($request);
                break;
                
            case 'iniciativa_popular':
                $this->validateIniciativaPopularAutoria($request);
                break;
        }
    }

    /**
     * Validar autoria de vereador
     */
    private function validateVereadorAutoria(Request $request)
    {
        if (!$request->filled('autor_id')) {
            throw ValidationException::withMessages([
                'autor_id' => 'O vereador autor é obrigatório quando o tipo de autoria for "Vereador".'
            ]);
        }
    }

    /**
     * Validar autoria do prefeito
     */
    private function validatePrefeitoAutoria(Request $request)
    {
        // Para prefeito, não há campos específicos obrigatórios além dos básicos
        // Mas podemos validar se há conflitos com outros campos
        if ($request->filled('autor_id')) {
            throw ValidationException::withMessages([
                'autor_id' => 'Não é possível selecionar um vereador quando o tipo de autoria for "Prefeito".'
            ]);
        }
    }

    /**
     * Validar autoria de comissão
     */
    private function validateComissaoAutoria(Request $request)
    {
        if (!$request->filled('autor_nome')) {
            throw ValidationException::withMessages([
                'autor_nome' => 'O nome da comissão é obrigatório quando o tipo de autoria for "Comissão".'
            ]);
        }

        if ($request->filled('autor_id')) {
            throw ValidationException::withMessages([
                'autor_id' => 'Não é possível selecionar um vereador quando o tipo de autoria for "Comissão".'
            ]);
        }
    }

    /**
     * Validar autoria de iniciativa popular
     */
    private function validateIniciativaPopularAutoria(Request $request)
    {
        $errors = [];

        // Validar campos obrigatórios
        if (!$request->filled('comite_nome')) {
            $errors['comite_nome'] = 'O nome do responsável/comitê é obrigatório para iniciativa popular.';
        }

        if (!$request->filled('numero_assinaturas')) {
            $errors['numero_assinaturas'] = 'O número de assinaturas coletadas é obrigatório.';
        }

        if (!$request->filled('minimo_assinaturas')) {
            $errors['minimo_assinaturas'] = 'O mínimo de assinaturas necessárias é obrigatório.';
        }

        // Validar se o número de assinaturas atende ao mínimo
        $numeroAssinaturas = (int) $request->input('numero_assinaturas', 0);
        $minimoAssinaturas = (int) $request->input('minimo_assinaturas', 0);

        if ($numeroAssinaturas > 0 && $minimoAssinaturas > 0 && $numeroAssinaturas < $minimoAssinaturas) {
            $errors['numero_assinaturas'] = "O número de assinaturas coletadas ({$numeroAssinaturas}) deve ser maior ou igual ao mínimo necessário ({$minimoAssinaturas}).";
        }

        // Validar mínimo legal (exemplo: 1% do eleitorado ou mínimo de 100)
        if ($minimoAssinaturas > 0 && $minimoAssinaturas < 100) {
            $errors['minimo_assinaturas'] = 'O mínimo de assinaturas deve ser pelo menos 100 (conforme legislação municipal).';
        }

        // Validar conflitos com outros campos
        if ($request->filled('autor_id')) {
            $errors['autor_id'] = 'Não é possível selecionar um vereador quando o tipo de autoria for "Iniciativa Popular".';
        }

        if (!empty($errors)) {
            throw ValidationException::withMessages($errors);
        }
    }
}
