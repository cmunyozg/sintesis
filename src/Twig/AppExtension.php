<?php
// src/Twig/AppExtension.php

namespace App\Twig;

use Symfony\Component\Validator\Constraints\Length;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class AppExtension extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('fecha', [$this, 'formatearFecha']),
            new TwigFilter('descripcion', [$this, 'formatearDescripcion'])
        ];
    }

    public function formatearFecha(\DateTime $fecha)
    {
        setlocale(LC_TIME, 'es_ES.UTF-8');
        return strftime("%A, %e de %B de %Y", $fecha->getTimestamp());
    }

    // Recibe número de palabras y devuelve la descripción recortada.
    public function formatearDescripcion(string $descripcion, $numPalabras)
    {
        $arrayPalabras = explode(' ', $descripcion, $numPalabras);
        if (count($arrayPalabras) < $numPalabras) {
            return $descripcion;
        } else {
            $resultado = '';
            for ($i = 0; $i < (count($arrayPalabras) - 1); $i++) $resultado .= ' ' . $arrayPalabras[$i];

            return $resultado . '...';
        }
    }
}
