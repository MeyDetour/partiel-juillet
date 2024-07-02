<?php

namespace App\Form;

use App\Entity\Address;
use App\Entity\PayMethode;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PayMethodeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('number', IntegerType::class, [
                'label' => "Votre numéro de carte",
                'attr'=>[

                    'className' => 'cardInput'
                ]
            ])->add('master', TextType::class, [
                'label' => "Nom du propriétaire",
                'attr'=>[

                    'className' => 'cardInput'
                ]
            ]);


    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PayMethode::class,
        ]);
    }
}
