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

            $messageInscription = null;
            $message = null;
            $lstInscription = $this->getDoctrine()->getRepository(Inscription::class);  //cherche l'id de la formation
            $formation = $this->getDoctrine()->getRepository(Formation::class)->find($id);
            $condition = $lstInscription->findOneBy(['formation' => $formation]);
            $visiteurId= $this->get('session')->get('visiteurId');
            $visiteur = $this->getDoctrine()->getRepository(Visiteur::class)->find($visiteurId);  

            if ($condition) {

                
                $message ="Vous êtes déjà inscrit à cette formation !";
           
    
            // Récupération de l'entity manager            
        }
            else {

           $messageInscription = "Inscription effectuée ! "; 
            $inscription = new Inscription(); 

            $inscription->setVisiteur($visiteur); 
            $inscription->setStatut('E');        //modifie statut en cours
            $inscription->setFormation($formation);
            $manager->persist($inscription);    //Signale à la Doctrine qu'on veut supprimer l'entité en argument de la base de données
            $manager->flush();                 //enregistre la formation dans la base de donnée
           
        }
             //renvoie des données à la vue grâce aux array
            return $this->render('gestion_formation/inscription_formation.html.twig',array('ensFormation'=>$formation,'message'=>$message, 'inscriptionMsg'=>$messageInscription ,'unVisiteur'=>$visiteur));
            }
    
    /**
     * @Route("/affListeInscriptionEnCours/", name="aff_inscription")
     */
    public function afficheLesInscriptions() //liste inscription en cours 
    {
     
        $listeInscription = $this->getDoctrine()->getRepository(Inscription::class);
        $statut = $listeInscription->findBy(['statut' => "E"]);
        if(!$statut){
            $message = "Aucune inscription en cours !";
        }
        else{
            $message = null;
        }
        return $this->render('gestion_formation/listeInscription.html.twig', array('lesInscriptions'=>$statut,'message'=>$message));
    }

    

     /**
     * @Route("/refuserInscription/{id}", name="app_refuserInscription")
     */
    public function refuserInscriptionFormation($id, ObjectManager $manager) //refuser inscription
    {
        $inscription = $this->getDoctrine()->getRepository(Inscription::class)->find($id);
        $em = $this->getDoctrine()->getManager();
        $inscription->setStatut("R"); //statut refusé
        $em->persist($inscription);
        $em->flush();

        return $this->redirectToRoute('app_aff_Aformation');
    }

         /**
        * @Route("/acceptationInscription/{id}", name="app_acceptationInscription")
        */

        public function acceptationInscriptionFormation($id, ObjectManager $manager) //refuser inscription
        {
            $inscription = $this->getDoctrine()->getRepository(Inscription::class)->find($id);
            $em = $this->getDoctrine()->getManager();
            $inscription->setStatut("A"); //statut refusé
            $em->persist($inscription);
            $em->flush();
            $this->addFlash('success','Inscription Enregistrée !');
    
            return $this->redirectToRoute('app_aff_Aformation');
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

    public function deconnexionE() {

        $session = $this->container->get('session');
        $session->invalidate();
        return $this->redirectToRoute('app_user_registrationEmploye');
    }
}
           

        
        
        
    

