<?php

declare(strict_types=1);

namespace App\Form\Category;

use App\Entity\Category\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'documentation' => [
                    'description' => 'Name of category.',
                ],
            ])
            ->add('abrev', TextType::class, [
                'documentation' => [
                    'description' => 'Abbreviation of category.',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Category::class,
            'allow_extra_fields' => true,
        ]);
    }

    /**
     * Get block prefix.
     */
    public function getBlockPrefix(): ?string
    {
        return null;
    }
}
