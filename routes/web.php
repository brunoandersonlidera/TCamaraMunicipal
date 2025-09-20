<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VereadorController;
use App\Http\Controllers\SessaoController;
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
