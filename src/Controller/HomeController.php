<?php

namespace App\Controller;

use App\Entity\Task;
use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $repository = $doctrine->getRepository(Task::class);

        $pendingTasks = $repository->findBy(['status' => 1]);
        $inProgressTasks = $repository->findBy(['status' => 2]);

        return $this->render('home/index.html.twig', [
            'pendingTasks' => $pendingTasks,
            'inProgressTasks' => $inProgressTasks,
        ]);
    }
}
