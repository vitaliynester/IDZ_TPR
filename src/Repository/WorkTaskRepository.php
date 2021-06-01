<?php

namespace App\Repository;

use App\Entity\WorkTask;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method WorkTask|null find($id, $lockMode = null, $lockVersion = null)
 * @method WorkTask|null findOneBy(array $criteria, array $orderBy = null)
 * @method WorkTask[]    findAll()
 * @method WorkTask[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WorkTaskRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, WorkTask::class);
    }

    /**
    * @return WorkTask[] Returns an array of WorkTask objects
    */
    public function findAllUncompleted()
    {
        return $this->createQueryBuilder('w')
            ->Where('w.status != :status')
            ->setParameter('status', 1)
            ->getQuery()
            ->getResult()
        ;
    }

    /*
    public function findOneBySomeField($value): ?WorkTask
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
