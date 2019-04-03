<?php

namespace App\Form;

use App\Entity\Question;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QuestionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class,
                ["label" => "Question",
                    "attr" => [
                        "class" => "form-control",
                        "placeholder" => "Entrez votre question"
                    ]])
            ->add('questionType', EntityType::class,
                ["label" => "Type de la question",
                    'class' => \App\Entity\QuestionType::class,
                    'choice_label' => 'resume',
                    'choice_value' => 'label'
                    ])
        ;
    }

 /*   public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Question::class,
        ]);
    }*/
}
