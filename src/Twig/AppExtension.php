<?php
// src/Twig/AppExtension.php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class AppExtension extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('fecha', [$this, 'fechaFormato']),
        ];
    }

    public function fechaFormato(\DateTime $fecha)
    {
        setlocale(LC_TIME, 'es_ES.UTF-8');
       

        return strftime("%A, %e de %B de %Y", $fecha->getTimestamp());
    }
}
