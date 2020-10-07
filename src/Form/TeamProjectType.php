<?php

namespace App\Form;

use App\Entity\Team;
use App\Entity\TeamProject;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TeamProjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('project_id')
            ->add('team', EntityType::class, ['class' => Team::class,
                'choice_label' => "id", 'multiple' => true]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => TeamProject::class,
        ]);
    }
}
