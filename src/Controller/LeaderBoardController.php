<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LeaderBoardController extends AbstractController
{
    #[Route('/leader/board', name: 'app_leader_board')]
    public function index(): Response
    {
        return $this->render('leader_board/index.html.twig', [
            'controller_name' => 'LeaderBoardController',
        ]);
    }
}
