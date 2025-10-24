@php
    // Obter configurações da entidade
    $nomeCamara = \App\Models\ConfiguracaoGeral::obterValor('nome_camara', 'Câmara Municipal');
    $brasao = \App\Models\ConfiguracaoGeral::obterBrasaoAbsoluto();
    $endereco = \App\Models\ConfiguracaoGeral::obterEndereco();
    $telefone = \App\Models\ConfiguracaoGeral::obterTelefone();
    $email = \App\Models\ConfiguracaoGeral::obterEmail();
    
    // Obter tema ativo e suas cores
    $tema = \App\Models\Theme::effectiveActive()->first();
    $primaryColor = $tema->primary_color ?? '#007bff';
    $secondaryColor = $tema->secondary_color ?? '#0056b3';
    $menuBg = $tema->menu_bg ?? "linear-gradient(135deg, {$primaryColor}, {$secondaryColor})";
    $footerBg = $tema->footer_bg ?? "linear-gradient(135deg, {$primaryColor}, {$secondaryColor})";
@endphp

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-SIC - Nova Mensagem</title>
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
            background: {{ $menuBg }};
            color: white;
            padding: 30px 20px;
            text-align: center;
        }
        .header-logo {
            max-width: 80px;
            max-height: 80px;
            margin-bottom: 15px;
            border-radius: 8px;
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
        .entity-name {
            font-size: 16px;
            font-weight: 500;
            margin-bottom: 10px;
            opacity: 0.95;
        }
        .content {
            padding: 30px 20px;
        }
        .protocol-box {
            background: rgba({{ hexdec(substr($primaryColor, 1, 2)) }}, {{ hexdec(substr($primaryColor, 3, 2)) }}, {{ hexdec(substr($primaryColor, 5, 2)) }}, 0.1);
            border: 2px solid {{ $primaryColor }};
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            margin: 20px 0;
        }
        .protocol-number {
            font-size: 28px;
            font-weight: bold;
            color: #1565c0;
            margin: 0;
        }
        .protocol-label {
            color: #666;
            font-size: 14px;
            margin: 5px 0 0 0;
        }
        .new-message-badge {
            background: #007bff;
            color: white;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 500;
            display: inline-block;
            margin: 10px 0;
        }
        .info-section {
            margin: 25px 0;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 6px;
            border-left: 4px solid #007bff;
        }
        .info-title {
            font-weight: 600;
            color: #333;
            margin-bottom: 15px;
            font-size: 16px;
        }
        .message-highlight {
            background: #fff3cd;
            border: 2px solid #ffc107;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
            position: relative;
        }
        .message-highlight::before {
            content: "💬 NOVA MENSAGEM";
            position: absolute;
            top: -12px;
            left: 20px;
            background: #ffc107;
            color: #212529;
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: bold;
        }
        .message-content {
            background: white;
            padding: 20px;
            border-radius: 6px;
            border: 1px solid #dee2e6;
            margin: 15px 0;
            line-height: 1.8;
        }
        .message-meta {
            background: #e9ecef;
            padding: 10px 15px;
            border-radius: 4px;
            font-size: 14px;
            color: #666;
            margin-top: 10px;
        }
        .attachment-note {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 6px;
            padding: 12px 16px;
            margin: 15px 0;
            color: #856404;
            font-size: 14px;
        }
        .attachment-note a {
            color: #856404;
            font-weight: 600;
            text-decoration: none;
        }
        .attachment-note a:hover {
            text-decoration: underline;
        }
        .history-section {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 20px;
            margin: 25px 0;
            border-left: 4px solid #6c757d;
        }
        .history-item {
            background: white;
            border-radius: 6px;
            padding: 15px;
            margin: 10px 0;
            border-left: 3px solid #dee2e6;
        }
        .history-item.cidadao {
            border-left-color: #28a745;
        }
        .history-item.ouvidor {
            border-left-color: #007bff;
        }
        .history-meta {
            font-size: 12px;
            color: #666;
            margin-bottom: 8px;
        }
        .history-content {
            font-size: 14px;
            line-height: 1.5;
        }
        .btn {
            display: inline-block;
            padding: 12px 24px;
            background: {{ $primaryColor }};
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 500;
            text-align: center;
            margin: 20px 0;
        }
        .btn:hover {
            background: {{ $secondaryColor }};
        }
        .footer {
            background: {{ $footerBg }};
            color: white;
            padding: 25px 20px;
            text-align: center;
            border-top: 1px solid #dee2e6;
        }
        .footer h3 {
            margin: 0 0 15px 0;
            font-size: 18px;
            font-weight: 600;
        }
        .footer-info {
            margin-bottom: 15px;
            line-height: 1.8;
        }
        .footer-info p {
            margin: 5px 0;
            opacity: 0.95;
        }
        .footer-links {
            margin-top: 20px;
            padding-top: 15px;
            border-top: 1px solid rgba(255,255,255,0.2);
        }
        .footer a {
            color: white;
            text-decoration: none;
            opacity: 0.9;
        }
        .footer a:hover {
            opacity: 1;
            text-decoration: underline;
        }
        .divider {
            height: 1px;
            background: #dee2e6;
            margin: 25px 0;
        }
        .status-badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 500;
        }
        .status-pendente { background: #fff3cd; color: #856404; }
        .status-em_analise { background: #d1ecf1; color: #0c5460; }
        .status-aguardando_informacoes { background: #f8d7da; color: #721c24; }
        .status-informacoes_recebidas { background: #cce5ff; color: #004085; }
        .status-respondida { background: #d4edda; color: #155724; }
        .status-finalizada { background: #e2e3e5; color: #383d41; }
        .status-arquivada { background: #e2e3e5; color: #383d41; }
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
            @if($brasao)
                <img src="{{ $brasao }}" alt="Brasão {{ $nomeCamara }}" class="header-logo">
            @endif
            <div class="entity-name">{{ $nomeCamara }}</div>
            <h1>📧 E-SIC - Nova Mensagem</h1>
            <p class="subtitle">Sistema Eletrônico do Serviço de Informação ao Cidadão</p>
        </div>

        <div class="content">
            <p>Prezado(a) <strong>{{ $solicitacao->nome_solicitante }}</strong>,</p>
            
            <p>Você recebeu uma <strong>nova mensagem</strong> referente à sua solicitação de acesso à informação!</p>

            <div class="protocol-box">
                <h2 class="protocol-number">#{{ $solicitacao->protocolo }}</h2>
                <p class="protocol-label">Número do Protocolo</p>
                <div class="new-message-badge">💬 NOVA MENSAGEM</div>
                @php
                    $statusClass = match($solicitacao->status) {
                        'pendente' => 'status-pendente',
                        'em_analise' => 'status-em_analise',
                        'aguardando_informacoes' => 'status-aguardando_informacoes',
                        'informacoes_recebidas' => 'status-informacoes_recebidas',
                        'respondida' => 'status-respondida',
                        'finalizada' => 'status-finalizada',
                        'arquivada' => 'status-arquivada',
                        default => 'status-pendente'
                    };
                    $statusText = match($solicitacao->status) {
                        'pendente' => 'Pendente',
                        'em_analise' => 'Em Análise',
                        'aguardando_informacoes' => 'Aguardando Informações',
                        'informacoes_recebidas' => 'Informações Recebidas',
                        'respondida' => 'Respondida',
                        'finalizada' => 'Finalizada',
                        'arquivada' => 'Arquivada',
                        default => ucfirst($solicitacao->status)
                    };
                @endphp
                <div class="status-badge {{ $statusClass }}">{{ $statusText }}</div>
            </div>

            <div class="info-section">
                <div class="info-title">📋 Informações da Solicitação</div>
                <p><strong>Assunto:</strong> {{ $solicitacao->assunto }}</p>
                <p><strong>Data da Solicitação:</strong> {{ $solicitacao->created_at->format('d/m/Y H:i') }}</p>
                <p><strong>Status Atual:</strong> {{ $statusText }}</p>
            </div>

            <div class="message-highlight">
                <div class="info-title">💬 Nova Mensagem do Ouvidor</div>
                
                <div class="message-content">
                    {!! nl2br(e($mensagem->mensagem)) !!}
                </div>
                
                <div class="message-meta">
                    <strong>Enviada em:</strong> {{ $mensagem->created_at->format('d/m/Y H:i') }}
                    @if($mensagem->usuario)
                    <br><strong>Por:</strong> {{ $mensagem->usuario->name }}
                    @endif
                    @if($mensagem->canal_comunicacao && $mensagem->canal_comunicacao !== 'sistema')
                    <br><strong>Canal:</strong> {{ $mensagem->getCanalFormatado() }}
                    @endif
                    @if($mensagem->anexos && count($mensagem->anexos) > 0)
                    <br><strong>Anexos:</strong> {{ count($mensagem->anexos) }} arquivo(s)
                    @endif
                </div>

                @if($mensagem->anexos && count($mensagem->anexos) > 0)
                <div class="attachment-note">
                    📎 Nota: Para visualizar e baixar o(s) anexo(s), faça login no sistema e acesse sua solicitação pelo link abaixo. Por motivos de segurança, anexos não são enviados por e-mail.
                    <div style="margin-top: 8px; text-align: center;">
                        <a href="{{ $linkAcompanhamento }}">Acessar Solicitação</a>
                    </div>
                </div>
                @endif
            </div>

            <div class="divider"></div>

            <div class="history-section">
                <div class="info-title">📜 Histórico de Mensagens</div>
                <p style="font-size: 14px; color: #666; margin-bottom: 15px;">Últimas 5 mensagens da conversa:</p>
                
                @php
                    $mensagensHistorico = $solicitacao->mensagens()
                        ->where('interna', false)
                        ->orderBy('created_at', 'desc')
                        ->limit(5)
                        ->get()
                        ->reverse();
                @endphp

                @forelse($mensagensHistorico as $msg)
                <div class="history-item {{ $msg->tipo_remetente }}">
                    <div class="history-meta">
                        <strong>
                            @if($msg->tipo_remetente === 'cidadao')
                                👤 {{ $solicitacao->nome_solicitante }}
                            @else
                                🏛️ {{ $msg->usuario->name ?? 'Ouvidor' }}
                            @endif
                        </strong>
                        - {{ $msg->created_at->format('d/m/Y H:i') }}
                        @if($msg->canal_comunicacao && $msg->canal_comunicacao !== 'sistema')
                            via {{ $msg->getCanalFormatado() }}
                        @endif
                    </div>
                    <div class="history-content">
                        {{ \Illuminate\Support\Str::limit($msg->mensagem, 200) }}
                        @if($msg->anexos && count($msg->anexos) > 0)
                            <br><small style="color: #666;">📎 {{ count($msg->anexos) }} anexo(s)</small>
                        @endif
                    </div>
                </div>
                @empty
                <p style="color: #666; font-style: italic;">Nenhuma mensagem anterior encontrada.</p>
                @endforelse
            </div>

            <div class="divider"></div>

            <p><strong>📱 Acesse o histórico completo:</strong></p>
            <p>Para ver todos os detalhes, responder ou acompanhar sua solicitação:</p>
            
            <div style="text-align: center;">
                <a href="{{ $linkAcompanhamento }}" class="btn">📄 Acessar Solicitação</a>
            </div>

            <div class="divider"></div>

            <p><strong>ℹ️ Informações Importantes:</strong></p>
            <ul>
                <li>Você pode responder a esta mensagem através do sistema</li>
                <li>Guarde este email para seus registros</li>
                <li>Em caso de dúvidas, entre em contato informando o protocolo</li>
                <li>Acompanhe o status da sua solicitação regularmente</li>
            </ul>
        </div>

        <div class="footer">
            <h3>{{ $nomeCamara }}</h3>
            
            <div class="footer-info">
                @if($endereco)
                    <p>📍 {{ $endereco }}</p>
                @endif
                @if($telefone)
                    <p>📞 {{ $telefone }}</p>
                @endif
                @if($email)
                    <p>✉️ {{ $email }}</p>
                @endif
            </div>
            
            <p style="margin: 15px 0; opacity: 0.9;">
                Obrigado por utilizar o Sistema E-SIC. Sua participação fortalece a transparência pública.
            </p>
            
            <div class="footer-links">
                <a href="{{ config('app.url') }}">🌐 Acessar Site</a> | 
                <a href="{{ route('esic.create') }}">📝 Nova Solicitação</a> | 
                <a href="{{ route('esic.sobre') }}">📖 Sobre o E-SIC</a>
            </div>
        </div>
    </div>
</body>
</html>