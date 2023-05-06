<?php

namespace App\Form;

use App\Entity\Accommodation;

use App\Entity\Region;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AccommodationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('type', ChoiceType::class, [
                'choices'=>[
                    "Hotel"=>'hotel',
                    "Maison d'hote"=>"Maison d'hote",
                ],
                'placeholder'=>'Choose an accommodation type',
            ])
            ->add('description')
            #->add('latitude')
            #->add('longitude')
            ->add('region', EntityType::class,[
                'class'=>Region::class,
                'choice_label'=>'name',
            ])
            ->add("Add", SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Accommodation::class,
        ]);
    }
}
