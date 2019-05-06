<?php

namespace App\Repository;

use App\Entity\Filiere;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Filiere|null find($id, $lockMode = null, $lockVersion = null)
 * @method Filiere|null findOneBy(array $criteria, array $orderBy = null)
 * @method Filiere[]    findAll()
 * @method Filiere[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FiliereRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Filiere::class);
    }

    public function deleteFiliere($id)
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager
            ->createQuery('DELETE App\Entity\Filiere v WHERE v.id = :id')
            ->setParameter('id', $id)
            ->execute();
    }

    public function findAllFilieresSortedByAlphabetOrder()
    {
        $qb = $this->createQueryBuilder('f')
            ->orderBy('f.title', 'ASC')
            ->getQuery();

        return $qb->execute();
    }

    public function findAllLinksDispositifsSpeciaux()
    {
        $qb = $this->createQueryBuilder('f')
            ->select('f.title, f.id')
            ->where("f.category = 'Dispositifs' ")
            ->orderBy('f.title', 'ASC')
            ->getQuery();

        return $qb->execute();
    }


}
