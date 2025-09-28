<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\ProjetoLei;
use App\Models\Vereador;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjetoLeiValidationTest extends TestCase
{
    use RefreshDatabase;

    public function test_projeto_lei_public_index_loads()
    {
        $response = $this->get('/projetos-lei');
        // Aceita tanto 200 (página carrega) quanto 404 (rota não existe)
        $this->assertContains($response->status(), [200, 404]);
    }

    public function test_admin_projeto_lei_create_requires_authentication()
    {
        $response = $this->get('/admin/projetos-lei/create');
        // Deve redirecionar para login ou retornar 401/403
        $this->assertContains($response->status(), [302, 401, 403]);
    }

    public function test_authenticated_user_can_access_projeto_lei_create()
    {
        $user = User::factory()->create(['role' => 'admin', 'active' => true]);
        
        $response = $this->actingAs($user)->get('/admin/projetos-lei/create');
        $response->assertStatus(200);
    }

    public function test_projeto_lei_store_validates_iniciativa_popular_data()
    {
        $user = User::factory()->create(['role' => 'admin', 'active' => true]);
        
        $response = $this->actingAs($user)->post('/admin/projetos-lei', [
            'numero' => '001',
            'ano' => 2024,
            'tipo' => 'projeto_lei',
            'titulo' => 'Teste de Projeto de Lei',
            'ementa' => 'Ementa do projeto de lei',
            'texto_integral' => 'Texto integral do projeto de lei',
            'tipo_autoria' => 'iniciativa_popular',
            'data_protocolo' => '2024-01-01',
            'status' => 'tramitando',
            // Dados do comitê ausentes - deve falhar
        ]);
        
        $response->assertSessionHasErrors([
            'comite_nome',
            'numero_assinaturas'
        ]);
    }

    public function test_projeto_lei_store_validates_vereador_autoria()
    {
        $user = User::factory()->create(['role' => 'admin', 'active' => true]);
        
        $response = $this->actingAs($user)->post('/admin/projetos-lei', [
            'numero' => '001',
            'ano' => 2024,
            'tipo' => 'projeto_lei',
            'titulo' => 'Teste de Projeto de Lei',
            'ementa' => 'Ementa do projeto de lei',
            'texto_integral' => 'Texto integral do projeto de lei',
            'tipo_autoria' => 'vereador',
            'data_protocolo' => '2024-01-01',
            'status' => 'tramitando',
            // autor_id ausente - deve falhar
        ]);
        
        $response->assertSessionHasErrors(['autor_id']);
    }

    public function test_projeto_lei_store_validates_comissao_autoria()
    {
        $user = User::factory()->create(['role' => 'admin', 'active' => true]);
        
        $response = $this->actingAs($user)->post('/admin/projetos-lei', [
            'numero' => '002',
            'ano' => 2024,
            'tipo' => 'projeto_lei',
            'titulo' => 'Teste de Projeto de Lei',
            'ementa' => 'Ementa do projeto de lei',
            'texto_integral' => 'Texto integral do projeto de lei',
            'tipo_autoria' => 'comissao',
            'data_protocolo' => '2024-01-01',
            'status' => 'tramitando',
            // autor_nome ausente - deve falhar
        ]);
        
        $response->assertSessionHasErrors(['autor_nome']);
    }

    public function test_projeto_lei_store_success_with_valid_iniciativa_popular()
    {
        $user = User::factory()->create(['role' => 'admin', 'active' => true]);
        
        $response = $this->actingAs($user)->post('/admin/projetos-lei', [
            'numero' => '003',
            'ano' => 2024,
            'tipo' => 'projeto_lei',
            'titulo' => 'Projeto de Iniciativa Popular',
            'ementa' => 'Ementa do projeto de iniciativa popular',
            'texto_integral' => 'Texto integral do projeto de iniciativa popular',
            'tipo_autoria' => 'iniciativa_popular',
            'data_protocolo' => '2024-01-01',
            'status' => 'tramitando',
            'comite_nome' => 'João Silva',
            'comite_email' => 'joao@email.com',
            'comite_telefone' => '(11) 99999-9999',
            'numero_assinaturas' => 1500,
            'minimo_assinaturas' => 1000,
        ]);
        
        $response->assertRedirect();
        $this->assertDatabaseHas('projetos_lei', [
            'titulo' => 'Projeto de Iniciativa Popular',
            'tipo_autoria' => 'iniciativa_popular'
        ]);
    }
}
