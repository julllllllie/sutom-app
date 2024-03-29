<?php

namespace App\Repository;

use App\Entity\Mots;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Mots>
 *
 * @method Mots|null find($id, $lockMode = null, $lockVersion = null)
 * @method Mots|null findOneBy(array $criteria, array $orderBy = null)
 * @method Mots[]    findAll()
 * @method Mots[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MotsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Mots::class);
    }

//    /**
//     * @return Mots[] Returns an array of Mots objects
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

//    public function findOneBySomeField($value): ?Mots
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
