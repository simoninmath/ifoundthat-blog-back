<?php

// namespace App\Controller;

// use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
// use Symfony\Component\HttpFoundation\JsonResponse;
// use Symfony\Component\Routing\Annotation\Route;
// use App\Entity\User;
// use Symfony\Component\HttpFoundation\Request;

// class ApiController extends AbstractController
// {

//     #[Route('api/users', name:'api_users_list', methods: ['GET'])]
//     public function getUsers(Request $request): JsonResponse
//     {
//         $userRepository = $request->get(User::class);
//         $users = $userRepository->findAll();

//         $formattedUsers = [];
//         foreach ($users as $user) {
//             $formattedUsers[] = [
//                 'email' => $user->getEmail(),
//                 'role' => $user->getRole(),
//                 'createdAt' => $user->getCreatedAt()->format('Y-m-d H:i:s')
//             ];
//         }

//         return $this->json($formattedUsers);
//     }
// }

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;

class ApiController extends AbstractController
{
    private $doctrine;

    public function __construct(ManagerRegistry $doctrine){
        $this->doctrine = $doctrine;
    }

    #[Route('/api/users', name: 'api_users_list', methods: ['GET'])]
    public function getUsers(): JsonResponse
    {
        $entityManager = $this->doctrine;
        
        $userRepository = $entityManager->getRepository(User::class);
        
        $users = $userRepository->findAll();

        $formattedUsers = [];
        foreach ($users as $user) {
            $formattedUsers[] = [
                'email' => $user->getEmail(),
                'role' => $user->getRole(),
                'createdAt' => $user->getCreatedAt()->format('Y-m-d H:i:s')
            ];
        }

        return $this->json($formattedUsers);
    }
}