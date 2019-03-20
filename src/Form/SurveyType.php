<?php

namespace App\Form;

use App\Entity\Event;
use App\Entity\Survey;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SurveyType extends AbstractType
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
            ->add('event', EntityType::class, [
                'label' => 'Evenement',
                'class' => Event::class,
                'choice_label' => 'title',
            ])
        ;
    }

 /*   public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }*/
}
