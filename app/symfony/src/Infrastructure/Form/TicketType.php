<?php

namespace App\Infrastructure\Form;

use App\Infrastructure\ORM\Doctrine\Entity\Label;
use App\Infrastructure\ORM\Doctrine\Entity\Priority;
use App\Infrastructure\ORM\Doctrine\Entity\Ticket;
use App\Infrastructure\ORM\Doctrine\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class TicketType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'attr' => ['maxlength' => 40]
            ])
            ->add('description', TextareaType::class)
            ->add('technician_user_id', EntityType::class, [
                'class' => User::class
            ])
            ->add('priority_id', EntityType::class, [
                'class' => Priority::class,
                'choice_label' => 'name',
                'expanded' => true,
                'data' => $options['current_priority']
            ])
            ->add('labels', EntityType::class, [
                'class' => Label::class,
                'expanded' => true,
                'multiple' => true,
            ])
            ->add('submit', SubmitType::class, ['label' => 'Create Ticket'])
        ;
        $builder->get('description')->setRequired(false);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Ticket::class,
            'current_priority' => 1
        ]);
    }
}
