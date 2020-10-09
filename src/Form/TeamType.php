<?php

namespace App\Form;

use App\Entity\Team;
use App\Entity\TeamProject;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TeamType extends AbstractType
{
    /*
     * Build the form for Team creation
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'attr' => ['class' => 'form-control form-control-lg'],
                'label' => "Nom de l'équipe"
            ])
            ->add('picture_url', TextType::class, [
                'attr' => ['class' => 'form-control form-control-lg'],
                'label' => "URL de la photo de profil"
            ])
            ->add('projects', EntityType::class,
                [
                    'choice_label' => "project_name",
                    'class' => TeamProject::class,
                    "expanded" => true,
                    'label' => "Projets",
                    "multiple" => true
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Team::class,
        ]);
    }
}
