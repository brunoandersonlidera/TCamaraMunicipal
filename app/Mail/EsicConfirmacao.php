<?php

namespace App\Mail;

use App\Models\EsicSolicitacao;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EsicConfirmacao extends Mailable
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
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'E-SIC - Confirmação de Recebimento - Protocolo #' . $this->solicitacao->protocolo,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.esic.confirmacao',
            with: [
                'solicitacao' => $this->solicitacao,
                'prazoResposta' => $this->solicitacao->data_limite_resposta->format('d/m/Y'),
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