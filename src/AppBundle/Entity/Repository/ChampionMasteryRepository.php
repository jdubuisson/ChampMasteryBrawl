<?php

namespace AppBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * ChampionMasteryRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ChampionMasteryRepository extends EntityRepository
{

    public function findBySummonerAndChampionId($summoner, $championId)
    {
        $query = $this->createQueryBuilder('cm')
            ->where('cm.summoner = :summoner')->andWhere('cm.championId = :championId')
            ->setParameter('summoner', $summoner)
            ->setParameter('championId', $championId)
            ->getQuery();
        return $query->getOneOrNullResult();
    }

    public function findTopBySummoner($summoner, $limit = null)
    {
        $query = $this->createQueryBuilder('cm')
            ->indexBy('cm', 'cm.championId')
            ->where('cm.summoner = :summoner')
            ->setParameter('summoner', $summoner)
            ->orderBy('cm.championPoints', 'DESC')->getQuery();
        if ($limit != null) {
            $query->setMaxResults($limit);
        }
        return $query->getResult();
    }

    public function findPointsBySummonerAndChampionId($summoner, $championId)
    {
        $query = $this->createQueryBuilder('cm')
            ->where('cm.summoner = :summoner')->andWhere('cm.championId = :championId')
            ->setParameter('summoner', $summoner)
            ->setParameter('championId', $championId)
            ->getQuery();
        $result = $query->getOneOrNullResult();
        if ($result == null) {
            $points = 0;
        } else {
            $points = $result->getChampionPoints();
        }
        return $points;
    }

    public function findPointsBySummonerAndChampionIds($summoner, $championIds)
    {
        $query = $this->createQueryBuilder('cm')
            ->where('cm.summoner = :summoner')->andWhere('cm.championId IN (:championIds)')
            ->setParameter('summoner', $summoner)
            ->setParameter('championIds', $championIds)
            ->getQuery();
        $result = $query->getResult();
        $points = array();
        if ($result != null) {
            foreach ($result as $champ) {
                $points[$champ->getChampionId()] = $champ->getChampionPoints();
            }
        }
        return $points;
    }
}
