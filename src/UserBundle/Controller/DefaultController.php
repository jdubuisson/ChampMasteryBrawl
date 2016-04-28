<?php

namespace UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     */
    public function profileAction()
    {
        return $this->render('UserBundle:Default:profile.html.twig', ['user' => $this->getUser()]);
    }
}
