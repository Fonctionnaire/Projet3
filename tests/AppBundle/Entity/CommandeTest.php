<?php

namespace Tests\AppBundle\Entity;

use AppBundle\Entity\Commande;
use AppBundle\Entity\Ticket;
use Doctrine\Bundle\DoctrineBundle\Tests\TestCase;

class CommandeTest extends TestCase
{

    public function testGetPrixTotal()
    {
        $commande = new Commande();
        $ticket1 = new Ticket();
        $ticket2 = new Ticket();
        $ticket3 = new Ticket();

        $prix1 = $ticket1->setPrix(13);
        $prix2 = $ticket2->setPrix(5);
        $prix3 = $ticket3->setPrix(19);

        $commande->setTickets(array('prix1' => $prix1, 'prix2' => $prix2, 'prix3' => $prix3));

        $result = $commande->getPrixTotal();

        $this->assertEquals(37, $result);
    }
}
