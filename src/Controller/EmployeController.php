<?php

namespace App\Controller;

use App\Form\EmployeType;
use App\Entity\Employe;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;

class EmployeController extends AbstractController
{
    /**
     * @Route("/employe", name="employe")
     */
    public function index()
    {
        return $this->render('employe/index.html.twig', [
            'controller_name' => 'EmployeController',
        ]);
    }

    /**
     * @Route("/loginEmploye", name="app_user_registrationEmploye")
     */
    public function loginEmploye(Request $request, $employe=null)
    {
         // 1) Construction du formulaire
        if ($employe==null) {
            $employe = new Employe();
         } 
        $form = $this->createForm(EmployeType::class, $employe);

        // 2) Vérifier que les données du formulaire son bien récupérer (will only happen on POST)
        $form->handleRequest($request);       
         
        if ($form->isSubmitted() && $form->isValid()) {

            // 4) sauvegarde le visiteur          
            $employe = $this->getDoctrine()->getRepository(Employe::class)->findOneBySomeLoginMdp($employe->getLogin(), $employe->getMdp());
           
          
            if($employe) {

                //mise en variable de session de l'employé
                $session = new Session();
                $session->set('employeId', $employe->getId());  

                return $this->redirectToRoute('app_aff_Aformation'); 
            }
             
        }

        return $this->render('employe/connexEmploye.html.twig', array('form'=>$form->createView())); 
    }

   
}


