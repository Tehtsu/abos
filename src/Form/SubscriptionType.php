<?php

declare(strict_types=1);

namespace App\Form;

use App\Entity\CategoryEntity;
use App\Entity\PaymentTypeEntity;
use App\Entity\SubscriptionEntity;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SubscriptionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class)
            ->add('startDate', DateType::class)
            ->add('coasts', NumberType::class)
            ->add('paymentPeriod', ChoiceType::class, [
                'choices' => [
                    'monatlich' => 1,
                    'viertel jährlich' => 3,
                    'halb jährlich' => 6,
                    'jährlich' => 12
                ]
            ])
            ->add('category', EntityType::class, [
                'class' => CategoryEntity::class,
                'choice_label' => 'name',
            ])
            ->add('paymentType', EntityType::class, [
                'class' => PaymentTypeEntity::class,
                'choice_label' => 'name',
            ])
            ->add('submit', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SubscriptionEntity::class
        ]);
    }
}
