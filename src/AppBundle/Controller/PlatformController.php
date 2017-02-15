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
            'email' => $commande->getEmail(),
        );
        dump($cAtcu);


        return $this->render('::recap.html.twig', array('cActu' => $cAtcu));
    }



    /**
     * @Route("/validation/{id}", name="validation", methods="POST")
     */
    public function savePaiementAction($id)
    {
        \Stripe\Stripe::setApiKey("sk_test_tIN6ASnQYiwCF2nnehCiOPIl");
// Get the credit card details submitted by the form
        $token = $_POST['stripeToken'];

        $em = $this->getDoctrine()->getManager();
        $commande = $em->getRepository('AppBundle:Commande')->findOneById($id);

        dump($commande);
        $total = $commande->getPrixTotal();
        dump($total);

        // Create a charge: this will charge the user's card
        try {
            $charge = \Stripe\Charge::create(array(
                "amount" => $total * 100, // Amount in cents
                "currency" => "eur",
                "source" => $token,
                "description" => "Paiement Stripe"
            ));
            
            return $this->redirectToRoute("recap", array('id' => $commande->getId()));
        } catch(\Stripe\Error\Card $e) {

            $this->addFlash("error","Une erreur s'est produite. Veuillez essayer à nouveau");
            return $this->redirectToRoute("recap", array('id' => $commande->getId()));
            // The card has been declined
        }


    }





}