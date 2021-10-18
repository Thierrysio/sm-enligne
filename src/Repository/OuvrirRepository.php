<?php

namespace App\Repository;

use App\Entity\Ouvrir;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Ouvrir|null find($id, $lockMode = null, $lockVersion = null)
 * @method Ouvrir|null findOneBy(array $criteria, array $orderBy = null)
 * @method Ouvrir[]    findAll()
 * @method Ouvrir[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OuvrirRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Ouvrir::class);
    }

//    /**
//     * @return Ouvrir[] Returns an array of Ouvrir objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Ouvrir
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
