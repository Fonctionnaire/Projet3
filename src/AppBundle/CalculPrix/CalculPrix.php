<?php

namespace AppBundle\calculPrix;

use AppBundle\Entity\Ticket;
use AppBundle\Entity\Prix;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityRepository;

class calculPrix
{

    private $em;





    public function prixTotal($id, $dateNaissance)
    {
        // ON RECUPERE LES TICKETS D'UNE COMMANDE

        $commande = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('AppBundle:Commande')
            ->getAllTickets();

        $test = $commande->getTickets($dateNaissance);


        $dateNaissance = $this->dateNaissance->diff(new \DateTime());

        return $dateNaissance->y;


    }





}