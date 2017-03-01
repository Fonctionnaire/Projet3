<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Commande;
use AppBundle\Entity\Ticket;
use AppBundle\Form\Type\CommandeType;
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

        $form = $this->createForm(CommandeType::class, $commande);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {


            $listTickets = $commande->getTickets();
            foreach ($listTickets as $ticket)
            {
                $prixTicket = $this->get("app.calculprix")->prixTotal($ticket);

                $ticket->setPrix($prixTicket);
            }

            $m=microtime(true);
            $codeReservation = sprintf("%8x%05x",floor($m),($m-floor($m))*1000000);

            $em = $this->getDoctrine()->getManager();

            $codes = $em->getRepository('AppBundle:Commande')->findOneByCodeResa($codeReservation);


            while ($codes == $codeReservation)
            {
                $codeReservation = sprintf("%8x%05x",floor($m),($m-floor($m))*1000000);
            }

            $commande->setCodeResa($codeReservation);

            $em->persist($commande);
            $em->persist($ticket);

            $em->flush();

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

        $cAtcu = array(
            'commande' => $commande,

        );

        return $this->render('::recap.html.twig', array('cActu' => $cAtcu,
            'listTickets' => $listTickets));
    }



    /**
     * @Route("/validation/{id}", name="validation", methods="POST")
     */
    public function savePaiementAction(Request $request, $id)
    {
        \Stripe\Stripe::setApiKey("sk_test_tIN6ASnQYiwCF2nnehCiOPIl");

       //$token = $_POST['stripeToken'];
        $token = $request->request->get('stripeToken');
        $em = $this->getDoctrine()->getManager();
        $commande = $em->getRepository('AppBundle:Commande')->findOneById($id);

        $listTickets = $em->getRepository('AppBundle:Ticket')->findBy(array('commande' => $commande));

        $total = $commande->getPrixTotal();

        try {
            $charge = \Stripe\Charge::create(array(
                "amount" => $total * 100,
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
