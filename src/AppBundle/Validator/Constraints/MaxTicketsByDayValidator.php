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

        //dump($value);

// COmpter le nb ticket vendu pour un jour (dans le repository Ticket avec jointure avec Commande)

       /* if ($dateVisite && $nbTickets >= 2)
        {
            $this->context
                ->buildViolation($constraint->message)
                ->setParameters(array('%string%' => $value))
                ->addViolation();
        }*/




    }
}
