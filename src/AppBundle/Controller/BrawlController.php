<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use UserBundle\Entity\User;

class BrawlController extends Controller
{
    /**
     * @Route("/opponents")
     */
    public function opponentsAction(Request $request)
    {

        $em = $this->get('doctrine.orm.entity_manager');
        $dql = "SELECT a FROM UserBundle:User a WHERE a.id <> " . $this->getUser()->getId();
        $query = $em->createQuery($dql);
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            10/*limit per page*/
        );


        return $this->render('AppBundle:Brawl:opponents.html.twig', ['pagination' => $pagination]);
    }

    /**
     * @Route("/challenge/{id}")
     * @ParamConverter("post", class="UserBundle:User")
     */
    public function challengeAction(Request $request, User $defendingUser)
    {
        $user = $this->getUser();
        $brawl = $this->get('cmb.brawl_service')->computeBrawl($user, $defendingUser);
        return $this->render('AppBundle:Brawl:challenge.html.twig', ['brawl' => $brawl]);
    }
}
