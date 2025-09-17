<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Informações da Câmara Municipal
    |--------------------------------------------------------------------------
    |
    | Configurações específicas da Câmara Municipal de Exemplolandia
    |
    */

    'nome' => env('CAMARA_NOME', 'Câmara Municipal de Exemplolandia'),
    'endereco' => env('CAMARA_ENDERECO', 'Rua Principal, 123 - Centro'),
    'cep' => env('CAMARA_CEP', '12345-678'),
    'cidade' => env('CAMARA_CIDADE', 'Exemplolandia'),
    'uf' => env('CAMARA_UF', 'EX'),
    'telefone' => env('CAMARA_TELEFONE', '(11) 1234-5678'),
    'email' => env('CAMARA_EMAIL', 'contato@camaraexemplolandia.gov.br'),
    'site' => env('CAMARA_SITE', 'https://camara.exemplolandia.gov.br'),

    /*
    |--------------------------------------------------------------------------
    | Configurações de e-SIC e Ouvidoria
    |--------------------------------------------------------------------------
    */

    'esic' => [
        'prazo_resposta' => env('ESIC_PRAZO_RESPOSTA', 20),
        'email_notificacao' => env('ESIC_EMAIL_NOTIFICACAO', 'esic@camaraexemplolandia.gov.br'),
        'protocolo_prefixo' => 'CMS',
    ],

    'ouvidoria' => [
        'email' => env('OUVIDORIA_EMAIL', 'ouvidoria@camaraexemplolandia.gov.br'),
        'protocolo_prefixo' => 'OUV',
    ],

    /*
    |--------------------------------------------------------------------------
    | Configurações de Upload
    |--------------------------------------------------------------------------
    */

    'upload' => [
        'max_file_size' => env('MAX_FILE_SIZE', 10240), // KB
        'allowed_types' => explode(',', env('ALLOWED_FILE_TYPES', 'pdf,doc,docx,xls,xlsx,jpg,jpeg,png,gif')),
        'documents_path' => 'documents',
        'images_path' => 'images',
        'videos_path' => 'videos',
    ],

    /*
    |--------------------------------------------------------------------------
    | Configurações de Busca
    |--------------------------------------------------------------------------
    */

    'search' => [
        'driver' => env('SEARCH_DRIVER', 'database'),
        'meilisearch' => [
            'host' => env('MEILISEARCH_HOST', 'http://localhost:7700'),
            'key' => env('MEILISEARCH_KEY', ''),
        ],
        'results_per_page' => 20,
    ],

    /*
    |--------------------------------------------------------------------------
    | Configurações de Cache
    |--------------------------------------------------------------------------
    */

    'cache' => [
        'ttl' => env('CACHE_TTL', 3600),
        'cdn_url' => env('CDN_URL', ''),
    ],

    /*
    |--------------------------------------------------------------------------
    | Configurações de Sessões
    |--------------------------------------------------------------------------
    */

    'sessoes' => [
        'tipos' => [
            'ordinaria' => 'Sessão Ordinária',
            'extraordinaria' => 'Sessão Extraordinária',
            'solene' => 'Sessão Solene',
            'audiencia_publica' => 'Audiência Pública',
        ],
        'status' => [
            'agendada' => 'Agendada',
            'em_andamento' => 'Em Andamento',
            'finalizada' => 'Finalizada',
            'cancelada' => 'Cancelada',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Configurações de Projetos de Lei
    |--------------------------------------------------------------------------
    */

    'projetos' => [
        'tipos' => [
            'projeto_lei' => 'Projeto de Lei',
            'projeto_decreto' => 'Projeto de Decreto',
            'projeto_resolucao' => 'Projeto de Resolução',
            'emenda' => 'Emenda',
            'substitutivo' => 'Substitutivo',
        ],
        'status' => [
            'tramitando' => 'Em Tramitação',
            'aprovado' => 'Aprovado',
            'rejeitado' => 'Rejeitado',
            'arquivado' => 'Arquivado',
            'sancionado' => 'Sancionado',
            'vetado' => 'Vetado',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Configurações de Roles e Permissões
    |--------------------------------------------------------------------------
    */

    'roles' => [
        'admin' => 'Administrador',
        'editor' => 'Editor',
        'autor' => 'Autor',
        'revisor' => 'Revisor',
        'visualizador' => 'Visualizador',
    ],

    /*
    |--------------------------------------------------------------------------
    | Configurações de Workflow
    |--------------------------------------------------------------------------
    */

    'workflow' => [
        'status' => [
            'rascunho' => 'Rascunho',
            'em_revisao' => 'Em Revisão',
            'aprovado' => 'Aprovado',
            'publicado' => 'Publicado',
            'arquivado' => 'Arquivado',
        ],
    ],

];