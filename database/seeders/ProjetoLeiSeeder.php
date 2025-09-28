<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ProjetoLei;
use App\Models\Vereador;
use App\Models\ComiteIniciativaPopular;
use Carbon\Carbon;

class ProjetoLeiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $vereadores = Vereador::all();
        
        if ($vereadores->count() == 0) {
            $this->command->warn('Nenhum vereador encontrado. Execute o VereadorSeeder primeiro.');
            return;
        }

        // Verificar se já existe projeto 101/2024
        if (ProjetoLei::where('numero', '101')->where('ano', 2024)->where('tipo', 'projeto_lei')->exists()) {
            $this->command->info('Projeto 101/2024 já existe. Pulando...');
        } else {
            // Projeto de autoria de vereador
            $projeto1 = ProjetoLei::create([
                'numero' => '101',
                'ano' => 2024,
                'tipo' => 'projeto_lei',
                'titulo' => 'Institui o Programa Municipal de Coleta Seletiva',
                'ementa' => 'Dispõe sobre a criação do Programa Municipal de Coleta Seletiva de resíduos sólidos e dá outras providências.',
                'justificativa' => 'A implementação da coleta seletiva é fundamental para a preservação do meio ambiente e para o desenvolvimento sustentável do município.',
                'texto_integral' => 'Art. 1º Fica instituído o Programa Municipal de Coleta Seletiva...',
                'status' => 'em_tramitacao',
                'data_protocolo' => Carbon::now()->subDays(30),
                'urgencia' => false,
                'tags' => 'meio ambiente,sustentabilidade,coleta seletiva',
                'observacoes' => 'Projeto em análise pela Comissão de Meio Ambiente',
                'tipo_autoria' => 'vereador',
                'autor_id' => $vereadores->first()->id,
                'legislatura' => 2024,
            ]);

            // Adicionar coautores
            if ($vereadores->count() > 1) {
                $coautores = $vereadores->skip(1)->take(2);
                $projeto1->coautores()->attach($coautores->pluck('id'));
            }
        }

        // Verificar se já existe projeto 102/2024
        if (ProjetoLei::where('numero', '102')->where('ano', 2024)->where('tipo', 'projeto_lei')->exists()) {
            $this->command->info('Projeto 102/2024 já existe. Pulando...');
        } else {
            // Projeto de autoria do prefeito
            ProjetoLei::create([
                'numero' => '102',
                'ano' => 2024,
                'tipo' => 'projeto_lei',
                'titulo' => 'Cria o Programa de Auxílio Alimentar para Famílias em Situação de Vulnerabilidade',
                'ementa' => 'Institui o Programa Municipal de Auxílio Alimentar destinado às famílias em situação de vulnerabilidade social.',
                'justificativa' => 'É necessário criar mecanismos de apoio às famílias que se encontram em situação de insegurança alimentar.',
                'texto_integral' => 'Art. 1º Fica instituído o Programa Municipal de Auxílio Alimentar...',
                'status' => 'aprovado',
                'data_protocolo' => Carbon::now()->subDays(60),
                'data_aprovacao' => Carbon::now()->subDays(10),
                'urgencia' => true,
                'tags' => 'assistência social,alimentação,vulnerabilidade',
                'observacoes' => 'Projeto aprovado por unanimidade',
                'tipo_autoria' => 'prefeito',
                'autor_nome' => 'Prefeito Municipal',
                'autor_id' => null,
                'legislatura' => 2024,
            ]);
        }

        // Verificar se já existe projeto 103/2024
        if (ProjetoLei::where('numero', '103')->where('ano', 2024)->where('tipo', 'projeto_resolucao')->exists()) {
            $this->command->info('Projeto 103/2024 já existe. Pulando...');
        } else {
            // Projeto de autoria de comissão
            ProjetoLei::create([
                'numero' => '103',
                'ano' => 2024,
                'tipo' => 'projeto_resolucao',
                'titulo' => 'Regulamenta o Funcionamento das Sessões Virtuais da Câmara Municipal',
                'ementa' => 'Estabelece normas para a realização de sessões ordinárias e extraordinárias em formato virtual.',
                'justificativa' => 'A modernização dos processos legislativos requer a regulamentação das sessões virtuais.',
                'texto_integral' => 'Art. 1º As sessões da Câmara Municipal poderão ser realizadas virtualmente...',
                'status' => 'em_tramitacao',
                'data_protocolo' => Carbon::now()->subDays(15),
                'urgencia' => false,
                'tags' => 'modernização,tecnologia,sessões virtuais',
                'observacoes' => 'Em análise pela Mesa Diretora',
                'tipo_autoria' => 'comissao',
                'autor_nome' => 'Comissão de Constituição e Justiça',
                'autor_id' => null,
                'legislatura' => 2024,
            ]);
        }

        // Verificar se comitê já existe
        $comite = ComiteIniciativaPopular::where('nome', 'Comitê Pró-Ciclovias')->first();
        if (!$comite) {
            // Criar comitê para iniciativa popular
            $comite = ComiteIniciativaPopular::create([
                'nome' => 'Comitê Pró-Ciclovias',
                'email' => 'contato@priciclovias.org',
                'telefone' => '(11) 99999-9999',
                'numero_assinaturas' => 1250,
                'minimo_assinaturas' => 1000,
            ]);
        }

        // Verificar se já existe projeto 104/2024
        if (ProjetoLei::where('numero', '104')->where('ano', 2024)->where('tipo', 'projeto_lei')->exists()) {
            $this->command->info('Projeto 104/2024 já existe. Pulando...');
        } else {
            // Projeto de iniciativa popular
            ProjetoLei::create([
                'numero' => '104',
                'ano' => 2024,
                'tipo' => 'projeto_lei',
                'titulo' => 'Dispõe sobre a Criação de Ciclovias no Município',
                'ementa' => 'Institui o Plano Municipal de Mobilidade Urbana Sustentável com foco na criação de ciclovias.',
                'justificativa' => 'A mobilidade urbana sustentável é essencial para reduzir a poluição e melhorar a qualidade de vida.',
                'texto_integral' => 'Art. 1º Fica instituído o Plano Municipal de Mobilidade Urbana Sustentável...',
                'status' => 'em_tramitacao',
                'data_protocolo' => Carbon::now()->subDays(45),
                'urgencia' => false,
                'tags' => 'mobilidade urbana,ciclovias,sustentabilidade',
                'observacoes' => 'Projeto de iniciativa popular com 1.250 assinaturas válidas',
                'tipo_autoria' => 'iniciativa_popular',
                'comite_iniciativa_popular_id' => $comite->id,
                'autor_id' => null,
                'legislatura' => 2024,
            ]);
        }

        // Verificar se já existe projeto 105/2024
        if (ProjetoLei::where('numero', '105')->where('ano', 2024)->where('tipo', 'indicacao')->exists()) {
            $this->command->info('Projeto 105/2024 já existe. Pulando...');
        } else {
            // Mais um projeto de vereador
            $projeto5 = ProjetoLei::create([
                'numero' => '105',
                'ano' => 2024,
                'tipo' => 'indicacao',
                'titulo' => 'Solicita Melhorias na Iluminação Pública do Bairro Centro',
                'ementa' => 'Indica ao Poder Executivo a necessidade de melhorias na iluminação pública do Bairro Centro.',
                'justificativa' => 'A iluminação inadequada compromete a segurança dos munícipes.',
                'texto_integral' => 'Considerando a necessidade de melhorar a segurança pública...',
                'status' => 'em_tramitacao',
                'data_protocolo' => Carbon::now()->subDays(20),
                'urgencia' => true,
                'tags' => 'iluminação pública,segurança,infraestrutura',
                'observacoes' => 'Encaminhado ao Executivo',
                'tipo_autoria' => 'vereador',
                'autor_id' => $vereadores->count() > 1 ? $vereadores->skip(1)->first()->id : $vereadores->first()->id,
                'legislatura' => 2024,
            ]);
        }

        // Verificar se já existe projeto 106/2024
        if (ProjetoLei::where('numero', '106')->where('ano', 2024)->where('tipo', 'projeto_lei')->exists()) {
            $this->command->info('Projeto 106/2024 já existe. Pulando...');
        } else {
            // Projeto de comissão
            ProjetoLei::create([
                'numero' => '106',
                'ano' => 2024,
                'tipo' => 'projeto_lei',
                'titulo' => 'Institui a Semana Municipal de Conscientização sobre Autismo',
                'ementa' => 'Cria a Semana Municipal de Conscientização sobre o Transtorno do Espectro Autista.',
                'justificativa' => 'É importante promover a conscientização e inclusão das pessoas com autismo.',
                'texto_integral' => 'Art. 1º Fica instituída a Semana Municipal de Conscientização sobre Autismo...',
                'status' => 'aprovado',
                'data_protocolo' => Carbon::now()->subDays(90),
                'data_aprovacao' => Carbon::now()->subDays(30),
                'urgencia' => false,
                'tags' => 'inclusão,autismo,conscientização',
                'observacoes' => 'Lei sancionada pelo Prefeito',
                'tipo_autoria' => 'comissao',
                'autor_nome' => 'Comissão de Saúde e Assistência Social',
                'autor_id' => null,
                'legislatura' => 2024,
            ]);
        }

        // Verificar se segundo comitê já existe
        $comite2 = ComiteIniciativaPopular::where('nome', 'Movimento Parques Urbanos')->first();
        if (!$comite2) {
            // Criar outro comitê para iniciativa popular
            $comite2 = ComiteIniciativaPopular::create([
                'nome' => 'Movimento Parques Urbanos',
                'email' => 'contato@parquesurbanos.org',
                'telefone' => '(11) 88888-8888',
                'numero_assinaturas' => 2100,
                'minimo_assinaturas' => 1500,
            ]);
        }

        // Verificar se já existe projeto 107/2024
        if (ProjetoLei::where('numero', '107')->where('ano', 2024)->where('tipo', 'projeto_lei')->exists()) {
            $this->command->info('Projeto 107/2024 já existe. Pulando...');
        } else {
            // Outro projeto de iniciativa popular
            ProjetoLei::create([
                'numero' => '107',
                'ano' => 2024,
                'tipo' => 'projeto_lei',
                'titulo' => 'Cria o Sistema Municipal de Parques Urbanos',
                'ementa' => 'Institui o Sistema Municipal de Parques Urbanos para preservação de áreas verdes e lazer.',
                'justificativa' => 'A criação de parques urbanos é fundamental para a qualidade de vida e preservação ambiental.',
                'texto_integral' => 'Art. 1º Fica instituído o Sistema Municipal de Parques Urbanos...',
                'status' => 'em_tramitacao',
                'data_protocolo' => Carbon::now()->subDays(25),
                'urgencia' => false,
                'tags' => 'parques,meio ambiente,lazer,qualidade de vida',
                'observacoes' => 'Projeto de iniciativa popular com 2.100 assinaturas válidas',
                'tipo_autoria' => 'iniciativa_popular',
                'comite_iniciativa_popular_id' => $comite2->id,
                'autor_id' => null,
                'legislatura' => 2024,
            ]);
        }

        $this->command->info('Projetos de lei processados com sucesso!');
        $this->command->info('- Projetos de autoria de vereadores');
        $this->command->info('- Projetos de autoria do prefeito');
        $this->command->info('- Projetos de autoria de comissões');
        $this->command->info('- Projetos de iniciativa popular');
    }
}
