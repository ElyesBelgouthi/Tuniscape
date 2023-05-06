<?php

namespace App\Controller;

use App\Entity\Food;
use App\Form\FoodType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FoodController extends AbstractController
{
    #[Route('/food', 'food_list_all')]
    public function index(ManagerRegistry $doctrine) : Response{
        $repository = $doctrine->getRepository(Food::class);
        $foods = $repository->findAll();
        return $this->render("food/index.html.twig",[
            'foods' => $foods
        ]);

    }
    #[Route('/food/edit/{id?0}', name: 'app_food_edit')]
    public function addActivity(Request $request, EntityManagerInterface $entityManager, Food $food = null): Response
    {   $isAdded = false;

        if(!$food){
            $food = new Food();
            $isAdded = true;
        }

        $form = $this->createForm(FoodType::class, $food);
        $form->handleRequest($request);

        if($form->isSubmitted()){
            $entityManager->persist($food);
            $entityManager->flush();
            if($isAdded){
                $message = "the dish " . $food->getId() . " : " . $food->getName() . " has been successfully added!";
            }else{
                $message = "the dish " . $food->getId() . " : " . $food->getName() . " has been successfully edited!";

            }
            $this->addFlash("success", $message);
            return $this->redirectToRoute('food_list_all');
        }

        return $this->render('food/add.html.twig', [
            'form'=>$form->createView(),
        ]);
    }

    #[Route('/food/delete/{id}', 'app_food_delete')]
    public function deleteActivity( EntityManagerInterface $entityManager, Food $food = null): RedirectResponse {
        if($food){
            $entityManager->remove($food);
            $entityManager->flush();
            $this->addFlash("success", "the dish " . $food->getName() . " has been successfully deleted!");
        } else {
            $this->addFlash("alert", "the food does not exist!");
        }
        return $this->redirectToRoute('food_list_all');



    }
}
