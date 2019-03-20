<?php

namespace App\Form;

use App\Entity\Filiere;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title',          TextType::class,        ['label' => 'Titre', 'attr' => ['placeholder' => 'Titre de la filière']])
            ->add('candidate',      TextType::class,        ['label' => 'Prérequis pour candidater', 'attr' => ['placeholder' => 'Prérequis pour candidater']])
            ->add('description',    TextAreaType::class,    ['label' => 'Description', 'attr' => ['placeholder' => 'Description de la filière']])
            ->add('titleBlock1',    TextType::class,        ['label' => 'Titre Bloque #1', 'attr' => ['placeholder' => '']])
            ->add('textBlock1',     TextareaType::class,    ['label' => 'Texte Bloque #1', 'attr' => ['placeholder' => '']])
            ->add('titleBlock2',    TextType::class,        ['label' => 'Titre Bloque #2', 'attr' => ['placeholder' => '']])
            ->add('textBlock2',     TextareaType::class,    ['label' => 'Texte Bloque #2', 'attr' => ['placeholder' => '']])
            ->add('titleBlock3',    TextType::class,        ['label' => 'Titre Bloque #3', 'attr' => ['placeholder' => '']])
            ->add('textBlock3',     TextareaType::class,    ['label' => 'Texte Bloque #3', 'attr' => ['placeholder' => '']])
            ->add('titleBlock4',    TextType::class,        ['label' => 'Titre Bloque #4', 'attr' => ['placeholder' => '']])
            ->add('textBlock4',     TextareaType::class,    ['label' => 'Texte Bloque #4', 'attr' => ['placeholder' => '']])
            ->add('titleBlock5',    TextType::class,        ['label' => 'Titre Bloque #5', 'attr' => ['placeholder' => '']])
            ->add('textBlock5',     TextareaType::class,    ['label' => 'Texte Bloque #5', 'attr' => ['placeholder' => '']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Filiere::class,
        ]);
    }
}
