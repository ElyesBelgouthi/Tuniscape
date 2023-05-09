<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Repository\AccommodationRepository;
use App\Repository\FoodRepository;
use App\Repository\ActivityRepository;
use App\Repository\ReservationRepository;
use App\Repository\UserRepository;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\ReservationService;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\User;

class CartController extends AbstractController
{
    #[Route("/cart", name: "app_cart")]
    public function index(
        UserRepository $userRepository,
        ReservationService $reservationService,
        AccommodationRepository $accommodationRepository,
        FoodRepository $foodRepository,
        ActivityRepository $activityRepository
    ): Response {
        $user = $this->getUser();
        if ($user === null) {
            // handle the case when the user is not logged in, e.g., redirect to the login page
            return $this->redirectToRoute("app_login");
        }

        $userId = $user->getId();
        $User2 = $userRepository->find($userId);
        // Find the existing reservation by user ID, if any
        $reservation = null;
        if ($userId) {
            $reservation = $reservationService->findReservationByUser($User2);
        }
        if ($reservation === null) {
            return $this->render("cart/noItemsAddedNow.html.twig");
        }

        // Initialize empty arrays to store the food, accommodation, and activity items
        $userFoods = [];
        $userAccommodations = [];
        $userActivities = [];

        // Loop through the reservations and retrieve the food, accommodation, and activity items

        $foods = $reservation->getFoods();
        $accommodations = $reservation->getAccommodations();
        $activities = $reservation->getActivity();
        $startDateValue = $reservation->getStartDate();
        $endDateValue = $reservation->getEndDate();
        if ($startDateValue === null) {
            $startDateValue = new \DateTime("NOW");
        }
        if ($endDateValue === null) {
            $endDateValue = new \DateTime("NOW");
        }
        foreach ($foods as $food) {
            $userFoods[] = $food;
        }

        foreach ($accommodations as $accommodation) {
            $userAccommodations[] = $accommodation;
        }

        foreach ($activities as $activity) {
            $userActivities[] = $activity;
        }

        return $this->render("cart/index.html.twig", [
            "foodCards" => $userFoods,
            "accommodationCards" => $userAccommodations,
            "activityCards" => $userActivities,
            "startDateValue" => $startDateValue->format("Y-m-d"),
            "endDateValue" => $endDateValue->format("Y-m-d"),
        ]);
    }

    #[Route("/cart/add", name: "cart_add")]
    public function add(
        Request $request,
        EntityManagerInterface $entityManager,
        UserRepository $userRepository,
        FoodRepository $foodRepository,
        AccommodationRepository $accommodationRepository,
        ReservationService $reservationService,
        ActivityRepository $activityRepository,
        LoggerInterface $logger
    ): Response {
        $id = $request->query->get("id");
        $type = $request->query->get("type");
        $this->addFlash("notice", "here");
        $user = $this->getUser();
        if ($user === null) {
            // handle the case when the user is not logged in, e.g., redirect to the login page
            return $this->redirectToRoute("app_login");
        }

        $userId = $user->getId();
        $User2 = $userRepository->find($userId);
        // Find the existing reservation by user ID, if any
        $reservation = null;
        if ($userId) {
            $reservation = $reservationService->findReservationByUser($User2);
        }
        if ($reservation === null) {
            $reservation = new Reservation();
            $reservation->setUser($User2);
        }

        switch ($type) {
            case "food":
                $food = $foodRepository->find($id);
                if ($food) {
                    $reservation->addFood($food);
                }
                break;
            case "accommodation":
                $logger->info(
                    "Attempting to remove accommodation with ID: {$id}"
                );

                $accommodation = $accommodationRepository->find($id);
                if ($accommodation) {
                    $logger->info(
                        "Found accommodation: {$accommodation->getName()}"
                    );
                    $reservation->addAccommodation($accommodation);
                    $logger->info("Removed accommodation from reservation");
                    $logger->info("Flushed changes to the database");

                    $this->addFlash("notice", $accommodation->getName());
                } else {
                    $logger->error(
                        "Could not find accommodation with ID: {$id}"
                    );
                }
                break;
            case "activity":
                $activity = $activityRepository->find($id);
                if ($activity) {
                    $reservation->addActivity($activity);
                }
        }
        //dd($reservation);
        $entityManager->persist($reservation);
        $entityManager->flush();
        return $this->redirectToRoute("app_explore");
    }

    #[Route("/cart/remove", name: "cart_remove")]
    public function remove(
        Request $request,
        EntityManagerInterface $em,
        UserRepository $userRepository,
        FoodRepository $foodRepository,
        AccommodationRepository $accommodationRepository,
        ReservationService $reservationService,
        ActivityRepository $activityRepository,
        LoggerInterface $logger
    ): Response {
        $id = $request->query->get("id");
        $type = $request->query->get("type");
        $user = $this->getUser();
        if ($user === null) {
            // handle the case when the user is not logged in, e.g., redirect to the login page
            return $this->redirectToRoute("app_login");
        }

        $userId = $user->getId();
        $User2 = $userRepository->find($userId);
        // Find the existing reservation by user ID, if any
        $reservation = null;
        if ($userId) {
            $reservation = $reservationService->findReservationByUser($User2);
        }
        switch ($type) {
            case "food":
                $food = $foodRepository->find($id);
                if ($food) {
                    $reservation->removeFood($food);
                }
                break;
            case "accommodation":
                $accommodation = $accommodationRepository->find($id);
                if ($accommodation) {
                    $reservation->removeAccommodation($accommodation);
                } else {
                    $logger->error(
                        "Could not find accommodation with ID: {$id}"
                    );
                }
                break;
            case "activity":
                $activity = $activityRepository->find($id);
                if ($activity) {
                    $reservation->removeActivity($activity);
                }
        }
        //dd($reservation);
        $em->persist($reservation);
        $em->flush();

        return $this->redirectToRoute("app_cart");
    }

    #[Route("/cart/approve", name: "cart_approve")]
    public function changeDate(
        Request $request,
        EntityManagerInterface $em,
        UserRepository $userRepository,
        ReservationService $reservationService,
        LoggerInterface $logger
    ): Response {
        $user = $this->getUser();
        if ($user === null) {
            // handle the case when the user is not logged in, e.g., redirect to the login page
            return $this->redirectToRoute("app_login");
        }
        $userId = $user->getId();
        $User2 = $userRepository->find($userId);
        // Find the existing reservation by user ID, if any
        $reservation = null;
        if ($userId) {
            $reservation = $reservationService->findReservationByUser($User2);
        }
        if ($reservation->getStartDate() !== null) {
        }
        //dd($request);
        $startDateValue = $request->request->get("start");
        $endDateValue = $request->request->get("end");
        $reservation->setStartDate(new \DateTime($startDateValue));
        $reservation->setEndDate(new \DateTime($endDateValue));
        //dd($reservation);
        $em->persist($reservation);
        $em->flush();

        return $this->redirectToRoute("app_cart");
    }
}
