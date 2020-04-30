<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Produit;
use App\Entity\Formation;
use App\Entity\Employe;
use App\Entity\Visiteur;
use App\Form\FormationType;
use App\Form\InscriptionVisiteur;
use App\Form\Formation\InscriptionFormation;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormTypeInterface;




class GestionFormationController extends AbstractController
{
  
    /**
     * @Route("/gestion/formation", name="gestion_formation")
     */
    public function index()
    {
        return $this->render('gestion_formation/index.html.twig', [
            'controller_name' => 'GestionFormationController',
        ]);
    }
     
        /**
         * @Route("/ajoutFormation", name="app_formation_ajouter")
         */
        public function ajoutFormation(EntityManagerInterface $em,Request $request){
           
            //création du formulaire 
            $form=$this->createForm(FormationType::class);
            $form->handleRequest($request);
 
            if ($form->isSubmitted() && $form->isValid()) {// va effectuer la requête d'UPDATE en base de données
                $data=$form->getData();
                $formation= new Formation(); //création d'une nouvelle formation
                $formation->setDateDebut($data->getDateDebut()); //récupération des dates du début 
                $formation->setNbreHeures($data->getNbreHeures()); //récupération nombres heures
                $formation->setDepartement($data->getDepartement()); //récupération du département 
                $formation->setVille($data->getVille()); //récupération de la ville
                //cela va persister dans la formation 
                $em->persist($formation);
                //enregistrement dans la base de données
                $em->flush();
                //redirection vers la page donnée 
                return $this->redirectToRoute('app_aff_Aformation');
            
            }
        
            return $this->render('gestion_formation/AjoutFormation.html.twig', array(
                'form' => $form->createView(), //le createView permet de créer un twig 
            
            ));
            
        }
     
         /**
         * @Route("/affFormation", name="app_aff_Aformation")                                                                       
         */
        public function afficheLesFormations(){

            // Récupération de l'entity manager
            $formation= $this->getDoctrine()->getRepository(Formation::class)->findall(); //retourne toutes les formations dans la collection

            if(!$formation){
                $message="Il n'y a aucune formation de disponible"; //pas de formation créer et affichage d'un message 
            }
            else{
                $message=null; //aucun message si il y'a une formation
            }
           
            //redirection vers la page donnée
            return $this->render('gestion_formation/listeFormation.html.twig',array('ensFormation'=>$formation,'message'=>$message));
        }

        /**
         * @Route("/suppFormation/{id}", name="app_supp_formation")
        */

         public function suppFormation($id,ObjectManager $manager){

             // Récupération de l'entity manager
            $formation=$this->getDoctrine()->getRepository(Formation::class)->findOneBy(['id' => $id]); //cherche l'id de la formation
            $date = new \DateTime();

                if ($formation!=null){ //s'il existe une  formation 

            //affichage des informations de la formation
            echo $formation->getId();                                                                                               
            echo $formation->getNbreHeures();
            echo $formation->getDepartement();
            echo $formation->getVille();
          
        } 

            $manager->remove($formation); //Signale à la Doctrine qu'on veut supprimer l'entité en argument de la base de données
            $manager->flush($formation); //enregistre la formation dans la base de donnée

            return $this->redirectToRoute('app_aff_Aformation');//redirection vers la page donnée
        
        }


         /**
         * @Route("/affFormationVisiteur", name="app_aff_AformationVisiteur")
         */

        public function afficheLesFormationsV() { //peut etre id aff
            
            // Récupération de l'entity manager
            $formation= $this->getDoctrine()->getRepository(Formation::class)->findall(); //va retourner toutes les formations dans la collection
            if(!$formation) { //pas de formation

                $message = "Il n'y a aucune formation de disponible";
            }
            else { //formation

                $message = null; 
            }
            
            //redirection vers la page donnée avec les valeurs de la formation et du message 
            return $this->render('gestion_formation/listeFormationVisiteur.html.twig',array('ensFormation'=>$formation,'message'=>$message)); 
        }

    

}
       
    
      





