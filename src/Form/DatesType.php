<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DatesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dateEntree', DateType::class, [
                'widget' => 'single_text',
                'required' => true,
                'label' => 'Date de début',
            ])
            ->add('dateSortie', DateType::class, [
                'widget' => 'single_text',
                'required' => true,
                'label' => 'Date de fin',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here if needed
        ]);
    }
}