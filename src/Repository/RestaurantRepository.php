<?php

namespace App\Repository;

use App\Entity\Restaurant;
use App\Entity\Categories;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

use Symfony\Component\HttpFoundation\Session\Attribute\AttributeBag;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\NativeSessionStorage;
use function dump;

/**
 * @method Restaurant|null find($id, $lockMode = null, $lockVersion = null)
 * @method Restaurant|null findOneBy(array $criteria, array $orderBy = null)
 * @method Restaurant[]    findAll()
 * @method Restaurant[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RestaurantRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Restaurant::class);
    }
    
     /** 
     * @return Restaurant[] Returns an array of Restaurant objects
     */
    public function findAllRestaurantsAutourPosition($latitude,$longitude): array
    {
        
       $qb = $this->createQueryBuilder('p')
            ->andWhere('distance(p.latitude,:latitude,p.latitude,:latitude,p.longitude,:longitude ) < 1000' )
            ->orderBy('distance(p.latitude,:latitude,p.latitude,:latitude,p.longitude,:longitude )', 'ASC')
            ->setParameter('latitude', $latitude)
            ->setParameter('longitude', $longitude)
            ->addselect('distance(p.latitude,:latitude,p.latitude,:latitude,p.longitude,:longitude )AS gps')
            ->getQuery();

        return $qb->execute();
    }
    
         /** 
     * @return Restaurant[] Returns an array of Restaurant objects
     */
    public function findAllRestaurantsSansPosition(): array
    {
        
       $qb = $this->createQueryBuilder('p')
            ->andWhere('distance(p.latitude,:latitude,p.latitude,:latitude,p.longitude,:longitude ) < 100000' )
            ->orderBy('p.ville', 'ASC')
            ->setParameter('latitude', 0)
            ->setParameter('longitude', 0)
            ->addselect('distance(p.latitude,:latitude,p.latitude,:latitude,p.longitude,:longitude )AS gps')
            ->getQuery();

        return $qb->execute();
    }
    
     /** 
     * @return Restaurant[] Returns an array of Restaurant objects
     */
    public function getRestaurantsParCategorie($categorie)
    {
        $session = new Session(new NativeSessionStorage(), new AttributeBag()); 
        
        $qb = $this->createQueryBuilder('p')
              ->innerJoin('p.categorie','c')
            ->addSelect('c')
            ->andWhere('distance(p.latitude,:latitude,p.latitude,:latitude,p.longitude,:longitude ) < 1000' )
            ->andWhere('c.id=:categorie')
            ->orderBy('distance(p.latitude,:latitude,p.latitude,:latitude,p.longitude,:longitude )', 'ASC')
            ->setParameter('latitude', $session->get('lat'))
            ->setParameter('longitude', $session->get('long'))
            ->setParameter('categorie', $categorie)
            ->addselect('distance(p.latitude,:latitude,p.latitude,:latitude,p.longitude,:longitude )AS gps')
            ->getQuery();

        return $qb->execute();
    }
    
         /** 
     * @return Restaurant[] Returns an array of Restaurant objects
     */
    public function getRestaurantsParCategoriesl($categorie)
    {
        $session = new Session(new NativeSessionStorage(), new AttributeBag()); 
        
        $qb = $this->createQueryBuilder('p')
              ->innerJoin('p.categorie','c')
            ->addSelect('c')
            ->andWhere('distance(p.latitude,:latitude,p.latitude,:latitude,p.longitude,:longitude ) < 1000000' )
            ->andWhere('c.id=:categorie')
            ->orderBy('p.ville', 'ASC')
            ->setParameter('latitude', 0)
            ->setParameter('longitude', 0)
            ->setParameter('categorie', $categorie)
            ->addselect('distance(p.latitude,:latitude,p.latitude,:latitude,p.longitude,:longitude )AS gps')
            ->getQuery();

        return $qb->execute();
    }
    
         /** 
     * @return Restaurant[] Returns an array of Restaurant objects
     */
    public function getRestaurantsParCategoriesl2($categorie,$ville)
    {
        $session = new Session(new NativeSessionStorage(), new AttributeBag()); 
        
        $qb = $this->createQueryBuilder('p')
              ->innerJoin('p.categorie','c')
            ->addSelect('c')
            ->andWhere('distance(p.latitude,:latitude,p.latitude,:latitude,p.longitude,:longitude ) < 1000000' )
            ->andWhere('c.id=:categorie')
            ->andWhere('p.ville=:ville')
            ->orderBy('p.ville', 'ASC')
            ->setParameter('latitude', 0)
            ->setParameter('longitude', 0)
            ->setParameter('categorie', $categorie)
            ->setParameter('ville', $ville)
            ->addselect('distance(p.latitude,:latitude,p.latitude,:latitude,p.longitude,:longitude )AS gps')
            ->getQuery();

        return $qb->execute();
    }
    
     /** 
     * @return Restaurant[] Returns an array of Restaurant objects
     */
    public function trouvehoraires($restaurant)
    {
        $qb = $this->createQueryBuilder('r')
            ->innerJoin('r.collouvrir','o')
            ->addSelect('o')
            ->innerJoin('o.id_jour','j')
            ->addSelect('j')    
            ->andWhere('r.id=:restaurant')
            ->setParameter('restaurant', $restaurant)
            ->select('o.id, j.jour, o.heure_debut,o.heure_fin')
            ->getQuery();

        return $qb->execute();
    }
    
     /** 
     * @return Restaurant[] Returns an array of Restaurant objects
     */
    public function trouvedescription($restaurant)
    {
        $qb = $this->createQueryBuilder('r')
            ->innerJoin('r.colldescription','d')
            ->addSelect('d')  
            ->andWhere('r.id=:restaurant')
            ->setParameter('restaurant', $restaurant)
            ->select('d.id, d.libelle')
            ->getQuery();

        return $qb->execute();
    }
    
     /** 
     * @return Restaurant[] Returns an array of Restaurant objects
     */
    public function getVille($restaurant)
    {
        $qb = $this->createQueryBuilder('r')
             
            ->andWhere('r.id=:restaurant')
            ->setParameter('restaurant', $restaurant)
            ->select('r.ville')
            ->getQuery();

        return $qb->execute();
    }
    
    

//    /**
//     * @return Restaurant[] Returns an array of Restaurant objects
//     */
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

     
     
}
