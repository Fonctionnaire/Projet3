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

        $form = $this->createForm(TicketType::class, $ticket);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid())
        {
            $ticket->setCommande($commande);

            $em = $this->getDoctrine()->getManager();

            $em->persist($commande);
            $em->persist($ticket);

            $em->flush();

            return $this->redirectToRoute('recap');
        }

        return $this->render('::index.html.twig', array(
            'form' => $form->createView(),
        ));
    }



    /**
     * @Route("/recapitulatif/{id}", name="recap")
     */
    public function recapAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $commande = $em->getRepository('AppBundle:Commande')->find($id);




        return $this->render('::recap.html.twig', array(
            'commande' => $commande,
            'id' => $commande->getId()
        ));
    }


}