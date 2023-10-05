<?php

namespace App\Form;

use App\Entity\Employe;
use App\Entity\Operation;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EmployeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('matricule')
            ->add('roles', ChoiceType::class, [
                'choices' => [
                    'EXPERT' => 'ROLE_EXPERT',
                    'SENIOR' => 'ROLE_SENIOR',
                    'APPRENTI' => 'ROLE_APPRENTI',
                ],
                'placeholder' => 'Sélectionnez une option', // Optionnel : affiche un libellé par défaut
                'label' => 'Roles', // Optionnel : spécifie l'étiquette du champ
                'multiple' => false
            ])
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false])
            ->add('nom')
            ->add('prenom')
            ->add('operation', EntityType::class, [
                'class' => 'App\Entity\Operation', //recupere la liste des opération
                'choice_label' => 'id', 
                'placeholder' => 'null', 
                'required' => false,//pour mettre un champs null
                'label' => 'Choisissez une operation',
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Employe::class, Operation::class,
            
        ]);
    }
}
