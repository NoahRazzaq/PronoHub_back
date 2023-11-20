<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{

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
            ->setUsername($data['username'])
            ->setName($data['name'])
            ->setLastname($data['lastname']);

        $hashedPassword = $passwordEncoder->hashPassword($user, $user->getPassword());
        $user->setPassword($hashedPassword);

        $manager->persist($user);
        $manager->flush();

        return $this->json(['message' => 'User created successfully'], Response::HTTP_CREATED);
    }
}
