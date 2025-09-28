<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;
use App\Models\User;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Limpar cache de permissões
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Criar permissões por módulo
        $this->createPermissions();
        
        // Criar roles
        $this->createRoles();
        
        // Atribuir permissões aos roles
        $this->assignPermissionsToRoles();
        
        // Migrar usuários existentes
        $this->migrateExistingUsers();
    }

    private function createPermissions()
    {
        $permissions = [
            // Módulo Notícias
            ['name' => 'noticias.view', 'display_name' => 'Visualizar Notícias', 'description' => 'Pode visualizar notícias', 'module' => 'noticias', 'action' => 'view', 'is_system' => true],
            ['name' => 'noticias.create', 'display_name' => 'Criar Notícias', 'description' => 'Pode criar novas notícias', 'module' => 'noticias', 'action' => 'create', 'is_system' => true],
            ['name' => 'noticias.edit', 'display_name' => 'Editar Notícias', 'description' => 'Pode editar notícias existentes', 'module' => 'noticias', 'action' => 'edit', 'is_system' => true],
            ['name' => 'noticias.delete', 'display_name' => 'Excluir Notícias', 'description' => 'Pode excluir notícias', 'module' => 'noticias', 'action' => 'delete', 'is_system' => true],
            ['name' => 'noticias.publish', 'display_name' => 'Publicar Notícias', 'description' => 'Pode publicar/despublicar notícias', 'module' => 'noticias', 'action' => 'publish', 'is_system' => true],

            // Módulo Usuários
            ['name' => 'users.view', 'display_name' => 'Visualizar Usuários', 'description' => 'Pode visualizar lista de usuários', 'module' => 'usuarios', 'action' => 'view', 'is_system' => true],
            ['name' => 'users.create', 'display_name' => 'Criar Usuários', 'description' => 'Pode criar novos usuários', 'module' => 'usuarios', 'action' => 'create', 'is_system' => true],
            ['name' => 'users.edit', 'display_name' => 'Editar Usuários', 'description' => 'Pode editar dados de usuários', 'module' => 'usuarios', 'action' => 'edit', 'is_system' => true],
            ['name' => 'users.delete', 'display_name' => 'Excluir Usuários', 'description' => 'Pode excluir usuários', 'module' => 'usuarios', 'action' => 'delete', 'is_system' => true],
            ['name' => 'users.permissions', 'display_name' => 'Gerenciar Permissões', 'description' => 'Pode gerenciar permissões de usuários', 'module' => 'usuarios', 'action' => 'manage', 'is_system' => true],

            // Módulo e-SIC
            ['name' => 'esic.view', 'display_name' => 'Visualizar e-SIC', 'description' => 'Pode visualizar solicitações e-SIC', 'module' => 'esic', 'action' => 'view', 'is_system' => true],
            ['name' => 'esic.respond', 'display_name' => 'Responder e-SIC', 'description' => 'Pode responder solicitações e-SIC', 'module' => 'esic', 'action' => 'edit', 'is_system' => true],
            ['name' => 'esic.manage', 'display_name' => 'Gerenciar e-SIC', 'description' => 'Pode gerenciar todo o sistema e-SIC', 'module' => 'esic', 'action' => 'manage', 'is_system' => true],

            // Módulo Ouvidoria
            ['name' => 'ouvidoria.view', 'display_name' => 'Visualizar Ouvidoria', 'description' => 'Pode visualizar manifestações da ouvidoria', 'module' => 'ouvidoria', 'action' => 'view', 'is_system' => true],
            ['name' => 'ouvidoria.respond', 'display_name' => 'Responder Ouvidoria', 'description' => 'Pode responder manifestações da ouvidoria', 'module' => 'ouvidoria', 'action' => 'edit', 'is_system' => true],
            ['name' => 'ouvidoria.manage', 'display_name' => 'Gerenciar Ouvidoria', 'description' => 'Pode gerenciar todo o sistema de ouvidoria', 'module' => 'ouvidoria', 'action' => 'manage', 'is_system' => true],

            // Módulo Legislação
            ['name' => 'legislacao.view', 'display_name' => 'Visualizar Legislação', 'description' => 'Pode visualizar projetos e leis', 'module' => 'legislacao', 'action' => 'view', 'is_system' => true],
            ['name' => 'legislacao.create', 'display_name' => 'Criar Legislação', 'description' => 'Pode criar projetos de lei', 'module' => 'legislacao', 'action' => 'create', 'is_system' => true],
            ['name' => 'legislacao.edit', 'display_name' => 'Editar Legislação', 'description' => 'Pode editar projetos e leis', 'module' => 'legislacao', 'action' => 'edit', 'is_system' => true],
            ['name' => 'legislacao.approve', 'display_name' => 'Aprovar Legislação', 'description' => 'Pode aprovar projetos de lei', 'module' => 'legislacao', 'action' => 'approve', 'is_system' => true],

            // Módulo Vereadores
            ['name' => 'vereadores.view', 'display_name' => 'Visualizar Vereadores', 'description' => 'Pode visualizar dados dos vereadores', 'module' => 'vereadores', 'action' => 'view', 'is_system' => true],
            ['name' => 'vereadores.edit', 'display_name' => 'Editar Vereadores', 'description' => 'Pode editar dados dos vereadores', 'module' => 'vereadores', 'action' => 'edit', 'is_system' => true],
            ['name' => 'vereadores.manage', 'display_name' => 'Gerenciar Vereadores', 'description' => 'Pode gerenciar cadastro de vereadores', 'module' => 'vereadores', 'action' => 'manage', 'is_system' => true],

            // Módulo Sessões
            ['name' => 'sessoes.view', 'display_name' => 'Visualizar Sessões', 'description' => 'Pode visualizar sessões da câmara', 'module' => 'sessoes', 'action' => 'view', 'is_system' => true],
            ['name' => 'sessoes.create', 'display_name' => 'Criar Sessões', 'description' => 'Pode criar novas sessões', 'module' => 'sessoes', 'action' => 'create', 'is_system' => true],
            ['name' => 'sessoes.edit', 'display_name' => 'Editar Sessões', 'description' => 'Pode editar sessões existentes', 'module' => 'sessoes', 'action' => 'edit', 'is_system' => true],

            // Módulo Transparência
            ['name' => 'transparencia.view', 'display_name' => 'Visualizar Transparência', 'description' => 'Pode visualizar dados de transparência', 'module' => 'transparencia', 'action' => 'view', 'is_system' => true],
            ['name' => 'transparencia.manage', 'display_name' => 'Gerenciar Transparência', 'description' => 'Pode gerenciar dados de transparência', 'module' => 'transparencia', 'action' => 'manage', 'is_system' => true],

            // Módulo Protocolo
            ['name' => 'protocolo.view', 'display_name' => 'Visualizar Protocolos', 'description' => 'Pode visualizar protocolos', 'module' => 'protocolo', 'action' => 'view', 'is_system' => true],
            ['name' => 'protocolo.create', 'display_name' => 'Criar Protocolos', 'description' => 'Pode criar novos protocolos', 'module' => 'protocolo', 'action' => 'create', 'is_system' => true],
            ['name' => 'protocolo.manage', 'display_name' => 'Gerenciar Protocolos', 'description' => 'Pode gerenciar sistema de protocolo', 'module' => 'protocolo', 'action' => 'manage', 'is_system' => true],

            // Módulo Administração
            ['name' => 'admin.dashboard', 'display_name' => 'Dashboard Admin', 'description' => 'Pode acessar dashboard administrativo', 'module' => 'admin', 'action' => 'view', 'is_system' => true],
            ['name' => 'admin.config', 'display_name' => 'Configurações', 'description' => 'Pode alterar configurações do sistema', 'module' => 'admin', 'action' => 'manage', 'is_system' => true],
            ['name' => 'admin.logs', 'display_name' => 'Visualizar Logs', 'description' => 'Pode visualizar logs do sistema', 'module' => 'admin', 'action' => 'view', 'is_system' => true],

            // Módulo Sistema
            ['name' => 'system.roles', 'display_name' => 'Gerenciar Roles', 'description' => 'Pode gerenciar tipos de usuários', 'module' => 'sistema', 'action' => 'manage', 'is_system' => true],
            ['name' => 'system.permissions', 'display_name' => 'Gerenciar Permissões', 'description' => 'Pode gerenciar permissões do sistema', 'module' => 'sistema', 'action' => 'manage', 'is_system' => true],
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(
                ['name' => $permission['name']],
                $permission
            );
        }
    }

    private function createRoles()
    {
        $roles = [
            [
                'name' => 'cidadao',
                'display_name' => 'Cidadão',
                'description' => 'Usuário comum do sistema, pode fazer solicitações e acompanhar processos',
                'color' => '#6B7280',
                'is_system' => true,
                'priority' => 1
            ],
            [
                'name' => 'secretario',
                'display_name' => 'Secretário/Assessor',
                'description' => 'Pode gerenciar conteúdo e responder solicitações',
                'color' => '#3B82F6',
                'is_system' => true,
                'priority' => 5
            ],
            [
                'name' => 'responsavel_esic',
                'display_name' => 'Responsável e-SIC',
                'description' => 'Especialista em transparência e acesso à informação',
                'color' => '#10B981',
                'is_system' => true,
                'priority' => 6
            ],
            [
                'name' => 'ouvidor',
                'display_name' => 'Ouvidor',
                'description' => 'Responsável por manifestações da ouvidoria',
                'color' => '#F59E0B',
                'is_system' => true,
                'priority' => 6
            ],
            [
                'name' => 'vereador',
                'display_name' => 'Vereador',
                'description' => 'Vereador da câmara municipal',
                'color' => '#8B5CF6',
                'is_system' => true,
                'priority' => 8
            ],
            [
                'name' => 'presidente',
                'display_name' => 'Presidente da Câmara',
                'description' => 'Presidente da câmara municipal',
                'color' => '#DC2626',
                'is_system' => true,
                'priority' => 10
            ],
            [
                'name' => 'editor',
                'display_name' => 'Editor de Conteúdo',
                'description' => 'Pode criar e editar conteúdo do site',
                'color' => '#06B6D4',
                'is_system' => true,
                'priority' => 4
            ],
            [
                'name' => 'protocolo',
                'display_name' => 'Protocolo',
                'description' => 'Responsável pelo protocolo de documentos',
                'color' => '#84CC16',
                'is_system' => true,
                'priority' => 3
            ],
            [
                'name' => 'contador',
                'display_name' => 'Contador/Financeiro',
                'description' => 'Responsável por dados financeiros e transparência',
                'color' => '#EF4444',
                'is_system' => true,
                'priority' => 7
            ],
            [
                'name' => 'admin',
                'display_name' => 'Administrador Geral',
                'description' => 'Acesso total ao sistema',
                'color' => '#1F2937',
                'is_system' => true,
                'priority' => 100
            ]
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(
                ['name' => $role['name']],
                $role
            );
        }
    }

    private function assignPermissionsToRoles()
    {
        // Cidadão - sem permissões especiais (apenas acesso público)
        
        // Secretário/Assessor
        $secretario = Role::where('name', 'secretario')->first();
        $secretario->givePermissionTo([
            'noticias.view', 'noticias.create', 'noticias.edit',
            'esic.view', 'esic.respond',
            'ouvidoria.view', 'ouvidoria.respond',
            'admin.dashboard'
        ]);

        // Responsável e-SIC
        $responsavelEsic = Role::where('name', 'responsavel_esic')->first();
        $responsavelEsic->givePermissionTo([
            'esic.view', 'esic.respond', 'esic.manage',
            'transparencia.view', 'transparencia.manage',
            'admin.dashboard'
        ]);

        // Ouvidor
        $ouvidor = Role::where('name', 'ouvidor')->first();
        $ouvidor->givePermissionTo([
            'ouvidoria.view', 'ouvidoria.respond', 'ouvidoria.manage',
            'admin.dashboard'
        ]);

        // Vereador
        $vereador = Role::where('name', 'vereador')->first();
        $vereador->givePermissionTo([
            'legislacao.view', 'legislacao.create', 'legislacao.edit',
            'sessoes.view',
            'vereadores.view', 'vereadores.edit',
            'admin.dashboard'
        ]);

        // Presidente da Câmara
        $presidente = Role::where('name', 'presidente')->first();
        $presidente->givePermissionTo([
            'legislacao.view', 'legislacao.create', 'legislacao.edit', 'legislacao.approve',
            'sessoes.view', 'sessoes.create', 'sessoes.edit',
            'vereadores.view', 'vereadores.edit', 'vereadores.manage',
            'noticias.view', 'noticias.create', 'noticias.edit', 'noticias.publish',
            'admin.dashboard'
        ]);

        // Editor de Conteúdo
        $editor = Role::where('name', 'editor')->first();
        $editor->givePermissionTo([
            'noticias.view', 'noticias.create', 'noticias.edit', 'noticias.publish',
            'admin.dashboard'
        ]);

        // Protocolo
        $protocolo = Role::where('name', 'protocolo')->first();
        $protocolo->givePermissionTo([
            'protocolo.view', 'protocolo.create', 'protocolo.manage',
            'admin.dashboard'
        ]);

        // Contador/Financeiro
        $contador = Role::where('name', 'contador')->first();
        $contador->givePermissionTo([
            'transparencia.view', 'transparencia.manage',
            'noticias.view', 'noticias.create', 'noticias.edit', // Exemplo do contador que pode publicar notícias
            'admin.dashboard'
        ]);

        // Administrador Geral - todas as permissões
        $admin = Role::where('name', 'admin')->first();
        $admin->givePermissionTo(Permission::all());
    }

    private function migrateExistingUsers()
    {
        // Migrar usuários existentes baseado no campo 'role'
        $adminUsers = User::where('role', 'admin')->get();
        foreach ($adminUsers as $user) {
            $user->assignRole('admin');
        }

        $regularUsers = User::where('role', 'user')->get();
        foreach ($regularUsers as $user) {
            $user->assignRole('cidadao');
        }
    }
}
