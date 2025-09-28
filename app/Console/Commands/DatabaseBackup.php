<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DatabaseBackup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:backup {--path= : Caminho personalizado para salvar o backup}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cria um backup completo do banco de dados MySQL em formato SQL';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Iniciando backup do banco de dados...');

        try {
            // Configurações do banco
            $host = config('database.connections.mysql.host');
            $port = config('database.connections.mysql.port');
            $database = config('database.connections.mysql.database');
            $username = config('database.connections.mysql.username');
            $password = config('database.connections.mysql.password');

            // Nome do arquivo de backup
            $timestamp = now()->format('Y-m-d_H-i-s');
            $filename = "backup_completo_{$timestamp}.sql";
            
            // Caminho personalizado ou padrão
            $path = $this->option('path') ?: base_path('backups');
            
            // Criar diretório se não existir
            if (!is_dir($path)) {
                mkdir($path, 0755, true);
            }
            
            $fullPath = $path . DIRECTORY_SEPARATOR . $filename;

            // Comando mysqldump
            $command = sprintf(
                'mysqldump -h %s -P %s -u %s -p%s %s > "%s"',
                escapeshellarg($host),
                escapeshellarg($port),
                escapeshellarg($username),
                escapeshellarg($password),
                escapeshellarg($database),
                $fullPath
            );

            // Tentar executar mysqldump
            $output = [];
            $returnCode = 0;
            exec($command . ' 2>&1', $output, $returnCode);

            if ($returnCode !== 0) {
                // Se mysqldump falhar, usar método alternativo
                $this->warn('mysqldump não disponível. Usando método alternativo...');
                $this->createBackupAlternative($fullPath);
            }

            if (file_exists($fullPath) && filesize($fullPath) > 0) {
                $size = $this->formatBytes(filesize($fullPath));
                $this->info("✅ Backup criado com sucesso!");
                $this->info("📁 Arquivo: {$filename}");
                $this->info("📍 Localização: {$fullPath}");
                $this->info("📊 Tamanho: {$size}");
                return 0;
            } else {
                $this->error('❌ Falha ao criar o backup.');
                return 1;
            }

        } catch (\Exception $e) {
            $this->error('❌ Erro durante o backup: ' . $e->getMessage());
            return 1;
        }
    }

    /**
     * Método alternativo para backup usando Laravel
     */
    private function createBackupAlternative($filePath)
    {
        $this->info('Criando backup usando método alternativo...');
        
        // Obter todas as tabelas
        $tables = DB::select('SHOW TABLES');
        $databaseName = config('database.connections.mysql.database');
        
        $sql = "-- Backup do banco de dados: {$databaseName}\n";
        $sql .= "-- Data: " . now()->format('Y-m-d H:i:s') . "\n\n";
        $sql .= "SET FOREIGN_KEY_CHECKS=0;\n\n";

        foreach ($tables as $table) {
            $tableName = array_values((array) $table)[0];
            
            // Estrutura da tabela
            $createTable = DB::select("SHOW CREATE TABLE `{$tableName}`")[0];
            $sql .= "-- Estrutura da tabela `{$tableName}`\n";
            $sql .= "DROP TABLE IF EXISTS `{$tableName}`;\n";
            $sql .= $createTable->{'Create Table'} . ";\n\n";
            
            // Dados da tabela
            $rows = DB::table($tableName)->get();
            if ($rows->count() > 0) {
                $sql .= "-- Dados da tabela `{$tableName}`\n";
                $sql .= "INSERT INTO `{$tableName}` VALUES\n";
                
                $values = [];
                foreach ($rows as $row) {
                    $rowData = [];
                    foreach ((array) $row as $value) {
                        if (is_null($value)) {
                            $rowData[] = 'NULL';
                        } else {
                            $rowData[] = "'" . addslashes($value) . "'";
                        }
                    }
                    $values[] = '(' . implode(',', $rowData) . ')';
                }
                
                $sql .= implode(",\n", $values) . ";\n\n";
            }
        }
        
        $sql .= "SET FOREIGN_KEY_CHECKS=1;\n";
        
        // Salvar arquivo
        file_put_contents($filePath, $sql);
    }

    /**
     * Formatar bytes em formato legível
     */
    private function formatBytes($size, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        
        for ($i = 0; $size > 1024 && $i < count($units) - 1; $i++) {
            $size /= 1024;
        }
        
        return round($size, $precision) . ' ' . $units[$i];
    }
}
