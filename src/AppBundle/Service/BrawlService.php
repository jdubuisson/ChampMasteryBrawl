<?php

namespace AppBundle\Service;

use AppBundle\Entity\Brawl;
use AppBundle\Entity\ChampionMastery;
use UserBundle\Entity\User as AppUser;

class BrawlService
{


    private $doctrine;

    /**
     * Constructor
     * @param $doctrine
     */
    public function __construct($doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public function checkBrawlRules(AppUSer $attacker, AppUser $defender)
    {
        $isOk = false;
        $brawlRepository = $this->doctrine->getRepository('AppBundle:Brawl');
        $lastBrawlDate = $brawlRepository->findLastWonBrawlDate($attacker, $defender);

        if ($lastBrawlDate != null && count($lastBrawlDate) == 1) {
            //there is a previous brawl : we investigate
            $lastBrawlDate = $lastBrawlDate['date'];

            if ($lastBrawlDate < (new \DateTime())->modify('-24 hours')) {
                //the brawl is "old" : fight on !
                $isOk = true;
            } else {
                //the brawl is not "old" : we investigate
                $lastDefenderTeamUpdate = $defender->getLastTeamUpdate();
                if ($lastDefenderTeamUpdate != null) {
                    //Did the defender update his/her team since the last fight ?
                    $isOk = ($lastBrawlDate < $lastDefenderTeamUpdate);
                }
            }
        } else {
            //there is not a previous brawl : fight on !
            $isOk = true;
        }
        return $isOk;
    }


    public function computeBrawl(AppUSer $attacker, AppUser $defender)
    {
        $brawl = $this->initiateBrawl($attacker, $defender);
        $em = $this->doctrine->getManager();
        $championMasteryRepository = $em->getRepository('AppBundle:ChampionMastery');
        $attackerRoundsWon = 0;

        for ($round = 1; $round <= 5; $round++) {
            $functionGetAtk = 'getAttackerChampion' . $round;
            $functionGetDef = 'getDefenderChampion' . $round;
            $functionSetVictor = 'setVictoriousChampion' . $round;

            $atk = $championMasteryRepository->findPointsBySummonerAndChampionId($attacker->getSummoner(), $brawl->$functionGetAtk());
            $def = $championMasteryRepository->findPointsBySummonerAndChampionId($defender->getSummoner(), $brawl->$functionGetDef());
            if ($atk >= $def) {
                $brawl->$functionSetVictor('attacker');
                $attackerRoundsWon++;
            } else {
                $brawl->$functionSetVictor('defender');
            }
        }
        if ($attackerRoundsWon >= 3) {
            $brawl->setVictoriousUser('attacker');
        } else {
            $brawl->setVictoriousUser('defender');
        }
        $brawl->setDate(new \DateTime());
        $em->persist($brawl);
        $em->flush();
        return $brawl;
    }

    protected function initiateBrawl(AppUSer $attacker, AppUser $defender)
    {
        $brawl = new Brawl();
        $brawl->setAttacker($attacker);
        $brawl->setDefender($defender);
        $brawl->setAttackerChampion1($attacker->getChampion1());
        $brawl->setAttackerChampion2($attacker->getChampion2());
        $brawl->setAttackerChampion3($attacker->getChampion3());
        $brawl->setAttackerChampion4($attacker->getChampion4());
        $brawl->setAttackerChampion5($attacker->getChampion5());
        $brawl->setDefenderChampion1($defender->getChampion1());
        $brawl->setDefenderChampion2($defender->getChampion2());
        $brawl->setDefenderChampion3($defender->getChampion3());
        $brawl->setDefenderChampion4($defender->getChampion4());
        $brawl->setDefenderChampion5($defender->getChampion5());
        return $brawl;
    }
}