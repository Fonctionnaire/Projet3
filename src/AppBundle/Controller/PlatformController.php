<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Commande;
use AppBundle\Entity\Ticket;
use AppBundle\Form\CommandeType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
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

        $commande->addTicket($ticket);

        $form = $this->createForm(CommandeType::class, $commande);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

            $em = $this->getDoctrine()->getManager();


            $em->persist($commande);
            $em->persist($ticket);

            $em->flush();

            $method = $this->get('app.calculprix');
            $method->prixTotal($commande->getId());

            $em->persist($commande);
            $em->persist($ticket);
            $em->flush();

            dump($ticket);
            dump($commande);
            dump($method);
            return $this->redirectToRoute('recap', array('id' => $commande->getId()));
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
        $commande = $em->getRepository('AppBundle:Commande')->findOneById($id);

        $cAtcu = array(
            'date' => $commande->getDate(),
            'dateVisite' => $commande->getDateVisite(),
            'prixTotal' => $commande->getPrixTotal(),
            'typeTicket' => $commande->getTypeTicket(),
            'nbTickets' => $commande->getTickets(),
            'id' => $commande->getId(),
        );
        dump($cAtcu);


        return $this->render('::recap.html.twig', array('cActu' => $cAtcu));
    }

    /**
     * @Route("/paiement", name="paiement")
     */
    public function paiementAction()
    {


        return $this->render('::paiement.html.twig');

    }


}