<?php

namespace App\Form;

use App\Entity\Tableau;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ColorType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TableauType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('rank',                   IntegerType::class,  ['label' => 'Position :'])
            ->add('diplome',                TextareaType::class, ['label' => 'Diplôme :', 'required' => false])
            ->add('nbPlaces',               TextareaType::class, ['label' => 'Nombre de Places :', 'required' => false])
            ->add('firstYear',              TextareaType::class, ['label' => 'Première année :', 'required' => false])
            ->add('secondYear',             TextareaType::class, ['label' => 'Seconde année :', 'required' => false])
            ->add('diplomeIntermediaire',   TextareaType::class, ['label' => 'Diplôme Intermédiaire:', 'required' => false])
            ->add('thirdYear',              TextareaType::class, ['label' => 'Troisième année :', 'required' => false])
            ->add('poursuiteEtudes',        TextareaType::class, ['label' => 'Poursuite d\'Etudes:', 'required' => false])
            ->add('formationEtConcours',    TextareaType::class, ['label' => 'Formation et concours :', 'required' => false])
            ->add('vieActive',              TextareaType::class, ['label' => 'Vie Active :', 'required' => false])
            ->add('couleur',                ColorType::class,    ['label' => 'Couleur :', 'required' => false])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Tableau::class,
        ]);
    }
}
