<?php

namespace App\Controller;

use App\Entity\Accommodation;
use App\Form\AccommodationType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccommodationController extends AbstractController
{
    #[Route("/accommodation", "accommodation_list_all")]
    public function index(ManagerRegistry $doctrine): Response
    {
        $repository = $doctrine->getRepository(Accommodation::class);
        $accommodations = $repository->findAll();
        return $this->render("accommodation/index.html.twig", [
            "accommodations" => $accommodations,
        ]);
    }

    #[Route("/accommodation/edit/{id?0}", name: "app_accommodation_edit")]
    public function addAccommodation(
        Request $request,
        EntityManagerInterface $entityManager,
        Accommodation $accommodation = null
    ): Response {
        $isAdded = false;

        if (!$accommodation) {
            $accommodation = new Accommodation();
            $isAdded = true;
        }

        $form = $this->createForm(AccommodationType::class, $accommodation);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $entityManager->persist($accommodation);
            $entityManager->flush();
            if ($isAdded) {
                $message =
                    "the accommodation " .
                    $accommodation->getId() .
                    " : " .
                    $accommodation->getName() .
                    " has been successfully added!";
            } else {
                $message =
                    "the accommodation " .
                    $accommodation->getId() .
                    " : " .
                    $accommodation->getName() .
                    " has been successfully edited!";
            }
            $this->addFlash("success", $message);
            return $this->redirectToRoute("accommodation_list_all");
        }

        return $this->render("accommodation/add.html.twig", [
            "form" => $form->createView(),
        ]);
    }

    #[Route("/accommodation/delete/{id}", "app_accommodation_delete")]
    public function deleteAccommodation(
        EntityManagerInterface $entityManager,
        Accommodation $accommodation = null
    ): RedirectResponse {
        if ($accommodation) {
            $entityManager->remove($accommodation);
            $entityManager->flush();
            $this->addFlash(
                "success",
                "the accommodation " .
                $accommodation->getName() .
                " has been successfully deleted!"
            );
        } else {
            $this->addFlash("alert", "the accommodation does not exist!");
        }
        return $this->redirectToRoute("accommodation_list_all");
    }
}
