<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperação de Senha - Câmara Municipal</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f8fafc;
        }
        
        .email-container {
            background: white;
            border-radius: 12px;
            padding: 40px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #e2e8f0;
        }
        
        .logo {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, var(--theme-primary, #f59e0b), var(--theme-accent, #d97706));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            color: white;
            font-size: 2rem;
        }
        
        .title {
            color: #1f2937;
            font-size: 24px;
            font-weight: bold;
            margin: 0;
        }
        
        .subtitle {
            color: #6b7280;
            font-size: 16px;
            margin: 5px 0 0 0;
        }
        
        .content {
            margin-bottom: 30px;
        }
        
        .greeting {
            font-size: 18px;
            color: #1f2937;
            margin-bottom: 20px;
        }
        
        .message {
            color: #4b5563;
            margin-bottom: 25px;
            line-height: 1.7;
        }
        
        .reset-button {
            display: inline-block;
            background: linear-gradient(135deg, var(--theme-primary, #f59e0b), var(--theme-accent, #d97706));
            color: white;
            text-decoration: none;
            padding: 15px 30px;
            border-radius: 8px;
            font-weight: bold;
            font-size: 16px;
            text-align: center;
            margin: 20px 0;
            transition: all 0.3s ease;
        }
        
        .reset-button:hover {
            background: linear-gradient(135deg, var(--theme-accent, #d97706), var(--theme-secondary, #b45309));
            transform: translateY(-2px);
        }
        
        .button-container {
            text-align: center;
            margin: 30px 0;
        }
        
        .info-box {
            background: #fef3c7;
            border: 1px solid #f59e0b;
            border-radius: 8px;
            padding: 15px;
            margin: 20px 0;
        }
        
        .info-box .icon {
            color: #d97706;
            margin-right: 8px;
        }
        
        .info-text {
            color: #92400e;
            font-size: 14px;
            margin: 0;
        }
        
        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
            text-align: center;
            font-size: 14px;
            /* Compatível com tema quando renderizado em contexto web, com fallback seguro */
            background-color: #1f2937; /* fallback sólido para clientes sem suporte a var() */
            background: var(--footer-bg, linear-gradient(135deg, #1f2937 0%, #374151 100%));
            color: white;
        }
        
        .footer a {
            color: var(--theme-primary, #3b82f6);
            text-decoration: none;
        }
        
        .security-notice {
            background: #fee2e2;
            border: 1px solid #fca5a5;
            border-radius: 8px;
            padding: 15px;
            margin: 20px 0;
        }
        
        .security-notice .icon {
            color: #dc2626;
            margin-right: 8px;
        }
        
        .security-text {
            color: #991b1b;
            font-size: 14px;
            margin: 0;
        }
        
        .alternative-link {
            background: #f3f4f6;
            border-radius: 6px;
            padding: 10px;
            margin: 15px 0;
            word-break: break-all;
            font-family: monospace;
            font-size: 12px;
            color: #4b5563;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <div class="logo">
                🔑
            </div>
            <h1 class="title">Recuperação de Senha</h1>
            <p class="subtitle">Câmara Municipal</p>
        </div>
        
        <div class="content">
            <div class="greeting">
                Olá, {{ $user->name }}!
            </div>
            
            <div class="message">
                Você solicitou a recuperação de senha para sua conta no sistema da Câmara Municipal. 
                Para redefinir sua senha, clique no botão abaixo:
            </div>
            
            <div class="button-container">
                <a href="{{ $resetUrl }}" class="reset-button">
                    🔐 Redefinir Minha Senha
                </a>
            </div>
            
            <div class="info-box">
                <p class="info-text">
                    <span class="icon">⏰</span>
                    <strong>Importante:</strong> Este link é válido por apenas 24 horas por motivos de segurança.
                </p>
            </div>
            
            <div class="message">
                Se o botão acima não funcionar, você pode copiar e colar o link abaixo em seu navegador:
            </div>
            
            <div class="alternative-link">
                {{ $resetUrl }}
            </div>
            
            <div class="security-notice">
                <p class="security-text">
                    <span class="icon">🛡️</span>
                    <strong>Aviso de Segurança:</strong> Se você não solicitou esta recuperação de senha, 
                    ignore este email. Sua senha atual permanecerá inalterada.
                </p>
            </div>
            
            <div class="message">
                Após redefinir sua senha, você poderá acessar normalmente:
                <ul>
                    <li>Área do cidadão</li>
                    <li>Acompanhamento de solicitações</li>
                    <li>Histórico de atendimentos</li>
                    <li>Notificações personalizadas</li>
                </ul>
            </div>
        </div>
        
        <div class="footer">
            <p>
                Este email foi enviado automaticamente pelo sistema da Câmara Municipal.<br>
                Para dúvidas, entre em contato através do nosso 
                <a href="{{ route('home') }}">site oficial</a>.
            </p>
            <p style="margin-top: 15px; font-size: 12px; color: rgba(255,255,255,0.85);">
                © {{ date('Y') }} Câmara Municipal. Todos os direitos reservados.
            </p>
        </div>
    </div>
</body>
</html>