<?php

namespace AppBundle\Services\CodeResa;


use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CodeResa extends Controller
{
    protected $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function checkCodeResa()
    {
        $m=microtime(true);
        $codeReservation = sprintf("%8x%05x",floor($m),($m-floor($m))*1000000);

        $codes = $this->em->getRepository('AppBundle:Commande')->findOneByCodeResa($codeReservation);

        while ($codes == $codeReservation)
        {
            $codeReservation = sprintf("%8x%05x",floor($m),($m-floor($m))*1000000);
        }

        return $codeReservation;
    }
}