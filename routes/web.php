<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VereadorController;
use App\Http\Controllers\SessaoController;
use App\Http\Controllers\UserAreaController;
use App\Http\Controllers\ImageUploadController;
use App\Http\Controllers\OuvidoriaController;
use App\Http\Controllers\AuthController;
use App\Models\Vereador;
use App\Models\User;
use App\Models\Sessao;

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
        
    return view('welcome', compact('presidente', 'vereadores', 'totalVereadores', 'projetos', 'sessoes', 'leis', 'sessoesGravadas', 'sessaoAoVivo', 'sessaoDestaque'));
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

// Rotas do E-SIC (públicas)
Route::get('/esic', [App\Http\Controllers\EsicController::class, 'index'])->name('esic.index');
Route::get('/esic/nova-solicitacao', [App\Http\Controllers\EsicController::class, 'create'])->name('esic.create');
Route::post('/esic/solicitacao', [App\Http\Controllers\EsicController::class, 'store'])->name('esic.store');
Route::get('/esic/consultar', [App\Http\Controllers\EsicController::class, 'consultar'])->name('esic.consultar');
Route::post('/esic/consultar', [App\Http\Controllers\EsicController::class, 'consultar'])->name('esic.consultar.post');
Route::get('/esic/solicitacao/{protocolo}', [App\Http\Controllers\EsicController::class, 'show'])->name('esic.show');
Route::get('/esic/sobre', [App\Http\Controllers\EsicController::class, 'sobre'])->name('esic.sobre');
Route::get('/esic/faq', [App\Http\Controllers\EsicController::class, 'faq'])->name('esic.faq');

// Rotas para Cartas de Serviço
Route::get('/cartas-servico', [App\Http\Controllers\CartaServicoController::class, 'indexPublico'])->name('cartas-servico.index');
Route::get('/cartas-servico/{slug}', [App\Http\Controllers\CartaServicoController::class, 'showPublico'])->name('cartas-servico.show');

// Rotas dos vereadores (públicas)
Route::get('/vereadores', [VereadorController::class, 'index'])->name('vereadores.index');
Route::get('/vereadores/{id}', [VereadorController::class, 'show'])->name('vereadores.show');

// Rotas das sessões (públicas)
Route::get('/sessoes', [SessaoController::class, 'index'])->name('sessoes.index');
Route::get('/tv-camara', [SessaoController::class, 'tvCamara'])->name('tv-camara');
Route::get('/sessoes/{sessao}', [SessaoController::class, 'show'])->name('sessoes.show');
Route::get('/sessoes/{sessao}/ata/download', [SessaoController::class, 'downloadAta'])->name('sessoes.download-ata');
Route::get('/sessoes/{sessao}/pauta/download', [SessaoController::class, 'downloadPauta'])->name('sessoes.download-pauta');
Route::get('/sessoes/calendario', [SessaoController::class, 'calendario'])->name('sessoes.calendario');
Route::get('/ao-vivo', [SessaoController::class, 'aoVivo'])->name('sessoes.ao-vivo');

// Rotas Administrativas (protegidas por middleware admin)
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('admin.dashboard');
    
    // Vereadores - CRUD Administrativo
    Route::resource('vereadores', App\Http\Controllers\Admin\VereadorController::class, [
        'as' => 'admin'
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
    Route::resource('users', App\Http\Controllers\Admin\UserController::class, [
        'as' => 'admin'
    ]);
    Route::patch('users/{user}/toggle-status', [App\Http\Controllers\Admin\UserController::class, 'toggleStatus'])
        ->name('admin.users.toggle-status');
    Route::post('users/{user}/reset-password', [App\Http\Controllers\Admin\UserController::class, 'resetPassword'])
        ->name('admin.users.reset-password');
    Route::get('users/{user}/impersonate', [App\Http\Controllers\Admin\UserController::class, 'impersonate'])
        ->name('admin.users.impersonate');
    
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
        'as' => 'admin'
    ]);
    Route::patch('projetos-lei/{projetoLei}/toggle-status', [App\Http\Controllers\Admin\ProjetoLeiController::class, 'toggleStatus'])->name('admin.projetos-lei.toggle-status');
    Route::get('projetos-lei/{projetoLei}/download/{tipo}', [App\Http\Controllers\Admin\ProjetoLeiController::class, 'download'])->name('admin.projetos-lei.download');

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

    // Rotas administrativas para menus
    Route::resource('menus', App\Http\Controllers\Admin\MenuController::class, [
        'as' => 'admin'
    ]);
    Route::patch('menus/{menu}/toggle-status', [App\Http\Controllers\Admin\MenuController::class, 'toggleStatus'])->name('admin.menus.toggle-status');
    Route::post('menus/reorder', [App\Http\Controllers\Admin\MenuController::class, 'reorder'])->name('admin.menus.reorder');
    
    // Futuras rotas administrativas podem ser adicionadas aqui
    // Route::resource('users', UserController::class);
    // Route::resource('noticias', NoticiaController::class);
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
