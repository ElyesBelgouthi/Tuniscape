<?php
namespace App\Service;

use App\Entity\Reservation;
use App\Entity\Food;
use App\Entity\Activity;
use App\Entity\User;

use App\Entity\Accommodation;
use Doctrine\ORM\EntityManagerInterface;

class ReservationService
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    public function findReservationByUserId(int $userId): ?Reservation
    {
        return $this->em->getRepository(Reservation::class)->findOneBy(['user' => $userId]);
    }

    public function addFoodToReservation(?Reservation $reservation, Food $food): Reservation
    {
        if (!$reservation) {
            $reservation = new Reservation();
        }

        $reservation->addFood($food);
        $food->addReservation($reservation);
        $this->em->persist($reservation);
        $this->em->flush();

        return $reservation;
    }

    public function addActivityToReservation(?Reservation $reservation, Activity $activity): Reservation
    {
        if (!$reservation) {
            $reservation = new Reservation();
        }

        $reservation->addActivity($activity);
        $activity->addReservation($reservation);
        $this->em->persist($reservation);
        $this->em->flush();

        return $reservation;
    }

    public function addAccommodationToReservation(?Reservation $reservation, Accommodation $accommodation): Reservation
    {
        if (!$reservation) {
            $reservation = new Reservation();
        }

        $reservation->addAccommodation($accommodation);
        $accommodation->addReservation($reservation);
        $this->em->persist($reservation);
        $this->em->flush();

        return $reservation;
    }

    public function createOrUpdateReservation(
        int $userId,
        \DateTimeInterface $startDate,
        \DateTimeInterface $endDate,
        int $status,
        ?Reservation $reservation = null
    ): Reservation {
        if (!$reservation) {
            $reservation = new Reservation();
            $user = $this->em->getRepository(User::class)->find($userId);
            if (!$user) {
                throw new \Exception('User not found');
            }

            $reservation->setUser($user);
        }




        $reservation->setStartDate($startDate);
        $reservation->setEndDate($endDate);
        $reservation->setStatus($status);

        $this->em->persist($reservation);
        $this->em->flush();

        return $reservation;
    }

}