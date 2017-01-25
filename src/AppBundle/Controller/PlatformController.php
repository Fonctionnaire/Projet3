<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class PlatformController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
        return $this->render('::layout.html.twig');
    }

    /**
     * @Route("/recapitulatif", name="recap")
     */
    public function recapAction()
    {
        return $this->render('::recap.html.twig');
    }
}