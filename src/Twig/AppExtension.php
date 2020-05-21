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
            new TwigFilter('descripcion', [$this, 'formatearDescripcion']),
            new TwigFilter('ubicacion', [$this, 'formatearUbicacion']),

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

    // Recibe la ubicación y la devuelve incluyendo hasta la ciudad
    public function formatearUbicacion(string $ubicacion)
    {
        $arrayPartesUbicacion = explode(',', $ubicacion);

        $resultado = '';
        for ($i = 0; $i < count($arrayPartesUbicacion) - 1; $i++)
            $resultado .= $arrayPartesUbicacion[$i].',';

        return substr($resultado, 0, -1); //elimina la coma final
    }
}
