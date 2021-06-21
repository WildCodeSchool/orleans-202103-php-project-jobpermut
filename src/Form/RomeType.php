<?php

namespace App\Form;

use App\Service\ApiRome\ApiRome;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RomeType extends AbstractType
{
    private ApiRome $apiRome;

    public function __construct(ApiRome $apiRome)
    {
        $this->apiRome = $apiRome;
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('appellation', ChoiceType::class, [
                'choices' => $this->apiRome->sortResponseByName($this->apiRome->getAllAppelations()),
                'label' => 'Métier'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
