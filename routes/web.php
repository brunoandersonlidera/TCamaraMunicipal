<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\VereadorController;
use App\Http\Controllers\SessaoController;
use App\Http\Controllers\UserAreaController;
use App\Http\Controllers\ImageUploadController;
use App\Http\Controllers\OuvidoriaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TransparenciaController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\CalendarioController;
use App\Http\Controllers\LicitacaoDocumentoController;
use App\Http\Controllers\Admin\EventosController;
use App\Http\Controllers\LeisController;
use App\Models\Vereador;
use App\Models\User;
use App\Models\Sessao;
use App\Models\AcessoRapido;
use App\Models\Noticia;

// Rota personalizada para servir imagens do storage
Route::get('/storage/{path}', function ($path) {
    $filePath = storage_path('app/public/' . $path);
    
    if (!file_exists($filePath)) {
        abort(404);
    }
    
    $mimeType = mime_content_type($filePath);
    
    return Response::file($filePath, [
        'Content-Type' => $mimeType,
        'Cache-Control' => 'public, max-age=31536000',
    ]);
})->where('path', '.*');

Route::get('/', function () {
    // Buscar presidente e vereadores para a página inicial
    $vereadores = Vereador::ativos()->orderBy('nome_parlamentar')->get();
    
    // Encontrar presidente (primeiro vereador que tem 'presidente' nas comissões)
    $presidente = $vereadores->first(function ($vereador) {
        $comissoes = $vereador->comissoes ?? [];
        // Se comissoes for string, decodificar JSON
        if (is_string($comissoes)) {
            $comissoes = json_decode($comissoes, true) ?? [];
        }
        return in_array('presidente', $comissoes);
    });
    
    // Remover presidente da lista de vereadores se encontrado
    if ($presidente) {
        $vereadores = $vereadores->reject(function ($vereador) use ($presidente) {
            return $vereador->id === $presidente->id;
        });
    }
    
    // Buscar sessões gravadas recentes para a página inicial
    $sessoesGravadas = Sessao::recentes(4)->get();
    
    // Buscar sessão ao vivo atual
    $sessaoAoVivo = Sessao::aoVivo()->first();
    
    // Buscar sessão em destaque (próxima, atual ou última)
    $sessaoDestaque = Sessao::where('status', 'em_andamento')->first() ?? // Sessão em andamento
                     Sessao::where('status', 'agendada')
                           ->where('data_sessao', '>=', now()->toDateString())
                           ->orderBy('data_sessao', 'asc')
                           ->orderBy('hora_inicio', 'asc')
                           ->first() ?? // Próxima sessão agendada
                     Sessao::where('status', 'finalizada')
                           ->orderBy('data_sessao', 'desc')
                           ->orderBy('hora_inicio', 'desc')
                           ->first(); // Última sessão finalizada
    
    // Dados para a seção "Números da Câmara"
    $totalVereadores = $vereadores->count() + ($presidente ? 1 : 0);
    $projetos = 45; // Valor padrão até implementar tabela de projetos
    $sessoes = Sessao::realizadas()->count();
    $leis = 12;     // Valor padrão até implementar tabela de leis
    
    // Buscar acessos rápidos ativos para a página inicial
    $acessosRapidos = AcessoRapido::ativos()->ordenados()->get();
    
    // Buscar slides ativos para o hero section
    $slides = \App\Models\Slide::ativos()->ordenados()->get();
    
    // Buscar configurações do hero section
    $heroConfig = \App\Models\HeroConfiguration::getActive();
    
    // Buscar últimas notícias para a página inicial
    $ultimasNoticias = Noticia::publicadas()
                             ->recentes()
                             ->limit(3)
                             ->get();
        
    return view('welcome', compact('presidente', 'vereadores', 'totalVereadores', 'projetos', 'sessoes', 'leis', 'sessoesGravadas', 'sessaoAoVivo', 'sessaoDestaque', 'acessosRapidos', 'slides', 'heroConfig', 'ultimasNoticias'));
})->name('home');

// Rotas de Autenticação
Route::middleware('guest')->group(function () {
    // Verificar se precisa configurar primeiro admin
    Route::get('/first-access', function () {
        if (User::admins()->exists()) {
            return redirect()->route('login');
        }
        return app(AuthController::class)->showFirstAccessForm();
    })->name('first-access');
    
    Route::post('/first-access', [AuthController::class, 'createFirstAdmin'])->name('first-access.create');
    
    // Login
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// Logout (disponível para usuários autenticados)
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Rotas de cadastro público
Route::get('/cadastro', [App\Http\Controllers\RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/cadastro', [App\Http\Controllers\RegisterController::class, 'register']);
Route::get('/cadastro/sucesso', [App\Http\Controllers\RegisterController::class, 'registrationSuccess'])->name('register.success');

// Rotas de verificação de email
Route::get('/verificar-email/{token}', [App\Http\Controllers\RegisterController::class, 'verifyEmail'])->name('verify.email');
Route::get('/reenviar-verificacao', [App\Http\Controllers\RegisterController::class, 'showResendForm'])->name('verification.resend');
Route::post('/reenviar-verificacao', [App\Http\Controllers\RegisterController::class, 'resendVerification']);

// Rotas para termos e política
Route::get('/termos-de-uso', [App\Http\Controllers\RegisterController::class, 'showTerms'])->name('terms');
Route::get('/politica-de-privacidade', [App\Http\Controllers\RegisterController::class, 'showPrivacy'])->name('privacy');

// Rotas de recuperação de senha
Route::get('/esqueci-minha-senha', [App\Http\Controllers\PasswordResetController::class, 'showRequestForm'])->name('password.request');
Route::post('/esqueci-minha-senha', [App\Http\Controllers\PasswordResetController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/redefinir-senha/{token}', [App\Http\Controllers\PasswordResetController::class, 'showResetForm'])->name('password.reset');
Route::post('/redefinir-senha', [App\Http\Controllers\PasswordResetController::class, 'reset'])->name('password.update');

// Rotas públicas de notícias
Route::get('/noticias', [App\Http\Controllers\NoticiaController::class, 'index'])->name('noticias.index');
Route::get('/noticias/{id}', [App\Http\Controllers\NoticiaController::class, 'show'])->name('noticias.show');

// Rotas públicas para projetos de lei
Route::get('/projetos-lei', [App\Http\Controllers\ProjetoLeiController::class, 'index'])->name('projetos-lei.index');
Route::get('/projetos-lei/{projetoLei}', [App\Http\Controllers\ProjetoLeiController::class, 'show'])->name('projetos-lei.show');
Route::get('/projetos-lei/{projetoLei}/download/{tipo}', [App\Http\Controllers\ProjetoLeiController::class, 'download'])->name('projetos-lei.download');

// Rotas da área do usuário (requer autenticação)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/minha-area', [UserAreaController::class, 'dashboard'])->name('user.dashboard');
    Route::get('/meu-perfil', [UserAreaController::class, 'profile'])->name('user.profile');
    Route::put('/meu-perfil', [UserAreaController::class, 'updateProfile'])->name('user.profile.update');
    Route::put('/alterar-senha', [UserAreaController::class, 'updatePassword'])->name('user.password.update');
    Route::get('/minhas-notificacoes', [UserAreaController::class, 'notifications'])->name('user.notifications');
    Route::post('/notificacoes/marcar-lida/{id}', [UserAreaController::class, 'markNotificationAsRead'])->name('user.notifications.mark-read');
    Route::post('/notificacoes/marcar-todas-lidas', [UserAreaController::class, 'markAllNotificationsAsRead'])->name('user.notifications.mark-all-read');
    Route::get('/meu-historico', [UserAreaController::class, 'history'])->name('user.history');
    Route::get('/configuracoes', [UserAreaController::class, 'settings'])->name('user.settings');
    Route::put('/configuracoes', [UserAreaController::class, 'updateSettings'])->name('user.settings.update');
});

// Rotas de upload de imagens (protegidas por autenticação)
Route::middleware(['auth'])->group(function () {
    Route::post('/upload/images/single', [ImageUploadController::class, 'upload'])->name('upload.image.single');
    Route::post('/upload/images/multiple', [ImageUploadController::class, 'uploadMultiple'])->name('upload.image.multiple');
    Route::post('/upload/images/delete', [ImageUploadController::class, 'delete'])->name('upload.image.delete');
    
    // Página de teste do upload (apenas para desenvolvimento)
    Route::get('/test-upload', function () {
        return view('test-upload');
    })->name('test.upload');
});

// Rotas da Ouvidoria (públicas)
Route::get('/ouvidoria', [OuvidoriaController::class, 'index'])->name('ouvidoria.index');
Route::get('/ouvidoria/nova-manifestacao', [OuvidoriaController::class, 'create'])->name('ouvidoria.create');
Route::post('/ouvidoria/manifestacao', [OuvidoriaController::class, 'store'])->name('ouvidoria.store');
Route::get('/ouvidoria/consultar', [OuvidoriaController::class, 'consultar'])->name('ouvidoria.consultar');
Route::post('/ouvidoria/avaliar/{protocolo}', [OuvidoriaController::class, 'avaliar'])->name('ouvidoria.avaliar');

// Rotas ESIC (Sistema Eletrônico de Informações ao Cidadão)
// Área pública - sem autenticação
Route::get('/esic', [App\Http\Controllers\EsicController::class, 'publicIndex'])->name('esic.public');
Route::get('/esic/sobre', [App\Http\Controllers\EsicController::class, 'sobre'])->name('esic.sobre');
Route::get('/esic/faq', [App\Http\Controllers\EsicController::class, 'faq'])->name('esic.faq');
Route::get('/esic/estatisticas', [App\Http\Controllers\EsicController::class, 'estatisticas'])->name('esic.estatisticas');

// Área do usuário - com autenticação
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/esic/dashboard', [App\Http\Controllers\EsicController::class, 'dashboard'])->name('esic.dashboard');
    Route::get('/esic/nova-solicitacao', [App\Http\Controllers\EsicController::class, 'create'])->name('esic.create');
    Route::post('/esic/solicitacao', [App\Http\Controllers\EsicController::class, 'store'])->name('esic.store');
    Route::get('/esic/minhas-solicitacoes', [App\Http\Controllers\EsicController::class, 'minhasSolicitacoes'])->name('esic.minhas');
    Route::get('/esic/solicitacao/{protocolo}', [App\Http\Controllers\EsicController::class, 'show'])->name('esic.show');
    Route::get('/esic/consultar', [App\Http\Controllers\EsicController::class, 'consultar'])->name('esic.consultar');
    Route::post('/esic/consultar', [App\Http\Controllers\EsicController::class, 'consultar'])->name('esic.consultar.post');
});

// Rotas para Cartas de Serviço
Route::get('/cartas-servico', [App\Http\Controllers\CartaServicoController::class, 'indexPublico'])->name('cartas-servico.index');
Route::get('/cartas-servico/{slug}', [App\Http\Controllers\CartaServicoController::class, 'showPublico'])->name('cartas-servico.show');

// Rotas dos vereadores (públicas)
Route::get('/vereadores', [\App\Http\Controllers\VereadorController::class, 'index'])->name('vereadores.index');
Route::get('/vereadores/{id}', [VereadorController::class, 'show'])->name('vereadores.show');

// Rotas das sessões (públicas)
Route::get('/sessoes', [SessaoController::class, 'index'])->name('sessoes.index');
Route::get('/tv-camara', [SessaoController::class, 'tvCamara'])->name('tv-camara');
Route::get('/sessoes/calendario', [SessaoController::class, 'calendario'])->name('sessoes.calendario');
Route::get('/ao-vivo', [SessaoController::class, 'aoVivo'])->name('sessoes.ao-vivo');
Route::get('/sessoes/{sessao}', [SessaoController::class, 'show'])->name('sessoes.show');
Route::get('/sessoes/{sessao}/ata/download', [SessaoController::class, 'downloadAta'])->name('sessoes.download-ata');
Route::get('/sessoes/{sessao}/pauta/download', [SessaoController::class, 'downloadPauta'])->name('sessoes.download-pauta');

// Rotas do Portal da Transparência (públicas)
Route::prefix('transparencia')->name('transparencia.')->group(function () {
    Route::get('/', [TransparenciaController::class, 'index'])->name('index');
    Route::get('/receitas', [TransparenciaController::class, 'receitas'])->name('receitas');
    Route::get('/despesas', [TransparenciaController::class, 'despesas'])->name('despesas');
    Route::get('/financeiro', [TransparenciaController::class, 'financeiro'])->name('financeiro');
    Route::get('/licitacoes', [TransparenciaController::class, 'licitacoes'])->name('licitacoes');
    Route::get('/licitacoes/{licitacao}', [TransparenciaController::class, 'showLicitacao'])->name('licitacoes.show');
    Route::get('/licitacoes/{licitacao}/documento/{documento}/download', [LicitacaoDocumentoController::class, 'download'])->name('licitacoes.documento.download');
    Route::get('/contratos', [TransparenciaController::class, 'contratos'])->name('contratos');
    Route::get('/contratos/{contrato}', [TransparenciaController::class, 'showContrato'])->name('contratos.show');
    Route::get('/contratos/{contrato}/download', [TransparenciaController::class, 'downloadContratoArquivo'])->name('contratos.download');
    Route::get('/contratos/{contrato}/aditivos/{aditivo}/download', [TransparenciaController::class, 'downloadAditivoArquivo'])->name('contratos.aditivos.download');
    Route::get('/folha-pagamento', [TransparenciaController::class, 'folhaPagamento'])->name('folha-pagamento');
    Route::get('/exportar/{tipo}', [TransparenciaController::class, 'exportar'])->name('exportar');
    Route::get('/api/evolucao-mensal', [TransparenciaController::class, 'evolucaoMensalJson'])->name('api.evolucao-mensal');
});

// Rotas públicas para documentos de licitações
Route::get('/licitacao/{licitacao}/documentos', [App\Http\Controllers\LicitacaoDocumentoController::class, 'listar'])->name('licitacao.documentos');
Route::get('/licitacao/documento/{documento}/download', [App\Http\Controllers\LicitacaoDocumentoController::class, 'download'])->name('licitacao.documento.download');
Route::get('/licitacao/documento/{documento}/visualizar', [App\Http\Controllers\LicitacaoDocumentoController::class, 'visualizar'])->name('licitacao.documento.visualizar');

// Rotas de Busca
Route::get('/busca', [SearchController::class, 'search'])->name('search');
Route::get('/api/busca', [SearchController::class, 'api'])->name('search.api');

// Rotas de API para o Calendário
Route::prefix('api')->name('api.')->group(function () {
    Route::get('/eventos', [CalendarioController::class, 'buscarEventos'])->name('eventos');
    Route::get('/eventos/estatisticas', [CalendarioController::class, 'estatisticas'])->name('eventos.estatisticas');
    Route::get('/eventos/proximos', [CalendarioController::class, 'proximosEventos'])->name('eventos.proximos');
});

// Rota raiz do calendário - redireciona para agenda
Route::get('/calendario', function () {
    return redirect()->route('calendario.agenda');
})->name('calendario');

// Rotas do Calendário (públicas)
Route::prefix('calendario')->name('calendario.')->group(function () {
    Route::get('/mini', [CalendarioController::class, 'miniCalendario'])->name('mini');
    Route::get('/agenda', [CalendarioController::class, 'agenda'])->name('agenda');
    Route::get('/agenda/vereador/{vereador}', [CalendarioController::class, 'agendaVereador'])->name('agenda.vereador');
    Route::get('/eventos', [CalendarioController::class, 'buscarEventos'])->name('eventos');
    Route::get('/evento/{evento}', [CalendarioController::class, 'show'])->name('evento.show');
    Route::get('/buscar', [CalendarioController::class, 'buscar'])->name('buscar');
    Route::get('/exportar.ics', [CalendarioController::class, 'exportarIcs'])->name('exportar.ics');
    
    // Rotas para usuários logados
    Route::middleware(['auth', 'verified'])->group(function () {
        Route::get('/meus-eventos', [CalendarioController::class, 'meusEventos'])->name('meus-eventos');
        Route::get('/meus-eventos/dados', [CalendarioController::class, 'getEventosEsicUsuario'])->name('meus-eventos.dados');
    });
});

// Rotas administrativas (protegidas por middleware de admin)
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('admin.dashboard');
    
    // Vereadores - CRUD Administrativo
    Route::resource('vereadores', App\Http\Controllers\Admin\VereadorController::class, [
        'as' => 'admin',
        'parameters' => ['vereadores' => 'vereador']
    ]);
    Route::patch('/vereadores/{vereador}/toggle-status', [App\Http\Controllers\Admin\VereadorController::class, 'toggleStatus'])
         ->name('admin.vereadores.toggle-status');
    
    // Rotas para Notícias
    Route::resource('noticias', App\Http\Controllers\Admin\NoticiaController::class, [
        'as' => 'admin'
    ]);
    Route::patch('noticias/{noticia}/toggle-publicacao', [App\Http\Controllers\Admin\NoticiaController::class, 'togglePublicacao'])
        ->name('admin.noticias.toggle-publicacao');
    Route::patch('noticias/{noticia}/toggle-destaque', [App\Http\Controllers\Admin\NoticiaController::class, 'toggleDestaque'])
        ->name('admin.noticias.toggle-destaque');

    // Rotas para Usuários
    Route::middleware(['permission:usuarios.listar'])->group(function () {
        Route::get('users', [App\Http\Controllers\Admin\UserController::class, 'index'])
            ->name('admin.users.index');
        Route::get('users/{user}', [App\Http\Controllers\Admin\UserController::class, 'show'])
            ->name('admin.users.show');
    });
    
    Route::middleware(['permission:usuarios.criar'])->group(function () {
        Route::get('users/create', [App\Http\Controllers\Admin\UserController::class, 'create'])
            ->name('admin.users.create');
        Route::post('users', [App\Http\Controllers\Admin\UserController::class, 'store'])
            ->name('admin.users.store');
    });
    
    Route::middleware(['permission:usuarios.editar'])->group(function () {
        Route::get('users/{user}/edit', [App\Http\Controllers\Admin\UserController::class, 'edit'])
            ->name('admin.users.edit');
        Route::put('users/{user}', [App\Http\Controllers\Admin\UserController::class, 'update'])
            ->name('admin.users.update');
        Route::patch('users/{user}', [App\Http\Controllers\Admin\UserController::class, 'update'])
            ->name('admin.users.update');
        Route::patch('users/{user}/toggle-status', [App\Http\Controllers\Admin\UserController::class, 'toggleStatus'])
            ->name('admin.users.toggle-status');
        Route::post('users/{user}/reset-password', [App\Http\Controllers\Admin\UserController::class, 'resetPassword'])
            ->name('admin.users.reset-password');
    });
    
    Route::middleware(['permission:usuarios.excluir'])->group(function () {
        Route::delete('users/{user}', [App\Http\Controllers\Admin\UserController::class, 'destroy'])
            ->name('admin.users.destroy');
    });
    
    Route::middleware(['permission:usuarios.impersonificar'])->group(function () {
        Route::get('users/{user}/impersonate', [App\Http\Controllers\Admin\UserController::class, 'impersonate'])
            ->name('admin.users.impersonate');
    });
    
    Route::middleware(['permission:usuarios.gerenciar_roles'])->group(function () {
        Route::get('users/{user}/manage-roles', [App\Http\Controllers\Admin\UserController::class, 'manageRoles'])
            ->name('admin.users.manage-roles');
        Route::put('users/{user}/update-roles', [App\Http\Controllers\Admin\UserController::class, 'updateRoles'])
            ->name('admin.users.update-roles');
        Route::get('users/{user}/permissions', [App\Http\Controllers\Admin\UserController::class, 'permissions'])
            ->name('admin.users.permissions');
    });

    // Rotas para Tipos de Usuários (Roles)
    Route::middleware(['permission:roles.listar'])->group(function () {
        Route::get('roles', [App\Http\Controllers\Admin\RoleController::class, 'index'])
            ->name('admin.roles.index');
        Route::get('roles/{role}', [App\Http\Controllers\Admin\RoleController::class, 'show'])
            ->name('admin.roles.show');
    });
    
    Route::middleware(['permission:roles.criar'])->group(function () {
        Route::get('roles/create', [App\Http\Controllers\Admin\RoleController::class, 'create'])
            ->name('admin.roles.create');
        Route::post('roles', [App\Http\Controllers\Admin\RoleController::class, 'store'])
            ->name('admin.roles.store');
    });
    
    Route::middleware(['permission:roles.editar'])->group(function () {
        Route::get('roles/{role}/edit', [App\Http\Controllers\Admin\RoleController::class, 'edit'])
            ->name('admin.roles.edit');
        Route::put('roles/{role}', [App\Http\Controllers\Admin\RoleController::class, 'update'])
            ->name('admin.roles.update');
        Route::patch('roles/{role}', [App\Http\Controllers\Admin\RoleController::class, 'update'])
            ->name('admin.roles.update');
        Route::patch('roles/{role}/toggle-status', [App\Http\Controllers\Admin\RoleController::class, 'toggleStatus'])
            ->name('admin.roles.toggle-status');
    });
    
    Route::middleware(['permission:roles.excluir'])->group(function () {
        Route::delete('roles/{role}', [App\Http\Controllers\Admin\RoleController::class, 'destroy'])
            ->name('admin.roles.destroy');
    });

    // Rotas para Permissões
    Route::middleware(['permission:permissoes.listar'])->group(function () {
        Route::get('permissions', [App\Http\Controllers\Admin\PermissionController::class, 'index'])
            ->name('admin.permissions.index');
        Route::get('permissions/{permission}', [App\Http\Controllers\Admin\PermissionController::class, 'show'])
            ->name('admin.permissions.show');
        Route::get('permissions/by-module', [App\Http\Controllers\Admin\PermissionController::class, 'getByModule'])
            ->name('admin.permissions.by-module');
    });
    
    Route::middleware(['permission:permissoes.criar'])->group(function () {
        Route::get('permissions/create', [App\Http\Controllers\Admin\PermissionController::class, 'create'])
            ->name('admin.permissions.create');
        Route::post('permissions', [App\Http\Controllers\Admin\PermissionController::class, 'store'])
            ->name('admin.permissions.store');
    });
    
    Route::middleware(['permission:permissoes.editar'])->group(function () {
        Route::get('permissions/{permission}/edit', [App\Http\Controllers\Admin\PermissionController::class, 'edit'])
            ->name('admin.permissions.edit');
        Route::put('permissions/{permission}', [App\Http\Controllers\Admin\PermissionController::class, 'update'])
            ->name('admin.permissions.update');
        Route::patch('permissions/{permission}', [App\Http\Controllers\Admin\PermissionController::class, 'update'])
            ->name('admin.permissions.update');
        Route::patch('permissions/{permission}/toggle-status', [App\Http\Controllers\Admin\PermissionController::class, 'toggleStatus'])
            ->name('admin.permissions.toggle-status');
    });
    
    Route::middleware(['permission:permissoes.excluir'])->group(function () {
        Route::delete('permissions/{permission}', [App\Http\Controllers\Admin\PermissionController::class, 'destroy'])
            ->name('admin.permissions.destroy');
    });
    
    // Rotas administrativas para tipos de sessão
    Route::resource('tipos-sessao', App\Http\Controllers\Admin\TipoSessaoController::class, [
        'as' => 'admin'
    ]);

    // Rotas administrativas para sessões
    Route::resource('sessoes', App\Http\Controllers\Admin\SessaoController::class, [
        'as' => 'admin'
    ]);
    Route::patch('sessoes/{sessao}/toggle-status', [App\Http\Controllers\Admin\SessaoController::class, 'toggleStatus'])->name('admin.sessoes.toggle-status');
    Route::get('sessoes/{sessao}/download/{tipo}', [App\Http\Controllers\Admin\SessaoController::class, 'download'])->name('admin.sessoes.download');
    Route::get('sessoes/{sessao}/ata/download', [App\Http\Controllers\Admin\SessaoController::class, 'downloadAta'])->name('admin.sessoes.download-ata');
    Route::get('sessoes/{sessao}/pauta/download', [App\Http\Controllers\Admin\SessaoController::class, 'downloadPauta'])->name('admin.sessoes.download-pauta');

    // Rotas administrativas para projetos de lei
    Route::resource('projetos-lei', App\Http\Controllers\Admin\ProjetoLeiController::class, [
        'as' => 'admin',
        'parameters' => ['projetos-lei' => 'projetoLei']
    ]);
    Route::patch('projetos-lei/{projetoLei}/toggle-status', [App\Http\Controllers\Admin\ProjetoLeiController::class, 'toggleStatus'])->name('admin.projetos-lei.toggle-status');
    Route::get('projetos-lei/{projetoLei}/download/{tipo}', [App\Http\Controllers\Admin\ProjetoLeiController::class, 'download'])->name('admin.projetos-lei.download');

    // Rotas administrativas para comitês de iniciativa popular
    Route::resource('comites-iniciativa-popular', App\Http\Controllers\Admin\ComiteIniciativaPopularController::class, [
        'as' => 'admin',
        'parameters' => ['comites-iniciativa-popular' => 'comite']
    ]);
    Route::patch('comites-iniciativa-popular/{comite}/toggle-status', [App\Http\Controllers\Admin\ComiteIniciativaPopularController::class, 'toggleStatus'])->name('admin.comites-iniciativa-popular.toggle-status');
    Route::get('comites-iniciativa-popular/{comite}/download/{documento}', [App\Http\Controllers\Admin\ComiteIniciativaPopularController::class, 'download'])->name('admin.comites-iniciativa-popular.download');
    Route::patch('comites-iniciativa-popular/{comite}/validar', [App\Http\Controllers\Admin\ComiteIniciativaPopularController::class, 'validar'])->name('admin.comites-iniciativa-popular.validar');
    Route::patch('comites-iniciativa-popular/{comite}/rejeitar', [App\Http\Controllers\Admin\ComiteIniciativaPopularController::class, 'rejeitar'])->name('admin.comites-iniciativa-popular.rejeitar');
    Route::patch('comites-iniciativa-popular/{comite}/arquivar', [App\Http\Controllers\Admin\ComiteIniciativaPopularController::class, 'arquivar'])->name('admin.comites-iniciativa-popular.arquivar');

    // Rotas administrativas para documentos
    Route::resource('documentos', App\Http\Controllers\Admin\DocumentoController::class, [
        'as' => 'admin'
    ]);
    Route::patch('documentos/{documento}/toggle-status', [App\Http\Controllers\Admin\DocumentoController::class, 'toggleStatus'])->name('admin.documentos.toggle-status');
    Route::patch('documentos/{documento}/toggle-destaque', [App\Http\Controllers\Admin\DocumentoController::class, 'toggleDestaque'])->name('admin.documentos.toggle-destaque');
    Route::get('documentos/{documento}/download', [App\Http\Controllers\Admin\DocumentoController::class, 'download'])->name('admin.documentos.download');

    // Rotas administrativas para solicitações e-SIC
    Route::resource('solicitacoes', App\Http\Controllers\Admin\SolicitacaoController::class, [
        'as' => 'admin',
        'parameters' => ['solicitacoes' => 'solicitacao']
    ]);
    Route::patch('solicitacoes/{solicitacao}/toggle-status', [App\Http\Controllers\Admin\SolicitacaoController::class, 'toggleStatus'])->name('admin.solicitacoes.toggle-status');
    Route::patch('solicitacoes/{solicitacao}/toggle-arquivo', [App\Http\Controllers\Admin\SolicitacaoController::class, 'toggleArquivo'])->name('admin.solicitacoes.toggle-arquivo');
    Route::patch('solicitacoes/{solicitacao}/marcar-visualizada', [App\Http\Controllers\Admin\SolicitacaoController::class, 'marcarVisualizada'])->name('admin.solicitacoes.marcar-visualizada');
    Route::get('solicitacoes/{solicitacao}/download', [App\Http\Controllers\Admin\SolicitacaoController::class, 'download'])->name('admin.solicitacoes.download');
    Route::get('solicitacoes/{solicitacao}/download-resposta', [App\Http\Controllers\Admin\SolicitacaoController::class, 'downloadResposta'])->name('admin.solicitacoes.download-resposta');
    
    // Rotas administrativas para manifestações de ouvidoria
    Route::resource('ouvidoria-manifestacoes', App\Http\Controllers\OuvidoriaManifestacaoController::class, [
        'as' => 'admin',
        'parameters' => ['ouvidoria-manifestacoes' => 'manifestacao']
    ]);
    Route::patch('ouvidoria-manifestacoes/{manifestacao}/toggle-status', [App\Http\Controllers\OuvidoriaManifestacaoController::class, 'toggleStatus'])->name('admin.ouvidoria-manifestacoes.toggle-status');
    Route::patch('ouvidoria-manifestacoes/{manifestacao}/atribuir', [App\Http\Controllers\OuvidoriaManifestacaoController::class, 'atribuir'])->name('admin.ouvidoria-manifestacoes.atribuir');
    Route::post('ouvidoria-manifestacoes/{manifestacao}/responder', [App\Http\Controllers\OuvidoriaManifestacaoController::class, 'responder'])->name('admin.ouvidoria-manifestacoes.responder');

    // Rotas administrativas para cartas de serviço
    Route::resource('cartas-servico', App\Http\Controllers\CartaServicoController::class, [
        'as' => 'admin',
        'parameters' => ['cartas-servico' => 'cartaServico']
    ]);
    Route::patch('cartas-servico/{cartaServico}/alterar-status', [App\Http\Controllers\CartaServicoController::class, 'alterarStatus'])->name('admin.cartas-servico.alterar-status');
    Route::get('cartas-servico/{cartaServico}/anexo/{indice}', [App\Http\Controllers\CartaServicoController::class, 'downloadAnexo'])->name('admin.cartas-servico.download-anexo');

    // Rotas administrativas para eventos do calendário
    Route::resource('eventos', App\Http\Controllers\Admin\EventosController::class, [
        'as' => 'admin'
    ]);
    Route::patch('eventos/{evento}/toggle-status', [App\Http\Controllers\Admin\EventosController::class, 'toggleStatus'])->name('admin.eventos.toggle-status');
    Route::patch('eventos/{evento}/toggle-destaque', [App\Http\Controllers\Admin\EventosController::class, 'toggleDestaque'])->name('admin.eventos.toggle-destaque');
    Route::post('eventos/{evento}/duplicate', [App\Http\Controllers\Admin\EventosController::class, 'duplicate'])->name('admin.eventos.duplicate');
    Route::get('eventos/exportar-csv', [App\Http\Controllers\Admin\EventosController::class, 'exportarCsv'])->name('admin.eventos.exportar-csv');
    Route::post('eventos/sincronizar', [App\Http\Controllers\Admin\EventosController::class, 'sincronizar'])->name('admin.eventos.sincronizar');
    Route::get('eventos/dashboard', [App\Http\Controllers\Admin\EventosController::class, 'dashboard'])->name('admin.eventos.dashboard');

    // Rotas administrativas para páginas de conteúdo
    Route::resource('paginas-conteudo', App\Http\Controllers\Admin\PaginaConteudoController::class, [
        'as' => 'admin',
        'parameters' => ['paginas-conteudo' => 'pagina']
    ]);
    Route::patch('paginas-conteudo/{pagina}/toggle-status', [App\Http\Controllers\Admin\PaginaConteudoController::class, 'toggleStatus'])->name('admin.paginas-conteudo.toggle-status');

    Route::post('cartas-servico/{cartaServico}/duplicar', [App\Http\Controllers\CartaServicoController::class, 'duplicar'])->name('admin.cartas-servico.duplicar');
    Route::get('cartas-servico-relatorio', [App\Http\Controllers\CartaServicoController::class, 'relatorio'])->name('admin.cartas-servico.relatorio');
    Route::get('cartas-servico-exportar', [App\Http\Controllers\CartaServicoController::class, 'exportar'])->name('admin.cartas-servico.exportar');

    // Rotas administrativas para usuários E-SIC
    Route::resource('esic-usuarios', App\Http\Controllers\Admin\EsicUsuarioController::class, [
        'as' => 'admin',
        'parameters' => ['esic-usuarios' => 'usuario']
    ]);
    Route::patch('esic-usuarios/{usuario}/toggle-status', [App\Http\Controllers\Admin\EsicUsuarioController::class, 'toggleStatus'])->name('admin.esic-usuarios.toggle-status');
    Route::post('esic-usuarios/{usuario}/resend-verification', [App\Http\Controllers\Admin\EsicUsuarioController::class, 'resendVerification'])->name('admin.esic-usuarios.resend-verification');
    Route::post('esic-usuarios/{usuario}/reset-password', [App\Http\Controllers\Admin\EsicUsuarioController::class, 'resetPassword'])->name('admin.esic-usuarios.reset-password');
    Route::get('esic-usuarios-relatorios', [App\Http\Controllers\Admin\EsicUsuarioController::class, 'relatorios'])->name('admin.esic-usuarios.relatorios');
    Route::get('esic-usuarios-exportar', [App\Http\Controllers\Admin\EsicUsuarioController::class, 'exportar'])->name('admin.esic-usuarios.exportar');

    // Rotas administrativas para ouvidores
    Route::resource('ouvidores', App\Http\Controllers\Admin\OuvidorController::class, [
        'as' => 'admin'
    ]);
    Route::patch('ouvidores/{ouvidor}/toggle-status', [App\Http\Controllers\Admin\OuvidorController::class, 'toggleStatus'])->name('admin.ouvidores.toggle-status');
    Route::get('ouvidores-relatorios', [App\Http\Controllers\Admin\OuvidorController::class, 'relatorios'])->name('admin.ouvidores.relatorios');
    Route::get('ouvidores-exportar', [App\Http\Controllers\Admin\OuvidorController::class, 'exportar'])->name('admin.ouvidores.exportar');

    // Rotas administrativas para relatórios
    Route::get('relatorios', [App\Http\Controllers\Admin\RelatorioController::class, 'index'])->name('admin.relatorios.index');
    Route::get('relatorios/geral', [App\Http\Controllers\Admin\RelatorioController::class, 'geral'])->name('admin.relatorios.geral');
    Route::get('relatorios/manifestacoes', [App\Http\Controllers\Admin\RelatorioController::class, 'manifestacoes'])->name('admin.relatorios.manifestacoes');
    Route::get('relatorios/usuarios', [App\Http\Controllers\Admin\RelatorioController::class, 'usuarios'])->name('admin.relatorios.usuarios');
    Route::get('relatorios/ouvidores', [App\Http\Controllers\Admin\RelatorioController::class, 'ouvidores'])->name('admin.relatorios.ouvidores');
    Route::get('relatorios/sessoes', [App\Http\Controllers\Admin\RelatorioController::class, 'sessoes'])->name('admin.relatorios.sessoes');
    Route::get('relatorios/projetos', [App\Http\Controllers\Admin\RelatorioController::class, 'projetos'])->name('admin.relatorios.projetos');
    Route::get('relatorios/documentos', [App\Http\Controllers\Admin\RelatorioController::class, 'documentos'])->name('admin.relatorios.documentos');
    Route::get('relatorios/noticias', [App\Http\Controllers\Admin\RelatorioController::class, 'noticias'])->name('admin.relatorios.noticias');
    Route::get('relatorios/exportar', [App\Http\Controllers\Admin\RelatorioController::class, 'exportar'])->name('admin.relatorios.exportar');

    // Rotas administrativas para configurações
    Route::get('configuracoes', [App\Http\Controllers\Admin\ConfiguracaoController::class, 'index'])->name('admin.configuracoes.index');
    Route::get('configuracoes/edit', [App\Http\Controllers\Admin\ConfiguracaoController::class, 'edit'])->name('admin.configuracoes.edit');
    Route::put('configuracoes', [App\Http\Controllers\Admin\ConfiguracaoController::class, 'update'])->name('admin.configuracoes.update');
    Route::post('configuracoes/clear-cache', [App\Http\Controllers\Admin\ConfiguracaoController::class, 'clearCache'])->name('admin.configuracoes.clear-cache');
    Route::post('configuracoes/optimize', [App\Http\Controllers\Admin\ConfiguracaoController::class, 'optimize'])->name('admin.configuracoes.optimize');
    Route::get('configuracoes/info', [App\Http\Controllers\Admin\ConfiguracaoController::class, 'info'])->name('admin.configuracoes.info');
    Route::get('configuracoes/logs', [App\Http\Controllers\Admin\ConfiguracaoController::class, 'logs'])->name('admin.configuracoes.logs');
    Route::post('configuracoes/clear-logs', [App\Http\Controllers\Admin\ConfiguracaoController::class, 'clearLogs'])->name('admin.configuracoes.clear-logs');

    // Rotas administrativas para configurações gerais (brasão, logo, contatos)
    Route::resource('configuracao-geral', App\Http\Controllers\Admin\ConfiguracaoGeralController::class, [
        'as' => 'admin'
    ]);

    // Rotas administrativas para menus
    Route::resource('menus', App\Http\Controllers\Admin\MenuController::class, [
        'as' => 'admin'
    ]);
    Route::patch('menus/{menu}/toggle-status', [App\Http\Controllers\Admin\MenuController::class, 'toggleStatus'])->name('admin.menus.toggle-status');
    Route::post('menus/reorder', [App\Http\Controllers\Admin\MenuController::class, 'reorder'])->name('admin.menus.reorder');

    // Rotas administrativas para licitações
    Route::resource('licitacoes', App\Http\Controllers\LicitacaoController::class, [
        'as' => 'admin',
        'parameters' => ['licitacoes' => 'licitacao']
    ]);
    Route::get('licitacoes/documento/{documento}/download', [App\Http\Controllers\LicitacaoController::class, 'downloadDocumento'])->name('admin.licitacoes.documento.download');
    Route::delete('licitacoes/documento/{documento}', [App\Http\Controllers\LicitacaoController::class, 'excluirDocumento'])->name('admin.licitacoes.documento.destroy');
    
    // Rotas administrativas para acesso rápido
    Route::resource('acesso-rapido', App\Http\Controllers\Admin\AcessoRapidoController::class, [
        'as' => 'admin',
        'parameters' => ['acesso-rapido' => 'acessoRapido']
    ]);
    Route::patch('acesso-rapido/{acessoRapido}/toggle-status', [App\Http\Controllers\Admin\AcessoRapidoController::class, 'toggleStatus'])->name('admin.acesso-rapido.toggle-status');
    Route::post('acesso-rapido/update-order', [App\Http\Controllers\Admin\AcessoRapidoController::class, 'updateOrder'])->name('admin.acesso-rapido.update-order');
    
    // Rotas administrativas para tipos de contrato
    Route::resource('tipos-contrato', App\Http\Controllers\Admin\TipoContratoController::class, [
        'as' => 'admin',
        'parameters' => ['tipos-contrato' => 'tipoContrato']
    ]);
    Route::patch('tipos-contrato/{tipoContrato}/toggle-status', [App\Http\Controllers\Admin\TipoContratoController::class, 'toggleStatus'])->name('admin.tipos-contrato.toggle-status');
    
    // Rotas administrativas para contratos
    Route::resource('contratos', App\Http\Controllers\Admin\ContratoController::class, [
        'as' => 'admin'
    ]);
    Route::patch('contratos/{contrato}/toggle-status', [App\Http\Controllers\Admin\ContratoController::class, 'toggleStatus'])->name('admin.contratos.toggle-status');
    Route::get('contratos/{contrato}/download', [App\Http\Controllers\Admin\ContratoController::class, 'download'])->name('admin.contratos.download');
    Route::delete('contratos/{contrato}/remove-arquivo', [App\Http\Controllers\Admin\ContratoController::class, 'removeArquivo'])->name('admin.contratos.remove-arquivo');
    Route::get('contratos/{contrato}/aditivos', [App\Http\Controllers\Admin\ContratoController::class, 'aditivos'])->name('admin.contratos.aditivos');
    Route::post('contratos/{contrato}/aditivos', [App\Http\Controllers\Admin\ContratoController::class, 'storeAditivo'])->name('admin.contratos.aditivos.store');
    Route::get('contratos/{contrato}/aditivos/{aditivo}', [App\Http\Controllers\Admin\ContratoController::class, 'showAditivo'])->name('admin.contratos.aditivos.show');
    Route::get('contratos/{contrato}/aditivos/{aditivo}/edit', [App\Http\Controllers\Admin\ContratoController::class, 'editAditivo'])->name('admin.contratos.aditivos.edit');
    Route::put('contratos/{contrato}/aditivos/{aditivo}', [App\Http\Controllers\Admin\ContratoController::class, 'updateAditivo'])->name('admin.contratos.aditivos.update');
    Route::delete('contratos/{contrato}/aditivos/{aditivo}', [App\Http\Controllers\Admin\ContratoController::class, 'destroyAditivo'])->name('admin.contratos.aditivos.destroy');
    Route::get('contratos/{contrato}/aditivos/{aditivo}/download', [App\Http\Controllers\Admin\ContratoController::class, 'downloadAditivo'])->name('admin.contratos.aditivos.download');
    
    Route::post('contratos/{contrato}/fiscalizacoes', [App\Http\Controllers\Admin\ContratoController::class, 'storeFiscalizacao'])->name('admin.contratos.fiscalizacoes.store');
    Route::get('contratos/{contrato}/fiscalizacoes/{fiscalizacao}/download', [App\Http\Controllers\Admin\ContratoController::class, 'downloadFiscalizacaoPdf'])->name('admin.contratos.fiscalizacoes.download');
    
    // Rotas administrativas para slides do hero section
    Route::resource('slides', App\Http\Controllers\Admin\SlideController::class, [
        'as' => 'admin'
    ]);
    Route::patch('slides/{slide}/toggle-status', [App\Http\Controllers\Admin\SlideController::class, 'toggleStatus'])->name('admin.slides.toggle-status');
    
    // Rotas administrativas para configurações do hero section
    Route::get('hero-config', [App\Http\Controllers\Admin\HeroConfigurationController::class, 'index'])->name('admin.hero-config.index');
    Route::get('hero-config/edit', [App\Http\Controllers\Admin\HeroConfigurationController::class, 'edit'])->name('admin.hero-config.edit');
    Route::put('hero-config', [App\Http\Controllers\Admin\HeroConfigurationController::class, 'update'])->name('admin.hero-config.update');
    
    // Futuras rotas administrativas podem ser adicionadas aqui
    // Route::resource('users', UserController::class);
    // Route::resource('noticias', NoticiaController::class);
});

// ========================================
// ROTAS DO SISTEMA DE LEIS
// ========================================

// Rotas públicas para visualização de leis
Route::prefix('leis')->name('leis.')->group(function () {
    Route::get('/', [LeisController::class, 'index'])->name('index');
    Route::get('/download/{id}', [LeisController::class, 'downloadPdf'])->name('download');
    Route::get('/{slug}', [LeisController::class, 'show'])->name('show');
});

// Rota AJAX para busca de leis (integração com motor de busca geral)
Route::get('/api/leis/buscar', [LeisController::class, 'buscarAjax'])->name('leis.buscar.ajax');

// Rotas administrativas para gestão de leis (protegidas por autenticação)
Route::middleware(['auth'])->prefix('admin/leis')->name('admin.leis.')->group(function () {
    Route::get('/', [LeisController::class, 'index'])->name('index');
    Route::get('/create', [LeisController::class, 'create'])->name('create');
    Route::post('/', [LeisController::class, 'store'])->name('store');
    Route::get('/{id}', [LeisController::class, 'adminShow'])->name('show');
    Route::get('/{id}/edit', [LeisController::class, 'edit'])->name('edit');
    Route::put('/{id}', [LeisController::class, 'update'])->name('update');
    Route::delete('/{id}', [LeisController::class, 'destroy'])->name('destroy');
});

// Rotas para servir arquivos CSS e JS
Route::get('/css/{file}', function ($file) {
    $path = public_path('css/' . $file);
    if (file_exists($path)) {
        return response()->file($path, [
            'Content-Type' => 'text/css'
        ]);
    }
    abort(404);
})->where('file', '.*\.css');

Route::get('/js/{file}', function ($file) {
    $path = public_path('js/' . $file);
    if (file_exists($path)) {
        return response()->file($path, [
            'Content-Type' => 'application/javascript'
        ]);
    }
    abort(404);
})->where('file', '.*\.js');

// Rota pública para download de PDF de fiscalização
Route::get('/contratos/{contrato}/fiscalizacoes/{fiscalizacao}/pdf', [App\Http\Controllers\Admin\ContratoController::class, 'downloadFiscalizacaoPdfPublico'])->name('contratos.fiscalizacoes.pdf.publico');

// Páginas institucionais dinâmicas
Route::get('/pagina/{slug}', [App\Http\Controllers\PaginaController::class, 'show'])->name('paginas.show');

// Páginas institucionais (rotas antigas mantidas para compatibilidade)
Route::get('/sobre/historia', [App\Http\Controllers\PaginaController::class, 'historia'])->name('paginas.historia');
Route::get('/sobre/estrutura', [App\Http\Controllers\PaginaController::class, 'estrutura'])->name('paginas.estrutura');
Route::get('/sobre/regimento', [App\Http\Controllers\PaginaController::class, 'regimento'])->name('paginas.regimento');
Route::get('/sobre/missao', [App\Http\Controllers\PaginaController::class, 'missao'])->name('paginas.missao');
Route::get('/contato', [App\Http\Controllers\PaginaController::class, 'contato'])->name('paginas.contato');

// Rota temporária para testar estilos de paginação
Route::get('/test-pagination', function () {
    return view('test-pagination');
});

// SEO - Sitemap
Route::get('/sitemap.xml', [App\Http\Controllers\SitemapController::class, 'index'])->name('sitemap');
