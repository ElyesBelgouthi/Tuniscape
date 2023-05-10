<?php

namespace App\Controller;

use App\Repository\AccommodationRepository;
use App\Repository\ActivityRepository;
use App\Repository\FoodRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DetailsController extends AbstractController
{
    #[Route('/details', name: 'app_details')]
    public function index(
        Request $request,
        AccommodationRepository $accommodationRepository,
        FoodRepository $foodRepository,
        ActivityRepository $activityRepository
    ): Response
    {
        $id = $request->query->get("id");
        $type = $request->query->get("type");
        $name = null;
        $description = null;
        $region = null;
        $image = null;
        $folderName = null;
        $typeAccommodation=null;
        $latitude=null;
        $longitude=null;
        switch ($type){
            case 'food':
                $name = $foodRepository->find($id)->getName();
                $description = $foodRepository->find($id)->getDescription();
                $image = $foodRepository->find($id)->getImage();
                $folderName = "uploads/foods/";
                break;
            case 'accommodation':
                $name = $accommodationRepository->find($id)->getName();
                $description = $accommodationRepository->find($id)->getDescription();
                $image = $accommodationRepository->find($id)->getImage();
                $typeAccommodation=$accommodationRepository->find($id)->getType();
                $latitude=$accommodationRepository->find($id)->getLatitude();
                $longitude=$accommodationRepository->find($id)->getLongitude();
                $folderName = "uploads/accommodations/";
                break;
            case 'activity':
                $name=$activityRepository->find($id)->getName();
                $image = $activityRepository->find($id)->getImage();
                $region=$activityRepository->find($id)->getRegion()->getName();
                $description=$activityRepository->find($id)->getDescription();
                $latitude=$activityRepository->find($id)->getLatitude();
                $longitude=$activityRepository->find($id)->getLongitude();
                $folderName = "uploads/activities/";

        }

        return $this->render('details/index.html.twig', [
            'id'=>$id,
            'type'=>$type,
            'name' => $name,
            'image' => $image,
            'folderName' => $folderName,
            'description' => $description,
            'region' => $region,
            'typeAccommodation'=>$typeAccommodation,
            'latitude'=>$latitude,
            'longitude'=>$longitude,
        ]);
    }
}
