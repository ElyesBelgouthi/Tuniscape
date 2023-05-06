<?php
namespace App\Controller;

use App\Repository\AccommodationRepository;
use App\Repository\FoodRepository;
use App\Repository\ActivityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\ReservationService;
use Symfony\Component\HttpFoundation\Request;
class ExploreController extends AbstractController
{
    #[Route('/explore', name: 'app_explore')]
    public function index(AccommodationRepository $accommodationRepository, FoodRepository $foodRepository
        , ActivityRepository                      $activityRepository): Response
    {
        $pgs = $accommodationRepository->findAll();
        $fgs = $foodRepository->findAll();
        $ags = $activityRepository->findAll();

        return $this->render('explore/explore.html.twig', [
            'pcards' => $pgs,
            'fcards' => $fgs,
            'acards' => $ags
        ]);
    }
    #[Route('/explore/add', name: 'app_explore_add')]
    public function addAction(
        Request $request,
        ReservationService $reservationService,
        FoodRepository $foodRepository,
        ActivityRepository $activityRepository,
        AccommodationRepository $accommodationRepository
    ) {

        $startDate = new \DateTime(); // current date and time
        $endDate = new \DateTime('+7 day');
        $user = $this->getUser();
        if ($user === null) {
            // handle the case when the user is not logged in, e.g., redirect to the login page
            return $this->redirectToRoute('app_login');
        }

        $userId = $user->getId();
        // Find the existing reservation by user ID, if any
        $reservation = null;
        if ($userId) {
            $reservation = $reservationService->findReservationByUserId($userId);
        }
        $startDate = new \DateTime(); // Set the start date to the current date
        $endDate = new \DateTime(); // Set the end date to the current date
        $status = 0; // Set the status to an appropriate value

// Create or update the reservation
        $reservation = $reservationService->createOrUpdateReservation($userId, $startDate, $endDate, $status, $reservation);

        // Assuming you have some way of getting the selected food, activity, and accommodation entities
        $foodId = $request->get('food_id');
        $activityId = $request->get('activity_id');
        $accommodationId = $request->get('accommodation_id');

        if ($foodId) {
            $food = $foodRepository->find($foodId);
            if ($food) {
                $reservationService->addFoodToReservation($reservation, $food);
            }
        } elseif ($activityId) {
            $activity = $activityRepository->find($activityId);
            if ($activity) {
                $reservationService->addActivityToReservation($reservation, $activity);
            }
        } elseif ($accommodationId) {
            $accommodation = $accommodationRepository->find($accommodationId);
            if ($accommodation) {
                $reservationService->addAccommodationToReservation($reservation, $accommodation);
            }
        }

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
        // todo edit button to add
    }
}