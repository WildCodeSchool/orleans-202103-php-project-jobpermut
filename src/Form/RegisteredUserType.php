<?php

namespace App\Form;

use App\Entity\RegisteredUser;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegisteredUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class)
            ->add('lastname', TextType::class)
            ->add('phone', TextType::class)
            ->add('city', TextType::class)
            ->add('cityJob', TextType::class)
            ->add('ogr', TextType::class)
            ->add('username', TextType::class)
            ->add('street', TextType::class)
            ->add('streetNumber', TextType::class)
            ->add('zipcode', TextType::class)
            ->add('jobStreet', TextType::class)
            ->add('jobStreetNumber', TextType::class)
            ->add('jobZipcode', TextType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => RegisteredUser::class,
        ]);
    }
}
