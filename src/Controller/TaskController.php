<?php

namespace App\Controller;

use App\Entity\Task;
use App\Form\TaskType;
use App\Entity\Priority;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TaskController extends AbstractController
{
    #[Route('/task/add', name: 'app_task_add')]
    public function addTask(Request $request, EntityManagerInterface $em): Response
    {
        $task = new Task();

        $defaultPriority = $em->getRepository(Priority::class)->find(2);
        $task->setPriority($defaultPriority);

        $form = $this->createForm(TaskType::class, $task, ['is_edit' => false]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            
            $user = $this->getUser();
            $task->setUserId($user);

            $em->persist($task);
            $em->flush();

            return $this->redirectToRoute("app_home");
        }

        return $this->render('task/index.html.twig', [
            'task' => $task,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/task/edit/{id}', name: 'app_task_edit')]
    public function editTask(Request $request, Task $task, ManagerRegistry $doctrine): Response
    {
        $form = $this->createForm(TaskType::class, $task, ['is_edit' => true]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $doctrine->getManager();
            $em->flush();

            return $this->redirectToRoute('app_home');
        }

        return $this->render('task/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('task/detail/{id}', name: 'app_task_detail')]
    public function detailTask(Task $task): Response
    {
        return $this->render('task/detail.html.twig', [
            'task' => $task
        ]);
    }
}
