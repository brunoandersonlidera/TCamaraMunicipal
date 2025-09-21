<?php
/**
 * SISTEMA DE GERENCIAMENTO DIRETO DE USUÁRIOS
 * Câmara Municipal - Sistema TCamaraMunicipal
 * 
 * ATENÇÃO: Este arquivo contém credenciais de banco de dados
 * e deve ser mantido em segurança absoluta.
 * 
 * Funcionalidades:
 * - Listar todos os usuários
 * - Criar novos usuários
 * - Editar dados de usuários existentes
 * - Alterar senhas (compatível com Laravel bcrypt)
 * - Desabilitar/Excluir usuários
 * - Diagnóstico de hashes de senha
 * - Detecção automática de hashes desatualizados
 * 
 * COMPATIBILIDADE DE HASH:
 * - Usa bcrypt com cost 12 (padrão Laravel)
 * - Detecta automaticamente hashes antigos
 * - Totalmente compatível com Hash::make() e Hash::check() do Laravel
 */

// Configurações de conexão direta com o banco
$db_config = [
    'host' => '193.203.175.57',
    'port' => '3306',
    'database' => 'u700101648_wrcXd',
    'username' => 'u700101648_fnFOi',
    'password' => 'L1d3r@t3cn0l0g1@'
];

// Função para conectar ao banco
function conectarBanco() {
    global $db_config;
    try {
        $dsn = "mysql:host={$db_config['host']};port={$db_config['port']};dbname={$db_config['database']};charset=utf8mb4";
        $pdo = new PDO($dsn, $db_config['username'], $db_config['password']);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        die("Erro de conexão: " . $e->getMessage());
    }
}

// Função para hash de senha (compatível com Laravel - bcrypt)
function hashSenha($senha) {
    // Usar bcrypt com cost 12 (padrão do Laravel)
    return password_hash($senha, PASSWORD_BCRYPT, ['cost' => 12]);
}

// Função para verificar senha (compatível com Laravel)
function verificarSenha($senha, $hash) {
    // Verifica tanto bcrypt quanto outros algoritmos
    return password_verify($senha, $hash);
}

// Função para verificar se o hash precisa ser atualizado
function precisaRehash($hash) {
    return password_needs_rehash($hash, PASSWORD_BCRYPT, ['cost' => 12]);
}

// Processar ações
$acao = $_GET['acao'] ?? 'listar';
$mensagem = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pdo = conectarBanco();
    
    if ($acao === 'criar') {
        $nome = $_POST['name'] ?? '';
        $email = $_POST['email'] ?? '';
        $senha = $_POST['password'] ?? '';
        $role = $_POST['role'] ?? 'user';
        
        if ($nome && $email && $senha) {
            try {
                $stmt = $pdo->prepare("INSERT INTO users (name, email, password, role, email_verified_at, created_at, updated_at) VALUES (?, ?, ?, ?, NOW(), NOW(), NOW())");
                $stmt->execute([$nome, $email, hashSenha($senha), $role]);
                $mensagem = "✅ Usuário criado com sucesso!";
            } catch (PDOException $e) {
                $mensagem = "❌ Erro ao criar usuário: " . $e->getMessage();
            }
        } else {
            $mensagem = "❌ Todos os campos são obrigatórios!";
        }
    }
    
    if ($acao === 'editar') {
        $id = $_POST['id'] ?? '';
        $nome = $_POST['name'] ?? '';
        $email = $_POST['email'] ?? '';
        $senha = $_POST['password'] ?? '';
        $role = $_POST['role'] ?? 'user';
        
        if ($id && $nome && $email) {
            try {
                if ($senha) {
                    // Nova senha fornecida - usar hash bcrypt
                    $stmt = $pdo->prepare("UPDATE users SET name = ?, email = ?, password = ?, role = ?, updated_at = NOW() WHERE id = ?");
                    $stmt->execute([$nome, $email, hashSenha($senha), $role, $id]);
                } else {
                    // Verificar se o hash atual precisa ser atualizado
                    $stmt_check = $pdo->prepare("SELECT password FROM users WHERE id = ?");
                    $stmt_check->execute([$id]);
                    $user_atual = $stmt_check->fetch(PDO::FETCH_ASSOC);
                    
                    if ($user_atual && precisaRehash($user_atual['password'])) {
                        $mensagem .= " ⚠️ Nota: Hash de senha desatualizado detectado. ";
                    }
                    
                    $stmt = $pdo->prepare("UPDATE users SET name = ?, email = ?, role = ?, updated_at = NOW() WHERE id = ?");
                    $stmt->execute([$nome, $email, $role, $id]);
                }
                $mensagem = "✅ Usuário atualizado com sucesso!" . ($mensagem ?? '');
            } catch (PDOException $e) {
                $mensagem = "❌ Erro ao atualizar usuário: " . $e->getMessage();
            }
        } else {
            $mensagem = "❌ Nome e email são obrigatórios!";
        }
    }
    
    if ($acao === 'excluir') {
        $id = $_POST['id'] ?? '';
        if ($id) {
            try {
                $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
                $stmt->execute([$id]);
                $mensagem = "✅ Usuário excluído com sucesso!";
            } catch (PDOException $e) {
                $mensagem = "❌ Erro ao excluir usuário: " . $e->getMessage();
            }
        }
    }
    
    if ($acao === 'desabilitar') {
        $id = $_POST['id'] ?? '';
        if ($id) {
            try {
                $stmt = $pdo->prepare("UPDATE users SET email_verified_at = NULL, updated_at = NOW() WHERE id = ?");
                $stmt->execute([$id]);
                $mensagem = "✅ Usuário desabilitado com sucesso!";
            } catch (PDOException $e) {
                $mensagem = "❌ Erro ao desabilitar usuário: " . $e->getMessage();
            }
        }
    }
    
    if ($acao === 'habilitar') {
        $id = $_POST['id'] ?? '';
        if ($id) {
            try {
                $stmt = $pdo->prepare("UPDATE users SET email_verified_at = NOW(), updated_at = NOW() WHERE id = ?");
                $stmt->execute([$id]);
                $mensagem = "✅ Usuário habilitado com sucesso!";
            } catch (PDOException $e) {
                $mensagem = "❌ Erro ao habilitar usuário: " . $e->getMessage();
            }
        }
    }
    
    if ($acao === 'diagnostico_hash') {
        try {
            $stmt = $pdo->query("SELECT id, name, email, password FROM users");
            $usuarios_hash = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            $hashes_desatualizados = 0;
            $hashes_ok = 0;
            
            foreach ($usuarios_hash as $user) {
                if (precisaRehash($user['password'])) {
                    $hashes_desatualizados++;
                } else {
                    $hashes_ok++;
                }
            }
            
            $mensagem = "📊 Diagnóstico de Hashes: {$hashes_ok} atualizados (bcrypt), {$hashes_desatualizados} desatualizados";
        } catch (PDOException $e) {
            $mensagem = "❌ Erro no diagnóstico: " . $e->getMessage();
        }
    }
}

// Buscar usuários
$pdo = conectarBanco();
$stmt = $pdo->query("SELECT * FROM users ORDER BY id DESC");
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Buscar usuário específico para edição
$usuario_editar = null;
if ($acao === 'editar' && isset($_GET['id'])) {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$_GET['id']]);
    $usuario_editar = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciamento de Usuários - Câmara Municipal</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            border-radius: 15px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        
        .header {
            background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        
        .header h1 {
            font-size: 2.5em;
            margin-bottom: 10px;
        }
        
        .header p {
            opacity: 0.9;
            font-size: 1.1em;
        }
        
        .content {
            padding: 30px;
        }
        
        .mensagem {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 8px;
            font-weight: bold;
        }
        
        .mensagem.sucesso {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .mensagem.erro {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        .nav-buttons {
            margin-bottom: 30px;
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }
        
        .btn {
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            text-decoration: none;
            font-weight: bold;
            transition: all 0.3s ease;
            display: inline-block;
        }
        
        .btn-primary {
            background: #007bff;
            color: white;
        }
        
        .btn-primary:hover {
            background: #0056b3;
            transform: translateY(-2px);
        }
        
        .btn-success {
            background: #28a745;
            color: white;
        }
        
        .btn-success:hover {
            background: #1e7e34;
        }
        
        .btn-warning {
            background: #ffc107;
            color: #212529;
        }
        
        .btn-warning:hover {
            background: #e0a800;
        }
        
        .btn-danger {
            background: #dc3545;
            color: white;
        }
        
        .btn-danger:hover {
            background: #c82333;
        }
        
        .btn-small {
            padding: 8px 16px;
            font-size: 0.9em;
        }
        
        .form-container {
            background: #f8f9fa;
            padding: 30px;
            border-radius: 10px;
            margin-bottom: 30px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #333;
        }
        
        .form-group input,
        .form-group select {
            width: 100%;
            padding: 12px;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            font-size: 16px;
            transition: border-color 0.3s ease;
        }
        
        .form-group input:focus,
        .form-group select:focus {
            outline: none;
            border-color: #007bff;
        }
        
        .table-container {
            overflow-x: auto;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
        }
        
        th {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 15px;
            text-align: left;
            font-weight: bold;
        }
        
        td {
            padding: 15px;
            border-bottom: 1px solid #e9ecef;
        }
        
        tr:hover {
            background: #f8f9fa;
        }
        
        .status {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.9em;
            font-weight: bold;
        }
        
        .status.ativo {
            background: #d4edda;
            color: #155724;
        }
        
        .status.inativo {
            background: #f8d7da;
            color: #721c24;
        }
        
        .actions {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }
        
        @media (max-width: 768px) {
            .nav-buttons {
                flex-direction: column;
            }
            
            .actions {
                flex-direction: column;
            }
            
            .btn {
                text-align: center;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🏛️ Gerenciamento de Usuários</h1>
            <p>Sistema Administrativo - Câmara Municipal</p>
        </div>
        
        <div class="content">
            <?php if ($mensagem): ?>
                <div class="mensagem <?= strpos($mensagem, '✅') !== false ? 'sucesso' : 'erro' ?>">
                    <?= htmlspecialchars($mensagem) ?>
                </div>
            <?php endif; ?>
            
            <div class="nav-buttons">
                <a href="?acao=listar" class="btn btn-primary">📋 Listar Usuários</a>
                <a href="?acao=criar" class="btn btn-success">➕ Novo Usuário</a>
                <a href="?acao=diagnostico_hash" class="btn btn-warning">🔍 Diagnóstico de Hashes</a>
            </div>
            
            <?php if ($acao === 'criar' || $acao === 'editar'): ?>
                <div class="form-container">
                    <h2><?= $acao === 'criar' ? '➕ Criar Novo Usuário' : '✏️ Editar Usuário' ?></h2>
                    <form method="POST">
                        <?php if ($acao === 'editar'): ?>
                            <input type="hidden" name="id" value="<?= htmlspecialchars($usuario_editar['id'] ?? '') ?>">
                        <?php endif; ?>
                        
                        <div class="form-group">
                            <label for="name">Nome Completo:</label>
                            <input type="text" id="name" name="name" value="<?= htmlspecialchars($usuario_editar['name'] ?? '') ?>" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" id="email" name="email" value="<?= htmlspecialchars($usuario_editar['email'] ?? '') ?>" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="password">Senha <?= $acao === 'editar' ? '(deixe em branco para manter a atual)' : '' ?>:</label>
                            <input type="password" id="password" name="password" <?= $acao === 'criar' ? 'required' : '' ?>>
                        </div>
                        
                        <div class="form-group">
                            <label for="role">Função:</label>
                            <select id="role" name="role" required>
                                <option value="user" <?= ($usuario_editar['role'] ?? '') === 'user' ? 'selected' : '' ?>>Usuário</option>
                                <option value="admin" <?= ($usuario_editar['role'] ?? '') === 'admin' ? 'selected' : '' ?>>Administrador</option>
                                <option value="moderator" <?= ($usuario_editar['role'] ?? '') === 'moderator' ? 'selected' : '' ?>>Moderador</option>
                            </select>
                        </div>
                        
                        <button type="submit" class="btn btn-success">
                            <?= $acao === 'criar' ? '➕ Criar Usuário' : '💾 Salvar Alterações' ?>
                        </button>
                        <a href="?acao=listar" class="btn btn-warning">❌ Cancelar</a>
                    </form>
                </div>
            <?php endif; ?>
            
            <?php if ($acao === 'listar'): ?>
                <div class="table-container">
                    <h2>👥 Lista de Usuários (<?= count($usuarios) ?> usuários)</h2>
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nome</th>
                                <th>Email</th>
                                <th>Função</th>
                                <th>Status</th>
                                <th>Hash</th>
                                <th>Criado em</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($usuarios as $usuario): ?>
                                <tr>
                                    <td><?= htmlspecialchars($usuario['id']) ?></td>
                                    <td><?= htmlspecialchars($usuario['name']) ?></td>
                                    <td><?= htmlspecialchars($usuario['email']) ?></td>
                                    <td>
                                        <span class="status <?= $usuario['role'] === 'admin' ? 'ativo' : '' ?>">
                                            <?= ucfirst(htmlspecialchars($usuario['role'])) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="status <?= $usuario['email_verified_at'] ? 'ativo' : 'inativo' ?>">
                                            <?= $usuario['email_verified_at'] ? 'Ativo' : 'Inativo' ?>
                                        </span>
                                    </td>
                                    <td>
                                        <?php $hash_ok = !precisaRehash($usuario['password']); ?>
                                        <span class="status <?= $hash_ok ? 'ativo' : 'inativo' ?>">
                                            <?= $hash_ok ? '🔒 Bcrypt' : '⚠️ Antigo' ?>
                                        </span>
                                    </td>
                                    <td><?= date('d/m/Y H:i', strtotime($usuario['created_at'])) ?></td>
                                    <td>
                                        <div class="actions">
                                            <a href="?acao=editar&id=<?= $usuario['id'] ?>" class="btn btn-primary btn-small">✏️ Editar</a>
                                            
                                            <?php if ($usuario['email_verified_at']): ?>
                                                <form method="POST" style="display: inline;" onsubmit="return confirm('Desabilitar usuário?')">
                                                    <input type="hidden" name="id" value="<?= $usuario['id'] ?>">
                                                    <button type="submit" name="acao" value="desabilitar" class="btn btn-warning btn-small">⏸️ Desabilitar</button>
                                                </form>
                                            <?php else: ?>
                                                <form method="POST" style="display: inline;">
                                                    <input type="hidden" name="id" value="<?= $usuario['id'] ?>">
                                                    <button type="submit" name="acao" value="habilitar" class="btn btn-success btn-small">▶️ Habilitar</button>
                                                </form>
                                            <?php endif; ?>
                                            
                                            <form method="POST" style="display: inline;" onsubmit="return confirm('ATENÇÃO: Esta ação é irreversível! Excluir usuário permanentemente?')">
                                                <input type="hidden" name="id" value="<?= $usuario['id'] ?>">
                                                <button type="submit" name="acao" value="excluir" class="btn btn-danger btn-small">🗑️ Excluir</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>