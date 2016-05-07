<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Brawl;
use AppBundle\Form\Type\FilterOpponentsType;
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
        $user = $this->getUser();
        if ($user->getSummoner() == null) {
            return $this->redirectToRoute('user_summoner_link');
        }
        $doctrine = $this->getDoctrine();
        //
        $form = $this->createForm(FilterOpponentsType::class);
        $form->handleRequest($request);
        $data = $form->getData();
        $query = $doctrine->getRepository('UserBundle:User')->generateOpponentsQuery($this->getUser(), $data);
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            10/*limit per page*/
        );

        return $this->render('AppBundle:Brawl:opponents.html.twig', ['pagination' => $pagination, 'form' => $form->createView(),]);
    }

    /**
     * @Route("/challenge/{id}")
     * @ParamConverter("post", class="UserBundle:User")
     */
    public function challengeAction(Request $request, User $defendingUser)
    {
        $user = $this->getUser();
        if ($user->getSummoner() == null) {
            return $this->redirectToRoute('user_summoner_link');
        }
        $brawlService = $this->get('cmb.brawl_service');
        //check if we can attack the defendingUser
        $brawlCanTakePlace = $brawlService->checkBrawlRules($user, $defendingUser);
        if (!$brawlCanTakePlace) {
            $this->addFlash('warning', 'cmb.brawl.cannot_attack_this_user_yet');
            return $this->redirectToRoute('app_brawl_opponents');
        }
        $brawl = $brawlService->computeBrawl($user, $defendingUser);
        return $this->redirectToRoute('app_brawl_viewbrawl', ['id' => $brawl->getId()]);
    }

    /**
     * @Route("/brawl/{id}")
     * @ParamConverter("post", class="AppBundle:Brawl")
     */
    public function viewBrawlAction(Request $request, Brawl $brawl)
    {
        $user = $this->getUser();
        if ($user->getSummoner() == null) {
            return $this->redirectToRoute('user_summoner_link');
        }
        $doctrine = $this->getDoctrine();
        $staticChampionRepository = $doctrine->getRepository('AppBundle:StaticChampion');
        $resultsForDisplay = array();


        $championMasteryRepository = $doctrine->getRepository('AppBundle:ChampionMastery');

        $attackerMasteryArray = $championMasteryRepository->findPointsBySummonerAndChampionIds($brawl->getAttacker()->getSummoner(), $brawl->getAttackerChampionIds());
        $defenderMasteryArray = $championMasteryRepository->findPointsBySummonerAndChampionIds($brawl->getDefender()->getSummoner(), $brawl->getDefenderChampionIds());

        for ($round = 1; $round <= 5; $round++) {
            $functionGetAtk = 'getAttackerChampion' . $round;
            $functionGetDef = 'getDefenderChampion' . $round;
            $functionGetVictor = 'getVictoriousChampion' . $round;

            $attacker = $staticChampionRepository->findOneByChampionId($brawl->$functionGetAtk());
            $defender = $staticChampionRepository->findOneByChampionId($brawl->$functionGetDef());
            if ($attacker == null) {
                $attackerKey = null;
                $attackerMastery = 0;
            } else {
                $attackerKey = $attacker->getChampionKey();
                $attackerMastery = $attackerMasteryArray[$attacker->getChampionId()];
            }
            if ($defender == null) {
                $defenderKey = null;
                $defenderMastery = 0;
            } else {
                $defenderKey = $defender->getChampionKey();
                $defenderMastery = $defenderMasteryArray[$defender->getChampionId()];
            }
            $resultsForDisplay[] = [
                'attacker' => $attackerKey,
                'defender' => $defenderKey,
                'victor' => $brawl->$functionGetVictor(),
                'attackerMastery' => $attackerMastery,
                'defenderMastery' => $defenderMastery
            ];
        }

        return $this->render('AppBundle:Brawl:brawl.html.twig', ['brawl' => $brawl, 'resultsForDisplay' => $resultsForDisplay]);
    }

    /**
     * @Route("/my-assaults")
     */
    public function listAssaultsAction(Request $request)
    {
        $user = $this->getUser();
        if ($user->getSummoner() == null) {
            return $this->redirectToRoute('user_summoner_link');
        }
        $doctrine = $this->getDoctrine();
        $query = $doctrine->getRepository('AppBundle:Brawl')->generateAssaultsQuery($user);
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
        $user = $this->getUser();
        if ($user->getSummoner() == null) {
            return $this->redirectToRoute('user_summoner_link');
        }
        $doctrine = $this->getDoctrine();
        $query = $doctrine->getRepository('AppBundle:Brawl')->generateDefensesQuery($user);
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            10/*limit per page*/
        );

        return $this->render('AppBundle:Brawl:defenses.html.twig', ['pagination' => $pagination]);
    }
}
