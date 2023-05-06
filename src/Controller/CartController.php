<?php

namespace App\Controller;

use App\Repository\AccommodationRepository;
use App\Repository\ActivityRepository;
use App\Repository\FoodRepository;
use App\Service\ReservationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{

    public function __construct(private ReservationService $reservationService)
    {
    }

    #[Route('/cart', name: 'app_cart')]
    public function index(AccommodationRepository $accommodationRepository, FoodRepository $foodRepository
        , ActivityRepository  $activityRepository): Response
    {

    }
}
