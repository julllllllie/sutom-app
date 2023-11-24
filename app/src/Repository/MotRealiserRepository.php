<?php

namespace App\Repository;

use App\Entity\MotRealiser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<MotRealiser>
 *
 * @method MotRealiser|null find($id, $lockMode = null, $lockVersion = null)
 * @method MotRealiser|null findOneBy(array $criteria, array $orderBy = null)
 * @method MotRealiser[]    findAll()
 * @method MotRealiser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MotRealiserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MotRealiser::class);
    }

//    /**
//     * @return MotRealiser[] Returns an array of MotRealiser objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('m.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?MotRealiser
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
