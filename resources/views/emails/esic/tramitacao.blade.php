<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-SIC - Atualização da Solicitação</title>
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
            background: linear-gradient(135deg, #17a2b8, #138496);
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
            background: #e0f7fa;
            border: 2px solid #00bcd4;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            margin: 20px 0;
        }
        .protocol-number {
            font-size: 28px;
            font-weight: bold;
            color: #00838f;
            margin: 0;
        }
        .protocol-label {
            color: #666;
            font-size: 14px;
            margin: 5px 0 0 0;
        }
        .status-change {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
            border-left: 4px solid #ffc107;
        }
        .status-item {
            display: flex;
            align-items: center;
            margin: 10px 0;
            padding: 10px;
            border-radius: 6px;
        }
        .status-from {
            background: #f8d7da;
            color: #721c24;
        }
        .status-to {
            background: #d4edda;
            color: #155724;
        }
        .status-arrow {
            text-align: center;
            font-size: 24px;
            color: #ffc107;
            margin: 10px 0;
        }
        .info-section {
            margin: 25px 0;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 6px;
            border-left: 4px solid #17a2b8;
        }
        .info-title {
            font-weight: 600;
            color: #333;
            margin-bottom: 15px;
            font-size: 16px;
        }
        .tramitacao-details {
            background: white;
            padding: 15px;
            border-radius: 6px;
            border: 1px solid #dee2e6;
            margin-top: 15px;
        }
        .btn {
            display: inline-block;
            padding: 12px 24px;
            background: #17a2b8;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 500;
            text-align: center;
            margin: 20px 0;
        }
        .btn:hover {
            background: #138496;
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
            color: #17a2b8;
            text-decoration: none;
        }
        .divider {
            height: 1px;
            background: #dee2e6;
            margin: 25px 0;
        }
        .timestamp {
            color: #666;
            font-size: 14px;
            font-style: italic;
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
            <h1>🔄 E-SIC - Atualização da Solicitação</h1>
            <p class="subtitle">Câmara Municipal - Nova Movimentação</p>
        </div>

        <div class="content">
            <p>Prezado(a) <strong>{{ $solicitacao->nome_solicitante }}</strong>,</p>
            
            <p>Sua solicitação de acesso à informação teve uma <strong>nova movimentação</strong>. Confira os detalhes abaixo:</p>

            <div class="protocol-box">
                <h2 class="protocol-number">#{{ $solicitacao->protocolo }}</h2>
                <p class="protocol-label">Número do Protocolo</p>
            </div>

            <div class="status-change">
                <h3 style="margin-top: 0; color: #333;">📊 Mudança de Status</h3>
                
                <div class="status-item status-from">
                    <strong>Status Anterior:</strong> {{ ucfirst(str_replace('_', ' ', $statusAnterior)) }}
                </div>
                
                <div class="status-arrow">⬇️</div>
                
                <div class="status-item status-to">
                    <strong>Status Atual:</strong> {{ ucfirst(str_replace('_', ' ', $statusAtual)) }}
                </div>
            </div>

            <div class="info-section">
                <div class="info-title">📝 Detalhes da Movimentação</div>
                
                <div class="tramitacao-details">
                    <p><strong>Data da Movimentação:</strong> {{ $tramitacao->created_at->format('d/m/Y H:i') }}</p>
                    
                    @if($tramitacao->observacoes)
                    <p><strong>Observações:</strong></p>
                    <div style="background: #f8f9fa; padding: 10px; border-radius: 4px; margin-top: 5px;">
                        {{ $tramitacao->observacoes }}
                    </div>
                    @endif
                    
                    @if($tramitacao->responsavel)
                    <p class="timestamp">
                        <strong>Responsável:</strong> {{ $tramitacao->responsavel->name }}
                    </p>
                    @endif
                </div>
            </div>

            <div class="divider"></div>

            <p><strong>📱 Acompanhe sua solicitação:</strong></p>
            <p>Para ver todas as movimentações e o histórico completo da sua solicitação:</p>
            
            <div style="text-align: center;">
                <a href="{{ $linkAcompanhamento }}" class="btn">🔍 Ver Detalhes Completos</a>
            </div>

            <div class="divider"></div>

            <div style="background: #e3f2fd; padding: 15px; border-radius: 6px; border-left: 4px solid #2196f3;">
                <p><strong>ℹ️ O que significa cada status:</strong></p>
                <ul style="margin: 10px 0;">
                    <li><strong>Pendente:</strong> Aguardando análise inicial</li>
                    <li><strong>Em Análise:</strong> Sendo processada pela equipe responsável</li>
                    <li><strong>Aguardando Informações:</strong> Necessita de dados adicionais</li>
                    <li><strong>Respondida:</strong> Resposta enviada ao solicitante</li>
                    <li><strong>Finalizada:</strong> Processo concluído</li>
                </ul>
            </div>
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