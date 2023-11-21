<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class BetController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/bet', name: 'app_bet')]
    public function index(): Response
    {
        return $this->render('bet/index.html.twig', [
            'controller_name' => 'BetController',
        ]);
    }

    #[Route('/bets/history/{userId}', name: 'app_bet_history', methods: ['GET'])]
    public function getHistory(int $userId): string//Response
    {
        $user = $this->entityManager->getRepository(User::class)->find($userId);

        $bets = $user->getBet();

        return 'test'/*$bets*/;
    }
}
