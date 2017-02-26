<?php

namespace AppBundle\Validator\Constraints;



use Doctrine\ORM\EntityManager;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use AppBundle\Entity\Commande;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @Annotation
 */
class MaxTicketsByDay extends ConstraintValidator
{
    protected  $em;

    public function __contruct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function validate($value, Constraint $constraint)
    {



    }
}