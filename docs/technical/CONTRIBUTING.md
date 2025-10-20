# Guia de Contribuição - TCamaraMunicipal

## Bem-vindo!

Obrigado por seu interesse em contribuir com o projeto TCamaraMunicipal! Este guia fornece todas as informações necessárias para contribuir de forma efetiva com o desenvolvimento do sistema.

## Índice

1. [Código de Conduta](#código-de-conduta)
2. [Como Contribuir](#como-contribuir)
3. [Configuração do Ambiente](#configuração-do-ambiente)
4. [Padrões de Desenvolvimento](#padrões-de-desenvolvimento)
5. [Processo de Pull Request](#processo-de-pull-request)
6. [Testes](#testes)
7. [Documentação](#documentação)
8. [Reportar Bugs](#reportar-bugs)
9. [Sugerir Melhorias](#sugerir-melhorias)
10. [Comunidade](#comunidade)

## Código de Conduta

### Nossos Compromissos

Como membros, contribuidores e líderes, nos comprometemos a fazer da participação em nossa comunidade uma experiência livre de assédio para todos, independentemente de idade, tamanho corporal, deficiência visível ou invisível, etnia, características sexuais, identidade e expressão de gênero, nível de experiência, educação, status socioeconômico, nacionalidade, aparência pessoal, raça, religião ou identidade e orientação sexual.

### Comportamentos Esperados

- Demonstrar empatia e bondade com outras pessoas
- Ser respeitoso com opiniões, pontos de vista e experiências diferentes
- Dar e aceitar feedback construtivo de forma elegante
- Aceitar responsabilidade e pedir desculpas aos afetados por nossos erros
- Focar no que é melhor não apenas para nós como indivíduos, mas para a comunidade como um todo

### Comportamentos Inaceitáveis

- Uso de linguagem ou imagens sexualizadas e atenção sexual indesejada
- Trolling, comentários insultuosos ou depreciativos e ataques pessoais ou políticos
- Assédio público ou privado
- Publicar informações privadas de outros sem permissão explícita
- Outras condutas que poderiam ser consideradas inadequadas em um ambiente profissional

## Como Contribuir

### Tipos de Contribuição

Valorizamos todos os tipos de contribuição:

#### 🐛 Correção de Bugs
- Identifique e corrija problemas no código
- Melhore a estabilidade do sistema
- Otimize performance

#### ✨ Novas Funcionalidades
- Implemente novos recursos
- Melhore funcionalidades existentes
- Adicione integrações

#### 📚 Documentação
- Melhore a documentação técnica
- Crie tutoriais e guias
- Traduza documentação

#### 🧪 Testes
- Escreva testes unitários
- Crie testes de integração
- Melhore cobertura de testes

#### 🎨 Interface e UX
- Melhore o design da interface
- Otimize a experiência do usuário
- Implemente responsividade

#### 🔧 DevOps e Infraestrutura
- Melhore scripts de deploy
- Otimize configurações
- Automatize processos

## Configuração do Ambiente

### Pré-requisitos

- **PHP:** 8.2 ou superior
- **Composer:** 2.x
- **Node.js:** 18.x ou superior
- **NPM:** 9.x ou superior
- **MySQL:** 8.0 ou superior (ou SQLite para desenvolvimento)
- **Git:** 2.x

### Configuração Inicial

1. **Fork do Repositório**
   ```bash
   # Clone seu fork
   git clone https://github.com/SEU_USUARIO/TCamaraMunicipal.git
   cd TCamaraMunicipal
   
   # Adicione o repositório original como upstream
   git remote add upstream https://github.com/ORIGINAL_REPO/TCamaraMunicipal.git
   ```

2. **Instalação de Dependências**
   ```bash
   # Dependências PHP
   composer install
   
   # Dependências Node.js
   npm install
   ```

3. **Configuração do Ambiente**
   ```bash
   # Copie o arquivo de ambiente
   cp .env.example .env
   
   # Gere a chave da aplicação
   php artisan key:generate
   
   # Configure o banco de dados no .env
   # Para desenvolvimento, você pode usar SQLite:
   DB_CONNECTION=sqlite
   DB_DATABASE=database/database.sqlite
   ```

4. **Configuração do Banco de Dados**
   ```bash
   # Crie o arquivo SQLite (se usando SQLite)
   touch database/database.sqlite
   
   # Execute as migrações
   php artisan migrate
   
   # Execute os seeders
   php artisan db:seed
   ```

5. **Compilação de Assets**
   ```bash
   # Desenvolvimento
   npm run dev
   
   # Ou modo watch
   npm run watch
   ```

6. **Iniciar o Servidor**
   ```bash
   php artisan serve
   ```

### Configuração do IDE

#### VS Code (Recomendado)

Instale as seguintes extensões:

```json
{
  "recommendations": [
    "bmewburn.vscode-intelephense-client",
    "bradlc.vscode-tailwindcss",
    "ms-vscode.vscode-typescript-next",
    "esbenp.prettier-vscode",
    "ryannaddy.laravel-artisan",
    "onecentlin.laravel-blade",
    "amiralizadeh9480.laravel-extra-intellisense"
  ]
}
```

#### Configurações do Workspace

```json
{
  "editor.formatOnSave": true,
  "editor.codeActionsOnSave": {
    "source.fixAll.eslint": true
  },
  "php.suggest.basic": false,
  "intelephense.files.maxSize": 5000000,
  "blade.format.enable": true
}
```

## Padrões de Desenvolvimento

### Padrões de Código PHP

#### PSR-12 Compliance
```php
<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Noticia;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class NoticiaController extends Controller
{
    public function index(Request $request): Response
    {
        $noticias = Noticia::query()
            ->when($request->filled('search'), function ($query) use ($request) {
                $query->where('titulo', 'like', "%{$request->search}%");
            })
            ->paginate(15);

        return response()->view('admin.noticias.index', compact('noticias'));
    }
}
```

#### Nomenclatura

**Classes:**
```php
// ✅ Correto
class NoticiaController extends Controller
class UserService
class DocumentRepository

// ❌ Incorreto
class noticiaController
class userservice
class document_repository
```

**Métodos:**
```php
// ✅ Correto
public function createNoticia()
public function updateUserProfile()
public function deleteDocument()

// ❌ Incorreto
public function CreateNoticia()
public function update_user_profile()
public function delete_document()
```

**Variáveis:**
```php
// ✅ Correto
$userName = 'João Silva';
$totalNoticias = 10;
$isActive = true;

// ❌ Incorreto
$user_name = 'João Silva';
$TotalNoticias = 10;
$IsActive = true;
```

#### Documentação de Código

```php
/**
 * Cria uma nova notícia no sistema.
 *
 * @param  \Illuminate\Http\Request  $request
 * @return \Illuminate\Http\Response
 * 
 * @throws \Illuminate\Validation\ValidationException
 */
public function store(Request $request): Response
{
    $validated = $request->validate([
        'titulo' => 'required|string|max:255',
        'conteudo' => 'required|string',
        'status' => 'required|in:rascunho,publicado',
    ]);

    $noticia = Noticia::create($validated);

    return redirect()
        ->route('admin.noticias.show', $noticia)
        ->with('success', 'Notícia criada com sucesso!');
}
```

### Padrões de Frontend

#### JavaScript/TypeScript

```javascript
// ✅ Correto - ES6+
const fetchNoticias = async (page = 1) => {
    try {
        const response = await fetch(`/api/noticias?page=${page}`);
        const data = await response.json();
        return data;
    } catch (error) {
        console.error('Erro ao buscar notícias:', error);
        throw error;
    }
};

// Event listeners
document.addEventListener('DOMContentLoaded', () => {
    const searchForm = document.getElementById('search-form');
    if (searchForm) {
        searchForm.addEventListener('submit', handleSearch);
    }
});
```

#### CSS/SCSS

```scss
// ✅ Correto - BEM Methodology
.noticia-card {
    @apply bg-white rounded-lg shadow-md p-6;
    
    &__title {
        @apply text-xl font-bold text-gray-800 mb-2;
    }
    
    &__content {
        @apply text-gray-600 line-clamp-3;
    }
    
    &__meta {
        @apply flex items-center justify-between mt-4 text-sm text-gray-500;
    }
    
    &--featured {
        @apply border-l-4 border-blue-500;
    }
}
```

#### Blade Templates

```blade
{{-- ✅ Correto --}}
@extends('layouts.admin')

@section('title', 'Gerenciar Notícias')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">{{ __('Notícias') }}</h3>
                    <a href="{{ route('admin.noticias.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>
                        {{ __('Nova Notícia') }}
                    </a>
                </div>
                
                <div class="card-body">
                    @if($noticias->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>{{ __('Título') }}</th>
                                        <th>{{ __('Autor') }}</th>
                                        <th>{{ __('Status') }}</th>
                                        <th>{{ __('Data') }}</th>
                                        <th>{{ __('Ações') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($noticias as $noticia)
                                        <tr>
                                            <td>{{ $noticia->titulo }}</td>
                                            <td>{{ $noticia->autor->name }}</td>
                                            <td>
                                                <span class="badge bg-{{ $noticia->status === 'publicado' ? 'success' : 'warning' }}">
                                                    {{ ucfirst($noticia->status) }}
                                                </span>
                                            </td>
                                            <td>{{ $noticia->created_at->format('d/m/Y H:i') }}</td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('admin.noticias.show', $noticia) }}" 
                                                       class="btn btn-sm btn-outline-primary">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('admin.noticias.edit', $noticia) }}" 
                                                       class="btn btn-sm btn-outline-secondary">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        {{ $noticias->links() }}
                    @else
                        <div class="text-center py-4">
                            <p class="text-muted">{{ __('Nenhuma notícia encontrada.') }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
```

### Padrões de Banco de Dados

#### Migrations

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('noticias', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->string('slug')->unique();
            $table->text('resumo')->nullable();
            $table->longText('conteudo');
            $table->string('imagem_destaque')->nullable();
            $table->enum('status', ['rascunho', 'publicado', 'arquivado'])->default('rascunho');
            $table->timestamp('data_publicacao')->nullable();
            $table->foreignId('autor_id')->constrained('users')->onDelete('cascade');
            $table->boolean('destaque')->default(false);
            $table->json('tags')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            // Índices
            $table->index(['status', 'data_publicacao']);
            $table->index(['autor_id', 'status']);
            $table->index('destaque');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('noticias');
    }
};
```

#### Models

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Noticia extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'titulo',
        'slug',
        'resumo',
        'conteudo',
        'imagem_destaque',
        'status',
        'data_publicacao',
        'autor_id',
        'destaque',
        'tags',
    ];

    protected $casts = [
        'data_publicacao' => 'datetime',
        'destaque' => 'boolean',
        'tags' => 'array',
    ];

    protected $dates = [
        'data_publicacao',
        'deleted_at',
    ];

    // Relacionamentos
    public function autor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'autor_id');
    }

    // Scopes
    public function scopePublicadas($query)
    {
        return $query->where('status', 'publicado')
                    ->where('data_publicacao', '<=', now());
    }

    public function scopeDestaque($query)
    {
        return $query->where('destaque', true);
    }

    // Mutators
    public function setTituloAttribute($value)
    {
        $this->attributes['titulo'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    // Accessors
    public function getResumoAttribute($value)
    {
        return $value ?: Str::limit(strip_tags($this->conteudo), 150);
    }
}
```

## Processo de Pull Request

### 1. Preparação

```bash
# Sincronize com o repositório upstream
git fetch upstream
git checkout main
git merge upstream/main

# Crie uma nova branch para sua feature
git checkout -b feature/nome-da-feature
```

### 2. Desenvolvimento

```bash
# Faça commits pequenos e frequentes
git add .
git commit -m "feat: adiciona validação de email único"

# Mantenha sua branch atualizada
git fetch upstream
git rebase upstream/main
```

### 3. Padrões de Commit

Utilizamos o padrão [Conventional Commits](https://www.conventionalcommits.org/):

```bash
# Tipos de commit
feat: nova funcionalidade
fix: correção de bug
docs: documentação
style: formatação, ponto e vírgula, etc
refactor: refatoração de código
test: adição ou correção de testes
chore: tarefas de manutenção

# Exemplos
git commit -m "feat: adiciona sistema de notificações por email"
git commit -m "fix: corrige validação de CPF no cadastro"
git commit -m "docs: atualiza README com instruções de instalação"
git commit -m "test: adiciona testes para controller de usuários"
```

### 4. Checklist Pré-PR

Antes de abrir um Pull Request, verifique:

- [ ] ✅ Código segue os padrões estabelecidos
- [ ] ✅ Testes passam (`php artisan test`)
- [ ] ✅ Linting passa (`composer lint`)
- [ ] ✅ Documentação atualizada (se necessário)
- [ ] ✅ Commits seguem o padrão Conventional Commits
- [ ] ✅ Branch está atualizada com main
- [ ] ✅ Não há conflitos de merge

### 5. Criando o Pull Request

#### Template de PR

```markdown
## Descrição

Breve descrição das mudanças implementadas.

## Tipo de Mudança

- [ ] 🐛 Correção de bug
- [ ] ✨ Nova funcionalidade
- [ ] 💥 Breaking change
- [ ] 📚 Documentação
- [ ] 🧪 Testes
- [ ] 🔧 Refatoração

## Como Testar

1. Faça checkout da branch
2. Execute `composer install && npm install`
3. Execute `php artisan migrate:fresh --seed`
4. Acesse `/admin/noticias`
5. Teste a funcionalidade X

## Screenshots (se aplicável)

![Screenshot](url-da-imagem)

## Checklist

- [ ] Meu código segue os padrões do projeto
- [ ] Realizei uma auto-revisão do código
- [ ] Comentei partes complexas do código
- [ ] Fiz as mudanças correspondentes na documentação
- [ ] Minhas mudanças não geram novos warnings
- [ ] Adicionei testes que provam que minha correção é efetiva ou que minha funcionalidade funciona
- [ ] Testes unitários novos e existentes passam localmente
```

### 6. Revisão de Código

#### Para Revisores

- Verifique a funcionalidade
- Teste localmente
- Revise a qualidade do código
- Verifique se segue os padrões
- Teste edge cases
- Verifique performance

#### Para Autores

- Responda aos comentários
- Faça as correções solicitadas
- Mantenha a discussão construtiva
- Atualize a documentação se necessário

## Testes

### Estrutura de Testes

```
tests/
├── Feature/           # Testes de integração
│   ├── Admin/
│   ├── Auth/
│   └── Api/
├── Unit/             # Testes unitários
│   ├── Models/
│   ├── Services/
│   └── Helpers/
└── Browser/          # Testes E2E (Dusk)
    ├── Admin/
    └── Public/
```

### Testes Unitários

```php
<?php

namespace Tests\Unit\Models;

use App\Models\Noticia;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NoticiaTest extends TestCase
{
    use RefreshDatabase;

    public function test_noticia_pode_ser_criada()
    {
        $user = User::factory()->create();
        
        $noticia = Noticia::create([
            'titulo' => 'Título de Teste',
            'conteudo' => 'Conteúdo de teste',
            'status' => 'rascunho',
            'autor_id' => $user->id,
        ]);

        $this->assertDatabaseHas('noticias', [
            'titulo' => 'Título de Teste',
            'slug' => 'titulo-de-teste',
        ]);
    }

    public function test_scope_publicadas_retorna_apenas_noticias_publicadas()
    {
        $user = User::factory()->create();
        
        Noticia::factory()->create([
            'status' => 'publicado',
            'data_publicacao' => now()->subDay(),
            'autor_id' => $user->id,
        ]);
        
        Noticia::factory()->create([
            'status' => 'rascunho',
            'autor_id' => $user->id,
        ]);

        $publicadas = Noticia::publicadas()->get();

        $this->assertCount(1, $publicadas);
        $this->assertEquals('publicado', $publicadas->first()->status);
    }
}
```

### Testes de Feature

```php
<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use App\Models\Noticia;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NoticiaControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->admin = User::factory()->admin()->create();
    }

    public function test_admin_pode_visualizar_lista_de_noticias()
    {
        $this->actingAs($this->admin);
        
        Noticia::factory()->count(3)->create(['autor_id' => $this->admin->id]);

        $response = $this->get(route('admin.noticias.index'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.noticias.index');
        $response->assertViewHas('noticias');
    }

    public function test_admin_pode_criar_noticia()
    {
        $this->actingAs($this->admin);

        $dados = [
            'titulo' => 'Nova Notícia',
            'conteudo' => 'Conteúdo da nova notícia',
            'status' => 'publicado',
            'data_publicacao' => now()->format('Y-m-d H:i:s'),
        ];

        $response = $this->post(route('admin.noticias.store'), $dados);

        $response->assertRedirect();
        $this->assertDatabaseHas('noticias', [
            'titulo' => 'Nova Notícia',
            'autor_id' => $this->admin->id,
        ]);
    }

    public function test_usuario_comum_nao_pode_acessar_admin()
    {
        $user = User::factory()->create(['role' => 'user']);
        
        $this->actingAs($user);

        $response = $this->get(route('admin.noticias.index'));

        $response->assertStatus(403);
    }
}
```

### Executando Testes

```bash
# Todos os testes
php artisan test

# Testes específicos
php artisan test --filter NoticiaTest
php artisan test tests/Feature/Admin/

# Com cobertura
php artisan test --coverage

# Testes paralelos
php artisan test --parallel
```

## Documentação

### Documentação de Código

```php
/**
 * Processa o upload de uma imagem para notícia.
 *
 * @param  \Illuminate\Http\UploadedFile  $file
 * @param  string  $directory
 * @return string|null
 * 
 * @throws \InvalidArgumentException Se o arquivo não for uma imagem válida
 * @throws \RuntimeException Se houver erro no upload
 */
private function processImageUpload(UploadedFile $file, string $directory = 'noticias'): ?string
{
    // Implementação...
}
```

### README de Módulos

Cada módulo importante deve ter seu próprio README:

```markdown
# Módulo de Notícias

## Visão Geral

Este módulo gerencia o sistema de notícias da aplicação.

## Estrutura

- `NoticiaController`: Controlador principal
- `Noticia`: Model principal
- `NoticiaService`: Lógica de negócio
- `NoticiaRepository`: Acesso a dados

## Uso

```php
$service = new NoticiaService();
$noticia = $service->create($dados);
```

## Testes

```bash
php artisan test tests/Feature/NoticiaTest.php
```
```

### Documentação de API

```php
/**
 * @OA\Get(
 *     path="/api/noticias",
 *     summary="Lista notícias",
 *     tags={"Notícias"},
 *     @OA\Parameter(
 *         name="page",
 *         in="query",
 *         description="Número da página",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Lista de notícias",
 *         @OA\JsonContent(
 *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Noticia")),
 *             @OA\Property(property="meta", ref="#/components/schemas/PaginationMeta")
 *         )
 *     )
 * )
 */
public function index(Request $request)
{
    // Implementação...
}
```

## Reportar Bugs

### Template de Issue para Bug

```markdown
**Descrição do Bug**
Uma descrição clara e concisa do bug.

**Para Reproduzir**
Passos para reproduzir o comportamento:
1. Vá para '...'
2. Clique em '....'
3. Role para baixo até '....'
4. Veja o erro

**Comportamento Esperado**
Uma descrição clara e concisa do que você esperava que acontecesse.

**Screenshots**
Se aplicável, adicione screenshots para ajudar a explicar o problema.

**Ambiente:**
 - OS: [ex: Windows 10]
 - Browser: [ex: Chrome, Safari]
 - Versão: [ex: 22]
 - PHP: [ex: 8.2]
 - Laravel: [ex: 11.0]

**Contexto Adicional**
Adicione qualquer outro contexto sobre o problema aqui.

**Logs**
```
Cole aqui os logs relevantes
```
```

### Investigação de Bugs

1. **Reproduza o bug** localmente
2. **Identifique a causa raiz**
3. **Escreva um teste** que falha
4. **Implemente a correção**
5. **Verifique** que o teste passa
6. **Teste manualmente**

## Sugerir Melhorias

### Template de Issue para Feature

```markdown
**A sua solicitação de feature está relacionada a um problema? Descreva.**
Uma descrição clara e concisa do problema. Ex: Estou sempre frustrado quando [...]

**Descreva a solução que você gostaria**
Uma descrição clara e concisa do que você quer que aconteça.

**Descreva alternativas que você considerou**
Uma descrição clara e concisa de quaisquer soluções ou features alternativas que você considerou.

**Contexto adicional**
Adicione qualquer outro contexto ou screenshots sobre a solicitação de feature aqui.

**Impacto**
- [ ] Baixo - Nice to have
- [ ] Médio - Melhoria significativa
- [ ] Alto - Funcionalidade crítica

**Complexidade Estimada**
- [ ] Baixa - Algumas horas
- [ ] Média - Alguns dias
- [ ] Alta - Algumas semanas
```

### Processo de Avaliação

1. **Discussão** na issue
2. **Avaliação** pela equipe
3. **Priorização** no roadmap
4. **Implementação** por contribuidor
5. **Review** e merge

## Comunidade

### Canais de Comunicação

- **GitHub Issues:** Para bugs e features
- **GitHub Discussions:** Para discussões gerais
- **Email:** contato@tcamara.gov.br

### Eventos

- **Code Review Sessions:** Quintas-feiras às 14h
- **Planning Meetings:** Primeira segunda do mês
- **Retrospectives:** Última sexta do mês

### Reconhecimento

Contribuidores são reconhecidos através de:

- **Contributors List** no README
- **Release Notes** mencionando contribuições
- **Hall of Fame** para contribuidores frequentes

## Recursos Úteis

### Documentação Laravel

- [Laravel Documentation](https://laravel.com/docs)
- [Laravel Best Practices](https://github.com/alexeymezenin/laravel-best-practices)
- [Laravel Testing](https://laravel.com/docs/testing)

### Ferramentas de Desenvolvimento

- [Laravel Debugbar](https://github.com/barryvdh/laravel-debugbar)
- [Laravel IDE Helper](https://github.com/barryvdh/laravel-ide-helper)
- [PHPStan](https://phpstan.org/)
- [PHP CS Fixer](https://cs.symfony.com/)

### Recursos de Aprendizado

- [Laracasts](https://laracasts.com/)
- [Laravel News](https://laravel-news.com/)
- [PHP The Right Way](https://phptherightway.com/)

## Licença

Ao contribuir com este projeto, você concorda que suas contribuições serão licenciadas sob a mesma licença do projeto.

## Agradecimentos

Agradecemos a todos os contribuidores que ajudam a tornar o TCamaraMunicipal melhor! 🎉

---

**Dúvidas?** Abra uma issue ou entre em contato conosco!

Obrigado por contribuir! 🚀