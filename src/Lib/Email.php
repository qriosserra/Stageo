<?php

namespace Stageo\Lib;

class Email
{

    public function __construct(private string $destinataire,
                                private string $objet,
                                private string $contenu)
    {
    }

    public function getDestinataire(): string
    {
        return $this->destinataire;
    }

    public function getObjet(): string
    {
        return $this->objet;
    }

    public function getContenu(): string
    {
        return $this->contenu;
    }
}