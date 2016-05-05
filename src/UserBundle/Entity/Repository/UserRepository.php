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
    public function generateOpponentsQuery($user, $filters = null, $limit = null)
    {

        $queryBuilder = $this->createQueryBuilder('u')
            ->where('u.id <> :userId')
            ->andWhere('u.summoner is not null')
            ->setParameter('userId', $user->getId())
            ->orderBy('u.lastMasteryUpdate', 'DESC');

        if (is_array($filters)) {
            if (array_key_exists('nameFilter', $filters) && $filters['nameFilter'] != null) {
                $queryBuilder
                    ->innerJoin('u.summoner', 'summoner')
                    ->andWhere('summoner.name like :nameFilter OR u.username like :nameFilter')
                    ->setParameter('nameFilter', '%'.$filters['nameFilter'].'%');
            }
            if (array_key_exists('region', $filters) && $filters['region'] != null && $filters['region'] != 'any') {
                $queryBuilder->andWhere('u.region = :region')
                    ->setParameter('region', $filters['region']);
            }
        }
        $query = $queryBuilder->getQuery();
        if ($limit != null) {
            $query->setMaxResults($limit);
        }
        return $query;
    }

}
