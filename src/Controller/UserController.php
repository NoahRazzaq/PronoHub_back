<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Bet;
use App\Entity\Game;
use App\Entity\Team;    
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Serializer\SerializerInterface;

#[AsController]
class UserController extends AbstractController
{

    public function __construct(
        private UserRepository $userRepository,
        private SerializerInterface $serializer
    ) {}

    #[Route("/history/{userId}", name: 'history', methods: ['GET'])]
    public function GetUsersBets(int $userId): JsonResponse
    {
        $betHistory = $this->userRepository->findBetsByUserId($userId);

        if (!$betHistory) {
            return $this->json(['message' => 'User not found'], Response::HTTP_NOT_FOUND);
        }

        $formattedBetHistory = [];

        foreach ($betHistory as $bet) {
            $formattedBetHistory[] = [
                'Id' => $bet->getId(),
                'Status' => $bet->getStatus(),
                'id match' => $bet->getGame()->getId(),
                'Team parié' => $bet->getTeam()->getName(),
                'Nom team 1' => $bet->getGame()->getTeamId1()->getName(),
                'Nom team 2' => $bet->getGame()->getTeamId2()->getName(),
                'Score 1' => $bet->getGame()->getScore1(),
                'Score 2' => $bet->getGame()->getScore2(),
                'Date match ' => $bet->getGame()->getDateMatch(),
            ];
        }

        return new JsonResponse($formattedBetHistory, Response::HTTP_OK);
    }

    #[Route('/score/{userId}', name: 'score', methods: ['GET'])]
    public function getUserScore(int $userId, UserRepository $userRepository): JsonResponse
    {
        $score = $userRepository->countValidBetsByUserId($userId);

        return new JsonResponse(['score' => $score]);
    }

    #[Route("/register", name: 'create_user', methods: ['POST'])]
    public function create(
        Request $request,
        UserPasswordHasherInterface $passwordEncoder,
        EntityManagerInterface $manager
    ): Response {
        $data = json_decode($request->getContent(), true);

        $user = new User();
        $user->setEmail($data['email'])
            ->setPassword($data['password'])
            ->setName($data['name'])
            ->setLastname($data['lastname']);

        $hashedPassword = $passwordEncoder->hashPassword($user, $user->getPassword());
        $user->setPassword($hashedPassword);

        $manager->persist($user);
        $manager->flush();

        return $this->json(['email' => $user->getEmail(), 'message' => 'User created successfully'], Response::HTTP_CREATED);
    }

}
