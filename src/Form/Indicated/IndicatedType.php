<?php

declare(strict_types=1);

namespace App\Form\Indicated;

use App\Entity\Category\Category;
use App\Entity\Indicated\Indicated;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class IndicatedType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('category', CollectionType::class, [
                'entry_class' => Category::class,
                'documentation' => [
                    'description' => 'Category of vote.',
                ],
            ])
            ->add('name', TextType::class, [
                'documentation' => [
                    'description' => 'Name of indicated.',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Indicated::class,
            'allow_extra_fields' => true,
        ]);
    }

    /**
     * Get block prefix.
     */
    public function getBlockPrefix(): string
    {
        return '';
    }
}
