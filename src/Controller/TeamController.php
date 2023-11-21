<?php

namespace App\Controller;

use App\Entity\Team;
use App\Repository\TeamRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
class TeamController extends AbstractController
{
    
    public function __construct(private TeamRepository $teamRepository)
    {
        $this->teamRepository = $teamRepository;
    }

    public function __invoke(int $id):JsonResponse
    {
        $team = $this->teamRepository->find($id);

        if (!$team) {
            return $this->json(['message' => 'Team not found'], Response::HTTP_NOT_FOUND);
        }

        $data = [
            'id' => $team->getId(),
            'name' => $team->getName(),
            'logo' => $team->getLogo(),
            'type' => $team->getType(),
        ];

        return $this->json($data);



    }
}
