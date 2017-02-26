<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Commande;
use AppBundle\Entity\Ticket;
use AppBundle\Form\CommandeType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;



class PlatformController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $ticket = new Ticket();
        $commande = new Commande();
        //$commande->setEmail('test@test.com');

       // $commande->addTicket($ticket);

        $form = $this->createForm(CommandeType::class, $commande);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
dump($commande);
            // BOUCLE FOREACH

            $listTickets = $commande->getTickets();
            foreach ($listTickets as $ticket)
            {
                $prixTicket = $this->get("app.calculprix")->prixTotal($ticket);

                dump($commande->getPrixTotal());

                dump($ticket);

                $ticket->setPrix($prixTicket);



                dump($commande->getPrixTotal());

            }

            dump($commande->getPrixTotal());
            dump($commande);
            dump($ticket);
            dump($commande->getTickets());
            $em = $this->getDoctrine()->getManager();

// ====================================================
            $em->persist($commande);
            $em->persist($ticket);

            $em->flush();



            dump($ticket);
            dump($commande);

            return $this->redirectToRoute('recap', array('id' => $commande->getId()));
        }

        return $this->render('::index.html.twig', array(
            'form' => $form->createView(),
        ));
    }


    /**
     * @Route("/recapitulatif/{id}", name="recap")
     * @ParamConverter("ticket", options={"mapping": {"commande_id": "commande"}})
     */
    public function recapAction($id)
    {

        $em = $this->getDoctrine()->getManager();
        $commande = $em->getRepository('AppBundle:Commande')->findOneById($id);

        $listTickets = $em
        ->getRepository('AppBundle:Ticket')
        ->findBy(array('commande' => $commande));

        dump($listTickets);
        $cAtcu = array(
            'commande' => $commande,

        );
        dump($cAtcu);


        return $this->render('::recap.html.twig', array('cActu' => $cAtcu,
            'listTickets' => $listTickets));
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

        $listTickets = $em
            ->getRepository('AppBundle:Ticket')
            ->findBy(array('commande' => $commande));

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


            $message = \Swift_Message::newInstance()
                ->setSubject('Votre commande')
                ->setFrom('commande@louvre.fr')
                ->setTo($commande->getEmail())
                ->setBody(
                    $this->renderView(
                        'Emails/ticket.html.twig',
                        array(
                            'commande' => $commande,
                            'listTickets' => $listTickets
                        )
                    ),
                    'text/html'
                );
            $this->get('mailer')->send($message);

            $this->addFlash('notice', 'Le paiement a bien été effectué, vous allez recevoir vos billets par e-mail');

            return $this->redirectToRoute("confirmation", array('id' => $commande->getId()));
        } catch(\Stripe\Error\Card $e) {

            $this->addFlash("error","Une erreur s'est produite. Veuillez essayer à nouveau");
            return $this->redirectToRoute("recap", array('id' => $commande->getId()));
            // The card has been declined
        }


    }

    /**
     * @Route("/confirmation/{id}", name="confirmation")
     */
    public function confirmationAction($id)
    {

        $em = $this->getDoctrine()->getManager();
        $commande = $em->getRepository('AppBundle:Commande')->findOneById($id);

        return $this->render("::confirmation.html.twig", array('id' => $commande->getId()));
    }





}