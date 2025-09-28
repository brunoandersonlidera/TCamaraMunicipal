<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Configurações de Projetos de Lei
    |--------------------------------------------------------------------------
    |
    | Configurações específicas para o sistema de projetos de lei da
    | Câmara Municipal, incluindo parâmetros para iniciativa popular.
    |
    */

    'iniciativa_popular' => [
        /*
        |--------------------------------------------------------------------------
        | Mínimo Legal de Assinaturas
        |--------------------------------------------------------------------------
        |
        | Número mínimo absoluto de assinaturas exigido por lei para
        | projetos de iniciativa popular, independente do tamanho do eleitorado.
        |
        */
        'minimo_legal' => env('INICIATIVA_POPULAR_MINIMO_LEGAL', 100),

        /*
        |--------------------------------------------------------------------------
        | Mínimo Padrão de Assinaturas
        |--------------------------------------------------------------------------
        |
        | Número padrão de assinaturas quando não há dados específicos
        | do eleitorado municipal disponíveis.
        |
        */
        'minimo_assinaturas_padrao' => env('INICIATIVA_POPULAR_MINIMO_PADRAO', 1000),

        /*
        |--------------------------------------------------------------------------
        | Percentual do Eleitorado
        |--------------------------------------------------------------------------
        |
        | Percentual do eleitorado municipal necessário para projetos
        | de iniciativa popular. Valor entre 0.01 (1%) e 0.05 (5%).
        |
        */
        'percentual_eleitorado' => env('INICIATIVA_POPULAR_PERCENTUAL', 0.01),

        /*
        |--------------------------------------------------------------------------
        | Prazo para Coleta de Assinaturas
        |--------------------------------------------------------------------------
        |
        | Prazo em dias para coleta das assinaturas necessárias
        | para projetos de iniciativa popular.
        |
        */
        'prazo_coleta_dias' => env('INICIATIVA_POPULAR_PRAZO_DIAS', 180),

        /*
        |--------------------------------------------------------------------------
        | Máximo de Assinaturas
        |--------------------------------------------------------------------------
        |
        | Número máximo razoável de assinaturas para validação.
        | Usado para evitar valores absurdos no sistema.
        |
        */
        'maximo_assinaturas' => env('INICIATIVA_POPULAR_MAXIMO', 50000),
    ],

    /*
    |--------------------------------------------------------------------------
    | Tipos de Projeto
    |--------------------------------------------------------------------------
    |
    | Tipos de projetos disponíveis no sistema com suas descrições.
    |
    */
    'tipos' => [
        'projeto_lei' => 'Projeto de Lei',
        'projeto_lei_complementar' => 'Projeto de Lei Complementar',
        'projeto_resolucao' => 'Projeto de Resolução',
        'projeto_decreto_legislativo' => 'Projeto de Decreto Legislativo',
        'indicacao' => 'Indicação',
        'mocao' => 'Moção',
        'requerimento' => 'Requerimento',
    ],

    /*
    |--------------------------------------------------------------------------
    | Status de Projeto
    |--------------------------------------------------------------------------
    |
    | Status possíveis para projetos de lei no sistema.
    |
    */
    'status' => [
        'tramitando' => 'Tramitando',
        'aprovado' => 'Aprovado',
        'rejeitado' => 'Rejeitado',
        'retirado' => 'Retirado',
        'arquivado' => 'Arquivado',
    ],

    /*
    |--------------------------------------------------------------------------
    | Tipos de Autoria
    |--------------------------------------------------------------------------
    |
    | Tipos de autoria disponíveis para projetos de lei.
    |
    */
    'tipos_autoria' => [
        'vereador' => 'Vereador',
        'prefeito' => 'Prefeito Municipal',
        'comissao' => 'Comissão',
        'iniciativa_popular' => 'Iniciativa Popular',
    ],

    /*
    |--------------------------------------------------------------------------
    | Configurações de Arquivo
    |--------------------------------------------------------------------------
    |
    | Configurações para upload de arquivos de projetos.
    |
    */
    'arquivos' => [
        'tipos_permitidos' => ['pdf', 'doc', 'docx'],
        'tamanho_maximo_mb' => 10,
        'pasta_upload' => 'projetos-lei',
    ],

    /*
    |--------------------------------------------------------------------------
    | Configurações de Paginação
    |--------------------------------------------------------------------------
    |
    | Configurações para paginação de listas de projetos.
    |
    */
    'paginacao' => [
        'itens_por_pagina' => 15,
        'itens_por_pagina_admin' => 20,
    ],
];