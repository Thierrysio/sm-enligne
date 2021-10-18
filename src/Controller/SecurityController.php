<?php

namespace App\Controller;
use Symfony\Component\HttpFoundation\Response;

use App\Entity\User;
use App\Entity\Photoprofil;
use App\Form\PhotoType;
use App\Form\PhotoprofilType;
use App\Form\RegistrationType;
use App\Form\StripeType;
use DateTime;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Attribute\AttributeBag;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\NativeSessionStorage;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class SecurityController extends Controller
{
    /**
     * @Route("/inscription", name="security_registration")
     * @Route("/inscription/{id}/edit", name="security_registration_update")
     */
    public function registration(User $user=null,Request $request, ObjectManager $manager, UserPasswordEncoderInterface $encoder)
    {
        if (!$user){
       $user = new User;
        $session = $request->getSession();
        $session->set('erreur','Vous êtes sur le point de changer votre façon de travailler. Profitez de votre premier mois d’essai gratuit sauce Moutard sans engagement puis 9€90 par mois. Vos données restent confidentielles, c’est promis!');
        }
       $form = $this->createForm(RegistrationType::class,$user);
       
       $form->handleRequest($request);

       if($form->isSubmitted()&& $form->isValid())
       {
           
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
           
           $session = new Session(new NativeSessionStorage(), new AttributeBag());
           $session->set('erreur','Votre inscription est enregistréee. Profitez bien de votre période d\'essai');
               
           return $this->redirectToRoute('security_login');
           
       }
       
       return $this->render('security/registration.html.twig',['form' => $form->createView(),
            'editmode'=>$user->getId() !== null]);
    }
    
    /**
     * @Route("/connexion", name="security_login")
     */
    public function login()
    {
        return $this->render('security/login.html.twig');
    }
    
    /**
     * @Route("/phasepaiement/{id} ", name="phasepaiement")
     */
    public function phasepaiement(User $user=null, Request $request)
    {
      
         
       $form = $this->createForm(StripeType::class);
       $form->handleRequest($request);

       if($form->isSubmitted()&& $form->isValid())
       {
            $user= $this->getDoctrine()->getRepository(User::class)->find($user);
            
            if ($user->getEmail() != $request->request->get('stripeEmail') )
            {
                $session = new Session(new NativeSessionStorage(), new AttributeBag());
                $session->set('erreur','Les mails INSCRIPTION et ABONNEMENT doivent correspondre. Nous vous invitons à recommencer la procédure d\'abonnement');  
                 
                return $this->redirectToRoute('security_registration_update',['id'=>$user->getId()] );
            }
            else {
     
                $session = new Session(new NativeSessionStorage(), new AttributeBag());
                $session->set('erreur','');  
                
            }
                
           \Stripe\Stripe::setApiKey("sk_live_m62cA8sQzQPQRouS8gnheZvO");

                $customer = \Stripe\Customer::create([
                'email' => $request->request->get('stripeEmail'),
                'source' => $request->request->get('stripeToken'),
                ]);
                
                $subscription = \Stripe\Subscription::create([
                'customer' => $customer->id,
                'items' => [['plan' => 'plan_DisfgDG5KOmFOH']],
                'trial_period_days' => 30,
                ]);
               
                
           
                $entityManager = $this->getDoctrine()->getManager();
                $user= $this->getDoctrine()->getRepository(User::class)->find($user->getId());
                $user->setCustomerStripe($customer->id);
                $user->setDateDebutAbonnement((new DateTime('now')));
                
                $entityManager->persist($user);
                $entityManager->flush();
                
                $session = new Session(new NativeSessionStorage(), new AttributeBag());
                $session->set('erreur','Votre inscription est enregistréee. Profitez bien de votre période d\'essai');
               
                
                return $this->redirectToRoute('security_login' );
                
       }
        return $this->render('security/phasepaiement.html.twig', ['form' => $form->createView(),
            'editmode'=>$user->getId() !== null]);
    }
    
    /**
    * @Route("/photoprofil", name="photoprofil")
     */
    public function photoprofil(Request $request, ObjectManager $manager, UserPasswordEncoderInterface $encoder)
    {
        $user = $this->getUser();
        
        if ($user == "") return $this->redirectToRoute('security_login');
        
        

        $photoprofil = new Photoprofil;

       $form = $this->createForm(PhotoprofilType::class,$photoprofil);
       $form->handleRequest($request);

       if($form->isSubmitted()&& $form->isValid())
       {
          
       
           
        $file = $photoprofil->getPhoto();
        
        

            $fileName = md5(uniqid()).'.'.$file->guessExtension();

            // Move the file to the directory where brochures are stored
            try {
                $file->move(
                    $this->getParameter('photo_directory'),
                    $fileName
                );
            } catch (FileException $e) {
                // ... handle exception if something happens during file upload
            }

            // updates the 'brochure' property to store the PDF file name
            // instead of its contents
            $photoprofil->setPhoto($fileName);
            
           $manager->persist($photoprofil);
           $manager->flush();
           
           $user->setPhoto($photoprofil);
           $manager->persist($user);
           $manager->flush();
           
           return $this->redirectToRoute('profil',array('id'=>$user->getId()) );
 
       }
       
       return $this->render('security/photoprofil.html.twig',['form' => $form->createView(),
            'editmode'=>$photoprofil->getId() !== null]);
    }
    
    /**
      * @Route("/photo/{id}/edit", name="photo")
     */
    public function photo(User $user=null,Request $request, ObjectManager $manager, UserPasswordEncoderInterface $encoder)
    {
        if (!$user){
       $user = $this->getUser();
        }
       $form = $this->createForm(PhotoType::class,$user);
       $form->handleRequest($request);

       if($form->isSubmitted()&& $form->isValid())
       {
           

         $hash = $encoder->encodePassword($user, $user->getPassword());
           $user->setPassword($hash);
           
           $manager->persist($user);
           $manager->flush();
           
           return $this->redirectToRoute('security_login');
 
       }
       
       return $this->render('security/photoForm.html.twig',['form' => $form->createView(),
            'editmode'=>$user->getId() !== null]);
    }
    
        /**
     * @Route("/mdpo/{identifiant}", name="mdpo")
     */
    public function mdpo($identifiant,UserPasswordEncoderInterface $encoder, \Swift_Mailer $mailer)
    {
         $entityManager = $this->getDoctrine()->getManager();
                
        $user= $this->getDoctrine()->getRepository(User::class)->findOneBy(['username' => $identifiant]);
        
        if ($user == "") return $this->redirectToRoute('security_login');
        
        $hash = $encoder->encodePassword($user, "saucemoutard");
        $user->setPassword($hash);
        $entityManager->persist($user);
        $entityManager->flush();
        
         $message = (new \Swift_Message('Hello '.$user->getPrenom()))
        ->setFrom('support@saucemoutard.ovh')
        ->setTo('thierry28220@icloud.com')
        ->setBody(
            $this->renderView(
                // templates/emails/registration.html.twig
                'security/textemail.html.twig'
            ),
            'text/html'
        )
        /*
         * If you also want to include a plaintext version of the message
        ->addPart(
            $this->renderView(
                'emails/registration.txt.twig',
                array('name' => $name)
            ),
            'text/plain'
        )
        */
    ;

    $mailer->send($message);
        return $this->render('security/mdpo.html.twig');
    }
    
    /**
    * @Route("/images", name="images")
     */
    public function images(Request $request)
    {

            // Move the file to the directory where brochures are stored
            

 return new Response($request);
    }
}
