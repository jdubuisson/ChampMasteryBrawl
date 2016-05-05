<?php

namespace UserBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * UserRepository
 *
 *
 */
class UserRepository extends EntityRepository
{
    public function generateOpponentsQuery($user, $limit = null)
    {
        $query = $query = $this->createQueryBuilder('u')
            ->where('u.id <> :userId')
            ->andWhere('u.summoner is not null')
            ->setParameter('userId', $user->getId())
            ->orderBy('u.lastMasteryUpdate', 'DESC')->getQuery();
        if ($limit != null) {
            $query->setMaxResults($limit);
        }
        return $query;
    }

}
