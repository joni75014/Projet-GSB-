<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Inscription;
use App\Entity\Formation;
use App\Form\FormationType;
use App\Form\VisiteurType;
use App\Entity\Visiteur;
use App\Form\InscriptionVisiteur;
use App\Form\InscriptionFormation;
use Doctrine\ORM\EntityManagerInterface;

class InscriptionFormationVisiteurController extends AbstractController
{
    /**
     * @Route("/inscription/formation/visiteur", name="inscription_formation_visiteur")
     */
    public function index()
    {
        return $this->render('inscription_formation_visiteur/index.html.twig', [
            'controller_name' => 'InscriptionFormationVisiteurController',
        ]);
    }

        /**
         * @Route("/inscriptionFormationVisiteur/{id}", name="app_inscrit_ajouter")
         */
        public function inscriptionLesFormationsV($id, ObjectManager $manager) {

            // Récupération de l'entity manager 
            $inscription= $this->getDoctrine()->getRepository(Inscription::class)->find(['id'=>$id]);//cherche l'id de la formation

                                  
      
            
            $inscription->setStatut('E');        //modifie statut en cours

            $manager->persist($inscription);    //Signale à la Doctrine qu'on veut supprimer l'entité en argument de la base de données
            
            $manager->flush();                 //enregistre la formation dans la base de donnée
            $message = "Inscription effectuée"; 

             //renvoie des données à la vue grâce aux array
            return $this->render('registration/inscriptionvalide.html.twig',array('inscription'=>$inscription, 'message' => $message));
            }


        /**
        * @Route("/acceptationInscription/{id}", name="app_acceptationInscription")
        */
        public function afficheLaFormationDuVisiteurInscrit($id) {

            $inscription = $this->getDoctrine()->getRepository(Inscription::class)->find($id); //cherche id inscription         
            $em->$this->getDoctrine()->getManager();
            $inscription->setStatut('A');       //statut est accepté
     
            $em->persist($inscription);
            $em->flush();
            return $this->redirectToRoute('app_inscription_afficher');
        }
         /**
         * @Route("/refuser/{id}", name="app_refuserInscription")
         */
    public function refuserInscription($id, ObjectManager $manager)
    {
        $inscription = $this->getDoctrine()->getRepository(Inscription::class)->find($id);
        $em = $this->getDoctrine()->getManager();
        $inscription->setStatut("R");
        $em->persist($inscription);
        $em->flush();
        return $this->redirectToRoute('aff_inscription');
    }

        /**
         * @Route("/ajoutInscription", name="app_inscription_ajouter")
         */

        public function ajoutInscription(EntityManagerInterface $em, Request $request){ 
            
                $inscription= new Inscription();
            
            //création du formulaire 
            $form=$this->createForm(InscriptionFormation::class,$inscription);
            $form->handleRequest($request);
 
            if ($form->isSubmitted() && $form->isValid()) {// va effectuer la requête d'UPDATE en base de données
             
                 //création d'une nouvelle formation
                 //récupération des dates du début 
                 $em=$this->getdoctrine()->getManager();
                $inscription->getVisiteur(); //récupération nombres heures
                ; //récupération du département 
                
                //cela va persister dans la formation 
                $em->persist($inscription);
                //enregistrement dans la base de données
                $em->flush();
                $this->addFlash('success','Inscription bien effectué !');
                //redirection vers la page donnée 
                return $this->redirectToRoute('app_inscription_ajouter')
               
                ;
            
            }
        
            return $this->render('registration/afficheFormationRestante.html.twig', array(
                'form' => $form->createView(),'inscription'=>$inscription,)) //le createView permet de créer un twig 
            
            ;
            
        }

    /**
     * @Route("/deconnexionVisiteur/", name="app_deconnexionV")
     */
    public function deconnexionV(){

        $session = $this->container->get('session');
        $session->invalidate();
        return $this->redirectToRoute('app_user_registration');
    }

     /**
     * @Route("/deconnexionEmploye/", name="app_deconnexionE")
     */

    public function deconnexionE(){

        $session = $this->container->get('session');
        $session->invalidate();
        return $this->redirectToRoute('app_user_registrationEmploye');
    }
        
    

}
           

        
        
        
    

