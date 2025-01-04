<?php

declare(strict_types=1);

namespace App\Form;

use App\Entity\RepeatCost;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RepeatCostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('description', TextType::class)
            ->add('cost', IntegerType::class)
            ->add('date', DateType::class, [
                'input'  => 'datetime_immutable',
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy',
                'html5' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => RepeatCost::class,
        ]);
    }

    public function getBlockPrefix(): string
    {
        $blockPrefix = parent::getBlockPrefix();

        return !empty($blockPrefix) ? $blockPrefix : 'repeat_cost';
    }
}
