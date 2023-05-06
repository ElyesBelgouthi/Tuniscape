<?php

namespace App\Controller;

use App\Repository\AccommodationRepository;
use App\Repository\FoodRepository;
use App\Repository\ActivityRepository;
use App\Repository\ReservationRepository;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\ReservationService;
use Symfony\Component\HttpFoundation\Request;

class CartController extends AbstractController
{
    #[Route('/cart', name: 'app_cart')]
    public function index(ReservationService $reservationService, AccommodationRepository $accommodationRepository, FoodRepository $foodRepository, ActivityRepository $activityRepository): Response
    {
        $user = $this->getUser();
        if ($user === null) {
            // handle the case when the user is not logged in, e.g., redirect to the login page
            return $this->redirectToRoute('login_route');
        }

        $userId = $user->getId();
        // Find the existing reservation by user ID, if any
        $reservation = null;
        if ($userId) {
            $reservation = $reservationService->findReservationByUserId($userId);
        }

        // Initialize empty arrays to store the food, accommodation, and activity items
        $userFoods = [];
        $userAccommodations = [];
        $userActivities = [];

        // Loop through the reservations and retrieve the food, accommodation, and activity items

            $foods = $reservation->getFoods();
            $accommodations = $reservation->getAccommodations();
            $activities = $reservation->getActivities();

            foreach ($foods as $food) {
                $userFoods[] = $food;
            }

            foreach ($accommodations as $accommodation) {
                $userAccommodations[] = $accommodation;
            }

            foreach ($activities as $activity) {
                $userActivities[] = $activity;
            }



        return $this->render('cart/cart.html.twig', [
            'fcards' => $userFoods,
            'acards' => $userAccommodations,
            'vcards' => $userActivities,
        ]);
    }
    #[Route('/cart/remove', name: 'cart_remove')]
    public function remove(
        Request $request,
        EntityManagerInterface $em,
        FoodRepository $foodRepository,
        AccommodationRepository $accommodationRepository,
        ReservationService $reservationService,
        ActivityRepository $activityRepository,
        LoggerInterface $logger
    ): Response {
        $id = $request->request->get('id');
        $type = $request->request->get('type');
        $this->addFlash('notice', 'here');
        $user = $this->getUser();
        if ($user === null) {
            // handle the case when the user is not logged in, e.g., redirect to the login page
            return $this->redirectToRoute('login_route');
        }

        $userId = $user->getId();
        // Find the existing reservation by user ID, if any
        $reservation = null;
        if ($userId) {
            $reservation = $reservationService->findReservationByUserId($userId);
        }

        switch ($type) {
            case 'food':
                $food = $foodRepository->find($id);
                if ($food) {
                    $reservation->removeFood($food);
                }
                break;
            case 'accommodation':

                $logger->info("Attempting to remove accommodation with ID: {$id}");

                $accommodation = $accommodationRepository->find($id);
                if ($accommodation) {
                    $logger->info("Found accommodation: {$accommodation->getName()}");
                    $reservation->removeAccommodation($accommodation);
                    $logger->info("Removed accommodation from reservation");

                    $em->persist($reservation);
                    $em->flush();
                    $logger->info("Flushed changes to the database");

                    $this->addFlash('notice', $accommodation->getName());
                } else {
                    $logger->error("Could not find accommodation with ID: {$id}");
                }
                break;
            case 'activity':
                $activity = $activityRepository->find($id);
                if ($activity) {
                    $reservation->removeActivity($activity);
                }
                break;
        }

        $em->persist($reservation);
        $em->flush();

        return new JsonResponse(['status' => 'success']);
    }

}




