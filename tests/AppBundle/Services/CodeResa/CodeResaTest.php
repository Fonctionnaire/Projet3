<?php

namespace Tests\AppBundle\Services\CodeResa;


use AppBundle\Entity\Commande;
use AppBundle\Services\CodeResa\CodeResa;
use Doctrine\Bundle\DoctrineBundle\Tests\TestCase;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class CodeResaTest extends TestCase
{
    public function testCodeResa()
    {
        $codeReservertation = $this->createMock(Commande::class);
        $codeReservertation
            ->method('getCodeResa')
            ->will($this->returnValue('abDfg42892er2s8'));

        $commandeRepository = $this
            ->getMockBuilder(EntityRepository::class)
            ->disableOriginalConstructor()
            ->getMock();
        $commandeRepository
            ->method('find')
            ->will($this->returnValue($codeReservertation));

        $em = $this
            ->getMockBuilder(EntityManagerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $em->expects($this->once())
            ->method('getRepository')
            ->will($this->returnValue($commandeRepository));

        $codeResa = new CodeResa($em);
        $this->assertNotEquals('abDfg42892er2s8', $codeResa->checkCodeResa());
    }
}
