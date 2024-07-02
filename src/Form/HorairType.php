<?php

namespace App\Form;

use App\Entity\Film;
use App\Entity\Horair;
use App\Entity\Room;
use App\Repository\FilmRepository;
use App\Repository\RoomRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HorairType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            ->add('hour', ChoiceType::class, [
                'choices' => [
                    '10:30' => new \DateTime('10:30'),
                    '13:45' => new \DateTime('13:45'),
                    '16:30' => new \DateTime('16:30'),
                    '19:00' => new \DateTime('19:00'),
                    '22:15' => new \DateTime('22:15'),
                ],
                'choice_label' => function($choice, $key, $value) {
                    return $key;
                },
                'choice_value' => function($choice) {
                    return $choice instanceof \DateTime ? $choice->format('H:i') : $choice;
                },
            ])
            ->add('film', EntityType::class, [
                'label'=>'Selectionnez votre film',
                'class' => Film::class,
                'query_builder' => function (FilmRepository $repository) {
                    return $repository->createQueryBuilder('u')
                        ->orderBy('u.title', 'ASC');
                },
                'choice_label' => 'title',
                'multiple' => false,
                'expanded' => false,
                'required'=>false,
            ])
            ->add('room', EntityType::class, [
                'label'=>'Selectionnez la salle',
                'class' => Room::class,
                'query_builder' => function (RoomRepository $repository) {
                    return $repository->createQueryBuilder('u')
                        ->orderBy('u.name', 'ASC');
                },
                'choice_label' => 'name',
                'multiple' => false,
                'expanded' => false,
                'required'=>false,
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Horair::class,
        ]);
    }
}
