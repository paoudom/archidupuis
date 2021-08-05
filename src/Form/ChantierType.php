<?php

namespace App\Form;

use App\Entity\Chantier;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class ChantierType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre')
            ->add('type', ChoiceType::class, [
                'choices'  => [
                    'Logement individuel' => 'indiv',
                    'Logement collectif' => 'coll',
                    'Etablissement public' => 'erp',
                ],
            ])
            ->add('imageFile', FileType::class, [
                'required' => false
            ])
            ->add('descriptif')
            ->add('archi')
            ->add('annee')
            ->add('prix')
            ->add('carouselFiles', FileType::class, [
                'required' => false,
                'multiple' => true,
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Chantier::class,
        ]);
    }
}
