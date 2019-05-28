<?php

namespace App\Form;

use App\Entity\Filiere;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\ColorType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FiliereType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title',          TextType::class,        ['label' => 'Titre :'])
            ->add('colorPicker',    ColorType::class,       ['label' => 'Couleur de l\'interface :'])
            ->add('category',       ChoiceType::class,      ['label' => 'Catégorie', 'placeholder' => 'Sélectionner une catégorie',
                'choices'  => [
                    'BAC Professionnel'     => 'BAC Professionnel',
                    'CAP'                   => 'CAP',
                    'Dispositifs Spéciaux'  => 'Dispositifs',
                    'Autres formations'     => 'Autres formations',
                ],
            ])
            ->add('candidate',      TextType::class,        ['label' => 'Prérequis pour candidater :', 'required' => false])
            ->add('description',    CKEditorType::class,    ['label' => 'Description :', 'config' => ['toolbar' => 'basic'], 'required' => false])
            ->add('titleBlock1',    TextType::class,        ['label' => 'Titre Bloque #1 :', 'required' => false])
            ->add('textBlock1',     CKEditorType::class,    ['label' => 'Texte Bloque #1 :', 'config' => ['toolbar' => 'basic'], 'required' => false])
            ->add('titleBlock2',    TextType::class,        ['label' => 'Titre Bloque #2 :', 'required' => false])
            ->add('textBlock2',     CKEditorType::class,    ['label' => 'Texte Bloque #2 :', 'config' => ['toolbar' => 'basic'], 'required' => false])
            ->add('titleBlock3',    TextType::class,        ['label' => 'Titre Bloque #3 :', 'required' => false])
            ->add('textBlock3',     CKEditorType::class,    ['label' => 'Texte Bloque #3 :', 'config' => ['toolbar' => 'basic'], 'required' => false])
            ->add('titleBlock4',    TextType::class,        ['label' => 'Titre Bloque #4 :', 'required' => false])
            ->add('textBlock4',     CKEditorType::class,    ['label' => 'Texte Bloque #4 :', 'config' => ['toolbar' => 'basic'], 'required' => false])
            ->add('titleBlock5',    TextType::class,        ['label' => 'Titre Bloque #5 :', 'required' => false])
            ->add('textBlock5',     CKEditorType::class,    ['label' => 'Texte Bloque #5 :', 'config' => ['toolbar' => 'basic'], 'required' => false])
            ->add('video',          TextType::class,        ['label' => 'Vidéo Youtube :'  , 'required' => false])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Filiere::class,
        ]);
    }
}
