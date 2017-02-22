<?php

namespace AppBundle\Services\CalculPrix;


use AppBundle\Entity\Commande;
use AppBundle\Entity\Ticket;
use AppBundle\Entity\Prix;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class CalculPrix extends Controller
{
    protected $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }


    public function prixTotal(Ticket $ticket)
    {


            // ON RECUPERE LA DATE DE NAISSANCE POUR CALCULER L'AGE

            $dateDeNaissance = $ticket->getDateNaissance()->diff(new \DateTime());

            $age = $dateDeNaissance->y;
            dump($age);

            // ON ATTRIBUT UN PRIX EN FONCTION DE L'AGE ET D'UNE REDUCTION

            $prix = new Prix();

            $reduction = $ticket->getReduction();
            switch (true) {

                case ($age >= 12 && $age < 60 && $reduction == false):
                    $prixTicket = $prix->getNormal();
                    break;

                case ($age >= 60 && $reduction == false):
                    $prixTicket = $prix->getSenior();
                    break;

                case ($age >= 4 && $age < 12):
                    $prixTicket = $prix->getEnfant();
                    break;

                case (true == $reduction):
                    $prixTicket = $prix->getReduit();
                    break;

                default:
                    $prixTicket = $prix->getGratuit();
                    break;

            }

            //$retourPrix = $ticket->setPrix($prixTicket);

            return $prixTicket;

    }

}