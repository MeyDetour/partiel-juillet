<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Film;
use App\Entity\Image;
use App\Repository\CategoryRepository;
use Doctrine\DBAL\Query\QueryBuilder;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FilmType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('description')
            ->add('title')
            ->add('categories', EntityType::class, [
                'label'=>'Selectionnez vos catégories',
                'class' => Category::class,
                'query_builder' => function (CategoryRepository $categoryRepository) {
                    return $categoryRepository->createQueryBuilder('u')
                        ->orderBy('u.name', 'ASC');
                },
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true,
                'required'=>false,
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Film::class,
        ]);
    }
}
