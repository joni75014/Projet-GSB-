<?php

namespace App\Controller;

use App\Form\VisiteurType;
use App\Entity\Visiteur;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;


class RegistrationController extends AbstractController
{
    /**
     * @Route("/registration", name="registration")
     */
    public function index()
    {
        return $this->render('registration/index.html.twig', [
            'controller_name' => 'RegistrationController',
        ]);
    }


    /**
     * @Route("/login", name="app_user_registration")
     */
    public function login(Request $request,$visiteur=null)
    {
         // 1) Construction du formulaire
         if(!$visiteur)
         {
             $visiteur= new Visiteur();
         }
        $form = $this->createForm(VisiteurType::class, $visiteur); 

        // 2) Vérifier que les données du formulaire son bien récupérer (will only happen on POST)
        $form->handleRequest($request);       
         
        if ($form->isSubmitted() && $form->isValid()) {

            // 4) sauvegarde le visiteur
           
            $visiteur = $this->getDoctrine()->getRepository(Visiteur::class)->findOneBySomeLoginMdp($visiteur->getLogin(), $visiteur->getMdp());

            if($visiteur){
                $session = new Session();
                $session->set('visiteurId', $visiteur->getId());     
                }
                $em=$this->getDoctrine()->getManager();
                $em->persist($visiteur);
                $em->flush();
                return $this->redirectToRoute('app_aff_AformationVisiteur', ['id'=>$visiteur->getId()]);
    }

    return $this->render('registration/connexVisiteur.html.twig', array('form'=>$form->createView(),'id'=>$visiteur->getId())); 
}
}
    