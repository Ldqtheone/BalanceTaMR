<?php

namespace App\Form;

use App\Entity\Team;
use App\Entity\TeamProject;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TeamType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('picture_url')
            ->add('projects', EntityType::class,
                [
                    'class' => TeamProject::class,
                    'choice_label' => "project_name",
                    "multiple" => true,
                    "expanded" => true
                ]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Team::class,
        ]);
    }
}
