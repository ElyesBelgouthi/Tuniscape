<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\WeatherService;


class HomeController extends AbstractController
{
    private $weatherService;
    public function __construct(WeatherService $weatherService) {
        $this->weatherService = $weatherService;
    }
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        $locations = [
            ['name' => 'Tunis', 'lat' => 36.8065, 'lon' => 10.1815],
            ['name' => 'Sousse', 'lat' => 35.8254, 'lon' => 10.6369],
            ['name' => 'Hammamet', 'lat' => 36.4000, 'lon' => 10.6167],
            ['name' => 'Djerba', 'lat' => 33.8076, 'lon' => 10.8451],
            ['name' => 'Monastir', 'lat' => 35.7833, 'lon' => 10.8]
        ];

        $weatherData = [];
        foreach ($locations as $location) {
            $weather = $this->weatherService->getWeatherData($location['lat'], $location['lon']);
            $weatherData[] = [
                'name' => $location['name'],
                'description' => $weather['weather'][0]['description'],
                'temp' => $weather['main']['temp']
            ];
        }

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'weatherData' => $weatherData,

        ]);
    }
}
