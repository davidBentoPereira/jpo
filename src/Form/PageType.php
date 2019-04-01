<?php

namespace App\Form;

use App\Entity\Filiere;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ColorType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title',          TextType::class,        ['label' => 'Titre :'])
            ->add('rank',           IntegerType::class,     ['label' => 'Rang :'])
            ->add('colorPicker',    ColorType::class,       ['label' => 'Couleur de l\'interface :'])
            ->add('candidate',      TextType::class,        ['label' => 'Prérequis pour candidater :'])
            ->add('description',    CKEditorType::class,    ['label' => 'Description :', 'config' => ['toolbar' => 'basic']])
            ->add('titleBlock1',    TextType::class,        ['label' => 'Titre Bloque #1 :'])
            ->add('textBlock1',     CKEditorType::class,    ['label' => 'Texte Bloque #1 :', 'config' => ['toolbar' => 'basic']])
            ->add('titleBlock2',    TextType::class,        ['label' => 'Titre Bloque #2 :'])
            ->add('textBlock2',     CKEditorType::class,    ['label' => 'Texte Bloque #2 :', 'config' => ['toolbar' => 'basic']])
            ->add('titleBlock3',    TextType::class,        ['label' => 'Titre Bloque #3 :'])
            ->add('textBlock3',     CKEditorType::class,    ['label' => 'Texte Bloque #3 :', 'config' => ['toolbar' => 'basic']])
            ->add('titleBlock4',    TextType::class,        ['label' => 'Titre Bloque #4 :'])
            ->add('textBlock4',     CKEditorType::class,    ['label' => 'Texte Bloque #4 :', 'config' => ['toolbar' => 'basic']])
            ->add('titleBlock5',    TextType::class,        ['label' => 'Titre Bloque #5 :'])
            ->add('textBlock5',     CKEditorType::class,    ['label' => 'Texte Bloque #5 :', 'config' => ['toolbar' => 'basic']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Filiere::class,
        ]);
    }
}
