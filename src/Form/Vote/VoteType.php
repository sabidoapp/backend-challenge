<?php

declare(strict_types=1);

namespace App\Form\Vote;

use App\Entity\Category\Category;
use App\Entity\Indicated\Indicated;
use App\Entity\Vote\Vote;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VoteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'documentation' => [
                    'description' => 'Category of vote.',
                ],
            ])
            ->add('indicated', EntityType::class, [
                'class' => Indicated::class,
                'documentation' => [
                    'description' => 'Indicated of vote.',
                ],
            ])
            ->add('rating', NumberType::class, [
                'documentation' => [
                    'description' => 'Rating of vote.',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Vote::class,
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
