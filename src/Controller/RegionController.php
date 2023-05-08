<?php

namespace App\Controller;

use App\Repository\RegionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RegionController extends AbstractController
{
    #[Route('/region', name: 'app_region')]
    public function index(
        RegionRepository $regionRepository
    ): Response
    {
        $regions = $regionRepository->findAll();

        $data = [];
        foreach ($regions as $region) {
            $data[] = [
                'name' => $region->getName(),
                'description' => $region->getDescription(),
                'latitude' => $region->getLatitude(),
                'longitude' => $region->getLongitude(),
            ];
        }
        return new JsonResponse($data);
    }
}
