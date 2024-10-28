<?php

declare(strict_types=1);

namespace App\Form;

use App\Entity\Const\Expense as ExpenseConstants;
use App\Entity\Expense;
use App\Entity\ExpenseCategory;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ExpenseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('description', TextType::class)
            ->add('type', ChoiceType::class, [
                'choices' => $this->buildTypeChoices(),
                'placeholder' => 'Please select an option',
            ])
            ->add('cost', IntegerType::class)
            ->add('date', DateType::class, [
                'input'  => 'datetime_immutable',
                'widget' => 'single_text',
                'format' => 'dd/mm/yyyy',
                'html5' => false,
            ])
            ->add('comments', TextareaType::class, [
                'required' => false,
                'attr' => ['rows' => 5],
            ])
            ->add('category', EntityType::class, [
                'class' => ExpenseCategory::class,
                'query_builder' => function (EntityRepository $er): QueryBuilder {
                    return $er->createQueryBuilder('expenseCategory')
                        ->orderBy('expenseCategory.name', 'ASC');
                },
                'choice_label' => 'name',
                'placeholder' => 'Please select an option',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Expense::class,
        ]);
    }

    public function getBlockPrefix(): string
    {
        $blockPrefix = parent::getBlockPrefix();

        return !empty($blockPrefix) ? $blockPrefix : 'expense';
    }

    /**
     * @return string[]
     */
    private function buildTypeChoices(): array
    {
        return array_combine(ExpenseConstants::TYPES, ExpenseConstants::TYPES);
    }
}
