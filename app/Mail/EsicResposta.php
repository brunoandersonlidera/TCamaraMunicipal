<?php

namespace App\Mail;

use App\Models\EsicSolicitacao;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EsicResposta extends Mailable
{
    use Queueable, SerializesModels;

    public $solicitacao;

    /**
     * Create a new message instance.
     */
    public function __construct(EsicSolicitacao $solicitacao)
    {
        $this->solicitacao = $solicitacao;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('E-SIC - Resposta da Solicitação - Protocolo #' . $this->solicitacao->protocolo)
                    ->view('emails.esic.resposta')
                    ->with([
                        'solicitacao' => $this->solicitacao,
                        'resposta' => $this->solicitacao->resposta,
                        'dataResposta' => $this->solicitacao->data_resposta ? $this->solicitacao->data_resposta->format('d/m/Y H:i') : 'Não informado',
                        'linkAcompanhamento' => route('esic.show', $this->solicitacao->protocolo)
                    ]);
    }
}