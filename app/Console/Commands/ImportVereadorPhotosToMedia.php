<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use App\Models\Media;
use App\Models\Vereador;

class ImportVereadorPhotosToMedia extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'media:import-vereadores {--dry-run : Executa sem gravar no banco, apenas mostra o que seria importado}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Importa fotos já existentes em storage/app/public/vereadores para a Biblioteca de Mídia, vinculando ao Vereador quando possível';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $disk = 'public';
        $dir = 'vereadores';

        if (!Storage::disk($disk)->exists($dir)) {
            $this->error("Diretório {$dir} não encontrado no disco '{$disk}'. Certifique-se de que as fotos estão em storage/app/public/{$dir} e que o storage:link foi criado.");
            return 1;
        }

        $files = Storage::disk($disk)->files($dir);
        $importados = 0;
        $existentes = 0;
        $erros = 0;

        foreach ($files as $path) {
            $fileName = basename($path);

            $jaExiste = Media::where('path', $path)
                ->orWhere(function ($q) use ($fileName) {
                    $q->where('file_name', $fileName)
                      ->where('collection_name', 'vereadores');
                })
                ->exists();

            if ($jaExiste) {
                $existentes++;
                $this->line("Pulando (já existe): {$path}");
                continue;
            }

            $mime = Storage::disk($disk)->mimeType($path) ?? 'image/jpeg';
            $size = Storage::disk($disk)->size($path) ?? 0;

            // Tentar vincular ao vereador correspondente
            $vereador = Vereador::where('foto', $path)->first();

            $data = [
                'file_name' => $fileName,
                'original_name' => $fileName,
                'mime_type' => $mime,
                'size' => $size,
                'path' => $path,
                'alt_text' => $vereador ? $vereador->nome_parlamentar : null,
                'title' => $vereador ? "Foto do Vereador {$vereador->nome_parlamentar}" : $fileName,
                'category' => 'foto',
                'uploaded_by' => null,
                'model_type' => $vereador ? Vereador::class : null,
                'model_id' => $vereador ? $vereador->id : null,
                'collection_name' => 'vereadores',
                'disk' => $disk,
                'name' => pathinfo($fileName, PATHINFO_FILENAME),
            ];

            if ($this->option('dry-run')) {
                $importados++;
                $this->info("DRY-RUN: Importaria {$path}");
                continue;
            }

            try {
                Media::create($data);
                $importados++;
                $this->info("Importado: {$path}");
            } catch (\Throwable $e) {
                $erros++;
                $this->error("Erro ao importar {$path}: " . $e->getMessage());
            }
        }

        $this->newLine();
        $this->info("Concluído. Importados: {$importados}, já existentes: {$existentes}, erros: {$erros}.");
        return 0;
    }
}