<?php

namespace Tests\Unit;

use App\Services\IniciativaPopularService;
use Tests\TestCase;

class IniciativaPopularServiceTest extends TestCase
{
    public function test_calcular_minimo_sem_eleitorado()
    {
        $minimo = IniciativaPopularService::calcularMinimoAssinaturas();
        $this->assertEquals(1000, $minimo); // minimo_padrao
    }

    public function test_calcular_minimo_com_eleitorado()
    {
        $eleitorado = 50000;
        $minimo = IniciativaPopularService::calcularMinimoAssinaturas($eleitorado);
        
        // 1% de 50.000 = 500, mas mínimo legal é 100
        $minimoCalculado = max(100, (int) ceil($eleitorado * 0.01));
        
        $this->assertEquals($minimoCalculado, $minimo);
    }

    public function test_validar_assinaturas()
    {
        // Número válido de assinaturas
        $this->assertTrue(IniciativaPopularService::validarAssinaturas(1500, 1000));
        
        // Número inválido de assinaturas
        $this->assertFalse(IniciativaPopularService::validarAssinaturas(500, 1000));
        
        // Número igual ao mínimo
        $this->assertTrue(IniciativaPopularService::validarAssinaturas(1000, 1000));
    }

    public function test_obter_requisitos()
    {
        $requisitos = IniciativaPopularService::obterRequisitos();
        
        $this->assertIsArray($requisitos);
        $this->assertArrayHasKey('minimo_legal', $requisitos);
        $this->assertArrayHasKey('minimo_padrao', $requisitos);
        $this->assertArrayHasKey('percentual_eleitorado', $requisitos);
        $this->assertArrayHasKey('prazo_coleta_dias', $requisitos);
        $this->assertArrayHasKey('documentos_necessarios', $requisitos);
    }

    /**
     * Testar validação de dados do comitê
     */
    public function test_validar_comite(): void
    {
        // Dados válidos
        $dadosValidos = [
            'nome' => 'Comitê Teste',
            'email' => 'teste@exemplo.com',
            'telefone' => '(11) 99999-9999'
        ];
        $errors = IniciativaPopularService::validarComite($dadosValidos);
        $this->assertEmpty($errors);

        // Nome obrigatório
        $dadosInvalidos = [
            'nome' => '',
            'email' => 'teste@exemplo.com'
        ];
        $errors = IniciativaPopularService::validarComite($dadosInvalidos);
        $this->assertArrayHasKey('comite_nome', $errors);

        // Email inválido
        $dadosInvalidos = [
            'nome' => 'Comitê Teste',
            'email' => 'email-invalido'
        ];
        $errors = IniciativaPopularService::validarComite($dadosInvalidos);
        $this->assertArrayHasKey('comite_email', $errors);

        // Telefone inválido
        $dadosInvalidos = [
            'nome' => 'Comitê Teste',
            'telefone' => '123'
        ];
        $errors = IniciativaPopularService::validarComite($dadosInvalidos);
        $this->assertArrayHasKey('comite_telefone', $errors);
    }

    /**
     * Testar formatação de telefone
     */
    public function test_formatar_telefone(): void
    {
        // Teste com telefone de 11 dígitos (celular)
        $telefone11 = '11999999999';
        $formatado11 = IniciativaPopularService::formatarTelefone($telefone11);
        $this->assertEquals('(11) 99999-9999', $formatado11);

        // Teste com telefone de 10 dígitos (fixo)
        $telefone10 = '1133334444';
        $formatado10 = IniciativaPopularService::formatarTelefone($telefone10);
        $this->assertEquals('(11) 3333-4444', $formatado10);

        // Teste com telefone já formatado
        $telefoneFormatado = '(11) 99999-9999';
        $resultado = IniciativaPopularService::formatarTelefone($telefoneFormatado);
        $this->assertEquals('(11) 99999-9999', $resultado);
    }
}
