<?php

namespace App\Repository;

use App\Entity\EssaiMot;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<EssaiMot>
 *
 * @method EssaiMot|null find($id, $lockMode = null, $lockVersion = null)
 * @method EssaiMot|null findOneBy(array $criteria, array $orderBy = null)
 * @method EssaiMot[]    findAll()
 * @method EssaiMot[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EssaiMotRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EssaiMot::class);
    }

//    /**
//     * @return EssaiMot[] Returns an array of EssaiMot objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('e.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?EssaiMot
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
