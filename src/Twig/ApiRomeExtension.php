<?php

namespace App\Twig;

use App\Service\ApiRome\ApiRome;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class ApiRomeExtension extends AbstractExtension
{
    private ApiRome $apiRome;

    public function __construct(ApiRome $apiRome)
    {
        $this->apiRome = $apiRome;
    }

    public function getFilters(): array
    {
        return [
            // If your filter generates SAFE HTML, you should add a third
            // parameter: ['is_safe' => ['html']]
            // Reference: https://twig.symfony.com/doc/2.x/advanced.html#automatic-escaping
            new TwigFilter('rome_name', [$this, 'romeName']),
        ];
    }

    public function romeName(string $codeRome): string
    {
        return $this->apiRome->getJobsByCodeName($codeRome)[0]['libelle'];
    }
}
