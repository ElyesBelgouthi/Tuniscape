<?php
namespace App\Service;

use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class WeatherService {
    private HttpClientInterface $client;

    private $apiKey;

    public function __construct(HttpClientInterface $client) {
        $this->apiKey = 'e321d00e6458d09f7dcbc011fe4cf340';
        $this->client = $client;
    }




    public function getWeatherData(float $lat, float $lon): ?array
    {
        try {
            $response = $this->client->request(
                'GET',
                "https://api.openweathermap.org/data/2.5/weather?lat={$lat}&lon={$lon}&appid={$this->apiKey}&units=metric");

            if ($response->getStatusCode() !== 200) {
                return null;
            }

            return json_decode($response->getContent(), true);
        } catch (\Exception $e) {
            // Log the exception or handle it as needed
            return null;
        }
    }


}
