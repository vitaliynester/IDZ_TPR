<?php

namespace App\Repository;

use App\Entity\WorkObject;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method WorkObject|null find($id, $lockMode = null, $lockVersion = null)
 * @method WorkObject|null findOneBy(array $criteria, array $orderBy = null)
 * @method WorkObject[]    findAll()
 * @method WorkObject[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WorkObjectRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, WorkObject::class);
    }

    // /**
    //  * @return WorkObject[] Returns an array of WorkObject objects
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
    public function findOneBySomeField($value): ?WorkObject
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
