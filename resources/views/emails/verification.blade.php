<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificação de E-mail - Câmara Municipal</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #0d6efd;
        }
        .logo {
            font-size: 24px;
            font-weight: bold;
            color: #0d6efd;
            margin-bottom: 10px;
        }
        .content {
            margin-bottom: 30px;
        }
        .button {
            display: inline-block;
            padding: 15px 30px;
            background-color: #0d6efd;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            text-align: center;
            margin: 20px 0;
        }
        .button:hover {
            background-color: #0b5ed7;
        }
        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #eee;
            font-size: 12px;
            color: #666;
            text-align: center;
        }
        .warning {
            background-color: #fff3cd;
            border: 1px solid #ffecb5;
            color: #664d03;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
        }
        .info {
            background-color: #d1ecf1;
            border: 1px solid #bee5eb;
            color: #0c5460;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">🏛️ Câmara Municipal</div>
            <h1>Verificação de E-mail</h1>
        </div>

        <div class="content">
            <p>Olá, <strong>{{ $user->name }}</strong>!</p>

            <p>Obrigado por se cadastrar em nosso sistema. Para ativar sua conta e começar a usar nossos serviços, você precisa verificar seu endereço de e-mail.</p>

            <div class="info">
                <strong>📧 E-mail cadastrado:</strong> {{ $user->email }}
            </div>

            <p>Clique no botão abaixo para verificar seu e-mail:</p>

            <div style="text-align: center;">
                <a href="{{ $verificationUrl }}" class="button">
                    ✅ Verificar E-mail
                </a>
            </div>

            <p>Ou copie e cole o link abaixo em seu navegador:</p>
            <p style="word-break: break-all; background-color: #f8f9fa; padding: 10px; border-radius: 5px; font-family: monospace;">
                {{ $verificationUrl }}
            </p>

            <div class="warning">
                <strong>⚠️ Importante:</strong>
                <ul>
                    <li>Este link é válido por 24 horas</li>
                    <li>Se você não se cadastrou em nosso sistema, ignore este e-mail</li>
                    <li>Não compartilhe este link com outras pessoas</li>
                </ul>
            </div>

            <p>Após a verificação, você poderá:</p>
            <ul>
                <li>Acessar sua área pessoal</li>
                <li>Fazer solicitações via e-SIC</li>
                <li>Registrar manifestações na Ouvidoria</li>
                <li>Acompanhar o andamento de seus pedidos</li>
            </ul>

            <p>Se você tiver alguma dúvida ou problema, entre em contato conosco.</p>

            <p>Atenciosamente,<br>
            <strong>Equipe da Câmara Municipal</strong></p>
        </div>

        <div class="footer">
            <p>Este é um e-mail automático, não responda a esta mensagem.</p>
            <p>© {{ date('Y') }} Câmara Municipal. Todos os direitos reservados.</p>
            <p>Se você não conseguir clicar no botão, copie e cole o link em seu navegador.</p>
        </div>
    </div>
</body>
</html>