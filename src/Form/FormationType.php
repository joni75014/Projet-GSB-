<?php

namespace App\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Formation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;

class FormationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dateDebut', DateType::class, array(
                'label' => 'Date du début :',
                 'placeholder' => 'Sélectionner une date ')) //placeholder = label grisé
            ->add('nbreHeures', TextType::class, array(
                'label' => 'Nombre d"heure :',
                'attr' => array(
                    'placeholder' => 'Veuillez saisir un nombre d"heure' )))          
            ->add('departement', TextType::class, array(
                'label' => 'Département :',
                'attr' => array(
                    'placeholder' => 'Veuillez saisir un département' )))
            ->add('ville', TextType::class, array(
                'label' => 'Ville :',
                'attr' => array(
                    'placeholder' => 'Veuillez saisir une ville' )))    
            ->add('Ajouter', SubmitType::class)
          
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Formation::class,
        ]);
    }
}
