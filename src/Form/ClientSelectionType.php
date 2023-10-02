<?php

// src/Form/ClientSelectionType.php

namespace App\Form;


use App\Entity\Operation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;



class ClientSelectionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('operation', EntityType::class, [
                'class' => Operation::class, //entité Operation
                'choice_label' => function ($operation) {
                
                    return $operation->getId(); // la propriété d'opération 
                },
                'placeholder' => 'Sélectionnez une opération', // Texte par défaut dans la liste déroulante
                'label' => 'Opération', // Étiquette du champ
                'required' => true, // Indique que  le champ est obligatoire
            ]);
    }

    // ...
}
