<?php

namespace App\Repository;

use App\Entity\Etrepresent;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Etrepresent|null find($id, $lockMode = null, $lockVersion = null)
 * @method Etrepresent|null findOneBy(array $criteria, array $orderBy = null)
 * @method Etrepresent[]    findAll()
 * @method Etrepresent[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EtrepresentRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Etrepresent::class);
    }

//    /**
//     * @return Etrepresent[] Returns an array of Etrepresent objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Etrepresent
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
