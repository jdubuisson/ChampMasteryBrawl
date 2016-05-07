<?php

namespace UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

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
            if ($user->$functionGetChampion() == null) {
                $champion = null;
            } else {
                $champion = $staticChampions[$user->$functionGetChampion()];
            }
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

    /**
     * @Route("/edit-team")
     */
    public function editTeamAction(Request $request)
    {
        //user
        $user = $this->getUser();
        $summoner = $user->getSummoner();
        if ($summoner == null) {
            return $this->redirectToRoute('user_summoner_link');
        }

        $doctrine = $this->getDoctrine();

        //mastery data
        $masteryData = $doctrine->getRepository('AppBundle:ChampionMastery')->findTopBySummoner($summoner);

        //team update
        //very ugly but gets the job done.
        $id0 = $request->query->get('id0');
        if ($id0 != null && array_key_exists($id0, $masteryData)) {
            $user->setChampion1($id0);
            $id1 = $request->query->get('id1');
            $this->addFlash('success', 'cmb.team.successful_update');
            if ($id1 != null && array_key_exists($id1, $masteryData)) {
                $user->setChampion2($id1);
                $user->setLastTeamUpdate(new \DateTime());
                $id2 = $request->query->get('id2');
                if ($id2 != null && array_key_exists($id2, $masteryData)) {
                    $user->setChampion3($id2);
                    $id3 = $request->query->get('id3');
                }
                if ($id3 != null && array_key_exists($id3, $masteryData)) {
                    $user->setChampion4($id3);
                    $id4 = $request->query->get('id4');
                    if ($id4 != null && array_key_exists($id4, $masteryData)) {
                        $user->setChampion5($id4);
                    }
                }
            }
            $em = $doctrine->getEntityManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('user_default_editteam');
        }
        //static champions
        $staticChampionRepository = $doctrine->getRepository('AppBundle:StaticChampion');
        $staticChampions = $staticChampionRepository->findByChampionIdsWithIndex(array_keys($masteryData));
        //team data
        $teamData = array();
        for ($round = 1; $round <= 5; $round++) {
            $functionGetChampion = 'getChampion' . $round;
            $key = $user->$functionGetChampion();
            $champion = null;
            if ($key != null) {
                if (array_key_exists($key, $masteryData)) {
                    $champion = $masteryData[$key];
                    unset($masteryData[$key]);
                }
            }
            $teamData[] = $champion;
        }


        return $this->render('UserBundle:Team:edit.html.twig',
            ['user' => $user,
                'masteryData' => $masteryData,
                'teamData' => $teamData,
                'staticChampions' => $staticChampions]);
    }
}
