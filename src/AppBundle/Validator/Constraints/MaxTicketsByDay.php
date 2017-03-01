<?php

namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
* @Annotation
*/
class MaxTicketsByDay extends Constraint
{

    public $message = 'Le maximum de billets vendu pour ce jour a été atteind';


    public function validatedBy()
    {
        return get_class($this).'Validator';
    }
}
