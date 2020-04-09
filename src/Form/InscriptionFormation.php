<?php

namespace App\Form;

use App\Entity\Inscription;
use App\Entity\Formation;
use App\Entity\Visiteur;
use App\Form\FormationType;
use App\Form\VisiteurType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type as SFType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;



class InscriptionFormation extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        
            ->add('Formation', EntityType::class,[                      
                'class' => Formation::class,
                'placeholder' => 'Sélectionner une formation',
                'required'=>false,
                'choice_label' => 'id',])
            ->add('statut',ChoiceType::class, [
                    'placeholder' => "Sélectionner le statut",
                    'choices'=>[
                        'Inscrit'=>"Inscrit"
                    ],
                    'choice_label' => function ($choice, $key, $value) 
                    {
                        if ("Inscrit" === $choice) {
                            return 'Inscrit';
                        }
                        return strtoupper($key)
                    ;}
                ])
           
         //   ->add ('Visiteur', EntityType::class,['class'=>Visiteur::class, 'choice_label' => 'nom',])
            ->add('Ajouter', SubmitType::class)
            ;   }
        
      

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Inscription::class,
        ]);
    } 
}

