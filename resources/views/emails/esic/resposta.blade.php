@php
    // Obter configurações da entidade
    $nomeCamara = \App\Models\ConfiguracaoGeral::obterValor('nome_camara', 'Câmara Municipal');
    $brasao = \App\Models\ConfiguracaoGeral::obterBrasaoAbsoluto();
    $endereco = \App\Models\ConfiguracaoGeral::obterEndereco();
    $telefone = \App\Models\ConfiguracaoGeral::obterTelefone();
    $email = \App\Models\ConfiguracaoGeral::obterEmail();
    
    // Obter tema ativo e suas cores
    $tema = \App\Models\Theme::effectiveActive()->first();
    $primaryColor = $tema->primary_color ?? '#28a745';
    $secondaryColor = $tema->secondary_color ?? '#1e7e34';
    $menuBg = $tema->menu_bg ?? "linear-gradient(135deg, {$primaryColor}, {$secondaryColor})";
    $footerBg = $tema->footer_bg ?? "linear-gradient(135deg, {$primaryColor}, {$secondaryColor})";
@endphp

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-SIC - Resposta da Solicitação</title>
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
            color: #155724;
            margin: 0;
        }
        .protocol-label {
            color: #666;
            font-size: 14px;
            margin: 5px 0 0 0;
        }
        .success-badge {
            background: {{ $primaryColor }};
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
            border-left: 4px solid {{ $primaryColor }};
        }
        .info-title {
            font-weight: 600;
            color: #333;
            margin-bottom: 15px;
            font-size: 16px;
        }
        .response-content {
            background: white;
            padding: 20px;
            border-radius: 6px;
            border: 1px solid #dee2e6;
            margin: 15px 0;
            line-height: 1.8;
        }
        .response-meta {
            background: #e9ecef;
            padding: 10px 15px;
            border-radius: 4px;
            font-size: 14px;
            color: #666;
            margin-top: 10px;
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
        .btn-secondary {
            background: #6c757d;
        }
        .btn-secondary:hover {
            background: #545b62;
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
        .satisfaction-section {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 6px;
            padding: 20px;
            margin: 20px 0;
            text-align: center;
        }
        .satisfaction-section h4 {
            color: #856404;
            margin-top: 0;
        }
        .rights-info {
            background: #e3f2fd;
            padding: 15px;
            border-radius: 6px;
            border-left: 4px solid #2196f3;
            margin: 20px 0;
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
            @if($brasao)
                <img src="{{ $brasao }}" alt="Brasão {{ $nomeCamara }}" class="header-logo">
            @endif
            <div class="entity-name">{{ $nomeCamara }}</div>
            <h1>✅ E-SIC - Resposta da Solicitação</h1>
            <p class="subtitle">Sistema Eletrônico do Serviço de Informação ao Cidadão</p>
        </div>

        <div class="content">
            <p>Prezado(a) <strong>{{ $solicitacao->nome_solicitante }}</strong>,</p>
            
            <p>Sua solicitação de acesso à informação foi <strong>respondida</strong>! Confira os detalhes abaixo:</p>

            <div class="protocol-box">
                <h2 class="protocol-number">#{{ $solicitacao->protocolo }}</h2>
                <p class="protocol-label">Número do Protocolo</p>
                <div class="success-badge">✅ RESPONDIDA</div>
            </div>

            <div class="info-section">
                <div class="info-title">📋 Informações da Solicitação</div>
                <p><strong>Assunto:</strong> {{ $solicitacao->assunto }}</p>
                <p><strong>Data da Solicitação:</strong> {{ $solicitacao->created_at->format('d/m/Y H:i') }}</p>
                <p><strong>Data da Resposta:</strong> {{ $dataResposta }}</p>
            </div>

            <div class="info-section">
                <div class="info-title">💬 Resposta da Câmara Municipal</div>
                
                <div class="response-content">
                    {!! nl2br(e($resposta)) !!}
                </div>
                
                <div class="response-meta">
                    <strong>Respondido em:</strong> {{ $dataResposta }}
                    @if($solicitacao->responsavel)
                    <br><strong>Responsável:</strong> {{ $solicitacao->responsavel->name }}
                    @endif
                </div>
            </div>

            <div class="divider"></div>

            <p><strong>📱 Acesse o histórico completo:</strong></p>
            <p>Para ver todos os detalhes e o histórico completo da sua solicitação:</p>
            
            <div style="text-align: center;">
                <a href="{{ $linkAcompanhamento }}" class="btn">📄 Ver Histórico Completo</a>
            </div>

            <div class="satisfaction-section">
                <h4>🌟 Avalie nosso atendimento</h4>
                <p>Sua opinião é muito importante para melhorarmos nossos serviços.</p>
                <div style="margin-top: 15px;">
                    <a href="{{ $linkAcompanhamento }}#avaliacao" class="btn btn-secondary" style="margin: 5px;">⭐ Avaliar Atendimento</a>
                </div>
            </div>

            <div class="rights-info">
                <h4 style="margin-top: 0; color: #1976d2;">⚖️ Seus Direitos</h4>
                <p><strong>Não ficou satisfeito com a resposta?</strong></p>
                <p>Você tem o direito de apresentar recurso em caso de:</p>
                <ul>
                    <li>Acesso negado às informações</li>
                    <li>Não fornecimento de razões da negativa</li>
                    <li>Informações incompletas ou incorretas</li>
                    <li>Descumprimento de prazos</li>
                </ul>
                <p><strong>Prazo para recurso:</strong> 10 dias úteis a partir do recebimento desta resposta.</p>
            </div>

            <div class="divider"></div>

            <p><strong>ℹ️ Informações Importantes:</strong></p>
            <ul>
                <li>Esta resposta encerra o atendimento da sua solicitação</li>
                <li>Guarde este email para seus registros</li>
                <li>Em caso de dúvidas, entre em contato informando o protocolo</li>
                <li>Você pode fazer novas solicitações a qualquer momento</li>
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