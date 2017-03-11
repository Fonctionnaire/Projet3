<?php

namespace AppBundle\Services\CalculPrix;



use AppBundle\Entity\Commande;
use AppBundle\Entity\Ticket;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class CalculPrix extends Controller
{
    protected $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }


    /**
     * @return float
     */
    public function prixTotal(Ticket $ticket, $typeTicket)
    {
        $dateDeNaissance = $ticket->getDateNaissance()->diff(new \DateTime());

        $age = $dateDeNaissance->y;

        $prix = $this->em->getRepository('AppBundle:Prix')->find(1);

        $reduction = $ticket->getReduction();
        switch (true) {

            case ($age >= 12 && $age < 60 && $reduction === false):
                $prixTicket = $prix->getNormal();
                break;

            case ($age >= 60 && $reduction === false):
                $prixTicket = $prix->getSenior();
                break;

            case ($age >= 4 && $age < 12):
                $prixTicket = $prix->getEnfant();
                break;

            case (true === $reduction):
                $prixTicket = $prix->getReduit();
                break;

            default:
                $prixTicket = $prix->getGratuit();
                break;

        }

        if($typeTicket === false){
            return $prixTicket / 2;
        }
            return $prixTicket;
    }

}
