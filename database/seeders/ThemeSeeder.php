<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Theme;

class ThemeSeeder extends Seeder
{
    public function run(): void
    {
        $themes = [
            [
                'name' => 'Outubro Rosa',
                'slug' => 'outubro-rosa',
                'primary_color' => '#e83e8c',
                'secondary_color' => '#ff6fa8',
                'accent_color' => '#d63384',
                'menu_bg' => 'linear-gradient(135deg, #e83e8c 0%, #ff6fa8 100%)',
                'footer_bg' => 'linear-gradient(135deg, #e83e8c 0%, #ff6fa8 100%)',
                'section_bg' => '#fff0f6',
                'is_active' => false,
                'is_scheduled' => true,
                'start_date' => now()->startOfMonth()->setMonth(10),
                'end_date' => now()->startOfMonth()->setMonth(10)->endOfMonth(),
            ],
            [
                'name' => 'Novembro Azul',
                'slug' => 'novembro-azul',
                'primary_color' => '#007bff',
                'secondary_color' => '#0056b3',
                'accent_color' => '#0d6efd',
                'menu_bg' => 'linear-gradient(135deg, #007bff 0%, #0056b3 100%)',
                'footer_bg' => 'linear-gradient(135deg, #007bff 0%, #0056b3 100%)',
                'section_bg' => '#f0f7ff',
                'is_active' => false,
                'is_scheduled' => true,
                'start_date' => now()->startOfMonth()->setMonth(11),
                'end_date' => now()->startOfMonth()->setMonth(11)->endOfMonth(),
            ],
            [
                'name' => 'Setembro Amarelo',
                'slug' => 'setembro-amarelo',
                'primary_color' => '#ffc107',
                'secondary_color' => '#e0a800',
                'accent_color' => '#ffcd39',
                'menu_bg' => 'linear-gradient(135deg, #ffc107 0%, #e0a800 100%)',
                'footer_bg' => 'linear-gradient(135deg, #ffc107 0%, #e0a800 100%)',
                'section_bg' => '#fff9e6',
                'is_active' => false,
                'is_scheduled' => true,
                'start_date' => now()->startOfMonth()->setMonth(9),
                'end_date' => now()->startOfMonth()->setMonth(9)->endOfMonth(),
            ],
            [
                'name' => 'Natal',
                'slug' => 'natal',
                'primary_color' => '#dc3545',
                'secondary_color' => '#28a745',
                'accent_color' => '#c82333',
                'menu_bg' => 'linear-gradient(135deg, #dc3545 0%, #28a745 100%)',
                'footer_bg' => 'linear-gradient(135deg, #dc3545 0%, #28a745 100%)',
                'section_bg' => '#fff5f5',
                'is_active' => false,
                'is_scheduled' => true,
                'start_date' => now()->setMonth(12)->startOfMonth(),
                'end_date' => now()->setMonth(12)->endOfMonth(),
            ],
            // Novos temas padrão
            [
                'name' => 'Padrão Verde',
                'slug' => 'padrao-verde',
                'primary_color' => '#28a745',
                'secondary_color' => '#20c997',
                'accent_color' => '#2ecc71',
                'menu_bg' => 'linear-gradient(135deg, #28a745 0%, #20c997 100%)',
                'footer_bg' => 'linear-gradient(135deg, #28a745 0%, #20c997 100%)',
                'section_bg' => '#f3fff6',
                'is_active' => false,
                'is_scheduled' => false,
            ],
            [
                'name' => 'Padrão Vermelho',
                'slug' => 'padrao-vermelho',
                'primary_color' => '#dc3545',
                'secondary_color' => '#c82333',
                'accent_color' => '#ff4d4f',
                'menu_bg' => 'linear-gradient(135deg, #dc3545 0%, #c82333 100%)',
                'footer_bg' => 'linear-gradient(135deg, #dc3545 0%, #c82333 100%)',
                'section_bg' => '#fff5f5',
                'is_active' => false,
                'is_scheduled' => false,
            ],
            [
                'name' => 'Padrão Azul',
                'slug' => 'padrao-azul',
                'primary_color' => '#0d6efd',
                'secondary_color' => '#0b5ed7',
                'accent_color' => '#1e90ff',
                'menu_bg' => 'linear-gradient(135deg, #0d6efd 0%, #0b5ed7 100%)',
                'footer_bg' => 'linear-gradient(135deg, #0d6efd 0%, #0b5ed7 100%)',
                'section_bg' => '#f0f7ff',
                'is_active' => false,
                'is_scheduled' => false,
            ],
            [
                'name' => 'Padrão Luto',
                'slug' => 'padrao-luto',
                'primary_color' => '#000000',
                'secondary_color' => '#343a40',
                'accent_color' => '#212529',
                'menu_bg' => 'linear-gradient(135deg, #000000 0%, #343a40 100%)',
                'footer_bg' => 'linear-gradient(135deg, #000000 0%, #343a40 100%)',
                'section_bg' => '#f8f9fa',
                'is_active' => false,
                'is_scheduled' => false,
                // Habilitar lacinho de luto por padrão (opcional)
                'ribbon_enabled' => true,
                'ribbon_variant' => 'mourning_black',
            ],
        ];

        foreach ($themes as $data) {
            Theme::updateOrCreate(['slug' => $data['slug']], $data);
        }
    }
}