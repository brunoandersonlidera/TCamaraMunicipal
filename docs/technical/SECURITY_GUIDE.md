# Guia de Segurança - TCamaraMunicipal

## Visão Geral

Este documento detalha as práticas de segurança implementadas no sistema TCamaraMunicipal, incluindo autenticação, autorização, proteção de dados, conformidade com LGPD e procedimentos de segurança operacional.

## Arquitetura de Segurança

### Camadas de Proteção

1. **Infraestrutura** - Firewall, SSL/TLS, Fail2Ban
2. **Aplicação** - Autenticação, autorização, validação
3. **Dados** - Criptografia, backup, anonimização
4. **Usuário** - Políticas de senha, 2FA, treinamento

### Princípios de Segurança

- **Defesa em Profundidade** - Múltiplas camadas de proteção
- **Menor Privilégio** - Acesso mínimo necessário
- **Segregação de Funções** - Separação de responsabilidades
- **Auditoria Contínua** - Logs e monitoramento
- **Segurança por Design** - Proteção desde o desenvolvimento

## Autenticação e Autorização

### Sistema de Autenticação

#### Tipos de Usuário
```php
// Hierarquia de usuários
1. Super Admin (system.admin)
2. Administrador (admin.*)
3. Ouvidor (ouvidor.*)
4. Editor (editor.*)
5. Cidadão (public.*)
```

#### Políticas de Senha
```php
// Configurações em config/auth.php
'password_requirements' => [
    'min_length' => 8,
    'require_uppercase' => true,
    'require_lowercase' => true,
    'require_numbers' => true,
    'require_symbols' => true,
    'max_age_days' => 90,
    'history_count' => 5,
    'max_attempts' => 5,
    'lockout_duration' => 900, // 15 minutos
]
```

#### Autenticação Multifator (2FA)
```php
// Implementação recomendada
use PragmaRX\Google2FA\Google2FA;

// Configurar 2FA para administradores
'two_factor' => [
    'enabled' => env('TWO_FACTOR_ENABLED', false),
    'required_for_admin' => true,
    'backup_codes_count' => 8,
    'window' => 4, // ±2 minutos
]
```

### Sistema de Permissões

#### Estrutura de Permissões
```php
// Formato: módulo.ação
'permissions' => [
    // Sistema
    'system.admin' => 'Administração do Sistema',
    'system.users' => 'Gerenciar Usuários',
    'system.permissions' => 'Gerenciar Permissões',
    
    // Conteúdo
    'content.noticias.create' => 'Criar Notícias',
    'content.noticias.edit' => 'Editar Notícias',
    'content.noticias.delete' => 'Excluir Notícias',
    
    // Transparência
    'transparency.view' => 'Visualizar Transparência',
    'transparency.manage' => 'Gerenciar Transparência',
    
    // Ouvidoria
    'ouvidor.view' => 'Visualizar Manifestações',
    'ouvidor.respond' => 'Responder Manifestações',
    
    // E-SIC
    'esic.view' => 'Visualizar Solicitações',
    'esic.respond' => 'Responder Solicitações',
]
```

#### Middleware de Autorização
```php
// app/Http/Middleware/CheckPermission.php
public function handle($request, Closure $next, $permission)
{
    if (!auth()->user()->hasPermission($permission)) {
        abort(403, 'Acesso negado');
    }
    
    // Log da tentativa de acesso
    Log::info('Permission check', [
        'user_id' => auth()->id(),
        'permission' => $permission,
        'ip' => $request->ip(),
        'user_agent' => $request->userAgent(),
    ]);
    
    return $next($request);
}
```

## Proteção de Dados

### Criptografia

#### Dados em Trânsito
```apache
# Configuração SSL/TLS no Apache
SSLEngine on
SSLProtocol all -SSLv2 -SSLv3 -TLSv1 -TLSv1.1
SSLCipherSuite ECDHE-ECDSA-AES256-GCM-SHA384:ECDHE-RSA-AES256-GCM-SHA384
SSLHonorCipherOrder on
SSLCompression off
SSLSessionTickets off

# HSTS
Header always set Strict-Transport-Security "max-age=31536000; includeSubDomains; preload"
```

#### Dados em Repouso
```php
// Criptografia de campos sensíveis
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;

class User extends Model
{
    protected $casts = [
        'cpf' => 'encrypted',
        'telefone' => 'encrypted',
        'endereco' => 'encrypted',
    ];
    
    // Accessor para CPF
    public function getCpfAttribute($value)
    {
        try {
            return $value ? Crypt::decryptString($value) : null;
        } catch (DecryptException $e) {
            return null;
        }
    }
    
    // Mutator para CPF
    public function setCpfAttribute($value)
    {
        $this->attributes['cpf'] = $value ? Crypt::encryptString($value) : null;
    }
}
```

### Sanitização de Dados

#### Validação de Input
```php
// app/Http/Requests/BaseRequest.php
class BaseRequest extends FormRequest
{
    protected function prepareForValidation()
    {
        // Sanitizar dados de entrada
        $input = $this->all();
        
        array_walk_recursive($input, function (&$value) {
            if (is_string($value)) {
                // Remover tags HTML perigosas
                $value = strip_tags($value, '<p><br><strong><em><ul><ol><li>');
                
                // Escapar caracteres especiais
                $value = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
                
                // Remover scripts
                $value = preg_replace('/<script\b[^<]*(?:(?!<\/script>)<[^<]*)*<\/script>/mi', '', $value);
            }
        });
        
        $this->replace($input);
    }
}
```

#### Proteção XSS
```php
// Helper para output seguro
function safe_output($text, $allowedTags = '<p><br><strong><em><ul><ol><li>')
{
    return strip_tags($text, $allowedTags);
}

// Blade directive personalizada
Blade::directive('safe', function ($expression) {
    return "<?php echo safe_output($expression); ?>";
});
```

### Proteção CSRF

#### Configuração
```php
// config/session.php
'same_site' => 'strict',
'secure' => env('SESSION_SECURE_COOKIE', true),
'http_only' => true,

// Middleware CSRF em todas as rotas POST/PUT/DELETE
Route::middleware(['web', 'csrf'])->group(function () {
    // Rotas protegidas
});
```

#### Implementação em JavaScript
```javascript
// Configurar token CSRF globalmente
window.axios.defaults.headers.common['X-CSRF-TOKEN'] = 
    document.querySelector('meta[name="csrf-token"]').getAttribute('content');

// Verificar token em requisições AJAX
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
```

## Conformidade com LGPD

### Princípios Implementados

1. **Finalidade** - Dados coletados apenas para fins específicos
2. **Adequação** - Tratamento compatível com finalidades
3. **Necessidade** - Limitação ao mínimo necessário
4. **Livre Acesso** - Consulta facilitada e gratuita
5. **Qualidade dos Dados** - Exatidão, clareza e atualização
6. **Transparência** - Informações claras sobre tratamento
7. **Segurança** - Medidas técnicas e administrativas
8. **Prevenção** - Medidas para evitar danos
9. **Não Discriminação** - Vedação de tratamento discriminatório
10. **Responsabilização** - Demonstração de conformidade

### Implementação Técnica

#### Consentimento
```php
// Model para controle de consentimento
class ConsentRecord extends Model
{
    protected $fillable = [
        'user_id',
        'purpose',
        'consent_given',
        'consent_date',
        'ip_address',
        'user_agent',
        'withdrawn_at',
    ];
    
    protected $casts = [
        'consent_given' => 'boolean',
        'consent_date' => 'datetime',
        'withdrawn_at' => 'datetime',
    ];
}

// Middleware para verificar consentimento
class CheckConsent
{
    public function handle($request, Closure $next, $purpose)
    {
        $user = auth()->user();
        
        if (!$user->hasConsentFor($purpose)) {
            return redirect()->route('consent.form', ['purpose' => $purpose]);
        }
        
        return $next($request);
    }
}
```

#### Direitos do Titular
```php
// Controller para exercício de direitos
class DataRightsController extends Controller
{
    // Direito de acesso
    public function exportData(Request $request)
    {
        $user = auth()->user();
        
        $data = [
            'personal_data' => $user->getPersonalData(),
            'activity_log' => $user->getActivityLog(),
            'consents' => $user->getConsentHistory(),
        ];
        
        return response()->json($data)
            ->header('Content-Disposition', 'attachment; filename="meus_dados.json"');
    }
    
    // Direito de retificação
    public function updateData(UpdateDataRequest $request)
    {
        $user = auth()->user();
        $user->update($request->validated());
        
        // Log da alteração
        ActivityLog::create([
            'user_id' => $user->id,
            'action' => 'data_updated',
            'description' => 'Dados pessoais atualizados pelo titular',
            'ip_address' => $request->ip(),
        ]);
        
        return response()->json(['message' => 'Dados atualizados com sucesso']);
    }
    
    // Direito de eliminação
    public function deleteData(Request $request)
    {
        $user = auth()->user();
        
        // Anonimizar dados em vez de excluir (para manter integridade)
        $user->anonymize();
        
        // Log da eliminação
        ActivityLog::create([
            'user_id' => $user->id,
            'action' => 'data_deleted',
            'description' => 'Dados pessoais eliminados a pedido do titular',
            'ip_address' => $request->ip(),
        ]);
        
        return response()->json(['message' => 'Dados eliminados com sucesso']);
    }
}
```

#### Anonimização de Dados
```php
// Trait para anonimização
trait Anonymizable
{
    public function anonymize()
    {
        $this->update([
            'name' => 'Usuário Anônimo',
            'email' => 'anonimo_' . $this->id . '@anonimo.local',
            'cpf' => null,
            'telefone' => null,
            'endereco' => null,
            'data_nascimento' => null,
            'anonymized_at' => now(),
        ]);
        
        // Manter apenas dados necessários para auditoria
        $this->consents()->delete();
        $this->sessions()->delete();
    }
}
```

### Relatórios de Conformidade

#### Relatório de Impacto (RIPD)
```php
// Command para gerar relatório
class GeneratePrivacyImpactReport extends Command
{
    public function handle()
    {
        $report = [
            'period' => [
                'start' => now()->subMonth()->startOfMonth(),
                'end' => now()->subMonth()->endOfMonth(),
            ],
            'data_processing' => [
                'new_users' => User::whereBetween('created_at', [...])->count(),
                'data_requests' => DataRequest::whereBetween('created_at', [...])->count(),
                'consent_withdrawals' => ConsentRecord::whereNotNull('withdrawn_at')->count(),
            ],
            'security_incidents' => SecurityIncident::whereBetween('created_at', [...])->get(),
            'compliance_status' => $this->checkCompliance(),
        ];
        
        Storage::put('reports/privacy_impact_' . now()->format('Y_m') . '.json', 
                    json_encode($report, JSON_PRETTY_PRINT));
    }
}
```

## Auditoria e Logs

### Sistema de Logs

#### Configuração de Logs
```php
// config/logging.php
'channels' => [
    'security' => [
        'driver' => 'daily',
        'path' => storage_path('logs/security.log'),
        'level' => 'info',
        'days' => 90,
    ],
    'audit' => [
        'driver' => 'daily',
        'path' => storage_path('logs/audit.log'),
        'level' => 'info',
        'days' => 365,
    ],
    'access' => [
        'driver' => 'daily',
        'path' => storage_path('logs/access.log'),
        'level' => 'info',
        'days' => 30,
    ],
]
```

#### Middleware de Auditoria
```php
class AuditMiddleware
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);
        
        // Log de acesso
        Log::channel('access')->info('Request processed', [
            'user_id' => auth()->id(),
            'ip' => $request->ip(),
            'method' => $request->method(),
            'url' => $request->fullUrl(),
            'user_agent' => $request->userAgent(),
            'status_code' => $response->getStatusCode(),
            'timestamp' => now(),
        ]);
        
        return $response;
    }
}
```

#### Eventos de Segurança
```php
// Event Listeners para eventos de segurança
class SecurityEventListener
{
    public function handleLogin($event)
    {
        Log::channel('security')->info('User login', [
            'user_id' => $event->user->id,
            'ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'timestamp' => now(),
        ]);
    }
    
    public function handleFailedLogin($event)
    {
        Log::channel('security')->warning('Failed login attempt', [
            'email' => $event->credentials['email'] ?? 'unknown',
            'ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'timestamp' => now(),
        ]);
    }
    
    public function handlePermissionDenied($event)
    {
        Log::channel('security')->warning('Permission denied', [
            'user_id' => auth()->id(),
            'permission' => $event->permission,
            'resource' => $event->resource,
            'ip' => request()->ip(),
            'timestamp' => now(),
        ]);
    }
}
```

### Monitoramento de Segurança

#### Detecção de Anomalias
```php
// Job para detectar atividades suspeitas
class DetectSuspiciousActivity extends Job
{
    public function handle()
    {
        // Múltiplos logins de IPs diferentes
        $suspiciousLogins = DB::table('activity_logs')
            ->where('action', 'login')
            ->where('created_at', '>', now()->subHour())
            ->groupBy('user_id')
            ->havingRaw('COUNT(DISTINCT ip_address) > 3')
            ->get();
            
        foreach ($suspiciousLogins as $login) {
            $this->alertSuspiciousActivity('multiple_ip_login', $login);
        }
        
        // Tentativas de força bruta
        $bruteForceAttempts = DB::table('activity_logs')
            ->where('action', 'failed_login')
            ->where('created_at', '>', now()->subMinutes(15))
            ->groupBy('ip_address')
            ->havingRaw('COUNT(*) > 10')
            ->get();
            
        foreach ($bruteForceAttempts as $attempt) {
            $this->alertSuspiciousActivity('brute_force', $attempt);
        }
    }
    
    private function alertSuspiciousActivity($type, $data)
    {
        // Enviar alerta para administradores
        Notification::send(
            User::admins()->get(),
            new SuspiciousActivityAlert($type, $data)
        );
        
        // Log do incidente
        Log::channel('security')->critical('Suspicious activity detected', [
            'type' => $type,
            'data' => $data,
            'timestamp' => now(),
        ]);
    }
}
```

## Backup e Recuperação

### Estratégia de Backup

#### Configuração de Backup
```php
// config/backup.php
return [
    'backup' => [
        'name' => env('APP_NAME', 'tcamara'),
        'source' => [
            'files' => [
                'include' => [
                    base_path(),
                ],
                'exclude' => [
                    base_path('vendor'),
                    base_path('node_modules'),
                    base_path('storage/logs'),
                ],
            ],
            'databases' => [
                'mysql',
            ],
        ],
        'destination' => [
            'filename_prefix' => '',
            'disks' => [
                'backup',
                's3', // Backup remoto
            ],
        ],
    ],
    'notifications' => [
        'notifications' => [
            \Spatie\Backup\Notifications\Notifications\BackupHasFailed::class => ['mail'],
            \Spatie\Backup\Notifications\Notifications\BackupWasSuccessful::class => ['mail'],
        ],
        'notifiable' => \App\Notifications\BackupNotifiable::class,
    ],
    'monitor_backups' => [
        [
            'name' => env('APP_NAME', 'tcamara'),
            'disks' => ['backup', 's3'],
            'health_checks' => [
                \Spatie\Backup\Tasks\Monitor\HealthChecks\MaximumAgeInDays::class => 1,
                \Spatie\Backup\Tasks\Monitor\HealthChecks\MaximumStorageInMegabytes::class => 5000,
            ],
        ],
    ],
];
```

#### Criptografia de Backup
```bash
#!/bin/bash
# Script de backup criptografado

BACKUP_DIR="/var/backups/tcamara"
DATE=$(date +%Y%m%d_%H%M%S)
GPG_RECIPIENT="admin@tcamara.gov.br"

# Criar backup
php artisan backup:run

# Criptografar backup
gpg --trust-model always --encrypt -r $GPG_RECIPIENT \
    $BACKUP_DIR/tcamara_$DATE.zip

# Remover backup não criptografado
rm $BACKUP_DIR/tcamara_$DATE.zip

# Upload para armazenamento remoto seguro
aws s3 cp $BACKUP_DIR/tcamara_$DATE.zip.gpg \
    s3://tcamara-backups-encrypted/ \
    --server-side-encryption AES256
```

### Plano de Recuperação

#### Procedimentos de Restore
```bash
#!/bin/bash
# Script de recuperação de desastre

# 1. Parar serviços
systemctl stop apache2
systemctl stop mysql

# 2. Baixar backup mais recente
aws s3 cp s3://tcamara-backups-encrypted/latest.zip.gpg /tmp/

# 3. Descriptografar
gpg --decrypt /tmp/latest.zip.gpg > /tmp/backup.zip

# 4. Extrair backup
unzip /tmp/backup.zip -d /tmp/restore/

# 5. Restaurar banco de dados
mysql -u root -p < /tmp/restore/database.sql

# 6. Restaurar arquivos
rsync -av /tmp/restore/files/ /var/www/tcamara/

# 7. Configurar permissões
chown -R www-data:www-data /var/www/tcamara
chmod -R 755 /var/www/tcamara

# 8. Reiniciar serviços
systemctl start mysql
systemctl start apache2

# 9. Verificar integridade
php artisan migrate:status
php artisan queue:restart
```

## Resposta a Incidentes

### Plano de Resposta

#### Classificação de Incidentes
1. **Crítico** - Comprometimento de dados pessoais
2. **Alto** - Acesso não autorizado ao sistema
3. **Médio** - Tentativas de invasão bloqueadas
4. **Baixo** - Atividades suspeitas detectadas

#### Procedimentos de Resposta
```php
// Classe para gerenciar incidentes
class SecurityIncidentManager
{
    public function reportIncident($type, $severity, $description, $evidence = [])
    {
        $incident = SecurityIncident::create([
            'type' => $type,
            'severity' => $severity,
            'description' => $description,
            'evidence' => json_encode($evidence),
            'reported_at' => now(),
            'status' => 'open',
        ]);
        
        // Notificar equipe de segurança
        $this->notifySecurityTeam($incident);
        
        // Executar resposta automática se necessário
        if ($severity === 'critical') {
            $this->executeEmergencyResponse($incident);
        }
        
        return $incident;
    }
    
    private function executeEmergencyResponse($incident)
    {
        // Bloquear IPs suspeitos
        if ($incident->type === 'brute_force') {
            $this->blockSuspiciousIPs($incident);
        }
        
        // Invalidar sessões se necessário
        if ($incident->type === 'data_breach') {
            $this->invalidateAllSessions();
        }
        
        // Ativar modo de manutenção se crítico
        if ($incident->severity === 'critical') {
            Artisan::call('down', ['--message' => 'Sistema em manutenção por motivos de segurança']);
        }
    }
}
```

### Comunicação de Incidentes

#### Notificação à ANPD
```php
// Template para notificação de vazamento
class DataBreachNotification
{
    public function generateReport($incident)
    {
        return [
            'incident_id' => $incident->id,
            'occurred_at' => $incident->created_at,
            'detected_at' => $incident->detected_at,
            'type' => $incident->type,
            'affected_data_types' => $incident->affected_data_types,
            'affected_users_count' => $incident->affected_users_count,
            'risk_assessment' => $incident->risk_assessment,
            'mitigation_measures' => $incident->mitigation_measures,
            'notification_timeline' => [
                'detection' => $incident->detected_at,
                'containment' => $incident->contained_at,
                'anpd_notification' => now()->addHours(72), // Prazo legal
                'user_notification' => now()->addDays(1),
            ],
        ];
    }
}
```

## Configurações de Segurança

### Configuração do Servidor

#### Hardening do Apache
```apache
# Ocultar versão do servidor
ServerTokens Prod
ServerSignature Off

# Desabilitar métodos HTTP desnecessários
<Location />
    <LimitExcept GET POST HEAD>
        Require all denied
    </LimitExcept>
</Location>

# Configurar timeouts
Timeout 60
KeepAliveTimeout 15

# Limitar tamanho de requisições
LimitRequestBody 10485760  # 10MB
LimitRequestFields 100
LimitRequestFieldSize 1024
LimitRequestLine 4094

# Headers de segurança
Header always set X-Content-Type-Options nosniff
Header always set X-Frame-Options DENY
Header always set X-XSS-Protection "1; mode=block"
Header always set Referrer-Policy "strict-origin-when-cross-origin"
Header always set Content-Security-Policy "default-src 'self'; script-src 'self' 'unsafe-inline'; style-src 'self' 'unsafe-inline'"
```

#### Configuração do MySQL
```sql
-- Configurações de segurança do MySQL
SET GLOBAL validate_password.policy = STRONG;
SET GLOBAL validate_password.length = 12;
SET GLOBAL validate_password.mixed_case_count = 1;
SET GLOBAL validate_password.number_count = 1;
SET GLOBAL validate_password.special_char_count = 1;

-- Remover usuários anônimos
DELETE FROM mysql.user WHERE User='';

-- Remover banco de dados de teste
DROP DATABASE IF EXISTS test;

-- Configurar SSL
SET GLOBAL require_secure_transport = ON;
```

### Configuração da Aplicação

#### Configurações de Segurança no .env
```env
# Configurações de sessão
SESSION_LIFETIME=120
SESSION_ENCRYPT=true
SESSION_SECURE_COOKIE=true
SESSION_SAME_SITE=strict

# Configurações de segurança
APP_DEBUG=false
APP_ENV=production
LOG_LEVEL=error

# Rate limiting
RATE_LIMIT_ENABLED=true
RATE_LIMIT_ATTEMPTS=60
RATE_LIMIT_DECAY_MINUTES=1

# Configurações de upload
MAX_UPLOAD_SIZE=10240  # 10MB
ALLOWED_FILE_TYPES=pdf,doc,docx,jpg,jpeg,png,gif

# Configurações de email
MAIL_ENCRYPTION=tls
MAIL_VERIFY_PEER=true

# Configurações de backup
BACKUP_ENABLED=true
BACKUP_ENCRYPTION=true
BACKUP_RETENTION_DAYS=90
```

## Checklist de Segurança

### Desenvolvimento
- [ ] Validação de todos os inputs
- [ ] Sanitização de outputs
- [ ] Proteção CSRF implementada
- [ ] Autenticação e autorização adequadas
- [ ] Logs de auditoria configurados
- [ ] Testes de segurança executados

### Deploy
- [ ] Certificado SSL configurado
- [ ] Firewall configurado
- [ ] Fail2Ban ativo
- [ ] Backups automatizados
- [ ] Monitoramento ativo
- [ ] Logs centralizados

### Operação
- [ ] Atualizações de segurança aplicadas
- [ ] Logs revisados regularmente
- [ ] Backups testados
- [ ] Incidentes documentados
- [ ] Treinamento da equipe atualizado
- [ ] Políticas de segurança revisadas

## Treinamento e Conscientização

### Programa de Treinamento

#### Para Desenvolvedores
- Secure coding practices
- OWASP Top 10
- Testes de segurança
- Revisão de código

#### Para Administradores
- Configuração segura de servidores
- Monitoramento de segurança
- Resposta a incidentes
- Backup e recuperação

#### Para Usuários Finais
- Políticas de senha
- Phishing e engenharia social
- Uso seguro do sistema
- Relatório de incidentes

### Recursos de Treinamento

#### Documentação Interna
- Políticas de segurança
- Procedimentos operacionais
- Guias de resposta a incidentes
- Checklist de segurança

#### Recursos Externos
- OWASP Security Guidelines
- NIST Cybersecurity Framework
- LGPD - Lei Geral de Proteção de Dados
- ISO 27001 - Gestão de Segurança da Informação

## Contatos de Emergência

### Equipe de Segurança
- **Responsável pela Segurança:** security@tcamara.gov.br
- **Administrador de Sistema:** admin@tcamara.gov.br
- **DPO (Data Protection Officer):** dpo@tcamara.gov.br

### Autoridades
- **ANPD:** https://www.gov.br/anpd/
- **CERT.br:** https://www.cert.br/
- **Polícia Civil - Crimes Cibernéticos:** 197

### Fornecedores
- **Provedor de Hospedagem:** [contato do provedor]
- **Empresa de Backup:** [contato da empresa]
- **Consultoria de Segurança:** [contato da consultoria]

---

**Última atualização:** 21 de Janeiro de 2025  
**Versão:** 1.0  
**Próxima revisão:** 21 de Julho de 2025