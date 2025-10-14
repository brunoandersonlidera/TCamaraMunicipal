<?php
// Database backup script
// Usage: php scripts/db_backup.php

declare(strict_types=1);

// Ensure errors are visible for troubleshooting
error_reporting(E_ALL);
ini_set('display_errors', '1');

$root = dirname(__DIR__);

// Load Composer autoload and .env without exposing sensitive data in code
require_once $root . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

// Load environment variables
if (class_exists(\Dotenv\Dotenv::class)) {
    $dotenv = \Dotenv\Dotenv::createImmutable($root);
    $dotenv->safeLoad();
}

// Helper to fetch env with default
function env(string $key, $default = null)
{
    $val = $_ENV[$key] ?? $_SERVER[$key] ?? getenv($key);
    return $val !== false && $val !== null && $val !== '' ? $val : $default;
}

$connection = strtolower((string) env('DB_CONNECTION', 'mysql'));
$host = (string) env('DB_HOST', '127.0.0.1');
$port = (string) env('DB_PORT', $connection === 'pgsql' ? '5432' : '3306');
$database = (string) env('DB_DATABASE', '');
$username = (string) env('DB_USERNAME', '');
$password = (string) env('DB_PASSWORD', '');

if ($database === '' || $username === '') {
    fwrite(STDERR, "[ERRO] DB_DATABASE e DB_USERNAME devem estar definidos no .env.\n");
    exit(1);
}

$backupDir = $root . DIRECTORY_SEPARATOR . 'backups';
if (!is_dir($backupDir)) {
    if (!mkdir($backupDir, 0775, true) && !is_dir($backupDir)) {
        fwrite(STDERR, "[ERRO] Não foi possível criar o diretório de backups: {$backupDir}\n");
        exit(1);
    }
}

$timestamp = date('Y-m-d_H-i-s');
$fileBase = "backup_completo_{$timestamp}";
$outFile = $backupDir . DIRECTORY_SEPARATOR . $fileBase . '.sql';

// Cross-platform safe proc_open wrapper
function runCommandToFile(string $cmd, array $envVars, string $outFile): int
{
    $descriptors = [
        0 => ['pipe', 'r'],
        1 => ['pipe', 'w'],
        2 => ['pipe', 'w'],
    ];

    $proc = proc_open($cmd, $descriptors, $pipes, null, $envVars);
    if (!is_resource($proc)) {
        fwrite(STDERR, "[ERRO] Falha ao iniciar processo do comando.\n");
        return 1;
    }

    $outFp = fopen($outFile, 'wb');
    if ($outFp === false) {
        fwrite(STDERR, "[ERRO] Não foi possível abrir arquivo de saída: {$outFile}\n");
        // Read and discard output to free pipes before closing
        stream_get_contents($pipes[1]);
        stream_get_contents($pipes[2]);
        foreach ($pipes as $p) { fclose($p); }
        proc_close($proc);
        return 1;
    }

    // Stream stdout to file and capture stderr
    stream_set_blocking($pipes[1], true);
    stream_set_blocking($pipes[2], true);

    // Close stdin
    fclose($pipes[0]);

    // Copy stdout to file
    stream_copy_to_stream($pipes[1], $outFp);
    fclose($pipes[1]);
    fclose($outFp);

    $stderr = stream_get_contents($pipes[2]) ?: '';
    fclose($pipes[2]);

    $exitCode = proc_close($proc);

    if ($exitCode !== 0) {
        // Remove incomplete file
        if (file_exists($outFile)) {
            @unlink($outFile);
        }
        fwrite(STDERR, "[ERRO] Comando falhou (código {$exitCode}). Detalhes:\n{$stderr}\n");
    }

    return (int) $exitCode;
}

if ($connection === 'mysql') {
    $mysqldumpPath = (string) env('MYSQLDUMP_PATH', 'mysqldump');
    $cmd = sprintf(
        '%s --host=%s --port=%s --user=%s --single-transaction --quick --routines --triggers --events --default-character-set=utf8mb4 %s',
        $mysqldumpPath,
        escapeshellarg($host),
        escapeshellarg($port),
        escapeshellarg($username),
        escapeshellarg($database)
    );

    // Use MYSQL_PWD to avoid exposing password in process args
$envVarsRaw = array_merge($_ENV ?? [], $_SERVER ?? [], [
    'MYSQL_PWD' => $password,
]);
// Filter only scalar string values for proc_open env
$envVars = [];
foreach ($envVarsRaw as $k => $v) {
    if (is_scalar($v)) {
        $envVars[(string)$k] = (string)$v;
    }
}

$code = runCommandToFile($cmd, $envVars, $outFile);
    if ($code === 0) {
        echo "[OK] Backup MySQL concluído: {$outFile}\n";
        exit(0);
    }
    // Fallback em PHP via PDO quando mysqldump não está disponível
    fwrite(STDOUT, "[INFO] 'mysqldump' indisponível; tentando fallback em PHP (PDO) usando as credenciais do .env...\n");

    /**
     * Dump MySQL database via PDO into a plain SQL file.
     * Observação: este fallback exporta tabelas e views; rotinas, triggers e events não são incluídos.
     */
    $mysqlDumpViaPDO = function (string $host, string $port, string $database, string $username, string $password, string $outFile): int {
        try {
            $dsn = sprintf('mysql:host=%s;port=%s;dbname=%s;charset=utf8mb4', $host, $port, $database);
            $pdo = new \PDO($dsn, $username, $password, [
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                // Use buffered queries to avoid 'unbuffered queries are active' errors when running multiple statements sequentially
                \PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true,
            ]);

            $fp = fopen($outFile, 'wb');
            if ($fp === false) {
                fwrite(STDERR, "[ERRO] Não foi possível criar arquivo de saída: {$outFile}\n");
                return 1;
            }

            $write = function (string $s) use ($fp) { fwrite($fp, $s); };
            $write("-- Backup (fallback) gerado via PHP/PDO em " . date('Y-m-d H:i:s') . "\n");
            $write("SET NAMES utf8mb4;\nSET FOREIGN_KEY_CHECKS=0;\n\n");

            // Listar tabelas e views
            $tables = [];
            $views = [];
            $qTables = $pdo->query("SHOW FULL TABLES WHERE Table_type = 'BASE TABLE'");
            while ($row = $qTables->fetch(\PDO::FETCH_NUM)) { $tables[] = $row[0]; }
            $qViews = $pdo->query("SHOW FULL TABLES WHERE Table_type = 'VIEW'");
            while ($row = $qViews->fetch(\PDO::FETCH_NUM)) { $views[] = $row[0]; }

            // Dump de tabelas (DDL + dados)
            foreach ($tables as $tbl) {
                $write("--\n-- Tabela: `{$tbl}`\n--\n");
                // DDL
                $ddlStmt = $pdo->query("SHOW CREATE TABLE `{$tbl}`");
                $ddl = $ddlStmt->fetch(\PDO::FETCH_ASSOC);
                $createSql = $ddl['Create Table'] ?? null;
                // Ensure cursor is closed before next queries
                if ($ddlStmt instanceof \PDOStatement) { $ddlStmt->closeCursor(); }
                if ($createSql === null) {
                    fwrite(STDERR, "[AVISO] Não foi possível obter DDL da tabela {$tbl}.\n");
                } else {
                    $write("DROP TABLE IF EXISTS `{$tbl}`;\n{$createSql};\n\n");
                }

                // Dados
                $stmt = $pdo->query("SELECT * FROM `{$tbl}`", \PDO::FETCH_ASSOC);
                $colsPrinted = false;
                while ($row = $stmt->fetch()) {
                    $cols = array_keys($row);
                    if (!$colsPrinted) {
                        $colsPrinted = true;
                    }
                    $values = [];
                    foreach ($row as $val) {
                        if ($val === null) { $values[] = 'NULL'; }
                        else { $values[] = $pdo->quote((string)$val); }
                    }
                    $colList = '`' . implode('`,`', array_map(fn($c) => (string)$c, $cols)) . '`';
                    $valList = implode(',', $values);
                    $write(sprintf("INSERT INTO `%s` (%s) VALUES (%s);\n", $tbl, $colList, $valList));
                }
                if ($stmt instanceof \PDOStatement) { $stmt->closeCursor(); }
                $write("\n");
            }

            // Dump de views
            foreach ($views as $vw) {
                $write("--\n-- View: `{$vw}`\n--\n");
                $ddlStmt = $pdo->query("SHOW CREATE VIEW `{$vw}`");
                $ddl = $ddlStmt->fetch(\PDO::FETCH_ASSOC);
                $createSql = $ddl['Create View'] ?? null;
                if ($ddlStmt instanceof \PDOStatement) { $ddlStmt->closeCursor(); }
                if ($createSql === null) {
                    fwrite(STDERR, "[AVISO] Não foi possível obter DDL da view {$vw}.\n");
                } else {
                    $write("DROP VIEW IF EXISTS `{$vw}`;\n{$createSql};\n\n");
                }
            }

            $write("SET FOREIGN_KEY_CHECKS=1;\n");
            fclose($fp);
            return 0;
        } catch (\Throwable $e) {
            fwrite(STDERR, "[ERRO] Fallback PDO falhou: " . $e->getMessage() . "\n");
            return 1;
        }
    };

    $fallbackCode = $mysqlDumpViaPDO($host, $port, $database, $username, $password, $outFile);
    if ($fallbackCode === 0) {
        echo "[OK] Backup MySQL (fallback via PHP) concluído: {$outFile}\n";
        exit(0);
    }
    fwrite(STDERR, "[DICA] Verifique o caminho do 'mysqldump' e/ou permissões de acesso ao banco.\n" .
        "      Você pode definir MYSQLDUMP_PATH no .env com o caminho completo do executável para um dump mais completo (rotinas/trigger/events).\n");
    exit($code);
} elseif ($connection === 'pgsql') {
    $pgdumpPath = (string) env('PG_DUMP_PATH', 'pg_dump');
    // Custom format can be used (e.g., -Fc). Here we keep plain SQL
    $cmd = sprintf(
        '%s -h %s -p %s -U %s %s',
        $pgdumpPath,
        escapeshellarg($host),
        escapeshellarg($port),
        escapeshellarg($username),
        escapeshellarg($database)
    );

    $envVarsRaw = array_merge($_ENV ?? [], $_SERVER ?? [], [
        'PGPASSWORD' => $password,
    ]);
    $envVars = [];
    foreach ($envVarsRaw as $k => $v) {
        if (is_scalar($v)) {
            $envVars[(string)$k] = (string)$v;
        }
    }

    $code = runCommandToFile($cmd, $envVars, $outFile);
    if ($code === 0) {
        echo "[OK] Backup PostgreSQL concluído: {$outFile}\n";
        exit(0);
    }
    exit($code);
} else {
    fwrite(STDERR, "[ERRO] DB_CONNECTION='{$connection}' não suportado por este script. Use 'mysql' ou 'pgsql'.\n");
    exit(1);
}