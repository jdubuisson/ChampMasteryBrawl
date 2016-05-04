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
        $user = $this->getUser();
        if ($user->getSummoner() == null) {
            return $this->redirectToRoute('user_summoner_link');
        }
        $this->get('cmb.user_mastery_service')->updateUserMasteryData($user);
        return $this->render('UserBundle:Default:profile.html.twig', ['user' => $user]);
    }
}
