<?php

namespace App\Controller;

use App\Entity\Accommodation;
use App\Form\AccommodationType;
use App\Repository\AccommodationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/accommodation')]
class AccommodationController extends AbstractController
{
    #[Route('/', name: 'app_accommodation_index', methods: ['GET'])]
    public function index(AccommodationRepository $accommodationRepository): Response
    {
        return $this->render('accommodation/index.html.twig', [
            'accommodations' => $accommodationRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_accommodation_new', methods: ['GET', 'POST'])]
    public function new(Request $request, AccommodationRepository $accommodationRepository): Response
    {
        $accommodation = new Accommodation();
        $form = $this->createForm(AccommodationType::class, $accommodation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $accommodationRepository->save($accommodation, true);

            return $this->redirectToRoute('app_accommodation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('accommodation/new.html.twig', [
            'accommodation' => $accommodation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_accommodation_show', methods: ['GET'])]
    public function show(Accommodation $accommodation): Response
    {
        return $this->render('accommodation/show.html.twig', [
            'accommodation' => $accommodation,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_accommodation_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Accommodation $accommodation, AccommodationRepository $accommodationRepository): Response
    {
        $form = $this->createForm(AccommodationType::class, $accommodation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $accommodationRepository->save($accommodation, true);

            return $this->redirectToRoute('app_accommodation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('accommodation/edit.html.twig', [
            'accommodation' => $accommodation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_accommodation_delete', methods: ['POST'])]
    public function delete(Request $request, Accommodation $accommodation, AccommodationRepository $accommodationRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$accommodation->getId(), $request->request->get('_token'))) {
            $accommodationRepository->remove($accommodation, true);
        }

        return $this->redirectToRoute('app_accommodation_index', [], Response::HTTP_SEE_OTHER);
    }
}
