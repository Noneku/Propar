<?php

namespace App\Form;

use App\Entity\Operation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType; // Importez ce namespace pour utiliser EntityType

class OperationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // Utilisez EntityType pour afficher un champ de sélection pour l'employé
            ->add('employe', EntityType::class, [
                'class' => 'App\Entity\Employe', // Remplacez par la classe réelle de l'employé
                'choice_label' => 'Nom', // L'attribut de l'employé à afficher dans la liste
                'multiple' => false,
                // Vous pouvez également ajouter d'autres options comme 'expanded' et 'multiple' si nécessaire
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Operation::class,
        ]);
    }
}
