<?php

namespace App\Http\Controllers;

use App\Models\LicitacaoDocumento;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class LicitacaoDocumentoController extends Controller
{
    /**
     * Download de documento
     */
    public function download(LicitacaoDocumento $documento)
    {
        // Verificar se o documento é público
        if (!$documento->publico) {
            abort(403, 'Documento não disponível para download público.');
        }

        // Verificar se o arquivo existe
        if (!Storage::disk('public')->exists($documento->arquivo)) {
            abort(404, 'Arquivo não encontrado.');
        }

        $caminhoCompleto = Storage::disk('public')->path($documento->arquivo);
        
        return response()->download($caminhoCompleto, $documento->arquivo_original, [
            'Content-Type' => $documento->tipo_mime,
        ]);
    }

    /**
     * Visualizar documento (para PDFs)
     */
    public function visualizar(LicitacaoDocumento $documento)
    {
        // Verificar se o documento é público
        if (!$documento->publico) {
            abort(403, 'Documento não disponível para visualização pública.');
        }

        // Verificar se o arquivo existe
        if (!Storage::disk('public')->exists($documento->arquivo)) {
            abort(404, 'Arquivo não encontrado.');
        }

        // Verificar se é um PDF
        if ($documento->tipo_mime !== 'application/pdf') {
            return $this->download($documento);
        }

        $caminhoCompleto = Storage::disk('public')->path($documento->arquivo);
        
        return response()->file($caminhoCompleto, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $documento->arquivo_original . '"'
        ]);
    }

    /**
     * Listar documentos de uma licitação (API para AJAX)
     */
    public function listar(Request $request, $licitacaoId)
    {
        $documentos = LicitacaoDocumento::where('licitacao_id', $licitacaoId)
                                       ->publicos()
                                       ->ordenados()
                                       ->get()
                                       ->map(function ($documento) {
                                           return [
                                               'id' => $documento->id,
                                               'nome' => $documento->nome,
                                               'descricao' => $documento->descricao,
                                               'tipo_documento' => $documento->tipo_documento,
                                               'tipo_documento_label' => $documento->getTipoDocumentoLabel(),
                                               'tamanho_formatado' => $documento->tamanho_formatado,
                                               'eh_pdf' => $documento->ehPdf(),
                                               'url_download' => route('licitacao.documento.download', $documento),
                                               'url_visualizar' => route('licitacao.documento.visualizar', $documento),
                                               'icone' => $documento->getIcone(),
                                           ];
                                       });

        if ($request->ajax()) {
            return response()->json($documentos);
        }

        return $documentos;
    }

    /**
     * Remover documento (admin)
     */
    public function destroy(LicitacaoDocumento $documento)
    {
        // Remover arquivo do storage
        if (Storage::disk('public')->exists($documento->arquivo)) {
            Storage::disk('public')->delete($documento->arquivo);
        }

        // Remover registro do banco
        $documento->delete();

        return response()->json([
            'success' => true,
            'message' => 'Documento removido com sucesso!'
        ]);
    }
}
