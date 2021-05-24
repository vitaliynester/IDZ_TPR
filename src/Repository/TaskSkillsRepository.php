<?php

namespace App\Repository;

use App\Entity\TaskSkills;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TaskSkills|null find($id, $lockMode = null, $lockVersion = null)
 * @method TaskSkills|null findOneBy(array $criteria, array $orderBy = null)
 * @method TaskSkills[]    findAll()
 * @method TaskSkills[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TaskSkillsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TaskSkills::class);
    }

    // /**
    //  * @return TaskSkills[] Returns an array of TaskSkills objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TaskSkills
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
