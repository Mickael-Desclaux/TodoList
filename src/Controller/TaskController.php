<?php

namespace App\Controller;

use App\Entity\Task;
use App\Form\TaskType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TaskController extends AbstractController
{
    #[Route('/task/add', name: 'app_task_add')]
    public function addTask(Request $request, ManagerRegistry $doctrine): Response
    {
        $task = new Task();
        $form = $this->createForm(TaskType::class, $task, ['is_edit' => false]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser();
            $task->setUserId($user);

            $em = $doctrine->getManager();
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
