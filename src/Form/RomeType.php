<?php

namespace App\Form;

use App\Service\ApiRome\ApiRome;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RomeType extends AbstractType
{
    private const INDEX = ['lebelle', 'code'];

    private ApiRome $apiRome;

    public function __construct(ApiRome $apiRome)
    {
        $this->apiRome = $apiRome;
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $utf8 = array(
            '/[áàâãªä]/u' => 'a',
            '/[ÁÀÂÃÄ]/u' => 'A',
            '/[ÍÌÎÏ]/u' => 'I',
            '/[íìîï]/u' => 'i',
            '/[éèêë]/u' => 'e',
            '/[ÉÈÊË]/u' => 'E',
            '/[óòôõºö]/u' => 'o',
            '/[ÓÒÔÕÖ]/u' => 'O',
            '/[úùûü]/u' => 'u',
            '/[ÚÙÛÜ]/u' => 'U',
            '/ç/' => 'c',
            '/Ç/' => 'C',
            '/ñ/' => 'n',
            '/Ñ/' => 'N',
            );
        $appellations = [];
        foreach ($this->apiRome->getAllAppelations() as $appellation) {
            $appellation[self::INDEX[0]] = preg_replace(array_keys($utf8), array_values($utf8), $appellation[self::INDEX[0]]);
            $appellations[$appellation[self::INDEX[0]]] = $appellation[self::INDEX[0]];
        }

        ksort($appellations);

        $builder
            ->add('appellation', ChoiceType::class, [
                'choices' => $appellations,
                'label' => 'Métier'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
