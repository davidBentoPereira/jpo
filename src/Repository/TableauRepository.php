<?php

namespace App\Repository;

use App\Entity\Tableau;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Tableau|null find($id, $lockMode = null, $lockVersion = null)
 * @method Tableau|null findOneBy(array $criteria, array $orderBy = null)
 * @method Tableau[]    findAll()
 * @method Tableau[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TableauRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Tableau::class);
    }

    public function findAllLinesInTableSortedByAlphabetOrder()
    {
        $qb = $this->createQueryBuilder('t')
            ->orderBy('t.diplome', 'ASC')
            ->getQuery();
        return $qb->execute();
    }

    public function deleteLigneTableau($id)
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager
            ->createQuery('DELETE App\Entity\Tableau t WHERE t.id = :id')
            ->setParameter('id', $id)
            ->execute();
    }
}
