<?php

namespace AciliaChallengeBundle\Service;

use AciliaChallengeBundle\Library\FresquitoServiceInterface;

class FresquitoService implements FresquitoServiceInterface
{
    protected $apiUrl;

    public function setApiUrl($apiUrl)
    {
        $this->apiUrl = $apiUrl;
    }

    public function getResults()
    {
        // Este método debe leer la api y retornar un array con este formato
        // respetando las reglas descritas en http://reto.acilia.es

        return [
            [1, 'DON BENITO', '30,2'],
            [2, 'SANTA ELENA', '30,8'],
            [3, 'VEJER DE LA FRONTERA', '31,0']
            ];
    }
}