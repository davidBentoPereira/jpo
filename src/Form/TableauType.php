<?php

namespace App\Form;

use App\Entity\Tableau;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ColorType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TableauType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('diplome',                TextareaType::class, ['label' => 'Diplôme :'])
            ->add('nbPlaces',               TextareaType::class, ['label' => 'Nombre de Places :'])
            ->add('firstYear',              TextareaType::class, ['label' => 'Première année :'])
            ->add('secondYear',             TextareaType::class, ['label' => 'Seconde année :'])
            ->add('diplomeIntermediaire',   TextareaType::class, ['label' => 'Diplôme Intermédiaire:'])
            ->add('thirdYear',              TextareaType::class, ['label' => 'Troisième année :'])
            ->add('poursuiteEtudes',        TextareaType::class, ['label' => 'Poursuite d\'Etudes:'])
            ->add('formationEtConcours',    TextareaType::class, ['label' => 'Formation et concours :'])
            ->add('vieActive',              TextareaType::class, ['label' => 'Vie Active :'])
            ->add('couleur',                ColorType::class,    ['label' => 'Couleur :'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Tableau::class,
        ]);
    }
}
