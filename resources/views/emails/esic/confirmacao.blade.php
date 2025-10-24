<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-SIC - Confirmação de Recebimento</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f8f9fa;
        }
        .email-container {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        .header {
            background: linear-gradient(135deg, #007bff, #0056b3);
            color: white;
            padding: 30px 20px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 600;
        }
        .header .subtitle {
            margin: 5px 0 0 0;
            opacity: 0.9;
            font-size: 14px;
        }
        .content {
            padding: 30px 20px;
        }
        .protocol-box {
            background: #e3f2fd;
            border: 2px solid #2196f3;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            margin: 20px 0;
        }
        .protocol-number {
            font-size: 28px;
            font-weight: bold;
            color: #1976d2;
            margin: 0;
        }
        .protocol-label {
            color: #666;
            font-size: 14px;
            margin: 5px 0 0 0;
        }
        .info-section {
            margin: 25px 0;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 6px;
            border-left: 4px solid #28a745;
        }
        .info-title {
            font-weight: 600;
            color: #333;
            margin-bottom: 10px;
            font-size: 16px;
        }
        .info-item {
            margin: 8px 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .info-label {
            font-weight: 500;
            color: #666;
        }
        .info-value {
            color: #333;
            font-weight: 500;
        }
        .deadline-warning {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 6px;
            padding: 15px;
            margin: 20px 0;
            text-align: center;
        }
        .deadline-warning .icon {
            font-size: 24px;
            color: #f39c12;
            margin-bottom: 10px;
        }
        .btn {
            display: inline-block;
            padding: 12px 24px;
            background: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 500;
            text-align: center;
            margin: 20px 0;
        }
        .btn:hover {
            background: #0056b3;
        }
        .footer {
            background: #f8f9fa;
            padding: 20px;
            text-align: center;
            border-top: 1px solid #dee2e6;
            color: #666;
            font-size: 14px;
        }
        .footer a {
            color: #007bff;
            text-decoration: none;
        }
        .divider {
            height: 1px;
            background: #dee2e6;
            margin: 25px 0;
        }
        @media (max-width: 600px) {
            body {
                padding: 10px;
            }
            .content {
                padding: 20px 15px;
            }
            .protocol-number {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <h1>🏛️ E-SIC - Sistema de Acesso à Informação</h1>
            <p class="subtitle">Câmara Municipal - Confirmação de Recebimento</p>
        </div>

        <div class="content">
            <p>Prezado(a) <strong>{{ $solicitacao->nome_solicitante }}</strong>,</p>
            
            <p>Sua solicitação de acesso à informação foi <strong>recebida com sucesso</strong> e está sendo processada por nossa equipe.</p>

            <div class="protocol-box">
                <h2 class="protocol-number">#{{ $solicitacao->protocolo }}</h2>
                <p class="protocol-label">Número do Protocolo</p>
            </div>

            <div class="info-section">
                <div class="info-title">📋 Detalhes da Solicitação</div>
                <div class="info-item">
                    <span class="info-label">Assunto:</span>
                    <span class="info-value">{{ $solicitacao->assunto }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Data da Solicitação:</span>
                    <span class="info-value">{{ $solicitacao->created_at->format('d/m/Y H:i') }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Prazo para Resposta:</span>
                    <span class="info-value">{{ $prazoResposta }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Status:</span>
                    <span class="info-value">{{ ucfirst(str_replace('_', ' ', $solicitacao->status)) }}</span>
                </div>
            </div>

            <div class="deadline-warning">
                <div class="icon">⏰</div>
                <strong>Prazo Legal:</strong> Sua solicitação será respondida em até <strong>20 dias úteis</strong>, conforme estabelecido pela Lei de Acesso à Informação (Lei nº 12.527/2011).
            </div>

            <div class="divider"></div>

            <p><strong>📱 Acompanhe sua solicitação:</strong></p>
            <p>Você pode acompanhar o andamento da sua solicitação a qualquer momento através do link abaixo:</p>
            
            <div style="text-align: center;">
                <a href="{{ $linkAcompanhamento }}" class="btn">🔍 Acompanhar Solicitação</a>
            </div>

            <div class="divider"></div>

            <p><strong>ℹ️ Informações Importantes:</strong></p>
            <ul>
                <li>Guarde este número de protocolo para futuras consultas</li>
                <li>Você receberá notificações por email sobre atualizações</li>
                <li>Em caso de dúvidas, entre em contato conosco informando o protocolo</li>
                <li>Se necessário, o prazo pode ser prorrogado por mais 10 dias úteis</li>
            </ul>
        </div>

        <div class="footer">
            <p><strong>Câmara Municipal</strong></p>
            <p>Este é um email automático. Para dúvidas, acesse nosso site ou entre em contato conosco.</p>
            <p>
                <a href="{{ config('app.url') }}">🌐 Acessar Site</a> | 
                <a href="{{ route('esic.sobre') }}">📖 Sobre o E-SIC</a>
            </p>
        </div>
    </div>
</body>
</html>