<?php

namespace AppBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * BrawlRepository
 *
 *
 */
class BrawlRepository extends EntityRepository
{
    public function findLastWonBrawlDate($attacker, $defender)
    {
        $query = $this->createQueryBuilder('brawl')
            ->select('brawl.date')
            ->where('brawl.attacker = :attacker')
            ->andWhere('brawl.defender = :defender')
            ->andWhere("brawl.victoriousUser = 'attacker'")
            ->setParameter('attacker', $attacker)
            ->setParameter('defender', $defender)
            ->orderBy('brawl.date', 'DESC')->getQuery();

        return $query->setMaxResults(1)->getOneOrNullResult();
    }

    public function generateAssaultsQuery($user, $limit = null)
    {
        $query = $this->getAssaultsQueryBuilder($user)
            ->orderBy('brawl.date', 'DESC')->getQuery();
        if ($limit != null) {
            $query->setMaxResults($limit);
        }
        return $query;
    }

    public function generateDefensesQuery($user, $limit = null)
    {
        $query = $this->getDefensesQueryBuilder($user)
            ->orderBy('brawl.date', 'DESC')->getQuery();
        if ($limit != null) {
            $query->setMaxResults($limit);
        }
        return $query;
    }

    public function getStatsForUser($user)
    {
        $results = array();
        $query = $this->getAssaultsQueryBuilder($user)->select('count(brawl.id)')->getQuery();
        $results['totalAssaults'] = $query->getSingleScalarResult();
        $query = $this->getAssaultsQueryBuilder($user)->andWhere("brawl.victoriousUser = 'attacker'")->select('count(brawl.id)')->getQuery();
        $results['successfulAssaults'] = $query->getSingleScalarResult();
        $query = $this->getDefensesQueryBuilder($user)->select('count(brawl.id)')->getQuery();
        $results['totalDefenses'] = $query->getSingleScalarResult();
        $query = $this->getDefensesQueryBuilder($user)->andWhere("brawl.victoriousUser != 'attacker'")->select('count(brawl.id)')->getQuery();
        $results['successfulDefenses'] = $query->getSingleScalarResult();

        return $results;
    }

    private function getAssaultsQueryBuilder($user)
    {
        return $query = $this->createQueryBuilder('brawl')
            ->where('brawl.attacker = :user')
            ->setParameter('user', $user);
    }

    private function getDefensesQueryBuilder($user)
    {
        return $query = $this->createQueryBuilder('brawl')
            ->where('brawl.defender = :user')
            ->setParameter('user', $user);
    }
}
