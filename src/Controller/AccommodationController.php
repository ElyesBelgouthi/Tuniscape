<?php

namespace App\Controller;

use App\Entity\Accommodation;
use App\Form\AccommodationType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccommodationController extends AbstractController
{   #[Route('/accommodation', 'accommodation_list_all')]
    public function index(ManagerRegistry $doctrine){
        $repository = $doctrine->getRepository(Accommodation::class);
        $accommodations = $repository->findAll();
        return $this->render("accommodation/index.html.twig",[
            'accommodations' => $accommodations
        ]);

    }
    #[Route('/accommodation/add', name: 'app_accommodation_add')]
    public function addAccommodation(Request $request, EntityManagerInterface $entityManager): Response
    {   $accommodation = new Accommodation();
        $form = $this->createForm(AccommodationType::class, $accommodation);
        $form->handleRequest($request);
        if($form->isSubmitted()){
            $entityManager->persist($accommodation);
            $entityManager->flush();
            return $this->redirectToRoute('app_accommodation_success', [
                'id'=>$accommodation->getId(),
            ]);
        }

        return $this->render('accommodation/add.html.twig', [
            'form'=>$form->createView(),
        ]);
    }

    #[Route('/accommodation/{id}', name: 'app_accommodation_success')]
    public function success(Accommodation $accommodation){
        return $this->render("accommodation/success.html.twig",[
            'accommodation'=>$accommodation,
        ]);

    }
}
