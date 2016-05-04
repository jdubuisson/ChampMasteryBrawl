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
    public function generateAssaultsQuery($user, $limit = null)
    {
        $query = $this->createQueryBuilder('brawl')
            ->where('brawl.attacker = :user')
            ->setParameter('user', $user)
            ->orderBy('brawl.date', 'DESC')->getQuery();
        if ($limit != null) {
            $query->setMaxResults($limit);
        }
        return $query;
    }
    public function generateDefensesQuery($user, $limit = null)
    {
        $query = $this->createQueryBuilder('brawl')
            ->where('brawl.defender = :user')
            ->setParameter('user', $user)
            ->orderBy('brawl.date', 'DESC')->getQuery();
        if ($limit != null) {
            $query->setMaxResults($limit);
        }
        return $query;
    }
}
