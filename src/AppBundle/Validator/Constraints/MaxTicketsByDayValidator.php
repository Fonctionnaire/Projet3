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

      $maxTicket = $this->em->getRepository('AppBundle:Ticket')->getMaxTicketByDate($value);

       if ($maxTicket >= 999)
        {
            $this->context
                ->buildViolation($constraint->messageMaxTicket)
                ->addViolation();
        }

    }
}
