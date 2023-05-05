<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FoodController extends AbstractController
{
    #[Route('/food', name: 'app_food')]
    public function index(): Response
    {
        return $this->render('food/index.html.twig', [
            'controller_name' => 'FoodController',
        ]);
    }
}
