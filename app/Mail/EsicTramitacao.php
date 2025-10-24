<?php

namespace App\Mail;

use App\Models\EsicSolicitacao;
use App\Models\EsicMovimentacao;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EsicTramitacao extends Mailable
{
    use Queueable, SerializesModels;

    public $solicitacao;
    public $tramitacao;

    /**
     * Create a new message instance.
     */
    public function __construct(EsicSolicitacao $solicitacao, EsicMovimentacao $tramitacao)
    {
        $this->solicitacao = $solicitacao;
        $this->tramitacao = $tramitacao;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'E-SIC - Atualização da Solicitação - Protocolo #' . $this->solicitacao->protocolo,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.esic.tramitacao',
            with: [
                'solicitacao' => $this->solicitacao,
                'tramitacao' => $this->tramitacao,
                'statusAnterior' => $this->tramitacao->status_anterior,
                'statusAtual' => $this->tramitacao->status_atual,
                'linkAcompanhamento' => route('esic.show', $this->solicitacao->protocolo)
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}