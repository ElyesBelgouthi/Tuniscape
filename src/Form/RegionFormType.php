<?php

namespace App\Form;

use App\Entity\Region;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegionFormType extends AbstractType
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $regions = $this->entityManager->getRepository(Region::class)->findBy([], ['name' => 'ASC']);

        $builder
            ->add('region', EntityType::class, [
                'class' => Region::class,
                'choice_label' => 'name',
                'choices' => $regions,
                'attr' => ['class' => 'region--name']
            ])
            ->add('Filter', SubmitType::class, [
                'attr' => ['class' => 'explore--btn'],
                'label' => '<i class="fas fa-filter"></i> Filter',
                'label_html' => true,
            ]);
    }
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
