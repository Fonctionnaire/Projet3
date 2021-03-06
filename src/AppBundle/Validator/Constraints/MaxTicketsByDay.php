<?php

namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
* @Annotation
*/
class MaxTicketsByDay extends Constraint
{

    public $messageMaxTicket = 'Le maximum de billets vendu pour ce jour a été atteint';

    public function validatedBy()
    {
        return get_class($this).'Validator';
    }
}
