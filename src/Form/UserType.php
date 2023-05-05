<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username')
            ->add('roles', ChoiceType::class, [
                'choices' => [
                    'User' => 'ROLE_USER',
                    'Admin' => 'ROLE_ADMIN',
                    // add more roles if needed
                ],
                'multiple' => true,
                'expanded' => true,
            ])
            ->add('password')
            ->add('firstName')
            ->add('lastName')
            ->add('email')
            ->add('age')
            ->add('nationality')
            ->add('createdAt')
            ->add('updatedAt')
            ->add('isVerified')
            ->add('verficationCode')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
