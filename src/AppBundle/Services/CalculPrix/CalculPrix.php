<?php

namespace AppBundle\Services\CalculPrix;


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


    public function prixTotal($id)
    {
        // ON RECUPERE LES TICKETS D'UNE COMMANDE

        $em = $this->em->getRepository('AppBundle:Commande')->findOneById($id);

        $listTickets = $em->getTickets();


        $prixCommande = 0;
        foreach ($listTickets as $key => $tickets) {

            // ON RECUPERE LA DATE DE NAISSANCE POUR CALCULER L'AGE

            $dateDeNaissance = $tickets->getDateNaissance()->diff(new \DateTime());

            $age = $dateDeNaissance->y;
            dump($age);

            // ON ATTRIBUT UN PRIX EN FONCTION DE L'AGE ET D'UNE REDUCTION

            $prix = new Prix();

            $reduction = $tickets->getReduction();
            switch (true) {

                case ($age >= 12 && $age < 60 && $reduction == false) :
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

            dump($reduction);
            dump($prixTicket);

            $prixCommande += $prixTicket;

            dump($prixCommande);
        }


        // ON RECUPERE LE TYPE DE TICKET CHOISI POUR LA COMMANDE POUR DEFINIR LE PRIX TOTAL
        $typeTicket = $em->getTypeTicket();

        $prixTotalCommande = $prixCommande;

        if ($typeTicket == false) {
            $prixTotalCommande = $prixCommande / 2;
        }

        $em->setPrixTotal($prixTotalCommande);

        dump($prixTotalCommande);

        return $prixTotalCommande;

    }

}