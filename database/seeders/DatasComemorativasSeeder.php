<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Evento;
use Carbon\Carbon;

class DatasComemorativasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ano = Carbon::now()->year;
        
        // Datas comemorativas nacionais fixas
        $datasNacionais = [
            // Janeiro
            ['dia' => 1, 'mes' => 1, 'titulo' => 'Confraternização Universal', 'descricao' => 'Feriado nacional - Ano Novo'],
            ['dia' => 25, 'mes' => 1, 'titulo' => 'Aniversário de São Paulo', 'descricao' => 'Fundação da cidade de São Paulo'],
            
            // Fevereiro
            ['dia' => 2, 'mes' => 2, 'titulo' => 'Dia de Iemanjá', 'descricao' => 'Festa popular em homenagem à Rainha do Mar'],
            
            // Março
            ['dia' => 8, 'mes' => 3, 'titulo' => 'Dia Internacional da Mulher', 'descricao' => 'Celebração dos direitos da mulher'],
            ['dia' => 15, 'mes' => 3, 'titulo' => 'Dia da Escola', 'descricao' => 'Valorização da educação'],
            ['dia' => 22, 'mes' => 3, 'titulo' => 'Dia Mundial da Água', 'descricao' => 'Conscientização sobre a preservação da água'],
            
            // Abril
            ['dia' => 7, 'mes' => 4, 'titulo' => 'Dia Mundial da Saúde', 'descricao' => 'Promoção da saúde pública'],
            ['dia' => 18, 'mes' => 4, 'titulo' => 'Dia Nacional do Livro Infantil', 'descricao' => 'Incentivo à leitura infantil'],
            ['dia' => 19, 'mes' => 4, 'titulo' => 'Dia do Índio', 'descricao' => 'Valorização da cultura indígena'],
            ['dia' => 21, 'mes' => 4, 'titulo' => 'Tiradentes', 'descricao' => 'Feriado nacional - Inconfidência Mineira'],
            ['dia' => 22, 'mes' => 4, 'titulo' => 'Descobrimento do Brasil', 'descricao' => 'Chegada dos portugueses ao Brasil'],
            ['dia' => 23, 'mes' => 4, 'titulo' => 'Dia Mundial do Livro', 'descricao' => 'Promoção da leitura e literatura'],
            
            // Maio
            ['dia' => 1, 'mes' => 5, 'titulo' => 'Dia do Trabalhador', 'descricao' => 'Feriado nacional - Dia do Trabalho'],
            ['dia' => 8, 'mes' => 5, 'titulo' => 'Dia das Mães', 'descricao' => 'Homenagem às mães (segundo domingo de maio)'],
            ['dia' => 13, 'mes' => 5, 'titulo' => 'Abolição da Escravatura', 'descricao' => 'Assinatura da Lei Áurea'],
            ['dia' => 18, 'mes' => 5, 'titulo' => 'Dia Nacional de Combate ao Abuso Sexual', 'descricao' => 'Proteção de crianças e adolescentes'],
            ['dia' => 31, 'mes' => 5, 'titulo' => 'Dia Mundial sem Tabaco', 'descricao' => 'Conscientização sobre os malefícios do tabaco'],
            
            // Junho
            ['dia' => 5, 'mes' => 6, 'titulo' => 'Dia Mundial do Meio Ambiente', 'descricao' => 'Conscientização ambiental'],
            ['dia' => 12, 'mes' => 6, 'titulo' => 'Dia dos Namorados', 'descricao' => 'Celebração do amor'],
            ['dia' => 24, 'mes' => 6, 'titulo' => 'Festa Junina - São João', 'descricao' => 'Tradição cultural brasileira'],
            
            // Julho
            ['dia' => 9, 'mes' => 7, 'titulo' => 'Revolução Constitucionalista', 'descricao' => 'Feriado estadual em São Paulo'],
            ['dia' => 20, 'mes' => 7, 'titulo' => 'Dia do Amigo', 'descricao' => 'Celebração da amizade'],
            
            // Agosto
            ['dia' => 11, 'mes' => 8, 'titulo' => 'Dia do Estudante', 'descricao' => 'Valorização da educação'],
            ['dia' => 22, 'mes' => 8, 'titulo' => 'Dia do Folclore', 'descricao' => 'Preservação da cultura popular'],
            ['dia' => 29, 'mes' => 8, 'titulo' => 'Dia Nacional de Combate ao Fumo', 'descricao' => 'Prevenção ao tabagismo'],
            
            // Setembro
            ['dia' => 7, 'mes' => 9, 'titulo' => 'Independência do Brasil', 'descricao' => 'Feriado nacional - Grito do Ipiranga'],
            ['dia' => 21, 'mes' => 9, 'titulo' => 'Dia da Árvore', 'descricao' => 'Conscientização ambiental'],
            ['dia' => 22, 'mes' => 9, 'titulo' => 'Início da Primavera', 'descricao' => 'Equinócio de primavera'],
            ['dia' => 23, 'mes' => 9, 'titulo' => 'Dia Nacional de Combate ao Câncer Infantil', 'descricao' => 'Conscientização sobre o câncer infantil'],
            
            // Outubro
            ['dia' => 4, 'mes' => 10, 'titulo' => 'Dia Mundial dos Animais', 'descricao' => 'Proteção animal'],
            ['dia' => 5, 'mes' => 10, 'titulo' => 'Dia Mundial dos Professores', 'descricao' => 'Valorização do magistério'],
            ['dia' => 12, 'mes' => 10, 'titulo' => 'Nossa Senhora Aparecida', 'descricao' => 'Feriado nacional - Padroeira do Brasil'],
            ['dia' => 15, 'mes' => 10, 'titulo' => 'Dia do Professor', 'descricao' => 'Homenagem aos educadores'],
            ['dia' => 16, 'mes' => 10, 'titulo' => 'Dia Mundial da Alimentação', 'descricao' => 'Combate à fome'],
            ['dia' => 17, 'mes' => 10, 'titulo' => 'Dia da Indústria', 'descricao' => 'Desenvolvimento industrial'],
            ['dia' => 31, 'mes' => 10, 'titulo' => 'Dia das Bruxas (Halloween)', 'descricao' => 'Tradição internacional'],
            
            // Novembro
            ['dia' => 2, 'mes' => 11, 'titulo' => 'Finados', 'descricao' => 'Feriado nacional - Dia dos Mortos'],
            ['dia' => 15, 'mes' => 11, 'titulo' => 'Proclamação da República', 'descricao' => 'Feriado nacional - Fim do Império'],
            ['dia' => 19, 'mes' => 11, 'titulo' => 'Dia da Bandeira', 'descricao' => 'Símbolo nacional'],
            ['dia' => 20, 'mes' => 11, 'titulo' => 'Dia da Consciência Negra', 'descricao' => 'Valorização da cultura afro-brasileira'],
            
            // Dezembro
            ['dia' => 1, 'mes' => 12, 'titulo' => 'Dia Mundial de Combate à AIDS', 'descricao' => 'Prevenção e conscientização'],
            ['dia' => 3, 'mes' => 12, 'titulo' => 'Dia Internacional da Pessoa com Deficiência', 'descricao' => 'Inclusão social'],
            ['dia' => 10, 'mes' => 12, 'titulo' => 'Dia dos Direitos Humanos', 'descricao' => 'Declaração Universal dos Direitos Humanos'],
            ['dia' => 25, 'mes' => 12, 'titulo' => 'Natal', 'descricao' => 'Feriado nacional - Nascimento de Jesus Cristo'],
            ['dia' => 31, 'mes' => 12, 'titulo' => 'Réveillon', 'descricao' => 'Passagem de ano'],
        ];
        
        // Datas comemorativas municipais (exemplos genéricos)
        $datasMunicipais = [
            ['dia' => 1, 'mes' => 1, 'titulo' => 'Aniversário do Município', 'descricao' => 'Fundação da cidade - Ajustar data conforme município'],
            ['dia' => 15, 'mes' => 3, 'titulo' => 'Dia do Servidor Municipal', 'descricao' => 'Homenagem aos servidores públicos municipais'],
            ['dia' => 23, 'mes' => 4, 'titulo' => 'Dia do Município', 'descricao' => 'Celebração da emancipação política'],
            ['dia' => 29, 'mes' => 6, 'titulo' => 'Festa do Padroeiro', 'descricao' => 'Celebração religiosa local - Ajustar conforme padroeiro'],
            ['dia' => 15, 'mes' => 8, 'titulo' => 'Semana da Pátria Municipal', 'descricao' => 'Atividades cívicas locais'],
            ['dia' => 1, 'mes' => 10, 'titulo' => 'Semana da Criança', 'descricao' => 'Atividades para o público infantil'],
            ['dia' => 22, 'mes' => 11, 'titulo' => 'Dia da Música Municipal', 'descricao' => 'Valorização da cultura musical local'],
        ];
        
        // Inserir datas nacionais
        foreach ($datasNacionais as $data) {
            $dataEvento = Carbon::create($ano, $data['mes'], $data['dia']);
            
            // Verificar se já existe
            $eventoExistente = Evento::where('titulo', $data['titulo'])
                                   ->where('data_evento', $dataEvento->format('Y-m-d'))
                                   ->first();
            
            if (!$eventoExistente) {
                Evento::create([
                    'titulo' => $data['titulo'],
                    'descricao' => $data['descricao'],
                    'tipo' => 'data_comemorativa',
                    'data_evento' => $dataEvento,
                    'hora_inicio' => null,
                    'hora_fim' => null,
                    'local' => 'Nacional',
                    'observacoes' => 'Data comemorativa nacional inserida automaticamente',
                    'destaque' => in_array($data['mes'], [1, 4, 5, 7, 9, 10, 11, 12]) && 
                                 in_array($data['dia'], [1, 21, 1, 9, 7, 12, 2, 15, 25]), // Feriados nacionais
                    'cor_destaque' => '#28a745', // Verde para datas comemorativas
                    'ativo' => true,
                ]);
            }
        }
        
        // Inserir datas municipais
        foreach ($datasMunicipais as $data) {
            $dataEvento = Carbon::create($ano, $data['mes'], $data['dia']);
            
            // Verificar se já existe
            $eventoExistente = Evento::where('titulo', $data['titulo'])
                                   ->where('data_evento', $dataEvento->format('Y-m-d'))
                                   ->first();
            
            if (!$eventoExistente) {
                Evento::create([
                    'titulo' => $data['titulo'],
                    'descricao' => $data['descricao'],
                    'tipo' => 'data_comemorativa',
                    'data_evento' => $dataEvento,
                    'hora_inicio' => null,
                    'hora_fim' => null,
                    'local' => 'Municipal',
                    'observacoes' => 'Data comemorativa municipal - Ajustar conforme necessário',
                    'destaque' => true, // Destacar datas municipais
                    'cor_destaque' => '#007bff', // Azul para datas municipais
                    'ativo' => true,
                ]);
            }
        }
        
        // Criar eventos para o próximo ano também
        $proximoAno = $ano + 1;
        
        // Inserir datas nacionais para o próximo ano
        foreach ($datasNacionais as $data) {
            $dataEvento = Carbon::create($proximoAno, $data['mes'], $data['dia']);
            
            // Verificar se já existe
            $eventoExistente = Evento::where('titulo', $data['titulo'])
                                   ->where('data_evento', $dataEvento->format('Y-m-d'))
                                   ->first();
            
            if (!$eventoExistente) {
                Evento::create([
                    'titulo' => $data['titulo'],
                    'descricao' => $data['descricao'],
                    'tipo' => 'data_comemorativa',
                    'data_evento' => $dataEvento,
                    'hora_inicio' => null,
                    'hora_fim' => null,
                    'local' => 'Nacional',
                    'observacoes' => 'Data comemorativa nacional inserida automaticamente',
                    'destaque' => in_array($data['mes'], [1, 4, 5, 7, 9, 10, 11, 12]) && 
                                 in_array($data['dia'], [1, 21, 1, 9, 7, 12, 2, 15, 25]),
                    'cor_destaque' => '#28a745',
                    'ativo' => true,
                ]);
            }
        }
        
        // Inserir datas municipais para o próximo ano
        foreach ($datasMunicipais as $data) {
            $dataEvento = Carbon::create($proximoAno, $data['mes'], $data['dia']);
            
            // Verificar se já existe
            $eventoExistente = Evento::where('titulo', $data['titulo'])
                                   ->where('data_evento', $dataEvento->format('Y-m-d'))
                                   ->first();
            
            if (!$eventoExistente) {
                Evento::create([
                    'titulo' => $data['titulo'],
                    'descricao' => $data['descricao'],
                    'tipo' => 'data_comemorativa',
                    'data_evento' => $dataEvento,
                    'hora_inicio' => null,
                    'hora_fim' => null,
                    'local' => 'Municipal',
                    'observacoes' => 'Data comemorativa municipal - Ajustar conforme necessário',
                    'destaque' => true,
                    'cor_destaque' => '#007bff',
                    'ativo' => true,
                ]);
            }
        }
        
        $this->command->info('Datas comemorativas inseridas com sucesso!');
        $this->command->info('Total de eventos criados para ' . $ano . ' e ' . $proximoAno);
        $this->command->info('Lembre-se de ajustar as datas municipais conforme a realidade local.');
    }
}