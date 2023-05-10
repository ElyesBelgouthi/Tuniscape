<?php

namespace App\Controller;

use App\Entity\Accommodation;
use App\Entity\Activity;
use App\Entity\Food;
use App\Repository\AccommodationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CatalogController extends AbstractController
{
    #[Route('/catalog/{entityName}/{page?1}', name: 'app_catalog')]
    public function index(EntityManagerInterface $entityManager,string $entityName = null, int $page ): Response
    {   $nb = 8;
        $cards=null;
        $repository=null;
        $size = null;
        $folderName = null;
        switch($entityName){
            case 'accommodation':
                $repository = $entityManager->getRepository(Accommodation::class);
                $cards=$repository->findBy([],[],$nb,($page-1)*$nb);
                $size = sizeof($repository->findAll());
                $folderName = "uploads/accommodations/";


                break;
            case 'food':
                $repository = $entityManager->getRepository(Food::class);
                $cards=$repository->findBy([],[],$nb,($page-1)*$nb);
                $size = sizeof($repository->findAll());
                $folderName = "uploads/foods/";

                break;
            case 'activity':
                $repository = $entityManager->getRepository(Activity::class);
                $cards=$repository->findBy([],[],$nb,($page-1)*$nb);
                $size = sizeof($repository->findAll());
                $folderName = "uploads/activities/";

                break;


        }


        if($entityName == 'accommodation' or $entityName == 'food' or $entityName == 'activity'){
        return $this->render('catalog/index.html.twig', [
            'cards'=>$cards,
            'page'=>$page,
            'name'=>$entityName,
            'max'=> ceil($size / $nb),
            'folderName'=> $folderName
        ]);} else {
            return $this->redirectToRoute("app_home");
        }
    }
}
