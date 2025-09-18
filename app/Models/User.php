<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, SoftDeletes;

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
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
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
            'password' => 'hashed',
        ];
    }

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'email_verified_at',
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
        return $this->hasMany(Documento::class, 'autor_id');
    }

    /**
     * Solicitações e-SIC criadas pelo usuário
     */
    public function solicitacoesEsic(): HasMany
    {
        return $this->hasMany(EsicSolicitacao::class, 'solicitante_id');
    }

    /**
     * Solicitações e-SIC atribuídas ao usuário para resposta
     */
    public function solicitacoesEsicResponsavel(): HasMany
    {
        return $this->hasMany(EsicSolicitacao::class, 'responsavel_id');
    }

    // Scopes - Removidos temporariamente até implementar sistema de roles

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
