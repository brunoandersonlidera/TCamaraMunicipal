<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Sessao;
use App\Models\TipoSessao;
use Carbon\Carbon;

class SessaoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buscar tipos de sessão para relacionamento
        $tipoOrdinaria = TipoSessao::where('slug', 'sessao-ordinaria')->first();
        $tipoExtraordinaria = TipoSessao::where('slug', 'sessao-extraordinaria')->first();
        $tipoSolene = TipoSessao::where('slug', 'sessao-solene')->first();

        $sessoes = [
            [
                'numero_sessao' => '001/2024',
                'tipo' => 'ordinaria',
                'tipo_sessao_id' => $tipoOrdinaria?->id,
                'data_sessao' => Carbon::parse('2024-02-05'),
                'hora_inicio' => Carbon::parse('19:00'),
                'hora_fim' => Carbon::parse('21:30'),
                'status' => 'finalizada',
                'legislatura' => 2024,
                'video_url' => 'https://www.youtube.com/watch?v=example1',
                'plataforma_video' => 'youtube',
                'thumbnail_url' => 'https://img.youtube.com/vi/example1/maxresdefault.jpg',
                'video_disponivel' => true,
                'data_gravacao' => Carbon::parse('2024-02-05 19:00'),
                'descricao_video' => '1ª Sessão Ordinária de 2024 - Câmara Municipal',
                'observacoes' => 'Primeira sessão do ano legislativo de 2024',
            ],
            [
                'numero_sessao' => '002/2024',
                'tipo' => 'ordinaria',
                'tipo_sessao_id' => $tipoOrdinaria?->id,
                'data_sessao' => Carbon::parse('2024-02-19'),
                'hora_inicio' => Carbon::parse('19:00'),
                'hora_fim' => Carbon::parse('20:45'),
                'status' => 'finalizada',
                'legislatura' => 2024,
                'video_url' => 'https://www.youtube.com/watch?v=example2',
                'plataforma_video' => 'youtube',
                'thumbnail_url' => 'https://img.youtube.com/vi/example2/maxresdefault.jpg',
                'video_disponivel' => true,
                'data_gravacao' => Carbon::parse('2024-02-19 19:00'),
                'descricao_video' => '2ª Sessão Ordinária de 2024 - Câmara Municipal',
                'observacoes' => 'Discussão de projetos de lei municipais',
            ],
            [
                'numero_sessao' => '003/2024',
                'tipo' => 'extraordinaria',
                'tipo_sessao_id' => $tipoExtraordinaria?->id,
                'data_sessao' => Carbon::parse('2024-03-01'),
                'hora_inicio' => Carbon::parse('14:00'),
                'hora_fim' => Carbon::parse('16:30'),
                'status' => 'finalizada',
                'legislatura' => 2024,
                'video_url' => 'https://www.youtube.com/watch?v=example3',
                'plataforma_video' => 'youtube',
                'thumbnail_url' => 'https://img.youtube.com/vi/example3/maxresdefault.jpg',
                'video_disponivel' => true,
                'data_gravacao' => Carbon::parse('2024-03-01 14:00'),
                'descricao_video' => 'Sessão Extraordinária - Orçamento Municipal 2024',
                'observacoes' => 'Sessão especial para aprovação do orçamento',
            ],
            [
                'numero_sessao' => '004/2024',
                'tipo' => 'ordinaria',
                'tipo_sessao_id' => $tipoOrdinaria?->id,
                'data_sessao' => Carbon::parse('2024-03-18'),
                'hora_inicio' => Carbon::parse('19:00'),
                'hora_fim' => Carbon::parse('21:15'),
                'status' => 'finalizada',
                'legislatura' => 2024,
                'video_url' => 'https://www.youtube.com/watch?v=example4',
                'plataforma_video' => 'youtube',
                'thumbnail_url' => 'https://img.youtube.com/vi/example4/maxresdefault.jpg',
                'video_disponivel' => true,
                'data_gravacao' => Carbon::parse('2024-03-18 19:00'),
                'descricao_video' => '4ª Sessão Ordinária de 2024 - Câmara Municipal',
                'observacoes' => 'Votação de projetos em segunda discussão',
            ],
            [
                'numero_sessao' => '005/2024',
                'tipo' => 'solene',
                'tipo_sessao_id' => $tipoSolene?->id,
                'data_sessao' => Carbon::parse('2024-04-22'),
                'hora_inicio' => Carbon::parse('10:00'),
                'hora_fim' => Carbon::parse('12:00'),
                'status' => 'finalizada',
                'legislatura' => 2024,
                'video_url' => null,
                'plataforma_video' => null,
                'thumbnail_url' => null,
                'video_disponivel' => false,
                'data_gravacao' => null,
                'descricao_video' => null,
                'observacoes' => 'Sessão comemorativa ao Dia do Descobrimento do Brasil',
            ],
            [
                'numero_sessao' => '006/2024',
                'tipo' => 'ordinaria',
                'tipo_sessao_id' => $tipoOrdinaria?->id,
                'data_sessao' => Carbon::parse('2024-05-06'),
                'hora_inicio' => Carbon::parse('19:00'),
                'hora_fim' => Carbon::parse('20:30'),
                'status' => 'finalizada',
                'legislatura' => 2024,
                'video_url' => null,
                'plataforma_video' => null,
                'thumbnail_url' => null,
                'video_disponivel' => false,
                'data_gravacao' => null,
                'descricao_video' => null,
                'observacoes' => 'Discussão sobre obras públicas municipais',
            ],
            [
                'numero_sessao' => '007/2024',
                'tipo' => 'ordinaria',
                'tipo_sessao_id' => $tipoOrdinaria?->id,
                'data_sessao' => Carbon::parse('2024-05-20'),
                'hora_inicio' => Carbon::parse('19:00'),
                'hora_fim' => Carbon::parse('21:45'),
                'status' => 'finalizada',
                'legislatura' => 2024,
                'video_url' => null,
                'plataforma_video' => null,
                'thumbnail_url' => null,
                'video_disponivel' => false,
                'data_gravacao' => null,
                'descricao_video' => null,
                'observacoes' => 'Prestação de contas do primeiro quadrimestre',
            ],
            [
                'numero_sessao' => '008/2024',
                'tipo' => 'extraordinaria',
                'tipo_sessao_id' => $tipoExtraordinaria?->id,
                'data_sessao' => Carbon::parse('2024-06-10'),
                'hora_inicio' => Carbon::parse('15:00'),
                'hora_fim' => Carbon::parse('17:20'),
                'status' => 'finalizada',
                'legislatura' => 2024,
                'video_url' => null,
                'plataforma_video' => null,
                'thumbnail_url' => null,
                'video_disponivel' => false,
                'data_gravacao' => null,
                'descricao_video' => null,
                'observacoes' => 'Discussão e votação do novo Plano Diretor',
            ],
        ];

        foreach ($sessoes as $sessaoData) {
            Sessao::updateOrCreate(
                ['numero_sessao' => $sessaoData['numero_sessao']],
                $sessaoData
            );
        }
    }
}
