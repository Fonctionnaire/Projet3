<?php

namespace Tests\AppBundle\Services\CalculPrix;

use AppBundle\Entity\Ticket;
use AppBundle\Services\CalculPrix\CalculPrix;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;
use Doctrine\ORM\EntityRepository;
use AppBundle\Entity\Prix;


class CalculPrixTest extends TestCase
{

    /**
     * @var CalculPrix
     */
    private $service;

    protected function setUp()
    {
        $prix = new Prix();

        $prix->setSenior(12);
        $prix->setEnfant(8);
        $prix->setGratuit(0);
        $prix->setNormal(16);
        $prix->setReduit(10);

        $prixRepository = $this
            ->getMockBuilder(EntityRepository::class)
            ->disableOriginalConstructor()
            ->getMock();
        $prixRepository->expects($this->any())
            ->method('find')
            ->will($this->returnValue($prix));

        $em = $this
            ->getMockBuilder(EntityManagerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $em->expects($this->any())
            ->method('getRepository')
            ->will($this->returnValue($prixRepository));

        $this->service = new CalculPrix($em);
    }

    public function testPrixTicketIsSenior()
    {
        $ticket = new Ticket();
        $ticket->setReduction(false);
        $ticket->setDateNaissance(new \DateTime('1910-10-10'));

        $this->assertEquals(12, $this->service->prixTotal($ticket, true));
    }

    public function testPrixTicketIsEnfant()
    {
        $ticket = new Ticket();
        $ticket->setReduction(false);
        $ticket->setDateNaissance(new \DateTime('2009-10-10'));

        $this->assertEquals(8, $this->service->prixTotal($ticket, true));
    }

    public function testPrixTicketIsNormal()
    {
        $ticket = new Ticket();
        $ticket->setReduction(false);
        $ticket->setDateNaissance(new \DateTime('1995-10-10'));

        $this->assertEquals(16, $this->service->prixTotal($ticket, true));
    }

    public function testPrixTicketIsGratuit()
    {
        $ticket = new Ticket();
        $ticket->setReduction(false);
        $ticket->setDateNaissance(new \DateTime('2015-10-10'));

        $this->assertEquals(0, $this->service->prixTotal($ticket, true));
    }

    public function testPrixTicketIsReduit()
    {
        $ticket = new Ticket();
        $ticket->setReduction(true);
        $ticket->setDateNaissance(new \DateTime('1910-10-10'));

        $this->assertEquals(10, $this->service->prixTotal($ticket, true));
    }

    public function testPrixTicketIsSeniorAndDemi()
    {
        $ticket = new Ticket();
        $ticket->setReduction(false);
        $ticket->setDateNaissance(new \DateTime('1910-10-10'));

        $this->assertEquals(6, $this->service->prixTotal($ticket, false));
    }

    public function testPrixTicketIsEnfantAndDemi()
    {
        $ticket = new Ticket();
        $ticket->setReduction(false);
        $ticket->setDateNaissance(new \DateTime('2009-10-10'));

        $this->assertEquals(4, $this->service->prixTotal($ticket, false));
    }

    public function testPrixTicketIsNormalAndDemi()
    {
        $ticket = new Ticket();
        $ticket->setReduction(false);
        $ticket->setDateNaissance(new \DateTime('1995-10-10'));

        $this->assertEquals(8, $this->service->prixTotal($ticket, false));
    }

    public function testPrixTicketIsGratuitAndDemi()
    {
        $ticket = new Ticket();
        $ticket->setReduction(false);
        $ticket->setDateNaissance(new \DateTime('2015-10-10'));

        $this->assertEquals(0, $this->service->prixTotal($ticket, false));
    }

    public function testPrixTicketIsReduitAndDemi()
    {
        $ticket = new Ticket();
        $ticket->setReduction(true);
        $ticket->setDateNaissance(new \DateTime('1910-10-10'));

        $this->assertEquals(5, $this->service->prixTotal($ticket, false));
    }

}
