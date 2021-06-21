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
            ->add('firstname', TextType::class, ['attr' => ['placeholder' => 'John']])
            ->add('lastname', TextType::class, ['attr' => ['placeholder' => 'Doe']])
            ->add('phone', TextType::class, ['attr' => ['placeholder' => '06 56 86 98 09']])
            ->add('city', TextType::class, ['attr' => ['placeholder' => 'Orléans']])
            ->add('cityJob', TextType::class, ['attr' => ['placeholder' => 'Tours']])
            ->add('ogr', TextType::class, ['attr' => ['placeholder' => 'Développeur Web']])
            ->add('street', TextType::class, ['attr' => ['placeholder' => 'Rue des Lumières']])
            ->add('streetNumber', TextType::class, ['attr' => ['placeholder' => '67']])
            ->add('zipcode', TextType::class, ['attr' => ['placeholder' => '45100']])
            ->add('jobStreet', TextType::class, ['attr' => ['placeholder' => 'Avenue Charles Lenoir']])
            ->add('jobStreetNumber', TextType::class, ['attr' => ['placeholder' => '253']])
            ->add('jobZipcode', TextType::class, ['attr' => ['placeholder' => '37000']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => RegisteredUser::class,
        ]);
    }
}
