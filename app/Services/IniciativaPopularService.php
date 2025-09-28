<?php

namespace App\Services;

class IniciativaPopularService
{
    /**
     * Calcular o mínimo de assinaturas necessárias para iniciativa popular
     * baseado na legislação municipal
     */
    public static function calcularMinimoAssinaturas(?int $eleitoradoMunicipal = null): int
    {
        // Se não tiver dados do eleitorado, usar mínimo legal padrão
        if (!$eleitoradoMunicipal) {
            return function_exists('config') ? 
                config('projeto_lei.iniciativa_popular.minimo_assinaturas_padrao', 1000) : 
                1000;
        }

        // Calcular percentual do eleitorado (geralmente 1% a 5%)
        $percentual = function_exists('config') ? 
            config('projeto_lei.iniciativa_popular.percentual_eleitorado', 0.01) : 
            0.01; // 1%
        $minimoCalculado = (int) ceil($eleitoradoMunicipal * $percentual);

        // Garantir que não seja menor que o mínimo legal
        $minimoLegal = function_exists('config') ? 
            config('projeto_lei.iniciativa_popular.minimo_legal', 100) : 
            100;
        
        return max($minimoCalculado, $minimoLegal);
    }

    /**
     * Validar se o número de assinaturas é suficiente
     */
    public static function validarAssinaturas(int $numeroAssinaturas, int $minimoNecessario): bool
    {
        return $numeroAssinaturas >= $minimoNecessario;
    }

    /**
     * Obter informações sobre os requisitos de iniciativa popular
     */
    public static function obterRequisitos(): array
    {
        return [
            'minimo_legal' => function_exists('config') ? 
                config('projeto_lei.iniciativa_popular.minimo_legal', 100) : 100,
            'minimo_padrao' => function_exists('config') ? 
                config('projeto_lei.iniciativa_popular.minimo_assinaturas_padrao', 1000) : 1000,
            'percentual_eleitorado' => function_exists('config') ? 
                config('projeto_lei.iniciativa_popular.percentual_eleitorado', 0.01) : 0.01,
            'prazo_coleta_dias' => function_exists('config') ? 
                config('projeto_lei.iniciativa_popular.prazo_coleta_dias', 180) : 180,
            'documentos_necessarios' => [
                'Lista de assinaturas com dados completos dos eleitores',
                'Cópia do título de eleitor de cada assinante',
                'Projeto de lei com justificativa',
                'Ata de constituição do comitê responsável'
            ]
        ];
    }

    /**
     * Validar dados do comitê responsável
     */
    public static function validarComite(array $dadosComite): array
    {
        $errors = [];

        if (empty($dadosComite['nome'])) {
            $errors['comite_nome'] = 'O nome do responsável/comitê é obrigatório.';
        }

        if (!empty($dadosComite['email']) && !filter_var($dadosComite['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['comite_email'] = 'O email do comitê deve ser um endereço válido.';
        }

        if (!empty($dadosComite['telefone'])) {
            $telefone = preg_replace('/[^0-9]/', '', $dadosComite['telefone']);
            if (strlen($telefone) < 10 || strlen($telefone) > 11) {
                $errors['comite_telefone'] = 'O telefone deve ter 10 ou 11 dígitos.';
            }
        }

        return $errors;
    }

    /**
     * Formatar número de telefone
     */
    public static function formatarTelefone(string $telefone): string
    {
        $telefone = preg_replace('/[^0-9]/', '', $telefone);
        
        if (strlen($telefone) == 11) {
            return preg_replace('/(\d{2})(\d{5})(\d{4})/', '($1) $2-$3', $telefone);
        } elseif (strlen($telefone) == 10) {
            return preg_replace('/(\d{2})(\d{4})(\d{4})/', '($1) $2-$3', $telefone);
        }
        
        return $telefone;
    }
}