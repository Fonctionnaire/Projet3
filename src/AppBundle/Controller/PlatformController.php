<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Commande;
use AppBundle\Form\Type\CommandeType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;


class PlatformController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @Method({"GET", "POST"})
     */
    public function indexAction(Request $request)
    {
        $commande = new Commande();
        $form = $this->createForm(CommandeType::class, $commande);
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $listTickets = $commande->getTickets();
            foreach ($listTickets as $ticket)
            {
                $prixTicket = $this->get("app.calculprix")->prixTotal($ticket, $commande->getTypeTicket());
                $ticket->setPrix($prixTicket);
            }
            $em = $this->getDoctrine()->getManager();
            $codeReservation = $this->get("app.codeResa")->checkCodeResa();
            $commande->setCodeResa($codeReservation);
            $em->persist($commande);
            $em->flush();

            return $this->redirectToRoute('recap', array('id' => $commande->getId()));
        }
        return $this->render('::index.html.twig', array('form' => $form->createView(),));
    }


    /**
     * @Route("/recapitulatif/{id}", name="recap")
     * @Method({"GET"})
     */
    public function recapAction(Commande $commande)
    {
        return $this->render('::recap.html.twig', array('commande' => $commande));
    }


    /**
     * @Route("/validation/{id}", name="validation", methods="POST")
     */
    public function savePaiementAction(Request $request, Commande $commande)
    {
        \Stripe\Stripe::setApiKey("sk_test_tIN6ASnQYiwCF2nnehCiOPIl");

        $token = $request->request->get('stripeToken');

        $total = $commande->getPrixTotal();

        try {
            \Stripe\Charge::create(array(
                "amount" => $total * 100, "currency" => "eur", "source" => $token,
                "description" => "Paiement Stripe"
            ));

            $message = \Swift_Message::newInstance()->setSubject('Votre commande')
                ->setFrom('commande@louvre.fr')
                ->setTo($commande->getEmail())
                ->setBody($this->renderView(
                        'Emails/ticket.html.twig',
                        array(
                            'commande' => $commande)
                    ),
                    'text/html'
                );
            $this->get('mailer')->send($message);

            return $this->redirectToRoute("confirmation", array('id' => $commande->getId()));
        } catch(\Stripe\Error\Card $e) {

            $this->addFlash("error","Une erreur s'est produite. Veuillez essayer à nouveau");
            return $this->redirectToRoute("recap", array('id' => $commande->getId()));
        }
    }

    /**
     * @Route("/confirmation/{id}", name="confirmation")
     * @Method({"GET"})
     */
    public function confirmationAction(Commande $commande)
    {
        if ($commande->getPrixTotal() == 0)
        {
            $message = \Swift_Message::newInstance()->setSubject('Votre commande')
                ->setFrom('commande@louvre.fr')
                ->setTo($commande->getEmail())
                ->setBody($this->renderView(
                    'Emails/ticket.html.twig',
                    array(
                        'commande' => $commande)
                ),
                    'text/html'
                );
            $this->get('mailer')->send($message);
        }

        return $this->render("::confirmation.html.twig", array('id' => $commande->getId()));
    }

}
