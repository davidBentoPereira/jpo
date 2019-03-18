<?php

namespace App\Form;

use App\Entity\Event;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class,
                ["label" => "Titre",
                    "attr" => [
                        "class" => "form-control",
                        "placeholder" => "Entrez votre titre"
                    ]])
            ->add('dateOfClosure', DateTimeType::class,
                ["label" => "Date de fin",
                    'input' => "datetime_immutable",
                    'placeholder' => [
                        'year' => 'Année', 'month' => 'Mois', 'day' => 'Jour',
                        'hour' => 'Heure', 'minute' => 'Minute', 'second' => 'Seconde'
                    ]])
            ->add('description', TextareaType::class,
                ["label" => "Description",
                    "attr" => [
                        "class" => "form-control",
                        "placeholder" => "Entrez votre description"
                    ]])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
}
