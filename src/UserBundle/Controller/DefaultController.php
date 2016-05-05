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
        //user
        $user = $this->getUser();
        $summoner = $user->getSummoner();
        if ($summoner == null) {
            return $this->redirectToRoute('user_summoner_link');
        } else {
            $this->get('cmb.user_mastery_service')->updateUserMasteryData($user);
        }

        $doctrine = $this->getDoctrine();
        //mastery data
        $masteryData = $doctrine->getRepository('AppBundle:ChampionMastery')->findTopBySummoner($summoner);

        //static champions
        $staticChampionRepository = $doctrine->getRepository('AppBundle:StaticChampion');
        $staticChampions = $staticChampionRepository->findByChampionIdsWithIndex(array_keys($masteryData));

        //team details
        $teamDetails = array();
        for ($round = 1; $round <= 5; $round++) {
            $functionGetChampion = 'getChampion' . $round;
            $champion = $staticChampions[$user->$functionGetChampion()];
            $teamDetails[$round] = ['championData' => $champion];
        }

        //stats
        $stats = $doctrine->getRepository('AppBundle:Brawl')->getStatsForUser($user);

        return $this->render('UserBundle:Profile:profile.html.twig',
            [
                'user' => $user,
                'masteryData' => $masteryData,
                'teamDetails' => $teamDetails,
                'staticChampions' => $staticChampions,
                'stats' => $stats
            ]);
    }
}
