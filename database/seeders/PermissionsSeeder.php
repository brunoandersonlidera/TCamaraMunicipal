<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\User;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Definir permissões por módulo
        $permissions = [
            // Usuários
            'usuarios' => [
                'usuarios.listar' => 'Listar usuários',
                'usuarios.criar' => 'Criar usuários',
                'usuarios.editar' => 'Editar usuários',
                'usuarios.excluir' => 'Excluir usuários',
                'usuarios.impersonificar' => 'Fazer login como outro usuário',
                'usuarios.gerenciar_roles' => 'Gerenciar roles de usuários',
            ],
            
            // Roles
            'roles' => [
                'roles.listar' => 'Listar roles',
                'roles.criar' => 'Criar roles',
                'roles.editar' => 'Editar roles',
                'roles.excluir' => 'Excluir roles',
            ],
            
            // Permissões
            'permissoes' => [
                'permissoes.listar' => 'Listar permissões',
                'permissoes.criar' => 'Criar permissões',
                'permissoes.editar' => 'Editar permissões',
                'permissoes.excluir' => 'Excluir permissões',
            ],
            
            // Vereadores
            'vereadores' => [
                'vereadores.listar' => 'Listar vereadores',
                'vereadores.criar' => 'Criar vereadores',
                'vereadores.editar' => 'Editar vereadores',
                'vereadores.excluir' => 'Excluir vereadores',
            ],
            
            // Notícias
            'noticias' => [
                'noticias.listar' => 'Listar notícias',
                'noticias.criar' => 'Criar notícias',
                'noticias.editar' => 'Editar notícias',
                'noticias.excluir' => 'Excluir notícias',
                'noticias.publicar' => 'Publicar/despublicar notícias',
            ],
            
            // Sessões
            'sessoes' => [
                'sessoes.listar' => 'Listar sessões',
                'sessoes.criar' => 'Criar sessões',
                'sessoes.editar' => 'Editar sessões',
                'sessoes.excluir' => 'Excluir sessões',
            ],
            
            // Documentos
            'documentos' => [
                'documentos.listar' => 'Listar documentos',
                'documentos.criar' => 'Criar documentos',
                'documentos.editar' => 'Editar documentos',
                'documentos.excluir' => 'Excluir documentos',
            ],
            
            // Transparência
            'transparencia' => [
                'transparencia.listar' => 'Listar dados de transparência',
                'transparencia.criar' => 'Criar dados de transparência',
                'transparencia.editar' => 'Editar dados de transparência',
                'transparencia.excluir' => 'Excluir dados de transparência',
            ],
            
            // Configurações
            'configuracoes' => [
                'configuracoes.visualizar' => 'Visualizar configurações',
                'configuracoes.editar' => 'Editar configurações do sistema',
            ],
            
            // Dashboard
            'dashboard' => [
                'dashboard.acessar' => 'Acessar painel administrativo',
            ],
        ];

        // Criar permissões
        foreach ($permissions as $module => $modulePermissions) {
            foreach ($modulePermissions as $name => $displayName) {
                // Extrair a ação do nome da permissão
                $action = explode('.', $name)[1] ?? 'manage';
                
                Permission::firstOrCreate([
                    'name' => $name,
                    'guard_name' => 'web',
                ], [
                    'display_name' => $displayName,
                    'module' => $module,
                    'action' => $action,
                    'description' => "Permissão para {$displayName}",
                    'is_system' => true,
                    'is_active' => true,
                    'priority' => 1,
                ]);
            }
        }

        // Criar role de Super Admin
        $superAdminRole = Role::firstOrCreate([
            'name' => 'super-admin',
            'guard_name' => 'web',
        ], [
            'display_name' => 'Super Administrador',
            'description' => 'Acesso total ao sistema',
            'color' => '#DC2626',
            'is_system' => true,
            'is_active' => true,
            'priority' => 1,
        ]);

        // Atribuir todas as permissões ao Super Admin
        $allPermissions = Permission::all();
        $superAdminRole->syncPermissions($allPermissions);

        // Criar role de Admin
        $adminRole = Role::firstOrCreate([
            'name' => 'admin',
            'guard_name' => 'web',
        ], [
            'display_name' => 'Administrador',
            'description' => 'Administrador do sistema',
            'color' => '#2563EB',
            'is_system' => true,
            'is_active' => true,
            'priority' => 2,
        ]);

        // Atribuir permissões básicas ao Admin
        $adminPermissions = Permission::whereIn('name', [
            'dashboard.acessar',
            'usuarios.listar',
            'usuarios.criar',
            'usuarios.editar',
            'usuarios.gerenciar_roles',
            'roles.listar',
            'permissoes.listar',
            'vereadores.listar',
            'vereadores.criar',
            'vereadores.editar',
            'noticias.listar',
            'noticias.criar',
            'noticias.editar',
            'noticias.publicar',
            'sessoes.listar',
            'sessoes.criar',
            'sessoes.editar',
            'documentos.listar',
            'documentos.criar',
            'documentos.editar',
            'transparencia.listar',
            'configuracoes.visualizar',
        ])->get();
        
        $adminRole->syncPermissions($adminPermissions);

        // Atribuir role de Super Admin ao primeiro usuário admin
        $firstAdmin = User::where('role', 'admin')->first();
        if ($firstAdmin) {
            $firstAdmin->assignRole('super-admin');
            $this->command->info("Role 'super-admin' atribuída ao usuário: {$firstAdmin->email}");
        }

        $this->command->info('Permissões e roles criados com sucesso!');
    }
}
