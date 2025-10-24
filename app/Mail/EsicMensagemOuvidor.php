<?php

namespace App\Mail;

use App\Models\EsicSolicitacao;
use App\Models\EsicMensagem;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EsicMensagemOuvidor extends Mailable
{
    use Queueable, SerializesModels;

    public $solicitacao;
    public $mensagem;

    /**
     * Create a new message instance.
     */
    public function __construct(EsicSolicitacao $solicitacao, EsicMensagem $mensagem)
    {
        $this->solicitacao = $solicitacao;
        $this->mensagem = $mensagem;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'E-SIC - Nova Mensagem - Protocolo #' . $this->solicitacao->protocolo,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.esic.mensagem-ouvidor',
            with: [
                'solicitacao' => $this->solicitacao,
                'mensagem' => $this->mensagem,
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