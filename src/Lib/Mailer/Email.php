<?php

namespace Stageo\Lib\Mailer;

class Email
{
    public function __construct(private string $destinataire,
                                private string $objet,
                                private string $message)
    {
    }

    public function getDestinataire(): string
    {
        return $this->destinataire;
    }

    public function setDestinataire(string $destinataire): void
    {
        $this->destinataire = $destinataire;
    }

    public function getObjet(): string
    {
        return $this->objet;
    }

    public function setObjet(string $objet): void
    {
        $this->objet = $objet;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function setMessage(string $message): void
    {
        $this->message = $message;
    }
}