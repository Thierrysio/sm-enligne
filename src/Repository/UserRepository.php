<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, User::class);
    }
    
     /** 
     * @return User[] Returns an array of Restaurant objects
     */
    public function decompteQuotidien($user)
    {
        
        $date = new \DateTime('now');
        $stringdate = $date->format('Y-m-d');
        
        $qb = $this->createQueryBuilder('u')
            ->innerJoin('u.etrepresents','e')
            ->addSelect('e')  
            ->andWhere('u.id=:user')
            ->andWhere('e.datepresence=:la')
            ->setParameter('user', $user)
            ->setParameter('la',$stringdate)
                
            ->select('count(e) AS t')
            ->getQuery();

        return $qb->execute();
    }
    
     /** 
     * @return User[] Returns an array of User objects
     */
    public function villesvisitees($id): array
    {
        
       $qb = $this->createQueryBuilder('u')
            ->getQuery();

        return $qb->execute();
    }
    
     /** 
     * @return User[] Returns an array of User objects
     */
    public function villespreferees($id): array
    {
        
       $qb = $this->createQueryBuilder('u')
            ->getQuery();

        return $qb->execute();
    }
    
     /** 
     * @return User[] Returns an array of User objects
     */
    public function tauxutilisation($id): array
    {
        
       $qb = $this->createQueryBuilder('u')
            ->getQuery();

        return $qb->execute();
    }

//    /**
//     * @return User[] Returns an array of User objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?User
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
