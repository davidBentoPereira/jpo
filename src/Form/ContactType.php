<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',       TextType::class, ['label' => 'Nom :'])
            ->add('address',    TextType::class, ['label' => 'Adresse :'])
            ->add('zipCode',    TextType::class, ['label' => 'Code Postal :'])
            ->add('city',       TextType::class, ['label' => 'Ville :'])
            ->add('phone',      TextType::class, ['label' => 'Téléphone :'])
            ->add('fax',        TextType::class, ['label' => 'Fax :'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
