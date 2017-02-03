<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
/**
 * CommandeRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CommandeRepository extends EntityRepository
{

    public function getAllTickets()
    {
        $qb = $this
            ->createQueryBuilder('c')
            ->leftJoin('c.tickets', 'tic')
            ->addSelect('tic')
        ;

        return $qb->getQuery()->getResult();

    }

}
