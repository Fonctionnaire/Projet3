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



    public function testPrixTicketIsGratuit()
    {

        $prix = $this->createMock(Prix::class);
        $prix->method('getId')
            ->will($this->returnValue(1));
        $prix->expects($this->once())
            ->method('getGratuit')
            ->will($this->returnValue(0));


        $ticket = $this->createMock(Ticket::class);
        $ticket->expects($this->once())
            ->method('getDateNaissance')
            ->will($this->returnValue(new \DateTime()));


        $prixRepository = $this
            ->getMockBuilder(EntityRepository::class)
            ->disableOriginalConstructor()
            ->getMock();
        $prixRepository->expects($this->once())
            ->method('find')
            ->will($this->returnValue($prix));

        $em = $this
            ->getMockBuilder(EntityManagerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $em->expects($this->once())
            ->method('getRepository')
            ->will($this->returnValue($prixRepository));

        $calculPrix = new CalculPrix($em);
        $this->assertEquals(0, $calculPrix->prixTotal($ticket));

    }

    public function testPrixTicketIsSenior()
    {
        $prix = $this->createMock(Prix::class);
        $prix
            ->method('getId')
            ->will($this->returnValue(1));
        $prix->expects($this->once())
            ->method('getSenior')
            ->will($this->returnValue(12));


        $ticket = $this->createMock(Ticket::class);
        $ticket->expects($this->once())
            ->method('getDateNaissance')
            ->will($this->returnValue(new \DateTime()));


        $prixRepository = $this
            ->getMockBuilder(EntityRepository::class)
            ->disableOriginalConstructor()
            ->getMock();
        $prixRepository->expects($this->once())
            ->method('find')
            ->will($this->returnValue($prix));

        $em = $this
            ->getMockBuilder(EntityManagerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $em->expects($this->once())
            ->method('getRepository')
            ->will($this->returnValue($prixRepository));



        $calculPrix = new CalculPrix($em);
        $this->assertEquals(12, $calculPrix->prixTotal($ticket));
    }

    public function testPrixTicketIsNormal()
    {
        $prix = $this->createMock(Prix::class);
        $prix
            ->method('getId')
            ->will($this->returnValue(1));
        $prix->expects($this->once())
            ->method('getNormal')
            ->will($this->returnValue(16));


        $ticket = $this->createMock(Ticket::class);
        $ticket->expects($this->once())
            ->method('getDateNaissance')
            ->will($this->returnValue(new \DateTime()));


        $prixRepository = $this
            ->getMockBuilder(EntityRepository::class)
            ->disableOriginalConstructor()
            ->getMock();
        $prixRepository->expects($this->once())
            ->method('find')
            ->will($this->returnValue($prix));

        $em = $this
            ->getMockBuilder(EntityManagerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $em->expects($this->once())
            ->method('getRepository')
            ->will($this->returnValue($prixRepository));



        $calculPrix = new CalculPrix($em);
        $this->assertEquals(16, $calculPrix->prixTotal($ticket));
    }

    public function testPrixTicketIsEnfant()
    {
        $prix = $this->createMock(Prix::class);
        $prix
            ->method('getId')
            ->will($this->returnValue(1));
        $prix->expects($this->once())
            ->method('getEnfant')
            ->will($this->returnValue(8));


        $ticket = $this->createMock(Ticket::class);
        $ticket->expects($this->once())
            ->method('getDateNaissance')
            ->will($this->returnValue(new \DateTime()));


        $prixRepository = $this
            ->getMockBuilder(EntityRepository::class)
            ->disableOriginalConstructor()
            ->getMock();
        $prixRepository->expects($this->once())
            ->method('find')
            ->will($this->returnValue($prix));

        $em = $this
            ->getMockBuilder(EntityManagerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $em->expects($this->once())
            ->method('getRepository')
            ->will($this->returnValue($prixRepository));



        $calculPrix = new CalculPrix($em);
        $this->assertEquals(8, $calculPrix->prixTotal($ticket));
    }

    public function testPrixTicketIsReduit()
    {
        $prix = $this->createMock(Prix::class);
        $prix
            ->method('getId')
            ->will($this->returnValue(1));
        $prix->expects($this->once())
            ->method('getReduit')
            ->will($this->returnValue(10));


        $ticket = $this->createMock(Ticket::class);
        $ticket->expects($this->once())
            ->method('getDateNaissance')
            ->will($this->returnValue(new \DateTime()));


        $prixRepository = $this
            ->getMockBuilder(EntityRepository::class)
            ->disableOriginalConstructor()
            ->getMock();
        $prixRepository->expects($this->once())
            ->method('find')
            ->will($this->returnValue($prix));

        $em = $this
            ->getMockBuilder(EntityManagerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $em->expects($this->once())
            ->method('getRepository')
            ->will($this->returnValue($prixRepository));



        $calculPrix = new CalculPrix($em);
        $this->assertEquals(10, $calculPrix->prixTotal($ticket));
    }
}
