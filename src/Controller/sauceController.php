<?php
namespace App\Controller;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of sauceController
 *
 * @author thierry28220
 */

use App\Entity\Categories;
use App\Entity\Restaurant;
use App\Entity\User;
use App\Entity\Etrepresent;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Attribute\AttributeBag;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\NativeSessionStorage;
use Symfony\Component\Routing\Annotation\Route;

use App\Form\IndexType;
use Doctrine\Common\Persistence\ObjectManager;


class sauceController extends Controller {
    
    /**
     * @Route("/", name="accueil")
     * @return Response
     */
   
     public function indexAction( Request $request, ObjectManager $manager)
    {
    
       $form = $this->createForm(IndexType::class);
       
       $form->handleRequest($request);
       
       
       
       if($form->isSubmitted()&& $form->isValid())
       {
           $ville= $this->getDoctrine()->getRepository(Restaurant::class)->getVille($request->request->get('index')['rest']);
       
           return $this->redirectToRoute('detailRecherchesl2', array('categorie'=>$request->request->get('index')['cat'],'ville'=>$ville ['0']['ville'] ));
       }
        return $this->render('sauce/index.html.twig', ['form' => $form->createView()]);
    }
    
    /**
     * @Route("/detailRecherche/{categorie}", name="detailRecherche")
     * @return Response
     */
    public function detailRechercheAction($categorie)
    {
      $session = new Session(new NativeSessionStorage(), new AttributeBag());  
     if(!$this->getUser()) return $this->redirectToRoute('accueil'); 
     if ($session->get("loc")== 'non')
     {
         return $this->redirectToRoute('detailRecherchesl', array('categorie'=>$categorie));
     
     }
    $restaurant= $this->getDoctrine()->getRepository(Restaurant::class)->getRestaurantsParCategorie($categorie)
        ;
 
         return $this->render('sauce/detailRecherche.html.twig', array('restaurants'=>$restaurant) );
    }
    
        /**
     * @Route("/detailRecherchesl/{categorie}", name="detailRecherchesl")
     * @return Response
     */
    public function detailRechercheslAction($categorie)
    {
        
     if(!$this->getUser()) return $this->redirectToRoute('accueil'); 
     
    $restaurant= $this->getDoctrine()->getRepository(Restaurant::class)->getRestaurantsParCategoriesl($categorie)
        ;
 
         return $this->render('sauce/detailRecherchesl.html.twig', array('restaurants'=>$restaurant) );
    }
    
      /**
     * @Route("/detailRecherchesl2/{categorie}/{ville}", name="detailRecherchesl2")
     * @return Response
     */
    public function detailRecherchesl2Action($categorie,$ville)
    {
        
    
     
    $restaurant= $this->getDoctrine()->getRepository(Restaurant::class)->getRestaurantsParCategoriesl2($categorie,$ville)
        ;
 
         return $this->render('sauce/detailRecherchesl2.html.twig', array('restaurants'=>$restaurant) );
    }
    
     /**
     * @Route("/jyvais/{id}", name="jyvais")
     * @return Response
     */
    public function JyvaisAction($id)
    {
    if(!$this->getUser()) return $this->redirectToRoute('accueil');
    $entityManager = $this->getDoctrine()->getManager();   
    
    $restaurant= $this->getDoctrine()->getRepository(Restaurant::class)->find($id);
    $user= $this->getUser();
   
    $Etrepresent = new Etrepresent();
    
    $Etrepresent->setDatepresence((new \DateTime('now')));
    $Etrepresent->setHeuredebut(new \DateTime('now'));
    $Etrepresent->setHeurefin(new \DateTime('now'));
    $Etrepresent->setRestaurant($restaurant);
    $Etrepresent->setUser($user);
    $entityManager->persist($Etrepresent);
    $entityManager->flush();
    
    
   
    $compteur= $this->getDoctrine()->getRepository(User::class)->decompteQuotidien( $user->getId());
   $tot = 0; 
   foreach($compteur as $lecompteur)
   { 
       $tot =$lecompteur['t'];
   }  
    if( $tot  <3)
    {
    $points = $user->getPoints();
    $points +=20;
    $user->setPoints($points);
    
    $grade = $user->getGrade();
    
    if ($points>1000)
    {
        $user->SetGrade('Samourai');
    }
    elseif($points>750)
    {
        $user->SetGrade('Mayonnaise');
    }
    elseif($points>500)
    {
        $user->SetGrade('Ketchup');
    }
    elseif($points>200)
    {
        $user->SetGrade('Tartare');
    }
    else 
     {
        $user->SetGrade('Moutarde');
    }
    
    $lieux = $user->getLieux();
    $lieux +=1;
    $user->SetLieux($lieux);
    
    
    $entityManager->persist($user);
    $entityManager->flush();
    
    return $this->render('sauce/jyvaisavecpoints.html.twig', array('restaurant'=>$restaurant));
    }
    else
    {
    return $this->render('sauce/jyvaissanspoint.html.twig', array('restaurant'=>$restaurant));   
    }

    }

    /**
     * @Route("/recherche", name="recherche")
     * @Route("/recherche/{lat}/{long}", name="rechercheliste")
     * @return Response
     */
    public function rechercheAction( $lat = null, $long = null)
    {
        if(!$this->getUser()) return $this->redirectToRoute('accueil');
     $session = new Session(new NativeSessionStorage(), new AttributeBag());
     if(!$session->has('lat'))
     {
     $session->set('lat',$lat); 
     $session->set('long',$long); 
     }
     $categories= $this->getDoctrine()->getRepository(Categories::class)->findAll();
        return $this->render('sauce/recherche.html.twig', array('categories'=>$categories) );
    }
    
    /**
     * @Route("/carte", name="carte")
     * @return Response
     */
    public function carteAction()
    {
        $session = new Session(new NativeSessionStorage(), new AttributeBag());  
     if(!$this->getUser()) return $this->redirectToRoute('accueil'); 
     if ($session->get("loc")== 'non')
     {
         return $this->redirectToRoute('listesl');
     
     }
        $restaurant= $this->getDoctrine()->getRepository(Restaurant::class)->findAll();
        return $this->render('sauce/carte.html.twig', array('restaurants'=>$restaurant) );          
    }
    
        /**
     * @Route("/itineraire/{id}", name="itineraire")
     * @return Response
     */
    public function itineraireAction($id)
    {
        $session = new Session(new NativeSessionStorage(), new AttributeBag());
        if(!$this->getUser()) return $this->redirectToRoute('accueil');
        if ($session->get("loc")== 'non')
     {
         return $this->redirectToRoute('listesl');
     
     }
        $restaurant= $this->getDoctrine()->getRepository(Restaurant::class)->find($id);
        return $this->render('sauce/itineraire.html.twig', array('restaurant'=>$restaurant));          
    }
    
        /**
     * @Route("/listesl", name="listesl")
     * @return Response
     */
    public function listeslAction()
    {
        if(!$this->getUser()) return $this->redirectToRoute('accueil');
        
        if($this->getUser()->getCustomerStripe()  == '-') return $this->redirectToRoute('phasepaiement', array('id'=>$this->getUser()->getId()));
        
        
        $session = new Session(new NativeSessionStorage(), new AttributeBag());
        $session->set('loc','non'); 
         
        $restaurants= $this->getDoctrine()->getRepository(Restaurant::class)->findAllRestaurantsSansPosition();

        return $this->render('sauce/listesl.html.twig', array('restaurants'=>$restaurants));
    }
    
    /**
     * @Route("/liste/{lat}/{long}", name="liste")
     * @return Response
     */
    public function listeAction($lat,$long)
    {
        if(!$this->getUser()) return $this->redirectToRoute('accueil');
        
        if($this->getUser()->getCustomerStripe()  == '-') return $this->redirectToRoute('phasepaiement', array('id'=>$this->getUser()->getId()));
        
        
        $session = new Session(new NativeSessionStorage(), new AttributeBag());
        $session->set('lat',$lat); 
        $session->set('long',$long);  
        $session->set('loc','oui');
        $restaurants= $this->getDoctrine()->getRepository(Restaurant::class)->findAllRestaurantsAutourPosition($lat,$long);

        return $this->render('sauce/liste.html.twig', array('restaurants'=>$restaurants));
    }
    
        /**
     * @Route("/details/{id}", name="details")
     * @return Response
     */
    public function detailsAction($id)
    {
        if(!$this->getUser()) return $this->redirectToRoute('accueil');
        $restaurant= $this->getDoctrine()->getRepository(Restaurant::class)->find($id);
        return $this->render('sauce/details.html.twig', array('restaurant'=>$restaurant) );
    
    }
    
            /**
     * @Route("/ensavoirplus", name="ensavoirplus")
     * @return Response
     */
    public function ensavoirplus()
    {
        
        return $this->render('sauce/ensavoirplus.html.twig');
    
    }
    
        /**
     * @Route("/profil/{id}", name="profil")
     * @return Response
     */
    public function profilAction($id)
    {
        
        if(!$this->getUser()) return $this->redirectToRoute('accueil');
        $user = $this->getUser();
        if ($user->getId() != $id)
        {$user = 'non';}
        else {$user = 'oui';}
        
       
        $profil= $this->getDoctrine()->getRepository(User::class)->find($id);
        return $this->render('sauce/profil.html.twig', array('profil'=>$profil,'user'=>$user) );
    
    }
    
         /**
     * @Route("/ajaxhiddenrestaurant", name="ajaxhiddenrestaurant")
     * @return Response
     */
    public function ajaxhiddenrestaurantAction()
    {  
      $jsonData = array();  
      return new JsonResponse($jsonData);   
    }
    
     /**
     * @Route("/ajaxrestaurant", name="ajaxrestaurant")
     * @return Response
     */
    public function ajaxrestaurantAction(Request $req)
    { 
        $lon = $req->request->get('lon');
        $lat = $req->request->get('lat');
         
        $restaurants= $this->getDoctrine()->getRepository(Restaurant::class)->findAllRestaurantsAutourPosition($lat,$lon);
      
        $jsonData = array();  
        $idx = 0;  
        foreach($restaurants as $restaurant) {  
            $temp = array(
                'id' => $restaurant->getId(),
            'raisonsociale' => $restaurant->getRaisonsociale(),
             'image' => $restaurant->getImage()
        );
        $jsonData[$idx++] = $temp;  
        } 
        return new JsonResponse($jsonData);     
    }   
    
    
                 /**
     * @Route("/versliste", name="versliste")
     * @return Response
     */
    public function versliste()
    { 
        return $this->render('sauce/versliste.html.twig');
    }
    
                /**
     * @Route("/cgu", name="cgu")
     * @return Response
     */
    public function cgu()
    {
        
        return $this->render('sauce/cgu.html.twig');
    
    }
    
                    /**
     * @Route("/cgv", name="cgv")
     * @return Response
     */
    public function cgv()
    {
        
        return $this->render('sauce/cgv.html.twig');
    
    }
    
                    /**
     * @Route("/ml", name="ml")
     * @return Response
     */
    public function ml()
    {
        
        return $this->render('sauce/ml.html.twig');
    
    }
}
