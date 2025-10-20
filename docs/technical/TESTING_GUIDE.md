# Guia de Testes - TCamaraMunicipal

## Visão Geral

Este documento detalha as estratégias, ferramentas e procedimentos de teste para o sistema TCamaraMunicipal, garantindo qualidade, confiabilidade e segurança da aplicação.

## Estratégia de Testes

### Pirâmide de Testes

```
    /\
   /  \     E2E Tests (10%)
  /____\    
 /      \   Integration Tests (20%)
/________\  Unit Tests (70%)
```

### Tipos de Teste

1. **Testes Unitários** - Testam componentes isolados
2. **Testes de Integração** - Testam interação entre componentes
3. **Testes Funcionais** - Testam funcionalidades completas
4. **Testes E2E** - Testam fluxos completos do usuário
5. **Testes de Performance** - Testam desempenho e carga
6. **Testes de Segurança** - Testam vulnerabilidades
7. **Testes de Acessibilidade** - Testam conformidade WCAG

## Configuração do Ambiente de Testes

### Dependências

#### Composer (PHP)
```json
{
    "require-dev": {
        "phpunit/phpunit": "^10.0",
        "mockery/mockery": "^1.5",
        "fakerphp/faker": "^1.21",
        "laravel/dusk": "^7.0",
        "spatie/laravel-ray": "^1.32",
        "barryvdh/laravel-debugbar": "^3.8",
        "nunomaduro/collision": "^7.0",
        "spatie/laravel-ignition": "^2.0"
    }
}
```

#### NPM (JavaScript)
```json
{
    "devDependencies": {
        "jest": "^29.0",
        "@testing-library/jest-dom": "^5.16",
        "@testing-library/user-event": "^14.4",
        "cypress": "^12.0",
        "eslint": "^8.0",
        "prettier": "^2.8"
    }
}
```

### Configuração do PHPUnit

#### phpunit.xml
```xml
<?xml version="1.0" encoding="UTF-8"?>
<phpunit xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
         xsi:noNamespaceSchemaLocation="./vendor/phpunit/phpunit/phpunit.xsd"
         bootstrap="vendor/autoload.php"
         colors="true">
    <testsuites>
        <testsuite name="Unit">
            <directory suffix="Test.php">./tests/Unit</directory>
        </testsuite>
        <testsuite name="Feature">
            <directory suffix="Test.php">./tests/Feature</directory>
        </testsuite>
        <testsuite name="Integration">
            <directory suffix="Test.php">./tests/Integration</directory>
        </testsuite>
    </testsuites>
    <coverage>
        <include>
            <directory suffix=".php">./app</directory>
        </include>
        <exclude>
            <directory>./app/Console</directory>
            <directory>./app/Exceptions</directory>
            <directory>./app/Http/Middleware</directory>
        </exclude>
        <report>
            <html outputDirectory="./coverage-report"/>
            <text outputFile="./coverage.txt"/>
        </report>
    </coverage>
    <php>
        <env name="APP_ENV" value="testing"/>
        <env name="BCRYPT_ROUNDS" value="4"/>
        <env name="CACHE_DRIVER" value="array"/>
        <env name="DB_CONNECTION" value="sqlite"/>
        <env name="DB_DATABASE" value=":memory:"/>
        <env name="MAIL_MAILER" value="array"/>
        <env name="QUEUE_CONNECTION" value="sync"/>
        <env name="SESSION_DRIVER" value="array"/>
        <env name="TELESCOPE_ENABLED" value="false"/>
    </php>
</phpunit>
```

### Configuração do Jest

#### jest.config.js
```javascript
module.exports = {
    testEnvironment: 'jsdom',
    setupFilesAfterEnv: ['<rootDir>/tests/javascript/setup.js'],
    testMatch: [
        '<rootDir>/tests/javascript/**/*.test.js'
    ],
    collectCoverageFrom: [
        'resources/js/**/*.js',
        '!resources/js/vendor/**',
        '!**/node_modules/**'
    ],
    coverageDirectory: 'coverage-js',
    coverageReporters: ['html', 'text', 'lcov'],
    moduleNameMapping: {
        '^@/(.*)$': '<rootDir>/resources/js/$1'
    }
};
```

## Testes Unitários

### Estrutura de Testes

#### Teste de Model
```php
<?php
// tests/Unit/Models/UserTest.php

namespace Tests\Unit\Models;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_a_user()
    {
        $userData = [
            'name' => 'João Silva',
            'email' => 'joao@example.com',
            'password' => bcrypt('password123'),
        ];

        $user = User::create($userData);

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals('João Silva', $user->name);
        $this->assertEquals('joao@example.com', $user->email);
    }

    /** @test */
    public function it_hides_password_in_array()
    {
        $user = User::factory()->create();
        $userArray = $user->toArray();

        $this->assertArrayNotHasKey('password', $userArray);
    }

    /** @test */
    public function it_can_check_user_permissions()
    {
        $user = User::factory()->create();
        $user->givePermissionTo('admin.users');

        $this->assertTrue($user->hasPermission('admin.users'));
        $this->assertFalse($user->hasPermission('admin.system'));
    }

    /** @test */
    public function it_can_get_full_name()
    {
        $user = User::factory()->make([
            'name' => 'João',
            'sobrenome' => 'Silva'
        ]);

        $this->assertEquals('João Silva', $user->getFullNameAttribute());
    }
}
```

#### Teste de Service
```php
<?php
// tests/Unit/Services/NotificationServiceTest.php

namespace Tests\Unit\Services;

use App\Services\NotificationService;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;
use Mockery;

class NotificationServiceTest extends TestCase
{
    protected $notificationService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->notificationService = new NotificationService();
    }

    /** @test */
    public function it_can_send_email_notification()
    {
        Mail::fake();
        
        $user = User::factory()->make();
        $message = 'Teste de notificação';

        $result = $this->notificationService->sendEmail($user, $message);

        $this->assertTrue($result);
        Mail::assertSent(\App\Mail\GeneralNotification::class);
    }

    /** @test */
    public function it_handles_failed_email_gracefully()
    {
        Mail::shouldReceive('send')->andThrow(new \Exception('SMTP Error'));
        
        $user = User::factory()->make();
        $message = 'Teste de notificação';

        $result = $this->notificationService->sendEmail($user, $message);

        $this->assertFalse($result);
    }

    /** @test */
    public function it_can_send_bulk_notifications()
    {
        Notification::fake();
        
        $users = User::factory()->count(3)->make();
        $message = 'Notificação em massa';

        $this->notificationService->sendBulkNotification($users, $message);

        Notification::assertSentTo($users, \App\Notifications\BulkNotification::class);
    }
}
```

### Factories e Seeders para Testes

#### User Factory
```php
<?php
// database/factories/UserFactory.php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition()
    {
        return [
            'name' => $this->faker->firstName(),
            'sobrenome' => $this->faker->lastName(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => bcrypt('password123'),
            'remember_token' => Str::random(10),
            'cpf' => $this->faker->cpf(false),
            'telefone' => $this->faker->cellphone(false),
            'data_nascimento' => $this->faker->date(),
            'ativo' => true,
        ];
    }

    public function admin()
    {
        return $this->afterCreating(function (User $user) {
            $user->assignRole('admin');
        });
    }

    public function inactive()
    {
        return $this->state(function (array $attributes) {
            return [
                'ativo' => false,
            ];
        });
    }
}
```

#### Noticia Factory
```php
<?php
// database/factories/NoticiaFactory.php

namespace Database\Factories;

use App\Models\Noticia;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class NoticiaFactory extends Factory
{
    protected $model = Noticia::class;

    public function definition()
    {
        return [
            'titulo' => $this->faker->sentence(),
            'subtitulo' => $this->faker->sentence(),
            'conteudo' => $this->faker->paragraphs(3, true),
            'resumo' => $this->faker->paragraph(),
            'autor_id' => User::factory(),
            'categoria_id' => 1,
            'publicado' => true,
            'destaque' => false,
            'data_publicacao' => now(),
            'slug' => $this->faker->slug(),
            'meta_description' => $this->faker->sentence(),
            'meta_keywords' => implode(',', $this->faker->words(5)),
        ];
    }

    public function published()
    {
        return $this->state(function (array $attributes) {
            return [
                'publicado' => true,
                'data_publicacao' => now(),
            ];
        });
    }

    public function draft()
    {
        return $this->state(function (array $attributes) {
            return [
                'publicado' => false,
                'data_publicacao' => null,
            ];
        });
    }

    public function featured()
    {
        return $this->state(function (array $attributes) {
            return [
                'destaque' => true,
            ];
        });
    }
}
```

## Testes de Integração

### Teste de Controller
```php
<?php
// tests/Feature/Controllers/NoticiaControllerTest.php

namespace Tests\Feature\Controllers;

use App\Models\Noticia;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class NoticiaControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->admin()->create();
    }

    /** @test */
    public function admin_can_view_noticias_index()
    {
        $noticias = Noticia::factory()->count(3)->create();

        $response = $this->actingAs($this->admin)
            ->get(route('admin.noticias.index'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.noticias.index');
        $response->assertViewHas('noticias');
    }

    /** @test */
    public function admin_can_create_noticia()
    {
        Storage::fake('public');
        
        $noticiaData = [
            'titulo' => 'Nova Notícia',
            'subtitulo' => 'Subtítulo da notícia',
            'conteudo' => 'Conteúdo da notícia...',
            'resumo' => 'Resumo da notícia',
            'categoria_id' => 1,
            'publicado' => true,
            'destaque' => false,
            'imagem' => UploadedFile::fake()->image('noticia.jpg'),
        ];

        $response = $this->actingAs($this->admin)
            ->post(route('admin.noticias.store'), $noticiaData);

        $response->assertRedirect();
        $this->assertDatabaseHas('noticias', [
            'titulo' => 'Nova Notícia',
            'autor_id' => $this->admin->id,
        ]);
        
        Storage::disk('public')->assertExists('noticias/noticia.jpg');
    }

    /** @test */
    public function admin_can_update_noticia()
    {
        $noticia = Noticia::factory()->create();
        
        $updateData = [
            'titulo' => 'Título Atualizado',
            'conteudo' => 'Conteúdo atualizado...',
        ];

        $response = $this->actingAs($this->admin)
            ->put(route('admin.noticias.update', $noticia), $updateData);

        $response->assertRedirect();
        $this->assertDatabaseHas('noticias', [
            'id' => $noticia->id,
            'titulo' => 'Título Atualizado',
        ]);
    }

    /** @test */
    public function admin_can_delete_noticia()
    {
        $noticia = Noticia::factory()->create();

        $response = $this->actingAs($this->admin)
            ->delete(route('admin.noticias.destroy', $noticia));

        $response->assertRedirect();
        $this->assertSoftDeleted('noticias', ['id' => $noticia->id]);
    }

    /** @test */
    public function guest_cannot_access_admin_routes()
    {
        $response = $this->get(route('admin.noticias.index'));
        $response->assertRedirect(route('login'));
    }

    /** @test */
    public function regular_user_cannot_access_admin_routes()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->get(route('admin.noticias.index'));

        $response->assertStatus(403);
    }
}
```

### Teste de API
```php
<?php
// tests/Feature/Api/SearchApiTest.php

namespace Tests\Feature\Api;

use App\Models\Noticia;
use App\Models\Vereador;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SearchApiTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_search_noticias()
    {
        $noticia = Noticia::factory()->published()->create([
            'titulo' => 'Reunião da Câmara Municipal'
        ]);

        $response = $this->getJson('/api/busca?q=reunião&categoria=noticias');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'titulo',
                    'url',
                    'tipo',
                    'data'
                ]
            ],
            'total'
        ]);
        
        $response->assertJsonFragment([
            'titulo' => 'Reunião da Câmara Municipal'
        ]);
    }

    /** @test */
    public function it_returns_empty_results_for_invalid_search()
    {
        $response = $this->getJson('/api/busca?q=termoinexistente');

        $response->assertStatus(200);
        $response->assertJson([
            'data' => [],
            'total' => 0
        ]);
    }

    /** @test */
    public function it_respects_search_limits()
    {
        Noticia::factory()->count(15)->published()->create([
            'titulo' => 'Notícia de Teste'
        ]);

        $response = $this->getJson('/api/busca?q=teste&limite=5');

        $response->assertStatus(200);
        $data = $response->json('data');
        $this->assertCount(5, $data);
    }

    /** @test */
    public function it_validates_search_parameters()
    {
        $response = $this->getJson('/api/busca?q=');

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['q']);
    }
}
```

## Testes End-to-End (E2E)

### Configuração do Laravel Dusk

#### DuskTestCase.php
```php
<?php
// tests/DuskTestCase.php

namespace Tests;

use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Laravel\Dusk\TestCase as BaseTestCase;

abstract class DuskTestCase extends BaseTestCase
{
    use CreatesApplication;

    public static function prepare()
    {
        if (! static::runningInSail()) {
            static::startChromeDriver();
        }
    }

    protected function driver()
    {
        $options = (new ChromeOptions)->addArguments(collect([
            $this->shouldStartMaximized() ? '--start-maximized' : '--window-size=1920,1080',
            '--disable-gpu',
            '--headless',
            '--no-sandbox',
            '--disable-dev-shm-usage',
        ])->unless($this->hasHeadlessDisabled(), function ($items) {
            return $items->forget(3);
        })->all());

        return RemoteWebDriver::create(
            $_ENV['DUSK_DRIVER_URL'] ?? 'http://localhost:9515',
            DesiredCapabilities::chrome()->setCapability(
                ChromeOptions::CAPABILITY, $options
            )
        );
    }

    protected function shouldStartMaximized()
    {
        return isset($_SERVER['DUSK_MAXIMIZED']);
    }

    protected function hasHeadlessDisabled()
    {
        return isset($_SERVER['DUSK_HEADLESS_DISABLED']);
    }
}
```

### Teste de Login
```php
<?php
// tests/Browser/LoginTest.php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class LoginTest extends DuskTestCase
{
    use DatabaseMigrations;

    /** @test */
    public function user_can_login_with_valid_credentials()
    {
        $user = User::factory()->create([
            'email' => 'admin@tcamara.gov.br',
            'password' => bcrypt('password123')
        ]);

        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->type('email', 'admin@tcamara.gov.br')
                    ->type('password', 'password123')
                    ->press('Entrar')
                    ->assertPathIs('/admin/dashboard')
                    ->assertSee('Dashboard');
        });
    }

    /** @test */
    public function user_cannot_login_with_invalid_credentials()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->type('email', 'invalid@email.com')
                    ->type('password', 'wrongpassword')
                    ->press('Entrar')
                    ->assertPathIs('/login')
                    ->assertSee('Credenciais inválidas');
        });
    }

    /** @test */
    public function user_can_logout()
    {
        $user = User::factory()->admin()->create();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                    ->visit('/admin/dashboard')
                    ->click('@logout-button')
                    ->assertPathIs('/')
                    ->assertGuest();
        });
    }
}
```

### Teste de Fluxo Completo
```php
<?php
// tests/Browser/NoticiaManagementTest.php

namespace Tests\Browser;

use App\Models\User;
use App\Models\Categoria;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class NoticiaManagementTest extends DuskTestCase
{
    use DatabaseMigrations;

    protected $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->admin()->create();
        Categoria::factory()->create(['nome' => 'Geral']);
    }

    /** @test */
    public function admin_can_create_edit_and_delete_noticia()
    {
        $this->browse(function (Browser $browser) {
            // Login
            $browser->loginAs($this->admin)
                    ->visit('/admin/noticias');

            // Criar notícia
            $browser->click('@create-noticia')
                    ->waitForText('Nova Notícia')
                    ->type('titulo', 'Notícia de Teste E2E')
                    ->type('subtitulo', 'Subtítulo de teste')
                    ->type('resumo', 'Resumo da notícia de teste')
                    ->select('categoria_id', 1)
                    ->check('publicado')
                    ->press('Salvar')
                    ->assertSee('Notícia criada com sucesso');

            // Verificar se aparece na listagem
            $browser->visit('/admin/noticias')
                    ->assertSee('Notícia de Teste E2E');

            // Editar notícia
            $browser->click('@edit-noticia-1')
                    ->waitForText('Editar Notícia')
                    ->clear('titulo')
                    ->type('titulo', 'Notícia Editada E2E')
                    ->press('Salvar')
                    ->assertSee('Notícia atualizada com sucesso');

            // Verificar edição
            $browser->visit('/admin/noticias')
                    ->assertSee('Notícia Editada E2E');

            // Excluir notícia
            $browser->click('@delete-noticia-1')
                    ->whenAvailable('.modal', function ($modal) {
                        $modal->click('@confirm-delete');
                    })
                    ->assertSee('Notícia excluída com sucesso')
                    ->assertDontSee('Notícia Editada E2E');
        });
    }

    /** @test */
    public function public_can_view_published_noticias()
    {
        $noticia = \App\Models\Noticia::factory()->published()->create([
            'titulo' => 'Notícia Pública'
        ]);

        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->assertSee('Notícia Pública')
                    ->click('@noticia-link-' . $noticia->id)
                    ->assertSee('Notícia Pública')
                    ->assertSee($noticia->conteudo);
        });
    }
}
```

## Testes de Performance

### Configuração do Apache Bench
```bash
#!/bin/bash
# scripts/performance-test.sh

echo "=== Teste de Performance - TCamaraMunicipal ==="

BASE_URL="http://localhost"
CONCURRENT_USERS=10
TOTAL_REQUESTS=1000

echo "Testando página inicial..."
ab -n $TOTAL_REQUESTS -c $CONCURRENT_USERS $BASE_URL/ > results/home-page.txt

echo "Testando listagem de notícias..."
ab -n $TOTAL_REQUESTS -c $CONCURRENT_USERS $BASE_URL/noticias > results/noticias.txt

echo "Testando API de busca..."
ab -n $TOTAL_REQUESTS -c $CONCURRENT_USERS -H "Accept: application/json" \
   $BASE_URL/api/busca?q=teste > results/api-search.txt

echo "Testando transparência..."
ab -n $TOTAL_REQUESTS -c $CONCURRENT_USERS $BASE_URL/transparencia > results/transparencia.txt

echo "=== Resultados ==="
echo "Página inicial:"
grep "Requests per second" results/home-page.txt

echo "Notícias:"
grep "Requests per second" results/noticias.txt

echo "API de busca:"
grep "Requests per second" results/api-search.txt

echo "Transparência:"
grep "Requests per second" results/transparencia.txt
```

### Teste de Carga com PHPUnit
```php
<?php
// tests/Performance/LoadTest.php

namespace Tests\Performance;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoadTest extends TestCase
{
    /** @test */
    public function homepage_loads_within_acceptable_time()
    {
        $startTime = microtime(true);
        
        $response = $this->get('/');
        
        $endTime = microtime(true);
        $loadTime = ($endTime - $startTime) * 1000; // em milissegundos

        $response->assertStatus(200);
        $this->assertLessThan(2000, $loadTime, 'Homepage deve carregar em menos de 2 segundos');
    }

    /** @test */
    public function api_search_responds_quickly()
    {
        $startTime = microtime(true);
        
        $response = $this->getJson('/api/busca?q=teste');
        
        $endTime = microtime(true);
        $loadTime = ($endTime - $startTime) * 1000;

        $response->assertStatus(200);
        $this->assertLessThan(500, $loadTime, 'API de busca deve responder em menos de 500ms');
    }

    /** @test */
    public function database_queries_are_optimized()
    {
        \DB::enableQueryLog();
        
        $this->get('/');
        
        $queries = \DB::getQueryLog();
        $queryCount = count($queries);
        
        $this->assertLessThan(20, $queryCount, 'Homepage deve executar menos de 20 queries');
    }
}
```

## Testes de Segurança

### Teste de Autenticação
```php
<?php
// tests/Security/AuthenticationTest.php

namespace Tests\Security;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_prevents_brute_force_attacks()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('correct-password')
        ]);

        // Simular 5 tentativas de login incorretas
        for ($i = 0; $i < 5; $i++) {
            $this->post('/login', [
                'email' => 'test@example.com',
                'password' => 'wrong-password'
            ]);
        }

        // A 6ª tentativa deve ser bloqueada
        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'correct-password'
        ]);

        $response->assertStatus(429); // Too Many Requests
    }

    /** @test */
    public function it_requires_strong_passwords()
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => '123', // Senha fraca
            'password_confirmation' => '123'
        ]);

        $response->assertSessionHasErrors(['password']);
    }

    /** @test */
    public function it_logs_security_events()
    {
        $user = User::factory()->create();

        $this->actingAs($user)->get('/admin/users');

        $this->assertDatabaseHas('activity_logs', [
            'user_id' => $user->id,
            'action' => 'access_attempt',
            'resource' => 'admin.users'
        ]);
    }
}
```

### Teste de Autorização
```php
<?php
// tests/Security/AuthorizationTest.php

namespace Tests\Security;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthorizationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_prevents_unauthorized_access_to_admin_routes()
    {
        $user = User::factory()->create(); // Usuário comum

        $adminRoutes = [
            '/admin/dashboard',
            '/admin/users',
            '/admin/noticias',
            '/admin/configuracoes'
        ];

        foreach ($adminRoutes as $route) {
            $response = $this->actingAs($user)->get($route);
            $response->assertStatus(403, "Route $route should be forbidden for regular users");
        }
    }

    /** @test */
    public function it_allows_admin_access_to_admin_routes()
    {
        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($admin)->get('/admin/dashboard');
        $response->assertStatus(200);
    }

    /** @test */
    public function it_prevents_privilege_escalation()
    {
        $user = User::factory()->create();
        $admin = User::factory()->admin()->create();

        // Usuário comum não pode editar admin
        $response = $this->actingAs($user)
            ->put("/admin/users/{$admin->id}", [
                'name' => 'Hacked Name'
            ]);

        $response->assertStatus(403);
        
        // Verificar que o admin não foi alterado
        $admin->refresh();
        $this->assertNotEquals('Hacked Name', $admin->name);
    }
}
```

### Teste de Proteção CSRF
```php
<?php
// tests/Security/CsrfTest.php

namespace Tests\Security;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CsrfTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_protects_against_csrf_attacks()
    {
        $admin = User::factory()->admin()->create();

        // Tentar fazer POST sem token CSRF
        $response = $this->actingAs($admin)
            ->post('/admin/noticias', [
                'titulo' => 'Notícia Maliciosa',
                'conteudo' => 'Conteúdo malicioso'
            ]);

        $response->assertStatus(419); // CSRF token mismatch
    }

    /** @test */
    public function it_allows_requests_with_valid_csrf_token()
    {
        $admin = User::factory()->admin()->create();

        // Obter token CSRF válido
        $response = $this->actingAs($admin)->get('/admin/noticias/create');
        $token = $response->getSession()->token();

        // Fazer POST com token válido
        $response = $this->actingAs($admin)
            ->withSession(['_token' => $token])
            ->post('/admin/noticias', [
                '_token' => $token,
                'titulo' => 'Notícia Legítima',
                'conteudo' => 'Conteúdo legítimo',
                'categoria_id' => 1,
                'publicado' => true
            ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('noticias', [
            'titulo' => 'Notícia Legítima'
        ]);
    }
}
```

## Testes de Acessibilidade

### Configuração do Pa11y
```javascript
// tests/accessibility/pa11y.config.js
module.exports = {
    standard: 'WCAG2AA',
    ignore: [
        'WCAG2AA.Principle1.Guideline1_4.1_4_3.G18.Fail',
        'WCAG2AA.Principle4.Guideline4_1.4_1_2.H91.A.EmptyNoId'
    ],
    hideElements: '.cookie-banner, .loading-spinner',
    chromeLaunchConfig: {
        args: ['--no-sandbox', '--disable-setuid-sandbox']
    }
};
```

### Script de Teste de Acessibilidade
```bash
#!/bin/bash
# scripts/accessibility-test.sh

echo "=== Teste de Acessibilidade - TCamaraMunicipal ==="

BASE_URL="http://localhost"
REPORT_DIR="reports/accessibility"

mkdir -p $REPORT_DIR

echo "Testando página inicial..."
pa11y $BASE_URL --reporter html > $REPORT_DIR/home.html

echo "Testando página de notícias..."
pa11y $BASE_URL/noticias --reporter html > $REPORT_DIR/noticias.html

echo "Testando formulário de contato..."
pa11y $BASE_URL/contato --reporter html > $REPORT_DIR/contato.html

echo "Testando transparência..."
pa11y $BASE_URL/transparencia --reporter html > $REPORT_DIR/transparencia.html

echo "Testando ouvidoria..."
pa11y $BASE_URL/ouvidoria --reporter html > $REPORT_DIR/ouvidoria.html

echo "=== Relatórios gerados em $REPORT_DIR ==="
```

## Automação de Testes

### GitHub Actions
```yaml
# .github/workflows/tests.yml
name: Tests

on:
  push:
    branches: [ main, develop ]
  pull_request:
    branches: [ main ]

jobs:
  tests:
    runs-on: ubuntu-latest

    services:
      mysql:
        image: mysql:8.0
        env:
          MYSQL_ROOT_PASSWORD: password
          MYSQL_DATABASE: tcamara_test
        ports:
          - 3306:3306
        options: --health-cmd="mysqladmin ping" --health-interval=10s --health-timeout=5s --health-retries=3

    steps:
    - uses: actions/checkout@v3

    - name: Setup PHP
      uses: shivammathur/setup-php@v2
      with:
        php-version: '8.2'
        extensions: mbstring, dom, fileinfo, mysql, gd
        coverage: xdebug

    - name: Setup Node.js
      uses: actions/setup-node@v3
      with:
        node-version: '18'
        cache: 'npm'

    - name: Install PHP dependencies
      run: composer install --no-progress --prefer-dist --optimize-autoloader

    - name: Install NPM dependencies
      run: npm ci

    - name: Build assets
      run: npm run build

    - name: Copy environment file
      run: cp .env.testing .env

    - name: Generate application key
      run: php artisan key:generate

    - name: Run migrations
      run: php artisan migrate --force

    - name: Run PHPUnit tests
      run: vendor/bin/phpunit --coverage-clover=coverage.xml

    - name: Run JavaScript tests
      run: npm test

    - name: Upload coverage to Codecov
      uses: codecov/codecov-action@v3
      with:
        file: ./coverage.xml

  dusk:
    runs-on: ubuntu-latest

    steps:
    - uses: actions/checkout@v3

    - name: Setup PHP
      uses: shivammathur/setup-php@v2
      with:
        php-version: '8.2'
        extensions: mbstring, dom, fileinfo, mysql, gd

    - name: Install dependencies
      run: composer install --no-progress --prefer-dist --optimize-autoloader

    - name: Setup Chrome
      uses: browser-actions/setup-chrome@latest

    - name: Setup ChromeDriver
      uses: nanasess/setup-chromedriver@master

    - name: Start Chrome Driver
      run: |
        export DISPLAY=:99
        chromedriver --url-base=/wd/hub &
        sudo Xvfb -ac :99 -screen 0 1280x1024x24 > /dev/null 2>&1 &

    - name: Run Laravel Server
      run: php artisan serve --no-reload &

    - name: Run Dusk Tests
      run: php artisan dusk
```

### Script de Teste Local
```bash
#!/bin/bash
# scripts/run-tests.sh

echo "=== Executando Testes - TCamaraMunicipal ==="

# Cores para output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Função para imprimir status
print_status() {
    if [ $1 -eq 0 ]; then
        echo -e "${GREEN}✓ $2${NC}"
    else
        echo -e "${RED}✗ $2${NC}"
        exit 1
    fi
}

# Preparar ambiente
echo -e "${YELLOW}Preparando ambiente de testes...${NC}"
cp .env.testing .env
php artisan key:generate --force
php artisan migrate:fresh --seed --force

# Testes unitários
echo -e "${YELLOW}Executando testes unitários...${NC}"
vendor/bin/phpunit tests/Unit
print_status $? "Testes unitários"

# Testes de feature
echo -e "${YELLOW}Executando testes de feature...${NC}"
vendor/bin/phpunit tests/Feature
print_status $? "Testes de feature"

# Testes de integração
echo -e "${YELLOW}Executando testes de integração...${NC}"
vendor/bin/phpunit tests/Integration
print_status $? "Testes de integração"

# Testes JavaScript
echo -e "${YELLOW}Executando testes JavaScript...${NC}"
npm test
print_status $? "Testes JavaScript"

# Análise de código
echo -e "${YELLOW}Executando análise de código...${NC}"
vendor/bin/phpstan analyse app
print_status $? "Análise estática"

# Verificar padrões de código
echo -e "${YELLOW}Verificando padrões de código...${NC}"
vendor/bin/php-cs-fixer fix --dry-run --diff
print_status $? "Padrões de código"

# Testes de segurança
echo -e "${YELLOW}Executando testes de segurança...${NC}"
vendor/bin/phpunit tests/Security
print_status $? "Testes de segurança"

# Gerar relatório de cobertura
echo -e "${YELLOW}Gerando relatório de cobertura...${NC}"
vendor/bin/phpunit --coverage-html coverage-report
print_status $? "Relatório de cobertura"

echo -e "${GREEN}=== Todos os testes executados com sucesso! ===${NC}"
echo -e "Relatório de cobertura disponível em: coverage-report/index.html"
```

## Métricas e Relatórios

### Configuração de Cobertura
```php
// phpunit.xml - Configuração de cobertura
<coverage processUncoveredFiles="true">
    <include>
        <directory suffix=".php">./app</directory>
    </include>
    <exclude>
        <directory>./app/Console</directory>
        <directory>./app/Exceptions</directory>
        <file>./app/Http/Kernel.php</file>
    </exclude>
    <report>
        <html outputDirectory="./coverage-report"/>
        <text outputFile="./coverage.txt"/>
        <clover outputFile="./coverage.xml"/>
    </report>
</coverage>
```

### Metas de Qualidade
```yaml
# quality-gates.yml
coverage:
  minimum: 80%
  target: 90%

performance:
  homepage_load_time: 2s
  api_response_time: 500ms
  database_queries_per_page: 20

security:
  vulnerabilities: 0
  code_smells: 0
  security_hotspots: 0

maintainability:
  technical_debt_ratio: <5%
  duplicated_lines: <3%
  complexity_per_function: <10
```

## Troubleshooting

### Problemas Comuns

#### Testes Falhando
```bash
# Limpar cache de testes
php artisan config:clear
php artisan cache:clear
php artisan view:clear

# Recriar banco de dados de teste
php artisan migrate:fresh --env=testing

# Verificar permissões
chmod -R 755 storage/
chmod -R 755 bootstrap/cache/
```

#### Problemas de Performance
```bash
# Otimizar autoloader
composer dump-autoload --optimize

# Verificar queries N+1
php artisan telescope:install
php artisan migrate

# Analisar performance
php artisan route:cache
php artisan config:cache
php artisan view:cache
```

#### Problemas de Memória
```php
// phpunit.xml - Aumentar limite de memória
<php>
    <ini name="memory_limit" value="512M"/>
</php>
```

### Comandos Úteis

```bash
# Executar testes específicos
vendor/bin/phpunit --filter=UserTest
vendor/bin/phpunit tests/Unit/Models/UserTest.php

# Executar com cobertura
vendor/bin/phpunit --coverage-html coverage

# Executar testes em paralelo
vendor/bin/paratest

# Executar Dusk em modo visível
php artisan dusk --without-headless

# Gerar relatório de métricas
vendor/bin/phpmetrics --report-html=metrics app/
```

## Suporte

### Documentação
- [PHPUnit Documentation](https://phpunit.de/documentation.html)
- [Laravel Testing](https://laravel.com/docs/testing)
- [Laravel Dusk](https://laravel.com/docs/dusk)

### Contatos
- **Equipe de QA:** qa@tcamara.gov.br
- **Desenvolvedor Principal:** dev@tcamara.gov.br
- **Suporte Técnico:** suporte@tcamara.gov.br

---

**Última atualização:** 21 de Janeiro de 2025  
**Versão:** 1.0  
**Próxima revisão:** 21 de Abril de 2025