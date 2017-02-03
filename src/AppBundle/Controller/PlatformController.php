<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Ticket;
use AppBundle\Entity\Commande;
use AppBundle\Entity\Prix;
use AppBundle\Form\TicketType;
use AppBundle\Form\CommandeType;
use Symfony\Component\HttpFoundation\Request;


class PlatformController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $ticket = new Ticket();
        $commande = new Commande();
        $commande->setEmail('test@test.com');
        $commande->setPrixTotal(12);

        $ticket->setCommande($commande);
        $commande->getTickets()->add($ticket);

        $form = $this->createForm(CommandeType::class, $commande);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid())
        {


            $em = $this->getDoctrine()->getManager();

            $em->persist($ticket);
            $em->persist($commande);

            dump($ticket);
            dump($commande);

            $em->flush();

            return $this->redirectToRoute('recap', array('id' => $commande->getId()));
        }

        return $this->render('::index.html.twig', array(
            'form' => $form->createView(),
        ));
    }



    /**
     * @Route("/recapitulatif/{id}", name="recap")
     */
    public function recapAction()
    {
        $tickets = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('AppBundle:Commande')
            ->getAllTickets();

        dump($tickets);



        return $this->render('::recap.html.twig', array(
            'commande' => $commande,
            'id' => $commande->getId()
        ));
    }


}