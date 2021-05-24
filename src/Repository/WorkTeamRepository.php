<?php

namespace App\Repository;

use App\Entity\WorkTeam;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method WorkTeam|null find($id, $lockMode = null, $lockVersion = null)
 * @method WorkTeam|null findOneBy(array $criteria, array $orderBy = null)
 * @method WorkTeam[]    findAll()
 * @method WorkTeam[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WorkTeamRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, WorkTeam::class);
    }

    // /**
    //  * @return WorkTeam[] Returns an array of WorkTeam objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('w.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?WorkTeam
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
