<?php

namespace AciliaChallengeBundle\Service;

use AciliaChallengeBundle\Library\FresquitoServiceInterface;
use Exception;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class FresquitoService implements FresquitoServiceInterface
{
    protected $apiUrl;
    protected $data;

    public function setApiUrl($apiUrl)
    {
        $this->apiUrl = $apiUrl;
    }

    public function getResults()
    {
        $this->loadData();
        $this->sortData();

        return $this->topRank(10);
    }

    protected function loadData()
    {
        $url = filter_var($this->apiUrl, FILTER_VALIDATE_URL);

        if (!$url) {
            throw new FileException('Source data not found');
        }

        $rawData = file_get_contents($url);
        $rawData = utf8_encode($rawData);
        $rawData = json_decode($rawData, true);

        if (!$rawData) {
            throw new Exception('No data received');
        }

        $this->data = [];
        foreach ($rawData as $key => $weatherData) {
            if (!array_key_exists('tmed', $weatherData)) {
                continue;
            }

            $indicativo = $weatherData['indicativo'];
            if (!array_key_exists($indicativo, $this->data)) {
                $this->data[$indicativo] = [
                    'nombre' => $weatherData['nombre'],
                    'media' => 0,
                    'data' => []
                ];
            }

            $dataCount = count($this->data[$indicativo]['data']);
            $this->data[$indicativo]['media'] = ($this->data[$indicativo]['media']*$dataCount+intval($weatherData['tmed']))/($dataCount+1);
            $this->data[$indicativo]['data'][] = $weatherData;
        }
    }

    protected function topRank($size = 10)
    {
        $top = array_splice($this->data, 0, $size);
        array_walk($top, function (&$item, $i) {
            $item = [$i, $item['nombre'], $item['media']];
        });

        return $top;
    }

    protected function sortData()
    {
        usort($this->data, function ($cityA, $cityB) {
            $a = $cityA['media'];
            $b = $cityB['media'];

            if ($a == $b) {
                return 0;
            }

            return ($a < $b) ? -1 : 1;
        });
    }
}
