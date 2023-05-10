<?php

namespace App\Controller;

use App\Entity\Accommodation;
use App\Entity\Activity;
use App\Entity\Food;
use App\Form\RegionFormType;
use App\Form\RegionType;
use App\Repository\AccommodationRepository;
use App\Repository\RegionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CatalogController extends AbstractController
{
    #[Route('/catalog/{entityName}/{page?1}', name: 'app_catalog')]
    public function index(Request $request, RegionRepository $regionRepository, EntityManagerInterface $entityManager, string $entityName = null, int $page): Response
    {
        $region = null;
        $nb = 8;
        $cards = null;
        $repository = null;
        $size = null;
        $folderName = null;
        $regionForm = null;
        switch ($entityName) {
            case 'accommodation':
                $repository = $entityManager->getRepository(Accommodation::class);
                break;
            case 'food':
                $repository = $entityManager->getRepository(Food::class);
                break;
            case 'activity':
                $repository = $entityManager->getRepository(Activity::class);
                break;
            default:
                return $this->redirectToRoute("app_home");
        }

        if ($entityName === 'accommodation' || $entityName === 'activity') {
            $regionForm = $this->createForm(RegionFormType::class, $region);
            $regionForm->handleRequest($request);

            if ($regionForm->isSubmitted() && $regionForm->isValid()) {
                $region = $regionForm->get('region')->getData();
            }
        }

        if ($region) {
            $cards = $repository->findBy(['region' => $region], [], $nb, ($page - 1) * $nb);
            $size = sizeof($repository->findBy(['region' => $region]));
        } else {
            $cards = $repository->findBy([], [], $nb, ($page - 1) * $nb);
            $size = sizeof($repository->findAll());
        }


        switch ($entityName) {
            case 'accommodation':
                $folderName = "uploads/accommodations/";
                break;
            case 'food':
                $folderName = "uploads/foods/";
                break;
            case 'activity':
                $folderName = "uploads/activities/";
                break;
        }

        $properties = [
            'cards' => $cards,
            'page' => $page,
            'name' => $entityName,
            'max' => ceil($size / $nb),
            'folderName' => $folderName
        ];

        if($entityName !== 'food'){
            $properties['regionForm'] = $regionForm;

        }
        return $this->render('catalog/index.html.twig', $properties);
    }
}
