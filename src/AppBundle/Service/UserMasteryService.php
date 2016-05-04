<?php

namespace AppBundle\Service;

use AppBundle\Entity\ChampionMastery;
use UserBundle\Entity\User as AppUser;

class UserMasteryService
{

    /**
     * @var Service
     */
    private $masteryService;

    private $doctrine;

    /**
     * Constructor
     * @param $masteryService
     */
    public function __construct($masteryService, $doctrine)
    {
        $this->masteryService = $masteryService;
        $this->doctrine = $doctrine;
    }

    public function updateUserMasteryData(AppUser $user)
    {
        if ($user->getLastMasteryUpdate() == null || $user->getLastMasteryUpdate() < (new \DateTime())->modify('-24 hours')) {
            $summoner = $user->getSummoner();
            $region = $user->getRegion();
            $results = $this->masteryService->getChampionMasteryForSummonerId($summoner->getId(), $region);
            $em = $this->doctrine->getManager();
            foreach ($results as $championMastery) {
                $champMasteryObject = $em->getRepository('AppBundle:ChampionMastery')->findBySummonerAndChampionId($summoner, $championMastery->championId);
                if ($champMasteryObject == null) {
                    $champMasteryObject = new ChampionMastery();
                }
                $champMasteryObject->setChampionId($championMastery->championId);
                if (isset($championMastery->championLevel)) {
                    $champMasteryObject->setChampionLevel($championMastery->championLevel);
                }
                $champMasteryObject->setChampionPoints($championMastery->championPoints);
                if (isset($championMastery->championPointsSinceLastLevel)) {
                    $champMasteryObject->setChampionPointsSinceLastLevel($championMastery->championPointsSinceLastLevel);
                }
                if (isset($championMastery->championPointsUntilNextLevel)) {
                    $champMasteryObject->setChampionPointsUntilNextLevel($championMastery->championPointsUntilNextLevel);
                }
                if (isset($championMastery->chestGranted)) {
                    $champMasteryObject->setChestGranted($championMastery->chestGranted);
                }
                if (isset($championMastery->highestGrade)) {
                    $champMasteryObject->setHighestGrade($championMastery->highestGrade);
                }
                if (isset($championMastery->lastPlayTime)) {
                    $champMasteryObject->setLastPlayTime($championMastery->lastPlayTime);
                }
                $champMasteryObject->setSummoner($summoner);
                $em->persist($champMasteryObject);
            }
            $user->setLastMasteryUpdate(new \DateTime());
            $em->flush();
        }
    }
}