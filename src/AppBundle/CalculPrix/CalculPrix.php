<?php

namespace AppBundle\calculPrix;

use AppBundle\Entity\Ticket;
use AppBundle\Entity\Prix;

class calculPrix
{

    private $dateNaissance;
    private $prix;





    public function age(Ticket $dateNaissance)
    {
        $dateNaissance = $this->dateNaissance->diff(new \DateTime());

        return $dateNaissance->y;
    }

    public function ticketPrice(Ticket $prix)
    {
        $prix = $this->prix;

        return $prix;
    }



}