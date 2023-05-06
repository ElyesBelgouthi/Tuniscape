<?php

namespace App\Controller;

use App\Repository\AccommodationRepository;
use App\Repository\ActivityRepository;
use App\Repository\FoodRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    #[Route('/cart', name: 'app_cart')]
    public function index(AccommodationRepository $accommodationRepository, FoodRepository $foodRepository
        , ActivityRepository  $activityRepository): Response
    {
        $accommodationCards = $accommodationRepository->findAll();
        $foodCards = $foodRepository->findAll();
        $activityCards = $activityRepository->findAll();

        return $this->render('cart/index.html.twig', [
            'accommodationCards' => $accommodationCards,
            'foodCards' => $foodCards,
            'activityCards' => $activityCards
        ]);
    }
}
