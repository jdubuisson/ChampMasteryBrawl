<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Brawl;
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
        return $this->redirectToRoute('app_brawl_viewbrawl', ['id' => $brawl->getId()]);
    }

    /**
     * @Route("/brawl/{id}")
     * @ParamConverter("post", class="AppBundle:Brawl")
     */
    public function viewBrawlAction(Request $request, Brawl $brawl)
    {
        $em = $this->get('doctrine.orm.entity_manager');
        $staticChampionRepository = $em->getRepository('AppBundle:StaticChampion');
        $resultsForDisplay = array();
        for ($round = 1; $round <= 5; $round++) {
            $functionGetAtk = 'getAttackerChampion' . $round;
            $functionGetDef = 'getDefenderChampion' . $round;
            $functionGetVictor = 'getVictoriousChampion' . $round;

            $attacker = $staticChampionRepository->findOneByChampionId($brawl->$functionGetAtk());
            $defender = $staticChampionRepository->findOneByChampionId($brawl->$functionGetDef());
            $resultsForDisplay[] = ['attacker' => $attacker->getChampionKey(), 'defender' => $defender->getChampionKey(), 'victor' => $brawl->$functionGetVictor()];
        }

        return $this->render('AppBundle:Brawl:brawl.html.twig', ['brawl' => $brawl, 'resultsForDisplay' => $resultsForDisplay]);
    }

    /**
     * @Route("/my-assaults")
     */
    public function listAssaultsAction(Request $request)
    {

        $em = $this->get('doctrine.orm.entity_manager');
        $query = $em->getRepository('AppBundle:Brawl')->generateAssaultsQuery($this->getUser());
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            10/*limit per page*/
        );

        return $this->render('AppBundle:Brawl:assaults.html.twig', ['pagination' => $pagination]);
    }

    /**
     * @Route("/my-defenses")
     */
    public function listDefensesAction(Request $request)
    {

        $em = $this->get('doctrine.orm.entity_manager');
        $query = $em->getRepository('AppBundle:Brawl')->generateDefensesQuery($this->getUser());
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            10/*limit per page*/
        );

        return $this->render('AppBundle:Brawl:defenses.html.twig', ['pagination' => $pagination]);
    }
}
