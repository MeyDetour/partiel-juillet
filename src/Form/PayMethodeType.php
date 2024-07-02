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
            ])
            ->add('address', TextType::class, [
                'label' => "Entrez votre adresse de facturation"
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PayMethode::class,
        ]);
    }
}
