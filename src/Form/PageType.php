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
            ->add('titleBlock1',    TextType::class,        ['label' => 'Titre Bloque #1', 'attr' => ['placeholder' => 'Titre du bloque #1']])
            ->add('textBlock1',     TextareaType::class,    ['label' => 'Texte Bloque #1', 'attr' => ['placeholder' => 'Texte du bloque #1']])
            ->add('titleBlock2',    TextType::class,        ['label' => 'Titre Bloque #2', 'attr' => ['placeholder' => 'Titre du bloque #2']])
            ->add('textBlock2',     TextareaType::class,    ['label' => 'Texte Bloque #2', 'attr' => ['placeholder' => 'Texte du bloque #2']])
            ->add('titleBlock3',    TextType::class,        ['label' => 'Titre Bloque #3', 'attr' => ['placeholder' => 'Titre du bloque #3']])
            ->add('textBlock3',     TextareaType::class,    ['label' => 'Texte Bloque #3', 'attr' => ['placeholder' => 'Texte du bloque #3']])
            ->add('titleBlock4',    TextType::class,        ['label' => 'Titre Bloque #4', 'attr' => ['placeholder' => 'Titre du bloque #4']])
            ->add('textBlock4',     TextareaType::class,    ['label' => 'Texte Bloque #4', 'attr' => ['placeholder' => 'Texte du bloque #4']])
            ->add('titleBlock5',    TextType::class,        ['label' => 'Titre Bloque #5', 'attr' => ['placeholder' => 'Titre du bloque #5']])
            ->add('textBlock5',     TextareaType::class,    ['label' => 'Texte Bloque #5', 'attr' => ['placeholder' => 'Texte du bloque #5']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Filiere::class,
        ]);
    }
}
