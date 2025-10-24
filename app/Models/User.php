<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Traits\HasRoles;

/**
 * @method bool isAdmin()
 * @method bool isUser()
 * @method bool isActive()
 * @method bool canAccessAdmin()
 * @method bool canManageContent()
 * @method bool canManageUsers()
 */
class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'email_verified_at',
        'email_verification_token',
        'role',
        'cargo',
        'setor',
        'observacoes',
        'active',
        'terms_accepted_at',
        'privacy_accepted_at',
        'phone',
        'birth_date',
        'address',
        'last_login_at',
        // Campos de cidadão migrados
        'cpf',
        'rg',
        'data_nascimento',
        'sexo',
        'estado_civil',
        'profissao',
        'telefone',
        'celular',
        'cep',
        'endereco',
        'numero',
        'complemento',
        'bairro',
        'cidade',
        'estado',
        'titulo_eleitor',
        'zona_eleitoral',
        'secao_eleitoral',
        'status_verificacao',
        'motivo_rejeicao',
        'verificado_em',
        'verificado_por',
        'pode_assinar',
        'pode_criar_comite',
        // Campos de ouvidor migrados
        'especialidade',
        'bio',
        'foto',
        'pode_gerenciar_esic',
        'pode_gerenciar_ouvidoria',
        'pode_visualizar_relatorios',
        'pode_responder_manifestacoes',
        'recebe_notificacao_email',
        'recebe_notificacao_sistema',
        'data_inicio_ouvidor',
        'data_fim_ouvidor',
        'ramal',
        'tipo_ouvidor',
        // Campos específicos de ouvidor para views
        'cargo_ouvidor',
        'setor_ouvidor',
        'especialidade_ouvidor',
        'ativo_ouvidor',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'email_verification_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'terms_accepted_at' => 'datetime',
            'privacy_accepted_at' => 'datetime',
            'password' => 'hashed',
            'active' => 'boolean',
            'birth_date' => 'date',
            'last_login_at' => 'datetime',
            'verificado_em' => 'datetime',
            // Casts para campos de ouvidor
            'pode_gerenciar_esic' => 'boolean',
            'pode_gerenciar_ouvidoria' => 'boolean',
            'pode_visualizar_relatorios' => 'boolean',
            'pode_responder_manifestacoes' => 'boolean',
            'recebe_notificacao_email' => 'boolean',
            'recebe_notificacao_sistema' => 'boolean',
            'data_inicio_ouvidor' => 'date',
            'data_fim_ouvidor' => 'date',
            'ativo_ouvidor' => 'boolean',
        ];
    }

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'email_verified_at',
        'terms_accepted_at',
        'privacy_accepted_at',
        'created_at',
        'updated_at',
    ];

    // Relacionamentos

    /**
     * Notícias criadas pelo usuário
     */
    public function noticias(): HasMany
    {
        return $this->hasMany(Noticia::class, 'autor_id');
    }

    /**
     * Sessões criadas pelo usuário
     */
    public function sessoes(): HasMany
    {
        return $this->hasMany(Sessao::class, 'secretario_id');
    }

    /**
     * Projetos de lei criados pelo usuário
     */
    public function projetosLei(): HasMany
    {
        return $this->hasMany(ProjetoLei::class, 'autor_id');
    }

    /**
     * Documentos criados pelo usuário
     */
    public function documentos(): HasMany
    {
        return $this->hasMany(Documento::class, 'usuario_upload_id');
    }

    /**
     * Solicitações e-SIC criadas pelo usuário
     */
    public function solicitacoesEsic(): HasMany
    {
        return $this->hasMany(EsicSolicitacao::class, 'user_id');
    }

    /**
     * Solicitações e-SIC atribuídas ao usuário para resposta
     */
    public function solicitacoesEsicResponsavel(): HasMany
    {
        return $this->hasMany(EsicSolicitacao::class, 'responsavel_id');
    }

    /**
     * Assinaturas eletrônicas do cidadão (baseada no CPF)
     */
    public function assinaturas(): HasMany
    {
        return $this->hasMany(AssinaturaEletronica::class, 'cpf', 'cpf');
    }

    /**
     * Comitês criados pelo cidadão (baseada no CPF)
     */
    public function comites(): HasMany
    {
        return $this->hasMany(ComiteIniciativaPopular::class, 'cpf', 'cpf');
    }

    /**
     * Manifestações de ouvidoria atribuídas ao ouvidor como responsável
     */
    public function manifestacoesResponsavel(): HasMany
    {
        return $this->hasMany(OuvidoriaManifestacao::class, 'ouvidor_responsavel_id');
    }

    /**
     * Manifestações de ouvidoria respondidas pelo ouvidor
     */
    public function manifestacoesRespondidas(): HasMany
    {
        return $this->hasMany(OuvidoriaManifestacao::class, 'respondida_por');
    }

    /**
     * Manifestações de ouvidoria atribuídas ao ouvidor (alias para manifestacoesResponsavel)
     */
    public function manifestacoesAtribuidas(): HasMany
    {
        return $this->manifestacoesResponsavel();
    }

    /**
     * Dados do cidadão (se o usuário for um cidadão)
     * NOTA: Os dados do cidadão agora estão diretamente no modelo User
     * Esta relação foi removida após a unificação dos modelos User e Cidadao
     */

    /**
     * Métodos de cidadão para compatibilidade
     */
    public function isVerificado(): bool
    {
        return $this->status_verificacao === 'verificado';
    }

    public function isAtivo(): bool
    {
        return $this->active && $this->role === 'cidadao';
    }

    public function aceitouTermos(): bool
    {
        return !is_null($this->terms_accepted_at);
    }

    public function podeAssinar(): bool
    {
        return $this->isAtivo() && $this->isVerificado() && $this->aceitouTermos();
    }

    public function podeCriarComite(): bool
    {
        return $this->podeAssinar();
    }

    /**
     * Verifica se o cidadão já assinou um comitê específico
     */
    public function jaAssinou($comiteId): bool
    {
        return $this->assinaturas()
                    ->where('comite_iniciativa_popular_id', $comiteId)
                    ->where('ativo', true)
                    ->exists();
    }

    /**
     * Accessor para nome_completo (compatibilidade)
     */
    public function getNomeCompletoAttribute(): string
    {
        return $this->name;
    }

    // Métodos de Role e Permissões

    /**
     * Verifica se o usuário é administrador
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin' && $this->active;
    }

    /**
     * Verifica se o usuário é um cidadão
     */
    public function isCidadao(): bool
    {
        return $this->role === 'cidadao' && $this->active;
    }

    /**
     * Verifica se o usuário é secretário
     */
    public function isSecretario(): bool
    {
        return $this->role === 'secretario' && $this->active;
    }

    /**
     * Verifica se o usuário é vereador
     */
    public function isVereador(): bool
    {
        return $this->role === 'vereador' && $this->active;
    }

    /**
     * Verifica se o usuário é presidente da câmara
     */
    public function isPresidente(): bool
    {
        return $this->role === 'presidente' && $this->active;
    }

    /**
     * Verifica se o usuário é funcionário
     */
    public function isFuncionario(): bool
    {
        return $this->role === 'funcionario' && $this->active;
    }

    /**
     * Verifica se o usuário é ouvidor
     */
    public function isOuvidor(): bool
    {
        return $this->role === 'ouvidor' && $this->active;
    }

    /**
     * Verifica se o usuário é um usuário comum (mantido para compatibilidade)
     * @deprecated Use isCidadao() instead
     */
    public function isUser(): bool
    {
        return $this->isCidadao();
    }

    /**
     * Verifica se o usuário está ativo
     */
    public function isActive(): bool
    {
        return $this->active;
    }

    /**
     * Verifica se o usuário tem permissão para acessar área administrativa
     */
    public function canAccessAdmin(): bool
    {
        return $this->isAdmin() || $this->isSecretario() || $this->isPresidente() || 
               ($this->isOuvidor() && ($this->pode_gerenciar_ouvidoria || $this->pode_gerenciar_esic));
    }

    /**
     * Verifica se o usuário pode gerenciar conteúdo
     */
    public function canManageContent(): bool
    {
        return $this->isAdmin() || $this->isSecretario();
    }

    /**
     * Verifica se o usuário pode gerenciar usuários
     */
    public function canManageUsers(): bool
    {
        return $this->isAdmin();
    }

    /**
     * Verifica se o usuário pode gerenciar sessões
     */
    public function canManageSessoes(): bool
    {
        return $this->isAdmin() || $this->isSecretario() || $this->isPresidente();
    }

    /**
     * Verifica se o usuário pode criar projetos de lei
     */
    public function canCreateProjetosLei(): bool
    {
        return $this->isAdmin() || $this->isVereador() || $this->isPresidente();
    }

    /**
     * Verifica se o usuário pode responder e-SIC
     */
    public function canResponderEsic(): bool
    {
        return $this->isAdmin() || $this->isSecretario() || $this->isFuncionario() || $this->isOuvidor();
    }

    /**
     * Verifica se o usuário pode gerenciar ouvidoria
     */
    public function canGerenciarOuvidoria(): bool
    {
        return $this->isAdmin() || ($this->isOuvidor() && $this->pode_gerenciar_ouvidoria);
    }

    /**
     * Verifica se o usuário pode responder manifestações de ouvidoria
     */
    public function canResponderManifestacoes(): bool
    {
        return $this->isAdmin() || ($this->isOuvidor() && $this->pode_responder_manifestacoes);
    }

    /**
     * Verifica se o usuário pode visualizar relatórios de ouvidoria
     */
    public function canVisualizarRelatorios(): bool
    {
        return $this->isAdmin() || ($this->isOuvidor() && $this->pode_visualizar_relatorios);
    }

    // Scopes

    /**
     * Scope para filtrar apenas administradores
     */
    public function scopeAdmins($query)
    {
        return $query->where('role', 'admin');
    }

    /**
     * Scope para filtrar apenas cidadãos
     */
    public function scopeCidadaos($query)
    {
        return $query->where('role', 'cidadao');
    }

    /**
     * Scope para filtrar apenas secretários
     */
    public function scopeSecretarios($query)
    {
        return $query->where('role', 'secretario');
    }

    /**
     * Scope para filtrar apenas vereadores
     */
    public function scopeVereadores($query)
    {
        return $query->where('role', 'vereador');
    }

    /**
     * Scope para filtrar apenas presidentes
     */
    public function scopePresidentes($query)
    {
        return $query->where('role', 'presidente');
    }

    /**
     * Scope para filtrar apenas funcionários
     */
    public function scopeFuncionarios($query)
    {
        return $query->where('role', 'funcionario');
    }

    /**
     * Scope para filtrar apenas ouvidores
     */
    public function scopeOuvidores($query)
    {
        return $query->where('role', 'ouvidor');
    }

    /**
     * Scope para filtrar apenas usuários comuns (mantido para compatibilidade)
     * @deprecated Use scopeCidadaos() instead
     */
    public function scopeUsers($query)
    {
        return $query->where('role', 'cidadao');
    }

    /**
     * Scope para filtrar usuários com acesso administrativo
     */
    public function scopeAdministrativos($query)
    {
        return $query->whereIn('role', ['admin', 'secretario', 'presidente']);
    }

    /**
     * Scope para filtrar membros da câmara
     */
    public function scopeMembrosCamara($query)
    {
        return $query->whereIn('role', ['vereador', 'presidente', 'secretario']);
    }

    /**
     * Scope para filtrar apenas usuários ativos
     */
    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    // Accessors

    /**
     * Get the user's avatar URL
     */
    public function getAvatarUrlAttribute(): string
    {
        // Gravatar como fallback
        $hash = md5(strtolower(trim($this->email)));
        return "https://www.gravatar.com/avatar/{$hash}?d=identicon&s=200";
    }

    // Mutators

    /**
     * Set the user's password
     */
    public function setPasswordAttribute($value): void
    {
        if ($value) {
            $this->attributes['password'] = Hash::make($value);
        }
    }

    /**
     * Set the user's email
     */
    public function setEmailAttribute($value): void
    {
        $this->attributes['email'] = strtolower(trim($value));
    }

    /**
     * Set the user's CPF
     */
    public function setCpfAttribute($value): void
    {
        if ($value) {
            $this->attributes['cpf'] = preg_replace('/[^0-9]/', '', $value);
        }
    }

    /**
     * Set the user's telefone
     */
    public function setTelefoneAttribute($value): void
    {
        if ($value) {
            $this->attributes['telefone'] = preg_replace('/[^0-9]/', '', $value);
        }
    }

    /**
     * Get CPF attribute - format with mask
     */
    public function getCpfFormattedAttribute(): string
    {
        if (!$this->cpf) {
            return '';
        }
        
        $cpf = preg_replace('/[^0-9]/', '', $this->cpf);
        if (strlen($cpf) === 11) {
            return substr($cpf, 0, 3) . '.' . substr($cpf, 3, 3) . '.' . substr($cpf, 6, 3) . '-' . substr($cpf, 9, 2);
        }
        
        return $this->cpf;
    }

    // Métodos auxiliares - Removidos temporariamente até implementar sistema de roles

    /**
     * Get user's initials for avatar
     */
    public function getInitials(): string
    {
        $words = explode(' ', $this->name);
        $initials = '';
        
        foreach ($words as $word) {
            if (strlen($word) > 0) {
                $initials .= strtoupper($word[0]);
            }
            if (strlen($initials) >= 2) break;
        }
        
        return $initials ?: 'U';
    }

    /**
     * Validações customizadas
     */
    public static function rules($id = null): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => $id ? 'nullable|min:8' : 'required|min:8',
        ];
    }

    /**
     * Boot method
     */
    protected static function boot()
    {
        parent::boot();

        static::updating(function ($user) {
            if ($user->isDirty('email')) {
                $user->email_verified_at = null;
            }
        });
    }
}
