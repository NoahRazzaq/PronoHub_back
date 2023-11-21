<?php

namespace App\Controller;

use App\Repository\GameRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

#[AsController]
class GameController extends AbstractController
{
    public function __construct(
        private GameRepository $gameRepository,
        private SerializerInterface $serializer
    ) {}

    public function __invoke(int $id): JsonResponse
    {
        $game = $this->gameRepository->find($id);

        if (!$game) {
            return $this->json(['message' => 'Game not found'], 404);
        }

        $data = $this->serializeGame($game);

        return $this->json($data);
    }

    private function serializeGame($game): array
    {
        $context = [
            AbstractNormalizer::GROUPS => ['game:read:all'],
        ];

        $data = $this->serializer->normalize($game, null, $context);

        return $data;
    }
}
