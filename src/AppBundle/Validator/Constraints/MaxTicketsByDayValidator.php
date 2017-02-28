<?php

namespace AppBundle\Validator\Constraints;



use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Doctrine\ORM\EntityManagerInterface;


class MaxTicketsByDayValidator extends ConstraintValidator
{

    /**
     * @var EntityManagerInterface
     */
    protected $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }


    public function validate($value, Constraint $constraint)
    {


        $commandes = $this->em->getRepository('AppBundle:Commande')->findAll();

        $nbTickets = 0;
        foreach ($commandes as $commande)
        {
            $dateVisite =  $commande->getDateVisite();


            $listTickets = $commande->getTickets();

            $nbTickets += count($listTickets);

        }

        if ($dateVisite && $nbTickets >= 1000)
        {
            $this->context
                ->buildViolation($constraint->message)
                ->setParameters(array('%string%' => $value))
                ->addViolation();
        }




    }
}