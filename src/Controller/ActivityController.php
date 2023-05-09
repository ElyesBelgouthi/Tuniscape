<?php

namespace App\Controller;

use App\Entity\Activity;
use App\Form\ActivityType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ActivityController extends AbstractController
{
    #[Route('/activity', 'activity_list_all')]
    public function index(ManagerRegistry $doctrine) : Response{
        if(!$this->isGranted("ROLE_ADMIN")){
            return $this->redirectToRoute('app_home');
        }
        $repository = $doctrine->getRepository(Activity::class);
        $activities = $repository->findAll();
        return $this->render("activity/index.html.twig",[
            'activities' => $activities
        ]);

    }
    #[Route('/activity/edit/{id?0}', name: 'app_activity_edit')]
    public function addActivity(Request $request, EntityManagerInterface $entityManager, Activity $activity = null): Response
    {   if(!$this->isGranted("ROLE_ADMIN")){
        return $this->redirectToRoute('app_home');
    }
        $isAdded = false;

        if(!$activity){
            $activity = new Activity();
            $isAdded = true;
        }

        $form = $this->createForm(ActivityType::class, $activity);
        $form->handleRequest($request);

        if($form->isSubmitted()){
            $entityManager->persist($activity);
            $entityManager->flush();
            if($isAdded){
                $message = "the activity " . $activity->getId() . " : " . $activity->getName() . " has been successfully added!";
            }else{
                $message = "the activity " . $activity->getId() . " : " . $activity->getName() . " has been successfully edited!";

            }
            $this->addFlash("success", $message);
            return $this->redirectToRoute('activity_list_all');
        }

        return $this->render('activity/add.html.twig', [
            'form'=>$form->createView(),
        ]);
    }

    #[Route('/activity/delete/{id}', 'app_activity_delete')]
    public function deleteActivity( EntityManagerInterface $entityManager, Activity $activity = null): RedirectResponse {
        if($activity){
            $entityManager->remove($activity);
            $entityManager->flush();
            $this->addFlash("success", "the activity " . $activity->getName() . " has been successfully deleted!");
        } else {
            $this->addFlash("alert", "the activity does not exist!");
        }
        return $this->redirectToRoute('activity_list_all');



    }

}
