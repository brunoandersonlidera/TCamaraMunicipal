<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VereadorController;
use App\Http\Controllers\AuthController;
use App\Models\Vereador;
use App\Models\User;

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
        
    return view('welcome', compact('presidente', 'vereadores'));
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

// Rotas Administrativas (protegidas por middleware admin)
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('admin.dashboard');
    
    // Futuras rotas administrativas podem ser adicionadas aqui
    // Route::resource('users', UserController::class);
    // Route::resource('noticias', NoticiaController::class);
});

// Rotas dos vereadores (públicas)
Route::get('/vereadores', [VereadorController::class, 'index'])->name('vereadores.index');
Route::get('/vereadores/{id}', [VereadorController::class, 'show'])->name('vereadores.show');
