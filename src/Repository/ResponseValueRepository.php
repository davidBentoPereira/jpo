<?php

namespace App\Repository;

use App\Entity\ResponseValue;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ResponseValue|null find($id, $lockMode = null, $lockVersion = null)
 * @method ResponseValue|null findOneBy(array $criteria, array $orderBy = null)
 * @method ResponseValue[]    findAll()
 * @method ResponseValue[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ResponseValueRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ResponseValue::class);
    }

    // /**
    //  * @return ResponseValue[] Returns an array of ResponseValue objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ResponseValue
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
