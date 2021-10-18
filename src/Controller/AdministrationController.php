<?php

namespace App\Controller;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\User;
use App\Entity\Restaurant;
use App\Entity\Categories;
use App\Entity\Description;
use App\Entity\Etrepresent;
use App\Entity\Jours;
use App\Entity\Ouvrir;
use App\Form\AjoutSalarieType;
use App\Form\JoursType;
use App\Form\OuvrirType;
use App\Form\DescriptionType;
use App\Form\RestaurantType;
use App\Form\EtrepresentType;
use App\Form\CategoriesType;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdministrationController extends AbstractController
{
             /**
     * @Route("/gestionEtrepresent/{id}/edit", name="gestionEtrepresent")
     */
    public function formEtrepresent(Etrepresent $Etrepresent=null, Request $request, ObjectManager $manager)
    {
    if (!$Etrepresent){
        $Etrepresent = new Etrepresent;
    }
       $form = $this->createForm(EtrepresentType::class,$Etrepresent);
       
       $form->handleRequest($request);
       
       if($form->isSubmitted()&& $form->isValid())
       {
          $manager->persist($Etrepresent);
          $manager->flush();
           
           return $this->redirectToRoute('tbsaucemoutard');
       }
        return $this->render('administration/formEtrepresent.html.twig', ['form' => $form->createView(),
            'editmode'=>$Etrepresent->getId() !== null]);
    }
         /**
     * @Route("/gestionOuvrir/{id}/edit", name="gestionOuvrir")
     */
    public function formOuvrir(Ouvrir $ouvrir=null, Request $request, ObjectManager $manager)
    {
    if (!$ouvrir){
        $ouvrir = new Ouvrir;
    }
       $form = $this->createForm(OuvrirType::class,$ouvrir);
       
       $form->handleRequest($request);
       
       if($form->isSubmitted()&& $form->isValid())
       {
          $manager->persist($ouvrir);
          $manager->flush();
           
           return $this->redirectToRoute('tbsaucemoutard');
       }
        return $this->render('administration/formOuvrir.html.twig', ['form' => $form->createView(),
            'editmode'=>$ouvrir->getId() !== null]);
    }
    
    /**
     * @Route("/removeOuvrir/{id}", name="removeOuvrir")
     */
    public function removeOuvrir($id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $ouvrir = $entityManager->getRepository(Ouvrir::class)->find($id);
        $entityManager->remove($ouvrir);
        $entityManager->flush();
        return $this->redirectToRoute('tbsaucemoutard');

    }
     /**
     * @Route("/gestionJours/{id}/edit", name="gestionJours")
     */
    public function formJours(Jours $jours=null, Request $request, ObjectManager $manager)
    {
    if (!$jours){
        $jours = new Jours;
    }
       $form = $this->createForm(JoursType::class,$jours);
       
       $form->handleRequest($request);
       
       if($form->isSubmitted()&& $form->isValid())
       {
          $manager->persist($jours);
          $manager->flush();
           
           return $this->redirectToRoute('tbsaucemoutard');
       }
        return $this->render('administration/formJours.html.twig', ['form' => $form->createView(),
            'editmode'=>$jours->getId() !== null]);
    }
    /**
     * @Route("/gestionDescription/{id}/edit", name="gestionDescription")
     */
    public function formDescription(Description $description=null, Request $request, ObjectManager $manager)
    {
    if (!$description){
        $description = new Description;
    }
       $form = $this->createForm(DescriptionType::class,$description);
       
       $form->handleRequest($request);
       
       if($form->isSubmitted()&& $form->isValid())
       {
          $manager->persist($description);
          $manager->flush();
           
           return $this->redirectToRoute('tbsaucemoutard');
       }
        return $this->render('administration/formDescription.html.twig', ['form' => $form->createView(),
            'editmode'=>$description->getId() !== null]);
    }
    
        /**
     * @Route("/removeDescription/{id}", name="removeDescription")
     */
    public function removeDescription($id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $description = $entityManager->getRepository(Description::class)->find($id);
        $entityManager->remove($description);
        $entityManager->flush();
        return $this->redirectToRoute('tbsaucemoutard');

    }
    
    /**
     * @Route("/gestionRestaurants/{id}/edit", name="gestionRestaurants")
     */
    public function formRestaurant(Restaurant $restaurant=null, Request $request, ObjectManager $manager)
    {
    if (!$restaurant){
        $restaurant = new Restaurant;
    }
       $form = $this->createForm(RestaurantType::class,$restaurant);
       
       $form->handleRequest($request);
       
       if($form->isSubmitted()&& $form->isValid())
       {
          $manager->persist($restaurant);
          $manager->flush();
           
           return $this->redirectToRoute('tbsaucemoutard');
       }
        return $this->render('administration/formRestaurant.html.twig', ['form' => $form->createView(),
            'editmode'=>$restaurant->getId() !== null]);
    }
    
    /**
     * @Route("/gestionCategories/{id}/edit", name="gestionCategories")
     */
    public function formCategories(Categories $categorie=null, Request $request, ObjectManager $manager)
    {
    if (!$categorie){
        $categorie = new Categories;
    }
       $form = $this->createForm(CategoriesType::class,$categorie);
       
       $form->handleRequest($request);
       
       if($form->isSubmitted()&& $form->isValid())
       {
          $manager->persist($categorie);
          $manager->flush();
           
           return $this->redirectToRoute('tbsaucemoutard');
       }
        return $this->render('administration/formCategories.html.twig', ['form' => $form->createView(),
            'editmode'=>$categorie->getId() !== null]);
    }
    
    /**
     * @Route("/removeCategories/{id}", name="removeCategories")
     */
    public function removeCategories($id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $categorie = $entityManager->getRepository(Categories::class)->find($id);
        $entityManager->remove($categorie);
        $entityManager->flush();
        return $this->redirectToRoute('tbsaucemoutard');

    }
     /**
     * @Route("/tbsaucemoutard", name="tbsaucemoutard")
     */
    public function tableauAction()
    {

     if($this->getUser()->getStatut()!= 'admin' )
     {
         return $this->redirectToRoute('security_login');
     }
     
        return $this->render('administration/tableau.html.twig');
    }
    
     /**
     * @Route("/tbentreprisesaucemoutard1", name="tbentreprisesaucemoutard1")
     */
    public function tableauentreprise1Action()
    {

     if(($this->getUser()->getStatut()!= 'admin')&&($this->getUser()->getStatut()!= 'entreprise') )
     {
         return $this->redirectToRoute('security_login');
     }
     
     $villesvisitees = $this->getDoctrine()->getRepository(User::class)->villesvisitees($this->getUser()->getEntreprise()->getId());
     $villespreferees = $this->getDoctrine()->getRepository(User::class)->villespreferees($this->getUser()->getEntreprise()->getId());
     $tauxutilisation = $this->getDoctrine()->getRepository(User::class)->tauxutilisation($this->getUser()->getEntreprise()->getId());
        
        return $this->render('administration/tableauentreprise1.html.twig' , array('id'=>$this->getUser()->getEntreprise()));
    }
    
         /**
     * @Route("/tbentreprisesaucemoutard2", name="tbentreprisesaucemoutard2")
     */
    public function tableauentreprise2Action()
    {

     if(($this->getUser()->getStatut()!= 'admin')&&($this->getUser()->getStatut()!= 'entreprise') )
     {
         return $this->redirectToRoute('security_login');
     }
        
        return $this->render('administration/tableauentreprise2.html.twig' , array('id'=>$this->getUser()->getEntreprise()));
    }
    
         /**
     * @Route("/tbentreprisesaucemoutard3", name="tbentreprisesaucemoutard3")
     */
    public function tableauentreprise3Action(User $user=null,Request $request, ObjectManager $manager, UserPasswordEncoderInterface $encoder)
    {

     if(($this->getUser()->getStatut()!= 'admin')&&($this->getUser()->getStatut()!= 'entreprise') )
     {
         return $this->redirectToRoute('security_login');
     }
        
      if (!$user){
       $user = new User;
       $form = $this->createForm(AjoutSalarieType::class,$user);
       
       $form->handleRequest($request);

       if($form->isSubmitted()&& $form->isValid())
       {
           $user->setPhoto('photo05.png');
           $user->setPoints('0');
           $user->setLieux('0');
           $user->setGrade('Sauce Moutarde');
           $user->setNepasderanger('0');
           $user->setCustomerStripe('test');
           $user->setLinkedin('-');
           $user->setInstagram('-');
           $user->setTwitter('-');
           $user->setFacebook('-');
           $user->setCodepromo('-');
           $user->setDateDebutAbonnement((new DateTime('now')));
           $hash = $encoder->encodePassword($user, $user->getPassword());
           $user->setPassword($hash);
           $manager->persist($user);
           $manager->flush();
           
             
           return $this->redirectToRoute('administration/tableauentreprise2.html.twig');
           
       }
       
       return $this->render('administration/tableauentreprise3.html.twig',['form' => $form->createView(),
            'editmode'=>$user->getId() !== null]);
      }
    }
    /**
     * @Route("/gestion1ListeRestaurants", name="gestion1ListeRestaurants")
     */
    public function tableauRestaurantsMajAction()
    {
    
       $restaurant= $this->getDoctrine()->getRepository(Restaurant::class)->findAll();
        return $this->render('administration/listeMiseAjourRestaurant.html.twig', array('restaurants'=>$restaurant) );
    }
    
     /**
     * @Route("/gestion1ListeCategories", name="gestion1ListeCategories")
     */
    public function tableauCategoriesMajAction( )
    {
    
       $categories= $this->getDoctrine()->getRepository(Categories::class)->findAll();
        return $this->render('administration/listeMiseAjouCategories.html.twig', array('categories'=>$categories) );
    }
    
     /**
     * @Route("/gestion1ListeHoraires/{id}", name="gestion1ListeHoraires")
     */
    public function tableauHorairesMajAction($id )
    {  
       $horaires= $this->getDoctrine()->getRepository(Restaurant::class)->trouvehoraires($id);
        return $this->render('administration/listeMiseAjouHoraires.html.twig', array('horaires'=>$horaires) );
    }
    
     /**
     * @Route("/gestion1ListeDescription/{id}", name="gestion1ListeDescription")
     */
    public function tableauDescriptionMajAction($id )
    {  
       $description= $this->getDoctrine()->getRepository(Restaurant::class)->trouvedescription($id);
        return $this->render('administration/listeMiseAjourDescription.html.twig', array('descriptions'=>$description) );
    }
}
